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

$this->title = 'Offer Helps';
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
                                            <div class="text-left"><?php echo $this->render('_search', ['model' => $searchModel]);  ?></div>
                                        </div>

                </div>
            </div>
            <div class="box-body">


                <div class="col-md-12">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summaryOptions' => ['class' => 'summary col-sm-6 dataTables_info'],
                        'layout' => "{items}\n{summary}{pager}",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%']],
                            
                            [
                                'attribute' => 'master_category_id',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                 'value' => function($model) {
                                    return $model->master_category_id != null ? $model->category->category_name : '-';
                                }
                            ],
                            [
                                'attribute' => 'no_of_items',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->no_of_items != null ? $model->no_of_items : '-';
                                }
                            ],
//                           
                            [
                                'attribute' => 'lat',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->lat != null ? $model->lat : '-';
                                }
                            ],
                            [
                                'attribute' => 'lng',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->lng != null ? $model->lng : '-';
                                }
                            ],
                            
                            [
                                'attribute' => 'payment',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->payment != null ? $model->payment : '-';
                                }
                            ],
                           
                            [
                                'attribute' => 'offer_condition',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->offer_condition != null ? $model->offer_condition : '-';
                                }
                            ],
                            [
                                'attribute' => 'Date ',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->datetime != null ?date("d-m-Y",strtotime($model->datetime)) : '-';
                                }
                            ],
                            [
                                'attribute' => 'time_zone_offset',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->time_zone_offset != null ? $model->time_zone_offset : '-';
                                }
                            ],
                                     [
                                'attribute' => 'status',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    if($model->status)
                                    {
                                        return "Active";
                                    }
                                    else
                                    {
                                        return "Inactive";
                                    }
                                    }
                            ],
//                            [
//                                'header' => Yii::t('user', ''),
//                                'contentOptions' => ['style' => 'width: 6%'],
//                                'value' => function ($model) {
//
//                                    return Html::button(Yii::t('user', '<span class="fa fa-info"></span> Detail'), ['value' => Url::to('/admin/apilog/requestbody?id=' . $model->id), 'class' => 'btn btn-xs btn-info btn-block reqmodel']);
//                                },
//                                'format' => 'raw',
//                            ],
//                                [
//                                    'attribute' => 'request_body',
//                                    'enableSorting' => false,
//                                    'format' => 'raw',
//                                ],
                        //'created_at',
                        ],
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>


