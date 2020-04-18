<?php

namespace app\models\form;

use yii;
use yii\base\Model;
use yii\validators\Validator;
use app\models\UserModel;

class UserForm extends Model {

    public $id;
    public $name;
    // public $username;
    public $mobile_no;
    public $email;
    //  public $confirm_password;
    public $password;
    public $role_id;
    public $role;
//    public $upd;
    public $district_code;
    public $block_code;
    public $blocked_at;
    public $facility_id;
    public $user_role_type_id;
    public $user_model;
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';

    public function __construct($user_model = null) {


        $this->user_model = yii::createObject(['class' => UserModel::classname()]);
        if ($user_model != null) {

            $this->user_model = $user_model;
            $this->id = $this->user_model->id;
            //$this->username = $this->user_model->username;
            $this->mobile_no = $this->user_model->mobile_no;
            $this->role_id = $this->user_model->role_id;
            $this->email = $this->user_model->email;
            $this->name = $this->user_model->name;
            //  $this->upd = $this->user_model->upd;
        }
    }

    public function rules() {
        $rules = [
            [['mobile_no', 'name', 'email', 'password', 'role_id'], 'required', 'message' => 'Is required'],
            // ['username', 'trim'],
//            ['username', 'match', 'pattern' => static::$usernameRegexp],
//            ['username', 'string', 'min' => 3, 'max' => 255],
            ['password', 'string', 'min' => 8, 'max' => 72],
            [['mobile_no'], \app\validators\ContactNumberValidator::className()],
//            [['username'], 'unique', 'when' => function($model, $attribute) {
//                    return $this->user_model->$attribute != $model->$attribute;
//                }, 'targetClass' => \app\models\UserModel::className(), 'message' => 'This username has already been taken'],
            [['email'], 'unique', 'when' => function($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                }, 'targetClass' => \app\models\UserModel::className(), 'message' => 'This Email id already exist please use another email id'],
            [['password'], 'required', 'on' => 'create', 'message' => 'Is required'],
            //   [['confirm_password'], 'compare', 'compareAttribute' => 'password', 'operator' => '=='],
            [['role_id', 'blocked_at'], 'safe']
        ];
        return $rules;
    }

    public function attributeLabels() {
        $label = [
            'name' => 'Name',
            'mobile_no' => 'Mobile No.',
            'role_id' => 'Role',
            // 'confirm-password' => 'Confirm Password',
            //'username' => 'Username',
            'password' => 'Password',
            'email' => 'email',
            'district_code' => 'District',
            'block_code' => 'Block',
            'facility_id' => 'Facility',
            'user_role_type_id' => 'Role Type',
        ];
        return $label;
    }

}
