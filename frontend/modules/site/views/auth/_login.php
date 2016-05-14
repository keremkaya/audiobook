<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use diginova\site\Module;
use diginova\site\helpers\GetPath;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Module::t ( 'site', 'Login' );
$this->params ['breadcrumbs'] [] = $this->title;

$form = ActiveForm::begin(['id' => 'login-form']); 
$data['email'] = $form->field($model, 'email')->textInput(['placeholder' => Module::t ( 'site', 'E-Mail' )]);
$data['password'] =  $form->field($model, 'password')->passwordInput(['placeholder' => Module::t ( 'site', 'Password' )]);
$data['rememberMe'] = $form->field($model, 'rememberMe')->checkbox();
$data['button'] = Html::submitButton('Login <i class="fa fa-angle-double-right"></i> ', ['class' => 'btn blue pull-right', 'name' => 'login-button']);

$data['resetPasswordUrl'] = Url::to(['/site/auth/request-password-reset']);

echo $this->render(GetPath::getPath('backend', 'site', 'auth', 'login'), $data);
ActiveForm::end(); 


?>