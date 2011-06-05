<?php function UserBlock($miner){ ?>
	<?php
		if(is_array($miner)){
			$additional = $miner[0];
			$miner = $miner["user"];
		}
	?>
	<?php if(is_a($miner, "User")): ?>
		<li class="player<?php if($miner->IsStreaming()) echo " streaming"; ?><?php if($miner->IsOnline()) echo " online"; ?>">
			<span class="playerimage">
				<a href="showCharacter.php?t=profile&s=10&n=<?php echo $miner->name; ?>"><img src="showCharacter.php?n=<?php echo $miner->name; ?>" /></a>
			</span>
			<span class="playername"><?php echo $miner->name; ?></span>

			<?php if($additional): ?>
				<div class="additional"><?php echo $additional; ?></div>
			<?php endif; ?>
		</li>
	<?php endif; ?>
<?php } ?>