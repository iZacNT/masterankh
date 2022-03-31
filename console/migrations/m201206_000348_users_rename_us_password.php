<?php

use yii\db\Migration;

class m201206_000348_users_rename_us_password extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('users', 'us_password', 'password');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('users', 'password', 'us_password');
    }
}
