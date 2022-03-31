<?php

use yii\db\Migration;

class m201205_084705_jobs_add_date_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('jobs', 'date_create', 'INT(11) NOT NULL AFTER `active`');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('jobs', 'date_create');
    }
}
