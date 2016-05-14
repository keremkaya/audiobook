<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\assets\AppAsset;

AppAsset::register ( $this );
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
    
</head>
<body class="page-container-bg-solid page-sidebar-closed-hide-logo page-header-fixed">
	<?php $this->beginBody()?>
	<!-- BEGIN HEADER -->
	<div class="page-header navbar navbar-fixed-top">
		<!-- BEGIN HEADER INNER -->
		<div class="page-header-inner">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="index.html"> <img
					src="/admin/css/assets/layouts/layout4/img/logo-light.png" alt="logo"
					class="logo-default">
				</a>
				<div class="menu-toggler sidebar-toggler">
					<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
				</div>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler responsive-toggler"
				data-toggle="collapse" data-target=".navbar-collapse"> </a>
			<!-- END RESPONSIVE MENU TOGGLER -->
		
			<!-- BEGIN PAGE TOP -->
			<div class="page-top">
				<!-- BEGIN HEADER SEARCH BOX -->
				<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
				<form class="search-form" action="page_general_search_2.html"
					method="GET">
					<div class="input-group">
						<input type="text" class="form-control input-sm"
							placeholder="Search..." name="query"> <span
							class="input-group-btn"> <a href="javascript:;"
							class="btn submit"> <i class="icon-magnifier"></i>
						</a>
						</span>
					</div>
				</form>
				<!-- END HEADER SEARCH BOX -->
				<!-- BEGIN TOP NAVIGATION MENU -->
				<div class="top-menu">
					<ul class="nav navbar-nav pull-right">
						<!-- BEGIN USER LOGIN DROPDOWN -->
						<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
						<li class="dropdown dropdown-user"><a href="javascript:;"
							class="dropdown-toggle" data-toggle="dropdown"
							data-hover="dropdown" data-close-others="true"
							aria-expanded="false"> <span
								class="username username-hide-on-mobile"> Nick </span> <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
								<img alt="" class="img-circle"
								src="/admin/css/assets/layouts/layout4/img/avatar9.jpg">
						</a>
							<ul class="dropdown-menu dropdown-menu-default">
								<li><a href="page_user_profile_1.html"> <i class="icon-user"></i>
										My Profile
								</a></li>
								<li><a href="app_calendar.html"> <i class="icon-calendar"></i>
										My Calendar
								</a></li>
								<li><a href="app_inbox.html"> <i class="icon-envelope-open"></i>
										My Inbox <span class="badge badge-danger"> 3 </span>
								</a></li>
								<li><a href="app_todo_2.html"> <i class="icon-rocket"></i> My
										Tasks <span class="badge badge-success"> 7 </span>
								</a></li>
								<li class="divider"></li>
								<li><a href="page_user_lock_1.html"> <i class="icon-lock"></i>
										Lock Screen
								</a></li>
								<li><a href="page_user_login_1.html"> <i class="icon-key"></i>
										Log Out
								</a></li>
							</ul></li>
						<!-- END USER LOGIN DROPDOWN -->
					</ul>
				</div>
				<!-- END TOP NAVIGATION MENU -->
			</div>
			<!-- END PAGE TOP -->
		</div>
		<!-- END HEADER INNER -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN HEADER & CONTENT DIVIDER -->
	<div class="clearfix"></div>
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar-wrapper">
			<!-- BEGIN SIDEBAR -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<div class="page-sidebar navbar-collapse collapse">
				<!-- BEGIN SIDEBAR MENU -->
				<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
				<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
				<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
				<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
				<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
				<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
				<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu"
					data-keep-expanded="false" data-auto-scroll="true"
					data-slide-speed="200" data-height="840">
					<li class="nav-item start active"><a href="javascript:;"
						class="nav-link nav-toggle"> <i class="icon-home"></i> <span
							class="title">Dashboard</span> <span class="selected"></span> <span
							class="arrow"></span>
					</a>
						<ul class="sub-menu" style="display: none;">
							<li class="nav-item start active open"><a href="index.html"
								class="nav-link "> <i class="icon-bar-chart"></i> <span
									class="title">Dashboard 1</span> <span class="selected"></span>
							</a></li>
							<li class="nav-item start "><a href="dashboard_2.html"
								class="nav-link "> <i class="icon-bulb"></i> <span class="title">Dashboard
										2</span> <span class="badge badge-success">1</span>
							</a></li>
							<li class="nav-item start "><a href="dashboard_3.html"
								class="nav-link "> <i class="icon-graph"></i> <span
									class="title">Dashboard 3</span> <span
									class="badge badge-danger">5</span>
							</a></li>
						</ul></li>
					<li class="heading">
						<h3 class="uppercase">Features</h3>
					</li>
					<li class="nav-item"><a href="javascript:;"
						class="nav-link nav-toggle"> <i class="icon-diamond"></i> <span
							class="title">UI Features</span> <span class="arrow"></span>
					</a>
						<ul class="sub-menu" style="display: none;">
							<li class="nav-item  "><a href="ui_datepaginator.html"
								class="nav-link "> <span class="title">Date Paginator</span>
							</a></li>
							<li class="nav-item  "><a href="ui_nestable.html"
								class="nav-link "> <span class="title">Nestable List</span>
							</a></li>
						</ul></li>	
				</ul>
				<!-- END SIDEBAR MENU -->
			</div>
			<!-- END SIDEBAR -->
		</div>
		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<!-- BEGIN CONTENT BODY -->
			<div class="page-content" style="min-height: 907px">
				<!-- BEGIN PAGE HEAD-->
				<div class="page-head">
					<!-- BEGIN PAGE TITLE -->
					<div class="page-title">
						<h1>
							Dashboard <small>dashboard &amp; statistics</small>
						</h1>
					</div>
					<!-- END PAGE TITLE -->
				
				</div>
				<!-- END PAGE HEAD-->
				<!-- BEGIN PAGE BREADCRUMB -->
				<ul class="page-breadcrumb breadcrumb">
					<li><a href="index.html">Home</a> <i class="fa fa-circle"></i></li>
					<li><span class="active">Dashboard</span></li>
				</ul>
				<?= $content; ?>

			</div>
			<!-- END CONTENT BODY -->
		</div>
		<!-- END CONTENT -->
	
	</div>
	<div class="page-footer">
		<div class="page-footer-inner">
			2014 © Metronic by keenthemes. <a
				href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes"
				title="Purchase Metronic just for 27$ and get lifetime updates for free"
				target="_blank">Purchase Metronic!</a>
		</div>

	</div>
	<div class="scroll-to-top" style="display: none;">
		<i class="icon-arrow-up"></i>
	</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage()?>








