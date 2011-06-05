<?php
	require_once("lib/Everything.php");
?>
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
 
 <script type="text/javascript" src="js/swfobject.js"></script>
 <script type="text/javascript">
	var params = {};

	params.host                         = "<?php Config::Instance()->Conf("IrcServer"); ?>";
	params.autojoin                     = "#<?php Config::Instance()->Conf("IrcRoom"); ?>";
	params.port                         = <?php Config::Instance()->Conf("IrcPort"); ?>;
	params.policyPort                   = <?php Config::Instance()->Conf("IrcPolicyPort"); ?>;
	params.language                     = "<?php Config::Instance()->Conf("IrcLanguage"); ?>";
	params.styleURL                     = "";
	params.nick                         = "<?php Config::Instance()->Conf("IrcNick"); ?>";
	params.showTranslationButton		= <?php Config::Instance()->Conf("IrcShowTranslationButton"); ?>;
	params.showEmoticonsButton			= <?php Config::Instance()->Conf("IrcShowEmoticonsButton"); ?>;
	params.showRichTextControls			= <?php Config::Instance()->Conf("IrcShowRichTextControls"); ?>;
	params.showServerWindow				= <?php Config::Instance()->Conf("IrcShowServerWindow"); ?>;
	params.showJoinPartMessages			= <?php Config::Instance()->Conf("IrcShowJoinPartMessages"); ?>;
	params.showMenuButton				= <?php Config::Instance()->Conf("IrcShowMenuButton"); ?>;
	params.perform                      = "";
	params.showNickSelection            = <?php Config::Instance()->Conf("IrcShowNickSelection"); ?>;
	params.showIdentifySelection        = <?php Config::Instance()->Conf("IrcShowIdentifySelection"); ?>;
	params.showRegisterNicknameButton   = <?php Config::Instance()->Conf("IrcShowRegisterNicknameButton"); ?>;
	params.showRegisterChannelButton    = false;
	params.showNewQueriesInBackground   = <?php Config::Instance()->Conf("IrcShowNewQueriesInBackground"); ?>;
	params.navigationPosition           = "<?php Config::Instance()->Conf("IrcNavigationPosition"); ?>";

	for(var key in params) {
	  params[key] = params[key].toString().replace(/%/g, "%25");
	}

	function sendCommand(command) {
	  swfobject.getObjectById('lightIRC').sendCommand(command);
	}
 
	swfobject.embedSWF("<?php Config::Instance()->Conf("IrcSwfSource"); ?>lightIRC.swf", "lightIRC", "100%", "100%", "10.0.0", "<?php Config::Instance()->Conf("IrcSwfSource"); ?>expressInstall.swf", params);
 </script>
</body>
</html>