<?php

use yii\db\Migration;

class m201203_060306_jobs_rename_inform_success_not_find extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('jobs', 'inform_success_not_find', 'inform_not_found');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('jobs', 'inform_not_found', 'inform_success_not_find');
    }
}
