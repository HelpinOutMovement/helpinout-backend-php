<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogEmailOfferMappingRequest */

$this->title = 'Create Log Email Offer Mapping Request';
$this->params['breadcrumbs'][] = ['label' => 'Log Email Offer Mapping Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-email-offer-mapping-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
