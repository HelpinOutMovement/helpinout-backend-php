<?php

return (array_replace_recursive(
                require(dirname(__FILE__) . '/console.php'), array(
            'components' => [
                'db' => [
                    'dsn' => 'mysql:host=hio-aurora-mysql-mumbai-1.cluster-cx5te3q4gasc.ap-south-1.rds.amazonaws.com;dbname=helpinout',
                    'username' => 'helpinout',
                    'password' => 'Phoht0eeshaeha',

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
                'mailSES' => [
                    'class' => 'app\components\amazonses\Mailer',
                    'access_key' => 'AKIAI6UPDYQL6DANTZKA',
                    'secret_key' => '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',
                    'host' => 'email.eu-west-1.amazonaws.com' // not required
                ],

            ],
            'params' => [
                'amazon_mail_enable' => TRUE,
                'fromEmail' => ['admin@helpinout.org' => 'Admin HelpinOut'],
                'sms_lane_enable' => FALSE,
            ],
           )
        ));
?>
