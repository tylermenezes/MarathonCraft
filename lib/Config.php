<?php
	define("CONF_DIR", str_replace('//','/',dirname(__FILE__)) . "/../config");
	require_once("User.php");

	class Config{

		private static $instance;

		private $lists;
		private $config;
		private $streams;

		private function __construct(){
			// Parse standard files.
			$this->config = self::ParseTsv(file_get_contents(CONF_DIR . "/config.txt"), true);
			$this->streams = self::ParseTsv(file_get_contents(CONF_DIR . "/streams.txt"));

			// Now parse all the list files.
			if ($handle = opendir(CONF_DIR)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && $file != "config.txt" && $file != "streams.txt") {
							// This is a list file
							$listName = substr($file, 0, strripos($file, "."));
							$contents = file_get_contents(CONF_DIR . "/$file");

							$this->lists[$listName] = array();
							foreach(self::ParseTsv($contents) as $u=>$v){
								$this->lists[$listName][$u] = $v;
								$this->lists[$listName][$u]["user"] = new User($u);
							}
					}
				}
				closedir($handle);
			}
		}

		private static function ParseTsv($contents, $collapse = false){
			$result = array();
			foreach(array_filter(explode("\n", $contents)) as $line){

				$line = trim($line);

				if(strpos($line, "#") !== false){
					$line = substr($line, 0, strpos($line, "#"));

					if(strlen($line) == 0){
						continue;
					}
				}

				$line = array_filter(explode("\t", $line));
				$name = array_shift($line);

				if($collapse){
					$line = implode("\t", $line);
				}

				$result[$name] = $line;
			}

			return $result;
		}

		public static function Instance(){
			if(is_null(self::$instance)){
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function GetConf($configVar, $defaultValue = false){
			return isset($this->config[$configVar])? $this->config[$configVar] : $defaultValue;
		}

		public function GetUserStreamingConfig($username){
			return isset($this->streams[$username])? (object)array("type" => $this->streams[$username][0], "name" => $this->streams[$username][1]) : false;
		}

		public function GetList($type){
			return isset($this->lists[$type])? $this->lists[$type] : array();
		}

		public function GetLists(){
			return $this->lists;
		}
	}
?>