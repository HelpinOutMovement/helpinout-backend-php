<?php

namespace app\components\notification;

use yii\base\BaseObject;
use Yii;
use yii\helpers\ArrayHelper;

class GoogleFirebase extends BaseObject {

    /**
     * @var string the api_url for Firebase cloude messageing.
     */
    public $apiUrl = 'https://fcm.googleapis.com/fcm/send';
    //public $image = "http://a.com/images/logo.png";

    public $firebase_api_key;
    public $timeout = 5;
    public $sslVerifyHost = false;
    public $sslVerifyPeer = false;

    /**
     * @var \app\models\Notification
     */
//    public $notification;
//
//    public function getPush() {
//        $res = array();
//        $res['title'] = "ALGN" . " " . $this->notification_model->message_title;
//        $res['message'] = $this->notification_model->message;
//        $res['visible'] = $this->notification_model->visible;
//        $res['module_type'] = $this->notification_model->notification_type;
//        $res['module_sub_type'] = $this->notification_model->notification_sub_type;
//        $res['detail_id'] = $this->notification_model->detail_id;
//        $res['id'] = $this->notification_model->id;
//        $res['genrated_on'] = $this->notification_model->genrated_on;
//
//
//        //$res['data']['is_background'] = $this->is_background;
//        //$res['data']['message'] = $this->notification_model->message;
//        //$res['data']['image'] = $this->image;
//        //$res['data']['additionalData'] = $this->notification_model->content;
//        //$res['data']['additionalData']['pf_id'] = $this->notification_model->premium_freight_id;
//        //$res['data']['additionalData']['status'] = $this->notification_model->approval_status;
//        //$res['data']['additionalData']['sub_segment'] = "CV/2W";//$this->notification_model->approval_status;
//        //$res['data']['additionalData']['customer_name'] = "Custome name is very big then how will you show";//$this->notification_model->approval_status;
//        //$res['data']['additionalData']['item_description1'] = "ITEM desction is also very long";
//        //$res['data']['additionalData']['item_count'] = "3";
//        //$res['data']['additionalData']['origin'] = "Plant/Warehoue";
//        //$res['data']['additionalData']['request_id'] = $this->notification_model->id;
//        //$res['data']['additionalData']['content'] = $this->notification_model->content;
//        //$res['data']['timestamp'] = date('Y-m-d G:i:s');
//        //$res['data']['content-available'] = $this->content_availabel;
//        //$res['data']['sound'] = "chime";
//        //$res['data']['force-start']='1';
//
//        return $res;
//    }
//
//    public function send($to) {
//        $fields = array(
//            'to' => $to,
//            'data' => $this->getPush(),
//        );
//        return $this->sendPushNotification($fields);
//    }
//
//    // Sending message to a topic by topic name
//    public function sendToTopic($to, $message) {
//        $fields = array(
//            'to' => '/topics/' . $to,
//            'data' => $message,
//        );
//        return $this->sendPushNotification($fields);
//    }
//
//    // sending push message to multiple users by firebase registration ids
//    public function sendMultiple($registration_ids, $message) {
//        $fields = array(
//            'to' => $registration_ids,
//            'data' => $message,
//        );
//
//        return $this->sendPushNotification($fields);
//    }
//
    // function makes curl request to firebase servers
    private function sendPushNotification($fields) {
        $headers = array(
            'Authorization: key=AAAAikKcjI4:APA91bGAPehF_Px6UG7BpSMga4isV6dnEPNYOIm3zKySw1XwNoSXnIRyas9bhOiVBiLEmCS5ITqm5LzbdOLe40WPCcVfIN6pwtHewlsENnAC0zcM7S1miUcCxLaNEyzv3yQF76dJCu4M',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
        //print_r(json_encode($fields));
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            //die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        $result = json_decode($result, true);
        return $result;
    }

    /**
     * send raw body to FCM
     * @param array $body
     * @return mixed
     */
    private function send($body) {
        $headers = [
            "Authorization: key={$this->firebase_api_key}",
            'Content-Type: application/json',
                //'Expect: ',
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYHOST => $this->sslVerifyHost,
            CURLOPT_SSL_VERIFYPEER => $this->sslVerifyPeer,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FRESH_CONNECT => false,
            CURLOPT_FORBID_REUSE => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_POSTFIELDS => json_encode($body),
        ]);
        $result = curl_exec($ch);
        if ($result === false) {
            Yii::error('Curl failed: ' . curl_error($ch) . ", with result=$result");
            throw new \Exception("Could not send notification");
        }
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code < 200 || $code >= 300) {
            Yii::error("got unexpected response code $code with result=$result");
            throw new \Exception("Could not send notification");
        }
        curl_close($ch);
        $result = json_decode($result, true);
        return $result;
    }

    /**
     * high level method to send notification for a specific tokens (registration_ids) with FCM
     * see https://firebase.google.com/docs/cloud-messaging/http-server-ref
     * see https://firebase.google.com/docs/cloud-messaging/concept-options#notifications_and_data_messages
     * 
     * @param array  $tokens the registration ids
     * @param array  $notification can be something like {title:, body:, sound:, badge:, click_action:, }
     * @param array  $options other FCM options https://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json
     * @return mixed
     */
    public function sendNotification($tokens = [], $notification, $options = []) {
        $body = [
            'registration_ids' => $tokens,
//            'notification' => $notification,
//            'to' => $tokens,
            'data' => $notification,
        ];
        $body = ArrayHelper::merge($body, $options);
        //return $this->send($body); Didn't work
        return $this->sendPushNotification($body);
    }

}

?>