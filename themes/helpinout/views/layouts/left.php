
<?php

use dektrium\user\models\User;
use app\models\UserModel;
?> 
<aside class="main-sidebar">
    <section class="sidebar">
        <div>&nbsp;</div>
        <?=
        dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
//                        Yii::$app->user->isGuest ?
//                                [
//                            'label' => 'Login', 'icon' => 'fa fa-sign-in', 'url' => ['/login']
//                                ] :
//                                [
//                            'label' => 'Dashboard',
//                            'url' => ['/dashboard'],
//                            'icon' => 'dashboard',
//                            'visible' => (!Yii::$app->user->isGuest),
//                                ],

                        ['label' => 'API', 'url' => ['/'],
                            'icon' => 'fas fa-info',
                            'visible' => !Yii::$app->user->isGuest and ( isset(Yii::$app->user->identity) and ( Yii::$app->user->identity->role_id == UserModel::ROLE_SUPERADMIN or Yii::$app->user->identity->role_id == UserModel::ROLE_ADMIN)),
                            'items' => [
                                ['label' => 'Api Log', 'url' => ['/admin/apilog/index']],
                                ['label' => 'App Detail', 'icon' => 'fas fa-list', 'url' => ['/admin/app-detail/index']],
                            ]],
                        [
                            'label' => 'Offer Help',
                            'url' => ['/report/offerhelp'],
                        ],
                         [
                            'label' => 'Request Help',
                            'url' => ['/report/requesthelp'],
                        ],
                         [
                            'label' => 'App User',
                            'url' => ['/report/appuser'],
                        ],
                         [
                            'label' => 'Api Log',
                            'url' => ['/report/apilog'],
                        ],
//                        
                    ],
                ]
        )
        ?>

    </section>

</aside>





