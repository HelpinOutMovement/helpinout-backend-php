<?php

namespace app\modules\user\models;

use yii\rbac\DbManager;
use Yii;
use app\modules\user\Module;
use yii\base\Model;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class AddForm extends Model {

    /** @var string */
    public $email;

    /** @var string */
    public $username;

    /** @var string */
    public $password;
    public $role;

    /** @var User */
    protected $user;

    /** @var Module */
    protected $module;

    /** @inheritdoc */
    public function init() {
        $this->user = \Yii::createObject([
                    'class' => User::className(),
                    'scenario' => 'add'
        ]);
        $this->module = \Yii::$app->getModule('user');
    }

    /** @inheritdoc */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z]\w+$/'],
            ['username', 'required'],
            ['role', 'required'],
            ['username', 'unique', 'targetClass' => $this->module->modelMap['User'],
                'message' => \Yii::t('user', 'This username has already been taken')],
            ['username', 'string', 'min' => 3, 'max' => 20],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => $this->module->modelMap['User'],
                'message' => \Yii::t('user', 'This email address has already been taken')],
            ['password', 'required', 'skipOnEmpty' => $this->module->enableGeneratingPassword],
            ['password', 'string', 'min' => 6],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'email' => \Yii::t('user', 'Email'),
            'username' => \Yii::t('user', 'Username'),
            'password' => \Yii::t('user', 'Password'),
            'role' => \Yii::t('user', 'Role'),
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'add-form';
    }

    /**
     * Registers a new user account.
     * @return bool
     */
    public function save() {
        if (!$this->validate()) {
            return false;
        }

        $this->user->setAttributes([
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password
        ]);
        if ($this->user->create()) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($this->role);
            $auth->assign($role, $this->user->id);
        }
        return $this->user;
    }

}
