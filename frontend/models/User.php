<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @property int $id
 * @property string $email
 * @property string $second_email
 * @property string $password
 * @property int $send_email_active
 * @property string $name
 * @property string $surname
 * @property string $auth_key
 * @property int $gender
 * @property string $mobile
 * @property string $phone
 * @property string $address_1
 * @property string $address_2
 * @property string $address_3
 * @property string $address_4
 * @property string $city
 * @property string $state
 * @property string $postal_code
 * @property string $country
 * @property string $company_name
 * @property string $website_url
 * @property int $status
 * @property int $registered_at
 * @property int $became_a_subscriber_date
 * @property string $ip_on_sign_up
 * @property string $ip_last_login
 * @property string $password_reset_token
 *
 * @property Payment[] $payments
 * @property Job[] $jobs
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_UNCONFIRMED = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_DELETED = 2;

    const GENDER_UNKNOWN = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * Statuses list.
     * @var array
     */
    public static $statuses = [
        self::STATUS_UNCONFIRMED => 'Unconfirmed',
        self::STATUS_CONFIRMED => 'Confirmed',
        self::STATUS_DELETED => 'Deleted',
    ];

    /**
     * Genders list.
     * @var array
     */
    public static $genders = [
        self::GENDER_UNKNOWN => '',
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female',
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->mobile = $this->phone = $this->address_1 = $this->address_2 = $this->address_3 = $this->address_4 = $this->city = $this->state = $this->postal_code = $this->country = $this->company_name = $this->website_url = '';
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['registered_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['second_email', 'email', 'name', 'surname', 'send_email_active', 'auth_key', 'gender', 'mobile', 'phone', 'address_1', 'address_2', 'address_3', 'address_4', 'city', 'state', 'postal_code', 'country', 'company_name', 'website_url', 'status', 'became_a_subscriber_date', 'ip_on_sign_up', 'ip_last_login'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['auth_key', 'default', 'value' => Yii::$app->security->generateRandomString()],
            ['send_email_active', 'default', 'value' => 1],
            ['ip_on_sign_up', 'default', 'value' => Yii::$app->request->userIP],
            ['gender', 'default', 'value' => self::GENDER_UNKNOWN],
            [['status', 'became_a_subscriber_date'], 'default', 'value' => 0],
            [['ip_on_sign_up', 'ip_last_login'], 'default', 'value' => ''],

            [['email', 'second_email', 'password'], 'required'],
            [['send_email_active', 'became_a_subscriber_date', 'registered_at'], 'integer'],
            [['name', 'surname'], 'string', 'max' => 50],
            [['email', 'second_email', 'password', 'auth_key', 'password_reset_token', 'mobile', 'phone', 'address_1',
              'address_2', 'address_3', 'address_4', 'city', 'state', 'postal_code', 'country', 'company_name', 'website_url', 'ip_on_sign_up', 'ip_last_login'], 'string', 'max' => 255],
            ['gender', 'in', 'range' => array_keys(self::$genders)],
            ['status', 'in', 'range' => array_keys(self::$statuses)],
            ['email', 'unique'],
            ['second_email', 'email']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email Username',
            'second_email' => 'Email for reports',
            'send_email_active' => 'Use notification email',
            'name' => 'First name',
            'surname' => 'Last name',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery
     */
    public static function find()
    {
        return Yii::createObject(UserQuery::class, [get_called_class()]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->where(['auth_key' => $token])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Current user auth key.
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * If auth key is valid for current user.
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['user_id' => 'id']);
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();

        $am = Yii::$app->authManager;
        if (!$am->getRolesByUser($this->id)) {
            $role = $am->getRole('user');
            $am->assign($role, $this->id);
        }
    }

    /**
     * Set user status = DELETED.
     * Stop all jobs.
     * {@inheritdoc}
     */
    public function delete()
    {
        $transaction = self::getDb()->beginTransaction();

        $this->status = self::STATUS_DELETED;
        if (!$this->save(true, ['status'])) {
            $transaction->rollback();
            return false;
        }

        if (!$this->stopAllJobs()) {
            $transaction->rollback();
            return false;
        }

        $transaction->commit();
        return true;
    }

    /**
     * Stop all jobs that are belong to current user.
     * @return bool
     */
    public function stopAllJobs(): bool
    {
        foreach ($this->jobs as $job) {
            $job->active = 0;
            if (!$job->save(true, ['active'])) return false;
        }
        return true;
    }

    /**
     * Name + surname.
     * @return string
     */
    public function fullName(): string
    {
        $str = $this->name;
        if ($this->surname) {
            $str.= ' ' . $this->surname;
        }
        return mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Return not expired plan.
     * @return Plan
     */
    public function getPlan(): Plan
    {
        $payment = Yii::$app->user->identity->getPaymentAvailable();
        $id = $payment ? $payment->plan_id : Plan::FREE;
        return Plan::getById($id);
    }

    /**
     * Check if user can create new job.
     * @return bool
     */
    public function canCreateNewJob(): bool
    {
        $countActiveJobs = Job::find()->byUser($this->id)->count();
        $countPaid = Payment::find()->getQuantityByUserId($this->id) ?: 0;
        return $countPaid > $countActiveJobs;
    }


    /**
     * Get payment available
     * @return Payment | null
     */
    public function getPaymentAvailable()
    {
        $paymentsActive = Payment::find()->getPaymentsActiveByUserId($this->id);
        $countActiveJobs = Job::find()->byUser($this->id)->count();
        foreach ($paymentsActive as $key => $payment) {
            $totalJobs = Job::find()->byUser($this->id)->getTotalJobByPaymentId($payment->id);
            if ($totalJobs <= $payment->quantity && $countActiveJobs >= $payment->quantity) {
                $countActiveJobs = $countActiveJobs - $payment->quantity;
                continue;
            }

            if ($totalJobs < $payment->quantity && $countActiveJobs < $payment->quantity) {
                return $payment;
            }
        }
        return null;
    }

    /**
     * Amount of expired jobs.
     * Depends on account type.
     * @return int
     */
    public function countExpiredJobs(): int
    {
        $plan = $this->getPlan();
        if ($plan->isFree()) { // FREE account
            return Job::find()->byUser($this->id)->andWhere('date_create + :plan_expire < :now', [
                'plan_expire' => $plan->expire(),
                'now' => time(),
            ])->count();
        } else { // Not FREE account
            return 0;
        }
    }

    /**
     * Payment that is not expires.
     * @return Payment|null
     * @todo: user can buy more than one plan
     */
    public function getActivePayment()
    {
        return Payment::find()
            ->notExpired()
            ->byUser($this->id)
            ->one();
    }

    /**
     * Last payment of current user.
     * @return Payment|null
     */
    public function getLastPayment()
    {
        return Payment::find()
            ->byUser($this->id)
            ->orderBy('date_create DESC')
            ->one();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = 3600;
        return $timestamp + $expire >= time();
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_CONFIRMED,
        ]);
    }
}

class UserQuery extends ActiveQuery
{
    /**
     * Users that have specified status.
     * @return self
     */
    public function isActive(): self
    {
        return $this->andWhere('status = ' . User::STATUS_CONFIRMED);
    }

    /**
     * Not deleted users.
     * @return self
     */
    public function notDeleted(): self
    {
        return $this->andWhere('status != ' . User::STATUS_DELETED);
    }
}
