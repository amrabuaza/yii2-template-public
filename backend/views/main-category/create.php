<?php

use buttflattery\formwizard\FormWizard;
use common\models\categories\MainCategory;
use common\models\translation\MainCategoryLanguage;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model MainCategory */

/* @var $this yii\web\View */
/* @var $modelAr MainCategoryLanguage */

$this->title = Yii::t('app', 'Create Main Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Main Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$steps = [
    [
        'model' => $model,
        'title' => "Main Category",
        'description' => false,
        'formInfoText' => false,
        'fieldConfig' => [
            "slug" => false,
            "name_ar" => false,
            "description_ar" => false,
            "created_at" => false,
            "updated_at" => false,
            'status' => false
        ]
    ], [
        'model' => $modelAr,
        'title' => "Main Category Arabic",
        'description' => false,
        'formInfoText' => false,
        'fieldConfig' => [
            "main_category_id" => false,
            "language" => false,
            "created_at" => false,
            "updated_at" => false,
        ]
    ],
];
?>
<div class="main-category-create">

    <h1><?=Html::encode($this->title)?></h1>

    <?=FormWizard::widget([
        'steps' => $steps,
        'theme' => FormWizard::THEME_ARROWS,
    ]);?>

</div>
