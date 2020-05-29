<?php

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

class GenralModel extends \yii\base\Model {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    /**/
    const APP_USER_TYPE_INDIVIDUAL = 1;
    const APP_USER_TYPE_ORGANIZATION = 2;
    /**/
    const HELP_TYPE_REQUEST = 1;
    const HELP_TYPE_OFFER = 2;
    /**/
    const HELP_TYPE_REQUESTER = 1;
    const HELP_TYPE_OFFERER = 2;
    /**/
    const CATEGORY_OTHERS = 0;
    const CATEGORY_FOOD = 1;
    const CATEGORY_PEOPLE = 2;
    const CATEGORY_SHELTER = 3;
    const CATEGORY_MED_PPE = 4;
    const CATEGORY_TESTING = 5;
    const CATEGORY_MEDICINES = 6;
    const CATEGORY_AMBULANCE = 7;
    const CATEGORY_MEDICAL_EQUIPMENT = 8;
    const CATEGORY_VOLUNTEERS = 9;
    const CATEGORY_FRUITS_VEGETABLES = 10;
    const CATEGORY_TRANSPORT = 11;
    const CATEGORY_ANIMAL_SUPPORT = 12;
    const CATEGORY_GIVEAWAYS = 13;
    const CATEGORY_PAID_WORK = 14;
    /**/
    const REQUEST_PAYMENT_CANNOT_PAY = 0;
    const REQUEST_PAYMENT_CAN_PAY = 1;
    const REQUEST_PAYMENT_GET_PAID = 11;
    const OFFER_PAYMENT_FOR_FREE = 0;
    const OFFER_PAYMENT_WANT_MONEY = 1;
    const OFFER_PAYMENT_WILL_PAY = 11;
    /**/
    const NOTIFICATION_REQUEST_RECEIVED = 1;
    const NOTIFICATION_OFFER_RECEIVED = 2;
    const NOTIFICATION_REQUEST_CANCELLED = 3;
    const NOTIFICATION_OFFER_CANCELLED = 4;

    public static function genrateNotification($request_help_id, $offer_help_id, $action, $app_user_id, $master_category_id) {

        $notification = New \app\models\Notification();
        $notification->request_help_id = $request_help_id;
        $notification->offer_help_id = $offer_help_id;
        $notification->app_user_id = $app_user_id;
        $notification->master_category_id = $master_category_id;
        switch ($action) {
            case GenralModel::NOTIFICATION_OFFER_RECEIVED:
            case GenralModel::NOTIFICATION_OFFER_CANCELLED:

                $notification->action = $action;
                $notification->activity_type = GenralModel::HELP_TYPE_REQUEST;
                $notification->save();
                break;

            case GenralModel::NOTIFICATION_REQUEST_RECEIVED:
            case GenralModel::NOTIFICATION_REQUEST_CANCELLED:

                $notification->action = $action;
                $notification->activity_type = GenralModel::HELP_TYPE_OFFER;
                $notification->save();
                break;

            default:
                break;
        }

//        switch ($action) {
//            case GenralModel::NOTIFICATION_OFFER_CANCELLED:
//            case GenralModel::NOTIFICATION_REQUEST_CANCELLED:
//
//                $notification->status = -1;
//                $notification->save();
//                break;
//            default:
//                break;
//        }
//        if ($request_help_id != NULL) {
//            $request_help = \app\models\RequestHelp::findOne($request_help_id);
//            $notification = New \app\models\Notification();
//            $notification->request_help_id = $request_help_id;
//            $notification->action = $action;
//            $notification->activity_type = GenralModel::HELP_TYPE_REQUEST;
//            $notification->app_user_id = $request_help->app_user->id;
//            $notification->master_category_id = $request_help->master_category_id;
//            $notification->save();
//        } else if ($offer_help_id != NULL) {
//            $offer_help = \app\models\OfferHelp::findOne($offer_help_id);
//            $notification = New \app\models\Notification();
//            $notification->offer_help_id = $offer_help_id;
//            $notification->action = $action;
//            $notification->activity_type = GenralModel::HELP_TYPE_OFFER;
//            $notification->app_user_id = $offer_help->app_user->id;
//            $notification->master_category_id = $offer_help->master_category_id;
//            $notification->save();
//        }
    }

}
