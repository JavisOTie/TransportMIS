<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\VehicleModels;
use yii\web\NotFoundHttpException;
use app\models\Search\VehicleModelsSearch;

/**
 * VehiclemodelsController implements the CRUD actions for VehicleModels model.
 */
class VehiclemodelsController extends Controller
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
     * Lists all VehicleModels models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
        {
             return $this->redirect(['site/login']);
        }
        
        $searchModel = new VehicleModelsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VehicleModels model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VehicleModels model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new VehicleModels();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             //return $this->redirect(['view', 'id' => $model->id]);
    //             return $this->redirect(['index']);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }
public function actionCreate()
    {
        $model = new VehicleModels();

        if ($this->request->isPost) {
            //dd($this->request->post(),$model->load($this->request->post()),  $model->save(), $model->errors);
            if ($model->load($this->request->post()) && $model->save()) {
                //return $this->redirect(['view', 'id' => $model->id]);
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
     * Updates an existing VehicleModels model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
           // return $this->redirect(['view', 'id' => $model->id]);
             return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VehicleModels model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VehicleModels model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return VehicleModels the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDashboardStats()
{
    // Group by vehicle type (example)
    $typeStats = VehicleModels::find()
        ->select(['type_id', 'COUNT(*) as count'])
        ->groupBy('type_id')
        ->asArray()
        ->all();

    // Group by make (example)
    $makeStats = VehicleModels::find()
        ->select(['make_id', 'COUNT(*) as count'])
        ->groupBy('make_id')
        ->asArray()
        ->all();

    return $this->render('dashboard', [
        'typeStats' => $typeStats,
        'makeStats' => $makeStats,
    ]);
}
    protected function findModel($id)
    {
        if (($model = VehicleModels::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
