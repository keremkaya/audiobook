<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
    	'site' => [
    		'class' => 'app\modules\site\Module',
    	],
    	'user' => [
    		 'class' => 'app\modules\user\Module',
    	],
    	'manage' => [
    		 'class' => 'app\modules\manage\Module',
    	],
    	
    ],
    'components' => [
    	
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/site/auth/login'],
        ],
        'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'Ws_5fvKwQV0EaWpFgpgU0x7aK5BsKfPY',
	        'class' => 'common\components\Request',
	        'web'=> '/backend/web',
	        'aliasUrl' => '/admin'
        ],
        'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
       /* 'view' => [
	        'theme' => [
		        'pathMap' => [
			        '@app/views' => '@backend',
			        '@app/modules' => '@backend/views/modules',
		        ],
		        
	        ],
        
        ],*/
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
