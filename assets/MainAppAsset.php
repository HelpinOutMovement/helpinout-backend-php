<?php

namespace app\assets;

use yii;
use yii\web\AssetBundle;
use app\assets\AppAsset;

class MainAppAsset extends AssetBundle {

    public $sourcePath = '@app/themes/helpinout/main_assets/';
    public $css = [
        'fonts/font-awesome-4.7.0/css/font-awesome.min.css',
        'css/bootstrap.min.css',
        'css/all.min.css',
        'css/style.css',
        'css/slick.css',
        'css/slick-theme.css',
        'https://cdn.thinkgeo.com/vectormap-js/1.0.2/vectormap.css',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $js = [
        'js/jquery-3.4.1.min.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/bootstrap.bundle.min.js',
        'js/slick.min.js',
        'js/main.js',
        'https://cdn.thinkgeo.com/vectormap-js/1.0.2/vectormap.js',
        'https://cdn.thinkgeo.com/vectormap-icons/1.0.0/webfontloader.js',
        'js/map-script.js'
    ];

//    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
//        'yii\bootstrap\BootstrapPluginAsset',
//    ];

    public function init() {
        parent::init();
    }

}
