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
            $model_request_help->self_else = isset($this->data_json['self_else']) ? $this->data_json['self_else'] : "1";
            $model_request_help->request_note = isset($this->data_json['request_note']) ? $this->data_json['request_note'] : "";

            if ($model_request_help->validate()) {
                $model_request_help->save();
            } else {
                print_r($model_request_help->errors);
                exit;
            }

            switch ($model_request_help->master_category_id) {
                case GenralModel::CATEGORY_FOOD:
                    RequestFoodDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
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
                    RequestPeopleDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
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
                    RequestShelterDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
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
                    RequestMedPpeDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
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
                    RequestTestingDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
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
                    RequestMedicineDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
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
                    RequestAmbulanceDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
                    //for ($i = 0; $i < $model_request_help->no_of_items; $i++) {
                    $activity_ambulance = new RequestAmbulanceDetail();
                    $activity_ambulance->request_help_id = $model_request_help->id;
                    $activity_ambulance->quantity = $this->data_json['activity_detail']['qty'];
                    $activity_ambulance->validate();
                    $activity_ambulance->save();
                    //}
                    break;
                case GenralModel::CATEGORY_MEDICAL_EQUIPMENT:
                    RequestMedicalEquipmentDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
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
                    RequestOthersDetail::updateAll(['status' => '0'], ['request_help_id' => $model_request_help->id]);
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

            $model_offer_help->offer_note = isset($this->data_json['offer_note']) ? $this->data_json['offer_note'] : "";
            $model_offer_help->offer_note = isset($this->data_json['offer_note']) ? $this->data_json['offer_note'] : "";

            if ($model_offer_help->validate()) {
                $model_offer_help->save();
            } else {
                print_r($model_offer_help->errors);
                exit;
            }


            switch ($model_offer_help->master_category_id) {
                case GenralModel::CATEGORY_FOOD:
                    OfferFoodDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
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
                    OfferPeopleDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
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
                    OfferShelterDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
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
                    OfferMedPpeDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
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
                    OfferTestingDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
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
                    OfferMedicineDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
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
                    OfferAmbulanceDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
                    //for ($i = 0; $i < $model_offer_help->no_of_items; $i++) {
                    $activity_ambulance = new OfferAmbulanceDetail();
                    $activity_ambulance->offer_help_id = $model_offer_help->id;
                    $activity_ambulance->quantity = $this->data_json['activity_detail']['qty'];
                    $activity_ambulance->validate();
                    $activity_ambulance->save();
                    //}
                    break;
                case GenralModel::CATEGORY_MEDICAL_EQUIPMENT:
                    OfferMedicalEquipmentDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
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
                    OfferOthersDetail::updateAll(['status' => '0'], ['offer_help_id' => $model_offer_help->id]);
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

            $offers = HelpinoutMapping::findAll(['request_help_id' => $model_request_help->id, 'status' => 1]);
            foreach ($offers as $offer) {
                $model_offer_help = OfferHelp::findOne($offer->offer_help_id);

                HelpinoutMapping::updateAll(['status' => '-1', 'mapping_delete_by' => GenralModel::HELP_TYPE_REQUESTER], ['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);

//                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);
//
//                $helpinout_mapping->status = -1;
//                $helpinout_mapping->mapping_delete_by = GenralModel::HELP_TYPE_REQUESTER;
//                $helpinout_mapping->save();

                GenralModel::genrateNotification($model_request_help->id, $model_offer_help->id, GenralModel::NOTIFICATION_REQUEST_CANCELLED, $model_offer_help->app_user_id, $model_offer_help->master_category_id);
            }

            $this->response['data'] = $model_request_help->getDetail(false, true);
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);

            if ($model_offer_help == '') {
                throw new \yii\web\BadRequestHttpException("Bad Request, UUid Not found"); // HTTP COde 400
            }

            $model_offer_help->inactivate();

            $requests = HelpinoutMapping::findAll(['offer_help_id' => $model_offer_help->id, 'status' => 1]);
            foreach ($requests as $request) {
                $model_request_help = requestHelp::findOne($request->request_help_id);

                HelpinoutMapping::updateAll(['status' => '-1', 'mapping_delete_by' => GenralModel::HELP_TYPE_OFFERER], ['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);

//                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);
//
//                $helpinout_mapping->status = -1;
//                $helpinout_mapping->mapping_delete_by = GenralModel::HELP_TYPE_OFFERER;
//                $helpinout_mapping->save();

                GenralModel::genrateNotification($model_request_help->id, $model_offer_help->id, GenralModel::NOTIFICATION_OFFER_CANCELLED, $model_request_help->app_user_id, $model_request_help->master_category_id);
            }

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

//            $offerers = OfferHelp::find()->join("left outer join", "helpinout_mapping", "offer_help.id = helpinout_mapping.offer_help_id  and offer_help.app_user_id != helpinout_mapping.offer_app_user_id")
//                            ->where(['master_category_id' => $model_request_help->master_category_id, 'offer_help.status' => '1'])
//                            ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
//                            ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])
//                            ->andWhere("helpinout_mapping.offer_help_id is null")->orderBy('offer_help.id desc')->limit(5)->all();



            $sql_count = 0;
            $this->response['data']["offers"] = array();
            while (true) {
                $offerers = OfferHelp::find()->select(['offer_help.*', 'distance' => new Expression('ST_distance( ' . new Expression('point(' . $model_request_help->lat . ' , ' . $model_request_help->lng . ' )') . ',location)')])->where(['master_category_id' => $model_request_help->master_category_id, 'status' => '1'])
                                ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                                ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])
                                ->orderBy('distance asc')->limit(10)->offset($sql_count)->all();

                if (count($offerers) == 0)
                    break;
                else
                    foreach ($offerers as $model_offer_help) {
                        $sql_count++;

                        $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id, 'mapping_initiator' => GenralModel::HELP_TYPE_REQUESTER]);
                        if ($helpinout_mapping == '') {
                            $t = $model_offer_help->getDetail(true, true);
                            $t['distance'] = \app\helpers\Utility::distance($model_offer_help->lat, $model_offer_help->lng, $model_request_help->lat, $model_request_help->lng, "K");
                            array_push($this->response['data']["offers"], $t);
                        }
                        if (count($this->response['data']["offers"]) == 5)
                            break 2;
                    }
            }
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);

//            $requests = RequestHelp::find()->join("left outer join", "helpinout_mapping", "request_help.id = helpinout_mapping.request_help_id  and request_help.app_user_id != helpinout_mapping.request_app_user_id")
//                            ->where(['master_category_id' => $model_offer_help->master_category_id, 'request_help.status' => '1'])
//                            ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
//                            ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])
//                            ->andWhere("helpinout_mapping.request_help_id is null")->orderBy('request_help.id desc')->limit(5)->all();
            //  $sql_count


            $sql_count = 0;
            $this->response['data']["requests"] = array();
            while (true) {
                $requests = RequestHelp::find()->select(['request_help.*', 'distance' => new Expression('ST_distance( ' . new Expression('point(' . $model_offer_help->lat . ' , ' . $model_offer_help->lng . ' )') . ',location)')])->where(['master_category_id' => $model_offer_help->master_category_id, 'status' => '1'])
                                ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                                ->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])
                                ->orderBy('distance asc')->limit(10)->offset($sql_count)->all();
                if (count($requests) == 0)
                    break;
                else
                    foreach ($requests as $model_request_help) {
                        $sql_count++;

                        $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id, 'mapping_initiator' => GenralModel::HELP_TYPE_OFFERER]);
                        if ($helpinout_mapping == '') {
                            $t = $model_request_help->getDetail(true, true);
                            $t['distance'] = \app\helpers\Utility::distance($model_offer_help->lat, $model_offer_help->lng, $model_request_help->lat, $model_request_help->lng, "K");
                            array_push($this->response['data']["requests"], $t);
                        }

                        if (count($this->response['data']["requests"]) == 5)
                            break 2;
                    }
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
                    $helpinout_maping->time_zone_offset = \Yii::$app->controller->module->model_apilog->request_time_zone_offset;
                    $helpinout_maping->datetime = \Yii::$app->controller->module->model_apilog->request_datetime;
                    $helpinout_maping->distance = \app\helpers\Utility::distance($model_offer_help->lat, $model_offer_help->lng, $model_request_help->lat, $model_request_help->lng, "K");

                    if ($helpinout_maping->validate())
                        $helpinout_maping->save();
                    else {
                        print_r($helpinout_maping->errors);
                        exit;
                    }
                    GenralModel::genrateNotification($model_request_help->id, $model_offer_help->id, GenralModel::NOTIFICATION_REQUEST_RECEIVED, $model_offer_help->app_user_id, $model_offer_help->master_category_id);
                }
            }
            $this->response['data'] = $model_request_help->getDetail(false, false, true);
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);


            if (isset($this->data_json['all_requester'])) {

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

                $requests = RequestHelp::find()->where(['master_category_id' => $model_offer_help->master_category_id, 'status' => '1'])
                                ->andWhere(['between', 'lat', $minlat, $maxlat])->andWhere(['between', 'lng', $minlng, $maxlng])
                                //->andWhere(['!=', 'app_user_id', \Yii::$app->controller->module->model_apilog->app_user_id])
                                ->orderBy('id desc')->all();

                foreach ($requests as $model_request_help) {
                    $helpinout_maping = HelpinoutMapping::findOne(['offer_help_id' => $model_offer_help->id, 'request_help_id' => $model_request_help->id, 'mapping_initiator' => $this->data_json['activity_type']]);
                    if ($helpinout_maping == '') {
                        $helpinout_maping = new HelpinoutMapping();
                        $helpinout_maping->offer_help_id = $model_offer_help->id;
                        $helpinout_maping->request_help_id = $model_request_help->id;
                        $helpinout_maping->request_app_user_id = $model_request_help->app_user_id;
                        $helpinout_maping->offer_app_user_id = $model_offer_help->app_user_id;
                        $helpinout_maping->mapping_initiator = $this->data_json['activity_type'];
                        $helpinout_maping->time_zone_offset = \Yii::$app->controller->module->model_apilog->request_time_zone_offset;
                        $helpinout_maping->datetime = \Yii::$app->controller->module->model_apilog->request_datetime;
                        $helpinout_maping->distance = \app\helpers\Utility::distance($model_offer_help->lat, $model_offer_help->lng, $model_request_help->lat, $model_request_help->lng, "K");

                        if ($helpinout_maping->validate())
                            $helpinout_maping->save();
                        else {
                            print_r($helpinout_maping->errors);
                            exit;
                        }
                        GenralModel::genrateNotification($model_request_help->id, $model_offer_help->id, GenralModel::NOTIFICATION_OFFER_RECEIVED, $model_request_help->app_user_id, $model_request_help->master_category_id);
                    }
                }
            } else if (isset($this->data_json['requester'])) {
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
                        $helpinout_maping->time_zone_offset = \Yii::$app->controller->module->model_apilog->request_time_zone_offset;
                        $helpinout_maping->datetime = \Yii::$app->controller->module->model_apilog->request_datetime;
                        $helpinout_maping->distance = \app\helpers\Utility::distance($model_offer_help->lat, $model_offer_help->lng, $model_request_help->lat, $model_request_help->lng, "K");

                        if ($helpinout_maping->validate())
                            $helpinout_maping->save();
                        else {
                            print_r($helpinout_maping->errors);
                            exit;
                        }
                        GenralModel::genrateNotification($model_request_help->id, $model_offer_help->id, GenralModel::NOTIFICATION_OFFER_RECEIVED, $model_request_help->app_user_id, $model_request_help->master_category_id);
                    }
                }
            }

            $this->response['data'] = $model_offer_help->getDetail(false, false, true);
        }


        // $this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

    public function actionDetail() {
        $response = \Yii::$app->response;

        if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_REQUEST) {
            $model_request_help = RequestHelp::findOne(['request_uuid' => $this->data_json['activity_uuid']]);

            if ($model_request_help == '') {
                throw new \yii\web\BadRequestHttpException("Bad Request, UUid Not found"); // HTTP COde 400
            }
            $this->response['data'] = $model_request_help->getDetail(true, false, true);
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);

            if ($model_offer_help == '') {
                throw new \yii\web\BadRequestHttpException("Bad Request, UUid Not found"); // HTTP COde 400
            }
            $this->response['data'] = $model_offer_help->getDetail(true, false, true);
        }

        $response->data = $this->response;
        return $this->response;
    }

    public function actionNewmatches() {
        $response = \Yii::$app->response;

        if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_REQUEST) {
            $requests = RequestHelp::find()->where(['app_user_id' => \Yii::$app->controller->module->model_apilog->app_user_id, 'status' => '1'])->orderBy(' created_at desc')->all();
            $this->response['data']["requests"] = array();
            foreach ($requests as $request) {
                array_push($this->response['data']["requests"], ['activity_uuid' => $request->request_uuid, 'new_matches' => 0]);
            }
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $offers = OfferHelp::find()->where(['app_user_id' => \Yii::$app->controller->module->model_apilog->app_user_id, 'status' => '1'])->orderBy(' created_at desc')->all();

            $this->response['data']["offers"] = array();
            foreach ($offers as $offer) {
                array_push($this->response['data']["offers"], ['activity_uuid' => $offer->offer_uuid, 'new_matches' => 0]);
            }
        }

        $response->data = $this->response;
        return $this->response;
    }

}
