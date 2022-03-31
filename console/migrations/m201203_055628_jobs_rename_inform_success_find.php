<?php

use yii\db\Migration;

class m201203_055628_jobs_rename_inform_success_find extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('jobs', 'inform_success_find', 'inform_found');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('jobs', 'inform_found', 'inform_success_find');
    }
}
