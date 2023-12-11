<?php
	session_start();
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<?php
	$id = isset($_REQUEST["id"])? $_REQUEST["id"] : "";
	$pw = isset($_REQUEST["pw"])? $_REQUEST["pw"] : "";
	$name = isset($_REQUEST["name"])? $_REQUEST["name"] : "";
	$gender = isset($_REQUEST["gender"]) ? $_REQUEST["gender"] : "";
	$CellPhone = isset($_REQUEST["CellPhone"]) ? $_REQUEST["CellPhone"] : "";

	try{
		require("db_connect.php");
		if(!($pw && $name)){
?>
			<script>
				alert('빈칸 없이 입력해야 합니다.');
				history.back();
			</script>
<?php
		}else{
			$db->exec("update member set pw='$pw',name='$name', gender='$gender',
		 CellPhone='$CellPhone'  where id='$id'");
			
			$_SESSION["userName"] = $name;
?>
			<script>
			alert('수정이 완료되었습니다.');
			location.href="/animal/animal.php";
			
			</script>
<?php
		}
	} catch(PDOException $e){
		exit($e->getMessage());
	}
?>
</body>
</html>