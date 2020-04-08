<?php

namespace app\modules\user\controllers;

use Yii;
use app\models\UserModel;
use app\models\form\UserForm;
use app\models\UserModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\user\filters\AccessRule;
use app\modules\user\Finder;
use app\modules\user\models\Profile;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\modules\user\helpers\Password;
use app\modules\user\Module;
use app\modules\user\traits\EventTrait;

/**
 * UserController implements the CRUD actions for UserModel model.
 */
class UserController extends Controller {

    use EventTrait;
    use \app\components\traits\AjaxValidationTrait;

    const EVENT_BEFORE_CREATE = 'beforeCreate';
    const EVENT_AFTER_CREATE = 'afterCreate';
    const EVENT_BEFORE_UPDATE = 'beforeUpdate';
    const EVENT_AFTER_UPDATE = 'afterUpdate';
    const EVENT_BEFORE_IMPERSONATE = 'beforeImpersonate';
    const EVENT_AFTER_IMPERSONATE = 'afterImpersonate';
    const EVENT_BEFORE_PROFILE_UPDATE = 'beforeProfileUpdate';
    const EVENT_AFTER_PROFILE_UPDATE = 'afterProfileUpdate';
    const EVENT_BEFORE_CONFIRM = 'beforeConfirm';
    const EVENT_AFTER_CONFIRM = 'afterConfirm';
    const EVENT_BEFORE_DELETE = 'beforeDelete';
    const EVENT_AFTER_DELETE = 'afterDelete';
    const EVENT_BEFORE_BLOCK = 'beforeBlock';
    const EVENT_AFTER_BLOCK = 'afterBlock';
    const EVENT_BEFORE_UNBLOCK = 'beforeUnblock';
    const EVENT_AFTER_UNBLOCK = 'afterUnblock';
    const ORIGINAL_USER_SESSION_KEY = 'original_user';

    /** @var Finder */
    protected $finder;

    /**
     * @param string  $id
     * @param Module2 $module
     * @param Finder  $finder
     * @param array   $config
     */
    public function __construct($id, $module, Finder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view', 'delete', 'changepassword'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'changepassword'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionChangepassword() {

        /** @var User $user */
        $user = \Yii::createObject([
                    'class' => \app\modules\user\models\form\ChangePasswordForm::className(),
        ]);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Password Change successfuly'));
            return $this->goHome();
        }

        return $this->render('changepassword', [
                    'user' => $user
        ]);
    }

    protected function findModel($id) {
        if (($model = UserModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
