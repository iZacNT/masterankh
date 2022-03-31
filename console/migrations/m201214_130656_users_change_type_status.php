<?php

use yii\db\Migration;

class m201214_130656_users_change_type_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->alterColumn('users', 'status', 'INT(1) NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->alterColumn('users', 'status', 'VARCHAR(255) NOT NULL');
    }

}
