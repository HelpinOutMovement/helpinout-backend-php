<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
switch (strtolower($_SERVER['SERVER_NAME'])) {
    case 'localhost':
        break;
    case 'hepinout.tli':
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
        require(__DIR__ . '/../vendor/autoload.php');
        require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
        $config = require(__DIR__ . '/../config/local_hr.php');
        break;
    case 'helpinout.vk':
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
        require(__DIR__ . '/../vendor/autoload.php');
        require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
        $config = require(__DIR__ . '/../config/local_vk.php');
        break;
    case 'helpinout.utpal':
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
        require(__DIR__ . '/../vendor/autoload.php');
        require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
        $config = require(__DIR__ . '/../config/local_utpal.php');
        break;
    
     case 'helpinout.soren':
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
        require(__DIR__ . '/../vendor/autoload.php');
        require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
        $config = require(__DIR__ . '/../config/local_soren.php');
        break;

    case 'beta.helpinout.org':
    case '3.7.52.176':
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
        require(__DIR__ . '/../vendor/autoload.php');
        require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
        $config = require(__DIR__ . '/../config/beta.php');
	break;

    case 'app.helpinout.org':
	defined('YII_DEBUG') or define('YII_DEBUG', false);
	defined('YII_ENV') or define('YII_ENV', 'prod');
	require(__DIR__ . '/../vendor/autoload.php');
	require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
	$config = require(__DIR__ . '/../config/prod.php');
	break;
    default:
        $config = require(__DIR__ . '/../config/web.php');
        break;
}

(new yii\web\Application($config))->run();
