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
use app\models\OfferHelp;
use app\models\RequestHelp;

/**
 * User controller for the `api` module
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UserController extends Controller {

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

    public function actionRegister() {
        $this->processRegister();
        \Yii::$app->response->data = $this->response;
        return $this->response;
    }

    public function actionUpdate() {
        $app_user = AppUser::findOne(['country_code' => $this->data_json['country_code'], 'mobile_no' => $this->data_json['mobile_no']]);
        $form_model = new LoginRegisterForm($app_user);
        $form_model->scenario = LoginRegisterForm::SCENARIO_UPDATE;


        if (empty($app_user)) {
            $this->response['status'] = "0";
            $this->response['message'] = "Unregistered User";
            unset($this->response['data']);
        } else {

            if ($form_model->load(['LoginRegisterForm' => $this->data_json], null)) {
                $form_model->time_zone_offset = \Yii::$app->controller->module->model_apilog->request_time_zone_offset;
                if ($form_model->validate()) {
                    $form_model->update();
                    $this->response['data']['user_id'] = $form_model->app_user->id;
                    //$this->response['data']['app_id'] = $form_model->app_register->id;
                    $app_user = AppUser::findOne(['country_code' => $this->data_json['country_code'], 'mobile_no' => $this->data_json['mobile_no']]);
                    $this->response['data']['user_detail'] = $app_user->detail;
                } else {
                    $this->response['status'] = "0";
                    $this->response['message'] = "Error(s): {" . \app\helpers\Utility::convertModelErrorToString($form_model) . "}";
                    unset($this->response['data']);
                }
            } else {
                throw new \yii\web\BadRequestHttpException("Bad Request, data missing"); // HTTP COde 400
            }
        }


        \Yii::$app->response->data = $this->response;
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
                    $this->response['data']['user_detail'] = $app_user->detail;
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
                    $app_user = AppUser::findOne(['country_code' => $this->data_json['country_code'], 'mobile_no' => $this->data_json['mobile_no']]);
                    $this->response['data']['user_detail'] = $app_user->detail;
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

    public function actionPastactivity() {
        $response = \Yii::$app->response;

        $offers = OfferHelp::find()->where(['app_user_id' => \Yii::$app->controller->module->model_apilog->app_user_id, 'status' => '1'])->orderBy(' created_at desc')->all();

        $this->response['data']["offers"] = array();
        foreach ($offers as $offer) {
            array_push($this->response['data']["offers"], $offer->getDetail(true, false, true));
        }

        $requests = RequestHelp::find()->where(['app_user_id' => \Yii::$app->controller->module->model_apilog->app_user_id, 'status' => '1'])->orderBy(' created_at desc')->all();
        $this->response['data']["requests"] = array();
        foreach ($requests as $request) {
            array_push($this->response['data']["requests"], $request->getDetail(true, false, true));
        }
        $response->data = $this->response;
        return $this->response;
    }

    public function actionLocationrequestersummary() {
        $response = \Yii::$app->response;

        $location_lat_lng = explode(",", $this->data_json['geo_location']);
        $lat = $location_lat_lng[0];
        $lng = $location_lat_lng[1];
        $range = isset($this->data_json['radius']) ? $this->data_json['radius'] : 50;
        $range = round(($range / 1000) * 0.95, 2);
        $earth_radius = 6371;

        $maxlat = $lat + rad2deg($range / $earth_radius);
        $minlat = $lat - rad2deg($range / $earth_radius);

        $maxlng = $lng + rad2deg($range / $earth_radius / cos(deg2rad($lat)));
        $minlng = $lng - rad2deg($range / $earth_radius / cos(deg2rad($lat)));

        $temp = array();

        for ($i = 0; $i < 9; $i++) {
            $count = RequestHelp::find()->where(['master_category_id' => $i, 'status' => '1'])
                    ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])->orderBy('id desc')
                    ->count();

            $near = RequestHelp::find()->where(['master_category_id' => $i, 'status' => '1'])
                    ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                    ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])->orderBy('id desc')
                    ->count();
            $temp[] = ['activity_category' => $i, 'total' => $count, 'near' => $near];
        }

        $this->response['data'] = $temp;
        $response->data = $this->response;
        return $this->response;
    }

    public function actionLocationsuggestion() {
        $response = \Yii::$app->response;

        $location_lat_lng = explode(",", $this->data_json['geo_location']);
        $lat = $location_lat_lng[0];
        $lng = $location_lat_lng[1];
        $range = isset($this->data_json['radius']) ? $this->data_json['radius'] : 50;
        $range = round(($range / 1000) * 0.95, 2);
        $earth_radius = 6371;

        $maxlat = $lat + rad2deg($range / $earth_radius);
        $minlat = $lat - rad2deg($range / $earth_radius);

        $maxlng = $lng + rad2deg($range / $earth_radius / cos(deg2rad($lat)));
        $minlng = $lng - rad2deg($range / $earth_radius / cos(deg2rad($lat)));


        //$q = WoPdv::find()->where(['between', 'wo_pdvLat', $minlat, $maxlat])->andWhere(['between', 'wo_pdvLong', $minlng, $maxlng]);
        //$q->select(['*',"ROUND((((acos(sin((".$lat."*pi()/180)) * sin((`wo_pdvLat`*pi()/180))+cos((".$lat."*pi()/180)) * cos((`wo_pdvLat`*pi()/180)) * cos(((".$lng."- `wo_pdvLong`)*pi()/180))))*180/pi())*60*1.1515*1.609344),2) as distance"]);//distance in km 
        //$q->having('distance <='.$range);
        //$q->orderBy('distance');       
        //// echo $q->createCommand()->getRawSql();die();
        //$POSlist=$q->all();

        $offerers = OfferHelp::find()->where(['status' => '1'])
                        ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                        ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])->orderBy('offer_help.id desc')->limit(30)->all();
        $this->response['data']["offers"] = array();
        foreach ($offerers as $offer) {
            $helpinout_mapping = \app\models\HelpinoutMapping::findOne(['offer_help_id' => $offer->id, 'offer_app_user_id' => \Yii::$app->controller->module->model_apilog->app_user_id]);
            if ($helpinout_mapping == '')
                array_push($this->response['data']["offers"], $offer->getDetail(false, true));

//            if (count($this->response['data']["offers"]) > 15)
//                break;
        }

        $requests = RequestHelp::find()->where(['status' => '1'])
                        ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                        ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])->orderBy('id desc')->limit(30)->all();
        $this->response['data']["requests"] = array();
        foreach ($requests as $request) {
            $helpinout_mapping = \app\models\HelpinoutMapping::findOne(['request_help_id' => $request->id, 'request_app_user_id' => \Yii::$app->controller->module->model_apilog->app_user_id]);
            if ($helpinout_mapping == '')
                array_push($this->response['data']["requests"], $request->getDetail(false, true));

//            if (count($this->response['data']["requests"]) > 15)
//                break;
        }

        //$this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

//    public function actionCurrentlocation() {
//        $response = \Yii::$app->response;
//
//
//        $this->response['data'] = '{}';
//        $response->data = $this->response;
//        return $this->response;
//    }

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
