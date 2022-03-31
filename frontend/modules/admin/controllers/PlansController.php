<?php

namespace frontend\modules\admin\controllers;

use app\modules\admin\repositories\PaymentRepository;
use app\modules\admin\services\PaymentService;
use frontend\helpers\EmailHelper;
use frontend\models\Payment;
use frontend\models\Plan;
use frontend\modules\admin\components\Controller;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class PlansController extends Controller
{
    /**
     * You can change this password at any time.
     */
    const PASSWORD = 'putin_vypei_chau';

    private $paymentService;

    public function __construct($id, $module, PaymentService $paymentService, $config = [])
    {
        $this->paymentService = $paymentService;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $result = parent::behaviors();
        $result['access']['rules'][] = [
            'allow' => true,
            'actions' => ['response'],
        ];
        return $result;
    }

    /**
     * Plans list.
     * @return string
     */
    public function actionIndex()
    {
        $paymentParams = [];
        $paymentParams['cmd'] = '_xclick-subscriptions';
        $paymentParams['business'] = Yii::$app->params['email']['paypal'];
        $paymentParams['return'] = Url::to(['payment-success'], true);
        //Set recurring payments until canceled.
        $paymentParams['src'] = "1";
        $paymentParams['notify_url'] = 'https://www.genieping.com/en/site/ipn-handler';
        $paymentParams['currency_code'] = 'GBP';
        $paymentParams['lc'] = 'US';
        //$paymentParams['p3'] = '1';
        $paymentParams['srt'] = '24';
        $paymentParams['t3'] = 'D';
        return $this->render('index', ['paymentParams' => $paymentParams]);
    }
    public function actionGenerateCustom()
    {

        $quantity = (int)Yii::$app->request->post('quantity', 1);
        $planId = (int)Yii::$app->request->post('id', 2);
        $plan = Plan::getById($planId);
        $now =  new \DateTime();
        $customParams = [
            'timeStamp' =>  $now->getTimestamp(),
            'expiredTime' => $now->modify("+ 7 second")->getTimestamp()
        ];
        Yii::$app->session->set(Plan::SESSION_PAYMENT, $customParams);
        if ($plan->isFree()) {
            throw new BadRequestHttpException('Plan is not exists');
        }
        return json_encode([
            'custom' => $this->paymentService->encrypt([
                'plan_id' => $plan->id,
                'user_id' => Yii::$app->user->id,
                'quantity' => $quantity,
            ]),
            'price' => number_format($quantity * $plan->price, 2)
        ]);
    }

    /**
     * Get payment response from PayPal.
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionResponse()
    {
        $status = Yii::$app->request->post('payment_status');
        $custom = Yii::$app->request->post('custom', '');
        $data = $this->paymentService->decrypt($custom);
        if (!in_array($status, ['Completed', 'Pending'])) {
            return $this->redirect(['/admin/plans']);
        }
        if (empty($data)) {
            throw new BadRequestHttpException('Bad verification code');
        }

        $payment = new Payment;
        $payment->setAttributes($data);

        $oldPayment = $this->paymentService->getOneByUserId(Yii::$app->user->id);
        if ($oldPayment) {
            $oldPayment->quantity = $payment->quantity + $oldPayment->quantity;
            $oldPayment->date_create = strtotime('now');
            $statusSave = $this->paymentService->save($oldPayment);
        } else {
            $statusSave = $this->paymentService->save($payment);
        }

        if ($statusSave) {
            EmailHelper::invoice($payment);
        }
        return $this->redirect(['/admin/plans']);
    }

    /**
     * Request to PayPal through redirect.
     * @param int $id - plan ID
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionRequest($id)
    {
        $plan = Plan::getById($id);
        if ($plan->isFree()) {
            throw new BadRequestHttpException('Plan is not exists');
        }

        $quantity = (int)Yii::$app->request->get('quantity', 1);
        $quantity = $quantity < 1 ? 1 : $quantity;
        $params = $this->paymentService->getRequestParams($quantity, $plan);

        $url = 'https://www.paypal.com/cgi-bin/webscr?' . http_build_query($params);
        return $this->redirect($url);
    }

    /**
     * Payment success page.
     * @return string
     */
    public function actionPaymentSuccess()
    {
        $this->paymentService->checkPaymentFromSession();
        return $this->render('payment-success', [
            'delay' => 5, // redirect after ... seconds
        ]);
    }
}
