<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
Yii::$app->language="en";
?>
<div class="site-index">

    <?=Yii::t("app", 'login')?>
    <?=Yii::t("app", 'signup')?>
    <?=Yii::t("app", 'contact')?>
    <?=Yii::t("app", 'about')?>
    <?=Yii::t("app", 'username')?>

</div>
