<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogEmailOfferMappingRequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-email-offer-mapping-request-search">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'id' => 'Searchform',
                    'data-pjax' => true,
                    'autocomplete' => 'off',
                ],
                'method' => 'get',
    ]);
    ?>


    <div class="col-md-3">
        <?= $form->field($model, 'app_user_id')->textInput(['placeholder'=>'Enter Username'])->label('User Name') ?>
    </div>
    

 <div class="col-md-3">
        <?= $form->field($model, 'email_address')->textInput(['placeholder'=>'Enter Email ']) ?> </div>
</div>
 <!--<div class="col-md-3">-->
    <?php //echo $form->field($model, 'status')->dropDownList(['1'=>'Request','2'=>'Send'],['prompt'=>'Select Status']) ?>
 <!--</div>-->
<div class="col-md-3"><br>
   
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
       
   
 </div>
    <?php ActiveForm::end(); ?>

</div>
