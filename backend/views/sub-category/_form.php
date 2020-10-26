<?php

use common\models\categories\MainCategory;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\categories\SubCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'description')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'main_category_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(MainCategory::find()->all(), 'id', 'name'),
        'language' => 'en-US',
        'options' => ['placeholder' => 'Select a Main Category name ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label("Main Category Name");
    ?>

    <?=$form->field($model, 'status')->dropDownList(['active' => 'Active', 'inactive' => 'Inactive',], ['prompt' => ''])?>

    <div class="form-group">
        <?=Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
