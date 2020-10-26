<?php

use common\lib\i18nModule\models\TranslateCategorySearch;
use common\lib\i18nModule\Module;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel TranslateCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Translate Category";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="element-box box box-primary">

    <div class="box-header with-border">
        <h1><?=Html::encode($this->title)?></h1>
    </div>
    <p>
        <?=Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success'])?>
    </p>
    <div class="table-responsive">
        <?php Pjax::begin(); ?>
        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'name'
            ]
        ]);?>
        <?php Pjax::end(); ?>
    </div>
</div>
