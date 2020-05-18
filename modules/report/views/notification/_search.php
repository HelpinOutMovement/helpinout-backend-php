<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\NotificationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-search">
    <div class="row">
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
            <?= $form->field($model, 'app_user_id')->textInput(['placeholder'=>'Enter Username'])->label('User Name') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'activity_type')->dropDownList(['1' => 'Request', '2' => 'Offer'], ['prompt' => 'Select Type']) ?>
        </div>
        <div class="col-md-2">

            <?= $form->field($model, 'master_category_id')->dropDownList(ArrayHelper::map(\app\models\MasterCategory::find()->all(), 'id', 'category_name'), ['prompt' => 'Select Category',])->label('Master category') ?>
        </div>
        <div class="col-md-2">
            <?php echo $form->field($model, 'action')->dropDownList(['1' => 'Request Received', '2' => 'Offer Received', '3' => 'Request Cancelled', '4' => 'Offer cancelled'], ['prompt' => 'Select Acrion']) ?>
        </div>
        <div class="col-md-2">

            <?php echo $form->field($model, 'status')->dropDownList(['-1' => 'Delete', '0' => 'Error', '2' => 'Success'], ['prompt' => 'Select Status']) ?>
        </div>

        <div class="col-md-2"><br>
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
