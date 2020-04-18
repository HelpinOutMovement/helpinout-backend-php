<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $sourcePath = '@app/themes/helpinout/assets/';
    // public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        //'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
        'style.css',
        'popupWindow.css',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyCaNo-whQ0kNdV0HBdKPC3X6QcURe_RtR4&callback',
      
         'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css',
     
       // 'main_assets/css/bootstrap.min.css',
       // 'main_assets/css/all.min.css',
        'main_assets/css/style.css',
        'main_assets/css/slick.css',
        'main_assets/css/slick-theme.css',
        'https://cdn.thinkgeo.com/vectormap-js/1.0.2/vectormap.css',
       
        
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $js = [
         'js/bootstrap-filestyle.js',
          'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
          'https://cdn.ckeditor.com/4.13.1/full/ckeditor.js',
        'https://code.highcharts.com/highcharts.js',
        'https://code.highcharts.com/highcharts-3d.js',
        'https://code.highcharts.com/modules/data.js',
        'https://code.highcharts.com/modules/drilldown.js',
          'https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js',
        'current.js',
        'jsonview.js',
        'http://ajax.microsoft.com/ajax/jquery.validate/1.8/jquery.validate.min.js',
        'bootstrap-multiselect.js',
         'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js',
        'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js',
        'popupWindow.js',
       // 'main_assets/js/popper.min.js',
       // 'main_assets/js/bootstrap.min.js',
      //  'main_assets/js/bootstrap.bundle.min.js',
        'main_assets/js/slick.min.js',
        'main_assets/js/main.js',
        'https://cdn.thinkgeo.com/vectormap-js/1.0.2/vectormap.js',
        'https://cdn.thinkgeo.com/vectormap-icons/1.0.0/webfontloader.js',
      //  'main_assets/js/map-script.js'
     
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function init() {
        parent::init();
    }

}
