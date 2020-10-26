<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use borales\extensions\phoneInput\PhoneInput;
use common\helper\Constants;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t(Constants::APP, 'signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?=Html::encode($this->title)?></h1>


    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?=$form->field($model, 'username')->textInput(['autofocus' => true])?>

            <?=$form->field($model, 'email')?>

            <?=$form
                ->field($model, 'phone_number')
                ->widget(PhoneInput::classname(), [
                    'jsOptions' => [
                        'class' => 'phone-number-input',
                    ],
                ])?>

            <?=$form->field($model, 'password')->passwordInput()?>

            <div class="form-group">
                <?=Html::submitButton(Yii::t(Constants::APP, 'signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button'])?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="flex-middle">
    <a href="/site/auth?authclient=facebook" class="facebook-btn">
        <?=Yii::t(
            Constants::APP,
            'login facebook'
        )?> </a>
</div>