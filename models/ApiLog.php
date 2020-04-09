<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "api_log".
 *
 * @property int $id
 * @property string|null $imei_no
 * @property string $ip
 * @property string|null $request_datetime
 * @property string|null $request_time_zone_offset
 * @property string|null $request_body
 * @property string $request_url
 * @property int $app_registration_id
 * @property int $http_response_code
 * @property int $api_response_status
 * @property string|null $api_response_message
 * @property string|null $response
 * @property int $app_user_id
 * @property int $created_at
 */
class ApiLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'api_log';
    }
    
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'request_url', 'app_user_id', 'created_at'], 'required'],
            [['request_datetime', 'request_time_zone_offset'], 'safe'],
            [['request_body', 'response'], 'string'],
            [['app_registration_id', 'http_response_code', 'api_response_status', 'app_user_id', 'created_at'], 'integer'],
            [['imei_no'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 25],
            [['request_url'], 'string', 'max' => 200],
            [['api_response_message'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imei_no' => 'Imei No',
            'ip' => 'Ip',
            'request_datetime' => 'Request Datetime',
            'request_time_zone_offset' => 'Request Time Zone Offset',
            'request_body' => 'Request Body',
            'request_url' => 'Request Url',
            'app_registration_id' => 'App Registration ID',
            'http_response_code' => 'Http Response Code',
            'api_response_status' => 'Api Response Status',
            'api_response_message' => 'Api Response Message',
            'response' => 'Response',
            'app_user_id' => 'App User ID',
            'created_at' => 'Created At',
        ];
    }

    public function getAppdetail() {
        return $this->hasOne(AppRegistration::className(), ['id' => 'app_registration_id']);
    }

}
