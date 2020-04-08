<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\password\PasswordInput;

/**
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model app\modules\user\models\ChangePasswordForm
 */
$this->title = Yii::t('user', 'Change Password');
$this->params['icon'] = 'fa fa-cog';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='changepasswordform'>

    <div class="box box-info">
        <div class="box-header"> <div class='title'>
                <i class="<?= $this->params['icon'] ?>"></i>
                <?= $this->title ?>
            </div>
        </div>
        <div class="box-body">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'change-password-form',
                        'options' => ['class' => 'form-horizontal', 'autocomplete' => 'off'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div >{error}</div>",
                            'labelOptions' => ['class' => 'col-md-3 control-label'],
                        ],
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
            ]);
            ?>

            <?= $form->field($user, 'new_password')->passwordInput(['placeholder' => 'New Password']) ?>
            <?= $form->field($user, 're_password')->passwordInput(['placeholder' => 'Repeat Password']) ?>
            <hr/>



            <div class="form-group">
                <div class="col-sm-offset-4 ">
                    <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-info']) ?><br>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>     
</div>       
<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>
