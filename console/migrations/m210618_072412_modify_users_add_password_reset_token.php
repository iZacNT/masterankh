<?php

use yii\db\Migration;

/**
 * Class m210618_072412_modify_users_add_password_reset_token
 */
class m210618_072412_modify_users_add_password_reset_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'password_reset_token', 'VARCHAR(255) NULL AFTER `ip_last_login`');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210618_072412_modify_users_add_password_reset_token cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210618_072412_modify_users_add_password_reset_token cannot be reverted.\n";

        return false;
    }
    */
}
