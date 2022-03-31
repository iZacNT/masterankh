<?php

use yii\db\Migration;

/**
 * Class m210625_032113_modify_table_plan
 */
class m210625_032113_modify_table_plan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('plan', 'subscription_duration', $this->string()->notNull()->defaultValue("30"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210625_032113_modify_table_plan cannot be reverted.\n";
        //$this->dropColumn('plan', 'subscription_duration');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210625_032113_modify_table_plan cannot be reverted.\n";

        return false;
    }
    */
}
