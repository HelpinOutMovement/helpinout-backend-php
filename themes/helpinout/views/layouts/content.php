<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use dmstr\widgets\Alert;
use kartik\widgets\AlertBlock;

$url = explode('/', Url::to());
$dasboard_url = '/';
?>
<style>
.contents {display:none;}
.preload { width:100px;
    height: 100px;
    position: fixed;
    top: 35%;
    left: 47%;}
</style>

<div class="content-wrapper">
    <section class="content-header">
        <?php //if (isset($this->blocks['content-header'])) { ?>
<!--            <h1><?php // echo $this->blocks['content-header']; ?></h1>-->
        <?php //} else { ?>
<!--            <h1>-->
                <?php
//                if ($this->title !== null) {
//                    echo "<ol class='breadcrumb'>".\yii\helpers\Html::encode($this->title)."</ol>";
//                } else {
//                    echo \yii\helpers\Inflector::camel2words(
//                            \yii\helpers\Inflector::id2camel($this->context->module->id)
//                    );
//                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
//                }
                ?>
<!--            </h1>-->
        <?php // } ?>
        <?php 
 //       echo
//        Breadcrumbs::widget([
//            'homeLink' => [
//                'label' => Yii::t('yii', 'Dashboard'),
//                'url' => $dasboard_url,
//            ],
//            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//        ]);
        ?>
    </section>
    <section class="content">
        <?php
        echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_ALERT,
            'delay' => 0,
        ]);
        ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        Designed and Developed by <a href="http://trilineinfotech.com/" target="_blank">Triline Infotech Pvt. Ltd</a>
    </div>
    <strong>Copyright &copy; <?= date('Y') - 1 ?>-<?= date('Y') ?> <?= Yii::$app->name ?> </strong> All rights reserved.

</footer>


<div class="preload"><img src="/images/loading2.gif" width="150px" height="150px"></div>
    <div class='control-sidebar-bg'></div>




    <?php
    $js = <<<JS
     
$(".preload").fadeOut(1500, function() {
        $(".content").fadeIn(700);        
    });    
       
       $(document).ready(function(){
          $('.hidden-xs').html('');
        })    
JS;
    $this->registerJs($js);
    ?>
