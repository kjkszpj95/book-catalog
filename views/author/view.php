<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->isGuest ? '' : Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Yii::$app->user->isGuest ? '' : Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => ['confirm' => 'Удалить автора?'],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'full_name',
        ],
    ]) ?>

   <?php if (Yii::$app->user->isGuest): ?>
    <h3>Подписаться на новые книги этого автора</h3>
    <form method="post">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
        <input type="text" name="phone" placeholder="Ваш номер телефона" required>
        <button type="submit">Подписаться</button>
    </form>
<?php endif; ?>
</div>