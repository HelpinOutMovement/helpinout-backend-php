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
    "app_id": "656",
    "imei_no": "637809f66112c7e4",
    "app_version": "2.1",
    "date_time": "2020-05-13T12:55:07.134+05:30",
    "data": {
        "activity_uuid": "933f7ab5-83b1-4281-93a6-a801c9c69512",
        "activity_type": 1,
        "geo_location": "29.98912566102302,77.49586410820484",
        "geo_accuracy": "371.629",
        "address": "Unnamed Road, Bhaupur, Uttar Pradesh 247002, India",
        "self_else": 0,
        "activity_category": 5,
        "activity_count": 1,
        "activity_detail": [
            {
                "detail": "Hi mohtsim from the resume of mine who have a very happy with the updated version change",
                "qty": "123"
            }
        ],
        "offer_note": "K to chudte laglam ar amar khala thake tahole ami amar hi add a comment on this device is resolved to be the same is true that says  to the activity of single page has me the resume of Mr and sao the list of single page website jha ke pass suite is the best of luck to everyone and other organisations and individuals who are surprisingly to you ji ko bol ker rahe hai ji been a very nice of fm idk ugh email address to send you the activity details for the r tch up",
        "offerer": "",
        "requester": "",
        "pay": 0
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
