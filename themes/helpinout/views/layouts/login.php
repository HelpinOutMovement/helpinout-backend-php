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
        <title>HelpInOut</title>
<?php $this->head() ?>
    </head>

<?php $this->beginBody() ?>

    <header class="main-header">
        <!-- Logo -->

        <!-- Header Navbar: style can be found in header.less -->
        
    </header>
    <section class="login-Main">
              <div class="login-box login-form">
                        <h2 class="login-title">
                            Login to your Account 
                        </h2>
                        <div class="login-box-body">
<?= $content ?>



                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        
                    </div>
              






    </section>




<?php $this->endBody() ?>  



</html>
<?php $this->endPage() ?>
