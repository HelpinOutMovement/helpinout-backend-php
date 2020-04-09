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
use app\models\base\GenralModel;
use app\models\OfferHelp;
use app\models\OfferFoodDetail;
use app\models\OfferShelterDetail;
use app\models\OfferOthersDetail;
use app\models\OfferPeopleDetail;
use app\models\OfferAmbulanceDetail;
use app\models\OfferMedPpeDetail;
use app\models\OfferMedicalEquipmentDetail;
use app\models\OfferMedicineDetail;
use app\models\OfferTestingDetail;
use app\models\RequestHelp;
use app\models\RequestFoodDetail;
use app\models\RequestShelterDetail;
use app\models\RequestOthersDetail;
use app\models\RequestPeopleDetail;
use app\models\RequestAmbulanceDetail;
use app\models\RequestMedPpeDetail;
use app\models\RequestMedicalEquipmentDetail;
use app\models\RequestMedicineDetail;
use app\models\RequestTestingDetail;

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

        $location_lat_lng = explode(",", $this->data_json['geo_location']);

        if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_REQUEST) {
            $model_request_help = RequestHelp::findOne(['request_uuid' => $this->data_json['activity_uuid']]);

            if ($model_request_help == '') {
                $model_request_help = new RequestHelp();
            }

            $model_request_help->request_uuid = $this->data_json['activity_uuid'];
            $model_request_help->app_user_id = \Yii::$app->controller->module->model_apilog->app_user_id;
            $model_request_help->api_log_id = \Yii::$app->controller->module->model_apilog->id;
            $model_request_help->location = new Expression('point(' . $location_lat_lng[0] . ' , ' . $location_lat_lng[1] . ' )');
            $model_request_help->lat = $location_lat_lng[0];
            $model_request_help->lng = $location_lat_lng[1];
            $model_request_help->accuracy = $this->data_json['geo_accuracy'];
            $model_request_help->master_category_id = $this->data_json['activity_category'];
            $model_request_help->no_of_items = isset($this->data_json['activity_count']) ? $this->data_json['activity_count'] : "1";
            $model_request_help->address = $this->data_json['address'];
            $model_request_help->payment = $this->data_json['pay'];
            $model_request_help->time_zone_offset = \Yii::$app->controller->module->model_apilog->request_time_zone_offset;
            $model_request_help->datetime = \Yii::$app->controller->module->model_apilog->request_datetime;

            $model_request_help->save();
            //$model_request_help->validate();

            RequestFoodDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
            switch ($model_request_help->master_category_id) {
                case GenralModel::CATEGORY_FOOD:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_food = new RequestFoodDetail();
                        $activity_food->request_help_id = $model_request_help->id;
                        $activity_food->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_food->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_food->validate();
                        $activity_food->save();
                    }
                    break;
                case GenralModel::CATEGORY_PEOPLE:
                   // for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_people = new RequestPeopleDetail();
                        $activity_people->request_help_id = $model_request_help->id;
                        $activity_people->volunters_required = $this->data_json['activity_detail']['volunters_required'];
                        $activity_people->volunters_detail = $this->data_json['activity_detail']['volunters_detail'];
                        $activity_people->volunters_quantity = $this->data_json['activity_detail']['volunters_quantity'];
                        $activity_people->technical_personal_required = $this->data_json['activity_detail']['technical_personal_required'];
                        $activity_people->technical_personal_detail = $this->data_json['activity_detail']['technical_personal_detail'];
                        $activity_people->technical_personal_quantity = $this->data_json['activity_detail']['technical_personal_quantity'];
                        $activity_people->validate();
                        $activity_people->save();
                   // }
                    break;
                case GenralModel::CATEGORY_SHELTER:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_shelter = new RequestShelter();
                        $activity_shelter->request_help_id = $model_request_help->id;
                        $activity_shelter->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_shelter->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_shelter->validate();
                        $activity_shelter->save();
                    }
                    break;
                case GenralModel::CATEGORY_MED_PPE:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_medppe = new RequestMedPpeDetail();
                        $activity_medppe->request_help_id = $model_request_help->id;
                        $activity_medppe->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_medppe->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_medppe->validate();
                        $activity_medppe->save();
                    }
                    break;
                case GenralModel::CATEGORY_TESTING:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_testing = new RequestTestingDetail();
                        $activity_testing->request_help_id = $model_request_help->id;
                        $activity_testing->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_testing->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_testing->validate();
                        $activity_testing->save();
                    }
                    break;
                case GenralModel::CATEGORY_MEDICINES:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_medicine = new RequestMedicineDetail();
                        $activity_medicine->request_help_id = $model_request_help->id;
                        $activity_medicine->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_medicine->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_medicine->validate();
                        $activity_medicine->save();
                    }
                    break;
                case GenralModel::CATEGORY_AMBULANCE:
                    //for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_ambulance = new RequestAmbulanceDetail();
                        $activity_ambulance->request_help_id = $model_request_help->id;
                        $activity_ambulance->quantity = $this->data_json['activity_detail']['qty'];
                        $activity_ambulance->validate();
                        $activity_ambulance->save();
                    //}
                    break;
                case GenralModel::CATEGORY_MEDICAL_EQUIPMENT:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_med_eqp = new RequestMedicalEquipmentDetail();
                        $activity_med_eqp->request_help_id = $model_request_help->id;
                        $activity_med_eqp->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_med_eqp->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_med_eqp->validate();
                        $activity_med_eqp->save();
                    }
                    break;
                case GenralModel::CATEGORY_OTHERS:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_other = new RequestOthersDetail();
                        $activity_other->request_help_id = $model_request_help->id;
                        $activity_other->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_other->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_other->validate();
                        $activity_other->save();
                    }
                    break;
                default:
            }
            $this->response['data'] = $model_request_help->detail;
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);
            if ($model_offer_help == '') {
                $model_offer_help = new OfferHelp();
            }

            $model_offer_help->offer_uuid = $this->data_json['activity_uuid'];
            $model_offer_help->app_user_id = \Yii::$app->controller->module->model_apilog->app_user_id;
            $model_offer_help->api_log_id = \Yii::$app->controller->module->model_apilog->id;
            $model_offer_help->location = new Expression('point(' . $location_lat_lng[0] . ' , ' . $location_lat_lng[1] . ' )');
            $model_offer_help->lat = $location_lat_lng[0];
            $model_offer_help->lng = $location_lat_lng[1];
            $model_offer_help->accuracy = $this->data_json['geo_accuracy'];
            $model_offer_help->master_category_id = $this->data_json['activity_category'];
            $model_offer_help->no_of_items = $this->data_json['activity_count'];
            $model_offer_help->address = $this->data_json['address'];
            $model_offer_help->payment = $this->data_json['pay'];
            $model_offer_help->time_zone_offset = \Yii::$app->controller->module->model_apilog->request_time_zone_offset;
            $model_offer_help->datetime = \Yii::$app->controller->module->model_apilog->request_datetime;
            $model_offer_help->offer_condition = $this->data_json['offer_condition'];

            $model_offer_help->save();

            OfferFoodDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
            switch ($model_offer_help->master_category_id) {
                case GenralModel::CATEGORY_FOOD:
                    for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_food = new OfferFoodDetail();
                        $activity_food->offer_help_id = $model_offer_help->id;
                        $activity_food->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_food->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_food->validate();
                        $activity_food->save();
                    }
                    break;
                case GenralModel::CATEGORY_PEOPLE:
                    //for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_people = new OfferPeopleDetail();
                        $activity_people->offer_help_id = $model_request_help->id;
                        $activity_people->volunters_required = $this->data_json['activity_detail']['volunters_required'];
                        $activity_people->volunters_detail = $this->data_json['activity_detail']['volunters_detail'];
                        $activity_people->volunters_quantity = $this->data_json['activity_detail']['volunters_quantity'];
                        $activity_people->technical_personal_required = $this->data_json['activity_detail']['technical_personal_required'];
                        $activity_people->technical_personal_detail = $this->data_json['activity_detail']['technical_personal_detail'];
                        $activity_people->technical_personal_quantity = $this->data_json['activity_detail']['technical_personal_quantity'];
                        $activity_people->validate();
                        $activity_people->save();
                    //}
                    break;
                case GenralModel::CATEGORY_SHELTER:
                    for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_shelter = new OfferShelter();
                        $activity_shelter->offer_help_id = $model_request_help->id;
                        $activity_shelter->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_shelter->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_shelter->validate();
                        $activity_shelter->save();
                    }
                    break;
                case GenralModel::CATEGORY_MED_PPE:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_medppe = new OfferMedPpeDetail();
                        $activity_medppe->request_help_id = $model_request_help->id;
                        $activity_medppe->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_medppe->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_medppe->validate();
                        $activity_medppe->save();
                    }
                    break;
                case GenralModel::CATEGORY_TESTING:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_testing = new OfferTestingDetail();
                        $activity_testing->request_help_id = $model_request_help->id;
                        $activity_testing->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_testing->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_testing->validate();
                        $activity_testing->save();
                    }
                    break;
                case GenralModel::CATEGORY_MEDICINES:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_medicine = new OfferMedicineDetail();
                        $activity_medicine->request_help_id = $model_request_help->id;
                        $activity_medicine->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_medicine->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_medicine->validate();
                        $activity_medicine->save();
                    }
                    break;
                case GenralModel::CATEGORY_AMBULANCE:
                    //for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_ambulance = new OfferAmbulanceDetail();
                        $activity_ambulance->offer_help_id = $model_request_help->id;
                        $activity_ambulance->quantity = $this->data_json['activity_detail']['qty'];
                        $activity_ambulance->validate();
                        $activity_ambulance->save();
                    //}
                    break;
                case GenralModel::CATEGORY_MEDICAL_EQUIPMENT:
                    for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                        $activity_med_eqp = new OfferMedicalEquipmentDetail();
                        $activity_med_eqp->request_help_id = $model_request_help->id;
                        $activity_med_eqp->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_med_eqp->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_med_eqp->validate();
                        $activity_med_eqp->save();
                    }
                    break;
                case GenralModel::CATEGORY_OTHERS:
                    for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_other = new OfferOthersDetail();
                        $activity_other->offer_help_id = $model_request_help->id;
                        $activity_other->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_other->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_other->validate();
                        $activity_other->save();
                    }
                    break;
                default:
            }
            $this->response['data'] = $model_offer_help->detail;
        } else {
            
        }



        // $this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

}
