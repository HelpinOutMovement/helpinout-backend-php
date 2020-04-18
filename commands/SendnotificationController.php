<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\db\Expression;
use app\models\CronStatus;
use app\models\Notification;
use app\models\NotificationFirebaseDetail;

/**
 * This command Send notification.
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class SendnotificationController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex() {

        $notification_model = Notification::find()->where(['=', 'status', '1'])->limit(45)->orderBy(['id' => SORT_ASC])->all();

        foreach ($notification_model as $model) {
            $response_result = \Yii::$app->firebaseNotification->sendNotification($model->token, $model->notificationdeatil);


//            print_r($model->token);
//            print_r($model->notificationdeatil);
//            print_r($response_result);

            $notification_firebase_detail = new NotificationFirebaseDetail();
            $notification_firebase_detail->notification_id = $model->id;
            if ($response_result == null) {
                $model->status = 0;
                $notification_firebase_detail->firebase_message = "No Token";
            } else {
                if ($response_result['success']) {
                    $model->status = 2;
                    $notification_firebase_detail->firebase_id = isset($response_result['results'][0]['message_id']) ? $response_result['results'][0]['message_id'] : '';
                } else {
                    $model->status = 0;
                    $notification_firebase_detail->firebase_message = isset($response_result['results'][0]['error']) ? $response_result['results'][0]['error'] : '';
                }
            }
            if ($model->update()) {
                
            } else {
                print_r($model->getErrors());
            }
            if ($notification_firebase_detail->save()) {
                
            } else {
                print_r($notification_firebase_detail->getErrors());
            }
        }
    }

}
