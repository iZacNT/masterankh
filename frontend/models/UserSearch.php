<?php

namespace frontend\models;

use yii\data\ActiveDataProvider;

class UserSearch extends User
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
     * Creates data provider instance with search query applied.
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = User::find()->notDeleted();
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $this->load($params);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'surname', $this->surname]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'second_email', $this->second_email]);

        return $dataProvider;
    }
}
