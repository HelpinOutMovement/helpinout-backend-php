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

    <div class="col-md-1">
        <?php
//        $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\UserModel::find()->where("(role_id=5 || role_id=7)")->orderBy([
//                            'email' => SORT_ASC,
//                        ])->all(), 'id', function($model) {
//                    return $model->email . ' (' . $model->name . ')';
//                }), ['prompt' => 'Select User'])->label(false)
//        ?>
    </div>
    <div class="col-md-2">

        <?php
        //echo $form->field($model, 'app_id')->textInput(['maxlength' => true, 'placeholder' => 'Search By App', 'class' => 'form-control form-control-sm'])->label(false);
        ?>

    </div> 
    <!--            <div class="col-md-2">-->
    <?php
//                                echo $form->field($model, 'app_id')->widget(DepDrop::classname(), [
//                                    'options' => ['prompt' => 'Select App',],
//                                    'data' => $model->app_option,
//                                    'pluginOptions' => [
//                                        'allowClear' => true,
//                                        'depends' => ['apilogsearch-user_id'],
//                                        'url' => Url::to(['/ajax/appid']),
//                                    ]
//                                ])->label(false);
    ?>

    <!--            </div>-->
    <div class="col-md-2">
        <?= $form->field($model, 'app_version')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\AppDetail::find()->all(), 'app_version', 'app_version'), ['prompt' => 'Select App Version'])->label(false) ?>
    </div>

    <div class="col-md-2">

        <?= $form->field($model, 'http_response_code')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\ApiLog::find()->select(['http_response_code'])->distinct()->orderBy('http_response_code asc')->all(), 'http_response_code', 'http_response_code'), ['prompt' => 'Select Response Code'])->label(false) ?>

    </div> 
    <div class="col-md-2">
        <?= $form->field($model, 'request_url')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\ApiLog::find()->select(['request_url'])->distinct()->orderBy('request_url asc')->all(), 'request_url', 'request_url'), ['prompt' => 'Select api url'])->label(false) ?>

    </div>
    <div class="col-md-2">

        <?php
        echo $form->field($model, 'request_body')->textInput(['maxlength' => true, 'placeholder' => 'Search By Request Body', 'class' => 'form-control form-control-sm'])->label(false);
        ?>

    </div> 


    <div class="col-md-1">
        <div class="form-group" style="margin-top:2px;">
            <?= Html::submitButton('<i class="fa fa-search"></i>Search', ['class' => 'btn btn-primary btn-sm']) ?>

        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>




