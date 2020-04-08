<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
   

    public function actionIndex() {
        if (!Yii::$app->user->isGuest) {
           
                return $this->redirect(['/admin/apilog']);
           
        } else {
             $this->layout = '@app/themes/helpinout/views/layouts/sitemain';
         return $this->render('index');
        }
        
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    public function actionDownloadreport() {

        ini_set('max_execution_time', 12000000000000000);
        ini_set('memory_limit', '10244444444444M');
        $temp_data = '';
        $base_path = Yii::$app->params['datapath'];


        $sql = "SELECT parameter_grading.parameter_id as parameter_id, parameter_grading.qs_weighted_value as qs_value,parameter_grading.dgt_weighted_value as dgt_value,parameter_grading.iti_code,presented_in_grievance_committee_no,iti_name,state,district,grievance_raised,addressed_in_grievance_committee_no_f,zero_graded,addressed_in_grievance_committee_no_s,random_check,"
                . "addressed_in_grievance__committee_no_t,qs_user,qs_grade,grc_grade,qs_submission_date_time,"
                . "qs_email_date_time,status FROM cgm_report left join parameter_grading on cgm_report.iti_code=parameter_grading.iti_code where parameter_grading.parameter_id<=27";
        $itis = \Yii::$app->getDb()->createCommand($sql)->queryAll();
        if (!empty($itis)) {

            $temp_data .= 'SNo,ITI Code,Presented in Grievance Committee No.,ITI Name,Private/Govt.,State,District,Grievance Raised(Yes/No),Addressed in Grievance Committee No,Zero Graded (Yes/No),Addressed in Grievance Committee No,Random Check (Yes/No),Addressed in Grievance Committee No,QS User,Parameter id,Paramaters,QS Score,QS Grade,GRC Score,GRC Grade,QS Submission date & time,QS Email Date & time,Status,';

            $temp_data .= "\r\n";
            $sno = 0;
            foreach ($itis as $q) {

                
                if ($q['parameter_id'] == '1') {
                    $sno++;
                    $code = $q['iti_code'];
                    $presented_in_grievance_committee_no = $q['presented_in_grievance_committee_no'];
                    $iti_name = '"' . $q['iti_name'] . '"';
                    $state = $q['state'];
                    $district = $q['district'];
                    $grievance_raised = $q['grievance_raised'];
                    $addressed_in_grievance_committee_no_f = $q['addressed_in_grievance_committee_no_f'];
                    $zero_graded = $q['zero_graded'];
                    $random_check = $q['random_check'];
                    $addressed_in_grievance__committee_no_t = $q['addressed_in_grievance__committee_no_t'];
                    $addressed_in_grievance_committee_no_s = $q['addressed_in_grievance_committee_no_s'];
                    $qs_user = $q['qs_user'];
                    $qs_grade = $q['qs_grade'];
                    $grc_grade = $q['grc_grade'];
                    $qs_submission_date_time = $q['qs_submission_date_time'];
                    $qs_email_date_time = $q['qs_email_date_time'];
                    $status = $q['status'];
                    $sql1 = "SELECT iti_type_id FROM iti_list where code='" . $code . "'";
                    $ititype = \Yii::$app->getDb()->createCommand($sql1)->queryOne();
                    $iti_type = $ititype['iti_type_id'];
                    if ($iti_type == '1') {
                        $iti_type = 'Pvt';
                    } else if ($iti_type == '2') {
                        $iti_type = 'Govt';
                    } else {
                        $iti_type = '';
                    }
                } else {
                    $code = '';
                    $presented_in_grievance_committee_no = '';
                    $iti_name = '';
                    $state = '';
                    $district = '';
                    $grievance_raised = '';
                    $addressed_in_grievance_committee_no_f = '';
                    $zero_graded = '';
                    $random_check = '';
                    $addressed_in_grievance__committee_no_t = '';
                    $addressed_in_grievance_committee_no_s = '';
                    $qs_user = '';
                    $qs_grade = '';
                    $grc_grade = '';
                    $qs_submission_date_time = '';
                    $qs_email_date_time = '';
                    $status = '';
                    $iti_type = '';
                }

                $qs_score = $q['qs_value'];
                $grc_score = $q['dgt_value'];

                $parameter_id = $q['parameter_id'];
                $q_sql = "SELECT name FROM master_parameter where id='" . $parameter_id . "'";
                $parameter_name = \Yii::$app->getDb()->createCommand($q_sql)->queryOne();
                $parameter_name = '"' . $parameter_name['name'] . '"';


                $temp_data .= "$sno,"
                        . "$code,"
                        . "$presented_in_grievance_committee_no,"
                        . "$iti_name,"
                        . "$iti_type,"
                        . "$state,"
                        . "$district,"
                        . "$grievance_raised,"
                        . "$addressed_in_grievance_committee_no_f,"
                        . "$zero_graded,"
                        . "$addressed_in_grievance_committee_no_s,"
                        . "$random_check,"
                        . "$addressed_in_grievance__committee_no_t,"
                        . "$qs_user,"
                        . "$parameter_id,"
                        . "$parameter_name,"
                        . "$qs_score,"
                        . "$qs_grade,"
                        . "$grc_score,"
                        . "$grc_grade,"
                        . "$qs_submission_date_time,"
                        . "$qs_email_date_time,"
                        . "$status\n";
            }
        }


        $file_name = "report";
        $filePath = $base_path . '/' . $file_name . ".csv";
        $fp = fopen($filePath, 'a+');
        $sr_no = 1;


        fwrite($fp, $temp_data);
        fclose($fp);

        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        header("Content-Type: application/csv");
        header("Content-Length: " . filesize($filePath));
        header("Content-Disposition: attachment; filename=$file_name.csv");
        readfile($filePath);
        unlink($filePath);

        exit();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {

//        $sql = "SELECT DISTINCT form_instance.form_id, `instance_file_size` , `instance_name` , form_instance.app_instance_id, form_instance.device_id, COUNT( * ) 
//              FROM form_instance
//              WHERE form_id in (1100,1098,1099,1101,1106,1119,1129,1135) 
//              AND STATUS =1
//              GROUP BY form_instance.form_id, `instance_file_size` , `instance_name` , form_instance.app_instance_id, form_instance.device_id
//              ORDER BY COUNT( * ) DESC 
//             LIMIT 0 , 300";
//        $model_duplicate_instance = \Yii::$app->getDb()->createCommand($sql)->queryAll();
//
//        if (!empty($model_duplicate_instance)) { //echo "Asdada";
//            foreach ($model_duplicate_instance as $model_duplicate_ins) {
//                $model_instance = FormInstance::find()->where(['form_id' => $model_duplicate_ins['form_id'], 'instance_file_size' => $model_duplicate_ins['instance_file_size'], 'app_instance_id' => $model_duplicate_ins['app_instance_id'], 'device_id' => $model_duplicate_ins['device_id']])->orderBy('id asc')->all();
//                if (count($model_instance) > 1) {
//                    $first_time = true;
//                    foreach ($model_instance as $instance) {
//                        if ($first_time == true) {
//                            $first_time = false;
//                            //  print_r($instance->id.' skip');
//                            continue;
//                        }
//
//                        $instance->status = 0;
//                        $instance->update();
//                    }
//                } else
//                    echo "done";
//            }
//        }

        return $this->render('about');

        $sql = "SELECT distinct(`file_name`), `file_name`, `iti_id`,`parameter_id`, COUNT( * ) 
              FROM `field_staff_files` where status = 1
             
              GROUP BY `file_name`, `iti_id` ,`parameter_id`
              ORDER BY COUNT( * ) DESC 
             LIMIT 0 , 3000";
        $model_duplicate_instance = \Yii::$app->getDb()->createCommand($sql)->queryAll();

        if (!empty($model_duplicate_instance)) { //echo "Asdada";
            foreach ($model_duplicate_instance as $model_duplicate_ins) {
                $model_instance = \app\models\FieldStaffFiles::find()->where(['iti_id' => $model_duplicate_ins['iti_id'], 'parameter_id' => $model_duplicate_ins['parameter_id'], 'file_name' => $model_duplicate_ins['file_name'], 'status' => 1])->orderBy('id asc')->all();
                if (count($model_instance) > 1) {
                    $first_time = true;
                    foreach ($model_instance as $instance) {
                        if ($first_time == true) {
                            $first_time = false;

                            echo $model_duplicate_ins['parameter_id'] . " ";
                            $iti = \app\models\ItiList::findOne(['id' => $model_duplicate_ins['iti_id']]);
                            $file = Yii::$app->params['datapath'] . $iti->code . '/' . $model_duplicate_ins['file_name'];

                            if (file_exists($file)) {
                                //   echo "The file $file_pointer exists";
                            } else {

                                $instance->status = 0;
                                $instance->update();
                            }

                            continue;
                        } else {

                            $instance->status = 0;
                            $instance->update();
                        }
                    }
                } else {
                    echo "done";

                    $iti = \app\models\ItiList::findOne(['id' => $model_duplicate_ins['iti_id']]);
                    $file = Yii::$app->params['datapath'] . $iti->code . '/' . $model_duplicate_ins['file_name'];

                    if (file_exists($file)) {
                        //echo "The file $file_pointer exists";
                    } else {
                        $instance = $model_instance[0];
                        $instance->status = 0;
                        $instance->update();
                    }
                }
            }
        }
    }

}
