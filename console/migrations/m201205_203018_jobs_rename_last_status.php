<?php

use yii\db\Migration;

class m201205_203018_jobs_rename_last_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('jobs', 'last_status', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('jobs', 'status', 'last_status');
    }
}
