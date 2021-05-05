<?php
function path2url($file, $Protocol='http://') {
   return $Protocol.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
}

function url2path($url, $Protocol='http://') {
	return $_SERVER['DOCUMENT_ROOT'].str_replace($Protocol.$_SERVER['HTTP_HOST'],'',$url);
}

?>