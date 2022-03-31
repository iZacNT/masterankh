<?php

namespace frontend\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use Yii;
use yii\base\Model;

class Login extends Model
{
    /**
     * User's email.
     * @var string
     */
    public $email;

    /**
     * User's password.
     * @var string
     */
    public $password;

    /**
     * Remember me - checkbox.
     * @var bool
     */
    public $remember_me = true;

    /**
     * ReCaptcha.
     * @var string
     */
    public $captcha;

    /**
     * @var User
     */
    public $user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['email' => 'email'], 'message' => 'User not found'],
            ['password', 'validatePassword'],
            ['remember_me', 'boolean'],
        ];
        if (!Yii::$app->request->isAjax) {
            $rules[] = ['captcha', ReCaptchaValidator2::class];
        }
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Your email',
            'password' => 'Your password',
            'remember_me' => 'Remember me',
        ];
    }

    /**
     * Password validator.
     * @param string $attribute
     * @param string $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) { // if no validation errors
            $user = $this->getUser();

            if (!$user || !Yii::$app->getSecurity()->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Wrong login or password');
            }

            if ($user->status != User::STATUS_CONFIRMED) {
                $this->addError('email', "Email isn't confirmed or deleted");
            }
        }
    }

    /**
     * Получение пользователя
     * @return User
     */
    public function getUser()
    {
        if (!$this->user) {
            $this->user = User::find()
                ->where(['email' => $this->email])
                ->one();
        }

        return $this->user;
    }
}
