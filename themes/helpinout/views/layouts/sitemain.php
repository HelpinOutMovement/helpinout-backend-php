<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\UserModel;
use kartik\widgets\AlertBlock;

app\assets\MainAppAsset::register($this);

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

    <body>
        <!-- Logo -->

        <!-- Header Navbar: style can be found in header.less -->


        <?= $content ?>




    </body>
    <?php $this->endBody() ?>  



</html>
<?php $this->endPage() ?>
