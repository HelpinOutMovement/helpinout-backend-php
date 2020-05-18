<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "helpinout_mapping".
 *
 * @property int $id
 * @property int $request_help_id
 * @property int $offer_help_id
 * @property int $mapping_initiator  1=requester, 2=offerer
 * @property int $request_app_user_id
 * @property int $offer_app_user_id
 * @property float $distance
 * @property int|null $call_initiated
 * @property int|null $mapping_delete_by      1=requester, 2=offerer
 * @property string $datetime
 * @property string $time_zone_offset
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class HelpinoutMapping extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public $app_user;

    public static function tableName() {
        return 'helpinout_mapping';
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
            [['request_help_id', 'offer_help_id', 'mapping_initiator', 'request_app_user_id', 'offer_app_user_id', 'distance', 'time_zone_offset'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['request_help_id', 'offer_help_id', 'mapping_initiator', 'request_app_user_id', 'offer_app_user_id', 'call_initiated', 'mapping_delete_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['distance'], 'number'],
            [['datetime', 'time_zone_offset'], 'safe'],
            [['request_help_id', 'offer_help_id', 'mapping_initiator'], 'unique', 'targetAttribute' => ['request_help_id', 'offer_help_id', 'mapping_initiator']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'request_help_id' => 'Request Help ID',
            'offer_help_id' => 'Offer Help ID',
            'mapping_initiator' => 'Request Mapping Initiator',
            'call_initiated' => 'Call Initiated',
            'mapping_delete_by' => 'Mapping Delete By',
            'datetime' => 'Datetime',
            'time_zone_offset' => 'Time Zone Offset',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getOfferdetail() {
        return $this->hasOne(OfferHelp::className(), ['id' => 'offer_help_id']);
    }

    public function getRequestdetail() {
        return $this->hasOne(RequestHelp::className(), ['id' => 'request_help_id']);
    }

    public function getRate_report() {
        return $this->hasMany(HelpinoutRateReport::className(), ['helpinout_mapping_id' => 'id']);
    }

    public function getRate_report_for_requester() {
        return $this->hasOne(HelpinoutRateReport::className(), ['helpinout_mapping_id' => 'id'])->where(['rating_taken_for' => '1']);
    }

    public function getRate_report_for_offerer() {
        return $this->hasOne(HelpinoutRateReport::className(), ['helpinout_mapping_id' => 'id'])->where(['rating_taken_for' => '2']);
    }

}
