<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\GeneralModel;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApiLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Api Logs';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(file_get_contents(dirname(__FILE__) . '/jsonview.js'));
$this->registerCss(file_get_contents(dirname(__FILE__) . '/jsonview.css'));
?>

<div class="row">
    <div class="card-bg" style="display:flex;">
        <div class="col-md-12 tabs-lefts">
            <ul class="nav nav-tabs small justify-content-center" style="margin-top:10px;">

                <li class="active"><a data-toggle="tab" href="#dhtab">JSON Format</a></li>
                <li><a data-toggle="tab" href="#phctab">Raw Format</a></li>

            </ul>

            <div class="tab-content">
                <div id="dhtab" class="tab-pane fade in active">
                    <div class="border-box">                                          
                        <div class="statewise-bg" style="height:500px; overflow:scroll;overflow-x:hidden;"> 
                            <table id="example2" class="table table-bordered dataTable table-hoverable table-striped">
                                <thead>

                                    <tr>



                                        <th>Body</th>


                                    </tr>
                                    </head>
                                <tbody>
                                    <?php foreach ($dataProvider->getModels() as $model) { ?>

                                        <tr>

                                            <td> 
                                                <div id="root<?php echo $model->id; ?>"></div>
                                                <script>
                                                    datas = <?php echo $model->request_body; ?>;
                                                </script>    

                                                <?php
                                                $this->registerJs(<<<JS
      
      
       jsonView.format(datas, '#root$model->id');
     
JS
                                                );
                                                ?>                           

                                            </td>

                                        </tr>
                                    <?php }; ?>
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>
                <div id="phctab" class="tab-pane fade">
                    <div class="border-box">                                          
                        <div class="statewise-bg" style="height:500px; overflow:scroll;overflow-x:hidden;"> 
                            <table id="example2" class="table table-bordered dataTable table-hoverable table-striped">
                                <thead>

                                    <tr>
                                        <th>Body</th>
                                    </tr>
                                    </head>
                                <tbody>
                                    <?php foreach ($dataProvider->getModels() as $model) { ?>

                                        <tr>

                                            <td style="word-break: break-all;"> 
                                                <?php
                                                echo "<pre>";
                                                echo json_encode(json_decode($model->request_body), JSON_PRETTY_PRINT);
                                                echo "</pre>";
                                                ?>

                                            </td>

                                        </tr>
                                    <?php }; ?>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>

            </div>  








        </div>  
    </div>

</div>

<style>
    i.fas.fa-caret-down:before {
        display:none;
    }

    i.fas.fa-caret-right:before {
        display:none;
    }
    .tabs-left > .nav-tabs > li > a:hover,
    .tabs-left > .nav-tabs > li > a:focus {
        border-color: #eeeeee #dddddd #eeeeee #eeeeee;
    }

    .tabs-lefts > .nav-tabs .active > a,
    .tabs-lefts > .nav-tabs .active > a:hover,
    .tabs-lefts > .nav-tabs .active > a:focus {
        background: #12509d;
        color:white;
        *border-right-color: #ffffff;
    }

</style>    
