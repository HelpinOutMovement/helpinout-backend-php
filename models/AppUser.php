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
 * @property int|null $master_app_user_org_type
 * @property string|null $org_division
 * @property int $status
 */
class AppUser extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
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
            [['mobile_no_visibility', 'user_type', 'master_app_user_org_type', 'status'], 'integer'],
            [['time_zone'], 'string', 'max' => 30],
            [['country_code'], 'string', 'max' => 10],
            [['mobile_no'], 'string', 'max' => 12],
            [['first_name', 'last_name'], 'string', 'max' => 60],
            [['org_name', 'org_division'], 'string', 'max' => 256],
            [['status'],'default','value'=>'1'],
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
            'user_type' => 'User Type',
            'org_name' => 'Org Name',
            'master_app_user_org_type' => 'App User Org Type',
            'org_division' => 'Org Divison',
            'status' => 'Status',
        ];
    }

    public function afterSave($insert, $changedAttributes) {

        $model = new history\AppUserHistory();
        $model->setAttributes($this->attributes);
        $model->parent_id = $this->id;

        $model->save();

        return true;
    }

    public function getDetail($type = "Array") {
        $return = array();

        $return['country_code'] = $this->country_code;
        $return['mobile_no'] = $this->mobile_no;
        $return['first_name'] = $this->first_name;
        $return['last_name'] = $this->last_name;
        $return['mobile_no_visibility'] = $this->mobile_no_visibility;
        $return['user_type'] = $this->user_type;
        $return['org_name'] = $this->org_name;
        $return['org_type'] = $this->master_app_user_org_type;
        $return['org_division'] = $this->org_division;

        return $return;
    }
public function getUser()
{
    return $this->first_name . ' ' . $this->last_name;
   
}
public function getAppuserorgtype()
{
    return $this->hasOne(\app\models\MasterAppUserOrganizationType::className(),['id'=>'master_app_user_org_type']);
}
}
