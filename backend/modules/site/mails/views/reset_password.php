<?php

/**
 * Email change email view.
 *
 * @var \yii\web\View $this View
 * @var \diginova\user\models\frontend\Email $model Model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::toRoute(['/site/auth/reset-password', 'token' => $user->password_reset_token], true); ?>
<p>Hello,</p>
<p>Şifre sıfırlama talebinde bulundunuz. Eğer bu işlemi siz gerçekleştirmediyseniz bu maili dikkate almayınız. Aşağıdaki link'e tıklayarak şifrenizi sıfırlayabilirsiniz</p>
<p><?= Html::a(Html::encode($url), $url) ?></p>
