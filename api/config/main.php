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
        ]
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
				[
				'class' => 'yii\rest\UrlRule',
				'controller' => [
					'v1/user',
	            	'v1/formelement',
	            	'v1/form',
	            	'v1/formrecord',
	            	'v1/formdata',
				],
				'extraPatterns'=>[
					'GET sample' => 'getsamples',
					'POST get-element-value' => 'get-element-value',
					'GET get-form-search-element' => 'get-form-search-element',
					'POST get-form-records' => 'get-form-records',
					'POST update-element-value' => 'update-element-value',
					'GET get-child-forms' => 'get-child-forms',
					'POST form-control' => 'form-control',
					'GET send-form-to-role' => 'send-form-to-role',
					'GET get-form-records-to-role' => 'get-form-records-to-role',
					'POST child-form-create' => 'child-form-create',
					'POST flow-up' => 'flow-up',
					'POST file-upload' => 'file-upload',
					'GET  file-download' => 'file-download',
					'GET  get-roles' => 'get-roles',
					'POST  test' => 'test',
						],
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
