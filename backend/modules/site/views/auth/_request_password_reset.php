<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use diginova\site\Module;
use diginova\site\helpers\GetPath;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Module::t ( 'site', 'Reset Password' );
$this->params ['breadcrumbs'] [] = $this->title;

$form = ActiveForm::begin(['id' => 'request-password-reset']); 
$data['email'] = $form->field($model, 'email')->textInput(['placeholder' => Module::t ( 'site', 'E-Mail' )]);
$data['button'] = Html::submitButton('Send <i class="fa fa-envelope"></i> ', ['class' => 'btn blue pull-right', 'name' => 'login-button']);

echo $this->render(GetPath::getPath('backend', 'site', 'auth', 'request_password_reset'), $data);
ActiveForm::end();
?>