<?php

namespace app\controllers;

use Yii;
use app\models\UploadFile;
use app\models\UploadFileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * QuestionImportController implements the CRUD actions for QuestionImportFile model.
 */
class UploadController extends Controller {

    public function actionXml() {


        ini_set('max_execution_time', 1200000000000000000);
        ini_set('memory_limit', '10244444444444M');

        $model = new Uploadfile();
        if ($model->load(Yii::$app->request->post())) {

            $uploadFile = UploadedFile::getInstance($model, 'file_name');
            $model->file_name = $uploadFile;
            $filename = str_replace(' ', '', $model->file_name);
            if ($model->file_name != '') {

                if (!file_exists($model->file_name)) {
                    $model->file_name->saveAs($model->file_name);
                }
                $file = $model->file_name;

                $servername = "localhost";
                $username = "root";
                $password = "password";
                $dbname = "helpinout";

                $conn = new \mysqli($servername, $username, $password, $dbname);
                mysqli_options($conn, MYSQLI_OPT_LOCAL_INFILE, true);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $delimiter = ';'; //By default ,
                $xmldata = simplexml_load_file($model->file_name) or die("Failed to load");


                $xmlparser = xml_parser_create();
                $fp = fopen($model->file_name, "r");
                $xmldata = fread($fp, 4096 * 10);
                $con = json_encode($xmldata);

                $newArr = json_decode($con, true);
//                print_r($xmldata);
//                exit;
                xml_parse_into_struct($xmlparser, $newArr, $values);
//


                xml_parser_free($xmlparser);
                $arr = simplexml_load_string($newArr);
                $count = count($arr);


                $columns = '';
                $j = 0;
                for ($i = 0; $i <= $count - 3; $i++) {
                    foreach ($arr->string[$i]->attributes() as $a => $column) {

                        if ($column == 'false' OR $column == 'CDATA') {
                            $column = '';
                        } else if ($column == 'change') {
                            $column = '_change';
                        } else {
                            if ($columns)
                                $columns .= ', ';

                            $column = (str_replace('', '', $column));
                            $column = (str_replace(',', '', $column));
                            $column = (str_replace('-', '_', $column));
                            $column = (str_replace(' ', '', $column));
                            $column = (str_replace('/', '', $column));

                            $columns .= $column . " varchar(250)";


                            $j++;
                        }
                    }
                }


                $columnss = '';
                $j = 0;
                foreach ($arr as $value) {
                    if ($columnss)
                        $columnss .= ', ';


                    $columnss .= $value;


                    $j++;
                }

                $table = explode('.', $model->file_name);
                $columnsn = $columns;
                $tableoriginal = str_replace(' ', '', $table[0]);
//                print_r($columnsn);
//                exit;
                $create = "create table  strings ($columns)";
                if ($conn->query($create) === TRUE) {
//                    echo "Table created successfully";
                } else {
//                    echo "Error creating table: " . $conn->error;
                }
                $insert = "LOAD XML LOCAL INFILE '$file'
INTO TABLE strings 
ROWS IDENTIFIED BY '<resources>'";
//              

//                print_r($insert);
//                exit;
                if ($conn->query($insert) === TRUE) {
                    echo "data inserted successfully";
                } else {
                    echo "Error: " . $conn->error;
                }
            }
        }
//        }
        return $this->render('xml', [
                    'model' => $model,
        ]);
    }

}
