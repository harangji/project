<?php
function processUpload($tagName, $savePath) {
if (!(isset($_FILES[$tagName]["error"]) && $_FILES[$tagName]
["error"] == UPLOAD_ERR_OK)){
return 1;
}
$tempName = $_FILES[$tagName]["tmp_name"];
$rv["name"] = $_FILES[$tagName]["name"];
$rv["size"] = $_FILES[$tagName]["size"];
$rv["type"] = $_FILES[$tagName]["type"];
$saveName = iconv("utf-8", "cp949", $rv["name"]);

/*if (file_exists("$savePath/$saveName")){
return 2;
}*/
if (!move_uploaded_file($tempName, "$savePath/$saveName")){
return 3;
}

return $rv;
}
    $writer  = $_REQUEST["writer" ];
	$title   = $_REQUEST["title"  ];
    $content = $_REQUEST["content"];
	$price 	 = $_REQUEST["price"];
	
	
    $result = processUpload("upload", "files");
	
	if(is_int($result)){
		$err='파일 업로드 실패.';
    } else if ($title && $writer && $content && $price) {
        try {
            require("db_connect.php");
    
            $regtime = date("Y-m-d H:i:s");
            
            $db->exec("insert into shopping (writer, title, content, price, regtime, fname )
                       values ('$writer', '$title', '$content', '$price', '$regtime',
					   '$result[name]' )");
            //echo("insert into shopping (writer, title, content, regtime, fname )
                       //values ('$writer', '$title', '$content', '$regtime','$result[name]' )");
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        
        header("Location:sec02.php");
        exit();
    }        
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<script>
    alert($err);
    history.back();
</script>

</body>
</html>
