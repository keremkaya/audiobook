<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\author\models\Author */

$this->title = 'Update Author: ' . $model->author_id;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->author_id, 'url' => ['view', 'id' => $model->author_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="author-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
