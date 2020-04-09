<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AppUser */

$this->title = 'Create App User';
$this->params['breadcrumbs'][] = ['label' => 'App Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
