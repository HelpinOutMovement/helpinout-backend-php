<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\MailLog;
use app\models\MailLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\UserModel;
use app\modules\user\models\UserSearch;
use yii\filters\VerbFilter;

/**
 * MaillogController implements the CRUD actions for MailLog model.
 */
class AppusersController extends Controller {

    /**
     * {@inheritdoc}
     */
//    public function behaviors() {
//        return [
//            'access' => [
//                'class' => \yii\filters\AccessControl::className(),
//                'only' => ['index', 'appdetail'],
//                'rules' => [
//                    [
//                        'actions' => ['index', 'appdetail'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            return (!Yii::$app->user->isGuest);
//                        }
//                    ],
//                    [
//                        'actions' => ['index', 'appdetail'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            return (!Yii::$app->user->isGuest && Yii::$app->user->identity->IsWebFullAccess);
//                        }
//                    ],
//                ],
//            ],
//        ];
//    }

    public function actionIndex() {

        $searchModel = new \app\models\UserModelSearch();
        $searchModel->master_organization_id = \Yii::$app->session->get('active_organization_id');
        $dataProvider = $searchModel->appusersearch(\Yii::$app->request->get());
        $dataProvider->query->andWhere("(role_id=5 || role_id=7)");
        $dataProvider->query->orderBy(['app_detail.date_of_install' => SORT_DESC,'app_detail.app_version' => SORT_DESC])->distinct();
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDelete($id) {
        $model = \app\models\AppDetail::findOne($id);
        if ($model->status == '1') {
            $model->status = '0';
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', "App Id:- " . $model->id . " Deactivated Successfully"));
        } else {
            $model->status = '1';
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', "App Id:- " . $model->id . " Activated Successfully"));
        }

        if ($model->save()) {
            return $this->redirect(['/admin/appusers/index']);
        }
    }

    public function actionAppdetail($id) {
        $searchModel = new \app\models\AppDetailSearch();
        $searchModel->user_id = $id;
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

}
