<?php

use yii\db\Migration;

class m201205_045853_payments_remove_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('payments', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('payments', 'status', 'INT(1) NOT NULL AFTER user_id');
    }
}
