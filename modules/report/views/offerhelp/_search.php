<?php

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


<!--<div class="col-sm-12">-->
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
<div class="row">
    <div class="col-md-12">

        <div class="col-md-3">
            <?= $form->field($model, 'master_category_id')->dropDownList(ArrayHelper::map(\app\models\MasterCategory::find()->all(), 'id', 'category_name'), ['prompt' => 'Select Category',]) ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'payment') ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'time_zone_offset') ?>

        </div>
         <div class="col-md-2">

            <?php echo $form->field($model, 'status')->dropDownList(['1'=>'Active','0'=>'Inactive'],['prompt'=>'Select Status']) ?>

        </div> 
        <div class="col-md-2"><br>

            <div class="form-group" style="margin-top:2px;">
                <?= Html::submitButton('<i class="fa fa-search"></i>Search', ['class' => 'btn btn-primary btn-sm']) ?>

            </div>
        </div>

    </div><br>

</div>





<?php ActiveForm::end(); ?>

<!--</div>-->