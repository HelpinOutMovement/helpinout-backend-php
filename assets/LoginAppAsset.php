<?php

namespace app\assets;

use yii;
use yii\web\AssetBundle;
use app\assets\AppAsset;

class LoginAppAsset extends AssetBundle {

    public $sourcePath = '@app/themes/helpinout/assets/';
    public $css = [
        'fonts/font-awesome-4.7.0/css/font-awesome.min.css',
      //  'css/login.css',
          'login.css',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $js = [
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
