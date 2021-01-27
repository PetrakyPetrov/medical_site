<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function admin_url($url){
	return site_url('admin/' . $url);
}

function encode_ip ($ip) {
	$d = explode('.', $ip);
	if (count($d) == 4) return sprintf('%02x%02x%02x%02x', $d[0], $d[1], $d[2], $d[3]);
 
	$d = explode(':', preg_replace('/(^:)|(:$)/', '', $ip));
	$res = '';
	foreach ($d as $x)
		$res .= sprintf('%0'. ($x == '' ? (9 - count($d)) * 4 : 4) .'s', $x);
	return $res;
}

function getClientIp($checkProxy = true) {
	if ($checkProxy && $_SERVER['HTTP_CLIENT_IP'] != null) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} else if ($checkProxy && $_SERVER['HTTP_X_FORWARDED_FOR'] != null) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;
}


/* Използва се за CSS, JS и др локални ресурси */
function asset_url($url){
	return site_url('assets/' . $url);
}

function uploads_url($url){
	return site_url('uploads/' . $url);
}

function remote_asset_url($url){
	return 'http://updev.union.lcl/string-exhange/design/assets/' . $url;
}

/* Използва се за изображения на обекти */
function cdn_url($url){
	return site_url('data/' . $url);
	//return 'http://keyfiseyir.local/public/' . $url;
}