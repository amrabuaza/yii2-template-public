<?php

use yii\db\Migration;

/**
 * Class m200904_190453_item
 */
class m200904_190453_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'price' => $this->double()->notNull(),
            'price_after_sale' => $this->double(),
            'has_offer' => 'ENUM("yes","no") DEFAULT "no"',
            'status' => 'ENUM("active","inactive") DEFAULT "active"',
            'slug' => $this->string()->null(),
            'sub_category_id' => $this->integer()->notNull(),
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->createTable('{{%item_language}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'language' => $this->string()->notNull(),
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->addForeignKey('fk_item_sub_category', 'item', 'sub_category_id', 'sub_category', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk_item_language', 'item_language', 'item_id', 'item', 'id', "CASCADE", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_190453_item cannot be reverted.\n";

        return false;
    }

}
