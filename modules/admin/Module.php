<?php

namespace app\modules\admin;

use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        if (isset(Yii::$app->user->identity)) {
            if (!in_array(\Yii::$app->user->identity->role_id, [\app\models\UserModel::ROLE_SUPERADMIN, \app\models\UserModel::ROLE_ADMIN])) {
                return \Yii::$app->getResponse()->redirect(['/']);
            }
        }
    }

}
