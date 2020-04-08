<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\AppRegistration;
use app\models\AppRegistrationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppDetailController implements the CRUD actions for AppDetail model.
 */
class AppDetailController extends Controller {
    /**
     * {@inheritdoc}
     */
//    public function behaviors() {
////        return [
////            'verbs' => [
////                'class' => VerbFilter::className(),
////                'actions' => [
////                    'delete' => ['POST'],
////                ],
////            ],
////        ];
//    }

    /**
     * Lists all AppDetail models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AppRegistrationSearch();
        if (isset($_GET['id'])) {
            $searchModel->id = $_GET['id'];
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the AppDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AppDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
