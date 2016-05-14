<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--  <div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
        

           
        </div>
    </div>
</div>
-->
            <div class="content-form-page">
            <?php $form = ActiveForm::begin(['id' => 'form-signup','options' => ['class' => 'form-horizontal form-without-legend']]); ?>
             	<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
 				<?= $form->field($model, 'email') ?>
                <?= Html::input('text','password');?>
                
                <div class="row">
                  <div class="col-lg-8 col-md-offset-2 padding-left-0 padding-top-20">
                  <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    
                  </div>
                </div>
               <?php ActiveForm::end(); ?>
            </div>
          
            
