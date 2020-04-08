<?php

namespace app\components\mail;

use SimpleEmailService;
use SimpleEmailServiceMessage;

class AmazonMail {

    public $subject;
    public $from = 'vikas@arthify.com';
    public $to;
    public $returnpath = 'vikas@arthify.com';
    public $message;
    public $ses_access_key = '';
    public $ses_secret_key = '';
    public $service = 'amazon-ses';
    public $enableSendMail = true;

    public function __construct($to, $message, $subject, $fron, $returnpath) {
        $this->to = $to;
        $this->message = $message;
        $this->subject = $subject;
        if ($fron != '')
            $this->from = $fron;
        if ($returnpath != '')
            $this->returnpath = $returnpath;
    }

    public function Send() {
        try {
            if ($this->enableSendMail) {
                $m = new SimpleEmailServiceMessage();
                $m->addTo($this->to);
                $m->setFrom($this->from);
                $m->setSubject($this->subject);
                $m->setMessageFromString('', $this->message);
                $m->returnpath = $this->returnpath;
                $mail = new SimpleEmailService($this->ses_access_key, $this->ses_secret_key, SimpleEmailService::AWS_EU_WEST1);
                return $mail->sendEmail($m);
            }

//            if ($this->enableSendMail) {
//                $smtpmail = \Yii::$app->mailer->compose()
//                        ->setFrom(\Yii::$app->params['smtp_mail_from'])
//                        ->setTo($this->to)
//                        ->setSubject($this->subject)
//                        ->setHtmlBody($this->message);
//                return $smtpmail->send();
//            }
        } catch (\Exception $e) {
            
        }
    }

}
