<?php

return (array_replace_recursive(
                require(dirname(__FILE__) . '/console.php'), array(
            'components' => [
                'db' => [
                    'dsn' => 'mysql:host=localhost;dbname=hcl_baseline',
                    'username' => 'root',
                    'password' => 'password',
                    'on afterOpen' => function($event) {
                        $event->sender->createCommand("SET sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';")->execute();
                    },
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
            ],
            'params' => [
                'adminEmail' => 'rahman.kld@gmail.com',
                'baseurl' => 'http://hcl-baseline.tli',
                'datapath' => '/home/rahman/hss/',
                'tmp' => '/tmp/',
                'sms_lane_enable' => FALSE,
                'amazon_mail_enable' => TRUE,
                'technical_team_email' => ['rahman.kld@gmail.com', 'vikas.k.c@gmail.com'],
            ],
                )
        ));
?>