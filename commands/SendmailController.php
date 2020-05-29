<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\db\Expression;
use app\models\base\GenralModel;
use app\models\LogEmailOfferMappingRequest;
use app\models\AppUser;
use app\models\HelpinoutMapping;
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
use app\models\OfferHelp;

/**
 * This command Send notification.
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class SendmailController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex() {

        $log_model = LogEmailOfferMappingRequest::find()->where(['=', 'status', '1'])->limit(5)->orderBy(['id' => SORT_ASC])->all();

        foreach ($log_model as $model) {

            //try {

            $array_cat = ['0' => 'Others', '1' => 'Food', '2' => 'People', '3' => 'Shelter', '4' => 'Med PPE', '5' => 'Testing',
                '6' => 'Medicines', '7' => 'Ambulance', '8' => 'Medical Equipment', '9' => 'Volunteers', '10' => 'Fruits/Vegetables',
                '11' => 'Transport', '12' => 'Animal support', '13' => 'Giveaways', '14' => 'Paid Work'
            ];
            $array_pay = ['0' => 'No', '1' => 'Yes', '11' => 'Get Paid'];

            $array_offer = array();

            $app_user_model = AppUser::findOne($model->app_user_id);
            $message_html = "Dear " . $app_user_model->profile_name . ",<br/><br/>";
            $message_html .= "As per your request, please find attached the data table with all the requests you have received.";
            $message_html .= "<br><br/>";
            $message_html .= "Thank you for HelpinOut!";
            $message_html .= "<br><br/>";
            $message_html .= "Regards,<br>";
            $message_html .= "HelpinOut portal Team<br>";


            $csv = "s.no,reqDate,reqTime,userName,Ccode,userPhone,category,canPay,lat,long,revLUAddress,distFromOfferKm,Item1,Item1Qty,Item2,Item2Qty,Item3,Item3Qty,Item4,Item4Qty,Volunters,VolQty,Personnel,PerQty,Notes\r\n";

            $mappings = HelpinoutMapping::find()
                            ->join("inner join", "offer_help", "offer_help.id = helpinout_mapping.offer_help_id")
                            ->join("inner join", "request_help", "request_help.id = helpinout_mapping.request_help_id")
                            ->where(['offer_app_user_id' => $model->app_user_id, 'helpinout_mapping.status' => '1', 'offer_help.status' => '1', 'request_help.status' => '1'])->orderBy("helpinout_mapping.created_at desc")->all();
            $count = 1;
            foreach ($mappings as $map) {

                $request = RequestHelp::findOne($map->request_help_id);
                if (isset($array_offer[$map->offer_help_id])) {
                    
                } else {
                    $array_offer = array_merge($array_offer, ["O" . $map->offer_help_id => \app\models\OfferHelp::findOne($map->offer_help_id)]);
                }
                $offer = $array_offer["O" . $map->offer_help_id];


                $csv .= $count++ . "," . date('d-M-Y', strtotime($map->datetime)) . "," . date('G:ia', strtotime($map->datetime)) . ","
                        . $request->app_user->profile_name . "," . $request->app_user->country_code . "," . $request->app_user->mobile_no . ","
                        . $array_cat[$map->offerdetail->master_category_id] . "," . $array_pay[$map->offerdetail->payment] . ","
                        . $request->lat . "," . $request->lng . ",\"" . $request->address . "\"," . round(\app\helpers\Utility::distance($offer->lat, $offer->lng, $request->lat, $request->lng, "K"), 2) . ",";

                switch ($request->master_category_id) {
                    case GenralModel::CATEGORY_FOOD:
                    case GenralModel::CATEGORY_SHELTER:
                    case GenralModel::CATEGORY_MED_PPE:
                    case GenralModel::CATEGORY_TESTING:
                    case GenralModel::CATEGORY_MEDICINES:
                    case GenralModel::CATEGORY_MEDICAL_EQUIPMENT:
                    case GenralModel::CATEGORY_OTHERS:
                        $t = 0;
                        foreach ($request->activity_detail as $ac_d) {
                            $csv .= "\"" . $ac_d->detail . "\",";
                            if (isset($ac_d['quantity'])) {
                                $csv .= $ac_d['quantity'] == null || $ac_d['quantity'] == "null" ? "" : $ac_d['quantity'];
                                $csv .= ",";
                            }

                            $t++;
                            if ($t < 4)
                                break;
                        }
                        for (; $t < 4; $t++) {
                            $csv .= "," . ",";
                        }
                        $csv .= "," . "," . "," . ",";
                        break;
                    case GenralModel::CATEGORY_PEOPLE:
                        $csv .= "," . "," . "," . "," . "," . "," . "," . ",";

                        $t = 0;
                        foreach ($request->activity_detail as $ac_d) {
                            $csv .= "\"" . $ac_d->volunters_detail . "\"," . $ac_d->volunters_quantity . ",\"" . $ac_d->technical_personal_detail . "\"," . $ac_d->technical_personal_quantity . ",";

                            $t++;
                            if ($t < 1)
                                break;
                        }
                        for (; $t < 1; $t++) {
                            $csv .= "," . "," . "," . ",";
                        }
                        break;
                    default:
                }
                $csv .= $request->request_note . ",";
                $csv .= "\r\n";
            }

            $mailer = Yii::$app->mailSES;
            $mail = $mailer->compose()
                    ->setFrom(Yii::$app->params['fromEmail'])
                    ->setTo($model->email_address)
                    ->setCc("admin@helpinout.org")
                    //->setCc("vikaskc3@gmail.com")
                    ->setSubject("HelpinOut received-requests data table.")
                    ->setHtmlBody($message_html)
                    ->attachContent($csv, ['fileName' => 'Requests_received_' . time() . '.csv', 'contentType' => 'text/csv'])
                    ->send();
            //echo $model->email_address . " " . $mail;
            if (!empty($mail)) {
                $model->status = 2;
                $model->update();
            } else {
                $model->status = -1;
                $model->update();
            }
            //} catch (\Exception $ex) {
            //   print_r($ex->getTrace());
            //}
        }
    }

}
