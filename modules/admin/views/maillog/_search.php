<?php
ini_set('max_execution_time', 1200);
ini_set('memory_limit', '1024M');

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UserModel;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\ApiLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="col-sm-12">
    <?php
    $form = ActiveForm::begin([
                'options' => [
//                    'class' => 'form-inline',
                    'id' => 'Searchform',
                    'data-pjax' => true,
                    'autocomplete' => 'off',
                ],
                'method' => 'get',
    ]);
    ?>

    <div class="col-md-2">
        <?php
        echo $form->field($model, 'to_email_id')->textInput(['maxlength' => true, 'placeholder' => 'Search By Email_no.', 'class' => 'form-control form-control-sm'])->label(false);
        ?>

    </div>
    <div class="col-md-2">
        <?php
        echo $form->field($model, 'model')->textInput(['maxlength' => true, 'placeholder' => 'Search By ITI Code.', 'class' => 'form-control form-control-sm'])->label(false);
        ?>

    </div>




    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(['0' => '0', '1' => '1'], ['prompt' => 'Select Status'])->label(false) ?>
    </div>

    <div class="col-md-1">
        <div class="form-group" style="margin-top:2px;">
            <?= Html::submitButton('<i class="fa fa-search"></i>Search', ['class' => 'btn btn-primary btn-sm']) ?>

        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>





