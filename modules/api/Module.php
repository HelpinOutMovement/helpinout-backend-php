<?php

namespace app\modules\api;

/**
 * api module definition class
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->modules = [
            'v1' => [
                'class' => 'app\modules\api\v1\Module',
            ]
        ];
    }

}
