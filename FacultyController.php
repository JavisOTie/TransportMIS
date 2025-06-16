<?php

namespace app\controllers;

use app\models\Faculty;
use app\models\FacultySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FacultyController implements the CRUD actions for Faculty model.
 */
class FacultyController extends Controller
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
     * Lists all Faculty models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FacultySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Faculty model.
     * @param string $fac_code Fac Code
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($fac_code)
    {
        return $this->render('view', [
            'model' => $this->findModel($fac_code),
        ]);
    }

    /**
     * Creates a new Faculty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Faculty();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'fac_code' => $model->fac_code]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Faculty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $fac_code Fac Code
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($fac_code)
    {
        $model = $this->findModel($fac_code);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'fac_code' => $model->fac_code]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Faculty model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $fac_code Fac Code
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($fac_code)
    {
        $this->findModel($fac_code)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Faculty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $fac_code Fac Code
     * @return Faculty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($fac_code)
    {
        if (($model = Faculty::findOne(['fac_code' => $fac_code])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
