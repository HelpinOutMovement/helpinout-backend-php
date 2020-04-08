<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_user".
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
 * @property string|null $org_type
 * @property string|null $org_divison
 * @property int $status
 */
class AppUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_zone', 'time_zone_offset', 'country_code', 'mobile_no', 'first_name', 'last_name'], 'required'],
            [['time_zone_offset'], 'safe'],
            [['mobile_no_visibility', 'user_type', 'status'], 'integer'],
            [['time_zone'], 'string', 'max' => 30],
            [['country_code'], 'string', 'max' => 10],
            [['mobile_no'], 'string', 'max' => 12],
            [['first_name', 'last_name'], 'string', 'max' => 60],
            [['org_name', 'org_divison'], 'string', 'max' => 256],
            [['org_type'], 'string', 'max' => 120],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time_zone' => 'Time Zone',
            'time_zone_offset' => 'Time Zone Offset',
            'country_code' => 'Country Code',
            'mobile_no' => 'Mobile No',
            'mobile_no_visibility' => 'Mobile No Visibility',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'user_type' => 'Organization',
            'org_name' => 'Organization Name',
            'org_type' => 'Organization Type',
            'org_divison' => 'Organization Divison',
            'status' => 'Status',
        ];
    }

}
