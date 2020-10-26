<?php

use common\models\user\User;
use yii\db\Migration;

/**
 * Class m200904_171930_insert_root_user
 */
class m200904_171930_insert_root_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();
        $user->username = "root";
        $user->email = "c.r925@hotmail.com";
        $user->first_name = "Amr";
        $user->last_name = "Abu Aza";
        $user->phone_number = "962780663397";
        $user->setPassword("53elgoj1");
        $user->user_type = User::TYPE_ROOT;
        $user->save();

        $user = new User();
        $user->username = "admin";
        $user->email = "admin@test.com";
        $user->first_name = "admin";
        $user->last_name = "ecommerce";
        $user->phone_number = "123123";
        $user->setPassword("12341234");
        $user->user_type = User::TYPE_ADMIN;
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_171930_insert_root_user cannot be reverted.\n";

        return false;
    }

}
