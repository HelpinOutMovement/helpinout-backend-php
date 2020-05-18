<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>


<div class="request-view">


<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'User Name',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => function($model) {
//                                    return $model->first_name != null ? $model->user : '-';
                return Html::a($model->app_user_id != null ? $model->app_user->first_name : '-');
            }
        ],
        [
            'attribute' => 'Self Else',
            'enableSorting' => false,
            'format' => 'raw',
//                                'header' => 'App Version',
            'value' => function($model) {
                if ($model->self_else == '1') {
                    return "Self";
                } elseif ($model->self_else) {
                    return "Offer";
                } else {
                    return "";
                }
            }
        ],
        [
            'attribute' => 'master_category_id',
            'contentOptions' => ['style' => 'width: 10%'],
            'enableSorting' => false,
            'format' => 'raw',
            'value' => function($model) {
                if ($model->master_category_id == 0) {
                    return "Others";
                } elseif ($model->master_category_id == 9) {
                    return 'Others';
                } else {
                    return $model->master_category_id != null ? $model->category->category_name : '';
                }
            }
        ],
        [
            'attribute' => 'Lat , Lng',
            'enableSorting' => false,
            'format' => 'raw',
//                                'header' => 'App Version',
            'value' => function($model) {
                return $model->lat != null ? $model->lat . ',' . $model->lng : '';
            }
        ],
        [
            'attribute' => 'payment',
            'enableSorting' => false,
            'format' => 'raw',
//                                'header' => 'App Version',
            'value' => function($model) {
                return $model->payment != null ? $model->payment : '0';
            }
        ],
        [
            'attribute' => 'Created At',
            'enableSorting' => false,
            'format' => 'raw',
//                                'header' => 'App Version',
            'value' => function($model) {
                return $model->created_at != null ? date("d-m-Y H:m:s", $model->created_at) : '00-00-0000 00:00:00';
            }
        ],
        [
            'attribute' => 'Status ',
            'enableSorting' => false,
            'format' => 'raw',
//                                'header' => 'App Version',
            'value' => function($model) {
                if ($model->status == '1') {
                    return "<p class='active'> Active</p>";
                } else {
                    return "<p class='inactive'>Inactive</p>";
                }
            }
        ],
    ],
])
?>

</div>
