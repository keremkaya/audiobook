<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'book_id') ?>

    <?= $form->field($model, 'book_name') ?>

    <?= $form->field($model, 'book_genre') ?>

    <?= $form->field($model, 'book_release_date') ?>

    <?= $form->field($model, 'book_release_number') ?>

    <?php // echo $form->field($model, 'book_publisher') ?>

    <?php // echo $form->field($model, 'voice_actor_id') ?>

    <?php // echo $form->field($model, 'book_rating') ?>

    <?php // echo $form->field($model, 'book_duration') ?>

    <?php // echo $form->field($model, 'book_price') ?>

    <?php // echo $form->field($model, 'author_id') ?>

    <?php // echo $form->field($model, 'book_picture') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
