<?php

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

class GenralModel extends \yii\base\Model {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const APP_USER_TYPE_INDIVIDUAL=1;
    const APP_USER_TYPE_ORGANIZATION=2;
    
    const HELP_TYPE_REQUEST = 1;
    const HELP_TYPE_OFFER = 2;
    
    const CATEGORY_OTHERS = 0;
    const CATEGORY_FOOD = 1;
    const CATEGORY_PEOPLE = 2;
    const CATEGORY_SHELTER = 3;
    const CATEGORY_MED_PPE = 4;
    const CATEGORY_TESTING = 5;
    const CATEGORY_MEDICINES = 6;
    const CATEGORY_AMBULANCE = 7;
    const CATEGORY_MEDICAL_EQUIPMENT = 8;
    

}
