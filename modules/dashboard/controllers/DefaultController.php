<?php

namespace app\modules\dashboard\controllers;

use yii\web\Controller;

/**
 * Default controller for the `report` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
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
