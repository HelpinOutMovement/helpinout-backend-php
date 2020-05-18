<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

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
 * @property string $profile_name
 * @property int $user_type 1=Individual, 2=Organization
 * @property string|null $org_name
 * @property int|null $master_app_user_org_type
 * @property string|null $org_division
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class AppUser extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'app_user';
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
            [['time_zone', 'time_zone_offset', 'country_code', 'mobile_no', 'first_name', 'last_name', 'profile_name'], 'required'],
            [['time_zone_offset'], 'safe'],
            [['mobile_no_visibility', 'user_type', 'master_app_user_org_type', 'created_at', 'updated_at', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['time_zone'], 'string', 'max' => 30],
            [['country_code'], 'string', 'max' => 10],
            [['mobile_no'], 'string', 'max' => 12],
            [['first_name', 'last_name'], 'string', 'max' => 60],
            [['profile_name'], 'string', 'max' => 125],
            [['org_name', 'org_division'], 'string', 'max' => 256],
            [['country_code', 'mobile_no'], 'unique', 'targetAttribute' => ['country_code', 'mobile_no']],
            [['status'], 'default', 'value' => '1'],
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
            'profile_name' => 'Profile Name',
            'user_type' => 'User Type',
            'org_name' => 'Org Name',
            'master_app_user_org_type' => 'Master App User Org Type',
            'org_division' => 'Org Division',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

    public function getDetail() {
        $return = array();

        $return['country_code'] = $this->mobile_no_visibility == "1" ? $this->country_code : "";
        $return['mobile_no'] = $this->mobile_no_visibility == "1" ? $this->mobile_no : "";
        $return['country_code'] = $this->country_code;
        $return['mobile_no'] = $this->mobile_no;
        $return['first_name'] = $this->first_name;
        $return['last_name'] = $this->last_name;
        $return['profile_name'] = $this->profile_name;
        $return['mobile_no_visibility'] = $this->mobile_no_visibility;
        $return['user_type'] = $this->user_type;
        $return['org_name'] = $this->org_name;
        $return['org_type'] = $this->master_app_user_org_type;
        $return['org_division'] = $this->org_division;

        $rating = $this->avgrating;
        $return['rating_avg'] = $rating['avg'];
        $return['rating_count'] = $rating['count'];

        return $return;
    }

    public function getUsername() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getActiveapp() {
        return $this->hasOne(\app\models\AppRegistration::className(), ['app_user_id' => 'id'])->where(['status' => 1])->orderBy('date_of_uninstall desc');
    }

    public function getAppuserorgtype() {
        return $this->hasOne(\app\models\MasterAppUserOrganizationType::className(), ['id' => 'master_app_user_org_type']);
    }

    public function getAvgrating($activity_type = null) {

        $rating = [];

        if ($activity_type == null) {
            $command = Yii::$app->db->createCommand("SELECT avg(rating) as `avg`, count(rating) as `count` FROM helpinout_rate_report where offer_app_user_id='" . $this->id . "' or request_app_user_id='" . $this->id . "'");
        } else if ($activity_type == base\GenralModel::HELP_TYPE_REQUEST) {
            $command = Yii::$app->db->createCommand("SELECT avg(rating) as `avg`, count(rating) as `count` FROM helpinout_rate_report where   request_app_user_id='" . $this->id . "'");
        } else if ($activity_type == base\GenralModel::HELP_TYPE_REQUEST) {
            $command = Yii::$app->db->createCommand("SELECT avg(rating) as `avg`, count(rating) as `count` FROM helpinout_rate_report where offer_app_user_id='" . $this->id . "'");
        }

        $result = ($command->queryAll())[0];
        $rating['avg'] = (round($result['avg'] * 2)) / 2;
        $rating['count'] = (int) $result['count'];
        return $rating;
    }

}
