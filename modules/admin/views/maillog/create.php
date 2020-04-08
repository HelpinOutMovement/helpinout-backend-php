<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MailLog */

$this->title = 'Create Mail Log';
$this->params['breadcrumbs'][] = ['label' => 'Mail Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
