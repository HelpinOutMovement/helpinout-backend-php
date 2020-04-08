<?php

namespace app\helpers;

use yii\db\Expression;

class Utility {

    public static function object_to_array($data) {
        if (is_array($data) || is_object($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                $result[$key] = Utility::object_to_array($value);
            }
            return $result;
        }
        return $data;
    }

    public static function gettoday($time = true, $format = 'Y-m-d') {
        $now = (new \yii\db\Query)->select(new Expression('NOW()'))->scalar();
        $date = \Yii::$app->formatter->asDatetime($now, "php:$format");
        return $time ? strtotime($date) : $date;
    }

    public static function convertModelErrorToString($model) {
        $returnMsg = "";
        /* @var $model Model */
        foreach ($model->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $returnMsg.="" . $attribute . " - " . $error . "; ";
            }
        }
        return $returnMsg;
    }

    public static function convertDateTimeToPBOFormat($datetime_mysql = null, $datetime_php = null) {
        if ($datetime_mysql != null) {
            $oDate = new \DateTime($datetime_mysql);
            $sDate = $oDate->format("d/m/Y h:i A");
        }
        return $sDate;
    }

}
