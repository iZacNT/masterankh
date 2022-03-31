<?php

use yii\db\Migration;

/**
 * Class m210616_154111_modify_table_jobs
 */
class m210616_154111_modify_table_jobs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('jobs', 'payment_id', $this->integer(11)->null());
        $this->addForeignKey('fk-job_id-payment_id', 'jobs', 'payment_id', 'payments', 'id', 'CASCADE',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210616_154111_modify_table_jobs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210616_154111_modify_table_jobs cannot be reverted.\n";

        return false;
    }
    */
}
