<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<div class="book-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'year')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'cover_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authorIds')->dropDownList(
    ArrayHelper::map($authors, 'id', 'full_name'),
    [
        'multiple' => true,
        'class' => 'form-control',
        'value' => $authorIds,
    ]
    )->label('Авторы') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>