<?php

use common\models\search\CustomerSearch;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'First Name',
                'value' => function ($model, $key, $index, $column) {
                    return $model->info->first_name;
                },
            ], [
                'attribute' => 'Last Name',
                'value' => function ($model, $key, $index, $column) {
                    return $model->info->last_name;
                },
            ], [
                'attribute' => 'Phone Number',
                'value' => function ($model, $key, $index, $column) {
                    return $model->info->phone_number;
                },
            ], [
                'attribute' => 'Email',
                'value' => function ($model, $key, $index, $column) {
                    return $model->info->email;
                },
            ], [
                'attribute' => 'Type',
                'value' => function ($model, $key, $index, $column) {
                    return $model->target;
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => ' {view}',
            ],
        ],
    ]);?>


</div>
