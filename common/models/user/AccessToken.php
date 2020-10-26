<?php

namespace common\models\user;

use common\models\ActiveRecord;

/**
 * This is the model class for table "access_token".
 *
 * @property int $id
 * @property string $grant_token
 * @property string|null $expiry_date
 * @property int $is_refresh_token
 * @property int $user_id
 * @property string $created_at
 *
 * @property User $user
 */
class AccessToken extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_token';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date("Y-m-d H:i:s");
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grant_token','user_id'], 'required'],
            [['expiry_date', 'created_at'], 'safe'],
            [['is_refresh_token', 'user_id'], 'integer'],
            [['grant_token'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grant_token' => 'Grant Token',
            'expiry_date' => 'Expiry Date',
            'is_refresh_token' => 'Is Refresh Token',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
