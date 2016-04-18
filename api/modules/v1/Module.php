<?php
namespace api\modules\v1;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * DigiNova API V1 Module
 * 
 * @author U�ur YILDIZ <yildiz@diginova.com.tr> 
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init()
    {
        parent::init(); 

        \Yii::$app->user->enableSession = false;
    }

    public function behaviors()
    {
    	$behaviors = parent::behaviors();
    	$behaviors['authenticator'] = [
    		'class' => CompositeAuth::className(),
    		'authMethods' => [
    			HttpBasicAuth::className(),
    			HttpBearerAuth::className(),
    			QueryParamAuth::className(),
    		],
    	];
    	return $behaviors;
    }
}