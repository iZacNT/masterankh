<?php

use yii\db\Migration;

class m201203_053925_jobs_remove_last_http_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('jobs', 'last_http_status');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('jobs', 'last_http_status', 'INT(11) NOT NULL');
    }
}
