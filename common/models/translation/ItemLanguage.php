<?php

namespace common\models\translation;

use common\models\ActiveRecord;
use common\models\item\Item;
use Yii;

/**
 * This is the model class for table "item_language".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $item_id
 * @property string $language
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Item $item
 */
class ItemLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_language';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$this->isNewRecord) {
                $this->updated_at = date("Y-m-d H:i:s");
            } else if ($this->isNewRecord) {
                $this->created_at = date("Y-m-d H:i:s");
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'item_id', 'language'], 'required'],
            [['item_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'description', 'language'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'item_id' => 'Item ID',
            'language' => 'Language',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}
