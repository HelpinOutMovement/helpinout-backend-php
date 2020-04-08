<?php

namespace app\modules\api\v1;

use Yii;
use yii\web\Response;
use yii\db\Expression;
use yii\base\ActionEvent;
use yii\base\Application;
use app\models\ApiLog;
use app\models\AppRegistration;
use app\models\AppUser;

/**
 * api module definition class
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\api\v1\controllers';

    /**
     * @var \app\modules\dacts\models\ApiLog
     */
    public $model_apilog;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $post_json;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $data_json;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $app_id;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $user_id;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $org_id;

    /**
     * @var PHP input Ojbect 
     */
    public $php_input;
    public $file_input;

    /*
     * Module Base URL
     */
    public $base_url = "api/v1/";

    /**
     *
     * @var type 
     */
    public $api_urls = [
        'api/v1/user/register',
        'api/v1/user/login',
        'api/v1/user/currentlocation',
        'api/v1/activity/suggestions',
        'api/v1/activity/add',
        'api/v1/activity/delete',
        'api/v1/mapping/rating',
        'api/v1/mapping/call',
        'api/v1/mapping/delete',
//        'api/v1/user/apilogin',
//        'api/v1/user/itilist',
//        'api/v1/user/dashboard',
//        'api/v1/iti/formsave',
//        'api/v1/iti/filesave',
//        'api/v1/iti/attachmentsubmit',
//        'api/v1/user/updategoogletoken',
//        'api/v1/user/updatepassword',
//        'api/v1/baseline/formsave',
//        'api/v1/baseline/filesave'
//        'api/v1/demo/apisave',
//        'api/v1/user/dashboard',
    ];
    
    //public $login_url = 'api/v1/user/register';
    public $direct_urls = [
        'api/v1/user/register',
        'api/v1/user/login'
    ];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        $app = Yii::$app;
        $app->on(Application::EVENT_BEFORE_ACTION, [$this, 'onBeforeAction']);

        $app->request->enableCsrfValidation = false;

        $app->response->on(Response::EVENT_BEFORE_SEND, [$this, 'onBeforeSend']);
        $app->response->format = \yii\web\Response::FORMAT_JSON;
        $app->response->headers->add('Access-Control-Allow-Origin', '*');
    }

    public function onBeforeAction($event) {
        $this->php_input = file_get_contents("php://input");
        $this->post_json = json_decode($this->php_input, true);
        $this->data_json = $this->post_json['data'];
        $this->saveApiInfo()->verifyandLogin();
    }

    public function onBeforeSend($event) {

        $response = $event->sender;

        if ($response->statusCode == 200) {
            $this->model_apilog->api_response_status = $response->data['status'];
            $this->model_apilog->api_response_message = $response->data['message'];
            $this->model_apilog->response = isset($response->data['data']) ? json_encode($response->data['data']) : "";
            // $response->statusText = base64_encode($response->statusText);
        } else if ($response->statusCode == 400 || $response->statusCode == 401 || $response->statusCode == 403 || $response->statusCode == 404 || $response->statusCode == 409) {
            // this is required for not found (404) case. Because "onBeforeAction" method is not triggered.
            if (!isset($this->model_apilog)) {
                $this->saveApiInfo();
            }

            $this->model_apilog->response = $response->data['message'];

            $response->statusText = $response->data['message'];
            $response->data = null;
        } else if ($response->statusCode == 500) {
            // this is required for some cases. Because "onBeforeAction" method is not triggered.
            if (!isset($this->model_apilog)) {
                $this->saveApiInfo();
            }
            $exception = Yii::$app->errorHandler->exception;
            $response->statusText = $exception->getMessage() . " " . (isset($this->model_apilog->app_id) ? $this->model_apilog->app_id : 0 ) . " " . file_get_contents("php://input");
            $this->model_apilog->response = $exception->getMessage() . " File : " . $exception->getFile() . " Line : " . $exception->getFile() . "Trace : " . $exception->getTraceAsString();
            $response->data = null;
        }
        $this->model_apilog->http_response_code = $response->statusCode;
        $this->model_apilog->save(FALSE);
    }

    private function saveApiInfo() {

        $app = Yii::$app;

        $this->model_apilog = new ApiLog();
        $this->model_apilog->ip = $app->getRequest()->getUserIP();
        $this->model_apilog->request_url = $app->request->pathInfo;
        $this->model_apilog->request_body = $this->php_input;
        $this->model_apilog->http_response_code = 0;
        $this->model_apilog->api_response_status = 0;
        
        $this->model_apilog->app_registration_id = isset($this->post_json['app_id']) ? (int) $this->post_json['app_id'] : 0;
        $this->model_apilog->save(FALSE);

        $parsed_date_time = date_parse($this->post_json['date_time']);
        $timezone_name = timezone_name_from_abbr("", $parsed_date_time['zone'], 0); // NB: Offset in seconds! 

        if ($timezone_name == "") {
            throw new \yii\web\ServerErrorHttpException('Api info log save error. Timezone not found. ' . json_encode($this->model_apilog->getErrors()));
        } else {
            $request_time_zone_offset = gmdate("H:i:s", $parsed_date_time['zone']);
            if ($parsed_date_time['zone'] < 0) {
                $date1 = new \DateTime($request_time_zone_offset);
                $date2 = new \DateTime('24:00');
                $finaldate = $date2->diff($date1);
                $request_time_zone_offset = "-" . $finaldate->format('%h:%i:%s');
            }
        }

        $request_date_time = $parsed_date_time['year'] . "-" . $parsed_date_time['month'] . "-" . $parsed_date_time['day'] . " " . $parsed_date_time['hour'] . ":" . $parsed_date_time['minute'] . ":" . $parsed_date_time['second'];

        $this->model_apilog->app_registration_id = isset($this->post_json['app_id']) ? (int) $this->post_json['app_id'] : 0;
        $this->model_apilog->imei_no = isset($this->post_json['imei_no']) ? $this->post_json['imei_no'] : '';
        $this->model_apilog->request_datetime = $request_date_time; // isset($this->post_json['date_time']) ? $this->post_json['date_time'] : '';
        $this->model_apilog->request_time_zone_offset = $request_time_zone_offset;

        if ($this->model_apilog->save(FALSE)) {
            
        } else {
            throw new \yii\web\ServerErrorHttpException('Api info log save error. ' . json_encode($this->model_apilog->getErrors()));
        }
        return $this;
    }

    private function verifyandLogin() {
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // STEP 1 checking the url requested is part of current API or not
        // Ideally this check is not required, 
        if (!in_array($this->model_apilog->request_url, $this->api_urls)) {
            throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
        }

        // STEP 2 checking whether the app_id and imei_no exists or not.
        // if ($this->model_apilog->request_url == $this->login_url) {// at the time of login app_id will be missing
        if (in_array($this->model_apilog->request_url, $this->direct_urls)) {
            if ($this->model_apilog->imei_no == "") {
                throw new \yii\web\BadRequestHttpException("Bad Request, imei_no missing"); //error 400
            }
        } else {
            if ($this->model_apilog->app_registration_id == 0 || $this->model_apilog->imei_no == "") {
                throw new \yii\web\BadRequestHttpException("Bad Request, imei_no or app id missing"); //error 400
            }

            // STEP 3 checking the request made from the app is active or not.
            $active_app = AppRegistration::find()->where(['id' => $this->model_apilog->app_registration_id, 'status' => 1])->one();
            if (empty($active_app)) {
                throw new \yii\web\ConflictHttpException("App is not active"); //error 409
            }

            //Todo
            //STEP4 check wheather user is still active or not and asigned the app.
            //throw new \yii\web\ForbiddenHttpException(""); //error 403
//            $user = AppUser::findOne(['id' => $active_app->app_user_id]);
//            if (!$user->status) {
//                if (\Yii::$app->getUser()->login($user, 10)) {
//                    //login successful;
//                } else {
//                    throw new \yii\web\ForbiddenHttpException("Forbidden - User unable to login."); //error 403
//                    //unable to login
//                }
//            } else {
//                throw new \yii\web\ForbiddenHttpException("Forbidden - User unable to login."); //error 403
//                //unable to login
//            }
        }

        //STEP check for active app
    }

}
