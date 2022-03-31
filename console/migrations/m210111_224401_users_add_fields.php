<?php

use yii\db\Migration;

class m210111_224401_users_add_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'gender', 'INT(1) NOT NULL AFTER `auth_key`');
        $this->addColumn('users', 'mobile', 'VARCHAR(255) NOT NULL AFTER `gender`');
        $this->addColumn('users', 'phone', 'VARCHAR(255) NOT NULL AFTER `mobile`');
        $this->addColumn('users', 'address_1', 'VARCHAR(255) NOT NULL AFTER `phone`');
        $this->addColumn('users', 'address_2', 'VARCHAR(255) NOT NULL AFTER `address_1`');
        $this->addColumn('users', 'address_3', 'VARCHAR(255) NOT NULL AFTER `address_2`');
        $this->addColumn('users', 'address_4', 'VARCHAR(255) NOT NULL AFTER `address_3`');
        $this->addColumn('users', 'city', 'VARCHAR(255) NOT NULL AFTER `address_4`');
        $this->addColumn('users', 'state', 'VARCHAR(255) NOT NULL AFTER `city`');
        $this->addColumn('users', 'postal_code', 'VARCHAR(255) NOT NULL AFTER `state`');
        $this->addColumn('users', 'country', 'VARCHAR(255) NOT NULL AFTER `postal_code`');
        $this->addColumn('users', 'company_name', 'VARCHAR(255) NOT NULL AFTER `country`');
        $this->addColumn('users', 'website_url', 'VARCHAR(255) NOT NULL AFTER `company_name`');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'gender');
        $this->dropColumn('users', 'mobile');
        $this->dropColumn('users', 'phone');
        $this->dropColumn('users', 'address_1');
        $this->dropColumn('users', 'address_2');
        $this->dropColumn('users', 'address_3');
        $this->dropColumn('users', 'address_4');
        $this->dropColumn('users', 'city');
        $this->dropColumn('users', 'state');
        $this->dropColumn('users', 'postal_code');
        $this->dropColumn('users', 'country');
        $this->dropColumn('users', 'company_name');
        $this->dropColumn('users', 'website_url');
    }
}
