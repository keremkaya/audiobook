<?php

/**
 * Email change email view.
 *
 * @var \yii\web\View $this View
 * @var \diginova\user\models\frontend\Email $model Model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::toRoute(['/admin/site/auth/confirm', 'key' => $user->auth_key], true); ?>
<p>Hello,</p>
<p>Follow the link below to confirm your new e-mail:</p>
<p><?= Html::a(Html::encode($url), $url) ?></p>