<?php

use yii\db\Migration;

class m201205_052856_payments_remove_last_jobs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('payments', 'last_jobs');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('payments', 'last_jobs', 'INT(11) NOT NULL AFTER `expire`');
    }
}
