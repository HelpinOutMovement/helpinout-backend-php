<?php

return (array_replace_recursive(
                require(dirname(__FILE__) . '/console.php'), array(
            'components' => [
                'db' => [
                    'dsn' => 'mysql:host=localhost;dbname=helpinout',
                    'username' => 'root',
                    'password' => 'Password#3',
                ],
                'log' => [
                    'traceLevel' => YII_DEBUG ? 3 : 0,
                    'targets' => [
                        [
                            'class' => 'yii\log\FileTarget',
                            'levels' => ['error', 'trace', 'info'],
                        ],
                    ],
                ],
                'firebaseNotification' => [
                    //'class' => 'app\components\notification\GoogleFirebase',
                    'firebase_api_key' => 'AAAAikKcjI4:APA91bGAPehF_Px6UG7BpSMga4isV6dnEPNYOIm3zKySw1XwNoSXnIRyas9bhOiVBiLEmCS5ITqm5LzbdOLe40WPCcVfIN6pwtHewlsENnAC0zcM7S1miUcCxLaNEyzv3yQF76dJCu4M',
                ],
            ],
            'params' => [
                'adminEmail' => 'vikas.kc@gmail.com',
                'baseurl' => 'http://jalmal.vk',
                'datapath' => '/home/vikas/www/jalmaldata/',
                'tmp_path' => '/home/vikas/www/jalmal/tmp/',
                'amazon_mail_enable' => false,
                'sms_lane_enable' => FALSE,
            ],
                )
        ));
?>