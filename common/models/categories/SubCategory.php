<?php

namespace common\models\categories;

use common\components\StringHelper;
use common\helper\Constants;
use common\models\ActiveRecord;
use common\models\item\Item;
use common\models\translation\SubCategoryLanguage;
use omgdef\multilingual\MultilingualBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "sub_category".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $main_category_id
 * @property string|null $status
 * @property string|null $slug
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Item[] $items
 * @property MainCategory $mainCategory
 * @property SubCategoryLanguage[] $subCategoryLanguages
 */
class SubCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_category';
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

    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params[Constants::LANGUAGES],
                'languageField' => 'language',
                'dynamicLangClass' => true,
                'langClassName' => SubCategoryLanguage::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => 'en-US',
                'langForeignKey' => 'sub_category_id',
                'tableName' => "{{%sub_category_language}}",
                'attributes' => [
                    'name',
                    'description'
                ]
            ],
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' =>
                    'slug',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'main_category_id', 'status'], 'required'],
            [['main_category_id'], 'integer'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'description', 'slug'], 'string', 'max' => 255],
            [['main_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategory::className(), 'targetAttribute' => ['main_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'main_category_id' => Yii::t('app', 'Main Category Name'),
            'status' => Yii::t('app', 'Status'),
            'slug' => Yii::t('app', 'Slug'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['sub_category_id' => 'id']);
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

    /**
     * Gets query for [[SubCategoryLanguages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategoryLanguages()
    {
        return $this->hasMany(SubCategoryLanguage::className(), ['sub_category_id' => 'id']);
    }

    public function getSlugName()
    {

        if (isset($this->slug) || empty($this->slug) || $this->slug == "") {
            $lang = Yii::$app->language;
            Yii::$app->language = "en-US";
            $tempCategory = SubCategory::findOne($this->id);
            $this->name = $tempCategory->name;
            $this->description = $tempCategory->description;

            $this->slug = StringHelper::slug($this->name);

            if (!$this->save()) {
                $tempSlug = StringHelper::slug($this->name, '--'); // remove multiple --
                $this->slug = $tempSlug;
                $this->save();
            }
            Yii::$app->language = $lang;
        }

        return $this->slug;
    }

    public function getRoute()
    {
        return ['sub-category/index', 'slug' => $this->getSlugName()];
    }

    public function getItemIndexUrl()
    {
        return Url::to($this->getRoute());
    }
}
