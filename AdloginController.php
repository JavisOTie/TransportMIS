<?php

namespace app\controllers;

use app\models\Adlogin;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AdloginSearch;
use yii\web\NotFoundHttpException;

/**
 * AdloginController implements the CRUD actions for Adlogin model.
 */
class AdloginController extends Controller
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
     * Lists all Adlogin models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AdloginSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adlogin model.
     * @param string $username Username
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($username)
    {
        return $this->render('view', [
            'model' => $this->findModel($username),
        ]);
    }

    /**
     * Creates a new Adlogin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Adlogin();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->save();
                return $this->redirect(['view', 'username' => $model->username]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Adlogin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $username Username
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($username)
    {
        $model = $this->findModel($username);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'username' => $model->username]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Adlogin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $username Username
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($username)
    {
        $this->findModel($username)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Adlogin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $username Username
     * @return Adlogin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($username)
    {
        if (($model = Adlogin::findOne(['username' => $username])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
