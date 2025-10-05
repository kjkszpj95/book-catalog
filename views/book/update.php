<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$this->title = 'Редактировать книгу';
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="book-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
        'authorIds' => $authorIds,
    ]) ?>
</div>