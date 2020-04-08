<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $session_id
 * @property string $ip
 * @property integer $logintime
 * @property integer $lastactivetime
 */
class UserLog extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_log';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'session_id', 'ip'], 'required'],
            [['user_id', 'logintime', 'lastactivetime'], 'integer'],
            [['session_id'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'session_id' => 'Session ID',
            'ip' => 'Ip',
            'logintime' => 'Logintime',
            'lastactivetime' => 'Lastactivetime',
        ];
    }

    public function loger() {
        $this->user_id = Yii::$app->user->identity->id;
        $this->session_id = Yii::$app->session->id;
        $this->ip = Yii::$app->getRequest()->getUserIP();
        $this->save();
    }

    public function beforeSave($insert) {

        if ($this->isNewRecord) {
            $this->logintime = time();
            $this->lastactivetime = time();
            return parent::beforeSave($insert);
        } else {
            $this->lastactivetime = time();
        }
        return true;
    }

}
