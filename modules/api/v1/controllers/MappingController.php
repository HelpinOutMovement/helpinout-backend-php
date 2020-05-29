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
use app\models\HelpinoutRateReport;

/**
 * User controller for the `api` module
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class MappingController extends Controller {

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

    public function actionDelete() {
        $response = \Yii::$app->response;

        if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_REQUEST) {
            $model_request_help = RequestHelp::findOne(['request_uuid' => $this->data_json['activity_uuid']]);

            $offer = $this->data_json['offerer'][0];
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $offer['activity_uuid']]);
            if (isset($offer['mapping_initiator']))
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id, 'mapping_initiator' => $offer['mapping_initiator']]);
            else
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);

            $helpinout_mapping->status = 0;
            $helpinout_mapping->mapping_delete_by = GenralModel::HELP_TYPE_REQUESTER;
            $helpinout_mapping->save();

            GenralModel::genrateNotification($model_request_help->id, $model_offer_help->id, GenralModel::NOTIFICATION_REQUEST_CANCELLED, $model_offer_help->app_user_id, $model_offer_help->master_category_id);
            $this->response['data'] = $model_request_help->getDetail(false, false, true);
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);

            $request = $this->data_json['requester'][0];
            $model_request_help = RequestHelp::findOne(['request_uuid' => $request['activity_uuid']]);
            if (isset($request['mapping_initiator']))
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id, 'mapping_initiator' => $request['mapping_initiator']]);
            else
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);

            $helpinout_mapping->status = 0;
            $helpinout_mapping->mapping_delete_by = GenralModel::HELP_TYPE_OFFERER;
            $helpinout_mapping->save();

            GenralModel::genrateNotification($model_request_help->id, $model_offer_help->id, GenralModel::NOTIFICATION_OFFER_CANCELLED, $model_request_help->app_user_id, $model_request_help->master_category_id);
            $this->response['data'] = $model_offer_help->getDetail(false, false, true);
        }


        //$this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

    public function actionCall() {
        $response = \Yii::$app->response;

        if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_REQUEST) {
            $model_request_help = RequestHelp::findOne(['request_uuid' => $this->data_json['activity_uuid']]);

            //foreach ($this->data_json['offerer'] as $offer) {
            $offer = $this->data_json['offerer'][0];
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $offer['activity_uuid']]);
            if (isset($offer['mapping_initiator']) && $offer['mapping_initiator'] != "0")
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id, 'mapping_initiator' => $offer['mapping_initiator']]);
            else
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);

            $helpinout_mapping->call_initiated = 1;
            $helpinout_mapping->save();
            //}
            //$this->response['data'] = $model_request_help->getDetail(false, false, true);
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);

            //foreach ($this->data_json['requester'] as $request) {
            $request = $this->data_json['requester'][0];
            $model_request_help = RequestHelp::findOne(['request_uuid' => $request['activity_uuid']]);
            if (isset($request['mapping_initiator']) && $offer['mapping_initiator'] != "0")
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id, 'mapping_initiator' => $request['mapping_initiator']]);
            else
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);

            $helpinout_mapping->call_initiated = 1;
            $helpinout_mapping->save();
            //}
            //$this->response['data'] = $model_offer_help->getDetail(false, false, true);
        }


        $this->response['data'] = '{}';
        $response->data = $this->response;
        return $this->response;
    }

    public function actionRating() {
        $response = \Yii::$app->response;

        if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_REQUEST) {
            $model_request_help = RequestHelp::findOne(['request_uuid' => $this->data_json['activity_uuid']]);

            //foreach ($this->data_json['offerer'] as $offer) {
            $offer = $this->data_json['offerer'][0];
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $offer['activity_uuid']]);
            if (isset($request['mapping_initiator']))
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id, 'mapping_initiator' => $request['mapping_initiator']]);
            else
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);

            $helpinout_mapping_rate_report = HelpinoutRateReport::findOne(['helpinout_mapping_id' => $helpinout_mapping->id, 'rating_taken_for' => GenralModel::HELP_TYPE_OFFERER]);
            if ($helpinout_mapping_rate_report == '') {
                $helpinout_mapping_rate_report = new HelpinoutRateReport();
                $helpinout_mapping_rate_report->helpinout_mapping_id = $helpinout_mapping->id;
                $helpinout_mapping_rate_report->rating_taken_for = GenralModel::HELP_TYPE_OFFERER;
            }

            $helpinout_mapping_rate_report->offer_help_id = $helpinout_mapping->offerdetail->id;
            $helpinout_mapping_rate_report->offer_app_user_id = $helpinout_mapping->offerdetail->app_user_id;

            $helpinout_mapping_rate_report->request_help_id = $helpinout_mapping->requestdetail->id;
            $helpinout_mapping_rate_report->request_app_user_id = $helpinout_mapping->requestdetail->app_user_id;

            $helpinout_mapping_rate_report->rating = $offer['rate_report']['rating'];
            $helpinout_mapping_rate_report->recommend_other = $offer['rate_report']['recommend_other'];
            $helpinout_mapping_rate_report->comments = $offer['rate_report']['comments'];


            if ($helpinout_mapping_rate_report->validate())
                $helpinout_mapping_rate_report->save();
            else {
                print_r($helpinout_mapping_rate_report->errors);
                exit;
            }
            //}
            $this->response['data'] = $model_request_help->getDetail(false, false, true);
        } else if ($this->data_json['activity_type'] == GenralModel::HELP_TYPE_OFFER) {
            $model_offer_help = OfferHelp::findOne(['offer_uuid' => $this->data_json['activity_uuid']]);

            //foreach ($this->data_json['requester'] as $request) {
            $request = $this->data_json['requester'][0];
            $model_request_help = RequestHelp::findOne(['request_uuid' => $request['activity_uuid']]);
            if (isset($request['mapping_initiator']))
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id, 'mapping_initiator' => $request['mapping_initiator']]);
            else
                $helpinout_mapping = HelpinoutMapping::findOne(['request_help_id' => $model_request_help->id, 'offer_help_id' => $model_offer_help->id]);

            $helpinout_mapping_rate_report = HelpinoutRateReport::findOne(['helpinout_mapping_id' => $helpinout_mapping->id, 'rating_taken_for' => GenralModel::HELP_TYPE_REQUESTER]);
            if ($helpinout_mapping_rate_report == '') {
                $helpinout_mapping_rate_report = new HelpinoutRateReport();
                $helpinout_mapping_rate_report->helpinout_mapping_id = $helpinout_mapping->id;
                $helpinout_mapping_rate_report->rating_taken_for = GenralModel::HELP_TYPE_REQUESTER;
            }

            $helpinout_mapping_rate_report->offer_help_id = $helpinout_mapping->offerdetail->id;
            $helpinout_mapping_rate_report->offer_app_user_id = $helpinout_mapping->offerdetail->app_user_id;

            $helpinout_mapping_rate_report->request_help_id = $helpinout_mapping->requestdetail->id;
            $helpinout_mapping_rate_report->request_app_user_id = $helpinout_mapping->requestdetail->app_user_id;

            $helpinout_mapping_rate_report->rating = $request['rate_report']['rating'];
            $helpinout_mapping_rate_report->recommend_other = $request['rate_report']['recommend_other'];
            $helpinout_mapping_rate_report->comments = $request['rate_report']['comments'];

            if ($helpinout_mapping_rate_report->validate())
                $helpinout_mapping_rate_report->save();
            else {
                print_r($helpinout_mapping_rate_report->errors);
                exit;
            }
            //}
            $this->response['data'] = $model_offer_help->getDetail(false, false, true);
        }

        $response->data = $this->response;
        return $this->response;
    }

}
