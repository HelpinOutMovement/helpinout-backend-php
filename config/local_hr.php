<?php

$custome_array = (array_replace_recursive(
                require(dirname(__FILE__) . '/config.php'), array(
            'components' => [
                'db' => [
                    'dsn' => 'mysql:host=localhost;dbname=hepinout',
                    'username' => 'root',
                    'password' => 'password',
                    'on afterOpen' => function($event) {
                        $event->sender->createCommand("SET sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';")->execute();
                    },
                ],
            ],
            'params' => [
                'adminEmail' => 'rahman.kld@gmail.com',
                'baseurl' => 'http://hepinout.tli',
                'datapath' => '/home/rahman/hepinout/',
                'tmp' => '/tmp/',
                'sms_lane_enable' => FALSE,
                'amazon_mail_enable' => TRUE,
                'technical_team_email' => ['rahman.kld@gmail.com', 'vikas.k.c@gmail.com'],
            ],
                )
        ));

return $custome_array;
?>