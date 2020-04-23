<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'helpinout',
    'name' => 'helpinout',
    'homeUrl' => ['/site'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\modules\user\Bootstrap'],
    'timeZone' => 'Asia/Calcutta',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
       
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'dashboard' => [
            'class' => 'app\modules\dashboard\Module',
        ],
          'report' => [
            'class' => 'app\modules\report\Module',
        ],
        
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
            'enableConfirmation' => FALSE,
            'enableRegistration' => TRUE,
            'cost' => 12,
            'admins' => ['admin'],
            'modelMap' => [
                'User' => 'app\models\UserModel',
            ],
            'controllerMap' => [//Recovery and login
                'security' => [
                    'class' => 'app\modules\user\controllers\SecurityController',
                    'layout' => '@app/themes/helpinout/views/layouts/login',
                ],
                'recovery' => [
                    'class' => 'app\modules\user\controllers\RecoveryController',
                    'layout' => '@app/themes/helpinout/views/layouts/recovery',
                ],
                'recoveryiti' => [
                    'class' => 'app\modules\user\controllers\RecoveryitiController',
                    'layout' => '@app/themes/helpinout/views/layouts/recoveriti',
                ],
                'user' => [
                    'class' => 'app\modules\user\controllers\UserController',
                    'layout' => '@app/themes/helpinout/views/layouts/changepassword',
                ],
            ],
            'mailer' => [
                'sender' => 'vikas@arthify.com', // or ['no-reply@myhost.com' => 'Sender name']
                'welcomeSubject' => 'Welcome to helpinout',
                'confirmationSubject' => 'Confirmation subject',
                'reconfirmationSubject' => 'Email change subject',
                'recoverySubject' => 'Recovery Password - helpinout',
            ],
        ],
//        'social' => [
//            // the module class
//            'class' => 'kartik\social\Module',
//            // the global settings for the google-analytics widget
//            'googleAnalytics' => [
//                'id' => 'UA-46024777-8',
//                'domain' => 'gradingiti.bharatskills.org.in',
//            ],
//        ]
    ],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/themes/helpinout/views', '@app/modules/user/views' => '@app/views/user'],
                'baseUrl' => '@web/themes/helpinout',
            ],
        ],
        'user' => [
            'enableAutoLogin' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'itigrading@imacs.net.in',
                'password' => 'It!@Grading@123#*',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'mail' => [
            'class' => 'yashop\ses\Mailer',
            'access_key' => 'AKIAJ2IHQAEE6HWXSHSA',
            'secret_key' => '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',
            'host' => 'email.eu-west-1.amazonaws.com' // not required
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '2XY-ShY_HlFtZ8GHONWKuvpQebzI9xPV',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => '\yii\rbac\DbManager',
            'ruleTable' => 'AuthRule', // Optional
            'itemTable' => 'AuthItem', // Optional
            'itemChildTable' => 'AuthItemChild', // Optional
            'assignmentTable' => 'AuthAssignment', // Optional
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => '/site',
                '/admin/login' => 'user/security/login',
                'logout' => 'user/security/logout',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['sns'],
                    'logFile' => '@app/runtime/logs/sns/requests.log',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'mailSES' => [
            'class' => 'app\components\amazonses\Mailer',
            'access_key' => '',
            'secret_key' => '',
            'host' => 'email.eu-west-1.amazonaws.com' // not required
        ],
        'db' => ['class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2basic',
            // 'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'db_api' => ['class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2basic',
            // 'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'firebaseNotification' => [
            'class' => 'app\components\notification\GoogleFirebase',
            'firebase_api_key' => 'API_KEY',
        ],
    ],
    'params' => $params,
//    'as access' => [
//        'class' => 'mdm\admin\components\AccessControl',
//        'allowActions' => [
//            'site/*',
//            'gii/*',
//            'debug/*',
//            'user/*',
//        ]
//    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
