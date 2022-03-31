<?php

use yii\db\Migration;

class m201206_000935_users_rename_us_second_email extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('users', 'us_second_email', 'second_email');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('users', 'second_email', 'us_second_email');
    }
}
