<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
        'css/assets/global/plugins/font-awesome/css/font-awesome.min.css',
        'css/assets/global/plugins/simple-line-icons/simple-line-icons.min.css',
        'css/assets/global/plugins/bootstrap/css/bootstrap.min.css',
        'css/assets/global/plugins/uniform/css/uniform.default.css',
        'css/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        'css/assets/global/plugins/select2/css/select2.min.css',
        'css/assets/global/plugins/select2/css/select2-bootstrap.min.css',
        'css/assets/global/css/components.min.css',
        'css/assets/global/css/plugins.min.css',
        'css/assets/pages/css/login-4.min.css',
    ];
    public $js = [
    	'css/assets/global/plugins/bootstrap/js/bootstrap.min.js',
    	'css/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
    	'css/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
    	'css/assets/global/plugins/jquery.blockui.min.js',
    	'css/assets/global/plugins/uniform/jquery.uniform.min.js',
    	'css/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
    	'css/assets/global/plugins/jquery-validation/js/jquery.validate.min.js',
    	'css/assets/global/plugins/jquery-validation/js/additional-methods.min.js',
    	'css/assets/global/plugins/select2/js/select2.full.min.js',
    	'css/assets/global/plugins/backstretch/jquery.backstretch.min.js',
    	'css/assets/global/scripts/app.min.js',
    	'css/assets/pages/scripts/login-4.min.js',
    	
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
