<div id="covid-19-help" class="covid-19-help-body-content">


    <div class="body-wrap">
        <div class="container-fluid">
            <div class="row pt-22">


                <div class="col-lg-12 col-md-12">
                    <div class="mid-wrapper">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 pr-0 pl-0 md-pad-left xsm-pad-right">
                                <div class="req-box">
                                    <div class="req text-left">
                                        <h4 class="fw-600">Total Requests<br> for Help</h4>
                                        <p class="fs-24 fw-600 resp-para main-txt-color mid-para mid-para-bg-pad"><?= $data['request_all']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 pr-0 sm-pad-right">
                                <div class="req-box">
                                    <div class="req text-left">
                                        <h4 class="fw-600">Requests for Help<br> recieved today</h4>
                                        <p class="fs-24 fw-600 resp-para main-txt-color mid-para"><?= $data['request_today'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 pr-0 xsm-pad-right">
                                <div class="req-box">
                                    <div class="req text-right">
                                        <h4 class="fw-600">Help Offers<br> recieved today</h4>
                                        <p class="fs-24 fw-600 resp-para mid-para dark-color"><?= $data['offer_today']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 pr-0 md-pad-right">
                                <div class="req-box">
                                    <div class="req text-right">
                                        <h4 class=" fw-600">Total Help Offers<br> recieved</h4>
                                        <p class="fs-24 fw-600 resp-para mid-para mid-para-bg-pad-1"><?= $data['offer_all']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div><br/>

                        <div class="row mt-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 pr-0 pl-0 md-pad-left  sm-pad-right">
                                <div class="map-wrapper">
                                    <?php
                                    $result = [];
                                    $request_arr = [];


                                    foreach ($offer as $offers) {

                                        if ($offers->master_category_id == 0) {
                                            $category = "Others";
                                        } elseif ($offers->master_category_id == 9) {
                                            $category = 'Others';
                                        } else {
                                            $category = $offers->master_category_id != null ? $offers->category->category_name : '';
                                        }

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
                                        $result[] = ['lat' => (float) $offers->lat, 'long' => (float) $offers->lng, 'address' => '<b>Category</b> [ ' . $category . ']  ,<br><b> DateTime</b> [' . date("d-m-Y h:m:s", strtotime($offers->datetime)) . '] , <br> <b>Request Mapped By Me </b>[ ' . $offers->mappingoffer . '] ,<br> <b>Offer Recieved </b>[' . $offers->mappingrequest . '],<br> <b>Username (Mobile No)</b>[ ' . $offers->app_user->first_name.' '.$offers->app_user->last_name.' ('.$offers->app_user->country_code.' '.$offers->app_user->mobile_no. ') ],<br><b> Address</b>[ ' . $offers->address . ' ]'];
                                    }
                                    foreach ($request as $requests) {
                                        if ($requests->master_category_id == 0) {
                                            $category = "Others";
                                        } elseif ($requests->master_category_id == 9) {
                                            $category = 'Others';
                                        } else {
                                            $category = $requests->master_category_id != null ? $requests->category->category_name : '';
                                        }
                                        $request_arr[] = ['lat' => (float) $requests->lat, 'long' => (float) $requests->lng, 'address' => '<b>Category</b> [ ' . $category . ']  ,<br><b> DateTime</b> [' . date("d-m-Y h:m:s", strtotime($requests->datetime)) . '] , <br> <b>Request Mapped By Me </b>[ ' . $requests->mappingoffer . '] ,<br> <b>Offer Recieved </b>[' . $requests->mappingrequest . '],<br> <b>Username (Mobile No)</b>[ ' . $requests->app_user->first_name.' '.$requests->app_user->last_name.' ('.$requests->app_user->country_code.' '.$requests->app_user->mobile_no. ') ],<br><b> Address</b>[ ' . $requests->address . ' ]'];
                                    }
                                    ?>

                                    <script>
                                        var results = <?= json_encode($result) ?>;
                                        var request = <?= json_encode($request_arr) ?>;

                                    </script>
                                    <div id="map"></div>
                                    <div class="legend">

                                        <ul>
                                            <li><span style="background-color:#FA5C43"></span>Offers</li>
                                            <li><span style="background-color:blue"></span>Request</li>

                                        </ul>
                                    </div>
                                    <Button id="reset_state" class="btn btn-sm btn-default" value="reset" onclick="myFunction()"/><i class="fa fa-refresh" aria-hidden="true"></i>Reload</button>

                                    <style>

                                        #map {
                                            height: 590px;  
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

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 pr-0 xsm-pad-right">
                                        <div class="req text-center">
                                            <img src="/images/Shelter.svg" class="mx-auto img-fluid help-svg" alt="shelter"/>
                                            <div class="d-flex justify-content-between">
                                                <p class="fw-600 resp-para main-txt-color mid-para"><?= $data['req_shelter']; ?></p>
                                                <p class="fw-600 resp-para mid-para"><?= $data['shelter']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 pr-0 md-pad-right">
                                        <div class="req text-center">
                                            <img src="/images/Other.svg" class="mx-auto img-fluid help-svg" alt="shelter"/>
                                            <div class="d-flex justify-content-between">
                                                <p class="fw-600 resp-para main-txt-color mid-para"><?= $data['req_other']; ?></p>
                                                <p class="fw-600 resp-para mid-para"><?= $data['other']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 pr-0 xsm-pad-right">
                                        <div class="req text-center mt-24 xsm-mar-top">
                                            <img src="/images/Testing.svg" class="mx-auto img-fluid help-svg" alt="shelter"/>
                                            <div class="d-flex justify-content-between">
                                                <p class="fw-600 resp-para main-txt-color mid-para"><?= $data['req_testing']; ?></p>
                                                <p class="fw-600 resp-para mid-para"><?= $data['testing']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 pr-0 md-pad-right">
                                        <div class="req text-center mt-24 xsm-mar-top">
                                            <img src="/images/PPE.svg" class="mx-auto img-fluid help-svg" alt="shelter"/>
                                            <div class="d-flex justify-content-between">
                                                <p class="fw-600 resp-para main-txt-color mid-para"><?= $data['req_ppe']; ?></p>
                                                <p class="fw-600 resp-para mid-para"><?= $data['ppe']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 pr-0 xsm-pad-right">
                                        <div class="req text-center mt-24 xsm-mar-top">
                                            <img src="/images/Medicine.svg" class="mx-auto img-fluid help-svg" alt="shelter"/>
                                            <div class="d-flex justify-content-between">
                                                <p class="fw-600 resp-para main-txt-color mid-para"><?= $data['req_medicines']; ?></p>
                                                <p class="fw-600 resp-para mid-para"><?= $data['medicines']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 pr-0 md-pad-right">
                                        <div class="req text-center mt-24 xsm-mar-top">
                                            <img src="/images/People.svg" class="mx-auto img-fluid help-svg" alt="shelter"/>
                                            <div class="d-flex justify-content-between">
                                                <p class="fw-600 resp-para main-txt-color mid-para"><?= $data['req_people']; ?></p>
                                                <p class="fw-600 resp-para mid-para"><?= $data['people']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 pr-0 xsm-pad-right">
                                        <div class="req text-center mt-24 xsm-mar-top mb-4">
                                            <img src="/images/MedEquip.svg" class="mx-auto img-fluid help-svg" alt="shelter"/>
                                            <div class="d-flex justify-content-between">
                                                <p class="fw-600 resp-para main-txt-color mid-para"><?= $data['req_equip']; ?></p>
                                                <p class="fw-600 resp-para mid-para"><?= $data['equip']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 pr-0 md-pad-right">
                                        <div class="req text-center mt-24 xsm-mar-top mb-4">
                                            <img src="/images/Food.svg" class="mx-auto img-fluid help-svg" alt="shelter"/>
                                            <div class="d-flex justify-content-between">
                                                <p class="fw-600 resp-para main-txt-color mid-para"><?= $data['req_food']; ?></p>
                                                <p class="fw-600 resp-para mid-para"><?= $data['food']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>
</div>
<style>
    .d-flex .main-txt-color {

        padding-right: 40px;
    }  

    .navbar-brand {

        padding: 1px 1px; 
        font-size: 18px;
    }

</style>    