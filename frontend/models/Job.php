<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "jobs".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $url
 * @property string $template
 * @property int $inform_found
 * @property int $inform_not_found
 * @property int $inform_fail
 * @property int $last_check
 * @property int $status
 * @property int $last_error
 * @property int $find_method
 * @property int $inform_today
 * @property int $inform_total
 * @property int $interval
 * @property int $active
 * @property int $payment_id
 * @property int $date_create
 *
 * @property User $user
 */
class Job extends ActiveRecord
{
    /**
     * Check timeout (seconds).
     */
    const CHECK_TIMEOUT = 10;

    const SCENARIO_CHECK = 'check';

    const FIND_METHOD_CODE = 1;
    const FIND_METHOD_TEXT = 2;

    const STATUS_NOT_FOUND = 0;
    const STATUS_FOUND = 1;
    const STATUS_FAIL = 2;
    const STATUS_TIMEOUT = 3;

    const DEFAULT_INTERVAL = 28800;

    /**
     * List of refresh intervals.
     * @var array
     */
    public static $intervals = [
        60 => '1 Minute',
        180 => '3 Minutes',
        300 => '5 Minutes',
        600 => '10 Minutes',
        1800 => '30 Minutes',
        3600 => '1 Hour',
        10800 => '3 Hours',
        21600 => '6 Hours',
        self::DEFAULT_INTERVAL => '8 Hours',
        43200 => '12 Hours',
        86400 => '24 Hours',
    ];

    /**
     * Statuses list and their descriptions.
     * @var array
     */
    public static $statuses = [
        self::STATUS_NOT_FOUND => 'FAIL – Text cannot be read',
        self::STATUS_FOUND => 'SUCCESS – Text can be read',
        self::STATUS_FAIL => 'FAIL - Website address',
        self::STATUS_TIMEOUT => 'TIMED OUT',
    ];

    /**
     * Methods list.
     * @var array
     */
    public static $methods = [
        self::FIND_METHOD_TEXT => 'By text',
        self::FIND_METHOD_CODE => 'By code',
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->interval = self::DEFAULT_INTERVAL;
        $this->status = 0;
        $this->last_check = 0;
        $this->last_error = 0;
        $this->inform_today = 0;
        $this->inform_total = 0;
        $this->user_id = isset(Yii::$app->user) ? Yii::$app->user->id : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobs';
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create'],
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
            self::SCENARIO_DEFAULT => ['title', 'url', 'find_method', 'template', 'active', 'inform_found', 'inform_not_found', 'inform_fail', 'interval', 'status', 'payment_id'],
            self::SCENARIO_CHECK => ['inform_today', 'inform_total', 'last_check', 'status', 'last_error', 'active', 'payment_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['user_id', 'default', 'value' => isset(Yii::$app->user) ? Yii::$app->user->id : null],
            [['inform_fail', 'inform_found', 'inform_not_found', 'active'], 'default', 'value' => 0],

            [['user_id', 'payment_id', 'inform_found', 'inform_not_found', 'inform_fail', 'active', 'last_check', 'status', 'last_error', 'find_method', 'inform_today', 'inform_total', 'interval', 'date_create'], 'integer'],
            [['title', 'url', 'template', 'inform_found', 'active'], 'required'],
            [['url', 'template'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'payment_id' => 'Payment ID',
            'title' => 'Group Name',
            'url' => 'Url',
            'template' => 'Text/Code to find',
            'inform_found' => 'Send me an email if this Text / URL "can" be found',
            'inform_not_found' => 'Send me an email if this Text / URL "cannot" be found',
            'inform_fail' => 'Send FAIL status',
            'last_check' => 'Last check',
            'status' => 'Ping status',
            'last_error' => 'Last error',
            'find_method' => 'Find method',
            'inform_today' => 'Inform messages today',
            'inform_total' => 'Inform messages total',
            'interval' => 'Interval',
            'active' => 'Active',
            'date_create' => 'Date create',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate()
    {
        if ($this->scenario == self::SCENARIO_DEFAULT) {
            $this->inform_today = 0;
        }
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     * @return JobQuery
     */
    public static function find()
    {
        return Yii::createObject(JobQuery::class, [get_called_class()]);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Check if this target is expired.
     * @return bool
     */
    public function isExpired(): bool
    {
        $payment = $this->getPayment()->one();
        if ($payment) {
            return $payment->isExpired();

        }
        $timestamp = $this->getExpirationDate();
        return $timestamp < time();
    }

    /**
     * Expiration timestamp.
     * @return int
     */
    public function getExpirationDate(): int
    {
        $payment = $this->getPayment()->one();
        if ($payment) {
            return strtotime($payment->getEndDate()->format('Y-m-d H:i:s'));
        }
        $user = $this->user ?? Yii::$app->user->identity;
        $plan = $user->getPlan();
        if ($plan->isFree()) { // FREE account
            $timestamp = $this->isNewRecord ? time() : $this->date_create;
            return $timestamp + $plan->expire();
        } else { // Not FREE account
            $payment = $user->getActivePayment();
            return $payment->getEndDate()->format('U');
        }
    }

    public function getPayment() {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
    }

    /**
     * Is amount of notifications today more than limit.
     * @return bool
     */
    public function isInformExceed(): bool
    {
        $plan = $this->user->getPlan();
        return $plan->inform_limit <= $this->inform_today;
    }

    /**
     * Allow to send email about recent change in this job.
     * @return bool
     */
    public function allowInform(): bool
    {
        if ($this->status == self::STATUS_NOT_FOUND && !$this->inform_not_found) {
            return false;
        }
        if ($this->status == self::STATUS_FOUND && !$this->inform_found) {
            return false;
        }
        if ($this->status == self::STATUS_FAIL && !$this->inform_fail) {
            return false;
        }
        $user = $this->user ?: User::findOne($this->user_id);
        if ($user && !$user->send_email_active) {
            return false;
        }
        return true;
    }

    /**
     * Check if current target (page) contains a template.
     * @param string|false $content - page content
     * @param int $code - code
     * @return int - status
     */
    public function checkTarget($content, $code = 200): int
    {
        $this->last_check = time();

        if ($code === 0) return self::STATUS_TIMEOUT;
        if ($code !== 200) return self::STATUS_FAIL;
        if ($this->find_method == self::FIND_METHOD_TEXT) {
            // fix strip_tags with less than symbol javascript
            $content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
            $content = strip_tags($content);
        }

        return mb_strpos($content, $this->template) === false ? self::STATUS_NOT_FOUND : self::STATUS_FOUND;
    }

    /**
     * Set new status.
     * @param int $status - status index
     * @return bool - is status changed
     */
    public function setStatus(int $status): bool
    {
        if ($this->status == $status) return false; // Status not changed - do nothing
        if ($status == self::STATUS_NOT_FOUND) {
            $this->last_error = time();
        }
        $this->status = $status;
        return true;
    }

    /**
     * Get status description by it ID.
     * @return string
     */
    public function getStatusName(): string
    {
        return array_key_exists($this->status, self::$statuses) ? self::$statuses[$this->status] : '';
    }


    public function getPlan() {
        $payment = $this->getPayment()->one();
        if ($payment) {
            return $payment->getPlan();
        }
    }


    /**
     * Increase counters by 1.
     * @return void
     */
    public function incrementInform()
    {
        $this->inform_today++;
        $this->inform_total++;
    }

    /**
     * Get jobs stats for specified user.
     * @return array
     */
    public static function getStats(): array
    {
        $id = Yii::$app->user->id;
        $query = Job::find()->byUser($id);

        return [
            'total' => (clone $query)->count(),
            'active' => (clone $query)->isActive(true)->count(),
            'inactive' => (clone $query)->isActive(false)->count(),
            'notFound' => (clone $query)->byStatuses(self::STATUS_NOT_FOUND)->count(),
            'found' => (clone $query)->byStatus(self::STATUS_FOUND)->count(),
            'failed' => (clone $query)->byStatus(self::STATUS_FAIL)->count(),
            'timeout' => (clone $query)->byStatuses(self::STATUS_TIMEOUT)->count(),
            'expired' => Yii::$app->user->identity->countExpiredJobs(),
        ];
    }
}

class JobQuery extends ActiveQuery
{
    /**
     * Only active jobs.
     * @param bool $active
     * @return self
     */
    public function isActive(bool $active = true): self
    {
        return $this->andWhere('active = ' . (int)$active);
    }

    /**
     * Jobs that are needing to check.
     * @return self
     */
    public function needToCheck(): self
    {
        return $this->isActive()->andWhere('last_check + `interval` < :now', ['now' => time()]);
    }

    /**
     * Find jobs of specified user.
     * @param int $id - user ID
     * @return self
     */
    public function byUser(int $id): self
    {
        return $this->andWhere('user_id = :user_id', ['user_id' => $id]);
    }


    /**
     * get total Job by Payment id
     * @param int $paymentId
     * @return int|string
     */
    public function getTotalJobByPaymentId(int $paymentId)
    {
        return $this->andWhere(['payment_id' => $paymentId])->count();
    }

    /**
     * Find jobs by having timeout.
     * @param int $userId - user ID
     * @return self
     * @throws Exception
     */
    public function hasTimeout(int $userId): self
    {
        $user = User::findOne($userId); /* @var User $user */
        if (!$user) {
            throw new Exception(500);
        }
        $plan = $user->getPlan();

        return $this
            ->byUser($userId)
            ->andWhere(':inform_today <= inform_today', ['inform_today' => $plan->inform_limit]);
    }

    /**
     * Find jobs by status.
     * @param int $status - status index
     * @return self
     */
    public function byStatus(int $status): self
    {
        return $this->andWhere('status = :status', ['status' => $status]);
    }

    public function byStatuses($statuses)
    {
        return $this->andWhere(['status' => $statuses]);
    }

    /**
     * Find expired jobs.
     * @param int $userId - user ID
     * @return self
     * @throws Exception
     */
    public function isExpired(int $userId): self
    {
        $user = User::findOne($userId); /* @var User $user */
        if (!$user) {
            throw new Exception(500);
        }
        $plan = $user->getPlan();
        if ($plan->isFree()) {
            return $this->andWhere('date_create + :plan_expire < :now', [
                'plan_expire' => $plan->expire(),
                'now' => time(),
            ]);
        } else {
            return $this->andWhere('1=0');
        }
    }

    /**
     * Filter by attributes values.
     * @param array $params
     * @return self
     */
    public function filter(array $params): self
    {
        $model = new $this->modelClass; /* @var Job $model */
        foreach ($params as $key => $value) {
            if ($value == '') continue;
            if ($model->hasAttribute($key)) {
                $this->andWhere("{$key} = :{$key}", [$key => $value]);
            }
        }
        return $this;
    }
}
