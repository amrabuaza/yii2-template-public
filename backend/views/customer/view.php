<?php

use common\models\user\Customer;
use common\models\user\User;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Customer */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

?>
<div class="user-view">
    <br/>

    <?=DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'First Name',
                'value' => $model->info->first_name
            ], [
                'label' => 'Last Name',
                'value' => $model->info->last_name
            ], [
                'label' => 'Phone Number',
                'value' => $model->info->phone_number
            ], [
                'label' => 'Email',
                'value' => $model->info->email
            ],
            [
                'label' => 'Type',
                'value' => $model->target
            ],

        ],
    ])?>

</div>
