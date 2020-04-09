<?php

namespace app\modules\report\controllers;

use Yii;
use app\models\ApiLog;
use app\models\ApiLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ApilogController implements the CRUD actions for ApiLog model.
 */
class ApilogController extends Controller {

    /**
     * {@inheritdoc}
     */
//    public function behaviors() {
//        return [
//            'access' => [
//                'class' => \yii\filters\AccessControl::className(),
//                'only' => ['index', 'view'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                // everything else is denied
//                ],
//            ],
//        ];
//    }

    /**
     * Lists all ApiLog models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ApiLogSearch();
        if (isset($_GET['id'])) {
            $searchModel->app_id = $_GET['id'];
        }
//        if (isset($_GET['user_id'])) {
//            $searchModel->user_id = $_GET['user_id'];
//        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       // $searchModel->app_option = \app\models\GenralModel::appoption($searchModel);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequestbody($id) {
        $searchModel = new ApiLogSearch();
        $searchModel->id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('requestbody', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('requestbody', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single ApiLog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ApiLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ApiLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ApiLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ApiLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ApiLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ApiLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ApiLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
