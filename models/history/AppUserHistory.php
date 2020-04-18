<?php

namespace app\models\history;

use Yii;

/**
 * This is the model class for table "app_user_history".
 *
 * @property int $id
 * @property string $time_zone
 * @property string $time_zone_offset
 * @property string $country_code
 * @property string $mobile_no
 * @property int $mobile_no_visibility
 * @property string $first_name
 * @property string $last_name
 * @property int $user_type
 * @property string|null $org_name
 * @property int|null $master_app_user_org_type
 * @property string|null $org_division
 * @property int $status
 * @property int $parent_id
 */
class AppUserHistory extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'app_user_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['time_zone', 'time_zone_offset', 'country_code', 'mobile_no', 'first_name', 'last_name', 'parent_id'], 'required'],
            [['time_zone_offset'], 'safe'],
            [['mobile_no_visibility', 'user_type', 'master_app_user_org_type', 'status', 'parent_id'], 'integer'],
            [['time_zone'], 'string', 'max' => 30],
            [['country_code'], 'string', 'max' => 10],
            [['mobile_no'], 'string', 'max' => 12],
            [['first_name', 'last_name'], 'string', 'max' => 60],
            [['org_name', 'org_division'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'time_zone' => 'Time Zone',
            'time_zone_offset' => 'Time Zone Offset',
            'country_code' => 'Country Code',
            'mobile_no' => 'Mobile No',
            'mobile_no_visibility' => 'Mobile No Visibility',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'user_type' => 'User Type',
            'org_name' => 'Org Name',
            'master_app_user_org_type' => 'Master App User Org Type',
            'org_division' => 'Org Divison',
            'status' => 'Status',
            'parent_id' => 'Parent ID',
        ];
    }

}
