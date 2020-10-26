<?php

use buttflattery\formwizard\FormWizard;
use common\models\categories\SubCategory;
use common\models\translation\ItemLanguage;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\item\Item */
/* @var $modelAr ItemLanguage */

$this->title = Yii::t('app', 'Create Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$steps = [
    [
        'model' => $model,
        'title' => "Item",
        'description' => false,
        'formInfoText' => false,
        'fieldConfig' => [
            "slug" => false,
            "created_at" => false,
            "updated_at" => false,
            'status' => false,
            'sub_category_id' => [
                'widget' => Select2::class,
                'options' => [
                    'data' => ArrayHelper::map(SubCategory::find()->all(), 'id', 'name'),
                ],
            ],
            'has_offer' => [
                'labelOptions' => [
                    'label' => "Has offer"
                ],
                'options' => [
                    'type' => 'radio',
                    'itemsList' => ["no" => "No", "yes" => "Yes"], // the radio inputs to be created for the radioList
                ]
            ],
        ]
    ], [
        'model' => $modelAr,
        'title' => "Item Arabic",
        'description' => false,
        'formInfoText' => false,
        'fieldConfig' => [
            "item_id" => false,
            "language" => false,
            "created_at" => false,
            "updated_at" => false,
        ]
    ],
];
?>
<div class="item-create">

    <h1><?=Html::encode($this->title)?></h1>

    <?=FormWizard::widget([
        'steps' => $steps,
        'theme' => FormWizard::THEME_ARROWS,
    ]);?>

</div>
