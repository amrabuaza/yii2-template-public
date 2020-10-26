<?php

use yii\db\Migration;

/**
 * Class m200904_171728_fix_auth_key
 */
class m200904_171728_fix_auth_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user','auth_key',$this->string(32));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_171728_fix_auth_key cannot be reverted.\n";

        return false;
    }


}
