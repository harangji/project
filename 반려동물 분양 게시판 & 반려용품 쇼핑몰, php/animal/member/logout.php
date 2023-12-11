<?php
	session_start();
?>
<?php

	$_SESSION["userId"]="";
	$_SESSION["userName"]="";
			
    header("Location:/animal/animal.php");
    exit;
?>
