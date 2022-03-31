<?php

use yii\db\Migration;

class m201205_054225_payments_remove_expire extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('payments', 'expire');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('payments', 'expire', 'INT(11) NOT NULL AFTER `quantity`');
    }
}
