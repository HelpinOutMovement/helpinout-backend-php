<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */




$this->title = 'Manage App Users';

$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'fa fa-user';
$js = <<<JS
$(function () {
   
    $('.appmodel').click(function(){
        $('#appmodel').modal('show')
         .find('#appcontent')
         .load($(this).attr('value'));
     });  
});        


        
JS;
$this->registerJs($js);
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
   
    $('.appmodel').click(function(){
        $('#appmodel').modal('show')
         .find('#appcontent')
         .load($(this).attr('value'));
     });  
});        


        
JS;
$this->registerJs($js);
?>
<div class="row">
    <div class="card-bg" style="display:flex;">
        <div class="col-md-12">
            <div class="box box-info">

                <div class="box-body"> 
                    <div class="form-group top-form">
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>  
                </div>
            </div>
        </div> 
    </div>
</div>   
<div class="row">
    <div class="col-md-12">
        <div class="card-bg">
            <div class="box box-info">
                <div class="box-header grade-bg">
                    <div class="box-title"> <strong><?php echo $this->title; ?>:-</strong> </div>
                </div>
                <div class="box-body">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-hover table-striped table-bordered'],
                        'id' => 'grid-data',
                        'headerRowOptions' => ['style' => 'background-color:silver'],
                        //  'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        //    'pjax' => TRUE,
//                                'floatHeader' => true,
//                                'floatHeaderOptions' => ['scrollingTop' => '5'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'name',
                                'enableSorting' => false,
                                'label' => 'Name',
                                'format' => 'html',
                                'value' => function($model) {

                                    $url = Url::to(["/admin/apilog/index?" . "user_id=$model->id"]);

                                    return Html::a($model->name, $url, ['data-pjax' => "0"]);
                                    // return $model->name != null ? $model->name : '-';
                                }
                            ],
                            [
                                'attribute' => 'email',
                                'enableSorting' => false,
                                'label' => 'Email Id',
                                'value' => function($model) {

                                    return $model->email != null ? $model->email : '-';
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'enableSorting' => false,
                                'label' => 'Mobile No.',
                                'value' => function($model) {

                                    return $model->mobile_no != null ? $model->mobile_no : '-';
                                }
                            ],
                            [
                                'attribute' => 'role_id',
                                'enableSorting' => false,
                                'label' => 'Role',
                                'value' => function($model) {

                                    return $model->role != null ? $model->role->role_name : '-';
                                }
                            ],
                             [
                                'attribute' => 'role_id',
                                'enableSorting' => false,
                                'label' => 'App Id',
                                'value' => function($model) {
                                    $app_model = \app\models\AppDetail::find()->where(['user_id'=> $model->id])->orderBy(['date_of_install' => SORT_DESC])->one();
                                    
                                    return $app_model != null ? $app_model->app_version : '-';
                                }
                            ],
                                    [
                                'attribute' => 'role_id',
                                'enableSorting' => false,
                                'label' => 'Last Installed On',
                                'value' => function($model) {

                                    $app_model = \app\models\AppDetail::find()->where(['user_id'=> $model->id])->orderBy(['date_of_install' => SORT_DESC])->one();
                                    return $app_model != null ? $app_model->date_of_install : '-';
                                }
                            ],
                            [
                                'header' => Yii::t('user', ''),
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'value' => function ($model) {

                                    return Html::button(Yii::t('user', '<span class="fa fa-info-circle"></span> App Detail'), ['value' => Url::to('appdetail?id=' . $model->id), 'class' => 'btn btn-xs btn-default btn-block appmodel']);
                                },
                                'format' => 'raw',
                            ],
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
    'header' => 'App Detail',
    'id' => 'appmodel',
    'size' => 'modal-lg'
]);
echo "<div id='appcontent'></div>";
Modal::end();
?>
<?php Pjax::end(); ?>
