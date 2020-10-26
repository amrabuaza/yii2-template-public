<?php

namespace common\models\user;

use common\models\ActiveRecord;
use Yii;

/**
 * Guest model
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone_number
 */
class Guest extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%guest}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'first_name', 'last_name', 'phone_number'], 'required'],
            [['email', 'first_name', 'last_name', 'phone_number'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => Yii::t("app", 'First Name'),
            'last_name' => Yii::t("app", 'Last Name'),
            'email' => Yii::t("app", 'Email'),
            'phone_number' => Yii::t("app", 'Phone Number'),
        ];
    }

}