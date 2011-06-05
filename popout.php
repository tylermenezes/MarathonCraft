<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
 <meta name="language" content="de" />
 <meta name="author" content="Valentin Manthei - lightIRC.com" />
 <title>CodePoverty Chat</title>

 <style type="text/css">
	html { height: 100%; overflow: hidden; }
	body { height:100%;	margin:0;	padding:0; background-color:#999;	}
 </style>
</head>

<body>
 <div id="lightIRC" style="height:100%; text-align:center;">
  <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
 </div>
 
 <script type="text/javascript" src="http://irc.arson-media.com/swfobject.js"></script>
 <script type="text/javascript">
	var params = {};

	params.host                         = "irc.arson-media.com";
	params.autojoin                     = "#CodePoverty";
	params.port                         = 6667;
	params.policyPort                   = 843;
	params.language                     = "en";
	params.styleURL                     = "";
	params.nick                         = "guest_%";
	params.showTranslationButton		= false;
	params.showEmoticonsButton			= false;
	params.showRichTextControls			= false;
	params.showServerWindow				= false;
	params.showJoinPartMessages			= false;
	params.showMenuButton				= false;
	params.perform                      = "";
	params.showServerWindow             = true;
	params.showNickSelection            = true;
	params.showIdentifySelection        = false;
	params.showRegisterNicknameButton   = false;
	params.showRegisterChannelButton    = false;
	params.showNewQueriesInBackground   = false;
	params.navigationPosition           = "bottom";

	for(var key in params) {
	  params[key] = params[key].toString().replace(/%/g, "%25");
	}

	function sendCommand(command) {
	  swfobject.getObjectById('lightIRC').sendCommand(command);
	}

	function onContextMenuSelect(nick) {
	  alert("onContextMenuSelect: "+nick);
	}
 
	swfobject.embedSWF("http://irc.arson-media.com/lightIRC.swf", "lightIRC", "100%", "100%", "10.0.0", "http://irc.arson-media.com/expressInstall.swf", params);
 </script>
</body>
</html>