<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'app_user_id')->textInput() ?>

    <?= $form->field($model, 'activity_type')->textInput() ?>

    <?= $form->field($model, 'master_category_id')->textInput() ?>

    <?= $form->field($model, 'request_help_id')->textInput() ?>

    <?= $form->field($model, 'offer_help_id')->textInput() ?>

    <?= $form->field($model, 'action')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
