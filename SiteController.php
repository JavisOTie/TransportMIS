<?php

namespace app\controllers;

use Yii;
use yii\db\Exception;
use app\models\Loginf;
use yii\db\Expression;
use yii\web\Responsef;
use yii\web\Controller;
use app\models\Vehicles;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\filters\VerbFilter;
use app\models\Vehiclemakes;
use app\models\Vehicletypes;
use app\models\VehicleModels;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

use PHPUnit\Framework\throwExceptionException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->redirect(['/site/login']);
        }


        
        // Query to get count of vehicles by color
        $colorData = Vehicles::find()
    ->select(['color', 'COUNT(*) as count'])
    ->groupBy('color')
    ->asArray()
    ->all();


     $makeRawData = Vehiclemakes::find()
        ->select(['name', 'COUNT(*) as count'])
        ->groupBy('name')
        ->asArray()
        ->all();
// Format data for the chart
    $chartDataMakes = [];
    foreach ($makeRawData as $row) {
        $chartDataMakes[] = [
            'Make' => $row['name'],
            'Count' => (int) $row['count'],
        ];
    }

    //  $typeData = Vehicletypes::find()
    // ->select(['name', 'COUNT(*) as count'])
    // ->groupBy('name')
    // ->asArray()
    // ->all();

$chartData = [];
foreach ($colorData as $row) {
    $chartData[] = [
        'Color' => $row['color'],
        'Count' => (int)$row['count'],
    ];
// Query to count vehicles by make name
   

    // Format data for the chart
    $typeChartData = [];
foreach ($makeRawData as $row) {
    $typeChartData[] = [
        'Name' => $row['name'],
        'Count' => (int)$row['count'],
    ];
    
    
}

    // Query to get count of vehicles by type
$typeRawData = Vehicletypes::find()
    ->select([
        'name' => 'vehicle_types.name', 
        'count'=> new Expression('COUNT(vehicle_models.type_id)'),
    ])
    ->distinct()
    ->groupBy('name')
    ->joinWith(['vehicleModels'])
    ->groupBy([
        'vehicle_types.name',
        'vehicle_models.type_id'
    ])
    ->asArray()
    ->all();

$typeChartData = [];
foreach ($typeRawData as $row) {
    $typeChartData[] = [
        'Name' => $row['name'],
        'Count' => (int)$row['count'],
    ];
    
    
}


}

    
        return $this->render('index', ['chartData' => $chartData,'typeChartData'=>$typeChartData,'chartDataMakes' => $chartDataMakes,'typeRawData' => $typeRawData,'makeRawData'=>$makeRawData]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        // if (!Yii::$app->user->isGuest) {
        //     return $this->goHome();
        // }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {//$model->login()
        
            
        //     $username = Yii::$app->request->post('LoginForm')['username'];
        //     $password = Yii::$app->request->post('LoginForm')['password'];
        //     $this->checkLogins($username, $password);
              
        //     // dd('here');
        //     return $this->goBack();
        // }
        if ($model->validate()) {
                    $user = Loginf::findByUsername($model->username);

                    if (empty($user) || empty($user->password) || !$user->validatePassword($model->password)) {
                        // $this->setFlash('danger', 'Login', 'Incorrect username or password.');
                        Yii::$app->session->setFlash('error', 'Invalid username or password');
                        
                        return $this->redirect(['/site/login']);
                    }

                    if (Yii::$app->user->login($user)) {
                       // $user->last_login = new Expression('NOW()');
                        // if (!$user->save()) {
                        //     throw new Exception('Failed to update login time.');
                        // }

       
                        return $this->goHome();
                    } else {
                        throw new Exception('An error occurred while trying to log in.');
                    }
                } else {
                    $this->setFlash('danger', 'Login', 'Incorrect username or password.');
                    return $this->redirect(['/site/login']);
                }
            }


        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    private function checkLogins($username, $password)
    {
        // dd(Yii::$app->getDb());
    //     try{
    //     Yii::$app->getDb()->username;
    //     Yii::$app->getDb()->password;
    //    Yii::$app->getDb()->createCommand('SELECT COUNT(*) FROM dual')->queryScalar();

    //     }
    //     catch(Exception $e)
    //     {
    //         throwException('Login ');
    //     }
        
       // dd($username, $password);
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        // return $this->redirect(['/site/login']);
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
        
    }
    // use app\models\Loginf;
// use Yii;

public function actionHashPasswords()
{
    $users = Loginf::find()->all();

    foreach ($users as $user) {
        // Only update if password is not already hashed
        try {
            Yii::$app->getSecurity()->validatePassword('dummy', $user->password);
            // Already hashed, skip
            continue;
        } catch (\yii\base\InvalidArgumentException $e) {
            // Not a valid hash – hash it now
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
            $user->save(false);
        }
    }

    echo "Passwords hashed successfully.";
}



}