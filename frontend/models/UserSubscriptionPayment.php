<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_subscription_payment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $plan_id
 * @property int|null $quantity
 * @property string $valid_from
 * @property string $valid_to
 * @property string $txn_id
 * @property string $payment_gross
 * @property string $subscr_id
 * @property string $payer_email
 * @property string $payment_status
 *
 * @property User $user
 */
class UserSubscriptionPayment extends \yii\db\ActiveRecord
{
    const SUBSCRIBED = 'Subscribed';
    const COMPLETED = 'Completed';
    const CANCELED = 'Canceled';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_subscription_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'plan_id', 'valid_from', 'valid_to', 'txn_id', 'payment_gross', 'subscr_id', 'payer_email', 'payment_status'], 'required'],
            [['user_id', 'plan_id', 'quantity'], 'integer'],
            [['valid_from', 'valid_to'], 'safe'],
            [['txn_id', 'payment_gross', 'subscr_id', 'payer_email', 'payment_status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'plan_id' => 'Plan ID',
            'quantity' => 'Quantity',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
