<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model app\models\AppUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'App Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="app-user-view">

    <h1><?php echo $model->first_name != null ? $model->username:'-'; ?></h1>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                                'attribute' => 'User Name',
                             
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
//                                    return $model->first_name != null ? $model->user : '-';
                                    return Html::a($model->first_name != null ? $model->username : '-', ['/report/appuser/detail?id=' . $model->id], ['data-pjax' => "0", 'class' => 'underlinelink']);
                                }
                            ],
                            [
                                'attribute' => 'Country Code',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
                                    return $model->country_code != null ? $model->country_code : '-';
                                }
                            ],
                            [
                                'attribute' => 'Mobile No.',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
                                $url = Url::to(["/report/apilog/index?" . "mobile_no=$model->mobile_no"]);

                                            return Html::a($model->mobile_no, $url, ['data-pjax' => "0"]);
                                    
                                }
                            ],
                            [
                                'attribute' => 'Mobile Visibility',
                                'enableSorting' => false,
                                'format' => 'raw',
//                              
                                'value' => function($model) {
                                    if ($model->mobile_no_visibility == '1') {
                                        return "Visible";
                                    } else {
                                        return "Invisible";
                                    }
                                }
                            ],
                            [
                                'attribute' => 'User Type',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->user_type == 1) {
                                        return "Individual";
                                    } else {
                                        return "Organization";
                                    }
                                }
                            ],
                            [
                                'attribute' => 'org_name',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->org_name != null ? $model->org_name : '-';
                                }
                            ],
                            [
                                'attribute' => 'org_division',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->org_division != null ? $model->org_division : '-';
                                }
                            ],
                            [
                                'attribute' => 'master_app_user_org_type',
                                'enableSorting' => false,
                                'format' => 'raw',
//                                'header' => 'App Version',
                                'value' => function($model) {
                                    return $model->master_app_user_org_type != null ? $model->appuserorgtype->org_type : '-';
                                }
                            ],
                            [
                                'attribute' => 'time_zone',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'time_zone_offset',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'status',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function($model) {
                                    if ($model->status == '1') {
                                        return "Active";
                                    } else {
                                        return "Inactive";
                                    }
                                }
                            ],
        ],
    ]) ?>

</div>
