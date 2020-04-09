<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AppUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'time_zone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_zone_offset')->textInput() ?>

    <?= $form->field($model, 'country_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_no_visibility')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_type')->textInput() ?>

    <?= $form->field($model, 'org_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'master_app_user_org_type')->textInput() ?>

    <?= $form->field($model, 'org_division')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
