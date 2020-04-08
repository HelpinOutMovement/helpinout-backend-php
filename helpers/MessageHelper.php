<?php

namespace app\helpers;

use yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\user\models\User;

/**
 * MessageHelper helper.
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class MessageHelper {

    public static function welcome($user, $token = null) {
        $model = User::findOne($user->id);
        $message = '<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.='Hello ' . $model->username . ',';
        $message.='</p>';
        $message.='<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.=Yii::t('user', 'Your account on {0} has been successfully created and we have generated password for you', Yii::$app->name) . '<br>';
        $message.=Yii::t('user', 'You can use it with your email address or username in order to log in.<br>');
        $message.=Yii::t('user', 'Please click the link go to ' . Yii::$app->name . '<br>');
        $message.=Html::a(Html::encode(Url::base(true)), Url::base(true));
        $message.='</p>';
        $message.='<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.=Yii::t('user', 'Email') . ' :  ' . $user->email . '<br>';
        $message.=Yii::t('user', 'Username') . ' :  ' . $user->username . '<br>';
        $message.=Yii::t('user', 'Password') . ' :  ' . $user->password . '<br>';
        $message.='</p>';
        $message.='<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.=Yii::t('user', 'P.S. If you received this email by mistake, simply delete it');
        $message.='</p>';
        return $message;
    }

    public static function resetpassword($user, $token = null) {
        $model = User::findOne($user->id);
        $message = '<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.='Hello ' . $model->username . ',';
        $message.='</p>';
        $message.='<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.=Yii::t('user', 'Your password on {0} has been successfully reset and we have generated password for you', Yii::$app->name) . '<br>';
        $message.=Yii::t('user', 'You can use it with your email address or username in order to log in<br>');
        $message.=Yii::t('user', 'Please click the link go to ' . Yii::$app->name . '<br>');
        $message.=Html::a(Html::encode(Url::base(true)), Url::base(true));
        $message.='</p>';
        $message.='<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.=Yii::t('user', 'Email') . ' :  ' . $user->email . '<br>';
        $message.=Yii::t('user', 'Username') . ' :  ' . $user->username . '<br>';
        $message.=Yii::t('user', 'Password') . ' :  ' . $user->password . '<br>';
        $message.='</p>';
        $message.='<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.=Yii::t('user', 'P.S. If you received this email by mistake, simply delete it');
        $message.='</p>';
        return $message;
    }

    public static function recoverpassword($model, $token = null) {
        $user = User::findOne($model->id);
        $message = '<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.='Hello ' . $user->username . ',';
        $message.='</p>';
        $message.='<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.=Yii::t('user', 'You have recently requested to reset your password on {0}', Yii::$app->name) . '<br>';
        $message.=Yii::t('user', 'In order to complete your request, we need you to verify that you initiated this request <br>');
        $message.=Yii::t('user', 'Please click the link below to complete your password reset');
        $message.='</p>';
        $message.='<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.=Html::a(Html::encode($token->url), $token->url);
        $message.='</p>';
        $message.='<p style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">';
        $message.=Yii::t('user', 'P.S. If you received this email by mistake, simply delete it');
        $message.='</p>';
        return $message;
    }

}
