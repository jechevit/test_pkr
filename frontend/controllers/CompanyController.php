<?php

namespace frontend\controllers;

use console\controllers\RoleController;
use core\entities\Company;
use core\forms\CompanyForm;
use core\services\CompanyService;
use DomainException;
use frontend\forms\CompanySearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;use yii\web\Response;

class CompanyController extends Controller
{
    /**
     * @var CompanyService
     */
    private $service;

    public function __construct($id, $module, CompanyService $service, $config = [])
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
                            'view'
                        ],
                        'allow' => true,
                        'roles' => [RoleController::USER],
                    ],
                    [
                        'actions' => [
                            'create',
                            'update',
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
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $company = $this->findModel($id);

        if (Yii::$app->user->can(RoleController::ADMIN)) {
            return $this->redirect(['update', 'id' => $company->id]);
        }
        return $this->render('view', [
            'model' => $company
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $form = new CompanyForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $company = $this->service->create($form);
                return $this->redirect(['index']);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $company = $this->findModel($id);

        $form = new CompanyForm($company);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($company->id, $form);
                return $this->redirect(['view', 'id' => $company->id]);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'company' => $company
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionDelete(int $id)
    {
        try {
            $this->service->remove($id);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company|null the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Company
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}