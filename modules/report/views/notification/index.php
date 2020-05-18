<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$js = <<<JS
      

$(function () {
   
        
     $('.qsrejectmodel').click(function(){
        $('#itimodel').modal('show')
         .find('#iticontent')
         .load($(this).attr('value'));
     });    
});   
    
        $(function () {
   
        
     $('.offermodel').click(function(){
        $('#itimodels').modal('show')
         .find('#iticontents')
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
                <div class="row">
                    <div class="col-md-10">
                        <div class="text-left"><?= $this->render('_search', ['model' => $searchModel]); ?></div>
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
                                    return ($model->app_user_id != null ? $model->app_user->first_name . ' ' . $model->app_user->last_name : '-' );
                                }
                            ],
                            [
                                'attribute' => 'Activity Type',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
                                    if ($model->activity_type == '1') {
                                        return "Request";
                                    } else {
                                        return "Offer";
                                    }
                                }
                            ],
                            [
                                'attribute' => 'Master Category',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
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
                                'attribute' => 'Request Help',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
//                                    return $model->request_help_id;
                                    return Html::button(Yii::t('user', 'View Request Help'), ['value' => Url::to('/report/notification/requesthelp?request_help_id=' . $model->request_help_id), 'class' => 'btn btn-xs btn-default btn-block qsrejectmodel']);
                                }
                            ],
                            [
                                'attribute' => 'Offer Help',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Html::button(Yii::t('user', 'View Offer Help'), ['value' => Url::to('/report/notification/offerhelp?offer_help_id=' . $model->offer_help_id), 'class' => 'btn btn-xs btn-default btn-block offermodel']);
                                }
                            ],
                            [
                                'attribute' => 'action',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    if ($model->action == '1') {
                                        return " <span class='label label-info'>Request Received</span>";
                                    } else if ($model->action == '2') {
                                        return "<span class='label label-success'>Offer Received</span>";
                                    } elseif ($model->action == '3') {
                                        return "<span class='label label-warning'>Request cancelled</span>";
                                    } else {
                                        return "<span class='label label-danger'>Offer Cancelled</span>";
                                    }
                                }
                            ],
                            [
                                'attribute' => 'DateTime',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->created_at != null ? date("d-m-Y H:m:s", $model->created_at) : '00-00-0000 00:00:00';
                                }
                            ],
//                            [
//                                'attribute' => 'Last Updated At',
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'value' => function($model) {
//                                    return $model->created_at != null ? date("d-m-Y H:m:s", $model->updated_at) : '00-00-0000 00:00:00';
//                                }
//                            ],
                            [
                                'attribute' => 'status',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    if ($model->status == '-1') {
                                        return "<span class='label label-danger'>Delete</span>";
                                    } else if ($model->status == '0') {
                                        return "<span class='label label-warning'>Error</span>";
                                    } elseif ($model->status == '1') {
                                        return "";
                                    } else {
                                        return "<span class='label label-success'>Success</span>";
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


<?php
Modal::begin([
    'id' => 'itimodel',
    'size' => 'modal-md'
]);
echo "<div id='iticontent'></div>";
Modal::end();
?>

<?php
Modal::begin([
    'id' => 'itimodels',
    'size' => 'modal-md'
]);
echo "<div id='iticontents'></div>";
Modal::end();
?>