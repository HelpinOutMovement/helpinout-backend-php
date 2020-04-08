<?php

namespace app\modules\user\models;

use yii;
use app\modules\user\helpers\Password;
use app\modules\user\Mailer;
use app\modules\user\Module;
use yii\base\Model;
use yii\base\NotSupportedException;

/**
 * ChangePasswordForm gets user's password,currentpassword,re_password and changes them.
 *
 * @property User $user
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ChangePasswordForm extends Model {

    /** @var string */
    public $new_password;
    public $re_password;

    /** @var string */
    public $current_password;

    /** @var Module */
    protected $module;

    /** @var Mailer */
    protected $mailer;

    /** @var User */
    private $_user;

    /** @return User */
    public function getUser() {
        if ($this->_user == null) {
            $this->_user = \Yii::$app->user->identity;
        }

        return $this->_user;
    }

    /** @inheritdoc */
    public function __construct(Mailer $mailer, $config = []) {
        $this->mailer = $mailer;
        $this->module = \Yii::$app->getModule('user');
        parent::__construct($config);
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [['new_password', 're_password', 'current_password'], 'required'],
            ['new_password', 'string', 'min' => 6],
            ['re_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "Passwords don't match"],
            ['current_password', function ($attr) {
                    if (!Password::validate($this->$attr, $this->user->password_hash)) {
                        $this->addError($attr, \Yii::t('user', 'Current password is not valid'));
                    }
                }]
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'new_password' => \Yii::t('user', 'New password'),
            're_password' => 'Re Password',
            'current_password' => \Yii::t('user', 'Current password')
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'change-password-form';
    }

    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save() {
        if ($this->validate()) {
            $this->user->scenario = 'changepassword';
            $this->user->password = $this->new_password;
            $this->user->actual_password = $this->new_password;

            return $this->user->save();
        }

        return false;
    }

}
