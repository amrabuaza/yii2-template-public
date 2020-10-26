<?php

use yii\db\Migration;

/**
 * Class m201003_123110_init_translate_messages_and_category
 */
class m201003_123110_init_translate_messages_and_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $files = [
            '/translate_category.sql',
            "/source_message.sql",
            '/message.sql',
        ];
        foreach ($files as $file) {
            $sql = file_get_contents(__DIR__ . $file);
            $command = Yii::$app->db->createCommand($sql);
            $command->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201003_123110_init_translate_messages_and_category cannot be reverted.\n";

        return false;
    }
}
