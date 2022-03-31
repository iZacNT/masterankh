<?php

use yii\db\Migration;

class m201212_025429_lang_add_record_english extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->insert('lang', [
            'id' => 1,
            'url' => 'en',
            'local' => 'en-US',
            'name' => 'en',
            'default' => 1,
            'date_update' => time(),
            'date_create' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->truncateTable('lang');
    }
}
