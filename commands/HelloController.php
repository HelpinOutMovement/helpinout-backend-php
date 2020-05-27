<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\AppUser;
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
use yii\db\Expression;
use app\models\base\GenralModel;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world') {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionUpdatedistance($message = 'hello world') {
        $mapping = \app\models\HelpinoutMapping::find()->all();

        foreach ($mapping as $map) {
            $model_request_help = \app\models\RequestHelp::findOne($map->request_help_id);
            $model_offer_help = \app\models\OfferHelp::findOne($map->offer_help_id);


            $map->distance = \app\helpers\Utility::distance($model_offer_help->lat, $model_offer_help->lng, $model_request_help->lat, $model_request_help->lng, "K");
            $map->update();
        }

        return ExitCode::OK;
    }

    public function actionCoast() {

        $str = file_get_contents('./supportnetwork.json');

        $json = json_decode($str, true);


        //  echo '<pre>' . print_r($json, true) . '</pre>';
        //echo count($json['results']);
        //echo print_r($json['results'][0]);

        foreach ($json['results'] as $t) {
            // print_r($t);
            //echo $t['title'] ."";
            //echo  $t['formio_usergroup'] . " "  ;
            //echo   $t['record_type'] . " "  ;

            $phone = substr($t['phone'], 0, 10); //. " " . substr($t['contact_numbers'], 10);
            echo $t['id'] . ". ";
            if ($this->validate_mobile($phone)) {
                //  echo $t['address'];
//               
//                    echo $t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'];

                echo "\r\n";

                $user = AppUser::findOne(['mobile_no' => $phone]);
                if ($user == "") {
                    $user = New AppUser();
                    $user->country_code = "+91";
                    $user->mobile_no = $phone;
                    $user->time_zone = "Asia/Kolkata";
                    $user->mobile_no_visibility = 1;
                    $name = $t['full_name'] != "" ? $t['full_name'] : $t['org_name'];
                    $user->first_name = $user->last_name = $user->profile_name = $user->org_name = $name;
                    $user->time_zone_offset = "05:30:00";
                    $user->user_type = 2;
                    $user->master_app_user_org_type = 5;
                    $user->org_division = "";
                    $user->ref_id = "" . $t['id'];
                    // $user->save();
                    if ($user->validate())
                        $user->save();
                    else
                        print_r($user->errors);
                }



                if (isset($t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'])) {
                    //   echo $t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'];
                    $model_offer_help = OfferHelp::findOne(['ref_id' => "" . $t['id']]);
                    if ($model_offer_help == "") {

                        $parsed_date_time = date_parse($t['modified']);
                        //$timezone_name = timezone_name_from_abbr("", $parsed_date_time['zone'], 0); // NB: Offset in seconds! 
//        if ($timezone_name == "") {
//            throw new \yii\web\ServerErrorHttpException('Api info log save error. Timezone not found. ' . json_encode($this->model_apilog->getErrors()));
//        } else {
                        $request_time_zone_offset = gmdate("H:i:s", $parsed_date_time['zone']);
                        if ($parsed_date_time['zone'] < 0) {
                            $date1 = new \DateTime($request_time_zone_offset);
                            $date2 = new \DateTime('24:00');
                            $finaldate = $date2->diff($date1);
                            $request_time_zone_offset = "-" . $finaldate->format('%h:%i:%s');
                        }
//        }

                        $request_date_time = $parsed_date_time['year'] . "-" . $parsed_date_time['month'] . "-" . $parsed_date_time['day'] . " " . $parsed_date_time['hour'] . ":" . $parsed_date_time['minute'] . ":" . $parsed_date_time['second'];





                        $model_offer_help = New OfferHelp();




                        $model_offer_help->app_user_id = $user->id;
                        $model_offer_help->offer_uuid = $this->gen_uuid();
                        $model_offer_help->location = new Expression('point(' . $t['latitude'] . ' , ' . $t['longitude'] . ' )');
                        $model_offer_help->lat = $t['latitude'];
                        $model_offer_help->lng = $t['longitude'];
                        $model_offer_help->accuracy = 0;
                        $model_offer_help->address = $t['address'];
                        $model_offer_help->payment = 0;
                        $model_offer_help->time_zone_offset = "05:30:00";
                        $model_offer_help->datetime = $request_date_time;
                        $model_offer_help->no_of_items = "1";
                        $model_offer_help->offer_note = $t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'];
                        $model_offer_help->ref_id = "" . $t['id'];


                        if (stripos($t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'], "food") !== false) {
                            $model_offer_help->master_category_id = \app\models\base\GenralModel::CATEGORY_FOOD;
                        } else if (stripos($t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'], "ration") !== false) {
                            $model_offer_help->master_category_id = \app\models\base\GenralModel::CATEGORY_FOOD;
                        } else if (stripos($t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'], "lunch") !== false) {
                            $model_offer_help->master_category_id = \app\models\base\GenralModel::CATEGORY_FOOD;
                        } else if (stripos($t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'], "dinner") !== false) {
                            $model_offer_help->master_category_id = \app\models\base\GenralModel::CATEGORY_FOOD;
                        } else if (stripos($t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'], "medical") !== false) {
                            $model_offer_help->master_category_id = \app\models\base\GenralModel::CATEGORY_MEDICINES;
                        } else if (stripos($t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'], "hygiene") !== false) {
                            $model_offer_help->master_category_id = \app\models\base\GenralModel::CATEGORY_OTHERS;
                        } else if (stripos($t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'], "Toiletries") !== false) {
                            $model_offer_help->master_category_id = \app\models\base\GenralModel::CATEGORY_OTHERS;
                        } else if (stripos($t['prefill_json']['data']['needsForm']['data']['needs']['whatHelp'], "essential") !== false) {
                            $model_offer_help->master_category_id = \app\models\base\GenralModel::CATEGORY_OTHERS;
                        } else {
                            
                        }


                        switch ($model_offer_help->master_category_id) {
                            case GenralModel::CATEGORY_FOOD:
                                $model_offer_help->save();

                                $activity_food = new OfferFoodDetail();
                                $activity_food->offer_help_id = $model_offer_help->id;
                                $activity_food->detail = "";
                                $activity_food->quantity = NULL;
                                $activity_food->validate();
                                $activity_food->save();
                                break;

                            case GenralModel::CATEGORY_MEDICINES:
                                $model_offer_help->save();

                                $activity_medicine = new OfferMedicineDetail();
                                $activity_medicine->offer_help_id = $model_offer_help->id;
                                $activity_medicine->detail = "";
                                $activity_medicine->quantity = NULL;
                                $activity_medicine->validate();
                                $activity_medicine->save();
                                break;

                            case GenralModel::CATEGORY_OTHERS:
                                $model_offer_help->save();

                                $activity_other = new OfferOthersDetail();
                                $activity_other->offer_help_id = $model_offer_help->id;
                                $activity_other->detail = "";
                                $activity_other->quantity = NULL;
                                $activity_other->validate();
                                $activity_other->save();
                                break;
                        }
                    }
                }
            } else {
                //  echo $t['full_name'] != "" ? $t['full_name'] : $t['org_name'];
                // echo "  ->  ";
                // echo $phone;
                //echo   $t['record_subtype'] . "   ";
                //echo   $t['record_subtype'] . "   ";
                //echo   $t['record_subtype'] . "   ";
                //echo "\r\n";
            }
        }

        return ExitCode::OK;
    }

//    /Food, lunch dinner shelter wheat atta Grocery ration
    //medical kit
    // hygiene
    // Toiletries
    //essential

    function validate_mobile($mobile) {
        return preg_match('/^[0-9]{10}+$/', $mobile);
    }

    function gen_uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

}
