<div id="covid-19-help" class="covid-19-help-body-content">
    <div class="nav-wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="nav-wrapper">
                        <div class="nav-head">
                            <h3 class="d-inline mr-4 fw-600">A people’s initiative to help each other</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="nav-wrapper">
                        <div class="nav-logo">
                            <a class="navbar-brand pull-right" style="margin-top:-5px;"href="index.html" target="_blank">
                                <img src="/images/HelpinOutLogo-80x80.png" class="mx-auto img-fluid" alt="helpinout">
                            </a>
                            <a class="navbar-brand pull-right" style="margin-top:20px;" href="index.html" target="_blank">
                                <h1><span class="main-txt-color">Helpin</span>Out</h1>
                            </a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="body-wrap">
        <div class="container-fluid">
            <div class="row pt-22">
                <div class="col-lg-2">
                    <div class="left-wrapper mobile-non-resp-app-down">
                        <h2 class="text-center fw-600">App<br> Download</h2>
                        <a href="#"><img src="/images/GoogleApp.png" class="mx-auto img-fluid mb-3" alt="g-play" /></a>
                        <a href="#"><img src="/images/AppleApp.png" class="mx-auto img-fluid mb-4" alt="a-store" /></a>
                        <h4 class="pl-3">App Languages</h4>
                        <ul class="text-left pl-3">
                            <li><a>English</a></li>
                            <li><a>हिंदी</a></li>
                            <li><a>ಕನ್ನಡ</a></li>
                            <li><a>French</a></li>
                            <li><a>Spanish</a></li>
                            <li><a>Marathi</a></li>
                            <li><a>Gujarati</a></li>
                            <li><a>Bhasa Indo</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12">
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
                                            height: 600px;  
                                            width: 100%;  
                                        }
                                        #reset_state {
                                            position: absolute;
                                            background: #fff;
                                            background: rgba(255, 255, 255, 0.8);
                                            left: 60%;
                                            top: 10px;

                                            padding: 10px;
                                            border: 1px solid;
                                        }

                                        .legend {
                                            position: absolute;
                                            background: #fff;
                                            background: rgba(255, 255, 255, 0.8);
                                            left: 20px;
                                            top: 490px;
                                            padding: 5px;
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
                                                    // label: labels[labelIndex++ % labels.length],

                                                });

                                                marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png')
                                                attachSecretMessage(marker, request[i].address);
                                               // map.fitBounds(bounds);
                                            }
                                            
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

<!--<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d17834829.428021498!2d76.782854505246!3d23.408592195240704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1586635500439!5m2!1sen!2sin" width="100%" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>-->
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

                <div class="col-lg-3 col-md-12">
                    <div class="right-wrapper text-right">
                        <span class="red-circle">
                            <span class="box-arrow"></span>
                            <ul class="name-list">
                                <li class="fs-18 fw-600 mb-3">Contributors</li>
                                <li>Vikas Chaudhary</li>
                                <li>Vineet Chikarmane
                                <li>
                                <li>Indra Verman</li>
                                <li>Ashok Hegde</li>
                                <li>Karthik Sashidhar</li>
                                <li>Avneesh Gupta</li>
                                <li>Sanjiv Sharma</li>
                                <li>Mitesh Thakkar</li>
                                <li>Vandana Viswanathan</li>
                                <li>Arun Ramanujanpuram</li>
                                <li>V.S.R. V Raghavan</li>
                                <li>Inna Bochkova</li>
                                <li>Bharati Mishra</li>
                                <li>Sandeep Bamane</li>
                                <li>Gora Mohanty</li>
                                <li>Inika Chikarmane</li>
                            </ul>
                        </span>
                        <h4 class="text-right fw-600">Initiated & Sustained by:</h4>
                        <p>Fiends, acquaintances & strangers coming together…</p>
                        <div class="md-btn mt-30">
                            <a href="#" class="btn btn-cust">Want to help?</a>    
                        </div>
                        <div>
                            <a href="#" class="btn btn-cust">help with...</a>
                        </div>    
                        <p class="right-md-para">Translations (download)</p>
                        <p class="right-md-para">Data analytics</p>
                        <p class="right-md-para">Community-level support</p>
                        <p class="right-md-para">Awareness</p>
                        <p class="right-md-para">Media outreach</p>
                        <p class="mt-30">Write to us:</p>
                        <div class="textarea-wrap">
                            <textarea rows="4" cols="40" class="mt-4">
                            </textarea>
                        </div>
                        <a href="#" class="btn btn-cust-1">Submit</a>
                        <p class="mt-30">
                            (we will try to respond as quickly as we can. Please bear with us.) 
                        </p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="left-wrapper mobile-resp-app-down">
                        <h2 class="text-center fw-600">App Download</h2>
                        <a href="#"><img src="/images/GoogleApp.png" class="mx-auto img-fluid mb-3" alt="g-play" /></a>
                        <a href="#"><img src="/images/AppleApp.png" class="mx-auto img-fluid mb-4" alt="a-store" /></a>
                        <h4 class="pl-3">App Languages</h4>
                        <ul class="text-left pl-3">
                            <li><a>English</a></li>
                            <li><a>हिंदी</a></li>
                            <li><a>ಕನ್ನಡ</a></li>
                            <li><a>French</a></li>
                            <li><a>Spanish</a></li>
                            <li><a>Marathi</a></li>
                            <li><a>Gujarati</a></li>
                            <li><a>Bhasa Indo</a></li>
                        </ul>
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