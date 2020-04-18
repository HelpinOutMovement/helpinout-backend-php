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


?>

<div class="row">
    <div class="card-bg">
        <div class="col-md-12 tabs-lefts">
            

           
                    <div class="border-box">                                          
                        <div class="statewise-bg" style="height:500px; overflow:scroll;overflow-x:hidden;"> 
                            <table id="example2" class="table table-bordered dataTable table-hoverable table-striped">
                                <thead>

                                    <tr>



                                        <th>Response</th>


                                    </tr>
                                    </head>
                                <tbody>
                                    <?php foreach ($dataProvider->getModels() as $model) { ?>

                                        <tr>

                                            <td> 
                                                <?php echo $model->response; ?>;
                                                
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


