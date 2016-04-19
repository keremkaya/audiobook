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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/assets/global/plugins/font-awesome/css/font-awesome.min.css',
        'css/assets/global/plugins/simple-line-icons/simple-line-icons.min.css',
        'css/assets/global/plugins/bootstrap/css/bootstrap.min.css',
        'css/assets/global/plugins/uniform/css/uniform.default.css',
        'css/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        'css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
        'css/assets/global/plugins/morris/morris.css',
        'css/assets/global/plugins/fullcalendar/fullcalendar.min.css',
        'css/assets/global/plugins/jqvmap/jqvmap/jqvmap.css',
        'css/assets/global/css/components-rounded.min.css',
        'css/assets/global/css/plugins.min.css',
        'css/assets/layouts/layout4/css/layout.min.css',
        'css/assets/layouts/layout4/css/themes/light.min.css',
        'css/assets/layouts/layout4/css/custom.min.css',
    ];
    public $js = [
    	'css/assets/global/plugins/bootstrap/js/bootstrap.min.js',
    	'css/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
    	'css/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
    	'css/assets/global/plugins/jquery.blockui.min.js',
    	'css/assets/global/plugins/uniform/jquery.uniform.min.js',
    	'css/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
    	'css/assets/global/plugins/bootstrap-daterangepicker/moment.min.js',
    	'css/assets/global/plugins/bootstrap-daterangepicker/moment.min.js',
    	'css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js',
    	'css/assets/global/plugins/morris/morris.min.js',
    	'css/assets/global/plugins/morris/raphael-min.js',
    	'css/assets/global/plugins/counterup/jquery.waypoints.min.js',
    	'css/assets/global/plugins/counterup/jquery.counterup.min.js',
    	'css/assets/global/plugins/amcharts/amcharts/amcharts.js',
    	'css/assets/global/plugins/amcharts/amcharts/serial.js',
    	'css/assets/global/plugins/amcharts/amcharts/pie.js',
    	'css/assets/global/plugins/amcharts/amcharts/radar.js',
    	'css/assets/global/plugins/amcharts/amcharts/themes/light.js',
    	'css/assets/global/plugins/amcharts/amcharts/themes/patterns.js',
    	'css/assets/global/plugins/amcharts/amcharts/themes/chalk.js',
    	'css/assets/global/plugins/amcharts/ammap/ammap.js',
    	'css/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js',
    	'css/assets/global/plugins/amcharts/amstockcharts/amstock.js',
    	'css/assets/global/plugins/fullcalendar/fullcalendar.min.js',
    	'css/assets/global/plugins/flot/jquery.flot.min.js',
    	'css/assets/global/plugins/flot/jquery.flot.resize.min.js',
    	'css/assets/global/plugins/flot/jquery.flot.categories.min.js',
    	'css/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js',
    	'css/assets/global/plugins/jquery.sparkline.min.js',
    	'css/assets/global/scripts/app.min.js',
    	'css/assets/pages/scripts/dashboard.min.js',
    	'css/assets/layouts/layout4/scripts/layout.min.js',
    	'css/assets/layouts/layout4/scripts/demo.min.js',
    	'css/assets/layouts/global/scripts/quick-sidebar.min.js',
    	
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
