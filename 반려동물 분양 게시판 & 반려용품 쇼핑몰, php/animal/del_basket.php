<?php
$num=$_REQUEST["num"];

try {

	$db = new PDO("mysql:host=localhost;dbname=phpdb","php", "1234");
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$db->exec("delete from basket where num=$num");
	 
	} catch(PDOException $e){
		exit($e->getMessage());
	}
	
	 header("Location: basket.php");
	 exit();
?>