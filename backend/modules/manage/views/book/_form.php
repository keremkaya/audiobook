<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'book_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_genre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_release_date')->textInput() ?>

    <?= $form->field($model, 'book_release_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_publisher')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'voice_actor_id')->textInput() ?>

    <?= $form->field($model, 'book_rating')->textInput() ?>

    <?= $form->field($model, 'book_duration')->textInput() ?>

    <?= $form->field($model, 'book_price')->textInput() ?>

    <?= $form->field($model, 'author_id')->dropDownList(ArrayHelper::map($authors, 'author_id', 'author_name')) //dropdownda listeleme ?>  

    <?= $form->field($model, 'book_picture')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
