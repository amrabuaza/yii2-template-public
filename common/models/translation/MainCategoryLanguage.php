<?php

namespace common\models\translation;

use common\models\ActiveRecord;
use common\models\categories\MainCategory;
use Yii;

/**
 * This is the model class for table "main_category_language".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $main_category_id
 * @property string $language
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property MainCategory $mainCategory
 */
class MainCategoryLanguage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_category_language';
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
            [['name', 'description', 'main_category_id', 'language'], 'required'],
            [['main_category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'description', 'language'], 'string', 'max' => 255],
            [['main_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategory::className(), 'targetAttribute' => ['main_category_id' => 'id']],
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
            'main_category_id' => 'Main Category ID',
            'language' => 'Language',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[MainCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMainCategory()
    {
        return $this->hasOne(MainCategory::className(), ['id' => 'main_category_id']);
    }


}
