<?php

use yii\db\Migration;

/**
 * Class m210513_132812_create_table_social_auth
 */
class m210513_132812_create_table_social_auth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('social_auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);
        $this->addForeignKey('fk-auth-user_id-user-id', 'social_auth', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('social_auth');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210513_132812_create_table_social_auth cannot be reverted.\n";

        return false;
    }
    */
}
