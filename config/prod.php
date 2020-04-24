<?php

$custome_array = (array_replace_recursive(
                require(dirname(__FILE__) . '/config.php'), array(
            'components' => [
                'db' => [
                    'dsn' => 'mysql:host=hio-aurora-mysql-mumbai-1.cluster-cx5te3q4gasc.ap-south-1.rds.amazonaws.com;dbname=helpinout',
                    'username' => 'helpinout',
                    'password' => 'Phoht0eeshaeha',
                ],
              ]
           )
	));

return $custome_array;
?>
