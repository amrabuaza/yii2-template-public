<?php

use common\models\translation\SubCategoryLanguage;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SubCategoryLanguage */
/* @var $form yii\widgets\ActiveForm */

$categoryName = $model->subCategory->name;
$this->title = "Mange ( $categoryName ) Translations";
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $categoryName, 'url' => ['view', 'id' => $model->sub_category_id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="sub-category-translations-form col-sm-4 col-lg-6">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, "language")->hiddenInput()->label(false)?>

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'description')->textInput(['maxlength' => true])?>

    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end(); ?>
</div>