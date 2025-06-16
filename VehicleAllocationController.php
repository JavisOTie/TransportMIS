<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Department;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\VehicleAllocation;
use yii\web\NotFoundHttpException;
use app\models\VehicleAllocationSearch;

/**
 * VehicleAllocationController implements the CRUD actions for VehicleAllocation model.
 */
class VehicleAllocationController extends Controller
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
     * Lists all VehicleAllocation models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VehicleAllocationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

            $dueVehicles = VehicleAllocation::find()
        ->where(['<=', 'return_date', date('Y-m-d')])
        ->andWhere(['allocation_status' => 'allocated'])
        ->all()]);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'dueVehicles' => $dueVehicles, // Pass to view
        ]);
    }
    /**
     * Lists all VehicleAllocation models.
     *
     * @return string
     */
    public function actionFaculty()
    {
        $searchModel = new VehicleAllocationSearch();
        $dataProvider = $searchModel->faculties(Yii::$app->request->queryParams);

        return $this->render('faculty', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDepartment()
    {
        $searchModel = new VehicleAllocationSearch();
        $dataProvider = $searchModel->departments(Yii::$app->request->queryParams);

        return $this->render('dept', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VehicleAllocation model.
     * @param int $allocation_id Allocation ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($allocation_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($allocation_id),
        ]);
    }

    /**
     * Creates a new VehicleAllocation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new VehicleAllocation();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
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
     * Updates an existing VehicleAllocation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $allocation_id Allocation ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($allocation_id)
    {
        $model = $this->findModel($allocation_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
        $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['index']);
    }

    return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing VehicleAllocation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $allocation_id Allocation ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($allocation_id)
    {
        $this->findModel($allocation_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VehicleAllocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $allocation_id Allocation ID
     * @return VehicleAllocation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($allocation_id)
    {
        if (($model = VehicleAllocation::findOne(['allocation_id' => $allocation_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    

    public function actionStatistics()
{
    $departments = Department::find()->all();

    $allocatedRaw = VehicleAllocation::find()
        ->select(['dept_id', 'COUNT(*) AS count'])
        ->where(['allocation_status' => 'allocated'])
        ->groupBy('dept_id')
        ->asArray()
        ->all();

    $withdrawnRaw = VehicleAllocation::find()
        ->select(['dept_id', 'COUNT(*) AS count'])
        ->where(['allocation_status' => 'withdrawn'])
        ->groupBy('dept_id')
        ->asArray()
        ->all();

    $allocated = ArrayHelper::map($allocatedRaw, 'dept_id', 'count');
    $withdrawn = ArrayHelper::map($withdrawnRaw, 'dept_id', 'count');

    $faculties = [];
    foreach ($departments as $dept) {
        $faculty = $dept['faculty'] ?? 'Unknown';
        $faculties[$faculty][] = [
            'dept_id' => $dept['dept_id'],
            'dept_name' => $dept['dept_name'],
            'allocated' => $allocated[$dept['dept_id']] ?? 0,
            'withdrawn' => $withdrawn[$dept['dept_id']] ?? 0,
        ];
    }

    return $this->render('statistics', [
        'departments' => $departments,
        'allocated' => $allocated,
        'withdrawn' => $withdrawn,
        

        
    ]);
}
public function actionDetails($dept_code)
{
    $searchModel = new VehicleAllocationSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    // Filter by department code
    $dataProvider->query->andWhere(['dept_code' => $dept_code]);

    return $this->render('details', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}


}
