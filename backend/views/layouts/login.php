<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="login-page">

    <?php $this->beginBody() ?>

    <?= $content ?>
    <?php
    if (class_exists('yii\debug\Module')) {
        $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
    }
    ?>
    <?php $this->endBody() ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>