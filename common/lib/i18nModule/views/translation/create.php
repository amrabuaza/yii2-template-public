<?php

use common\lib\i18nModule\models\TranslateCategory;
use common\lib\i18nModule\Module;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\lib\i18nModule\models\SourceMessage */

$this->title = Module::t('Create Translation');
$this->params['breadcrumbs'][] = ['label' => Module::t('Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('Create');
?>
<div class="element-box source-message-update  box box-primary">

    <div class="box-body table-responsive">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="source-message-form">

            <?php $form = ActiveForm::begin(); ?>

            <?=$form->field($model, 'category')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TranslateCategory::find()->all(), 'name', 'name'),
                'language' => 'en-US',
                'options' => ['placeholder' => 'Select a Category name ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label("Category");
            ?>

            <?= $form->field($model, 'message')->textarea() ?>

            <div class="form-group">
                <?= Html::submitButton(Module::t('Update'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
