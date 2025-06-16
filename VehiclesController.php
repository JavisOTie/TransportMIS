<?php

namespace app\controllers;


use Yii;

use yii\web\Controller;
use app\models\Vehicles;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\models\VehiclesSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
/**
 * VehiclesController implements the CRUD actions for Vehicles model.
 */
class VehiclesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                        'access' =>
                ['class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
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
     * Lists all Vehicles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
        {
             return $this->redirect(['site/login']);
        }
        
        $searchModel = new VehiclesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vehicles model.
     * @param string $registration_no Registration No
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($registration_no)
    {
        return $this->render('view', [
            'model' => $this->findModel($registration_no),
        ]);
    }

    /**
     * Creates a new Vehicles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Vehicles();
        if ($model->load(yii::$app->request->post())) {

            $postData = yii::$app->request->post();


                $regNo = strtoupper($postData['Vehicles']['registration_no']);
    
    // List of restricted prefixes (add more as needed)
    $restrictedPrefixes = ['GK', 'GP', 'KDF', 'GK', 'GK', 'GKA', 'CD', 'GKB'];
    
    foreach ($restrictedPrefixes as $prefix) {
        if (strpos($regNo, $prefix) === 0) {

            Yii::$app->session->setFlash('vec');
            return $this->redirect(['index']);
        }
    }
            
            $imagename = $model->registration_no;
            $model->file = UploadedFile::getInstance($model, 'vpic');

            $model->file->saveAs('uploads/' . $imagename . '.' . $model->file->extension);
            //save the path in the db
            $model->vpic = 'uploads/' . $imagename . '.' . $model->file->extension;
            $model->save();


            return $this->redirect(['index']);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);




        // dd($model);
        // exit();


        // z

        // dd($model);
        // exit();

        // if ($model->upload() && $model->save()) {
        //     return $this->redirect(['index']);
        // }
        // } else {
        //  $model->loadDefaultValues();
        // }

        // return $this->render('create', [
        //'model' => $model,
        // ]);
    }


    // public function actionCreate()
    // {
    //     $model = new Vehiclesd();

    //     if ($this->request->isPost) {
    //         $model->load($this->request->post());
    //         $model->picture = UploadedFile::getInstance($model, 'picture');

    //         // dd($model);
    //         // exit();

    //         if ($model->upload() && $model->save()) {
    //             return $this->redirect(['index']);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }



    public function actionUpdate($registration_no)
{
    $model = $this->findModel($registration_no);
    $oldImage = $model->vpic; // Backup existing image path

    if ($this->request->isPost && $model->load($this->request->post())) {
        $file = UploadedFile::getInstance($model, 'vpic');
        $deleteImage = Yii::$app->request->post('deleteImage'); // Check if user wants to delete it

        if ($deleteImage && $oldImage && file_exists($oldImage)) {
            unlink($oldImage);
            $model->vpic = null;
        }

        if ($file) {
            $imageName = $model->registration_no . '_' . time();
            $imagePath = 'uploads/' . $imageName . '.' . $file->extension;
            if ($file->saveAs($imagePath)) {
                $model->vpic = $imagePath;
            }
        } elseif (!$deleteImage) {
            $model->vpic = $oldImage; // Retain the old image if no new one uploaded
        }

        if ($model->save(false)) {
            return $this->redirect(['index']);
        }
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}

    /**
     * Finds the Vehicles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $registration_no Registration No
     * @return Vehicles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($registration_no)
    {
        if (($model = Vehicles::findOne(['registration_no' => $registration_no])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
