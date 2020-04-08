<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use app\models\UserModel;

class GenralModel extends \yii\base\Model {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function stateoption($status = NULL) {
        $query = MasterState::find();

        $query->orderBy('state_name asc');
        $model = $query->all();
        return ArrayHelper::map($model, 'id', 'state_name');
    }

    

    public static function appoption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \app\models\AppDetailSearch();

            if (isset($md->user_id)) {
                $searchModel->user_id = $md->user_id;
            }


            $dataProvider = $searchModel->search($md, false);

            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'id', 'id') : [];
    }

    

    public static function districtoption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \app\models\MasterDistrictSearch();

            if (isset($md->state_id)) {
                $searchModel->state_id = $md->state_id;
            }


            $dataProvider = $searchModel->search($md, false);
            $dataProvider->query->orderBy(['district_name' => SORT_ASC]);
            $dataProvider->pagination->pageSize = 100;
            $model = $dataProvider->getModels();
        }
        if ($md->state_id == '') {
            return [];
        } else {
            return isset($model) ? ArrayHelper::map($model, 'id', 'district_name') : [];
        }
    }

    public static function districtoptions($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \app\models\MasterDistrictSearch();

            if (isset($md->state_name)) {
                $searchModel->state_id = $md->state_name;
            }


            $dataProvider = $searchModel->search($md, false);

            $model = $dataProvider->getModels();
        }
        if ($md->state_name == '') {
            return [];
        } else {
            return isset($model) ? ArrayHelper::map($model, 'id', 'district_name') : [];
        }
    }

}
