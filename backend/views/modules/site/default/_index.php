<?php 
use diginova\site\helpers\GetPath;

$this->title = 'Dashboard';
$this->params['pageTitle'] = 'Dashboard';
$this->params['pageDesc'] = 'manage all application';
echo $this->render(GetPath::getPath('backend', 'site', 'default', 'index'));