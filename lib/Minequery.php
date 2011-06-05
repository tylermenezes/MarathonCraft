<?php
	require_once("Config.php");
	require_once("Cache.php");

	class Minequery{

		/**
		 * Queries a Minequery server using JSON.
		 *
		 * @static
		 * @param string $address The address to the Minequery server.
		 * @param int $port The port of the Minequery server.
		 * @param int $timeout The time given before the connection attempt gives up.
		 * @return object|bool A stdClass object on success, FALSE on failure.
		 */
		public static function query_json(){
			$query = cache_get("online-players");

			if($query === false){

				$beginning_time = microtime(true);

				$address = Config::Instance()->GetConf("ServerAddr", "localhost");
				$port = Config::Instance()->GetConf("MinequeryPort", "25566");

				$socket = @fsockopen($address, $port, $errno, $errstr, 5);

				if (!$socket) {
					// Could not establish a connection to the server.
					return false;
				}

				$end_time = microtime(true);

				fwrite($socket, "QUERY_JSON\n");

				$response = "";

				while(!feof($socket)) {
					$response .= fgets($socket, 1024);
				}

				$query = json_decode($response, true);
				$query->latency = ($end_time - $beginning_time) * 1000;

				cache_add("online-players", $query, 60);
			}

			return $query;
		}
	}