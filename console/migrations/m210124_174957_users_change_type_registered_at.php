<?php

use yii\db\Migration;

class m210124_174957_users_change_type_registered_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('users', [
            'registered_at' => 0,
        ]);
        $this->alterColumn('users', 'registered_at', 'INT NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('users', 'registered_at', 'VARCHAR(255) NOT NULL');
    }
}
