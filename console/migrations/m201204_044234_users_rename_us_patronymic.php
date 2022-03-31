<?php

use yii\db\Migration;

class m201204_044234_users_rename_us_patronymic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('users', 'us_patronymic', 'patronymic');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('users', 'patronymic', 'us_patronymic');
    }
}
