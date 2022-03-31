<?php

namespace frontend\models;

use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int $user_id
 * @property int $quantity
 * @property int $plan_id
 * @property int|null $date_create
 * @property string|null $valid_from
 * @property string|null $valid_to
 * @property string|null $txn_id
 * @property string $payment_gross
 * @property string $subscr_id
 * @property string|null $payer_email
 * @property string|null $payment_status
 *
 * @property User $user
 * @property Plan $plan
 */
class Payment extends ActiveRecord
{
    const SCENARIO_UPDATE = 'update';
    const SUBSCRIBED = 'Subscribed';
    const COMPLETED = 'Completed';
    const CANCELED = 'Canceled';
    /**
     * @var string
     */
    public $end_date;
    public $start_date;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

//    /**
//     * @inheritdoc
//     */
//    public function behaviors()
//    {
//        return [
//            'timestamp' => [
//                'class' => TimestampBehavior::class,
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create'],
//                ],
//            ],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'user_id',
                'quantity',
                'plan_id',
                'txn_id',
                'payment_gross',
                'subscr_id',
                'payer_email',
                'payment_status',
                'valid_from', 'valid_to'
                ],
            self::SCENARIO_UPDATE => ['user_id', 'quantity', 'plan_id', 'end_date',  'txn_id',
                                      'payment_gross',
                                      'subscr_id',
                                      'payer_email',
                                      'payment_status',
                                      'valid_from', 'valid_to'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['user_id', 'default', 'value' => isset(Yii::$app->user) ? Yii::$app->user->id : null],

            [['user_id', 'quantity', 'plan_id'], 'required'],
            [['user_id', 'quantity', 'plan_id', 'date_create'], 'integer'],
            [['valid_from', 'valid_to'], 'safe'],
            [['txn_id', 'payment_gross', 'subscr_id', 'payer_email', 'payment_status'], 'string', 'max' => 255],
//            ['plan_id', 'in', 'range' => array_column(Plan::getModels([Plan::FREE]), 'id')],
            ['user_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

            ['end_date', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', 'on' => self::SCENARIO_UPDATE],
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
            'quantity' => 'Quantity',
            'plan_id' => 'Plan ID',
            'date_create' => 'Date Create',
            'valid_from' => 'Valid From',
            'valid_to' => 'Valid To',
            'txn_id' => 'Txn ID',
            'payment_gross' => 'Payment Gross',
            'subscr_id' => 'Subscr ID',
            'payer_email' => 'Payer Email',
            'payment_status' => 'Payment Status',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->end_date = $this->getEndDate()->format('Y-m-d H:i:s');
        $this->start_date = $this->getStartDate()->format('Y-m-d H:i:s');
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate()
    {
        if ($this->scenario == self::SCENARIO_UPDATE) {
            $this->date_create = DateTime::createFromFormat('Y-m-d H:i:s', $this->end_date)->modify("-$this->quantity month")->format('U');
        }
        return parent::beforeValidate();
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return Plan
     */
    public function getPlan(): Plan
    {
        return Plan::getById($this->plan_id);
    }

    /**
     * {@inheritdoc}
     * @return PaymentQuery
     */
    public static function find()
    {
        return Yii::createObject(PaymentQuery::class, [get_called_class()]);
    }

    /**
     * Count end_date according to date_create and quantity.
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        if ($this->getPlan()->isFree()) {
            return (new DateTime)->setTimestamp($this->date_create)->modify("+1 day");
        }
        return $this->valid_to ? (new DateTime($this->valid_to)):
            (new DateTime)->setTimestamp($this->date_create)->modify("+1 month");
    }


    /**
     * Count end_date according to date_create and quantity.
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->valid_from ? (new DateTime($this->valid_from)): (new DateTime)->setTimestamp($this->date_create);
    }

    /**
     * Total price of invoice.
     * @return int
     */
    public function totalPrice(): int
    {
        return $this->quantity * $this->plan->price;
    }

    /**
     * Check payment is expired.
     * @return bool
     */
    public function isExpired(): bool
    {
        if ($this->getPlan()->isFree()) {
            return $this->getEndDate()->getTimestamp() < time();
        }
        $month = 3600 * 24 * 30;
        return in_array('payment_status', [Payment::CANCELED, Payment::SUBSCRIBED]) ||
            (!$this->payment_status &&  $this->date_create < time() - $month);
    }
}

class PaymentQuery extends ActiveQuery
{
    /**
     * Not expired payments.
     * @return self
     */
    public function notExpired(): self
    {
        $month = 3600 * 24 * 30;
        return $this->andWhere(['payment_status' => Payment::COMPLETED])
            ->orWhere(['and' , ['payment_status' => null], [">=", "date_create", time() - $month]]);
    }

    /**
     * Quantity of user.
     * @return int
     */
    public function getQuantityByUserId($userId)
    {
        return $this->notExpired()->byUser($userId)->sum('quantity');
    }

    /**
     * Payments active of user.
     * @return Payment[]
     */
    public function getPaymentsActiveByUserId($userId)
    {
        return $this->notExpired()->byUser($userId)->all();
    }

    /**
     * Get by user ID.
     * @param int $id - user ID
     * @return self
     */
    public function byUser(int $id): self
    {
        return $this->andWhere('user_id = :user_id', ['user_id' => $id]);
    }


}
