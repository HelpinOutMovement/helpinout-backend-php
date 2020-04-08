<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\UserModel;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$form = ActiveForm::begin([
            'options' => [
                'id' => 'Searchform',
                'data-pjax' => true,
                'autocomplete' => 'off',
            ],
            'method' => 'get',
        ]);
?>

<div class="col-sm-12">


    <div class="col-sm-2">
        <?php
        echo $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Search By Name', 'class' => 'form-control form-control-sm'])->label(false);
        ?>
    </div>
    <div class="col-sm-2">
        <?php
        echo $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Search By Email', 'class' => 'form-control form-control-sm'])->label(false);
        ?>
    </div>

    <div class="col-sm-2">
        <?php
        $mapping = ArrayHelper::map(\app\models\MasterRole::find()->where("(id=5 || id=7)")->asArray()->all(), 'id', 'role_name');
        echo $form->field($model, "role_id")->widget(Select2::classname(), [
            'data' => $mapping,
            'options' => ['placeholder' => 'Select Role...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false);
        ?>
    </div>
    <div class="col-sm-2">
        <?php
        $mapping = ArrayHelper::map(\app\models\AppDetail::find()->asArray()->all(), 'app_version', 'app_version');
        echo $form->field($model, "app_version")->widget(Select2::classname(), [
            'data' => $mapping,
            'options' => ['placeholder' => 'Select App Version...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false);
        ?>
    </div>
    <div class="col-sm-2">
        <?php
         echo $form->field($model, 'date_of_install')->textInput(['maxlength' => true, 'placeholder' => 'Search By Date Of Install', 'class' => 'form-control form-control-sm'])->label(false);
        
        ?>
    </div>
    

    <div class="col-md-1">
        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-search"></i>Search', ['class' => 'btn btn-primary btn-sm']) ?>

        </div>
    </div>


</div>

<?php ActiveForm::end(); ?>
       