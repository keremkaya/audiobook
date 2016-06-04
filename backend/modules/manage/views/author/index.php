<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\metronic\widgets\Portlet;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\author\models\AuthorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php Portlet::begin(['icon' => 'fa fa-bell-o','title' => 'Title Portlet',]);?>


   
   <?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'id'=> 'userGrid',
	'columns' => [
		['class' => 'yii\grid\CheckBoxColumn'],
		'id',
            'name',
            'info',
		['class' => 'backend\modules\metronic\widgets\ActionColumn'],
		 
	],
]);?>
<?php Portlet::end([]);?>
    
</div>
