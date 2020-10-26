<?php

use common\models\translation\ItemLanguage;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ItemLanguage */
/* @var $form yii\widgets\ActiveForm */

$itemName = $model->item->name;
$this->title = "Mange ( $itemName ) Translations";
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $itemName, 'url' => ['view', 'id' => $model->item_id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="item-category-translations-form col-sm-4 col-lg-6">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, "language")->hiddenInput()->label(false)?>

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'description')->textInput(['maxlength' => true])?>

    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end(); ?>
</div>