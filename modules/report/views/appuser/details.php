<?php

use kartik\tabs\TabsX;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'Details' . $model->first_name != null ? $model->username  .'('.$model->country_code.' '.$model->mobile_no.')': '-';

?>
<?php
$js = <<<JS
      

$(function () {
   
        
     $('.qsrejectmodel').click(function(){
        $('#itimodel').modal('show')
         .find('#iticontent')
         .load($(this).attr('value'));
     });    
});   
    
        $(function () {
   
        
     $('.appdetailmodel').click(function(){
        $('#itimodels').modal('show')
         .find('#iticontents')
         .load($(this).attr('value'));
     });    
});   
 
        
JS;
$this->registerJs($js);
?>
<div class='detail-page'>
    <div class='box bordered-box '>
        <div class='box-header '>
            <div class='title'>
                <i class='icon-plus-sign'></i>
                <h2 class="text-center">
                <?= $this->title ?>
                </h2>
            </div>
            
        </div>
        <div class='box-content'>
            <div class='col-md-2 pull-right'>
            <?php echo Html::button(Yii::t('user', '<span class="fa fa-user"></span> Profile'), ['value' => Url::to('/report/appuser/profile?id=' . $model->id), 'class' => 'btn btn-xs btn-info btn-block qsrejectmodel']); ?>
             </div>
            <div class='col-md-2 pull-right'>
            <?php echo Html::button(Yii::t('user', '<span class="fa fa-history"></span> App Detail'), ['value' => Url::to('/report/appuser/appdetails?id=' . $model->id), 'class' => 'btn btn-xs btn-warning btn-block appdetailmodel']); ?>
            </div>
            <?php

            $items = [];
            $i = 0;
            $error = -1;
            
           
            //echo $error; exit;            
            $i = 0;
//            foreach ($offer as $detail) {

                array_push($items, [
                'label' => 'Offer Help',
                'content' => $this->render('/appuser/offerhelp', [
                    'offer' => $offer,
                    //'form' => $form,
                    'i' => $i,
                    ]),
                'active' => ($i == $error || ($error == -1 && $i == 0)) ? true : false,
                ]);
                $i++;
//            }
            array_push($items, [
                'label' => "Request Help",
                'content' => $this->render('/appuser/requesthelp', [
                    'request' => $request,
                    //'form' => $form,
                ]),
                'active' => ($i == $error) ? true : false,
            ]);
            echo TabsX::widget([
                'items' => $items,
                'position' => TabsX::POS_ABOVE,
                'encodeLabels' => false
            ]);
            ?>
          
           
        </div>            
    </div> 
</div> 

<?php
Modal::begin([
    
    'id' => 'itimodel',
    'size' => 'modal-md'
]);
echo "<div id='iticontent'></div>";
Modal::end();
?>

<?php
Modal::begin([
    
    'id' => 'itimodels',
    'size' => 'modal-lg'
]);
echo "<div id='iticontents'></div>";
Modal::end();
?>