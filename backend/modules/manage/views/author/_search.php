<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\author\models\AuthorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="author-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'author_name') ?>

    <?= $form->field($model, 'author_info_details') ?>

    <?= $form->field($model, 'author_picture') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
