<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */




$this->title = 'Detail';

$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    <div class="col-md-12">
        <div class="card-bg">
            <div class="box box-info">

                <div class="box-body">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-hover table-striped table-bordered'],
                        'id' => 'grid-data',
                        'headerRowOptions' => ['style' => 'background-color:silver'],
                        'columns' => [
                            [
                                'attribute' => 'id',
                                'enableSorting' => false,
                                'header' => 'App Id',
                                'format' => 'raw',
                                'value' => function($model) {

                                    $url = Url::to(["/admin/apilog/index?" . "id=$model->id"]);

                                    return Html::a($model->id, $url, ['data-pjax' => "0"]);
                                }
                            ],
//                                    [
//                                        'attribute' => 'user_id',
//                                        'enableSorting' => false,
//                                        'format' => 'raw',
//                                        'value' => function($model) {
//                                            return $model->user != null ? $model->user->username : '-';
//                                        }
//                                    ],
//                                     [
//                                        'attribute' => 'user_id',
//                                        'enableSorting' => false,
//                                          'header' => 'User Id',
//                                        'format' => 'raw',
//                                        'value' => function($model) {
//                                            return $model->user_id != null ? $model->user_id : '-';
//                                        }
//                                    ],       
                            [
                                'attribute' => 'imei_no',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
//                                    [
//                                        'attribute' => 'os_type',
//                                        'enableSorting' => false,
//                                        'format' => 'raw',
//                                    ],
                            [
                                'attribute' => 'manufacturer_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'os_version',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'app_version',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'date_of_install',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'date_of_uninstall',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->date_of_uninstall != null ? $model->date_of_uninstall : '-';
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->status == 1 ? 'Active' : 'Not Active';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['style' => 'width: 10%;'],
                                'template' => '<div>{update}</div>',
                                'header' => '',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        if ($model->status == '1') {
                                            return Html::a('<span class="fa fa-power-off" style="color:red;"></span>', ['/admin/appusers/delete', 'id' => $model->id], [
                                                        //  'title' => Yii::t('app', 'Edit'),
                                                        'class' => '',
                                                        'data-pjax' => "0",
                                                        'class' => 'btn btn-sm btn-default',
                                            ]);
                                        } else {
                                            return Html::a('<span class="fa fa-power-off"></span>', ['/admin/appusers/delete', 'id' => $model->id], [
                                                        //   'title' => Yii::t('app', 'Edit'),
                                                        'class' => '',
                                                        'data-pjax' => "0",
                                                        'class' => 'btn btn-sm btn-default',
                                            ]);
                                        }
                                    },
                                ]
                            ],
                        ],
                    ]);
                    ?>


                </div>
            </div>
        </div> 
    </div>
</div>       

