<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "ТОП-10 авторов за $year";
?>
<h1>ТОП-10 авторов за <?= Html::encode($year) ?></h1>

<form method="get" class="form-inline mb-3">
    <label for="year" class="mr-2">Год:</label>
    <input type="number" 
           id="year" 
           name="year" 
           value="<?= Html::encode($year) ?>" 
           min="1900" 
           max="<?= date('Y') ?>" 
           class="form-control" 
           style="width: 120px;">
    <button type="submit" class="btn btn-secondary ml-2">Показать</button>
</form>

    <?php if (empty($topAuthors)): ?>
        <p>Нет данных за <?= $year ?> год.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Место</th>
                    <th>Автор</th>
                    <th>Книг выпущено</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topAuthors as $index => $author): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= Html::encode($author['full_name']) ?></td>
                    <td><?= (int)$author['book_count'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p>
        <?= Html::a('← Назад на главную', ['site/index']) ?>
    </p>
</div>