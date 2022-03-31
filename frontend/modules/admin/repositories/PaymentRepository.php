<?php

namespace app\modules\admin\repositories;

use frontend\models\Payment;

class PaymentRepository
{
    private function query()
    {
        return Payment::find();
    }

    private function getOneByCondition(array $params = [])
    {
        return $this->query()->where($params)->limit(1)->one();
    }

    private function getAllByCondition(array $params = [])
    {
        return $this->query()->where($params)->all();
    }

    public function getOneByUserId($userId)
    {
        return $this->getOneByCondition(['user_id' => $userId]);
    }

    public function getQuantityByUserId($userId)
    {
        return $this->query()->getQuantityByUserId($userId);
    }

    public function getCountPaidByUserId($userId)
    {
        $model = $this->getOneByUserId($userId);
        if ($model) {
            return $model->quantity;
        }
        return 0;
    }

    public function save(Payment $model)
    {
        try {
            return $model->save();
        } catch (\Exception $exception) {
            return false;
        }
    }
}
