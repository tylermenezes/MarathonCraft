<?php
	require_once("Config.php");

	$memcached = new Memcached();
	if(Config::Instance()->GetConf("CacheEnable") == "true"){
		$memcached->addServer(Config::Instance()->GetConf("CacheHost", "127.0.0.1"), Config::Instance()->GetConf("CachePort", "11211"));
	}

	function cache_add($key, $val, $exp){
		if(Config::Instance()->GetConf("CacheEnable") == "true"){
			global $memcached;
			$memcached->set(Config::Instance()->GetConf("CacheNamespace") . $key, $val, $exp);
		}
	}

	function cache_get($key){
		if(Config::Instance()->GetConf("CacheEnable") == "true"){
			global $memcached;
			return $memcached->get(Config::Instance()->GetConf("CacheNamespace") . $key);
		}else{
			return false;
		}
	}
?>