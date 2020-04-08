<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\GeneralModel;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AppDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'App Details';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'fa fa-history';
?>
<div class="app-detail-index">

    <?php
    Pjax::begin([
        'id' => 'grid-data',
        'enablePushState' => FALSE,
        'enableReplaceState' => FALSE,
        'timeout' => false,
    ]);
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
<!--                    <div class="col-md-10">
                        <div class="text-left"><?php //echo $this->render('_search', ['model' => $searchModel]); ?></div>
                    </div>-->
                   
                </div>
            </div>
            <div class="box-body">


                <div class="col-md-12">

              <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => "{items}\n{pager}\n{summary}",
                                'tableOptions' => ['class' => 'table table-hover table-striped table-bordered'],
                                'id' => 'grid-data',
                                'headerRowOptions' => ['style' => 'background-color:silver'],
                                //  'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                'pjax' => TRUE,
//                                'floatHeader' => true,
//                                'floatHeaderOptions' => ['scrollingTop' => '5'],
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
//                                            $url = Url::to(["/admin/apilog/index?user_id=" . $model->user->id]);
//
//                                            return Html::a($model->user->email, $url, ['data-pjax' => "0"]);
//                                            //  return $model->user != null ? $model->user->username : '-';
//                                        }
//                                    ],
//                                     [
//                                        'attribute' => 'user_id',
//                                        'enableSorting' => false,
//                                          'header' => 'User Id',
//                                        'format' => 'raw',
//                                        'value' => function($model) {
//                                           
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
//                                    [
//                                        'attribute' => 'date_of_uninstall',
//                                        'enableSorting' => false,
//                                        'header' => 'No. Of Forms Saved',
//                                        'format' => 'html',
//                                        'value' => function($model) {
//                                            //   return $total = \app\models\ApiLog::find()->where(['app_id'=>$model->id,'request_url'=>'api/v1/iti/formsave'])->count();
//                                            return $success = \app\models\ApiLog::find()->where(['app_id' => $model->id, 'request_url' => 'api/v1/iti/formsave', 'http_response_code' => 200])->count();
//
//                                            //return '<table class="table table-striped table-bordered"><tr class="even"><td>Total</td><td>'.$total.'</td></tr><tr><td>Success</td><td>'.$success.'</td></tr></table>';
//                                        }
//                                    ],
                                    [
                                        'attribute' => 'status',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function($model) {
                                            return $model->status != null ? $model->status : '0';
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
    
    
    
    
    
      