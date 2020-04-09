<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AppUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'App Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="app-user-view">

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
            'time_zone',
            'time_zone_offset',
            'country_code',
            'mobile_no',
            'mobile_no_visibility',
            'first_name',
            'last_name',
            'user_type',
            'org_name',
            'master_app_user_org_type',
            'org_division',
            'status',
        ],
    ]) ?>

</div>
