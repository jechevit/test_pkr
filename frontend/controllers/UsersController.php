<?php

namespace frontend\controllers;

use console\controllers\RoleController;
use core\entities\User;
use core\forms\user\PasswordChangeForm;
use core\forms\user\UserCreateForm;
use core\forms\user\UserEditForm;
use core\services\UserService;
use DomainException;
use frontend\forms\UserSearch;
use Throwable;
use Yii;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * UsersController constructor.
     * @param $id
     * @param $module
     * @param UserService $service
     * @param array $config
     */
    public function __construct($id, $module, UserService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'view',
                            'create',
                            'edit',
                            'activate',
                            'draft',
                            'change-password',
                            'delete'
                        ],
                        'allow' => true,
                        'roles' => [RoleController::ADMIN],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     */
    public function actionCreate()
    {
        $form = new UserCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->create($form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEdit($id)
    {
        $user = $this->findModel($id);

        $form = new UserEditForm($user);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($user->id, $form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionChangePassword($id)
    {
        $user = $this->findModel($id);

        if (!Yii::$app->user->can('admin', ['user' => $user])){
            throw new ForbiddenHttpException('Вы не можете редактировать пользователя');
        }

        $form = new PasswordChangeForm($user);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->changePassword($user->id, $form);
            return $this->redirect(['view', 'id' => $user->id]);
        } else {
            return $this->render('change-password', [
                'model' => $form,
                'user' => $user,
            ]);
        }
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionActivate(int $id)
    {
        $user = $this->findModel($id);
        try {
            $this->service->activate($user->id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $user->id]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDraft(int $id)
    {
        $user = $this->findModel($id);
        try {
            $this->service->draft($user->id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $user->id]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $user = $this->findModel($id);
        try {
            $this->service->remove($user->id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['view', 'id' => $user->id]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}