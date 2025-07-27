<?php

namespace app\controllers;

use app\models\AdminLogInForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\App;
use app\models\VideoSearchForm;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use app\models\Modules;

class SiteController extends Controller
{
    /**
     * Behaviour config of the controller
     * 
     * @return array
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'login', 'admin-log-in', 'signup', 'contact'],
                        'allow' => true,
                        'roles' => ['?'], // ? - user is guest
                    ],
                    [
                        'actions' => ['logout', 'contact'],
                        'allow' => true,
                        'roles' => ['@'], // @ - is authorized
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
     * Index action: displays all videos
     * 
     * @return view
     */
    public function actionIndex()
    {
        $searchModel = new VideoSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Admin login action.
     *
     * @return string
     */
    public function actionAdminLogIn()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new AdminLogInForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/']); // - / = site/index
        }

        return $this->render('adminlogin', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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

    /**
     * Displays register page.
     *
     * @return string
     */
    public function actionRegister() {
        $model = new RegisterForm();


        if( $model->load(Yii::$app->request->post()) && $model->validate() ) {
            if( $model->add() ) {
                App::alert('success', 'You were successfully registered.');
            } else {
                App::alert('danger', 'There was an error while registering. Try again later.');
            }

            return $this->refresh();
        }

        return $this->render('register', ['model' => $model]);
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact() {

        $model = new ContactForm();

        if( $model->load(App::post()) && $model->validate() ) {
            if( $model->sendEmail() ) {
                App::alert('success', 'The message has been sent. Thank you for contacting.');
            } else {
                App::alert('danger', 'Error while sending a message. Try again later.');
            }

            return $this->refresh();
        }

        return $this->render('contact', ['model' => $model]);
    }
}
