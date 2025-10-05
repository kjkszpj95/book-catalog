<?php

namespace app\controllers;

use Yii;
use app\models\Book;
use app\models\Author;
use app\models\Subscription;
use app\models\BookAuthor;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // Гости могут только смотреть
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['?', '@'],
                    ],
                    // Авторизованные — полный CRUD
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find()->with('authors'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Book();
        $authorIds = [];

        if ($model->load(Yii::$app->request->post())) {
            $postData = Yii::$app->request->post();
            $authorIds = $postData['Book']['authorIds'] ?? [];
            if ($model->save()) {
                $this->saveBookAuthors($model->id, $authorIds);
                $this->notifySubscribers($model, $authorIds);
                Yii::$app->session->setFlash('success', 'Книга успешно создана.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $authors = Author::find()->all();
        return $this->render('create', compact('model', 'authors', 'authorIds'));
    }

    public function actionUpdate($id)
{
    $model = $this->findModel($id);

    $authorIds = ArrayHelper::getColumn($model->authors, 'id', []);

    if ($model->load(Yii::$app->request->post())) {
        $postData = Yii::$app->request->post();
        $newAuthorIds = $postData['Book']['authorIds'] ?? [];

        if (!is_array($newAuthorIds)) {
            $newAuthorIds = $newAuthorIds ? [$newAuthorIds] : [];
        }

        if ($model->save()) {
            $this->saveBookAuthors($model->id, $newAuthorIds);
            Yii::$app->session->setFlash('success', 'Книга успешно обновлена.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    $authors = Author::find()->all();
    return $this->render('update', compact('model', 'authors', 'authorIds'));
}

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Книга удалена.');
        return $this->redirect(['index']);
    }


    private function saveBookAuthors($bookId, $authorIds)
    {

        BookAuthor::deleteAll(['book_id' => $bookId]);

        foreach ($authorIds as $authorId) {
            $ba = new BookAuthor();
            $ba->book_id = $bookId;
            $ba->author_id = (int)$authorId;
            $ba->save(false); 
        }
    }

  
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }


        private function notifySubscribers($book, $authorIds)
        {
           

        if (empty($authorIds)) return;

            $subscriptions = Subscription::find()
                ->where(['author_id' => $authorIds])
                ->asArray()
                ->all();
            foreach ($subscriptions as $sub) {
                $message = "Новая книга автора с ID {$sub['author_id']}: {$book->title}";
                $this->sendSms($sub['phone'], $message);
            }
        }

    private function sendSms($to, $text)
    {
        $apiKey = $_ENV['SMSPILOT_API_KEY'] ?? 'demo';
        $url = "https://smspilot.ru/api.php?send=" . urlencode($text) . "&to=$to&apikey=$apiKey&format=json";
        @file_get_contents($url);
    }
}