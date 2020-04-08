<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItiListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mail Log';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
<div class="row" style="margin-top:-20px;">
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
                    <div class="box-title"> <strong><?php echo $this->title; ?></strong> </div>
                </div>
                <div class="box-body">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'to_email_id',
                            [
                                'attribute' => 'model',
                                'enableSorting' => false,
                                'label' => 'ITI Code',
                                'contentOptions' => ['style' => 'width: 13%', 'class' => 'school'],
                                'value' => function($model) {
                                    return $model->model != null ? $model->model : '-';
                                    // $query = \app\models\ItiList::find()->where("(verified_email='".$model->to_email_id."' or new_email='".$model->to_email_id."')")->one();
                                    //return  $query->code; 
                                }
                            ],
                            'subject',
                            'template',
                            [
                                'attribute' => 'created_at',
                                'enableSorting' => false,
                                'label' => 'Date & Time',
                                'contentOptions' => ['style' => 'width: 13%', 'class' => 'school'],
                                'value' => function($model) {

                                    return date('Y-m-d H:i:s', $model->created_at);
                                }
                            ],
                            'status',
                        ],
                    ]);
                    ?>

                </div>
            </div>
        </div>  
    </div>
</div>       
<?php Pjax::end(); ?>


