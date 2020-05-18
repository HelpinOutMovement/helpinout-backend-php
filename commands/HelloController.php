<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world') {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionUpdatedistance($message = 'hello world') {
        $mapping = \app\models\HelpinoutMapping::find()->all();

        foreach ($mapping as $map) {
            $model_request_help = \app\models\RequestHelp::findOne($map->request_help_id);
            $model_offer_help = \app\models\OfferHelp::findOne($map->offer_help_id);


            $map->distance = \app\helpers\Utility::distance($model_offer_help->lat, $model_offer_help->lng, $model_request_help->lat, $model_request_help->lng, "K");
            $map->update();
        }

        return ExitCode::OK;
    }

}
