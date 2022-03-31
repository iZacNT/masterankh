<?php

use yii\db\Migration;

class m210112_152915_create_table_plan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('plan', [
            'id' => 'pk',
            'name' => 'VARCHAR(255) NOT NULL',
            'price' => 'INT NOT NULL',
            'target_limit' => 'INT NOT NULL',
            'inform_limit' => 'INT NOT NULL',
            'notification_interval' => 'INT NOT NULL',
            'date_create' => 'INT NOT NULL',
            'date_update' => 'INT NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('plan');
    }
}
