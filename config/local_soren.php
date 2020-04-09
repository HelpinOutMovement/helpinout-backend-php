<?php

$custome_array = (array_replace_recursive(
                require(dirname(__FILE__) . '/config.php'), array(
            'components' => [
                'db' => [
                    'dsn' => 'mysql:host=localhost;dbname=helpinout',
                    'username' => 'root',
                    'password' => 'password',
                ],
            ],
            'params' => [
                'adminEmail' => 'rahman.kld@gmail.com',
                'baseurl' => 'http://hepinout.utpal',
                'datapath' => '/home/triline/hepinout/',
                'tmp' => '/tmp/',
                'sms_lane_enable' => FALSE,
                'amazon_mail_enable' => TRUE,
                'technical_team_email' => ['rahman.kld@gmail.com', 'vikas.k.c@gmail.com'],
            ],
                )
        ));

return $custome_array;
?>