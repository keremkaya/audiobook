<?php

namespace common\components;

use Yii;

class Request extends \yii\web\Request {
    public $web;
    public $aliasUrl;

    public function getBaseUrl(){
 	
        return str_replace($this->web, "", parent::getBaseUrl()) . $this->aliasUrl;
    }
    
    /*public function resolve()
    {
    	$result = Yii::$app->getUrlManager()->parseRequest($this);
    	
    	
    	$result = str_replace($result[0], "admin/$result[0]", $result);
    	
    	if ($result !== false) {
    		list ($route, $params) = $result;
    		if ($this->getQueryParams() === null) {
    			$_GET = $params + $_GET; // preserve numeric keys
    		} else {
    			$this->setQueryParams($params + $this->getQueryParams());
    		}
    		return [$route, $this->getQueryParams()];
    	} else {
    		throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    	}
    }*/

    /*public function resolvePathInfo(){
    	
    	echo 'getUrl :' . $this->getUrl() . '<br>';
    	echo 'alias :' . $this->aliasUrl . '<br>';
    	
    	return parent::resolvePathInfo();
    	
        if($this->getUrl() === $this->aliasUrl){
        	echo 'true';
            return "";
        }else{
        	echo 'false';
            return parent::resolvePathInfo();
        }
    }*/
}