<?php

use yii\db\Migration;

class m201129_154823_create_table_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'us_id' => 'pk',
            'us_email' => 'VARCHAR(255) NOT NULL',
            'us_second_email' => 'VARCHAR(255) NOT NULL',
            'us_password' => 'VARCHAR(255) NOT NULL',
            'send_email_active' => 'INT(1) NOT NULL',
            'us_name' => 'VARCHAR(50) NOT NULL',
            'us_surname' => 'VARCHAR(50) NOT NULL',
            'us_patronymic' => 'VARCHAR(50) NOT NULL',
            'auth_key' => 'VARCHAR(255) NOT NULL',
            'contact_id' => 'VARCHAR(255) NOT NULL',
            'salutation' => 'VARCHAR(255) NOT NULL',
            'status' => 'VARCHAR(255) NOT NULL',
            'gender' => 'VARCHAR(255) NOT NULL',
            'marital_status' => 'VARCHAR(255) NOT NULL',
            'registered_at' => 'VARCHAR(255) NOT NULL',
            'start_date' => 'VARCHAR(255) NOT NULL',
            'mobile_phone_number' => 'VARCHAR(255) NOT NULL',
            'phone_number' => 'VARCHAR(255) NOT NULL',
            'became_a_subscriber_date' => 'VARCHAR(255) NOT NULL',
            'ip_on_sign_up' => 'VARCHAR(255) NOT NULL',
            'ip_last_login' => 'VARCHAR(255) NOT NULL',
            'street_address' => 'VARCHAR(255) NOT NULL',
            'street_address2' => 'VARCHAR(255) NOT NULL',
            'street_address3' => 'VARCHAR(255) NOT NULL',
            'street_address4' => 'VARCHAR(255) NOT NULL',
            'city' => 'VARCHAR(255) NOT NULL',
            'state_region' => 'VARCHAR(255) NOT NULL',
            'postal_code' => 'VARCHAR(255) NOT NULL',
            'country' => 'VARCHAR(255) NOT NULL',
            'company_name' => 'VARCHAR(255) NOT NULL',
            'website_url' => 'VARCHAR(255) NOT NULL',
            'job_title' => 'VARCHAR(255) NOT NULL',
            'industry' => 'VARCHAR(255) NOT NULL',
            'twitter_username' => 'VARCHAR(255) NOT NULL',
            'facebook_username' => 'VARCHAR(255) NOT NULL',
            'instagram_username' => 'VARCHAR(255) NOT NULL',
            'linkedin_username' => 'VARCHAR(255) NOT NULL',
        ]);

        $this->execute('ALTER TABLE `users` ADD UNIQUE KEY `us_email` (`us_email`);');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
