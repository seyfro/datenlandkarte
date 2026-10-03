<?php

function art_get_array_value($arr = array(), $key = null, $def = false){
	if (is_array($arr) && isset($arr[$key])){
		return $arr[$key];
	}
	return $def;
}

function art_is_empty_html($str){
	return (!is_string($str) || strlen(str_replace(array('&nbsp;', ' ', "\n", "\r", "\t"), '', $str)) == 0);
}

function art_trim_long_str($str, $len = 50, $sep = ' '){
	//$words = split($sep, $str);
	$words = explode($sep, $str);
	$wcount = count($words);
	while( $wcount > 0 && strlen(join($sep, array_slice($words, 0, $wcount))) > $len) $wcount--;
	if ($wcount != count($words)) {
		$str = join($sep, array_slice($words, 0, $wcount)) . '&hellip;';
	}
	return $str;
}


function art_get_current_url() {
	$pageURL = 'http';
	if (is_ssl()) {
		$pageURL .= 's';
	}
	$pageURL .= '://' . $_SERVER['SERVER_NAME'];
	if ($_SERVER['SERVER_PORT'] != '80') {
		$pageURL .= ':' . $_SERVER["SERVER_PORT"];
	} 
	$pageURL .= $_SERVER["REQUEST_URI"];
	return $pageURL;
}

function art_remove_last_slash($url) {
	$len = strlen($url);
	if ( $len > 0 && $url[$len-1] == '/') {
		$url =  substr($url, 0, -1);
	}
	return $url;
}

function art_is_current_url($url) {
	// remove # anchor 
	if (strpos( $url, '#' )) {
		$url =  substr($url, 0, strpos( $url, '#'));
	}
	
	$url = art_remove_last_slash($url);
	$cur = art_remove_last_slash(art_get_current_url());
	
	// compare
	return ($cur == $url);
}

function art_prepare_attr($attr = array()) {
	$attr = wp_parse_args($attr);
	if (count($attr)  == 0) return '';
	$result = '';
	foreach($attr as $name => $value){
		if(empty($name) || empty($value)) continue;
		$result .= ' ' . strtolower($name) . '="' . esc_attr($value) . '"';
	}
	return $result;
}
