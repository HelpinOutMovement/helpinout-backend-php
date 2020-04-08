<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\UserModel;
use kartik\widgets\AlertBlock;
dmstr\web\AdminLteAsset::register($this);

app\assets\LoginAppAsset::register($this);

$arg = explode('/', Yii::$app->request->url);
$module_title = "";
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?= Html::csrfMetaTags() ?>
        <title>ITI</title>
        <?php $this->head() ?>
    </head>
  
       <?php $this->beginBody() ?>
    
 <header class="main-header">
    <!-- Logo -->

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top login-header">
      <div class="col-md-4 col-sm-6 col-xs-12">
        <!-- Sidebar toggle button-->
        <div class="brand">
          <a href="#"><img src="/images/logo-left.png" class="img-responsive" title="IMACS" alt="IMACS"></a>
        </div>
         </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <p class="iti-grading">Grading of ITI'S</p>
          </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
               
                <li>
                  <img src="/images/dgt-logo.png" class="img-responsive logo-right shiksha-logos" title="IMACS" alt="IMACS">
                </li>
                <li>
                  <img src="/images/skill-logo.png" class="img-responsive logo-right" title="IMACS" alt="IMACS">
                </li>
              </ul>
        </div>
      </div>
        </nav>
  </header>
  <section class="login-Main">
      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="2000" data-pause="false">
      <div class="carousel-inner">
        <div class="item active">
            <div class="slider-forgot">
          <img src="/images/login-slider1_1.jpg" class="img-responsive" alt="IMACS">
        </div>
        </div>
            <div class="item">
             <div class="slider-forgot">
          <img src="/images/login-slider2.jpg" class="img-responsive" alt="IMACS">
        </div>
        </div>
            <div class="item">
              <div class="slider-forgot">
          <img src="/images/login-slider3.jpg" class="img-responsive" alt="IMACS">
        </div>
        </div>

        <div class="carousel-form">
          <div class="login-box login-form">
              <h2 class="login-title">
                   Password Recovery
                </h2>
           <div class="login-box-body">
                <?= $content ?>
       
       
                
            </div>
          </div>
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="commentbox">
              <h4>About ITI Grading</h4>
              <p>In order to ensure the quality checks of these institutes, Directorate General of Training (DGT) under
                Ministry of Skill Development and Entrepreneurship (MSDE) – has decided to grade the ITIs on the basis
                of some key parameters. The grading shall provide a “benchmark for comparison” amongst the institutes. </p>
                </div>
          </div>
          </div>
      </div>
        </div>
      
      
      
      
      
    
          </section>

    
    
  
 <?php $this->endBody() ?>  
    
   

</html>
<?php $this->endPage() ?>
