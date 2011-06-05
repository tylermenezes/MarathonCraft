<?php
	require_once("lib/Everything.php");
	require_once("tpl/UserBlock.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Mine For Charity</title>
		<meta name="description" content="#" />
		<meta name="keywords" content="#" />
		<link href="css/main.css" rel="stylesheet" />
		
		<script "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/colorbox/jquery.colorbox.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				$(".playerimage a").colorbox({photo: true});

				$(".player.streaming").click(function(){
					myName = $(this).children(".playername").text();
				});
			});
		</script>

	</head>
	<body>
		<div id="header">
			<h1>Mine For Charity</h1>
		</div>
		<div id="content">
			<p style="font-size: larger;">
				More coming soon.
			</p>
			<hr />
			
			<div>
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