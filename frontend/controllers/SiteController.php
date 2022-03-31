<?php

namespace frontend\controllers;

use app\modules\admin\services\PaymentService;
use frontend\models\Payment;
use frontend\helpers\EmailHelper;
use frontend\models\ContactForm;
use frontend\models\Job;
use frontend\models\Login;
use frontend\models\Plan;
use frontend\models\Register;
use frontend\models\User;
use Yii;
use yii\base\BaseObject;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\components\AuthHandler;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout = 'narrow';

    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['login', 'register', 'verify-email'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    return $this->redirect(Url::toRoute(['/admin/main/dashboard']));
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
        return $this->redirect('/site/login');
    }

    /**
     * Main page.
     * @return string
     * @todo: create and use "index" layout instead of "false"
     */
    public function actionIndex()
    {
        $this->layout = false;
        return $this->render('index');
    }

    /**
     * Logout page.
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->session->regenerateID(true);
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout(true);
        }
        return $this->redirect(Url::home());
    }

    /**
     * Login page.
     * @return array|string|Response
     */
    public function actionLogin()
    {
        $login = new Login;
        $load = $login->load(Yii::$app->request->post());

        // AJAX validation
        if ($load && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($login);
        }

        if ($load && $login->validate()) {
            $user = $login->getUser();
            Yii::$app->user->login($user, 3600 * 24 * 7);
            $user->ip_last_login = Yii::$app->request->userIP;
            $user->save(true, ['ip_last_login']);
            return $this->refresh();
        }

        return $this->render('login', [
            'login' => $login,
        ]);
    }

    /**
     * Register page.
     * @return array|string
     */
    public function actionRegister()
    {
        $model = new Register;
        $load = $model->load(Yii::$app->request->post());

        // AJAX validation
        if ($load && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($load && $model->validate()) {

            $model->password = Yii::$app->security->generatePasswordHash($model->password);

            $user = new User([
                'email' => $model->email,
                'second_email' => $model->email,
                'password' => $model->password,
                'name' => $model->name,
                'surname' => $model->surname,
            ]);

            if ($user->save()) {
                $code = Yii::$app->security->encryptByPassword($user->email, Yii::$app->request->cookieValidationKey);
                EmailHelper::register($user, $code);
                return $this->render('check-email');
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * New accout verification page.
     * @param string $code - verification code
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($code)
    {
        $email = Yii::$app->security->decryptByPassword($code, Yii::$app->request->cookieValidationKey);

        if (!$email) {
            throw new BadRequestHttpException('Expired registration code');
        }

        $user = User::find()
            ->where(['email' => $email])
            ->one(); /* @var User $user */

        if (!$user) {
            throw new BadRequestHttpException('User not found');
        }

        $user->status = User::STATUS_CONFIRMED;
        if ($user->save()) {
            Yii::$app->user->login($user);
        }

        return $this->redirect(['/admin/main']);
    }

    /**
     * Terms and conditions page.
     * @return string
     */
    public function actionTermsAndConditions()
    {
        $this->layout = false;
        return $this->render('terms-and-conditions');
    }

    /**
     * Privacy policy page.
     * @return string
     */
    public function actionPrivacyPolicy()
    {
        $this->layout = false;
        return $this->render('privacy-policy');
    }

    /**
     * Contact form page.
     * @return string|Response
     */
    public function actionContactForm()
    {
        $model = new ContactForm;
        $load = $model->load(Yii::$app->request->post());

        if ($load && $model->validate() && $model->run()) {
            return $this->redirect(Url::home());
        }

        return $this->render('contact-form', [
            'model' => $model,
        ]);
    }

    /**
     * Php info.
     */
    public function actionPhpinfo()
    {
        phpinfo();
    }

    public function actionTest()
    {
        $jobs = Job::find()->all();
        foreach ($jobs as $job) {
            if (!$job->user) {
                p($job, 0);
            }
        }
        echo 'success';
    }
    public function beforeAction($action)
    {
        if (property_exists($action, 'actionMethod') && $action->actionMethod === 'actionIpnHandler') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * handler validate the transaction subscription payment IPN.
     */
    public function actionIpnHandler()
    {
        //$urlIPN = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
        $urlIPN = 'https://ipnpb.paypal.com/cgi-bin/webscr';

        if (!count($_POST)) {
            throw new \Exception("Missing POST Data");
        }

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        foreach ($myPost as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }

        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($urlIPN);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . "/cacert.pem");
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: PHP-IPN-Verification-Script',
            'Connection: Close',
        ));
        $res = curl_exec($ch);

        if ( ! ($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new \Exception("cURL error: [$errno] $errstr");
        }

        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];
        if ($http_code != 200) {
            throw new \Exception("PayPal responded with http code $http_code");
        }

        curl_close($ch);

        // Check if PayPal verifies the IPN data, and if so, return true.
        if ($res == 'VERIFIED') {
            $this->saveDataPayment();
            return true;
        } else {
            return false;
        }
    }
    private function saveDataPayment()
    {
        $paypalInfo = $_POST;
        $txn_type = $paypalInfo['txn_type'];

        //file_put_contents('log_payment.txt', json_encode($paypalInfo) . PHP_EOL, FILE_APPEND);
        if ($txn_type === 'subscr_signup') {
            $subscr_id = $paypalInfo['subscr_id'];
            $payer_email = $paypalInfo['payer_email'];
            $subscr_date = $paypalInfo['subscr_date'];
            $custom = $paypalInfo['custom'];
            $mc_amount3 = $paypalInfo['mc_amount3'];
            $recur_times = $paypalInfo['recur_times'];
            $dt = new \DateTime($subscr_date);
            $subscr_date = $dt->format("Y-m-d H:i:s");
            $subscr_date_valid_to = date("Y-m-d H:i:s", strtotime(" + $recur_times month", strtotime($subscr_date)));
            $subscription = new Payment();
            $dataCustom = PaymentService::decryptCustom($custom);
            $plan = Plan::findOne($dataCustom['plan_id']);

            $data = [
                'user_id'        => $dataCustom['user_id'],
                'quantity'       => $dataCustom['quantity'] * ($plan ? $plan->target_limit : 0),
                'plan_id'        => $dataCustom['plan_id'],
                'valid_from'     => $subscr_date,
                'valid_to'       => $subscr_date_valid_to,
                'payment_gross'  => $mc_amount3,
                'subscr_id'      => $subscr_id,
                'txn_id'         => '0',
                'payment_status' => Payment::SUBSCRIBED,
                'payer_email'    => $payer_email,
            ];
            //file_put_contents('log_payment.txt', json_encode($data) . PHP_EOL, FILE_APPEND);
            $subscription->load($data, '');
            $subscription->save();
        }
        if ($txn_type === 'subscr_payment') {
            $subscr_id = $paypalInfo['subscr_id'];
            $payer_email = $paypalInfo['payer_email'];
            $txn_id = !empty($paypalInfo['txn_id']) ? $paypalInfo['txn_id'] : '';
            $payment_gross = !empty($paypalInfo['mc_gross']) ? $paypalInfo['mc_gross'] : 0;
            $payment_status = !empty($paypalInfo['payment_status']) ? $paypalInfo['payment_status'] : '';
            $custom = $paypalInfo['custom'];
            if (!empty($txn_id) && Payment::findOne(['txn_id' => $txn_id])) {
                return;
            }
            $subscription = Payment::findOne(['subscr_id' => $subscr_id]);
            if (!$subscription) {
                return;
            }
            $dataCustom = PaymentService::decryptCustom($custom);
            if (empty($dataCustom)) {
                throw new BadRequestHttpException('Bad verification code');
            }
            $plan = Plan::findOne($dataCustom['plan_id']);
            $data = [
                'user_id'        => $dataCustom['user_id'],
                'quantity'       => $dataCustom['quantity'] * ($plan ? $plan->target_limit : 0),
                'plan_id'        => $dataCustom['plan_id'],
                'txn_id'         => $txn_id,
                'payment_gross'  => $payment_gross,
                'payment_status' => $payment_status,
                'payer_email'    => $payer_email,
            ];
            $subscription->load($data, '');
            $subscription->save();
        }
        if ($txn_type === 'subscr_cancel') {
            $subscr_id = $paypalInfo['subscr_id'];
            $subscription = Payment::findOne(['subscr_id' => $subscr_id]);
            if (!$subscription) {
                return;
            }
            $subscr_date = $paypalInfo['subscr_date'];
            $dt = new \DateTime($subscr_date);
            $subscr_date = $dt->format("Y-m-d H:i:s");
            $data = [
                'payment_status' => Payment::CANCELED,
                'valid_to'       => $subscr_date,
            ];
            $subscription->load($data, '');
            $subscription->save();
        }
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
