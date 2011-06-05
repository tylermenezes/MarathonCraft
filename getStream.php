<?php
	require_once("lib/Everything.php");

	$user = new User((isset($_GET["u"]))? $_GET["u"] : "tylermenezes");
	if($user->GetStream()->IsOnAir()){
		echo $user->GetStream()->GetEmbedCode();
	} 
?>