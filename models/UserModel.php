<?php

namespace app\models;

use app\modules\user\models\User as baseUser;
use app\modules\user\helpers\Password;

/**
 * User ActiveRecord model.
 *
 * @property string    $rolename
 */
class UserModel extends baseUser {

    const ROLE_SUPERADMIN = 0;
    const ROLE_ADMIN = 1;
    const ROLE_DC = 2;
    const ROLE_FIELDSTAFF = 3;
    const ROLE_QC = 4;
    const ROLE_ITI = 5;
    const ROLE_DGT = 6;
    const ROLE_QS = 7;
    const ROLE_ADMIN_SUPPORT = 8;
     const ROLE_CGC = 9;

    public function scenarios() {
        $scenarios = parent::scenarios();
        // add field to scenarios
        $scenarios['create'][] = 'name';
        $scenarios['update'][] = 'name';
        $scenarios['register'][] = 'name';
        $scenarios['create'][] = 'mobile_no';
        $scenarios['update'][] = 'mobile_no';
        $scenarios['create'][] = 'last_password_change_date';
        $scenarios['update'][] = 'last_password_change_date';
        $scenarios['create'][] = 'login_attempt';
        $scenarios['update'][] = 'login_attempt';
        $scenarios['register'][] = 'mobile_no';
        $scenarios['create'][] = 'role_id';
        return $scenarios;
    }

    public function rules() {
        $rules = parent::rules();
        // add some rules
        $rules['fieldRequired'] = [['name', 'role_id'], 'required'];
        $rules['fieldLength'] = ['name', 'string', 'max' => 150, 'min' => '3'];
       // $rules['fieldupds'] = ['upd', 'safe'];
        $rules['fieldchangedate'] = ['last_password_change_date', 'safe'];
        $rules['fieldnameTrim'] = ['name', 'trim'];
        $rules['fieldmobiledefault'] = ['mobile_no', 'default', 'value' => ''];
        $rules['fieldrole'] = ['role', 'default', 'value' => 0];
        $rules['attempt'] = ['login_attempt', 'safe'];
        $rules['fieldstatus'] = ['status_check', 'safe'];

        return $rules;
    }

    public function getIsAdmin() {
        return $this->role_id == self::ROLE_ADMIN;
    }

    public function getIsDc() {
        return $this->role_id == self::ROLE_DC;
    }
     public function getIsCgc() {
        return $this->role_id == self::ROLE_CGC;
    }

    public function getIsFieldstaff() {
        return $this->role_id == self::ROLE_FIELDSTAFF;
    }

    public function getIsIti() {
        return $this->role_id == self::ROLE_ITI;
    }

    public function getIsSuperadmin() {
        return $this->role_id == self::ROLE_SUPERADMIN;
    }
    public function getIsAdminsupport() {
        return $this->role_id == self::ROLE_ADMIN_SUPPORT;
    }

    public function getIsQc() {
        return $this->role_id == self::ROLE_QC;
    }

    public function getIsQs() {
        return $this->role_id == self::ROLE_QS;
    }

    public function getIsDgt() {
        return $this->role_id == self::ROLE_DGT;
    }

    public function getRole() {
        return $this->hasOne(MasterRole::className(), ['id' => 'role_id']);
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            if (\Yii::$app instanceof WebApplication) {
                $this->setAttribute('registration_ip', \Yii::$app->request->userIP);
            }
        }

        if (!empty($this->password)) {
           // $this->setAttribute('upd', rand('100', '999') . $this->password);
            $this->setAttribute('password_hash', Password::hash($this->password));
        }

        return parent::beforeSave($insert);
    }

    public function getUserid() {
        return $this->hasOne(\app\models\UserManagement::className(), ['user_id' => 'id']);
    }

}
