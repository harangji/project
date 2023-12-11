<?php
$num=$_REQUEST["num"];

try {

	$db = new PDO("mysql:host=localhost;dbname=phpdb","php", "1234");
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$file_name = $db->query("select fname from shopping where num=$num")->fetchColumn();;

	$db->exec("delete from shopping where num=$num");
	 
	unlink("files/$file_name");
	
	} catch(PDOException $e){
		exit($e->getMessage());
	}
	
	 header("Location: sec02.php?sort=$_REQUEST[sort]&dir=$_REQUEST[dir]");
	 exit();
?>