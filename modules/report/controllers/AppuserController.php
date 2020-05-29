<?php

namespace app\modules\report\controllers;

use Yii;
use app\models\AppUser;
use app\models\AppUserSearch;
use app\models\AppRegistration;
use app\models\AppRegistrationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\OfferHelp;
use app\models\RequestHelp;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

/**
 * AppuserController implements the CRUD actions for AppUser model.
 */
class AppuserController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AppUser models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AppUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppUser model.
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
     * Creates a new AppUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AppUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing AppUser model.
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

    public function actionActive($id) {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionInactive($id) {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionDetail($id) {
        $model = $this->findModel($id);
        $offer = OfferHelp::find()->where(['app_user_id' => $id, 'status' => 1])->all();


        $request = RequestHelp::find()->where(['app_user_id' => $id, 'status' => 1])->all();
        $notification= \app\models\Notification::find()->where(['app_user_id'=>$id])->all();
        return $this->render('details', [
                    'model' => $model, 'offer' => $offer, 'request' => $request,
                     'notification'=>$notification,
//                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionProfile($id) {

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionAppdetails($id) {
        $searchModel = new AppRegistrationSearch();
        $searchModel->app_user_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('appdetail', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('appdetail', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Finds the AppUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AppUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
