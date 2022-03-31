<?php

use yii\db\Migration;

class m201204_043550_users_rename_us_surname extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->renameColumn('users', 'us_surname', 'surname');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->renameColumn('users', 'surname', 'us_surname');
    }
}
