<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
        return $this->render('index');
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

        $model->password = '';
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

    public function actionSignup()
{
    $model = new \app\models\User();

    if ($model->load(\Yii::$app->request->post())) {
        $model->setPassword($model->password);
        $model->generateAuthKey();
        $model->status = \app\models\User::STATUS_ACTIVE;
        $model->created_at = time();
        $model->updated_at = time();

        if ($model->save()) {
            \Yii::$app->session->setFlash('success', 'Регистрация прошла успешно.');
            return $this->goHome();
        }
    }

    return $this->render('signup', [
        'model' => $model,
    ]);
}


    public function actionTopAuthors($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }

        if (!is_numeric($year) || $year < 1900 || $year > 2100) {
            throw new \yii\web\BadRequestHttpException('Некорректный год');
        }

        $topAuthors = \app\models\Author::find()
            ->select([
                'author.id',
                'author.full_name',
                'book_count' => 'COUNT(book.id)'
            ])
            ->from('{{%author}} author')
            ->leftJoin('{{%book_author}} ba', 'author.id = ba.author_id')
            ->leftJoin('{{%book}} book', 'ba.book_id = book.id AND book.year = :year', [':year' => $year])
            ->groupBy('author.id')
            ->orderBy('book_count DESC')
            ->limit(10)
            ->asArray()
            ->all();

        return $this->render('top-authors', [
            'topAuthors' => $topAuthors,
            'year' => $year,
        ]);
    }
}
