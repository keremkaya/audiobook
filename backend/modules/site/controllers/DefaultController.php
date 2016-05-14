<?php
namespace app\modules\site\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {

		return $this->render('index');
    }
}
