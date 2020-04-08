<?php

namespace app\modules\api\v1\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use yii\web\Controller;
use app\models\AppRegistration;
use app\models\ApiLog;
use app\models\AppUser;
use app\models\form\LoginRegisterForm;

/**
 * User controller for the `api` module
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ActivityController extends Controller {

    protected $finder;
    private $response = [];
    private $post_json;
    private $data_json;
    public $app_id;
    public $imei_no;
    public $current_module;

    public function beforeAction($event) {

        //$response = \Yii::$app->response;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $this->current_module = \Yii::$app->controller->module;
        $this->post_json = $this->current_module->post_json;
        $this->data_json = $this->current_module->data_json;

        $this->response['status'] = "1";
        $this->response['message'] = "Success";
        $this->response['data'] = [];
        return parent::beforeAction($event);
    }
    
    public function actionSuggestions() {
        $response = \Yii::$app->response;


        $this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

    public function actionAdd() {
        $response = \Yii::$app->response;


        $this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

    public function actionLogin() {

        $app_user = AppUser::findOne(['country_code' => $this->data_json['country_code'], 'mobile_no' => $this->data_json['mobile_no']]);
        if (!empty($app_user)) {

            $form_model = new LoginRegisterForm($app_user); // \Yii::createObject(LoginRegisterForm::className());
            $form_model->scenario = LoginRegisterForm::SCENARIO_LOGIN;

            if ($form_model->load(['LoginRegisterForm' => $this->data_json], null)) {
                $form_model->time_zone_offset = \Yii::$app->controller->module->model_apilog->request_time_zone_offset;
                if ($form_model->validate()) {
                    $form_model->login();
                    $this->response['data']['user_id'] = $form_model->app_user->id;
                    $this->response['data']['app_id'] = $form_model->app_register->id;
                } else {
                    $this->response['status'] = "0";
                    $this->response['message'] = "Error(s): {" . \app\helpers\Utility::convertModelErrorToString($form_model) . "}";
                    unset($this->response['data']);
                }
            } else {
                throw new \yii\web\BadRequestHttpException("Bad Request, data missing"); // HTTP COde 400
            }
        } else {
            $this->response['status'] = "0";
            $this->response['message'] = "Regsitration required";
            unset($this->response['data']);
        }


        $response = \Yii::$app->response;

        $response->data = $this->response;
        return $this->response;
    }

    private function processRegister() {

        $form_model = \Yii::createObject(LoginRegisterForm::className());
        $form_model->scenario = LoginRegisterForm::SCENARIO_REGISTER;
        $app_user = AppUser::findOne(['country_code' => $this->data_json['country_code'], 'mobile_no' => $this->data_json['mobile_no']]);

        if (empty($app_user)) {
            if ($form_model->load(['LoginRegisterForm' => $this->data_json], null)) {
                $form_model->time_zone_offset = \Yii::$app->controller->module->model_apilog->request_time_zone_offset;
                if ($form_model->validate()) {
                    $form_model->register();
                    $this->response['data']['user_id'] = $form_model->app_user->id;
                    $this->response['data']['app_id'] = $form_model->app_register->id;
                } else {
                    $this->response['status'] = "0";
                    $this->response['message'] = "Error(s): {" . \app\helpers\Utility::convertModelErrorToString($form_model) . "}";
                    unset($this->response['data']);
                }
            } else {
                throw new \yii\web\BadRequestHttpException("Bad Request, data missing"); // HTTP COde 400
            }
        } else {
            $this->response['status'] = "0";
            $this->response['message'] = "Already registered";
            unset($this->response['data']);
        }
    }

    private function processRegisterIntoDb($confirm_overwrite = FALSE) {
        $this->response['status'] = "1";
        $member_app_model = new AppDetail();
        $member_app_model->user_id = \Yii::$app->user->identity->id;
        $member_app_model->imei_no = $this->data_json['imei_no'];
        $member_app_model->os_type = $this->data_json['os_type'];
        $member_app_model->manufacturer_name = $this->data_json['manufacturer_name'];
        $member_app_model->os_version = $this->data_json['os_version'];
        $member_app_model->app_version = $this->data_json['app_version'];
        $member_app_model->firebase_token = $this->data_json['firebase_token'];
        $member_app_model->date_of_install = new Expression('NOW()');

        if ($member_app_model->save()) {
            $this->response['message'] = "success, request processed successfully";
            $this->response['app_id'] = $member_app_model->id;
            $this->response['user_id'] = $member_app_model->user_id;
            $this->response['name'] = \Yii::$app->user->identity->name;

            Notification::updateAll(['acknowledge_status' => 1, 'acknowledge_date' => new Expression('NOW()'), 'app_id' => $member_app_model->id], 'user_id ="' . \Yii::$app->user->identity->id . '" and acknowledge_status=' . '0');
        } else {
            throw new \yii\web\ServerErrorHttpException("App registartion error : " . json_encode($member_app_model->getErrors()));
        }
    }

    public function actionCurrentlocation() {
        $response = \Yii::$app->response;


        $this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

    public function actionUpdategoogletoken() {
        $user = \Yii::$app->user->identity;
        $active_app = AppDetail::findOne($this->current_module->model_apilog->app_id);
        $active_app->firebase_token = $this->data_json['firebase_token'];
        if ($active_app->save()) {
            
        } else {
            $this->response['status'] = "0";
            $this->response['message'] = "Error(s): {" . \app\modules\dacts\helpers\Utility::convertModelErrorToString($active_app) . "}";
        }
        $response = \Yii::$app->response;

        $response->data = $this->response;
        return $this->response;
    }

}
