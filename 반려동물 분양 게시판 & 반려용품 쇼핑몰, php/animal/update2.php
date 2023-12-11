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
    $num     = $_REQUEST["num"    ];
    
    $title   = $_REQUEST["title"  ];
    $writer  = $_REQUEST["writer" ];
    $content = $_REQUEST["content"];
    $price = $_REQUEST["price"];

	$result = processUpload("upload", "files");
	if(is_int($result)){
		try {
            require("db_connect.php");
    
            $regtime = date("Y-m-d H:i:s");
            
            $db->exec("update shopping set writer='$writer', title='$title', content='$content', 
                       regtime='$regtime', price='$price' where num=$num");
                       
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
         
        $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];        
        header("Location:view2.php?num=$num&page=$page");
        exit();
    } else if ($title && $writer && $content) {
        try {
            require("db_connect.php");
    
            $regtime = date("Y-m-d H:i:s");
            
            $db->exec("update shopping set writer='$writer', title='$title', content='$content', 
                       regtime='$regtime', fname='$result[name]', price='$price' where num=$num");
                       
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
         
        $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];        
        header("Location:view2.php?num=$num&page=$page");
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
    history.back();
</script>

</body>
</html>
