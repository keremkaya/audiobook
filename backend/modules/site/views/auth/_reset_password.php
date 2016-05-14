<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use diginova\site\Module;
use diginova\site\helpers\GetPath;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */


$form = ActiveForm::begin(['id' => 'reset-password']); 
$data['newpassword'] =  $form->field($model, 'newpassword')->passwordInput(['placeholder' => Module::t ( 'site', 'New Password' )]);
$data['repassword'] =  $form->field($model, 'repassword')->passwordInput(['placeholder' => Module::t ( 'site', 'Again New Password' )]);
$data['button'] = Html::submitButton('Okey <i class="fa fa-envelope"></i> ', ['class' => 'btn blue pull-right', 'name' => 'login-button']);

echo $this->render(GetPath::getPath('backend', 'site', 'auth', 'reset_password'), $data);
ActiveForm::end();
?>