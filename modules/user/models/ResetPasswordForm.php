<?php

namespace app\modules\user\models;

use yii;
use app\modules\user\helpers\Password;
use app\modules\user\Mailer;
use app\modules\user\Module;
use yii\base\Model;
use app\components\mail\AmazonMail;
use \app\modules\user\helpers\MailMessage;
use yii\base\NotSupportedException;
use yii\db\Expression;

/**
 * ChangePasswordForm gets user's password,currentpassword,re_password and changes them.
 *
 * @property User $user
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ResetPasswordForm extends Model {

    /** @var string */
    public $new_password;
    public $re_password;
    public $mail_to_member;

    /** @var Module */
    protected $module;

    /** @var Mailer */
    protected $mailer;

    /** @var User */
    private $_user;
    public $user;

    public function init() {
        if (isset($_GET["member_id"])) {
            $this->user = User::findOne($_GET["member_id"]);
        } else {
            $this->user = \Yii::createObject([
                        'class' => User::className(),
            ]);
        }
        $this->module = \Yii::$app->getModule('user');
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
            [['new_password', 're_password'], 'required'],
            ['new_password', 'string', 'min' => 6],
            ['re_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "Passwords don't match"],
            [['mail_to_member'], 'safe'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'new_password' => \Yii::t('user', 'New password'),
            're_password' => 'Re Password',
            'mail_to_member' => \Yii::t('user', 'Send Mail To Member')
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'rest-password-form';
    }

    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save() {
        if ($this->validate()) {

            $this->user->password = $this->new_password;
            $this->user->actual_password = $this->new_password;
            $this->user->scenario = 'changepassword';
            if ($this->user->save()) {
                if ($this->mail_to_member) {
                    $mail = new AmazonMail($this->user->email, MailMessage::resetpassword($this->user), 'Reset Password - NRB Alert System', \Yii::$app->params['amazon_mail_from'], \Yii::$app->params['amazon_retun_path']);
                    $mail->enableSendMail = \Yii::$app->params['amazon_mail_enable'];
                    if ($mail->enableSendMail) {
                        $mailr = $mail->Send();
                        $user_mail_log = new \app\models\UserMailSendLog();
                        $user_mail_log->user_id = $this->user->id;
                        $user_mail_log->email_id = $this->user->email;
                        $user_mail_log->mail_send_time = new Expression('NOW()');
                        $user_mail_log->msg = MailMessage::resetpassword($this->user);
                        $user_mail_log->service = $mail->service;
                        if (isset($mailr['MessageId'])) {
                            $user_mail_log->service_provider_id = $mailr['MessageId'];
                            $user_mail_log->request_id = $mailr['RequestId'];
                        }
                        if ($user_mail_log->save()) {
                            
                        } else {
                            
                        }
                    }
                }
            }

            return $this->user;
        }

        return false;
    }

}
