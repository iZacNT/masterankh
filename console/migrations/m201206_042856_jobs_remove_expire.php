<?php

use yii\db\Migration;

class m201206_042856_jobs_remove_expire extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('jobs', 'expire');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('jobs', 'expire', 'INT(11) NOT NULL AFTER `inform_total`');
    }
}
