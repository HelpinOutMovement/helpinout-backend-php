<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MailLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mail Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mail-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'from_email_id:email',
            'to_email_id:email',
            'to_user_id',
            'subject',
            'template',
            'model:ntext',
            'model_id',
            'master_mail_type_id',
            'am_messageid',
            'am_requestid',
            'mail_send_time',
            'try_send_count',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'status',
        ],
    ])
    ?>

</div>
