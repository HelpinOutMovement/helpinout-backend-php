<?php

namespace app\models\history;

use Yii;

/**
 * This is the model class for table "request_help_history".
 *
 * @property int $id
 * @property int $app_user_id
 * @property int $self_else
 * @property string $request_uuid
 * @property int $master_category_id
 * @property int $no_of_items
 * @property string $location
 * @property float $lat
 * @property float $lng
 * @property float $accuracy
 * @property int $payment 0=canot pay, 1=can pay
 * @property string $address
 * @property string|null $request_note
 * @property string $datetime
 * @property string $time_zone_offset
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property int $parent_id
 */
class RequestHelpHistory extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'request_help_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['app_user_id', 'self_else', 'request_uuid', 'master_category_id', 'no_of_items', 'location', 'lat', 'lng', 'accuracy', 'address', 'datetime', 'time_zone_offset', 'created_at', 'updated_at', 'parent_id'], 'required'],
            [['app_user_id', 'master_category_id', 'no_of_items', 'payment', 'created_at', 'updated_at', 'status', 'parent_id'], 'integer'],
            //[['location'], 'string'],
            [['lat', 'lng', 'accuracy'], 'number'],
            [['datetime', 'time_zone_offset'], 'safe'],
            [['request_uuid'], 'string', 'max' => 36],
            [['address', 'request_note'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'app_user_id' => 'App User ID',
            'self_else' => 'Self Else',
            'request_uuid' => 'Request Uuid',
            'master_category_id' => 'Master Category ID',
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
            'parent_id' => 'Parent ID',
        ];
    }

}
