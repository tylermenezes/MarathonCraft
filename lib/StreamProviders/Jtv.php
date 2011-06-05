<?php
	class Jtv{
		public $name;

		public function __construct($name){
			$this->name = $name;
		}

		public function IsOnAir(){
			return (count($this->getStream()->children()) != 0);
		}

		public function GetEmbedCode($width = 400, $height = 300, $autoplay = false){
			$autoplay = $autoplay? "true":"false";
			return <<<EOF
<object type="application/x-shockwave-flash" height="$height" width="$width" id="live_embed_player_flash" data="http://www.justin.tv/widgets/live_embed_player.swf?channel={$this->name}" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://www.justin.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="start_volume=25&channel={$this->name}&auto_play=$autoplay" /></object> 
EOF;
		}

		private function getStream(){
			$result = cache_get("jtv-{$this->name}");

			if($result === false){
				$result = file_get_contents("http://api.justin.tv/api/stream/list.xml?channel=" . $this->name);
				cache_add("jtv-{$this->name}", $result, Config::Instance()->GetConf("CacheStreamUptimeTime", "60"));
			}

			$result = new SimpleXMLElement($result);
			return $result;
		}
	}
?>