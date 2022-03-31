<?php

namespace frontend\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use Yii;
use yii\base\Model;

class Register extends Model
{
    const SPECIAL_CHARACTERS = '!@#$%^&()-_=+<>{}[]|';

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $surname;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_confirm;

    /**
     * ReCaptcha.
     * @var string
     */
    public $captcha;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['email', 'password', 'password_confirm', 'name', 'surname'], 'required'],
            ['password', 'string', 'min' => 8, 'max' => 100],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],
            ['password', 'validatePassword'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'First Name should not contain numbers'],
            ['surname', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Last Name should not contain numbers']
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
            'email' => 'Email',
            // 'name' => 'Name',
            'name' => 'First Name',
            // 'surname' => 'Surname',
            'surname' => 'Last Name',
            'password' => 'Password',
            'password_confirm' => 'Password confirm',
        ];
    }

    /**
     * Password validator.
     * @param string $attribute
     * @param string $params
     */
    public function validatePassword($attribute, $params)
    {
        $pass = $this->$attribute;
        $message = 'Password needs to contain at least one digit, one uppercase letter and one special character: ' . self::SPECIAL_CHARACTERS;

        // Digits
        if (!preg_match('/[0-9]/', $pass)) {
            $this->addError($attribute, $message);
        }

        // Uppercase
        if (!preg_match('/[A-Z]/', $pass)) {
            $this->addError($attribute, $message);
        }

        // Lowercase
        if (!preg_match('/[a-z]/', $pass)) {
            $this->addError($attribute, $message);
        }

        // Specialchars
        $chars = preg_quote(self::SPECIAL_CHARACTERS);
        if (!preg_match("/[$chars]/", $pass)) {
            $this->addError($attribute, $message);
        }
    }
}
