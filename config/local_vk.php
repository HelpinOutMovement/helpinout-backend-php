<?php

$custome_array = (array_replace_recursive(
                require(dirname(__FILE__) . '/config.php'), array(
            'components' => [
                'db' => [
                    'dsn' => 'mysql:host=localhost;dbname=helpinout',
                    'username' => 'root',
                    'password' => 'Password#3',
                ],
            ],
            'params' => [
                'adminEmail' => 'rahman.kld@gmail.com',
                'baseurl' => 'http://helpinout.vk:8080',
                'datapath' => '/home/vikas/www/hepinout-data',
                'tmp' => '/tmp/',
                'sms_lane_enable' => FALSE,
                'amazon_mail_enable' => TRUE,
                'technical_team_email' => ['rahman.kld@gmail.com', 'vikas.k.c@gmail.com'],
            ],
                )
        ));

return $custome_array;
?>