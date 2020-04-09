<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OfferHelp */

$this->title = 'Update Offer Help: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Offer Helps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="offer-help-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
