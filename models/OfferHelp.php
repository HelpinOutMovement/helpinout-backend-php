<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\base\GenralModel;

/**
 * This is the model class for table "offer_help".
 *
 * @property int $id
 * @property int $app_user_id
 * @property int $api_log_id
 * @property string $offer_uuid
 * @property int $master_category_id
 * @property int $no_of_items
 * @property string $location
 * @property float $lat
 * @property float $lng
 * @property int $accuracy
 * @property int $payment 0=for free, 1=want money
 * @property string $address
 * @property string $offer_condition
 * @property string $datetime
 * @property string $time_zone_offset
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class OfferHelp extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'offer_help';
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
            [['api_log_id', 'offer_uuid', 'master_category_id', 'no_of_items', 'location', 'lat', 'lng', 'accuracy', 'address', 'offer_condition', 'datetime', 'time_zone_offset',], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            //[['location'], 'string'],
            [['lat', 'lng'], 'number'],
            [['datetime', 'time_zone_offset'], 'safe'],
            [['offer_uuid'], 'string', 'max' => 36],
            [['address', 'offer_condition'], 'string', 'max' => 512],
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
            'offer_uuid' => 'Offer Uuid',
            'master_category_id' => 'Master Category',
            'no_of_items' => 'No Of Items',
            'location' => 'Location',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'accuracy' => 'Accuracy',
            'payment' => 'Payment',
            'address' => 'Address',
            'offer_condition' => 'Offer Condition',
            'datetime' => 'Datetime',
            'time_zone_offset' => 'Time Zone Offset',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function afterSave($insert, $changedAttributes) {

        $model = new history\OfferHelpHistory();
        $model->setAttributes($this->attributes);
        $model->parent_id = $this->id;
        $model->save();
        return true;
    }

    public function getActivity_detail() {
        switch ($this->master_category_id) {
            case GenralModel::CATEGORY_FOOD:
                return $this->hasMany(OfferFoodDetail::className(), ['offer_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_PEOPLE:
                return $this->hasMany(OfferPeopleDetail::className(), ['offer_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_SHELTER:
                return $this->hasMany(OfferShelterDetail::className(), ['offer_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_MED_PPE:
                return $this->hasMany(OfferMedPpeDetail::className(), ['offer_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_TESTING:
                return $this->hasMany(OfferTestingDetail::className(), ['offer_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_MEDICINES:
                return $this->hasMany(OfferMedicineDetail::className(), ['offer_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_AMBULANCE:
                return $this->hasMany(OfferAmbulanceDetail::className(), ['offer_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_MEDICAL_EQUIPMENT:
                return $this->hasMany(OfferMedicalEquipmentDetail::className(), ['offer_help_id' => 'id'])->where(['status' => 1]);
                break;
            case GenralModel::CATEGORY_OTHERS:
                return $this->hasMany(OfferOthersDetail::className(), ['offer_help_id' => 'id'])->where(['status' => 1]);
                break;
            default:
        }
    }

    public function getDetail($type = "partial") {
        $return = array();

        $return['activity_type'] = GenralModel::HELP_TYPE_OFFER;
        $return['activity_uuid'] = $this->offer_uuid;
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
