<?php
date_default_timezone_set('Europe/Moscow');
include __DIR__.'/vendor/autoload.php';

require('config/router.config.php');
require('config/db.config.php');
require('config/templates.config.php');

$debug = 0;

if($debug){
print_r('<pre>');
print_r($routerMatch);
print_r('</pre>');
}

if($router_C == 200){
	include("page/".rTarget.".php");
}
else{
	print("error#".$router_C);
}

