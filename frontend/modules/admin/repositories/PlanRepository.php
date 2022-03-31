<?php

namespace app\modules\admin\repositories;

use frontend\models\Plan;

class PlanRepository
{
    private function query()
    {
        return Plan::find();
    }

    private function getOneByCondition(array $params = [])
    {
        return $this->query()->where($params)->limit(1)->one();
    }

    private function getAllByCondition(array $params = [])
    {
        return $this->query()->where($params)->all();
    }

    public function getOneById($id)
    {
        return $this->getOneByCondition(['id' => $id]);
    }

    public function save(Plan $model)
    {
        try {
            return $model->save();
        } catch (\Exception $exception) {
            return false;
        }
    }
}