<?php

namespace frontend\models;

use yii\data\ActiveDataProvider;

class PaymentSearch extends Payment
{
    /**
     * {@inheritdoc}
     */
    public function init() {}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params, array $condition = null): ActiveDataProvider
    {
        $query = Payment::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);

        if ($condition) {
            $query->andFilterWhere($condition);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'plan_id' => $this->plan_id,
            'quantity' => $this->quantity,
        ]);

        return $dataProvider;
    }
}
