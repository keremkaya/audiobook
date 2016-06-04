<?php

use backend\modules\metronic\widgets\Portlet;
use backend\modules\metronic\widgets\DatePicker;
use backend\models\User;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

	<?php Portlet::begin(['icon' => 'fa fa-bell-o','title' => 'Title Portlet',]);?>

     <?php 
     $model = new User();
    GridView::widget([
	'dataProvider' => $provider,
	'filterModel' => $searchModel,
	'id'=> 'userGrid',
	'pjax' => true,
	'columns' => [
		['class' => 'yii\grid\CheckBoxColumn'],
		'id',
		'username',
		'email',
		['class' => 'diginova\theme\widgets\ActionColumn'],
		 
	],
]);?>

   <?php Portlet::end([]);?>
</div>
