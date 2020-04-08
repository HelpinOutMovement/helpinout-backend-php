<?php
switch (strtolower($_SERVER['SERVER_NAME'])) {
    case 'localhost':
        break;
    case 'hcl.utpal':
        $base_url = 'http://hcl.utpal';
        break;
    case 'sa-hcl.vk':
        $base_url = 'http://sa-hcl.vk:8080';
        break;
    default:
        $base_url = 'www.sa-hcl.in';
        break;
}
$base_url = 'http://alc.tlitech.net';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $url = $base_url . '/api/v2/center/learner';
    $arr['data'] = $_POST;
    //$arr['app_id'] = $_POST['app_id'];
    //$arr['imei_no'] = $_POST['imei_no'];
    //$arr['app_id'] = "2672";
    $arr['app_id'] = "2683";
    $arr['imei_no'] = "	b05088650ee9f66c";
    //$data_string = "data=".  json_encode($arr);


    if (function_exists('curl_file_create')) { // php 5.5+
        $cFile = curl_file_create('checked_checkbox.png');
    } else { // 
        $cFile = '@' . realpath('checked_checkbox.png');
    }

    // $arr['file']='@'.realpath('checked_checkbox.png');
    //print_r($arr['file']); exit;
    //echo $data_string; exit;
    //$data_string = base64_encode($data_string);
    //$post = array('data' =>  json_encode($_POST), 'app_id' => $_POST['app_id'], 'imei_no' => $_POST['imei_no'], 'file_content' => $cFile);
//
//        $post = array('data' =>  '{"center_id": "64","batch_id": "129","attendance_date": "2019-12-17","gps": "28.6111771,77.3627482","start_time": "02:05pm","end_time": "04:00pm","class_option_type": "1","course_day": "2","learner": [{"learner_id": 42,"present": 0,"late_min": ""},{"learner_id": 43,"present": 0,"late_min": ""},{"learner_id": 44,"present": 0,"late_min": ""},{"learner_id": 45,"present": 0,"late_min": ""},{"learner_id": 46,"present": 1,"late_min": ""},{"learner_id": 47,"present": 0,"late_min": ""},{"learner_id": 48,"present": 1,"late_min": ""},{"learner_id": 49,"present": 0,"late_min": ""},{"learner_id": 50,"present": 0,"late_min": ""},{"learner_id": 51,"present": 0,"late_min": ""},{"learner_id": 52,"present": 0,"late_min": ""},{"learner_id": 53,"present": 0,"late_min": ""},{"learner_id": 54,"present": 0,"late_min": ""},{"learner_id": 55,"present": 0,"late_min": ""},{"learner_id": 60,"present": 0,"late_min": ""}]}'
//        , 'app_id' => $arr['app_id'], 'imei_no' => $arr['imei_no'], 'file_content' => $cFile);

    $post = array('data' => '{ "imei_no": "b05088650ee9f66c", "app_id": "2683", "app_version": "1.7", "master_center_id": 64, "batch_code": 129 }'
        , 'app_id' => $arr['app_id'], 'imei_no' => $arr['imei_no'], 'file_content' => $cFile);

    $ch = curl_init($url);
    //curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
    //curl_setopt($ch, CURLOPT_NOBODY,1);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',
//        'Content-Length: ' . strlen($data_string))
//    );

    $result = curl_exec($ch);

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
        <title>Api Base Line Form Save</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form  method="POST" enctype="multipart/form-data">
            URL<input type="text" name="URL" value="<?= $base_url ?>/api/v2/user/apilogin"/><br/>
            app_id<input type="text" name="app_id" value="1" /><br/>
            imei_no<input type="text" name="imei_no" value="198989898"/><br/>

            app_id<input type="text" name="username" value="admin" /><br/>
            imei_no<input type="text" name="password" value="admin125"/><br/>

            master_block_id<input type="text" name="master_block_id" value="1"/><br/>
            master_panchayat_id<input type="text" name="master_panchayat_id" value="1"/><br/>
            master_village_id<input type="text" name="master_village_id" value="1"/><br/>
            home_id<input type="text" name="home_id" value=""/><br/>
            headman_name<input type="text" name="headman_name" value="Hemant Kumari"/><br/>
            answering_name<input type="text" name="answering_name" value="Hemant Kumari"/><br/>
            master_religion_id<input type="text" name="master_religion_id" value="1"/><br/>
            master_caste_id<input type="text" name="master_caste_id" value="1"/><br/>
            number_of_house_members<input type="text" name="number_of_house_members" value="4"/><br/>
            <br/>
            do_you_want_part_sharing_work<input type="text" name="do_you_want_part_sharing_work" value="1"/><br/>


            profile_image<input type="file" name="profile_image"/><br/>

            master_block_id<input type="text" name="learner[0][master_block_id]" value="1"/><br/>
            master_panchayat_id<input type="text" name="learner[0][master_panchayat_id]" value="1"/><br/>
            master_village_id<input type="text" name="learner[0][master_village_id]" value="1"/><br/>
            home_id<input type="text" name="learner[0][home_id]" value=""/><br/>
            learner_name<input type="text" name="learner[0][learner_name]" value="Hemant Kumari"/><br/>
            age<input type="text" name="learner[0][age]" value="21"/><br/>
            gender<input type="text" name="learner[0][gender]" value="1"/><br/>
            master_relation_id<input type="text" name="learner[0][master_relation_id]" value="1"/><br/>
            formal_education<input type="text" name="learner[0][formal_education]" value="1"/><br/>
            master_education_id<input type="text" name="learner[0][master_education_id]" value="1"/><br/>
            have_you_studied_in_the_adult_literacy_center<input type="text" name="learner[0][have_you_studied_in_the_adult_literacy_center]" value="1"/><br/>
            can_read<input type="text" name="learner[0][can_read]" value="1"/><br/>
            can_write<input type="text" name="learner[0][can_write]" value="1"/><br/>
            can_add_subtract<input type="text" name="learner[0][can_add_subtract]" value="1"/><br/>
            profile_image<input type="file" name="learner[0][lprofile_image]"/><br/>
            identity_card_image_f<input type="file" name="learner[0][lidentity_card_image_f]"/><br/>
            identity_card_image_b<input type="file" name="learner[0][lidentity_card_image_b]"/><br/>
            master_occupation_id<input type="text" name="learner[0][master_occupation_id]" value="1"/><br/>
            willing_to_come<input type="text" name="learner[0][willing_to_come]" value="1"/><br/>

            master_reason_id<br/>
            <input type="checkbox" name="learner[0][master_reason_id1]">master_reason_1<br>
            <input type="checkbox" name="learner[0][master_reason_id2]">master_reason_2<br>
            <input type="checkbox" name="learner[0][master_reason_id3]">master_reason_3<br>
            <input type="checkbox" name="learner[0][master_reason_id4]">master_reason_4<br>
            <input type="checkbox" name="learner[0][master_reason_id5]">master_reason_5<br>
            <input type="checkbox" name="learner[0][master_reason_id6]">master_reason_6<br>
            <input type="checkbox" name="learner[0][master_reason_id7]">master_reason_7<br>
            <input type="checkbox" name="learner[0][master_reason_id8]">master_reason_8<br>
            <input type="checkbox" name="learner[0][master_reason_id9]">master_reason_9<br>
            <br/>
            functional_capacity<br/>
            <input type="checkbox" name="learner[0][functional_capacity_1]">functional_capacity_1<br>
            <input type="checkbox" name="learner[0][functional_capacity_2]">functional_capacity_2 <br>
            <input type="checkbox" name="learner[0][functional_capacity_3]">functional_capacity_3<br>
            <br/>
            did_you_use_mobile<input type="text" name="learner[0][did_you_use_mobile]" value="1"/><br/>

            statistical_composition<br/>
            <input type="checkbox" name="learner[0][statistical_composition_1]">statistical_composition 1<br>
            <input type="checkbox" name="learner[0][statistical_composition_2]">statistical_composition 2 <br>
            <input type="checkbox" name="learner[0][statistical_composition_3]">statistical_composition 3<br>
            <input type="checkbox" name="learner[0][statistical_composition_4]">statistical_composition 4 <br>
            social_zip_cage <input type="text" name="learner[0][social_zip_cage]" value="8"><br>
            social_emblem <input type="text" name="learner[0][social_emblem]" value="7"><br>
            self_confidence_asaser <input type="text" name="learner[0][self_confidence_asaser]" value="6"><br>
            self_confidence_share<input type="text" name="learner[0][self_confidence_share]" value="4"></br>
            possibility<br/>
            <input type="checkbox" name="learner[0][possibility_1]">possibility 1<br>
            <input type="checkbox" name="learner[0][possibility_2]">possibility 2 <br>
            <input type="checkbox" name="learner[0][possibility_3]">possibility 3<br>
            <input type="checkbox" name="learner[0][possibility_4]">possibility 4 <br>
            <input type="checkbox" name="learner[0][possibility_5]">possibility 5<br>
            no_of_file<input type="text" name="no_of_file" value="7"/><br/>

            app_form_id<input type="text" name="app_form_id" value="123"/><br/>
            form_date<input type="text" name="form_date" value="2019-03-29 11:34:28"/><br/>
            gps<input type="text" name="gps" value="198989898,1222222222"/><br/>
            gps_accuracy<input type="text" name="gps_accuracy" value="10 meter"/><br/>
            status<input type="text" name="status" value="1"/><br/>
            <br/>

            <input type="submit" />
        </form>
    </body>
</html>
