<?php
	define("STREAM_LIB_DIR", str_replace('//','/',dirname(__FILE__)) . "/StreamProviders");

	$streamFiles = array();

	if ($handle = opendir(STREAM_LIB_DIR)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != basename(__FILE__) && strpos($file, ".php") > 0) {
					$streamFiles[] = $file;
			}
		}
		closedir($handle);
	}

	foreach($streamFiles as $file){
		require_once(STREAM_LIB_DIR . "/" . $file);
	}
?>