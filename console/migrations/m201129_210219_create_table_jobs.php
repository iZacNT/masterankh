<?php

use yii\db\Migration;

class m201129_210219_create_table_jobs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('jobs', [
            'id' => 'pk',
            'user_id' => 'INT(11) NOT NULL',
            'title' => 'TEXT NOT NULL',
            'url' => 'TEXT NOT NULL',
            'template' => 'TEXT NOT NULL',
            'active' => 'INT(1) NOT NULL',
            'inform_success_find' => 'INT(1) NOT NULL',
            'inform_success_not_find' => 'INT(1) NOT NULL',
            'inform_fail' => 'INT(1) NOT NULL',
            'last_check' => 'INT(11) NOT NULL',
            'next_check' => 'INT(11) NOT NULL',
            'last_status' => 'INT(1) NOT NULL',
            'last_error' => 'INT(11) NOT NULL',
            'find_method' => 'INT(11) NOT NULL',
            'last_http_status' => 'INT(11) NOT NULL',
            'inform_today' => 'INT(11) NOT NULL',
            'limit_informs' => 'INT(11) NOT NULL',
            'expire' => 'INT(11) NOT NULL',
            'interval' => 'INT(11) NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('jobs');
    }
}
