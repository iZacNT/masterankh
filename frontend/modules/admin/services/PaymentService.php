<?php


namespace app\modules\admin\services;

use app\modules\admin\repositories\PaymentRepository;
use app\modules\admin\repositories\PlanRepository;
use frontend\helpers\EmailHelper;
use frontend\models\Payment;
use frontend\models\Plan;
use Yii;
use yii\helpers\Url;

class PaymentService
{
    const SESSION_KEY = 'dRwpQYuaNmSHA23_@poFs';

    private $paymentRepository;
    private $planRepository;

    public function __construct(PaymentRepository $paymentRepository, PlanRepository $planRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->planRepository = $planRepository;
    }

    public function clearSessionData()
    {
        Yii::$app->session->remove(self::SESSION_KEY);
    }

    public function getOneByUserId($userId)
    {
        return $this->paymentRepository->getOneByUserId($userId);
    }

    public function save($model)
    {
        return $this->paymentRepository->save($model);
    }

    public function checkPaymentFromSession()
    {
        $sessionData = Yii::$app->session->get(self::SESSION_KEY);
        if (!empty($sessionData)) {
            $arrayData = $this->decrypt($sessionData);
            if (isset($arrayData['user_id'])) {
                $payment = $this->paymentRepository->getOneByUserId($arrayData['user_id']);
                $plan = $this->planRepository->getOneById($arrayData['plan_id']);
                $pinTargets = $plan ? $plan->target_limit : 1;
                if (!$payment) {
                    $payment = new Payment();
                }
                $payment->user_id = Yii::$app->user->id;
                $payment->quantity = $payment->quantity + ($pinTargets * $arrayData['quantity']);
                $payment->date_create = strtotime('now');
                $payment->plan_id = $arrayData['plan_id'];
                if ($payment->save()) {
                    $this->clearSessionData();
                    EmailHelper::invoice($payment);
                }
            }
        }
    }

    public function encrypt(array $data): string
    {
        $str = json_encode($data);
        $encrypted = Yii::$app->security->encryptByPassword($str, self::SESSION_KEY);
        return base64_encode($encrypted);
    }

    public function decrypt(string $str): array
    {
        $str = base64_decode($str);
        $str = Yii::$app->security->decryptByPassword($str, self::SESSION_KEY);
        return (array)json_decode($str, true);
    }

    public static function decryptCustom(string $str): array
    {
        $str = base64_decode($str);
        $str = Yii::$app->security->decryptByPassword($str, self::SESSION_KEY);
        return (array)json_decode($str, true);
    }

    public function getRequestParams(int $quantity, Plan $plan): array
    {
        $customParams = $this->encrypt([
            'plan_id' => $plan->id,
            'user_id' => Yii::$app->user->id,
            'quantity' => $quantity,
        ]);
        Yii::$app->session->set(self::SESSION_KEY, $customParams);
        $params['quantity'] = $quantity;
        $params['cmd'] = '_xclick';
        $params['business'] = Yii::$app->params['email']['paypal'];
        $params['item_name'] = $plan->fullName();
        $params['amount'] = $plan->price;
        $params['no_shipping'] = 1;
        $params['return'] = Url::to(['payment-success'], true);
        $params['rm'] = 2;
        $params['custom'] = $customParams;
        $params['currency_code'] = 'GBP';
        $params['lc'] = 'US';
        $params['bn'] = 'PP-BuyNowBF';
        return $params;
    }

    public function addFreePlanIfLoggedNewUser()
    {
        $payment = $this->paymentRepository->getOneByUserId(Yii::$app->user->id);
        if (!$payment) {
            $payment = new Payment([
                'user_id' => Yii::$app->user->id,
                'quantity' => 1,
                'plan_id' => Plan::FREE,
                'date_create' => strtotime('+ 24 hours')
            ]);
            $this->paymentRepository->save($payment);
        }
    }
}
