<?php
 
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
 
$config = [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'   // here is our v1 modules
        ],
		'forum' => [
    		 'class' => 'ibrahim4593\forum\Module',
    	],
		
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'request' => [
       		// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        	'cookieValidationKey' => 'Ws_5fvKwQV0EaWpFgpgU0x7aK5BsKfPY',
        	'class' => 'common\components\Request',
        	'web'=> '/api/web',
        	'aliasUrl' => '/api'
        ],
        'authManager' => [
        'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
            	[
            	'class' => 'yii\rest\UrlRule',
	            	'controller' => [
	            		 'v1/sample',
						],				
	            	'tokens' => ['{id}' => '<id:\\w+>']
				],
				 
            ]  
        ]
            		
        		
    ],
    'params' => $params,
        	
];

if (!YII_ENV_TEST) {
	// configuration adjustments for 'dev' environment
	//    $config['bootstrap'][] = 'debug';
	//    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
