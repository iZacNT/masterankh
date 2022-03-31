<?php

use yii\db\Migration;

class m201129_164251_create_table_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('lang', [
            'id' => 'pk',
            'url' => 'VARCHAR(255) NOT NULL',
            'local' => 'VARCHAR(255) NOT NULL',
            'name' => 'VARCHAR(255) NOT NULL',
            'default' => 'INT(11) NOT NULL',
            'date_update' => 'INT(11) NOT NULL',
            'date_create' => 'INT(11) NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('lang');
    }
}
