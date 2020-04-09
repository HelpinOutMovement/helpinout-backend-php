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

$this->title = 'Api Logs';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'fa fa-history';
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
?>
<?php
$js = <<<JS
$(function () {
   
        
     $('.reqmodel').click(function(){
        $('#requestmodel').modal('show')
         .find('#requestcontent')
         .load($(this).attr('value'));
     });    
});        

   
JS;
$this->registerJs($js);
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
                <!--<div class="row">-->
                    <!--<div class="col-md-10">-->
                        <!--<div class="text-left">-->
                            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                        <!--</div>-->
                    <!--</div>-->
                   
                <!--</div>-->
            </div>
            <div class="box-body">


                <div class="col-md-12">

             <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-hover'],
                        'id' => 'grid-data',
                        'headerRowOptions' => ['style' => 'background-color:silver'],
//                              'headerRowOptions' => ['style' => 'background-color:silver'],
                        //  'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                        'pjax' => TRUE,
                        // 'floatHeader' => true,
                        // 'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%']],
                            [
                                'attribute' => 'app_id',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    $url = Url::to(["/admin/app-detail/index?" . "id=$model->app_registration_id"]);

                                    return Html::a($model->app_registration_id, $url, ['data-pjax' => "0"]);
                                }
                            ],
//                            [
//                                'attribute' => 'app_user_id',
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'header' => 'User',
//                                'value' => function($model) {
//                                    return $model->appdetail != null ? $model->appdetail->user->email : '-';
//                                }
//                            ],
                            [
                                'attribute' => 'ip',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
//                            [
//                                'attribute' => 'time',
//                                'contentOptions' => ['style' => 'width: 15%'],
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                            ],
                            [
                                'attribute' => 'request_url',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'http_response_code',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'app_id',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->appdetail != null ? $model->appdetail->app_version : '-';
                                }
                            ],
                            [
                                'attribute' => 'response',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->response != null ? $model->response : '-';
                                }
                            ],
                            [
                                'header' => Yii::t('user', ''),
                                'contentOptions' => ['style' => 'width: 6%'],
                                'value' => function ($model) {

                                    return Html::button(Yii::t('user', '<span class="fa fa-info"></span> Detail'), ['value' => Url::to('/admin/apilog/requestbody?id=' . $model->id), 'class' => 'btn btn-xs btn-info btn-block reqmodel']);
                                },
                                'format' => 'raw',
                            ],
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




<?php
Modal::begin([
    'header' => 'Request Body',
    'id' => 'requestmodel',
    'size' => 'modal-lg'
]);
echo "<div id='requestcontent'></div>";
Modal::end();
?>
 <?php Pjax::end() ?>