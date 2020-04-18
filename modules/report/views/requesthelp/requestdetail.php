        
<?php

use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\GeneralModel;
use yii\bootstrap\Modal;
use app\components\CustomPagination;

//use yii\helpers\Html;
//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApiLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>




<?php
$geolocation = $model->lat . ',' . $model->lng;
$request = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $geolocation . '&sensor=false';
$file_contents = file_get_contents($request);
$json_decode = json_decode($file_contents);
if (isset($json_decode->results[0])) {
    $response = array();
    foreach ($json_decode->results[0]->address_components as $addressComponet) {
        if (in_array('political', $addressComponet->types)) {
            $response[] = $addressComponet->long_name;
        }
    }

    if (isset($response[0])) {
        $first = $response[0];
    } else {
        $first = 'null';
    }
    if (isset($response[1])) {
        $second = $response[1];
    } else {
        $second = 'null';
    }
    if (isset($response[2])) {
        $third = $response[2];
    } else {
        $third = 'null';
    }
    if (isset($response[3])) {
        $fourth = $response[3];
    } else {
        $fourth = 'null';
    }
    if (isset($response[4])) {
        $fifth = $response[4];
    } else {
        $fifth = 'null';
    }

    if ($first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth != 'null') {
        echo "<br/>Address:: " . $first;
        echo "<br/>City:: " . $second;
        echo "<br/>State:: " . $fourth;
        echo "<br/>Country:: " . $fifth;
    } else if ($first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth == 'null') {
        echo "<br/>Address:: " . $first;
        echo "<br/>City:: " . $second;
        echo "<br/>State:: " . $third;
        echo "<br/>Country:: " . $fourth;
    } else if ($first != 'null' && $second != 'null' && $third != 'null' && $fourth == 'null' && $fifth == 'null') {
        echo "<br/>City:: " . $first;
        echo "<br/>State:: " . $second;
        echo "<br/>Country:: " . $third;
    } else if ($first != 'null' && $second != 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null') {
        echo "<br/>State:: " . $first;
        echo "<br/>Country:: " . $second;
    } else if ($first != 'null' && $second == 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null') {
        echo "<br/>Country:: " . $first;
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <?php
        $result = [];
       
        foreach ($offer as $offers) {
            $result[] = ['lat' => (float) $offers->offerdetail->lat, 'lng' => (float) $offers->offerdetail->lng, 'text' => $offers->offerdetail->address];
           
        }
           // print_r(json_encode($cluster));
        ?>

        <script>
            var results = <?= json_encode($result) ?>;
          
            
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
                left: 20px;
                top: 10px;

                padding: 10px;
                border: 1px solid;
            }
        </style>

        <script>

            var map;
            function mapLibReadyHandler()
            {

                var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
               
                var myLatLng = {lat: 21.243309, lng: 81.6367873};
                var bounds = new google.maps.LatLngBounds();
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 4,
                    gestureHandling: 'greedy',
                    center: myLatLng,
                    mapTypeId: 'roadmap'
                });
                map.data.loadGeoJson('/india.geojson');
               
                var markers = results.map(function (location, i) {
                    
                    var positions = new google.maps.LatLng(location.lat, location.lng);
                    bounds.extend(positions);
                    return marker = new google.maps.Marker({
                        position: positions,
                        map: map,
                        label: labels[i % labels.length]
                    });
                     
                     
                });
                
                var markerCluster = new MarkerClusterer(map, markers,
                        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
       
//                 for (i = 0; i < results.length; i++) {
//
//                    var positions = new google.maps.LatLng(results[i].lat, results[i].lng);
//                    bounds.extend(positions);
//                    var marker = new google.maps.Marker({
//                        position: positions,
//                        map: map,
//                        'id': results[i].text,
////                        label: labels[labelIndex++ % labels.length],
//                    });
//                    attachSecretMessage(marker, results[i].text);
//                    //  map.fitBounds(bounds);
//                }

            }
//            function attachSecretMessage(marker, secretMessage) {
//                var infowindow = new google.maps.InfoWindow({
//                    content: secretMessage
//                });
//
//                marker.addListener('mouseover', function () {
//
//                    infowindow.open(marker.get('map'), marker);
//
//                });
//                marker.addListener('mouseout', function () {
//                    infowindow.close();
//
//
//                });
//                marker.addListener('click', function () {
//
//                    marker.get('map').setZoom(15);
//                    marker.get('map').setCenter(marker.getPosition());
//                });
//            }
//
            function myFunction() {
                mapLibReadyHandler();
            }

        </script>
        <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js">
    </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?callback=mapLibReadyHandler&key=AIzaSyCaNo-whQ0kNdV0HBdKPC3X6QcURe_RtR4&amp"></script>

    </div>
</div>  <br/>     
<div class="row">
    <div class="col-md-12">

        <div class="box card-2" style="border-radius:10px;">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-6">

                    </div>

                </div><br/>
                <div class="row">
                    <div class="col-md-10">
                        <div class="text-left"><?php //echo $this->render('_search', ['model' => $searchModel]);                       ?></div>
                    </div>

                </div>
            </div>
            <div class="box-body">
                <div class="text-center"><?= $model->app_user_id != null ? $model->app_user->first_name . ' ' . $model->app_user->last_name . '(' . $model->app_user->country_code . $model->app_user->mobile_no . ')' : '' ?></div>



                <div class="col-md-12">
                    <div class="text">


                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>User Name</th>
                                        <th>Master category</th>
                                        <th>Address</th>

                                        <th>Map</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sn = 1;

                                    foreach ($offer as $offers) {
                                        ?>
                                        <tr>
                                            <td><?= $sn ?></td>
                                            <td><?= $offers->offer_help_id != NULL ? $offers->offerdetail->app_user->first_name . ' ' . $offers->offerdetail->app_user->last_name : '' ?></td>
                                            <td><?= $offers->offer_help_id != null ? $offers->offerdetail->category->category_name : '' ?></td>
                                            <td><?= $offers->offer_help_id != null ? $offers->offerdetail->address : '' ?></td>
                                            <td><iframe width="100%" height="300" src="https://maps.google.com/maps?q=<?= $offers->offerdetail->lat ?>,<?= $offers->offerdetail->lng ?>&output=embed"></iframe></td>
                                        </tr>

                                        <?php
                                        $sn++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<style>
    /*    .active{
            color:rgb(0, 255, 0);
        }
        .inactive{
            color:rgb(0, 255, 0);
        }*/
    .btn-primary
    {
        color:#fff;
    }
    .btn-danger
    {
        color:#fff;
    }
    .underlinelink
    {
        color:#000;
    }



    /* Tooltip container */
    .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
    }

    /* Tooltip text */
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;

        /* Position the tooltip text - see examples below! */
        position: absolute;
        z-index: 1;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    .tooltip:hover .tooltiptext {
        visibility: visible;
    }
</style>
