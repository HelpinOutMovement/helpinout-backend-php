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
                $returnMsg .= "" . $attribute . " - " . $error . "; ";
            }
        }
        return $returnMsg;
    }

    public static function convertDateTimetoTZFormat($date_time, $time_zone_offset) {
        //echo $time_zone_offset." ".strtotime($time_zone_offset);
        if ($time_zone_offset < 0)
            return date("Y-m-d\TH:i:s.000", strtotime($date_time)) . "-" . date("H:i", strtotime($time_zone_offset));
        else
            return date("Y-m-d\TH:i:s.000", strtotime($date_time)) . "+" . date("H:i", strtotime($time_zone_offset));
    }

    public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return round(($miles * 1.609344), 2);
            } else if ($unit == "N") {
                return round(($miles * 0.8684), 2);
            } else {
                return $miles;
            }
        }
    }

}
