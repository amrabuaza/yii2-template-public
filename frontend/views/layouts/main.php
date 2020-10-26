<?php

/* @var $this View */

/* @var $content string */

use common\helper\Constants;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$this->registerJsVar('isGuest', Yii::$app->user->isGuest);
$this->registerJsVar('user_id', Yii::$app->user->id);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->language == "en") {
        $langURl = '/site/language?lang=ar';
    } else {
        $langURl = '/site/language?lang=en';
    }

    $menuItems = [
        ['label' => Yii::$app->language == "en" ? "العربية" : "English", 'url' => [$langURl]],
        ['label' => Yii::t(Constants::APP, 'about'), 'url' => ['/site/about']],
        ['label' => Yii::t(Constants::APP, 'contact'), 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t(Constants::APP, 'signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t(Constants::APP, 'login'), 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::t(Constants::APP, 'logout'),
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?=Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])?>
        <?=Alert::widget()?>
        <div class="box rel">
            <h2 class="mb32 ls100 uppercase bold f16_15_14 fg-999 center">
                <?=Html::encode($this->title)?>
            </h2>
            <div>
                <?=$content?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?=Html::encode(Yii::$app->name)?> <?=date('Y')?></p>

        <p class="pull-right"><?=Yii::powered()?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
