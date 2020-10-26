<?php

use buttflattery\formwizard\FormWizard;
use common\models\categories\MainCategory;
use common\models\translation\SubCategoryLanguage;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\categories\SubCategory */
/* @var $modelAr SubCategoryLanguage */

$this->title = Yii::t('app', 'Create Sub Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sub Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$steps = [
    [
        'model' => $model,
        'title' => "Sub Category",
        'description' => false,
        'formInfoText' => false,
        'fieldConfig' => [
            "slug" => false,
            "created_at" => false,
            "updated_at" => false,
            'status' => false,
            'main_category_id' => [
                'widget' => Select2::class,
                'options' => [
                    'data' => ArrayHelper::map(MainCategory::find()->all(), 'id', 'name'),
                ],
            ]
        ]
    ], [
        'model' => $modelAr,
        'title' => "Sub Category Arabic",
        'description' => false,
        'formInfoText' => false,
        'fieldConfig' => [
            "sub_category_id" => false,
            "language" => false,
            "created_at" => false,
            "updated_at" => false,
        ]
    ],
];
?>
<div class="sub-category-create">

    <h1><?=Html::encode($this->title)?></h1>

    <?=FormWizard::widget([
        'steps' => $steps,
        'theme' => FormWizard::THEME_ARROWS,
    ]);?>

</div>
