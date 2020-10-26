<?php

use common\models\categories\SubCategory;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\item\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'description')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'price')->textInput()?>

    <?=$form->field($model, 'has_offer')->dropDownList(['yes' => 'Yes', 'no' => 'No',], ['prompt' => ''])?>

    <?=$form->field($model, 'status')->dropDownList(['active' => 'Active', 'inactive' => 'Inactive',], ['prompt' => ''])?>

    <?=$form->field($model, 'sub_category_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(SubCategory::find()->all(), 'id', 'name'),
        'language' => 'en-US',
        'options' => ['placeholder' => 'Select a Sub Category name ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label("Sub Category Name");
    ?>
    <div class="form-group">
        <?=Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
