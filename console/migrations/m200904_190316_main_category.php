<?php

use yii\db\Migration;

/**
 * Class m200904_190316_main_category
 */
class m200904_190316_main_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%main_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'status' => 'ENUM("active","inactive") DEFAULT "active"',
            'slug' => $this->string()->null(),
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->createTable('{{%main_category_language}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'main_category_id' => $this->integer()->notNull(),
            'language' => $this->string()->notNull(),
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->addForeignKey('fk_main_category_language', 'main_category_language', 'main_category_id', 'main_category', 'id', "CASCADE", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_190316_main_category cannot be reverted.\n";

        return false;
    }

}
