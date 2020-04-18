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
$base_url = 'http://3.7.52.176:8080';
$url = $base_url . '/api/v1/mapping/delete';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $arr = [];
    $arr['data'] = $_POST;
    $arr['app_id'] = $_POST['app_id'];
    $arr['imei_no'] = $_POST['imei_no'];
    $arr['date_time'] = $_POST['date_time']; //"2020-04-04T13:39:27.397-05:30";
    $data_string = '{"app_id":"1","imei_no":"d31f70e57896db2b","app_version":"1.0","date_time":"2020-04-05T19:17:26.190+05:30","data":{"geo_location":"28.6442562,77.3617728","geo_accuracy":"23.001","time_zone":"Asia\/Kolkata"}}';

    $data_string = '{"app_id":"174","imei_no":"d31f70e57896db2b","app_version":"1.0","date_time":"2020-04-12T14:08:32.198+05:30","data":{"activity_uuid":"cc4c3ee4-28f2-4e70-acc9-254d1c8a78c9","activity_type":1,"offerer":[{"activity_uuid":"16cf6454-b0a8-4835-a69a-24913c8065f7"}],"time_zone":"Asia\/Kolkata"}}';

    //$arr['data'] = $_POST;
    //$arr['app_id'] = $_POST['app_id'];
    //$arr['imei_no'] = $_POST['imei_no'];
    //$arr['app_id'] = "2672";
//    $arr['app_id'] = "0";
//    $arr['imei_no'] = "	b05088650ee9f66c";
//    $arr['date_time'] = "2019-07-22T13:39:27.397-05:30";
    //$data_string = "data=".  json_encode($arr);
    // $arr['file']='@'.realpath('checked_checkbox.png');
    //print_r($arr['file']); exit;
    //echo $data_string; exit;
    //$data_string = base64_encode($data_string);
    //$post = array('data' =>  json_encode($_POST), 'app_id' => $_POST['app_id'], 'imei_no' => $_POST['imei_no'], 'file_content' => $cFile);
//
//        $post = array('data' =>  '{"center_id": "64","batch_id": "129","attendance_date": "2019-12-17","gps": "28.6111771,77.3627482","start_time": "02:05pm","end_time": "04:00pm","class_option_type": "1","course_day": "2","learner": [{"learner_id": 42,"present": 0,"late_min": ""},{"learner_id": 43,"present": 0,"late_min": ""},{"learner_id": 44,"present": 0,"late_min": ""},{"learner_id": 45,"present": 0,"late_min": ""},{"learner_id": 46,"present": 1,"late_min": ""},{"learner_id": 47,"present": 0,"late_min": ""},{"learner_id": 48,"present": 1,"late_min": ""},{"learner_id": 49,"present": 0,"late_min": ""},{"learner_id": 50,"present": 0,"late_min": ""},{"learner_id": 51,"present": 0,"late_min": ""},{"learner_id": 52,"present": 0,"late_min": ""},{"learner_id": 53,"present": 0,"late_min": ""},{"learner_id": 54,"present": 0,"late_min": ""},{"learner_id": 55,"present": 0,"late_min": ""},{"learner_id": 60,"present": 0,"late_min": ""}]}'
//        , 'app_id' => $arr['app_id'], 'imei_no' => $arr['imei_no'], 'file_content' => $cFile);
//    //    if (function_exists('curl_file_create')) { // php 5.5+
//        $cFile = curl_file_create('checked_checkbox.png');
//    } else { // 
//        $cFile = '@' . realpath('checked_checkbox.png');
//    }
//    $post = array('data' => '{ '
//        . '"imei_no": "b05088650ee9f66c", '
//        . '"app_id": "2683", '
//        . '"app_version": "1.7", '
//        . '"master_center_id": 64, '
//        . '"batch_code": 129 }'
//        , 'app_id' => $arr['app_id'], 'imei_no' => $arr['imei_no'], 'file_content' => $cFile);
//    $post = array('data' => '{
//  "app_id": "",
//  "imei_no": "d31f70e57896db2b",
//  "date_time": "2020-04-02T17:01:32.783-05:30",
//  "os_type": "Android",
//  "manufacturer_name": "Xiaomi Redmi Note 8 Pro",
//  "os_version": "28",
//  "firebase_token": "d15a_diZQoS8zXZkoyxV7l:APA91bHDD6ZJftaw_NAb0D_Ywd4mhSOw-T1Ci6ty8y_tX140VOTAgd3BeFNXChVh0uWgR4dFGmLlUEWGW-bgqg8QxvseX-sE4JZneNZprVcOeDesDKceaQQmhDbYtQj851utGolrJIr0",
//  "country_code": "+91",
//  "mobile_no": "8800579215"
//}'
//        , 'app_id' => $arr['app_id'], 'imei_no' => $arr['imei_no'], 'date_time' => $arr['date_time']);
//
//    $arr['data'] = '{
//  
//  "os_type": "Android",
//  "manufacturer_name": "Xiaomi Redmi Note 8 Pro",
//  "os_version": "28",
//  "firebase_token": "d15a_diZQoS8zXZkoyxV7l:APA91bHDD6ZJftaw_NAb0D_Ywd4mhSOw-T1Ci6ty8y_tX140VOTAgd3BeFNXChVh0uWgR4dFGmLlUEWGW-bgqg8QxvseX-sE4JZneNZprVcOeDesDKceaQQmhDbYtQj851utGolrJIr0",
//  "country_code": "+91",
//  "mobile_no": "8800579215"
//}';
//    $data_string = json_encode($arr);
//
//    $data_string = '{"app_id":"","imei_no":"d31f70e57896db2b","app_version":"1.0","date_time":"2020-04-03T22:08:33.982-05:00","data":{"app_id":"","imei_no":"d31f70e57896db2b","app_version":"1.0","date_time":"2020-04-03T22:08:34.031-05:00","os_type":"Android","manufacturer_name":"Xiaomi Redmi Note 8 Pro","os_version":"28","firebase_token":"ejt3njknRqe386D6qo7gBl:APA91bEEiN4hEnMLpXQgUEwAkssBiy00PXQp0Iw0sYTc76cbuo6TsvhaXenvWpEnABdvQVk35JJ6Q-YXhwJ_OT-SS9BM-XcUAfC34hBRbyfQ6tAoxaHbSua-lkMsRUQb8Pv9N1gpSqio","time_zone":"+05:30","country_code":"+91","mobile_no":"8800579215","first_name":"Avneesh","last_name":"Kumar","mobile_no_visibility":1,"user_type":1,"org_name":"","org_type":"","org_division":""}}';


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
        <title>Api Check - User Register</title>
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
            geo_location<input type="text" name="geo_accuracy"/><br/>
            geo_accuracy<input type="text" name="geo_accuracy"/><br/>
            <input type="submit" />
        </form>
    </body>
</html>
