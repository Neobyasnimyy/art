<?php

namespace app\controllers;

use app\models\About;
use app\models\Message;
use app\models\RegisterForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
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
        return $this->render('index');
    }

    public function actionError()
    {
        return $this->redirect('/');
    }

    /**
     * Register action
     *
     * @return string|Response
     */
    public function actionRegister(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new RegisterForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->role='user';
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            if($user->save()){
                Yii::$app->session->setFlash('success','Регистрация прошла успешно'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
                return Yii::$app->response->redirect(Url::to('/login'));
            }
        }
        return $this->render('register', compact('model'));
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

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
        $message = new Message();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $message->setAttributes($model->getAttributes());
            if ($message->save()){
                Yii::$app->session->setFlash('contactFormSubmitted');
                return $this->refresh();
            }

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
        $about=About::findOne(['id'=>1]);
        return $this->render('about',compact('about'));
    }
}
