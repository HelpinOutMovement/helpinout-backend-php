<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use app\models\AppUser;
use app\models\AppRegistration;

/**
 * MeetingForm is the model behind the Meeting.
 */
class LoginRegisterForm extends Model {

    public $app_user;
    public $app_register;
    public $time_zone;
    public $time_zone_offset;
    public $country_code;
    public $mobile_no;
    public $mobile_no_visibility;
    public $first_name;
    public $last_name;
    public $profile_name;
    public $user_type;
    public $org_name;
    public $org_type;
    public $org_division;
    public $imei_no;
    public $os_type;
    public $manufacturer_name;
    public $os_version;
    public $firebase_token;
    public $app_version;
    public $date_of_install;
    public $date_of_uninstall;

    const SCENARIO_LOGIN = "login";
    const SCENARIO_REGISTER = "register";
    const SCENARIO_UPDATE = "update";

    public function __construct($app_user = null) {
        if ($app_user != null)
            $this->app_user = $app_user;
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['time_zone', 'time_zone_offset', 'country_code', 'mobile_no', 'first_name', 'last_name', 'profile_name', 'firebase_token', 'imei_no', 'os_type', 'app_version', 'manufacturer_name', 'os_version', 'mobile_no_visibility', 'user_type'], 'required', 'on' => [LoginRegisterForm::SCENARIO_REGISTER]],
            [['time_zone', 'time_zone_offset', 'country_code', 'mobile_no', 'firebase_token', 'imei_no', 'os_type', 'app_version', 'manufacturer_name', 'os_version',], 'required', 'on' => [LoginRegisterForm::SCENARIO_LOGIN]],
            [['mobile_no_visibility', 'user_type', 'org_type'], 'integer'],
            [['time_zone'], 'string', 'max' => 30],
            [['country_code'], 'string', 'max' => 10],
            [['mobile_no'], 'string', 'max' => 12],
            [['first_name', 'last_name'], 'string', 'max' => 60],
            [['first_name', 'last_name', 'profile_name', 'mobile_no_visibility', 'user_type'], 'required', 'on' => [LoginRegisterForm::SCENARIO_REGISTER]],
            [['first_name', 'last_name', 'profile_name', 'mobile_no_visibility', 'user_type'], 'required', 'on' => [LoginRegisterForm::SCENARIO_UPDATE]],
            [['profile_name'], 'safe'],
            [['profile_name'], 'string', 'max' => 125],
            [['org_name', 'org_division'], 'string', 'max' => 256],
            [['imei_no', 'os_type', 'app_version'], 'string', 'max' => 100],
            [['manufacturer_name', 'os_version'], 'string', 'max' => 150],
        ];
    }

    public function login() {
        $this->addApp();
    }

    public function register() {
        $this->addUser();
        $this->addApp();
    }

    public function update() {
        $this->app_user->time_zone_offset = $this->time_zone_offset;
        $this->app_user->time_zone = $this->time_zone;

        $this->app_user->mobile_no_visibility = $this->mobile_no_visibility;
        $this->app_user->first_name = $this->first_name;
        $this->app_user->last_name = $this->last_name;
        $this->app_user->profile_name = (isset($this->profile_name) && $this->profile_name != "" ) ? $this->profile_name : $this->first_name . " " . $this->last_name;
        $this->app_user->user_type = $this->user_type;
        $this->app_user->org_name = $this->org_name;
        $this->app_user->master_app_user_org_type = $this->org_type;
        $this->app_user->org_division = $this->org_division;
        $this->app_user->save();
    }

    private function addUser() {
        $this->app_user = new AppUser();

        $this->app_user->time_zone_offset = $this->time_zone_offset;
        $this->app_user->time_zone = $this->time_zone;

        $this->app_user->country_code = $this->country_code;
        $this->app_user->mobile_no = $this->mobile_no;
        $this->app_user->mobile_no_visibility = $this->mobile_no_visibility;
        $this->app_user->first_name = $this->first_name;
        $this->app_user->last_name = $this->last_name;
        $this->app_user->profile_name = (isset($this->profile_name) && $this->profile_name != "" ) ? $this->profile_name : $this->first_name . " " . $this->last_name;
        $this->app_user->user_type = $this->user_type;
        $this->app_user->org_name = $this->org_name;
        $this->app_user->master_app_user_org_type = $this->org_type;
        $this->app_user->org_division = $this->org_division;
        $this->app_user->save();
    }

    private function addApp() {

        AppRegistration::updateAll(['date_of_uninstall' => new Expression('NOW()'), 'status' => 0], 'app_user_id ="' . $this->app_user->id . '" and status=' . '1');

        $this->app_register = new AppRegistration();
        $this->app_register->app_user_id = $this->app_user->id;
        $this->app_register->imei_no = $this->imei_no;
        $this->app_register->os_type = $this->os_type;
        $this->app_register->manufacturer_name = $this->manufacturer_name;
        $this->app_register->os_version = $this->os_version;
        $this->app_register->app_version = $this->app_version;
        $this->app_register->firebase_token = $this->firebase_token;

        $this->app_register->time_zone = $this->time_zone;
        $this->app_register->time_zone_offset = $this->time_zone_offset;

        $this->app_register->date_of_install = new Expression('NOW()');

        $this->app_register->save();
    }

}
