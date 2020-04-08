<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MailLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mail-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_email_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_email_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_user_id')->textInput() ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'template')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'mail_send_time')->textInput() ?>

    <?= $form->field($model, 'try_send_count')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
