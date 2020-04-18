<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use opensooq\firebase\FirebaseNotifications;

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

            return $this->redirect(['/dashboard']);
        } else {

            $res = array();
            $res['title'] = "ALGN" . " ";
            $res['message'] = 'message';
            $res['visible'] = 'visible';

            $res['id'] = 'notification_model->id';
            $res['genrated_on'] = 'genrated_on';

            $service = new FirebaseNotifications(['authKey' => 'AAAAikKcjI4:APA91bGAPehF_Px6UG7BpSMga4isV6dnEPNYOIm3zKySw1XwNoSXnIRyas9bhOiVBiLEmCS5ITqm5LzbdOLe40WPCcVfIN6pwtHewlsENnAC0zcM7S1miUcCxLaNEyzv3yQF76dJCu4M']);

            $service->sendNotification(["fdwbaCEZQRm7lnSUUK4yJ7:APA91bFSt2XyoEG5kVhsvADyIZVaLbn9cYKOR7Uw-0LImP7bCc0wESI1n_a-ChoclnU26GJWU-DeGKKYsP2G37A89NjNwfWv6olh_Rnl44FF9Gn6eM-ANgpN4Ipz6Ps_4wWAaBCU8gXb"], $res);

            $this->layout = '@app/themes/helpinout/views/layouts/sitemain';

            $data = [];
            $data['request_all'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->count();
            $data['request_today'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere("DATE_FORMAT(datetime, '%Y-%m-%d')='" . date('Y-m-d') . "'")->count();
            $data['offer_all'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->count();
            $data['offer_today'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere("DATE_FORMAT(datetime, '%Y-%m-%d')='" . date('Y-m-d') . "'")->count();

            $data['food'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 1])->count();
            $data['people'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 2])->count();
            $data['shelter'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 3])->count();
            $data['ppe'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 4])->count();
            $data['testing'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 5])->count();
            $data['medicines'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 6])->count();
            $data['ambulance'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 7])->count();
            $data['equip'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 8])->count();
            $data['other'] = \app\models\OfferHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 0])->count();

            $data['req_food'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 1])->count();
            $data['req_people'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 2])->count();
            $data['req_shelter'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 3])->count();
            $data['req_ppe'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 4])->count();
            $data['req_testing'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 5])->count();
            $data['req_medicines'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 6])->count();
            $data['req_ambulance'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 7])->count();
            $data['req_equip'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 8])->count();
            $data['req_other'] = \app\models\RequestHelp::find()->where(['=', 'status', 1])->andWhere(['=', 'master_category_id', 0])->count();

             $request= \app\models\RequestHelp::find()->andWhere(['=', 'status', 1])->all();
             $offer= \app\models\OfferHelp::find()->andWhere(['=', 'status', 1])->all();
//      print_r($request);
//      exit();
            return $this->render('index', ['data' => $data,'offer'=>$offer,'request'=>$request]);
            
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
