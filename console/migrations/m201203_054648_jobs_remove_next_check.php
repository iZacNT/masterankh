<?php

use yii\db\Migration;

class m201203_054648_jobs_remove_next_check extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('jobs', 'next_check');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('jobs', 'next_check', 'INT(11) NOT NULL');
    }
}
