<?php

namespace app\modules\user\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use app\models\UserModel;

class App extends \yii\base\Component {

    public function init() {
        $request = explode('/', Yii::$app->request->url);

        if (isset(Yii::$app->user->identity) && Yii::$app->user->identity->id != 1) {
            if (Yii::$app->user->identity->isBlocked) {
                \Yii::$app->user->logout();
            }

            $days = $this->attempt->set_days;
            $last_password_change = strtotime($this->passwordchangedate->last_password_change_date);

            $date = strtotime(date("Y-m-d"));
            $total_days_diff = ($date - $last_password_change) / 60 / 60 / 24;

            if ($total_days_diff > $days) {
                if (!in_array('changepasswords', $request)) {

                    return Yii::$app->getResponse()->redirect(Yii::$app->urlManager->createUrl('changepasswords'));
                }
            }
        }
        parent::init();
    }

    public function getAttempt() {
        return \app\models\UserSetting::find()->where(['status' => 1])->one();
    }

    public function getPasswordchangedate() {
        return \app\models\UserModel::findOne(Yii::$app->user->identity->id);
    }

}
