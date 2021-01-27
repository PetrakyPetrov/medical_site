<?php
$reqfile = $_GET['file'];
if(file_exists($reqfile)){
	readfile($reqfile);
	exit;
}
if($reqfile == 'compiled.js'){
	$basePath = './';
} else {
	header("HTTP/1.0 404 Not Found");
	die();
}

$basePath = './';

$mergeFiles = array(
	"jquery-1.10.2.js",
	"bootstrap.js",
	"jquery-ui.js",
	"../third_party/light_gallery/js/lightgallery.min.js",

);

$files = array();
//header ("Content-Type: text/css; charset: UTF-8");
$c = '';
foreach($files as $file){
	$c .= file_get_contents($basePath . $file);
}

$m = '';
foreach($mergeFiles as $file){
	$m .= file_get_contents($basePath . $file);
}
require_once 'jsmin.php';
//$result = JSMin::minify($c);
file_put_contents('./' . $reqfile, $m . $c);
echo $m . $c;
exit;