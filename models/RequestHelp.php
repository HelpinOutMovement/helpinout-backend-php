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
 * @property float $accuracy
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
            [['app_user_id', 'api_log_id', 'master_category_id', 'no_of_items', 'payment', 'created_at', 'updated_at', 'status'], 'integer'],
            [['api_log_id', 'request_uuid', 'master_category_id', 'no_of_items', 'location', 'lat', 'lng', 'accuracy', 'address', 'datetime', 'time_zone_offset'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            //[['location'], 'string'],
            [['lat', 'lng', 'accuracy'], 'number'],
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

    public function add() {
        
    }

    public function inactivate() {
        $this->status = 0;
        $this->save();
    }

    public function getApp_user() {
        return $this->hasOne(AppUser::className(), ['id' => 'app_user_id']);
    }

    public function getCategory() {
        return $this->hasOne(\app\models\MasterCategory::className(), ['id' => 'master_category_id']);
    }

    public function getMapping() {
        return $this->hasMany(HelpinoutMapping::className(), ['request_help_id' => 'id'])->where(['status' => 1]);
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

    public function getDetail($detail = TRUE, $app_user = TRUE, $mapping = FALSE) {
        $return = array();

        $return['activity_type'] = GenralModel::HELP_TYPE_REQUEST;
        $return['activity_uuid'] = $this->request_uuid;
        $return['date_time'] = \app\helpers\Utility::convertDateTimetoTZFormat($this->datetime, $this->time_zone_offset);
        $return['activity_category'] = $this->master_category_id;
        $return['activity_count'] = $this->no_of_items;
        $return['geo_location'] = $this->lat . "," . $this->lng;
        $return['status'] = $this->status;

        if ($detail) {
            foreach ($this->activity_detail as $ac_d) {
                $ac_d = $ac_d->toArray();
                unset($ac_d['id']);
                unset($ac_d['request_help_id']);
                unset($ac_d['status']);
                if (isset($ac_d['quantity'])) {
                    $ac_d['quantity'] == null || $ac_d['quantity'] == "null" ? "" : $ac_d['quantity'];
                }
                $return['activity_detail'][] = $ac_d;
            }
        }

        if ($app_user) {
            $return['user_detail'] = $this->app_user->detail;
        }

        if ($mapping) {
            foreach ($this->mapping as $mapping) {
                $temp = array();
                $temp['offer_detail'] = $mapping->offerdetail->getDetail(true, true, false);
                $temp['status'] = $mapping->status;
                $temp['mapping_initiator'] = $mapping->mapping_initiator;
                if (isset($mapping->rate_report_for_offerer))
                    $temp['rate_report'] = $mapping->rate_report_for_offerer->detail;
                else
                    $temp['rate_report'] = '{}';
                $return['mapping'][] = $temp;
            }
        }
        return $return;
    }

    public function getMappingoffer() {
        return $this->hasMany(HelpinoutMapping::className(), ['request_help_id' => 'id'])->where(['status' => 1])->andWhere(['=', 'mapping_initiator', 1])->count();
    }

    public function getMappingrequest() {
        return $this->hasMany(HelpinoutMapping::className(), ['request_help_id' => 'id'])->where(['status' => 1])->andWhere(['=', 'mapping_initiator', 2])->count();
    }

}
