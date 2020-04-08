<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
        <?=
        $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\UserModel::find()->where("(role_id=5 || role_id=7)")->orderBy([
                            'email' => SORT_ASC,
                        ])->all(), 'id', function($model) {
                    return $model->email . ' (' . $model->name . ')';
                }), ['prompt' => 'Select User'])->label(false)
        ?>
    </div>

    <div class="col-md-2">
        <?php
        echo $form->field($model, 'imei_no')->textInput(['maxlength' => true, 'placeholder' => 'Search By Imei No.', 'class' => 'form-control form-control-sm'])->label(false);
        ?>

        <?php // $form->field($model, 'imei_no')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\AppDetail::find()->select(['imei_no'])->distinct()->all(), 'imei_no', 'imei_no'), ['prompt' => 'Select IMEI No'])->label(false);  ?>
    </div>
    <!--            <div class="col-md-2">
    
    <?php //echo $form->field($model, 'os_type')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\AppDetail::find()->select(['os_type'])->distinct()->all(), 'os_type', 'os_type'), ['prompt' => 'Select OS type'])->label(false)  ?>
    
                </div> -->
    <div class="col-md-2">
        <?= $form->field($model, 'manufacturer_name')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\AppDetail::find()->orderBy(['manufacturer_name' => SORT_ASC])->select(['manufacturer_name'])->distinct()->all(), 'manufacturer_name', 'manufacturer_name'), ['prompt' => 'Select Manufacturer'])->label(false) ?>

    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\AppDetail::find()->select(['status'])->distinct()->all(), 'status', 'status'), ['prompt' => 'Select Status'])->label(false) ?>

    </div>


    <div class="col-md-1">
        <div class="form-group" style="margin-top:2px;">
            <?= Html::submitButton('<i class="fa fa-search"></i>Search', ['class' => 'btn btn-primary btn-sm']) ?>

        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>



