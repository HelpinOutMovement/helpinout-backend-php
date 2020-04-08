<?php

namespace app\helpers;

class RatingHelper {

    public static function getRatingColorByNumber($num = -1) {
        $color = ["#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F", "#D53E4F",
                  "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61", "#FDAE61",
                  "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5", "#66C2A5",
                  "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD", "#3288BD",
                  "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2", "#5E4FA2"];
        if($num == "")
            return "";
        else if ($num == -1)
            return $color;
        else if ($num >= 0 && $num <= 100)
           return $color[$num];
        else
           return "";
    }

    public static function getRatingColorArray() {
        $color = ["#D53E4F", "#FDAE61", "#66C2A5", "#3288BD", "#5E4FA2"];

        return $color;
    }

}
