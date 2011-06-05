<?php
	require_once("lib/Everything.php");
	
	$nickname = (isset($_GET["n"]))? $_GET["n"] : "notch";
	$type = (isset($_GET["t"]) && $_GET["t"] == "profile")? "profile" : "portrait";
	$scale = (isset($_GET["s"]) && ((int)$_GET["s"]) > 0)? (int)$_GET["s"] : 3;

	$key = "character-image-$type-$nickname-$scale";

	$a = cache_get($key);

	if($a === false){
		ob_start();
			$C = new MinecraftCharacter($nickname);
			$C->load();

			if($type == "portrait"){
				imagepng($C->portrait()->get($scale));
			}else{
				imagepng($C->profile()->get($scale));
			}

		$a = ob_get_contents();
		ob_clean();
		ob_end_flush();

		cache_add($key, $a, Config::Instance()->GetConf("CacheAvatarTime", "3600"));
	}
	
	header("Content-type: image/png");
	echo $a;
?>