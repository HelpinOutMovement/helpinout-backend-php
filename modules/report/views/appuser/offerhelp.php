        
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
                        <div class="text-left"><?php //echo $this->render('_search', ['model' => $searchModel]);       ?></div>
                    </div>

                </div>
            </div>
            <div class="box-body">




                <div class="col-md-12">
                    <div class="text-center">

                        <?php if ($offer != NULL) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Master Category</th>
                                            <th>No Of Items	</th>
                                            <th>Request Mapped By Me</th>
                                            <th>Offer Recieved</th>
                                            <th>Detail</th>
                                            <th>Lat, Lng</th>
                                            <th>Payment</th>
                                            <th>Offer Note</th>
                                            <th>User Date Time</th>
                                            <th>User Time Zone Offset</th>
                                            <th>Status</th>
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
                                                <td><?= $offers->id != null ? $offers->mappingoffer : '' ?></td>
                                                <td><?= $offers->id != null ? $offers->mappingrequest : '' ?></td>
                                                <td><?php
                                                    if ($offers->master_category_id == 2) {
                                                        echo '';
                                                    } else if ($offers->master_category_id == 7) {
                                                        echo '';
                                                    } else {
                                                        $html = '<ul>';
                                                        foreach ($offers->activity_detail as $detail) {
                                                            $html .= '<li>' . $detail->detail != null ? $detail->detail . ' (' . $detail->quantity . ')' . '<br>' : '' . "</li>";
//                                      
                                                        }
                                                        $html .= "</ul>";
                                                        echo $html;
                                                    }
                                                    ?></td>
                                                <td><?= $offers->lat != null ? $offers->lat . ',' . $offers->lng : '' ?></td>

                                                <td><?= $offers->payment != null ? $offers->payment : '0' ?></td>
                                                <td><?= $offers->offer_note != null ? $offers->offer_note : '' ?></td>
                                                <td><?= $offers->datetime != null ? date('d-m-Y H:i:s', strtotime($offers->datetime)) : '00-00-000 00:00:00' ?></td>
                                                <td><?= $offers->time_zone_offset != null ? $offers->time_zone_offset : ' ' ?></td>
                                                <td><?php
                                                    if ($offers->status) {
                                                        echo "<p class='active'> Active</p>";
                                                    } else {
                                                        echo "<p class='inactive'>Inactive</p>";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $sn++;
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