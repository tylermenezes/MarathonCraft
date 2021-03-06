<?php
	require_once("lib/Everything.php");
	require_once("tpl/UserBlock.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title><?php Config::Instance()->Conf("Name"); ?></title>
		<meta name="description" content="#" />
		<meta name="keywords" content="#" />
		<link href="css/main.css" rel="stylesheet" />
		
		<script "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/colorbox/jquery.colorbox.js"></script>
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
			  swfobject.getObjectById('chat').sendCommand(command);
			}

			$(document).ready(function(){
				$(".playerimage a").colorbox({photo: true});

				$(".player.streaming").click(function(){
					myName = $(this).children(".playername").text();
					$.get("getStream.php", {u : myName}, function(data){
						$("#stream").html(data);
					});
				});
			});
		</script>

	</head>
	<body>
		<div id="header">
			<h1><?php Config::Instance()->Conf("Name"); ?></h1>
		</div>
		<div id="content">
			<div id="stream">&nbsp;
				<?php
					$stream = "";
					$u = false;
					
					if(isset($_GET["stream"])){
						$u = new User($_GET["stream"]);
					}

					if($u !== false && $u->IsStreaming()){
						$stream = $u->GetStream()->GetEmbedCode();
					}else{
						foreach(Config::Instance()->GetStreamUsers() as $user){
							if($user->IsStreaming()){
								$stream = $user->GetStream()->GetEmbedCode();
							}
						}
					}

					echo $stream;
				?>
			</div>

			<?php if(Config::Instance()->GetConf("IrcEnable", false) == "true") : ?>
				<div id="chat">
					<div id="lightIRC"><p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p></div>
					<script type="text/javascript">
						swfobject.embedSWF("<?php Config::Instance()->Conf("IrcSwfSource"); ?>lightIRC.swf", "lightIRC", "100%", "100%", "10.0.0", "<?php Config::Instance()->Conf("IrcSwfSource"); ?>expressInstall.swf", params);
					</script>
					
				</div>
			<?php endif; ?>
			<hr />
			<div>
			<div>
				<p>Green = online; Red = streaming</p>
				<p>Click on a streaming user to switch to their stream.</p>
			</div>
			<div id="columns">
				<div class="col">
					<h2 style="color: #2EB448">Marathon Team</h2>
					<ul class="playerlist">
						<?php
							foreach(Config::Instance()->GetList("team") as $member){
								UserBlock($member);
							}
						?>
					</ul>
				</div>
				<div class="col">
					<h2 style="color: #2EB448">Special Thanks</h2>
					<ul class="playerlist">
						<?php
							foreach(Config::Instance()->GetList("thanks") as $member){
								UserBlock($member);
							}
						?>
					</ul>
				</div>
			</div>
			<hr />
				<?php $miners = User::AllPlayers(); ?>
				<h2>All Miners:</h2>
				<div id="columns">
				<div class="col">
					<ul class="playerlist">
						<?php
							for($i = 0; $i < ceil((float)count($miners)/2); $i++){
								UserBlock(array_shift($miners));
							}
						?>
					</ul>
				</div>
				
				<div class="col">
					<ul class="playerlist">
						<?php
							for($i = 0; $i <count($miners); $i++){
								UserBlock(array_shift($miners));
							}
						?>
					</ul>
				</div>
			</div>
			<hr />
		</div>
		<div id="footer">
			<div class="copyright">
				Copyright &copy; 2011 Mine For Charity. All rights reserved. Web design by <a href="http://www.codepoverty.com/">CodePoverty</a>. Hosting by <a href="http://www.arson-media.com">ARSON Media</a>.
			</div>
		</div>
	</body>
</html>