<?php

use yii\db\Migration;
use yii\db\Query;

class m201205_050504_payments_remove_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('payments', 'code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('payments', 'code', 'VARCHAR(50) NOT NULL AFTER user_id');
        if (!$this->fillCodeColumn()) return false;
        $this->execute('ALTER TABLE `payments` ADD UNIQUE KEY `code` (`code`);');
    }

    /**
     * Fill code column with random unique strings.
     * @return bool
     */
    private function fillCodeColumn(): bool
    {
        $payments = (new Query)
            ->select('*')
            ->from('payments')
            ->all();

        foreach ($payments as $payment) {
            $code = Yii::$app->security->generateRandomString(15);
            $rowsAffected = Yii::$app->db->createCommand()->update('payments', ['code' => $code], 'id = :id', ['id' => $payment['id']])->execute();
            if ($rowsAffected < 1) return false;
        }
        return true;
    }
}
