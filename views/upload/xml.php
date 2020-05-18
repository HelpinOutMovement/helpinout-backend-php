<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionImportFile */

$this->title = 'Import Files';
//$this->params['breadcrumbs'][] = ['label' => 'Import ITI File', 'url' => ['index']];


ini_set('upload_max_filesize', '1000M');
ini_set('post_max_size', '1000M');
ini_set('max_input_time', 1200000000000000000);
ini_set('max_execution_time', 1200000000000000000);
ini_set('memory_limit', '10244444444444M');
ini_set('file_uploads', 'On');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="question-import-file-create">
    <div class="col-md-12" id="listing">

    </div>

    <div class="box box-info">
        <div class="box-body">
            <div class="question-import-file-form">
                <div class="row dash-row">
                    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($model, 'file_name')->fileInput(['id' => 'file', 'placeholder' => 'Choose File'])->label(false); ?>





                    <div class="col-md-6 col-md-offset-5">
                        <button class="btn btn-info" id="b22" data-complete="showTick-13"> <i class="fa fa-upload"></i> Upload CSV</button>
                        <?php // Html::submitButton('<i class="fa fa-upload"></i> Upload CSV', ['class' => 'btn btn-info']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
 <div class="col-md-6 col-md-offset-3" id="listing">
                <div id="file" style="display:none">
                    <div class="progress-outer">
                        <div id='hello'>

                        </div>
                        <span class="pull-right" id="hi">Please wait...</span>
                        <div class="progress">
                            <div class="progress-bar progress-bar-info progress-bar-striped active">
                                <div class="progress-value">

                                </div>

                            </div> 
                        </div> 
                        <div id="file1"></div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
   
    <style>
        .progress-outer{
            background: #fff;
            border-radius: 50px;
            padding: 25px;
            margin: 10px 0;
            box-shadow: 0 0  10px rgba(209, 219, 231,0.7);
        }
        .progress{
            height: 27px;
            margin: 0;
            overflow: visible;
            border-radius: 50px;
            background: #eaedf3;
            box-shadow: inset 0 10px  10px rgba(244, 245, 250,0.9);
        }
        .progress .progress-bar{
            border-radius: 50px;
        }
        .progress .progress-value{
            position: relative;
            left: -20px;
            top: 4px;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            letter-spacing: 2px;
        }
        .progress-bar.active{
            animation: reverse progress-bar-stripes 0.40s linear infinite, animate-positive 2s;
        }
        @-webkit-keyframes animate-positive{
            0% { width: 0%; }
        }
        @keyframes animate-positive {
            0% { width: 0%; }
        }
        .input-group-btn {
            background:blue;
        }
        .buttonText{
            color:white;
        }
    </style>

</div>
