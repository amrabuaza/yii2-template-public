<?php

namespace common\models\user;

use common\models\ActiveRecord;

/**
 * Customer model
 *
 * @property integer $id
 * @property string $target
 * @property string $target_id
 * @property User|Guest $info
 * @property string $username
 */
class Customer extends ActiveRecord
{

    const TARGET = "target";
    const TARGET_ID = "target_id";
    const TARGET_USER = "user";
    const TARGET_GUEST = "guest";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['target', 'target_id'], 'required'],
            [['target_id'], 'integer'],
            [['target'], 'string'],
        ];
    }

    public function getUsername()
    {
        return $this->info->first_name . " " . $this->info->last_name;
    }

    public function getInfo()
    {
        if ($this->target == self::TARGET_USER) {
            return User::findOne($this->target_id);
        }
        return Guest::findOne($this->target_id);
    }

}