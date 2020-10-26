<?php

use yii\db\Migration;

/**
 * Class m200904_205424_user_auth
 */
class m200904_205424_user_auth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);
        $this->addForeignKey('fk_auth_user_id', 'auth', 'user_id', 'user', 'id', "CASCADE", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_205424_user_auth cannot be reverted.\n";

        return false;
    }

}
