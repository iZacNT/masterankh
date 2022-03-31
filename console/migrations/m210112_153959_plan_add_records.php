<?php

use yii\db\Migration;

class m210112_153959_plan_add_records extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $time = time();

        $this->insert('plan', [
            'id' => 1,
            'name' => 'FREE',
            'price' => 0,
            'target_limit' => 1,
            'inform_limit' => 3,
            'notification_interval' => 15,
            'date_create' => $time,
            'date_update' => $time,
        ]);

        $this->insert('plan', [
            'id' => 2,
            'name' => 'BUSINESS',
            'price' => 1,
            'target_limit' => 1,
            'inform_limit' => 7,
            'notification_interval' => 2,
            'date_create' => $time,
            'date_update' => $time,
        ]);

        $this->insert('plan', [
            'id' => 3,
            'name' => 'ENTERPRISE',
            'price' => 2,
            'target_limit' => 5,
            'inform_limit' => 30,
            'notification_interval' => 1,
            'date_create' => $time,
            'date_update' => $time,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('plan');
    }
}
