<?php

namespace common\models\translation;

use common\models\ActiveRecord;
use common\models\categories\SubCategory;
use Yii;

/**
 * This is the model class for table "sub_category_language".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $sub_category_id
 * @property string $language
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property SubCategory $subCategory
 */
class SubCategoryLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_category_language';
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
            [['name', 'description', 'sub_category_id', 'language'], 'required'],
            [['sub_category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'description', 'language'], 'string', 'max' => 255],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategory::className(), 'targetAttribute' => ['sub_category_id' => 'id']],
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
            'sub_category_id' => 'Sub Category ID',
            'language' => 'Language',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[SubCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategory()
    {
        return $this->hasOne(SubCategory::className(), ['id' => 'sub_category_id']);
    }
}
