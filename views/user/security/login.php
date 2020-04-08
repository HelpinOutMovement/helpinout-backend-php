<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>







  <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>

     <div class="form-group has-feedback">
         <?php if ($module->debug): ?>
                    <?= $form->field($model, 'login', [
                        'inputOptions' => [
                            'autofocus' => 'autofocus',
                            'placeholder'=>'dfg',
                            'class' => 'form-control',
                            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                    ?>
                     <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <?php else: ?>

                    <?= $form->field($model, 'login',
                        ['inputOptions' => ['autofocus' => 'autofocus', 'placeholder'=>'Username', 'class' => 'form-control', 'tabindex' => '1']]
                    )->label(false)
                 
                ?>
                   <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
         <?php endif ?>
      </div>
      <div class="form-group has-feedback">
        <?php if ($module->debug): ?>
                    <div class="alert alert-warning">
                        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                    </div>
                <?php else: ?>
                    <?= $form->field(
                        $model,
                        'password',
                        ['inputOptions' => ['class' => 'form-control','placeholder'=>'Password', 'tabindex' => '2']])
                        ->passwordInput()
                        ->label(
                            Yii::t('user', 'Password')
                        )->label(false) ?>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php endif ?>

               
                

      </div>
       <div class="row">
                  <div class="col-xs-8">
                    <div class="checkbox icheck">
                        
                        <label>
                      <?= $form->field($model, 'rememberMe', [
        'template' => "<div class=\" col-lg-10\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
    ])->checkbox()->label("Remember Me") ?>
                        </label>
                    </div>
                  </div>
                  <div class="col-xs-4">
                      <div class="form-bottom">
                      <?php
//    echo $module->enablePasswordRecovery ?
//            Html::a(
//                    Yii::t('user', 'Forgot password?'), ['/user/recovery/request'], ['tabindex' => '5']
//            ) : '';
    ?>
                      </div>
                     </div>
                </div>
      <div class="row">
        
        <div class="col-xs-12">
         <?= Html::submitButton(
                    Yii::t('user', 'Sign in'),
                    ['class' => 'btn btn-primary btn-block btn-flat', 'tabindex' => '4']
                ) ?>
        </div>
           <?php if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
            </p>
           <?php endif ?>
           <?php if ($module->enableRegistration): ?>
              <p style="margin-left:-20px;"class="text-center">
                <?php Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']); ?>
              </p>
           <?php endif ?>
           <?= Connect::widget([
              'baseAuthUrl' => ['/user/security/auth'],
            ]) ?>
       </div>
    <?php ActiveForm::end(); ?>
               
              
