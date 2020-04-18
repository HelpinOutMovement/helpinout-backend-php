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
            <?= $form->field($model, 'payment')->dropDownList(['0' => '0', '1' => '1'], ['prompt' => 'Select Payment']) ?>

        </div>
        <!--<div class="col-md-3">-->
            <?php // $form->field($model, 'time_zone_offset')->dropDownList(ArrayHelper::map(\app\models\MasterTimezone::find()->select('offset')->distinct()->orderBy(['offset' => SORT_ASC])->all(), 'offset', 'offset'), ['prompt' => 'Select Time Zone Offset']) ?>

        <!--</div>-->
        <div class="col-md-2">
            <label for='status'>Status</label>
            <select class="form-control" name="OfferHelpSearch[status]">
                <option value=''>Select Status</option>
                <option value="1" class="active">Active</option>
                <option value="0" class="inactive">Inactive</option>
            </select>
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
<style>
 [attr]
/* {
     color:green;
 }
*/    
.active{
        color:rgb(0, 255, 0);
    }
    .inactive{
        color:#FF5733 ;
    }
    </style>