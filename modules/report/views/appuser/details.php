<?php

use kartik\tabs\TabsX;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'Details' . $model->first_name != null ? $model->username . '(' . $model->country_code . ' ' . $model->mobile_no . ')' : '-';
?>





<div class="map-wrapper">
    <?php
    $result = [];
    $request_arr = [];
    foreach ($offer as $offers) {
        if ($offers->master_category_id == 2) {
            $html = '';
        } else if ($offers->master_category_id == 7) {
            $html = '';
        } else {
            $html = '<ul>';
            foreach ($offers->activity_detail as $detail) {
                $html .= '<li>' . $detail->detail != null ? $detail->detail . ' (' . $detail->quantity . ')' . '<br>' : '' . "</li>";
//                                      
            }
            $html .= "</ul>";
        }
        $result[] = ['lat' => (float) $offers->lat, 'long' => (float) $offers->lng, 'address' => '<b> Category </b>[ ' . $offers->category->category_name . '] ,<b><br> Offer Note </b>[' . $offers->offer_note . '],<b> <br> Detail [</b>' . $html . ']<b> ,<br> DateTime </b>[' . date("d-m-Y h:m:s", strtotime($offers->datetime)) . ']<b>  ,<br> Request Mapped By Me </b>[ ' . $offers->mappingoffer . '] ,<b><br> Offer Recieved </b>[' . $offers->mappingrequest . ']]<br><b>UserName(Mobile no)</b>[ ' . $offers->app_user->first_name.' '.$offers->app_user->last_name.'('.$offers->app_user->country_code.' '.$offers->app_user->mobile_no.')' . ' ]<br><b>Address</b>[ ' . $offers->address . ' ] ,<b><br> '];
    }

    foreach ($request as $requests) {
        if ($requests->master_category_id == 2) {
            $html = '';
        } else if ($requests->master_category_id == 7) {
            $html = '';
            } else {
                $html = '<ul>';
                foreach ($requests->activity_detail as $detail) {
                $html .= '<li>' . $detail->detail != null ? $detail->detail . ' (' . $detail->quantity . ')' . '<br>' : '' . "</li>";
//                                      
            }
            $html .= "</ul>";
        }
        $request_arr[] = ['lat' => (float) $requests->lat, 'long' => (float) $requests->lng, 'address' => '<b>Category </b>[ ' . $requests->category->category_name . '] ,<br><b> Detail </b>[' . $html . '] ,<br><b> DateTime</b> [' . date("d-m-Y h:m:s", strtotime($requests->datetime)) . '] ,<br><b> Request Mapped By Me</b> [ ' . $requests->mappingoffer . '] ,<br><b> Offer Recieved</b> [' . $requests->mappingrequest . ']<br><b>UserName(Mobile no)</b>[ ' . $requests->app_user->first_name.' '.$requests->app_user->last_name.'('.$requests->app_user->country_code.' '.$requests->app_user->mobile_no.')' . ' ]<br><b>Address</b>[ ' . $requests->address . ' ] ,<b><br> '];
    }
    ?>

    <script>
        var results = <?= json_encode($result) ?>;
        var request = <?= json_encode($request_arr) ?>;

    </script>
    <div id="map"></div>

    <Button id="reset_state" class="btn btn-sm btn-default" value="reset" onclick="myFunction()"/><i class="fa fa-refresh" aria-hidden="true"></i>Reload</button>

<style>
    #map {
        height: 400px;  
        width: 100%;  
    }
    #reset_state {
        position: absolute;
        background: #fff;
        background: rgba(255, 255, 255, 0.8);
        left: 74%;
        top: 10px;

        padding: 10px;
        border: 1px solid;
    }

    .legend {
        position: absolute;
        background: #fff;
        background: rgba(255, 255, 255, 0.8);
        left: 20px;
        top: 10px;
        padding: 10px;
        border: 1px solid;
    }
    .legend h4 {
        margin: 0 0 10px;
        text-transform: uppercase;
        font-family: sans-serif;
        text-align: center;
    }
    .legend ul {
        list-style-type: none;
        margin: 0;
        padding: 0;

    }
    .legend li { padding-bottom: 5px; }
    .legend span {
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 6px;
    }
</style>
<script>
    var map;
    function mapLibReadyHandler() {
//                                            var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
//                                            var labelIndex = 0;

        var myLatLng = {lat: 21.243309, lng: 81.6367873};
        var bounds = new google.maps.LatLngBounds();

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            gestureHandling: 'greedy',
            center: myLatLng,
            mapTypeId: 'roadmap'
        });



        map.data.loadGeoJson('/world.geojson');

        for (i = 0; i < results.length; i++) {

            var position = new google.maps.LatLng(results[i].lat, results[i].long);
            bounds.extend(position);
            var marker = new google.maps.Marker({
                position: position,
                map: map,

                // label: labels[labelIndex++ % labels.length],

            });

            attachSecretMessage(marker, results[i].address);
            // map.fitBounds(bounds);
        }

        for (i = 0; i < request.length; i++) {

            var position = new google.maps.LatLng(request[i].lat, request[i].long);
            bounds.extend(position);
            var marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                }
                // label: labels[labelIndex++ % labels.length],

            });

//                                                marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png')
            attachSecretMessage(marker, request[i].address);
            // map.fitBounds(bounds);
        }
//                                          
    }
    function attachSecretMessage(marker, secretMessage) {
        var infowindow = new google.maps.InfoWindow({
            content: secretMessage
        });

        marker.addListener('mouseover', function () {

            infowindow.open(marker.get('map'), marker);

        });
        marker.addListener('mouseout', function () {
            infowindow.close();


        });
        marker.addListener('click', function () {

            marker.get('map').setZoom(15);
            marker.get('map').setCenter(marker.getPosition());
        });
    }

    function myFunction() {
        mapLibReadyHandler();
    }

</script>
                            <!--<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d17834829.428021498!2d76.782854505246!3d23.408592195240704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1586635500439!5m2!1sen!2sin" width="100%" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>-->
<script async defer
        src="https://maps.google.com/maps/api/js?v=3&callback=mapLibReadyHandler&key=AIzaSyCaNo-whQ0kNdV0HBdKPC3X6QcURe_RtR4">

</script>
</div>


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

            array_push($items, [
                'label' => "Notification ",
                'content' => $this->render('/appuser/notification', [
                    'notification' => $notification,
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