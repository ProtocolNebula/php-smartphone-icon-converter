<?php
include APP_DIR . 'lib/thumbs.php';
include APP_DIR . 'lib/pclzip.lib.php';
	
function downloadZip($file, $nameToShow, $delete = true) {
	
	header("Content-type: application/zip"); 
	header("Content-Disposition: attachment; filename=$nameToShow");
	header("Content-length: " . filesize($file));
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	readfile($file);
	unlink($file); 
	die();
}