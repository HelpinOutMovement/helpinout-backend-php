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
                    <div class="col-md-6">

                    </div>

                </div><br/>
                <div class="row">
                    <div class="col-md-10">
                        <div class="text-left"><?php //echo $this->render('_search', ['model' => $searchModel]);                ?></div>
                    </div>

                </div>
            </div>
            <div class="box-body">


                <div class="col-md-12">
                    <div class="text">


                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>User Name</th>
                                        <th>Self Else</th>
                                        <th>Master category</th>
                                        <th>No Of Items	</th>
                                        <th>Detail</th>
                                        <th>Lat, Lng</th>
                                        <th>Payment</th>
                                        <th>User Date Time</th>
                                        <th>User Time Zone Offset</th>
                                        <th>Status</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sn = 1;
                                    foreach ($requestmapbyme as $requests) {
                                        ?>
                                        <tr>
                                            <td><?= $sn ?></td>
                                            <td><?= $requests->request_help_id != NULL ? $requests->requestdetail->app_user->first_name . ' ' . $requests->offerdetail->app_user->last_name : '' ?></td>
                                            <td><?php if($requests->requestdetail->self_else=='1'){echo "Self";} else{echo "Offer";}?></td>
                                            <td><?= $requests->request_help_id != null ? $requests->requestdetail->category->category_name : '' ?></td>

                                            <td><?= $requests->request_help_id != null ? $requests->requestdetail->no_of_items : '' ?></td>
                                            <td><?php
                                                if ($requests->requestdetail->master_category_id == 2) {
                                                    echo '';
                                                } else if ($requests->requestdetail->master_category_id == 7) {
                                                    echo '';
                                                } else {
                                                    $html = '<ul>';
                                                    foreach ($requests->requestdetail->activity_detail as $detail) {
                                                        $html .= '<li>' . $detail->detail != null ? $detail->detail . ' (' . $detail->quantity . ')' . '<br>' : '' . "</li>";
//                                      
                                                    }
                                                    $html .= "</ul>";
                                                    echo $html;
                                                }
                                                ?></td>
                                            <td><?= $requests->request_help_id != null ? $requests->requestdetail->lat . ',' . $requests->requestdetail->lng : '' ?></td>

                                            <td><?= $requests->request_help_id != null ? $requests->requestdetail->payment : '0' ?></td>
                                            <td><?= $requests->request_help_id != null ? date('d-m-Y H:i:s', strtotime($requests->requestdetail->datetime)) : '00-00-000 00:00:00' ?></td>
                                            <td><?= $requests->request_help_id != null ? $requests->requestdetail->time_zone_offset : ' ' ?></td>
                                            <td><?php
                                                if ($requests->status) {
                                                    echo "<p class='active'> Active</p>";
                                                } else {
                                                    echo "<p class='inactive'>Inactive</p>";
                                                }
                                                ?></td>

                                        </tr>
                                        <?php
                                        $sn++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!--dfgf-->


<!--jkgjhk-->

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
</style>

