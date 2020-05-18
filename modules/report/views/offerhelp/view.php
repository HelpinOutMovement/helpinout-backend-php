<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OfferHelp */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Offer Helps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="offer-help-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'app_user_id',
            'api_log_id',
            'offer_uuid',
            'master_category_id',
            'no_of_items',
            'location',
            'lat',
            'lng',
            'accuracy',
            'payment',
            'address',
            'offer_note',
            'datetime',
            'time_zone_offset',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
