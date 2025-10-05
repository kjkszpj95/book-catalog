<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->isGuest ? '' : Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Yii::$app->user->isGuest ? '' : Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'year',
            'isbn',
            'description:ntext',
            'cover_url:url',
            [
                'label' => 'Авторы',
                'value' => implode(', ', ArrayHelper::getColumn($model->authors, 'full_name')),
            ],
        ],
    ]) ?>
</div>