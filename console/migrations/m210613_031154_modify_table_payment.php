<?php

use yii\db\Migration;

/**
 * Class m210613_031154_modify_table_payment
 */
class m210613_031154_modify_table_payment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('payments', 'valid_from', $this->dateTime()->null());
        $this->addColumn('payments', 'valid_to', $this->dateTime()->null());
        $this->addColumn('payments', 'txn_id', $this->string()->null()->defaultValue("0"));
        $this->addColumn('payments', 'payment_gross', $this->string()->notNull()->defaultValue("0"));
        $this->addColumn('payments', 'subscr_id', $this->string()->notNull()->defaultValue("0"));
        $this->addColumn('payments', 'payer_email', $this->string()->null());
        $this->addColumn('payments', 'payment_status', $this->string()->null());
        $this->alterColumn('payments', 'date_create', $this->integer(11)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210613_031154_modify_table_payment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210613_031154_modify_table_payment cannot be reverted.\n";

        return false;
    }
    */
}
