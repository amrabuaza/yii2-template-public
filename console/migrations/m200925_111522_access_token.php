<?php

use yii\db\Migration;

/**
 * Class m200925_111522_access_token
 */
class m200925_111522_access_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%access_token}}', [
            'id' => $this->primaryKey(),
            'grant_token' => $this->string()->notNull(),
            'expiry_date' => 'datetime DEFAULT NULL',
            'is_refresh_token' => $this->boolean()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->addForeignKey('fk_access_token_user', 'access_token', 'user_id', 'user', 'id', "CASCADE", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200925_111522_access_token cannot be reverted.\n";

        return false;
    }

}
