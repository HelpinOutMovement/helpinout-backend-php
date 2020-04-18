<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "app_registration".
 *
 * @property int $id
 * @property int $app_user_id
 * @property string|null $imei_no
 * @property string|null $os_type
 * @property string|null $manufacturer_name
 * @property string|null $os_version
 * @property string|null $firebase_token
 * @property string|null $app_version
 * @property string|null $time_zone
 * @property string $time_zone_offset
 * @property string $date_of_install
 * @property string|null $date_of_uninstall
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class AppRegistration extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'app_registration';
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
            [['app_user_id', 'time_zone_offset', 'date_of_install'], 'required'],
            [['app_user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['firebase_token'], 'string'],
            [['time_zone_offset', 'date_of_install', 'date_of_uninstall'], 'safe'],
            [['imei_no', 'os_type', 'app_version'], 'string', 'max' => 100],
            [['manufacturer_name', 'os_version'], 'string', 'max' => 150],
            [['time_zone'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'app_user_id' => 'App User ID',
            'imei_no' => 'Imei No',
            'os_type' => 'Os Type',
            'manufacturer_name' => 'Manufacturer Name',
            'os_version' => 'Os Version',
            'firebase_token' => 'Firebase Token',
            'app_version' => 'App Version',
            'time_zone' => 'Time Zone',
            'time_zone_offset' => 'Time Zone Offset',
            'date_of_install' => 'Date Of Install',
            'date_of_uninstall' => 'Date Of Uninstall',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getAppUser() {
        return $this->hasOne(AppUser::className(), ['id' => 'app_user_id']);
    }

}
