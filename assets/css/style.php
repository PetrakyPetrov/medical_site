<?php
$reqfile = $_GET['file'];
if(file_exists($reqfile)){
	header ("Content-Type: text/css; charset: UTF-8");
	readfile($reqfile);
	exit;
}
if($reqfile == 'compiled.css'){
	$basePath = './';
} else {
	header("HTTP/1.0 404 Not Found");
	die();
}


$files = array(
	"google-fonts.css",
	"bootstrap.v3.css",
	"main.css",
	"../third_party/stroke-icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css",
	"../third_party/stroke-icons/pe-icon-7-stroke/css/helper.css",
	"font-awesome.css",
);
header("Content-Type: text/css; charset: UTF-8");
$c = '';
foreach($files as $file){
	$c .= @file_get_contents($basePath . $file);
}
require_once 'cssmin.php';
$result = '/* ' . $reqfile . ' */' . CssMin::minify(($c));
file_put_contents('./' . $reqfile, $result);
echo $result;
exit;
