
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
//                        [
//                            'label' => 'Master',
//                            'url' => '#',
//                            'items' => [
//                                ['label' => 'Bill Category', 'url' => ['/master/billcategory/']],
//                                ['label' => 'Bill Status', 'url' => ['/master/billstatus/'],],
//                                ['label' => 'Budget Category', 'url' => ['/master/budgetcategory/']],
//                                ['label' => 'Ministry', 'url' => ['/master/ministry/']],
//                                ['label' => 'Acts Type', 'url' => ['/master/parliamentactstype/']],
//                                ['label' => 'Budget Type', 'url' => ['/master/budgettype/']],
//                                ['label' => 'Budget Year', 'url' => ['/master/budgetyear/']],
//                                 ['label' => 'President', 'url' => ['/master/president/']],
//                            ],
//                        ],
//                        
                    ],
                ]
        )
        ?>

    </section>

</aside>





