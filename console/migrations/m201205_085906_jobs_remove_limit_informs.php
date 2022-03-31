<?php

use yii\db\Migration;

class m201205_085906_jobs_remove_limit_informs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('jobs', 'limit_informs');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('jobs', 'limit_informs', 'INT(11) NOT NULL AFTER `inform_total`');
    }
}
