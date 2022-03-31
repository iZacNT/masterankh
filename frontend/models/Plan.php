<?php

namespace frontend\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Plan
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $target_limit
 * @property int $inform_limit
 * @property int $notification_interval
 * @property int $date_create
 * @property int $date_update
 * @property string $subscription_duration
 */
class Plan extends ActiveRecord
{
    const FREE = 1;
    const BUSINESS = 2;
    const ENTERPRISE = 3;
    const SESSION_PAYMENT = 'SESSION_PAYMENT';

    private $subscription_duration;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plan';
    }

    /**
     * List of models (caching container).
     * @var self[]
     * @see getModels()
     */
    private static $models;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
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
            self::SCENARIO_DEFAULT => ['name', 'price', 'target_limit', 'inform_limit', 'notification_interval'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'target_limit', 'inform_limit', 'notification_interval', 'date_create', 'date_update'], 'required'],
            [['price', 'target_limit', 'inform_limit', 'notification_interval', 'date_create', 'date_update'], 'integer'],
            [['name', 'subscription_duration'], 'string', 'max' => 255],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'filter', 'filter' => 'mb_strtoupper'],
            [['subscription_duration'], 'safe'],
            [['name', 'price', 'target_limit', 'inform_limit', 'notification_interval'], 'required'],
            ['name', 'string', 'max' => 255],
            [['price', 'subscription_duration', 'target_limit', 'inform_limit', 'notification_interval',
              'date_create', 'date_update'], 'integer'],
            ['name', 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'target_limit' => 'Ping target',
            'inform_limit' => 'Inform Limit',
            'notification_interval' => 'Notification Interval',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'subscription_duration' => 'Subscription Duration',
        ];
    }

    /**
     * Full name of plan.
     * @return string
     */
    public function fullName(): string
    {
        return 'Plan ' . $this->name;
    }

    /**
     * Check if current plan is FREE.
     * @return bool
     */
    public function isFree(): bool
    {
        return $this->id == self::FREE;
    }

    /**
     * Expiration time (sec).
     * @return int
     */
    public function expire(): int
    {
        $duration = $this->subscription_duration ?: 30;
        if ($this->isFree() && !$this->subscription_duration) {
            $duration = 1;
        }
        return $duration * 3600 * 24;
    }

    /**
     * Return data for dropdown list.
     * @var array $except - except items with IDs
     * @return array
     */
    public static function getList(array $except = []): array
    {
        $models = self::getModels($except);
        return array_column($models, 'name', 'id');
    }

    /**
     * Get models list.
     * @param array $except - except model with IDs
     * @return self[]
     */
    public static function getModels(array $except = []): array
    {
        if (self::$models === null) {
            self::$models = self::find()->all();
        }

        $result = [];
        foreach (self::$models as $model) {
            if (in_array($model->id, $except)) continue;
            $result[$model->id] = $model;
        }
        return $result;
    }


    /**
     * Get plan by it ID.
     * @param int $id - plan ID
     * @return self
     */
    public static function getById(int $id): self
    {
        $models = self::getModels();
        return array_key_exists($id, $models) ? $models[$id] : $models[self::FREE];
    }
}
