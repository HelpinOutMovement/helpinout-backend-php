<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogEmailOfferMappingRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Email Offer Mapping Requests';
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
                                    return ($model->app_user_id != null ? $model->app_user->first_name.' '.$model->app_user->last_name:'');
                                }
                            ],
                            [
                                'attribute' => 'Email Address',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
                                    return $model->email_address != null ? $model->email_address : '-';
                                }
                            ],
                            [
                                'attribute' => 'datetime',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
                                    return $model->datetime != null ? date("d-m-Y h:m:s",strtotime($model->datetime)) : '-';
                                }
                            ],
                           
                            [
                                'attribute' => 'status',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->status == '1') {
                                        return "Request";
                                    } elseif($model->status=='2') {
                                        return "Send";
                                    }
                                    else
                                    {
                                        return "-";
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
</div>
