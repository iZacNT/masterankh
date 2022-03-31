<?php

namespace frontend\models;

use frontend\helpers\EmailHelper;
use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $website;
    public $message;
    public $send_copy_to_yourself;
    public $captcha;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['name', 'email', 'message'], 'required'],
            [['name', 'phone', 'website', 'message'], 'string'],
            ['send_copy_to_yourself', 'boolean'],
            ['phone', 'match', 'pattern' => '/^\+?[0-9]+$/'],
            ['email', 'email'],
            ['captcha', ReCaptchaValidator2::class],
        ];
        if (!Yii::$app->request->isAjax) {
            $rules[] = ['captcha', ReCaptchaValidator2::class];
        }
        return $rules;
    }

    /**
     * Send email.
     * @return bool
     */
    public function run(): bool
    {
        if ($this->send_copy_to_yourself) {
            if (!EmailHelper::contactForm($this, $this->email)) {
                $this->addError('email', "Can't send message to your email");
                return false;
            }
        }
        $result = EmailHelper::contactForm($this, Yii::$app->params['email']['info']);
        if (!$result) {
            $this->addError('email', "Can't send message");
        }
        return $result;
    }
}
