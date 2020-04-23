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
use app\models\HelpinoutMapping;

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

            if ($model_request_help->validate()) {
                $model_request_help->save();
            } else {
                print_r($model_request_help->errors);
                exit;
            }

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
                        $activity_shelter = new RequestShelterDetail();
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
            $this->response['data'] = $model_request_help->getDetail(true, false);
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
            $model_offer_help->no_of_items = isset($this->data_json['activity_count']) ? $this->data_json['activity_count'] : "1";
            $model_offer_help->address = $this->data_json['address'];
            $model_offer_help->payment = $this->data_json['pay'];
            $model_offer_help->time_zone_offset = \Yii::$app->controller->module->model_apilog->request_time_zone_offset;
            $model_offer_help->datetime = \Yii::$app->controller->module->model_apilog->request_datetime;
            $model_offer_help->offer_condition = isset($this->data_json['offer_condition']) ? $this->data_json['offer_condition'] : "";

            if ($model_offer_help->validate()) {
                $model_offer_help->save();
            } else {
                print_r($model_offer_help->errors);
                exit;
            }

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
                    $activity_people->offer_help_id = $model_offer_help->id;
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
                        $activity_shelter = new OfferShelterDetail();
                        $activity_shelter->offer_help_id = $model_offer_help->id;
                        $activity_shelter->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_shelter->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_shelter->validate();
                        $activity_shelter->save();
                    }
                    break;
                case GenralModel::CATEGORY_MED_PPE:
                    for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_medppe = new OfferMedPpeDetail();
                        $activity_medppe->offer_help_id = $model_offer_help->id;
                        $activity_medppe->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_medppe->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_medppe->validate();
                        $activity_medppe->save();
                    }
                    break;
                case GenralModel::CATEGORY_TESTING:
                    for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_testing = new OfferTestingDetail();
                        $activity_testing->offer_help_id = $model_offer_help->id;
                        $activity_testing->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_testing->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_testing->validate();
                        $activity_testing->save();
                    }
                    break;
                case GenralModel::CATEGORY_MEDICINES:
                    for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_medicine = new OfferMedicineDetail();
                        $activity_medicine->offer_help_id = $model_offer_help->id;
                        $activity_medicine->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_medicine->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_medicine->validate();
                        $activity_medicine->save();
                    }
                    break;
                case GenralModel::CATEGORY_AMBULANCE:
                    //for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                    $activity_ambulance = new OfferAmbulanceDetail();
                    $activity_ambulance->offer_help_id = $model_offer_help->id;
                    $activity_ambulance->quantity = $this->data_json['activity_detail']['qty'];
                    $activity_ambulance->validate();
                    $activity_ambulance->save();
                    //}
                    break;
                case GenralModel::CATEGORY_MEDICAL_EQUIPMENT:
                    for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_med_eqp = new OfferMedicalEquipmentDetail();
                        $activity_med_eqp->offer_help_id = $model_offer_help->id;
                        $activity_med_eqp->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_med_eqp->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_med_eqp->validate();
                        $activity_med_eqp->save();
                    }
                    break;
                case GenralModel::CATEGORY_OTHERS:
                    for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                        $activity_other = new OfferOthersDetail();
                        $activity_other->offer_help_id = $model_offer_help->id;
                        $activity_other->detail = $this->data_json['activity_detail'][$i]['detail'];
                        $activity_other->quantity = $this->data_json['activity_detail'][$i]['qty'];
                        $activity_other->validate();
                        $activity_other->save();
                    }
                    break;
                default:
            }
            $this->response['data'] = $model_offer_help->getDetail(true, false);
        } else {
            
        }

        $response->data = $this->response;
        return $this->response;
    }

    public function actionDelete() {
        $response = \Yii::$app->response;

        if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_REQUEST) {
            $model_request_help = RequestHelp::findOne(['request_uuid' => $this->data_json['activity_uuid']]);

            if ($model_request_help == '') {
                throw new \yii\web\BadRequestHttpException("Bad Request, UUid Not found"); // HTTP COde 400
            }

            $model_request_help->inactivate();
            $this->response['data'] = $model_request_help->getDetail(false, true);
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);

            if ($model_offer_help == '') {
                throw new \yii\web\BadRequestHttpException("Bad Request, UUid Not found"); // HTTP COde 400
            }

            $model_offer_help->inactivate();
            $this->response['data'] = $model_offer_help->getDetail(false, true);
        }

        $response->data = $this->response;
        return $this->response;
    }

    public function actionSuggestions() {
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

        if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_REQUEST) {
            $model_request_help = RequestHelp::findOne(['request_uuid' => $this->data_json['activity_uuid']]);

            $offerers = OfferHelp::find()->join("left outer join", "helpinout_mapping", "offer_help.id = helpinout_mapping.offer_help_id  and offer_help.app_user_id != helpinout_mapping.offer_app_user_id")
                            ->where(['master_category_id' => $model_request_help->master_category_id, 'offer_help.status' => '1'])
                            ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                            ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])
                            ->andWhere("helpinout_mapping.offer_help_id is null")->orderBy('offer_help.id desc')->limit(5)->all();

            $offerers = OfferHelp::find()->where(['master_category_id' => $model_request_help->master_category_id, 'status' => '1'])
                            ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                            //->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])
                            ->orderBy('id desc')->limit(5)->all();

            $this->response['data']["offers"] = array();
            foreach ($offerers as $offer) {
                array_push($this->response['data']["offers"], $offer->getDetail(true, true));
            }
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);

            $requests = RequestHelp::find()->join("left outer join", "helpinout_mapping", "request_help.id = helpinout_mapping.request_help_id  and request_help.app_user_id != helpinout_mapping.request_app_user_id")
                            ->where(['master_category_id' => $model_offer_help->master_category_id, 'request_help.status' => '1'])
                            ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                            ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])
                            ->andWhere("helpinout_mapping.request_help_id is null")->orderBy('request_help.id desc')->limit(5)->all();

            $requests = RequestHelp::find()->where(['master_category_id' => $model_offer_help->master_category_id, 'status' => '1'])
                            ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                            //->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])
                            ->orderBy('id desc')->limit(5)->all();

            $this->response['data']["requests"] = array();
            foreach ($requests as $request) {
                array_push($this->response['data']["requests"], $request->getDetail(true, true));
            }
        }

        // $this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

    public function actionMapping() {
        $response = \Yii::$app->response;

        if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_REQUEST) {
            $model_request_help = RequestHelp::findOne(['request_uuid' => $this->data_json['activity_uuid']]);

            foreach ($this->data_json['offerer'] as $offer) {

                $model_offer_help = OfferHelp::findOne(['offer_uuid' => $offer['activity_uuid']]);

                $helpinout_maping = HelpinoutMapping::findOne(['offer_help_id' => $model_offer_help->id, 'request_help_id' => $model_request_help->id, 'mapping_initiator' => $this->data_json['activity_type']]);
                if ($helpinout_maping == '') {
                    $helpinout_maping = new HelpinoutMapping();
                    $helpinout_maping->offer_help_id = $model_offer_help->id;
                    $helpinout_maping->request_help_id = $model_request_help->id;
                    $helpinout_maping->request_app_user_id = $model_request_help->app_user_id;
                    $helpinout_maping->offer_app_user_id = $model_offer_help->app_user_id;
                    $helpinout_maping->mapping_initiator = $this->data_json['activity_type'];

                    if ($helpinout_maping->validate())
                        $helpinout_maping->save();
                    else {
                        print_r($helpinout_maping->errors);
                        exit;
                    }
                }
                GenralModel::genrateNotification($model_request_help->id, $model_offer_help->id, GenralModel::NOTIFICATION_REQUEST_RECEIVED, $model_offer_help->app_user_id, $model_offer_help->master_category_id);
            }
            $this->response['data'] = $model_request_help->getDetail(false, false, true);
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);

            foreach ($this->data_json['requester'] as $request) {

                $model_request_help = RequestHelp::findOne(['request_uuid' => $request['activity_uuid']]);

                $helpinout_maping = HelpinoutMapping::findOne(['offer_help_id' => $model_offer_help->id, 'request_help_id' => $model_request_help->id, 'mapping_initiator' => $this->data_json['activity_type']]);
                if ($helpinout_maping == '') {
                    $helpinout_maping = new HelpinoutMapping();
                    $helpinout_maping->offer_help_id = $model_offer_help->id;
                    $helpinout_maping->request_help_id = $model_request_help->id;
                    $helpinout_maping->request_app_user_id = $model_request_help->app_user_id;
                    $helpinout_maping->offer_app_user_id = $model_offer_help->app_user_id;
                    $helpinout_maping->mapping_initiator = $this->data_json['activity_type'];

                    if ($helpinout_maping->validate())
                        $helpinout_maping->save();
                    else {
                        print_r($helpinout_maping->errors);
                        exit;
                    }
                }

                GenralModel::genrateNotification($model_request_help->id, $model_offer_help->id, GenralModel::NOTIFICATION_OFFER_RECEIVED, $model_request_help->app_user_id, $model_request_help->master_category_id);
            }
            $this->response['data'] = $model_offer_help->getDetail(false, false, true);
        }


        // $this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

}
