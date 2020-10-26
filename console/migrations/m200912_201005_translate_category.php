<?php

use yii\db\Migration;

/**
 * Class m200912_201005_translate_category
 */
class m200912_201005_translate_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("translate_category", [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200912_201005_translate_category cannot be reverted.\n";

        return false;
    }

}
