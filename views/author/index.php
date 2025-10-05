<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Добавить автора', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'full_name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}',
            ],
        ],
    ]); ?>
</div>