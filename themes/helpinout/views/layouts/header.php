<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use dektrium\user\models\User;
?>



<header class="main-header">
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <a class="brand left-logo" href="#" style="margin-top:-18px;">
          <!--<h3 class="logo"><img src="/images/main_logo.png" alt="Logo"   width="140px" height="30px"> </h3>-->
            <h3 class="logo">HelpInOut </h3>

        </a>
        <a href="#" class="sidebar-toggle dashboard" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <?php if (!Yii::$app->user->isGuest) { ?>
                <ul class="nav navbar-nav">
                   
                 
                    
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="fa fa-user" alt="User Image"></i>
                            <span><?= Yii::$app->user->identity->username ?></span><span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <div class="pull-right">
                                    <?=
                                    Html::a(
                                            'Sign out', ['/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                    )
                                    ?>
                                </div>
                            </li>
                        </ul>
                    </li>


                </ul>
            <?php } ?>
        </div>
    </nav>
</header>                                    

