<?php

namespace app\controllers;

use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AuthorizingOfficer;
use yii\web\NotFoundHttpException;
use app\models\AuthorizingOfficerSearch;

/**
 * AuthorizingOfficerController implements the CRUD actions for AuthorizingOfficer model.
 */
class AuthorizingOfficerController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all AuthorizingOfficer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthorizingOfficerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthorizingOfficer model.
     * @param int $authority_id Authority ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($authority_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($authority_id),
        ]);
    }

    /**
     * Creates a new AuthorizingOfficer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AuthorizingOfficer();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $payroll = $this->request->post()['AuthorizingOfficer']['payroll_no'];
                $staff = (new Query())
                    ->select([
                        'payroll_no',
                        'sirname',
                        'dsg_name',
                        'other_names',
                        'fac_code',
                        'dept_code',
                        "CONCAT(sirname, ' ', other_names) AS names"
                    ])
                    ->from(['staff'])->where(['payroll_no' => $payroll])->one();

                $model->dept_code = $staff['dept_code'];
                $model->save();
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthorizingOfficer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $authority_id Authority ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($authority_id)
    {
        $model = $this->findModel($authority_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthorizingOfficer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $authority_id Authority ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($authority_id)
    {
        $this->findModel($authority_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthorizingOfficer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $authority_id Authority ID
     * @return AuthorizingOfficer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($authority_id)
    {
        if (($model = AuthorizingOfficer::findOne(['authority_id' => $authority_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
