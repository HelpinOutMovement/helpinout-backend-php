        
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

$this->title = 'App Users';
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
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%']],
                            [
                                'attribute' => 'User Name',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
//                                    return $model->first_name != null ? $model->user : '-';
                                    return Html::a($model->first_name != null ? $model->username : '-', ['/report/appuser/detail?id=' . $model->id], ['data-pjax' => "0", 'class' => 'underlinelink']);
                                }
                            ],
                            [
                                'attribute' => 'Country Code',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
                                    return $model->country_code != null ? $model->country_code : '-';
                                }
                            ],
                            [
                                'attribute' => 'Mobile No.',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
                                    return $model->mobile_no != null ? $model->mobile_no : '-';
                                }
                            ],
                            [
                                'attribute' => 'Mobile Visibility',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
                                    if ($model->mobile_no_visibility == '1') {
                                        return "Visible";
                                    } else {
                                        return "Invisible";
                                    }
                                }
                            ],
                            [
                                'attribute' => 'User Type',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->user_type == 1) {
                                        return "Individual";
                                    } else {
                                        return "Organization";
                                    }
                                }
                            ],
                            [
                                'attribute' => 'org_name',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->org_name != null ? $model->org_name : '-';
                                }
                            ],
                            [
                                'attribute' => 'org_division',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->org_division != null ? $model->org_division : '-';
                                }
                            ],
                            [
                                'attribute' => 'master_app_user_org_type',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->master_app_user_org_type != null ? $model->appuserorgtype->org_type : '-';
                                }
                            ],
                            [
                                'attribute' => 'time_zone',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'time_zone_offset',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'status',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->status == '1') {
                                        return "Active";
                                    } else {
                                        return "Inactive";
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
                                        return Html::a('Make Inactive', ['/report/appuser/inactive?id=' . $model->id], ['data-pjax' => "0", 'class' => 'btn btn-xs btn-default btn-danger', 'data-confirm' => 'are you sure to inactive this ? ']) . '';

//                           
                                    } else {
                                        return Html::a('Make Active', ['/report/appuser/active?id=' . $model->id], ['data-pjax' => "0", 'class' => 'btn btn-xs btn-default btn-primary', 'data-confirm' => 'are you sure to active this ?']) . '';

//                           
                                    }
                                }
                            ],
//                         
//                            
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
/*    .underlinelink
    {
        color:#000;
    }*/
</style>