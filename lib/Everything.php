<?php
	define("LIB_DIR", str_replace('//','/',dirname(__FILE__)));

	$files = array();

	if ($handle = opendir(LIB_DIR)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != basename(__FILE__) && strpos($file, ".php") > 0) {
					$files[] = $file;
			}
		}
		closedir($handle);
	}

	foreach($files as $file){
		require_once(LIB_DIR . "/" . $file);
	}
?>