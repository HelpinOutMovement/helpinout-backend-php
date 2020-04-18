        
<?php

use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\GeneralModel;
use yii\bootstrap\Modal;
use app\components\CustomPagination;
//use yii\helpers\Html;
//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApiLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' Users Detail';
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
                        <div class="text-left"><?php //echo $this->render('_search', ['model' => $searchModel]);    ?></div>
                    </div>

                </div>
            </div>
            <div class="box-body">


                <div class="col-md-12">
                    <div class="text-center">
                        <h2>   <?= $model->first_name != null ? $model->username  .'('.$model->country_code.' '.$model->mobile_no.')': '-'?></h2>
                    </div> 
                </div>
                <br><br>

                <div class="col-md-6">
                    <div class="panel-body">
                        <div class="text-center"><h2>Offer Help</h2></div><br>
<?php if ($offer != NULL) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Master Category</th>
                                            <th>No Of Items	</th>
                                            <th>Lat, Lng</th>
                                            <th>Payment</th>
                                            <th>User Date Time</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sn = 1;
                                        foreach ($offer as $offers) {
                                            ?>
                                            <tr>
                                                <td><?= $sn ?></td>
                                                <td><?= $offers->master_category_id != null ? $offers->category->category_name : 'Others' ?></td>
                                                <td><?= $offers->no_of_items != null ? $offers->no_of_items : '' ?></td>
                                                <td><?= $offers->lat != null ? $offers->lat . ',' . $offers->lng : '' ?></td>

                                                <td><?= $offers->payment != null ? $offers->payment : '0' ?></td>
                                                <td><?= $offers->datetime != null ? date('d-m-Y H:i:s', strtotime($offers->datetime)) : '00-00-000 00:00:00' ?></td>
                                                <td><?= $offers->time_zone_offset != null ? $offers->time_zone_offset : ' ' ?></td>
                                            </tr>
                                            <?php $sn++;
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "";
                        }
                        ?>
                        
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel-body">
                        <div class="text-center"><h2>Request Help</h2></div><br>
<?php if ($offer != NULL) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Master Category</th>
                                            <th>No Of Items	</th>
                                            <th>Lat, Lng</th>
                                            <th>Payment</th>
                                            <th>User Date Time</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sn = 1;
                                        foreach ($request as $requests) {
                                            ?>
                                            <tr>
                                                <td><?= $sn; ?></td>
                                                <td><?php
                                                    if ($requests->master_category_id == 0) {
                                                        echo "Others";
                                                    } elseif ($requests->master_category_id == 9) {
                                                        echo 'Others';
                                                    } else {
                                                        echo $requests->master_category_id != null ? $requests->category->category_name : '';
                                                    }
                                                    ?></td>
                                                <td><?= $requests->no_of_items != null ? $requests->no_of_items : '' ?></td>
                                                <td><?= $requests->lat != null ? $requests->lat . ',' . $requests->lng : '' ?></td>

                                                <td><?= $requests->payment != null ? $requests->payment : '0' ?></td>
                                                <td><?= $requests->datetime != null ? date('d-m-Y H:i:s', strtotime($requests->datetime)) : '00-00-000 00:00:00' ?></td>
                                                <td><?= $requests->time_zone_offset != null ? $requests->time_zone_offset : ' ' ?></td>
                                            </tr>
        <?php $sn++;
    }
    ?>

                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "";
                        }
                        ?>
                        
                    </div>
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
    .underlinelink
    {
        color:#000;
    }
</style>
