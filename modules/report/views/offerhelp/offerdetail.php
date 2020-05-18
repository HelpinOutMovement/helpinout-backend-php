        
<?php

use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\GeneralModel;
use yii\bootstrap\Modal;
use app\components\CustomPagination;
use kartik\tabs\TabsX;
use yii\widgets\ActiveForm;

//use yii\helpers\Html;
//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApiLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>



<div class="row">
    <div class="col-lg-12 col-md-6 col-sm-12 pr-0 pl-0 md-pad-left  sm-pad-right">
        <div class="map-wrapper">
            <?php
            $result = [];
            $request_arr = [];
            foreach ($requestmapbyme as $offers) {
                if ($offers->requestdetail->master_category_id == 2) {
                    $html = '';
                } else if ($offers->requestdetail->master_category_id == 7) {
                    $html = '';
                } else {
                    $html = '<ul>';
                    foreach ($offers->requestdetail->activity_detail as $detail) {
                        $html .= '<li>' . $detail->detail != null ? $detail->detail . ' (' . $detail->quantity . ')' . '<br>' : '' . "</li>";
//                                      
                    }
                    $html .= "</ul>";
                }
                if ($offers->requestdetail->master_category_id == 0) {
                    $category = "Others";
                } elseif ($offers->requestdetail->master_category_id == 9) {
                    $category = 'Others';
                } else {
                    $category = $offers->requestdetail->master_category_id != null ? $offers->requestdetail->category->category_name : '';
                }
                $result[] = ['lat' => (float) $offers->requestdetail->lat, 'long' => (float) $offers->requestdetail->lng, 'address' => '<b>Category </b>[ ' . $category. ' ], <br><b>Detail</b>[ ' . $html . '] ,<br><b>Date Time</b> [ ' . $offers->requestdetail->datetime . '] ,<br><b> Offer Mapped By Me </b>[ ' . $offers->requestdetail->mappingoffer . '] ,<br><b> Offer Recieved </b>[ ' . $offers->requestdetail->mappingrequest . ']<br><b>Username (Mobile No)</b> [' . $offers->requestdetail->app_user->first_name.' '.$offers->requestdetail->app_user->last_name.'('.$offers->requestdetail->app_user->country_code.' '.$offers->requestdetail->app_user->mobile_no. ')] , <br><b>Address</b> [' . $offers->requestdetail->address . '] , <br><b>Distance</b>[ '.$offers->distance.'KM ]'];
            }


//    echo $html;

            foreach ($offerrecieved as $requests) {
                if ($requests->requestdetail->master_category_id == 2) {
                    $html = '';
                } else if ($requests->requestdetail->master_category_id == 7) {
                    $html = '';
                } else {
                    $html = '<ul>';
                    foreach ($requests->requestdetail->activity_detail as $detail) {
                        $html .= '<li>' . $detail->detail != null ? $detail->detail . ' (' . $detail->quantity . ')' . '<br>' : '' . "</li>";
//                                      
                    }
                    $html .= "</ul>";
                }

                if ($requests->requestdetail->master_category_id == 0) {
                    $category = "Others";
                } elseif ($requests->requestdetail->master_category_id == 9) {
                    $category = 'Others';
                } else {
                    $category = $requests->requestdetail->master_category_id != null ? $requests->requestdetail->category->category_name : '';
                }
                $request_arr[] = ['lat' => (float) $requests->requestdetail->lat, 'long' => (float) $requests->requestdetail->lng, 'address' => '<b>Category</b> [ ' . $category . '] ,<br><b> Detail </b>[ ' . $html . '] ,<br><b> Date Time</b> [ ' . $requests->requestdetail->datetime . ' ], <br><b>Offer Mapped By Me</b> [ ' . $requests->requestdetail->mappingoffer . '] , <br><b>Offer Recieved </b>[ ' . $requests->requestdetail->mappingrequest . ']<br><b>Username (Mobile No)</b> [' . $requests->requestdetail->app_user->first_name.' '.$requests->requestdetail->app_user->last_name.'('.$requests->requestdetail->app_user->country_code.' '.$requests->requestdetail->app_user->mobile_no. ')] , <br><b>Address</b> [' . $requests->requestdetail->address . '] , <br><b>Distance</b> ['.$requests->distance.'KM ]'];
            }
            ?>

            <script>
                var results = <?= json_encode($result) ?>;
                var request = <?= json_encode($request_arr) ?>;

            </script>
            <div id="map"></div>
            <div class="legend">

                <ul>
                    <li><span style="background-color:#FA5C43"></span>Offer Request By Me</li>
                    <li><span style="background-color:blue"></span>Offer Received</li>

                </ul>
            </div>
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
    </div>
</div>


<div class='detail-page'>
    <div class='box bordered-box '>
        <div class='box-header '>
            <div class='title'>
                <i class='icon-plus-sign'></i>
                <h2 class="text-center">
                    <div class="text-center"><h2><?= $model->app_user_id != null ? $model->app_user->first_name . ' ' . $model->app_user->last_name . '(' . $model->app_user->country_code . $model->app_user->mobile_no . ')' : '' ?></h2></div>

                </h2>
            </div>

        </div>

        <div class='box-content'>

            <?php
            $items = [];
            $i = 0;
            $error = -1;


//echo $error; exit;            
            $i = 0;
//            foreach ($offer as $detail) {

            array_push($items, [
                'label' => ' Request Mapped By Me',
                'content' => $this->render('/offerhelp/request_map_by_me', [
                    'requestmapbyme' => $requestmapbyme,
                    //'form' => $form,
                    'i' => $i,
                ]),
                'active' => ($i == $error || ($error == -1 && $i == 0)) ? true : false,
            ]);
            $i++;
//            }
            array_push($items, [
                'label' => "Offer Recieved",
                'content' => $this->render('/offerhelp/offer_recieved', [
                    'offerrecieved' => $offerrecieved,
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

