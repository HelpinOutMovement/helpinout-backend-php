<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OfferHelp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offer-help-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'app_user_id')->textInput() ?>

    <?= $form->field($model, 'api_log_id')->textInput() ?>

    <?= $form->field($model, 'offer_uuid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'master_category_id')->textInput() ?>

    <?= $form->field($model, 'no_of_items')->textInput() ?>

    <?= $form->field($model, 'location')->textInput() ?>

    <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lng')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accuracy')->textInput() ?>

    <?= $form->field($model, 'payment')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'offer_note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datetime')->textInput() ?>

    <?= $form->field($model, 'time_zone_offset')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
