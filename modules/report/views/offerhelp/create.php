<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OfferHelp */

$this->title = 'Create Offer Help';
$this->params['breadcrumbs'][] = ['label' => 'Offer Helps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offer-help-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
