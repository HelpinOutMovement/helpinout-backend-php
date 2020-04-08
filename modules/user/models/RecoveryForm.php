<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\modules\user\models;

use app\modules\user\Finder;
use app\modules\user\Mailer;
use yii\base\Model;

/**
 * Model for collecting data on password recovery.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RecoveryForm extends Model {
   const SCENARIO_REQUEST = 'request';
   const SCENARIO_RESET = 'reset';
    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var User */
    protected $user;

    /** @var \dektrium\user\Module */
    protected $module;

    /** @var Mailer */
    protected $mailer;

    /** @var Finder */
    protected $finder;

    /**
     * @param Mailer $mailer
     * @param Finder $finder
     * @param array  $config
     */
    public function __construct(Mailer $mailer, Finder $finder, $config = []) {
        $this->module = \Yii::$app->getModule('user');
        $this->mailer = $mailer;
        $this->finder = $finder;
        parent::__construct($config);
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'email' => \Yii::t('user', 'Email'),
            'password' => \Yii::t('user', 'Password'),
        ];
    }

    /** @inheritdoc */
    public function scenarios() {
        return [
            'request' => ['email'],
            'reset' => ['password']
        ];
    }

    /** @inheritdoc */
    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => $this->module->modelMap['User'],
                'message' => \Yii::t('user', 'There is no user with such email.')
            ],
            ['email', function ($attribute) {
                    $this->user = $this->finder->findUserByEmail($this->email);
                    if ($this->user->blocked_at !='') {
                        $this->addError($attribute, \Yii::t('user', 'This user is blocked'));
                    }
                }],
            ['email', function ($attribute) {
                    $this->user = $this->finder->findUserByEmail($this->email);
                    if ($this->user !== null && $this->module->enableConfirmation && !$this->user->getIsConfirmed()) {
                        $this->addError($attribute, \Yii::t('user', 'You need to confirm your email address'));
                    }
                }],
           ['email', function ($attribute) {
                        $this->user = $this->finder->findUserByEmail($this->email);
                        if($this->user->role_id==5){
                           $iti_model = \app\models\ItiList::find()->where(['user_id' => $this->user->id])->one();
                           if($iti_model!=''){
                               if($iti_model->email_sent_time==''){
                                 $this->addError($attribute, \Yii::t('user','This user is inactive'));
                               }
                           }
                        }
                    
                }],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Sends recovery message.
     *
     * @return bool
     */
    public function sendRecoveryMessage() {
        if ($this->validate()) {
            /** @var Token $token */
            $token = \Yii::createObject([
                        'class' => Token::className(),
                        'user_id' => $this->user->id,
                        'type' => Token::TYPE_RECOVERY
            ]);
            $token->save(false);
            $this->mailer->sendRecoveryMessage($this->user, $token);
            \Yii::$app->session->setFlash('info', \Yii::t('user', 'You will receive an email with instructions on how to reset your password in a few minutes.'));
            return true;
        }

        return false;
    }

    /**
     * Resets user's password.
     *
     * @param  Token $token
     * @return bool
     */
    public function resetPassword(Token $token) {
        if (!$this->validate() || $token->user === null) {
            return false;
        }

        if ($token->user->resetPassword($this->password)) {
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your password has been changed successfully.'));
            $token->delete();
        } else {
            \Yii::$app->session->setFlash('danger', \Yii::t('user', 'An error occurred and your password has not been changed. Please try again later.'));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function formName() {
        return 'recovery-form';
    }

}
