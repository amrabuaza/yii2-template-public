<?php

use yii\db\Migration;

/**
 * Class m200904_215244_customer
 */
class m200904_215244_customer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'target' => $this->string()->notNull(),
            'target_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_215244_customer cannot be reverted.\n";

        return false;
    }


}
