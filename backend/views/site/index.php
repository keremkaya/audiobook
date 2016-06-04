<?php

use backend\modules\metronic\widgets\Portlet;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

	<?php Portlet::begin(['icon' => 'fa fa-bell-o','title' => 'Title Portlet',]);?>

     <?php echo DatePicker::widget([
      'language' => 'tr',
      'clientOptions' => [
          'dateFormat' => 'yy-mm-dd',
      ],
  ]);?>

   <?php Portlet::end([]);?>
</div>
