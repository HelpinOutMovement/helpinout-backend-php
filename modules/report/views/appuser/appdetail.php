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

              <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => "{items}\n{pager}\n{summary}",
                                'tableOptions' => ['class' => 'table table-hover table-striped table-bordered'],
                                'id' => 'grid-data',
                                'headerRowOptions' => ['style' => 'background-color:silver'],
                                'pjax' => TRUE,
                                'columns' => [
                                    [
                                        'attribute' => 'id',
                                        'enableSorting' => false,
                                        'header' => 'App Id',
                                        'format' => 'raw',
                                        'value' => function($model) {

                                            $url = Url::to(["/report/apilog/index?" . "id=$model->id"]);

                                            return Html::a($model->id, $url, ['data-pjax' => "0"]);
                                        }
                                    ],
  
                                    [
                                        'attribute' => 'imei_no',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                    ],

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
                                            return $model->status =='1'  ? 'Active' : 'Not Active';
                                        }
                                    ],
                                ],
                            ]);
                            ?>
                   
              
        </div>
    </div>
</div>
    
    
    
    
    
      