<?php

use yii\db\Migration;

class m201204_042936_users_rename_us_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('users', 'us_name', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('users', 'name', 'us_name');
    }
}
