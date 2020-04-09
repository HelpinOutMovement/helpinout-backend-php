<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\base\GenralModel;
use app\models\MasterCategory;

/**
 * This is the model class for table "request_help".
 *
 * @property int $id
 * @property int $app_user_id
 * @property int $api_log_id
 * @property string $request_uuid
 * @property int $master_category_id
 * @property int $no_of_items
 * @property string $location
 * @property float $lat
 * @property float $lng
 * @property int $accuracy
 * @property int $payment 0=canot pay, 1=can pay
 * @property string $address
 * @property string $datetime
 * @property string $time_zone_offset
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class RequestHelp extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'request_help';
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
            [['app_user_id', 'api_log_id', 'master_category_id', 'no_of_items', 'accuracy', 'payment', 'created_at', 'updated_at', 'status'], 'integer'],
            [['api_log_id', 'request_uuid', 'master_category_id', 'no_of_items', 'location', 'lat', 'lng', 'accuracy', 'address', 'datetime', 'time_zone_offset'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            //[['location'], 'string'],
            [['lat', 'lng'], 'number'],
            [['datetime', 'time_zone_offset'], 'safe'],
            [['request_uuid'], 'string', 'max' => 36],
            [['address'], 'string', 'max' => 512],
            [['status'], 'default', 'value' => '1'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'app_user_id' => 'App User ID',
            'api_log_id' => 'Api Log ID',
            'request_uuid' => 'Request Uuid',
            'master_category_id' => 'Master Category',
            'no_of_items' => 'No Of Items',
            'location' => 'Location',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'accuracy' => 'Accuracy',
            'payment' => 'Payment',
            'address' => 'Address',
            'datetime' => 'Datetime',
            'time_zone_offset' => 'Time Zone Offset',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function afterSave($insert, $changedAttributes) {

        $model = new history\RequestHelpHistory();
        $model->setAttributes($this->attributes);
        $model->parent_id = $this->id;
        $model->save();
        return true;
    }

    public function getApp_user() {
        return $this->hasOne(AppUser::className(), ['id' => 'app_user_id']);
    }

    public function getActivity_detail() {
        switch ($this->master_category_id) {
            case GenralModel::CATEGORY_FOOD:
                return $this->hasMany(RequestFoodDetail::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_PEOPLE:
                return $this->hasMany(RequestPeopleDetail::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_SHELTER:
                return $this->hasMany(RequestShelterDetail::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_MED_PPE:
                return $this->hasMany(RequestMedPpeDetail::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_TESTING:
                return $this->hasMany(RequestTestingDetail::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_MEDICINES:
                return $this->hasMany(RequestMedicineDetail::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_AMBULANCE:
                return $this->hasMany(RequestAmbulanceDetail::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_MEDICAL_EQUIPMENT:
                return $this->hasMany(RequestMedicalEquipmentDetail::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_OTHERS:
                return $this->hasMany(RequestOthersDetail::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
                break;
            default:
        }
    }

    public function getDetail($type = "partial") {
        $return = array();

        $return['activity_type'] = GenralModel::HELP_TYPE_REQUEST;
        $return['activity_uuid'] = $this->request_uuid;
        $return['date_time'] = \app\helpers\Utility::convertDateTimetoTZFormat($this->datetime, $this->time_zone_offset);
        $return['activity_category'] = $this->master_category_id;
        $return['activity_count'] = $this->no_of_items;
        $return['geo_location'] = $this->lat . "," . $this->lng;
        $return['activity_detail'] = $this->activity_detail;

        if ($type == "full") {
            $return['app_user_id'] = $this->app_user_id;
            $return['app_user_detail'] = $this->app_user->detail;
        }

        return $return;
    }

    public function getCategory() {
        return $this->hasOne(\app\models\MasterCategory::className(), ['id' => 'master_category_id']);
    }

}
