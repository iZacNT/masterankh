<?php

use yii\db\Migration;

class m201205_053420_payments_add_date_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('payments', 'date_create', 'INT(11) NOT NULL AFTER `plan_id`');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('payments', 'date_create');
    }
}
