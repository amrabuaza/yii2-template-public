<?php

use common\lib\i18nModule\models\TranslateCategory;
use yii\db\Migration;

/**
 * Class m200912_201116_insert_translate_category
 */
class m200912_201116_insert_translate_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        TranslateCategory::create("app");
        TranslateCategory::create("yii");
        TranslateCategory::create("metalguardian/i18n");
        TranslateCategory::create("rbac-admin");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200912_201116_insert_translate_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200912_201116_insert_translate_category cannot be reverted.\n";

        return false;
    }
    */
}
