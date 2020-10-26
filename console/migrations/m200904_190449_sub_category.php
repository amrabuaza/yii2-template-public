<?php

use yii\db\Migration;

/**
 * Class m200904_190449_sub_category
 */
class m200904_190449_sub_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sub_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'main_category_id' => $this->integer()->notNull(),
            'status' => 'ENUM("active","inactive") DEFAULT "active"',
            'slug' => $this->string()->null(),
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->createTable('{{%sub_category_language}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'sub_category_id' => $this->integer()->notNull(),
            'language' => $this->string()->notNull(),
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->addForeignKey('fk_sub_category_main_category', 'sub_category', 'main_category_id', 'main_category', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk_sub_category_language', 'sub_category_language', 'sub_category_id', 'sub_category', 'id', "CASCADE", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_190449_sub_category cannot be reverted.\n";

        return false;
    }

}
