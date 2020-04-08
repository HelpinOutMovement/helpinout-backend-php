<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $ucontent string */

dmstr\web\AdminLteAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
//AdminLtePluginAsset::register($this);
if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
} else {
    app\assets\AppAsset::register($this);
}
//$this->registerJsFile('@vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js' ,['position' => \yii\web\View::POS_HEAD]);
$skin = 'skin-black-light';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Yii::$app->name ?> :: - <?= Html::encode($this->title) ?></title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <?php $this->head() ?>
    </head>
    <body class="hold-transition <?= $skin ?> sidebar-mini sidebar-collapse">
        <?php //include_once("googleanalyticstracking.php")  ?>
        <?php $this->beginBody() ?>
        <div class="wrapper">

            <?=
            $this->render(
                    'header.php', ['directoryAsset' => $directoryAsset]
            )
            ?>

            <?=
            $this->render(
                    'left.php', ['directoryAsset' => $directoryAsset]
            )
            ?>

            <?=
            $this->render(
                    'content.php', ['content' => $content, 'directoryAsset' => $directoryAsset]
            )
            ?>
        </div>

        <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>
<style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 4px;
        line-height: 1;
        vertical-align: top;
        border-top: 1px solid #ddd;
    } 
</style>