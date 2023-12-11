<?php
	session_start();

    $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";
    $pw = isset($_REQUEST["pw"]) ? $_REQUEST["pw"] : "";
    
    try {
        require("db_connect.php");

        $query = $db->query("select * from member where id='$id' and pw='$pw'");
        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {    
                      
			$_SESSION["userId"]=$row["id"];
			$_SESSION["userName"]=$row["name"];
            
            header("Location:/animal/animal.php");
            exit;
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<script>
    alert('아이디 또는 비밀번호가 틀렸습니다.');
    history.back();
</script>

</body>
</html>
