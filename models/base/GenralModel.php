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
    const APP_USER_TYPE_INDIVIDUAL = 1;
    const APP_USER_TYPE_ORGANIZATION = 2;
    const HELP_TYPE_REQUEST = 1;
    const HELP_TYPE_OFFER = 2;
    const HELP_TYPE_REQUESTER = 1;
    const HELP_TYPE_OFFERER = 1;
    const CATEGORY_OTHERS = 0;
    const CATEGORY_FOOD = 1;
    const CATEGORY_PEOPLE = 2;
    const CATEGORY_SHELTER = 3;
    const CATEGORY_MED_PPE = 4;
    const CATEGORY_TESTING = 5;
    const CATEGORY_MEDICINES = 6;
    const CATEGORY_AMBULANCE = 7;
    const CATEGORY_MEDICAL_EQUIPMENT = 8;
    const NOTIFICATION_REQUEST_ACCEPTED = 1;
    const NOTIFICATION_OFFER_ACCEPTED = 2;
    const NOTIFICATION_REQUEST_CANCELLED = 3;
    const NOTIFICATION_OFFER_CANCELLED = 4;

    public static function genrateNotification($request_help_id = NULL, $offer_help_id = NULL, $action) {
        if ($request_help_id != NULL) {
            $request_help = \app\models\RequestHelp::findOne($request_help_id);
            $notification = New \app\models\Notification();
            $notification->request_help_id = $request_help_id;
            $notification->action = $action;
            $notification->activity_type = GenralModel::HELP_TYPE_REQUEST;
            $notification->app_user_id = $request_help->app_user->id;
            $notification->master_category_id = $request_help->master_category_id;
            $notification->save();
        } else if ($offer_help_id != NULL) {
            $offer_help = \app\models\OfferHelp::findOne($offer_help_id);
            $notification = New \app\models\Notification();
            $notification->offer_help_id = $offer_help_id;
            $notification->action = $action;
            $notification->activity_type = GenralModel::HELP_TYPE_OFFER;
            $notification->app_user_id = $offer_help->app_user->id;
            $notification->master_category_id = $offer_help->master_category_id;
            $notification->save();
        }
    }

}
