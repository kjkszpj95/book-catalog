<?php

namespace app\controllers;

use Yii;
use app\models\Author;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\Subscription;

class AuthorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['?', '@'],
                    ],
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
            'query' => Author::find(),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Обработка подписки
        if (Yii::$app->request->isPost && Yii::$app->user->isGuest) {
            $phone = trim(Yii::$app->request->post('phone'));
            if ($phone) {
                $sub = new Subscription();
                $sub->author_id = $model->id;
                $sub->phone = preg_replace('/\D/', '', $phone);
                if ($sub->save()) {
                    Yii::$app->session->setFlash('success', 'Подписка оформлена!');
    
                }
                }
            }
             return $this->render('view', ['model' => $model]);
        }

       
    

    public function actionCreate()
    {
        $model = new Author();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Автор успешно создан.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Автор успешно обновлён.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Автор удалён.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }

}