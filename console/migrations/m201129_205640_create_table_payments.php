<?php

use yii\db\Migration;

class m201129_205640_create_table_payments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('payments', [
            'id' => 'pk',
            'user_id' => 'INT(11) NOT NULL',
            'code' => 'VARCHAR(50) NOT NULL',
            'quantity' => 'INT(11) NOT NULL',
            'expire' => 'INT(11) NOT NULL',
            'last_jobs' => 'INT(11) NOT NULL',
            'status' => 'INT(11) NOT NULL',
            'plan_id' => 'INT(1) NOT NULL',
        ]);

        $this->execute('ALTER TABLE `payments` ADD UNIQUE KEY `code` (`code`);');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('payments');
    }
}
