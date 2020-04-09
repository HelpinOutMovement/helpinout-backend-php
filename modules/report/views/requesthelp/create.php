<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RequestHelp */

$this->title = 'Create Request Help';
$this->params['breadcrumbs'][] = ['label' => 'Request Helps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-help-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
