<?php
switch (strtolower($_SERVER['SERVER_NAME'])) {
    case 'localhost':
        break;
    case 'helpinout.vk':
        $base_url = 'http://helpinout.vk:8080';
        break;
    default:
        $base_url = 'http://3.7.52.176:8080';
        break;
}
//phpinfo(); exit;
//$base_url = 'http://3.7.52.176:8080';
$url = $base_url . '/api/v1/activity/add';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $arr = [];
    $arr['data'] = $_POST;
    $arr['app_id'] = $_POST['app_id'];
    $arr['imei_no'] = $_POST['imei_no'];
    $arr['date_time'] = $_POST['date_time']; //"2020-04-04T13:39:27.397-05:30";
    $data_string = '{"app_id":"1","imei_no":"d31f70e57896db2b","app_version":"1.0","date_time":"2020-04-05T19:17:26.190+05:30","data":{"geo_location":"28.6442562,77.3617728","geo_accuracy":"23.001","time_zone":"Asia\/Kolkata"}}';
// json_encode($arr);


    $data_string = '{
    "app_id": "2",
    "imei_no": "d60a758feb3e1c30",
    "app_version": "1.0",
    "date_time": "2020-04-06T19:19:41.866-05:00",
    "data": {
        "uuid": "78fa2f0e-6d4c-4074-8e9d-c91ea1e9ac89",
        "activity_type": 5,
        "geo_location": "38.6627279,77.3886294",
        "geo_accuracy": "16",
        "address": "464, Sector 1, Vasundhara, Ghaziabad, Uttar Pradesh 201012, India",
        "activity_category": 1,
        "activity_count": 2,
        "offer_condition" : "ndasnsmdsadsl dsla dslsl dsd",
        "activity_detail": [
            {
                "detail": "Y1y",
                "qty": "1"
            },
            {
                "detail": "G1",
                "qty": "2"
            }
        ],
        "offerer": "",
        "requester": "",
        "pay": 0,
        "time_zone": "Asia\/Kolkata"
    }
    }';
    
//    $data_string='{
//    "app_id": "2",
//    "imei_no": "d31f70e57896db2b",
//    "app_version": "1.0",
//    "date_time": "2020-04-09T13:40:32.742+05:30",
//    "data": {
//        "uuid": "4c53b61b-4b23-4de0-8f03-58a35601c4f4",
//        "activity_type": 2,
//        "geo_location": "28.6442674,77.3617401",
//        "geo_accuracy": "23",
//        "address": "181, Niti Khand I, Indirapuram, Ghaziabad, Uttar Pradesh 201014, India",
//        "activity_category": 1,
//        "activity_count": 1,
//        "activity_detail": [
//            {
//                "detail": "",
//                "qty": ""
//            }
//        ],
//        "offerer": "",
//        "requester": "",
//        "pay": 1,
//        "time_zone": "Asia\/Kolkata"
//    }
//}';
    
    $data_string='{
  "app_id": "11",
  "imei_no": "d31f70e57896db2b",
  "app_version": "1.0",
  "date_time": "2020-04-09T19:13:08.101+05:30",
  "data": {
    "activity_uuid": "d65db754-8b96-4b07-87db-24cc98a66b39",
    "activity_type": 1,
    "activity_category": 2,
    "volunters_required": 1,
    "volunters_detail": "Cavsgs",
    "address": "181, Niti Khand I, Indirapuram, Ghaziabad, Uttar Pradesh 201014, India",
    "volunters_quantity": "546",
    " technical_personal_required": 1,
    "technical_personal_detail": "Vzvvsvs",
    "technical_personal_quantity": "976",
    "pay": 1,
    "geo_location": "28.6442629,77.3617667",
    "geo_accuracy": "22",
    "time_zone": "Asia/Kolkata"
  }
}';
    

    $ch = curl_init($url);
    //curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_PORT, 8080);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
    //curl_setopt($ch, CURLOPT_NOBODY,1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',
        'Content-Length: ' . strlen($data_string))
    );
//echo $data_string;//exit;
    $result = curl_exec($ch);
    echo $result . $data_string; //exit;
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($result, 0, $header_size);
    $body = substr($result, $header_size);
    echo $header;
    echo "<br/>";
    echo "<br/>";
    echo $body;
    exit;
}
?>
<html>
    <head>
        <title>Api Check - Activity Add</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form  method="POST">
            <br/>
            URL<input type="text" name="URL" value="<?= $url ?>"/><br/>
            app_id<input type="text" name="app_id"/><br/>
            imei_no<input type="text" name="imei_no"/><br/>
            date_time<input type="text" name="date_time"/><br/>
            <br/>
            
            <input type="submit" />
        </form>
    </body>
</html>
