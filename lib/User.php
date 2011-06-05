<?php
	require_once("Config.php");
	require_once("Cache.php");
	require_once("Minequery.php");
	require_once("StreamProviders.php");

	class User{
		public $name;

		public function __construct($name){
			$this->name = $name;
		}

		public function GetStream(){
			$config = Config::Instance()->GetUserStreamingConfig($this->name);
			if($config === false){
				throw new Exception("This user does not stream.");
			}

			if($config->type == "jtv"){
				return new Jtv($config->name);
			}
		}

		public function IsStreaming(){
			return (Config::Instance()->GetUserStreamingConfig($this->name) !== false && $this->GetStream()->IsOnAir());
		}

		public function IsOnline(){
			return in_array($this->name, self::AllOnlinePlayers());
		}

		public function IsListed($listNames = false){
			foreach(Config::Instance()->GetLists() as $listName=>$list){
				if(isset($listNames) && !in_array($listName, $listNames)){
					continue;
				}

				if(isset($list[$this->name])){
					return true;
				}
			}

			return false;
		}

		public static function AllOnlinePlayers(){
			$q = Minequery::query_json();
			return $q["playerList"];
		}

		public static function AllPlayers(){
			$list = cache_get("players");

			if($list === false){
				$l = file_get_contents("http://" . Config::Instance()->GetConf("ServerAddr", "localhost") . ":" . Config::Instance()->GetConf("AllPlayerPort", "9898") . "/");
				$l = array_filter(explode("\n", $l));
				$l = array_merge($l, self::AllOnlinePlayers());

				if(!is_array($l)){
					$l = array();
				}

				foreach($l as $player){
					$list[$player] = new User($player);
				}

				cache_add("players", $list, 60);
			}

			return $list;
		}
	}
?>