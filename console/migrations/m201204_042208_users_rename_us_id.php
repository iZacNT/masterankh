<?php

use yii\db\Migration;

class m201204_042208_users_rename_us_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('users', 'us_id', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('users', 'id', 'us_id');
    }
}
