<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;

class JobSearch extends Job
{
    const STATUS_TIMEOUT = 3;
    const STATUS_EXPIRED = 4;

    public $user_name;
    public $user_second_email;

    /**
     * {@inheritdoc}
     */
    public static $statuses = [
        self::STATUS_NOT_FOUND => 'FAIL – Text cannot be read',
        self::STATUS_FOUND => 'SUCCESS – Text can be read',
        self::STATUS_FAIL => 'FAIL -  Website address',
        self::STATUS_TIMEOUT => 'TIMED OUT',
        self::STATUS_EXPIRED => 'EXPIRED',
    ];

    /**
     * {@inheritdoc}
     */
    public function init() {}

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['title', 'url', 'template', 'expired', 'timeout', 'active', 'status', 'user_name', 'user_second_email'],
        ];
    }

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
        $query = Job::find()->joinWith(['user']);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);

        $dataProvider->sort->attributes['user_name'] = [
            'asc'  => ['users.name' => SORT_ASC],
            'desc' => ['users.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['user_second_email'] = [
            'asc'  => ['users.second_email' => SORT_ASC],
            'desc' => ['users.second_email' => SORT_DESC],
        ];

        if ($this->active != '') {
            $query->andWhere(['jobs.active' => $this->active]);
        }

        if ($this->isEmptyStatus()) {
            // Don't filter by status.
        } elseif ($this->status == self::STATUS_EXPIRED) {
            $query->isExpired(Yii::$app->user->id);
        } elseif ($this->status == self::STATUS_TIMEOUT) {
            $query->hasTimeout(Yii::$app->user->id);
        } elseif (in_array($this->status, array_keys(self::$statuses))) {
            $query->andWhere(['jobs.status' => $this->status]);
        }

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'url', $this->url]);
        $query->andFilterWhere(['like', 'template', $this->template]);
        $query->andFilterWhere(['like', 'users.name', $this->user_name]);
        $query->andFilterWhere(['like', 'users.second_email', $this->user_second_email]);

        return $dataProvider;
    }

    /**
     * If status is not specified.
     * @return bool
     */
    private function isEmptyStatus(): bool
    {
        return in_array(
            $this->status,
            [null, ''],
             true
        );
    }
}
