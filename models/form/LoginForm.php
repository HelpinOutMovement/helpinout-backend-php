<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\AppUser;
use app\models\AppRegistration;

/**
 * MeetingForm is the model behind the Meeting.
 */
class LoginForm extends Model {

    public $origin_source;
    public $meeting_reoccurring_id;
    public $meeting_reoccurring_sno;
    public $wbs_id;
    public $client_name;
    public $meeting_name;
    public $responsible_user_id;
    public $agenda;
    public $check_availability;
    public $start_datetime;
    public $end_datetime;
    // for snooze meeting
    public $snooze;
    public $snooze_time;
    public $snooze_reason;
    // for cancel meeting
    public $cancel_reason;
    public $meeting_id;
    public $comments;
    public $date;
    public $time_start;
    public $time_end;
    public $reoccur;
    public $wbs_type;
    public $muser;
    public $meeting;
    public $usermeeting;

    const SCENARIO_CALENDER_MEETING = "login";
    const SCENARIO_DIRECT_MEETING = "register";

    public function __construct($meeting_source = Meeting::SOURCE_CALENDAR, $meeting = null) {
        $this->origin_source = $meeting_source;
        $this->meeting = Yii::createObject([
                    'class' => \app\models\Meeting::className(),
        ]);

        if (isset($meeting) && $meeting != null) {
            $this->meeting = $meeting;
            $this->setAttributes([
                'meeting_name' => $this->meeting->meeting_name,
                'date' => \Yii::$app->formatter->asDatetime($this->meeting->start_datetime, "php:Y-m-d"),
                'time_start' => \Yii::$app->formatter->asDatetime($this->meeting->start_datetime, "php:H:i"),
                'time_end' => \Yii::$app->formatter->asDatetime($this->meeting->end_datetime, "php:H:i"),
                'muser' => ArrayHelper::getColumn($this->meeting->meetingusers, 'user_id'),
                'wbs_id' => $this->meeting->wbs_id,
                'wbs_type' => $this->meeting->meeting_type,
                'agenda' => $this->meeting->agenda,
                'check_availability' => $this->meeting->check_availability,
            ]);
            $this->date = \Yii::$app->formatter->asDatetime($this->meeting->start_datetime, "php:Y-m-d");
            $this->time_start = \Yii::$app->formatter->asDatetime($this->meeting->start_datetime, "php:h:i A");
            $this->time_end = \Yii::$app->formatter->asDatetime($this->meeting->end_datetime, "php:h:i A");
            $this->agenda = $this->meeting->agenda;
            $this->reoccur = $this->meeting->meetingreoccurring != NULL ? $this->meeting->meetingreoccurring->reoccurring_type : Meeting::MEETING_REOCCUR_ONETIME;
            $this->responsible_user_id = $this->meeting->responsible_user_id;
            $this->wbs_type = $this->meeting->meeting_type;
            $this->client_name = $this->meeting->client_name;
            $this->cancel_reason = $this->meeting->cancel_reason;
        }
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['meeting_name', 'date', 'time_start', 'time_end', 'reoccur', 'muser', 'agenda', 'responsible_user_id'], 'required', 'on' => [MeetingForm::SCENARIO_CALENDER_MEETING, MeetingForm::SCENARIO_WBS_MEETING, MeetingForm::SCENARIO_DIRECT_MEETING], 'message' => 'Is required'],
            [['wbs_type'], 'required', 'on' => [MeetingForm::SCENARIO_WBS_MEETING]],
            [['wbs_id'], 'required', 'on' => [MeetingForm::SCENARIO_WBS_MEETING]],
            [['client_name'], 'required', 'on' => [MeetingForm::SCENARIO_WBS_MEETING], 'when' => function ($model) {
                    return $model->wbs_type == Meeting::WBS_MEETING_TYPE_CLIENT;
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#wbs_type').val() == '1';
            }"],
            ['date', \app\components\validators\TodayDateValidator::className(), 'on' => [MeetingForm::SCENARIO_CALENDER_MEETING, MeetingForm::SCENARIO_DIRECT_MEETING]],
            ['date', function ($attribute, $params) {
                    if (isset($this->date) and $this->date != '') {

                        $wbs = \app\models\Wbs::findOne($this->wbs_id);
                        if (strtotime($this->date) < strtotime($wbs->start_date)) {
                            $this->addError($attribute, 'Meeting date should be greater than WBS start date.');
                        }
                    } else {
                        $this->addError($attribute, 'Date not set.');
                    }
                }, 'on' => [MeetingForm::SCENARIO_WBS_MEETING]],
            ['date', function ($attribute, $params) {
                    if (isset($this->date) and $this->date != '') {

                        $wbs = \app\models\Wbs::findOne($this->wbs_id);
                        if (strtotime($this->date) > strtotime($wbs->end_date)) {
                            $this->addError($attribute, 'Meeting date should be less than WBS end date.');
                        }
                    } else {
                        $this->addError($attribute, 'Date not set.');
                    }
                }, 'on' => [MeetingForm::SCENARIO_WBS_MEETING]],
            ['responsible_user_id', \app\components\validators\CheckMeetingMemberValidator::className(), 'on' => [MeetingForm::SCENARIO_CALENDER_MEETING, MeetingForm::SCENARIO_WBS_MEETING, MeetingForm::SCENARIO_DIRECT_MEETING]],
            ['time_start', function ($attribute, $params) {
                    if (isset($this->date) and $this->date != '') {
                        $now_date_time = date('Y-m-d H:i:s ');
                        $start_date_time = $this->startdatetime();
                        //echo $start_date_time. " ".$now_date_time;exit;
                        if (strtotime($start_date_time) < strtotime($now_date_time)) {
                            $this->addError($attribute, 'Start Time should be greater than current time.');
                        }
                    } else {
                        $this->addError($attribute, 'Date not set.');
                    }
                }, 'on' => [MeetingForm::SCENARIO_CALENDER_MEETING, MeetingForm::SCENARIO_WBS_MEETING, MeetingForm::SCENARIO_DIRECT_MEETING]],
            ['time_end', function ($attribute, $params) {
                    if (isset($this->date) and $this->date != '') {
                        $start_date_time = $this->startdatetime();
                        $end_date_time = $this->enddatetime();
                        if (strtotime($end_date_time) <= strtotime($start_date_time)) {
                            $this->addError($attribute, 'Time End should be greater than Start Time');
                        }
                    } else {
                        $this->addError($attribute, 'Date not set.');
                    }
                }, 'on' => [MeetingForm::SCENARIO_CALENDER_MEETING, MeetingForm::SCENARIO_WBS_MEETING, MeetingForm::SCENARIO_DIRECT_MEETING]],
            [['meeting_name'], 'string', 'max' => 255],
            [['meeting_name'], 'trim'],
            [['client_name'], 'string', 'max' => 255],
            [['client_name'], 'trim'],
            [['snooze_time', 'snooze_reason'], 'required', 'on' => ['snoozemeeting'], 'message' => 'Is required'],
            [['cancel_reason'], 'required', 'on' => ['cancelmeeting'], 'message' => 'Is required'],
            [['snooze_time'], 'integer', 'on' => ['snoozemeeting'], 'message' => 'Is number'],
            [['meeting_id'], 'required', 'on' => ['snoozemeeting', 'cancelmeeting'], 'message' => 'Is required'],
            ['meeting_reoccurring_id', 'safe'],
            ['meeting_reoccurring_sno', 'safe'],
            ['check_availability', 'safe'],
            ['wbs_id', 'safe'],
            ['responsible_user_id', 'safe'],
            ['start_datetime', 'safe'],
            ['end_datetime', 'safe'],
            ['cancel_reason', 'safe'],
            ['comments', 'safe'],
            ['muser', 'safe'],
            ['meeting_id', 'safe']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'wbs_type' => 'WBS Type',
            'meeting_name' => 'Meeting Name',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
            'reoccur' => 'Reoccur',
            'agenda' => 'Agenda',
            'muser' => 'Assign User',
            'responsible_user_id' => 'Assign Responsibility',
        ];
    }

//    public function snooze() {
//        if ($this->validate()) {
//            return true;
//        }
//        return false;
//    }
//    public function cancel() {
//        if ($this->validate()) {
//            return true;
//        }
//        return false;
//    }

    public function startdatetime() {
        $strtdate = $this->date . ' ' . $this->time_start;
        //\Yii::$app->formatter->timeZone = 'Asia/Kolkata';
        //echo \Yii::$app->formatter->asDatetime($strtdate, "php:Y-m-d h:i A"); exit;
        return \Yii::$app->formatter->asDatetime($strtdate, "php:Y-m-d H:i:s");
    }

    public function enddatetime() {
        $enddate = $this->date . ' ' . $this->time_end;
        //\Yii::$app->formatter->timeZone = 'Asia/Kolkata';
        return \Yii::$app->formatter->asDatetime($enddate, "php:Y-m-d H:i:s");
    }

}
