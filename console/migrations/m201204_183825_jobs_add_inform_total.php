<?php

use yii\db\Migration;

class m201204_183825_jobs_add_inform_total extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('jobs', 'inform_total', 'INT(11) NOT NULL AFTER inform_today');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('jobs', 'inform_total');
    }
}
