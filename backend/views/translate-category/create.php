<?php

use common\lib\i18nModule\models\TranslateCategory;
use common\lib\i18nModule\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model TranslateCategory */

$this->title = Module::t('Create Category Translation');
$this->params['breadcrumbs'][] = ['label' => 'Category Translation', 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('Create');
?>
<div class="element-box source-message-update  box box-primary">

    <div class="box-body table-responsive">
        <h1><?=Html::encode($this->title)?></h1>

        <div class="source-message-form">

            <?php $form = ActiveForm::begin(); ?>

            <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

            <div class="form-group">
                <?=Html::submitButton(Module::t('Create'), ['class' => 'btn btn-primary'])?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
