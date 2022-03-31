<?php

use yii\db\Migration;

class m201206_001317_users_rename_us_email extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('users', 'us_email', 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('users', 'email', 'us_email');
    }
}
