<?php

namespace common\models\item;

use common\components\StringHelper;
use common\helper\Constants;
use common\models\ActiveRecord;
use common\models\categories\SubCategory;
use common\models\translation\ItemLanguage;
use omgdef\multilingual\MultilingualBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string|null $has_offer
 * @property float|null $price_after_sale
 * @property string|null $status
 * @property string|null $slug
 * @property int $sub_category_id
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property SubCategory $subCategory
 * @property ItemLanguage[] $itemLanguages
 */
class Item extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
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
                'langClassName' => ItemLanguage::className(),
                'defaultLanguage' => 'en-US',
                'langForeignKey' => 'item_id',
                'tableName' => "{{%item_language}}",
                'attributes' => [
                    'name',
                    'description'
                ]
            ], TimestampBehavior::className(),
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
            [['name', 'description', 'price', 'sub_category_id', 'status'], 'required'],
            [['price', 'price_after_sale'], 'number'],
            [['has_offer', 'status'], 'string'],
            [['sub_category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'description', 'slug'], 'string', 'max' => 255],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategory::className(), 'targetAttribute' => ['sub_category_id' => 'id']],
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
            'price' => Yii::t('app', 'Price'),
            'price_after_sale' => Yii::t('app', 'Price After Sale'),
            'has_offer' => Yii::t('app', 'Has Offer'),
            'status' => Yii::t('app', 'Status'),
            'slug' => Yii::t('app', 'Slug'),
            'sub_category_id' => Yii::t('app', 'Sub Category'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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

    /**
     * Gets query for [[ItemLanguages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemLanguages()
    {
        return $this->hasMany(ItemLanguage::className(), ['item_id' => 'id']);
    }

    public function getSlugName()
    {

        if (isset($this->slug) || empty($this->slug) || $this->slug == "") {
            $lang = Yii::$app->language;
            Yii::$app->language = "en-US";
            $tempItem = Item::findOne($this->id);
            $this->name = $tempItem->name;
            $this->description = $tempItem->description;

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
        return ['item/view', 'slug' => $this->getSlugName()];
    }

    public function getItemIndexUrl()
    {
        return Url::to($this->getRoute());
    }
}
