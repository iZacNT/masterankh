<?php

use yii\db\Migration;

class m210124_174251_users_change_type_became_a_subscriber_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('users', [
            'became_a_subscriber_date' => 0,
        ]);
        $this->alterColumn('users', 'became_a_subscriber_date', 'INT NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('users', 'became_a_subscriber_date', 'VARCHAR(255) NOT NULL');
    }
}
