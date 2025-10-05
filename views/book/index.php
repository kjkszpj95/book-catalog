<?php
use yii\helpers\Html;
use yii\grid\GridView;

use yii\helpers\ArrayHelper;


$this->title = 'Каталог книг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            'year',
            'isbn',
            [
                'label' => 'Авторы',
                'value' => function ($model) {
                return implode(', ', ArrayHelper::getColumn($model->authors, 'full_name'));
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}',
            ],
        ],
    ]); ?>
</div>