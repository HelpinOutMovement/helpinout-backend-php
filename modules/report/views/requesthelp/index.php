<?php

use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\GeneralModel;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApiLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request Helps';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="row">
    <div class="col-md-12">

        <div class="box card-2" style="border-radius:10px;">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-left">
                            <i class="fa fa-calendar" style="font-size:20px;color:red"></i> <span style="font-size:20px;color:maroon"><?= Html::encode($this->title) ?></span>
                        </div>
                    </div>

                </div><br/>
                <div class="row">
                    <div class="col-md-10">
                        <div class="text-left"><?php echo $this->render('_search', ['model' => $searchModel]); ?></div>
                    </div>

                </div>
            </div>
            <div class="box-body">


                <div class="col-md-12">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                       'layout' => "{pager}\n{summary}\n{items}",
                        'tableOptions' => ['class' => 'table table-hover'],
                        'columns' => [
//                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%']],
                            [
                                'attribute' => 'id',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::a($model->id != null ? $model->id : '',['/report/requesthelp/requestdetail?request_id=' . $model->id], ['data-pjax' => "0", 'class' => 'underlinelink']);
                                }
                            ],
                            [
                                'attribute' => 'User Detail',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::a($model->app_user_id != null ? $model->app_user->first_name.' '.$model->app_user->last_name.'<br>('.$model->app_user->country_code.$model->app_user->mobile_no.')' : '',['/report/appuser/detail?id=' . $model->app_user_id], ['data-pjax' => "0", 'class' => 'underlinelink']);
                                }
                            ],
                                    [
                                'attribute' => 'Offer Mapped By Me',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->id != null ? $model->mappingoffer:'';
                                }
                            ],
                                    [
                                'attribute' => 'Offer Recieved',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                     return $model->id != null ? $model->mappingrequest:'';
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
//                            [
//                                'attribute' => 'no_of_items',
//                                'enableSorting' => false,
//                                'format' => 'raw',
////                                'header' => 'App Version',
//                                'value' => function($model) {
//                                    return $model->no_of_items != null ? $model->no_of_items : '';
//                                }
//                            ],
                            [
                                'attribute' => 'Detail',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {

                                    if ($model->master_category_id == 2) {
                                        return '';
                                    } else if ($model->master_category_id == 7) {
                                        return '';
                                    } elseif (is_array($model->activity_detail) || is_object($model->activity_detail)) {
                                        $html = '<ul>';
                                        foreach ($model->activity_detail as $detail) {
                                            $html .= '<li>' . $detail->detail != null ? $detail->detail . ' (' . $detail->quantity . ')' . '<br>' : '' . "</li>";
//                                      
                                        }
                                        $html .= "</ul>";
                                        return $html;
                                    } else {
                                        return '';
                                    }
                                }
//                                    
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
//                            [
//                                'attribute' => 'User DateTime ',
//                                'enableSorting' => false,
//                                'format' => 'raw',
////                                'header' => 'App Version',
//                                'value' => function($model) {
//                                    return $model->datetime != null ? date("d-m-Y H:m:s", strtotime($model->datetime)) : '';
//                                }
//                            ],
//                            [
//                                'attribute' => 'User Time Zone Offset',
//                                'enableSorting' => false,
//                                'format' => 'raw',
////                                'header' => 'App Version',
//                                'value' => function($model) {
//                                    return $model->time_zone_offset != null ? $model->time_zone_offset : '00-00-0000 00:00:00';
//                                }
//                            ],
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
                            [
                                'attribute' => 'Action',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    if ($model->status) {
                                        return Html::a('Make Inactive', ['/report/requesthelp/inactive?id=' . $model->id], ['data-pjax' => "0", 'class' => 'btn btn-xs btn-default btn-danger', 'data-confirm' => 'are you sure to inactive this ? ']) . '';

//                           
                                    } else {
                                        return Html::a('Make Active', ['/report/requesthelp/active?id=' . $model->id], ['data-pjax' => "0", 'class' => 'btn btn-xs btn-default btn-primary', 'data-confirm' => 'are you sure to active this ?']) . '';

//                           
                                    }
                                }
                            ],
                        ],
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /*    .active{
            color:rgb(0, 255, 0);
        }
        .inactive{
            color:rgb(0, 255, 0);
        }*/
    .btn-primary
    {
        color:#fff;
    }
    .btn-danger
    {
        color:#fff;
    }
</style>
