        
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


?>
<div class="row">
    <div class="col-md-12">

        <div class="box card-2" style="border-radius:10px;">
            <div class="box-header">
                <div class="row">
                    

                </div><br/>
                <div class="row">
                    <div class="col-md-10">
                        <div class="text-left"><?php //echo $this->render('_search', ['model' => $searchModel]);    ?></div>
                    </div>

                </div>
            </div>
            <div class="box-body">


                


                <div class="col-md-12">
                    <div class="panel-body">
                        
<?php if ($request != NULL) { ?>
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
                                            <th>User Time Zone Offset</th>

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
