<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
	    'css/assets/plugins/font-awesome/css/font-awesome.min.css',
	    'css/assets/plugins/bootstrap/css/bootstrap.min.css',
	    'css/assets/pages/css/animate.css',
	    'css/assets/plugins/fancybox/source/jquery.fancybox.css',
	    'css/assets/owl.carousel.css',
	    'css/assets/pages/css/components.css',
	    'css/assets/pages/css/components.css',
	    'css/assets/pages/css/slider.css',
	    'css/assets/pages/css/style-shop.css',
	    'css/assets/corporate/css/style.css',
	    'css/assets/corporate/css/style-responsive.css',
	    'css/assets/corporate/css/themes/red.css',
	    'css/assets/corporate/css/custom.css',
    ];
    public $js = [
	    'css/assets/plugins/jquery.min.js', 
	    'css/assets/plugins/jquery-migrate.min.js', 
	    'css/assets/plugins/bootstrap/js/bootstrap.min.js' ,
	    'css/assets/corporate/scripts/back-to-top.js', 
	    'css/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js' ,
	    'css/assets/plugins/fancybox/source/jquery.fancybox.pack.js' ,
	    'css/assets/owl.carousel.min.js' ,
	    'css/assets/plugins/zoom/jquery.zoom.min.js' ,
	    'css/assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js',
	    'css/assets/corporate/scripts/layout.js' ,
	    'css/assets/pages/scripts/bs-carousel.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
