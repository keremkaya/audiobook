<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class' => 'login-form']]); ?>
	<h3 class="form-title">Login to your account</h3>
	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		<span> Enter any username and password. </span>
    </div>
 
	<?= $form->field($model, 'username')->textInput(['autofocus' => true,'class' => 'form-control placeholder-no-fix','autocomplete' => 'off']) ?>

	<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control placeholder-no-fix']); ?>
	
	<div class="form-actions">
	    <?php   
	    		echo $form->beginField($model, 'rememberMe');
	    		echo Html::activeCheckbox($model, 'rememberMe');
	    		echo Html::submitButton('Login', ['class' => 'btn green pull-right', 'name' => 'login-button']);
	    		echo $form->endField();
	    ?>
    </div>
	<div class="login-options">
                    <h4>Or login with</h4>
                    <ul class="social-icons">
                        <li>
                            <a class="facebook" data-original-title="facebook" href="javascript:;"> </a>
                        </li>
                        <li>
                            <a class="twitter" data-original-title="Twitter" href="javascript:;"> </a>
                        </li>
                        <li>
                            <a class="googleplus" data-original-title="Goole Plus" href="javascript:;"> </a>
                        </li>
                        <li>
                            <a class="linkedin" data-original-title="Linkedin" href="javascript:;"> </a>
                        </li>
                    </ul>
    </div>
     <div class="forget-password">
                    <h4>Forgot your password ?</h4>
                    <p> no worries, click
                        <a href="javascript:;" id="forget-password"> here </a> to reset your password. </p>
                </div>
     <div class="create-account">
                    <p> Don't have an account yet ?&nbsp;
                        <a href="javascript:;" id="register-btn"> Create an account </a>
                    </p>
     </div>
<?php ActiveForm::end(); ?>



