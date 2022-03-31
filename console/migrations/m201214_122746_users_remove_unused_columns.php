<?php

use yii\db\Migration;

class m201214_122746_users_remove_unused_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('users', 'start_date');

        $this->dropColumn('users', 'marital_status');
        $this->dropColumn('users', 'mobile_phone_number');
        $this->dropColumn('users', 'phone_number');

        $this->dropColumn('users', 'gender');
        $this->dropColumn('users', 'salutation');
        $this->dropColumn('users', 'contact_id');
        $this->dropColumn('users', 'patronymic');

        $this->dropColumn('users', 'street_address');
        $this->dropColumn('users', 'street_address2');
        $this->dropColumn('users', 'street_address3');
        $this->dropColumn('users', 'street_address4');

        $this->dropColumn('users', 'city');
        $this->dropColumn('users', 'state_region');
        $this->dropColumn('users', 'postal_code');
        $this->dropColumn('users', 'country');

        $this->dropColumn('users', 'company_name');
        $this->dropColumn('users', 'website_url');
        $this->dropColumn('users', 'job_title');
        $this->dropColumn('users', 'industry');

        $this->dropColumn('users', 'twitter_username');
        $this->dropColumn('users', 'facebook_username');
        $this->dropColumn('users', 'instagram_username');
        $this->dropColumn('users', 'linkedin_username');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('users', 'start_date', 'VARCHAR(255) NOT NULL');

        $this->addColumn('users', 'marital_status', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'mobile_phone_number', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'phone_number', 'VARCHAR(255) NOT NULL');

        $this->addColumn('users', 'gender', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'salutation', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'contact_id', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'patronymic', 'VARCHAR(50) NOT NULL');

        $this->addColumn('users', 'street_address', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'street_address2', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'street_address3', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'street_address4', 'VARCHAR(255) NOT NULL');

        $this->addColumn('users', 'city', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'state_region', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'postal_code', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'country', 'VARCHAR(255) NOT NULL');

        $this->addColumn('users', 'company_name', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'website_url', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'job_title', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'industry', 'VARCHAR(255) NOT NULL');

        $this->addColumn('users', 'twitter_username', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'facebook_username', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'instagram_username', 'VARCHAR(255) NOT NULL');
        $this->addColumn('users', 'linkedin_username', 'VARCHAR(255) NOT NULL');
    }
}
