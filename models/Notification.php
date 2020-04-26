<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\base\GenralModel;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $app_user_id
 * @property int $activity_type
 * @property int $master_category_id
 * @property int|null $request_help_id
 * @property int|null $offer_help_id
 * @property int $action 1=request received, 2=offer received,3=request cancelled, 4=offer cancelled
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class Notification extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'notification';
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['app_user_id', 'activity_type', 'master_category_id', 'action'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['app_user_id', 'activity_type', 'master_category_id', 'request_help_id', 'offer_help_id', 'action', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'app_user_id' => 'App User ID',
            'activity_type' => 'Activity Type',
            'master_category_id' => 'Master Category ID',
            'request_help_id' => 'Request Help ID',
            'offer_help_id' => 'Offer Help ID',
            'action' => 'Action',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getTitle() {
        
    }

    public function getActivity_uuid() {
        if ($this->activity_type == GenralModel::HELP_TYPE_REQUEST) {
            return $this->requestdetail->request_uuid;
        } else if ($this->activity_type == GenralModel::HELP_TYPE_OFFER) {
            return $this->offerdetail->offer_uuid;
        }
    }

    public function getOfferdetail() {
        return $this->hasOne(OfferHelp::className(), ['id' => 'offer_help_id']);
    }

    public function getRequestdetail() {
        return $this->hasOne(RequestHelp::className(), ['id' => 'request_help_id']);
    }

    public function getApp_user() {
        return $this->hasOne(\app\models\AppUser::className(), ['id' => 'app_user_id']);
    }

    public function getNotificationdeatil() {
        $notification = array();
        $notification['title'] = "HelpinOut";
        $notification['activity_type'] = $this->activity_type;
        $notification['category_type'] = $this->master_category_id;
        $notification['activity_uuid'] = $this->activity_uuid;
        if ($this->activity_type == GenralModel::HELP_TYPE_REQUEST) {
            $notification['sender_name'] = $this->offerdetail->app_user->username;
        } else if ($this->activity_type == GenralModel::HELP_TYPE_OFFER) {
            $notification['sender_name'] = $this->requestdetail->app_user->username;
        }
        $notification['activity_uuid'] = $this->activity_uuid;
        $notification['action'] = $this->action;
        return $notification;
    }

    public function getToken() {
        $token = array();
        $token[] = $this->app_user->activeapp != "" ? $this->app_user->activeapp->firebase_token : "";
        return $token;
    }

}
