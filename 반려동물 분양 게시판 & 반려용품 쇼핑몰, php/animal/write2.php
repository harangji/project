<?php
	session_start();
    // 새글쓰기 모드로 가정하고 변수값 설정
    $title   = "";
    $writer  = $_SESSION["userId"];
    $content = "";
	$price	 = "";
    $action  = "insert2.php";
	
    $num = isset($_REQUEST["num"]) ? $_REQUEST["num"] : "";
    
    // 글 수정 모드로 실행되어야 하면
    if ($num) {
        try {
            require("db_connect.php");
    
            $query = $db->query("select * from shopping where num=$num");
    
            if ($row = $query->fetch(PDO::FETCH_ASSOC)) {    
                $writer  = $row["writer" ];
                $title   = $row["title"  ];
                $content = $row["content"];
                $price   = $row["price"  ];
				
				
                $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];
                $action  = "update2.php?num=$num&page=$page";
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }          
        
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table { width:680px; text-align:center; }
        th    { width:100px; background-color:cyan; }
        input[type=text], textarea { width:100%; }
    </style>
</head>
<body>

<form method="post" action="<?=$action?>" enctype="multipart/form-data">
    <table>
        <tr>
            <th>제목</th>
            <td><input type="text" name="title" maxlength="80" value="<?=$title?>"></td>
        </tr>
        <tr>
            <th>작성자</th>
            <td><input type="text" name="writer" maxlength="20" value="<?=$writer?>"readonly></td>
        </tr>
        <tr>
            <th>내용</th>
            <td><textarea name="content" rows="10"><?=$content?></textarea></td>
        </tr>
		<tr>
            <th>이미지</th>
			<?php 
			
				if (!(empty($row["fname"]))){
			?>
			<td><img src="files/<?=$row["fname"]?>" width="150px" height="130px"><br>
			<input type="file" name="upload"></td>
			<?php 
				}else{
			?>
			<td><input type="file" name="upload"></td>
			<?php 
				}
			?>
        </tr>
		<tr>
            <th>가격</th>
            <td><input type="text" name="price" maxlength="20" value="<?=$price?>"></td>
        </tr>
    </table>

    <br>
    <input type="submit" value="저장">
    <input type="button" value="취소" onclick="history.back()">
</form>

</body>
</html>