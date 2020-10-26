<?php

namespace common\lib\i18nModule\models;

/**
 * This is the model class for table "translate_category".
 *
 * @property int $id
 * @property string $name
 *
 */
class TranslateCategory extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translate_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
        ];
    }

    public static function create($name)
    {
        $model = new TranslateCategory();
        $model->name = $name;
        $model->save();
    }

}