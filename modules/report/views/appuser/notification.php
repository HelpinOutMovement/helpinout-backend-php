        
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

                    </div>

                </div><br/>
                <div class="row">
                    <div class="col-md-10">
                        <div class="text-left"><?php //echo $this->render('_search', ['model' => $searchModel]);           ?></div>
                    </div>

                </div>
            </div>
            <div class="box-body">




                <div class="col-md-12">
                    <div class="text-center">

                        <?php if ($notification != NULL) { ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>

                                            <th>Master Category	</th>
                                            <th>Activity Type</th>
                                            <th>Request Help</th>
                                            <th>Offer Help</th>
                                            <th>Action</th>
                                            <th>Date Time</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sn = 1;
                                        foreach ($notification as $model) {
                                            ?>
                                            <tr>
                                                <td><?= $sn ?></td>
                                                <td><?php
                                                    if ($model->master_category_id == 0) {
                                                        echo  "Others";
                                                    } elseif ($model->master_category_id == 9) {
                                                        echo 'Others';
                                                    } else {
                                                        echo $model->master_category_id != null ? $model->category->category_name : '';
                                                    }
                                                    ?></td>

                                                <td><?php
                                            if ($model->activity_type == '1') {
                                                echo "Request";
                                            } else {
                                                echo "Offer";
                                            }
                                                    ?></td>
                                                <td><?= Html::button(Yii::t('user', 'View Request Help'), ['value' => Url::to('/report/notification/requesthelp?request_help_id=' . $model->request_help_id), 'class' => 'btn btn-xs btn-default btn-block qsrejectmodel']) ?></td>
                                                <td><?= Html::button(Yii::t('user', 'View Offer Help'), ['value' => Url::to('/report/notification/offerhelp?offer_help_id=' . $model->offer_help_id), 'class' => 'btn btn-xs btn-default btn-block offermodel']) ?></td>
                                                <td><?php
                                            if ($model->action == '1') {
                                                echo " <span class='label label-info'>Request Received</span>";
                                            } else if ($model->action == '2') {
                                                echo "<span class='label label-success'>Offer Received</span>";
                                            } elseif ($model->action == '3') {
                                                echo "<span class='label label-warning'>Request cancelled</span>";
                                            } else {
                                                echo "<span class='label label-danger'>Offer Cancelled</span>";
                                            }
                                                    ?></td>
                                                <td><?= $model->created_at != null ? date("d-m-Y H:m:s", $model->created_at) : '00-00-0000 00:00:00' ?></td>
                                                <td><?php
                                            if ($model->status == '-1') {
                                                echo "<span class='label label-danger'>Delete</span>";
                                            } else if ($model->status == '0') {
                                                echo "<span class='label label-warning'>Error</span>";
                                            } elseif ($model->status == '1') {
                                                echo "";
                                            } else {
                                                echo "<span class='label label-success'>Success</span>";
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
</style>
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