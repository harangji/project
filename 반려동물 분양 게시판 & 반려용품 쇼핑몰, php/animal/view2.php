<?php
	session_start();
    $num = $_REQUEST["num"];
    $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];
    
    try {
        require("db_connect.php");

        $query = $db->query("select * from shopping where num=$num");

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {    
			$title   = $row["title"  ];
			$content = $row["content"];
			$price   = $row["price"  ];
			$fname	 = $row["fname"  ];
			
            $title   = str_replace(" ", "&nbsp;", $row["title"  ]);
            $content = str_replace(" ", "&nbsp;", $row["content"]);
            $content = str_replace("\n", "<br>", $content);
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }        
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table { width:680px; text-align:center; }
        th    { width:100px; background-color:cyan; }
        td    { text-align:left; border:1px solid gray; }
    </style>
</head>
<body>

<table>
    <tr>
        <th>제목</th>
        <td><?=$title?></td>
    </tr>
    <tr>
        <th style="height:250px;">내용</th>
        <td><?=$content?></td>
    </tr>
	<tr>
		<th>제품 이미지</th>
		<td style="vertical-align: middle;"><img src="files/<?=$row["fname"]?>" width="150px" height="130px"></td>
	</tr>
	<tr>
        <th>가격</th>
        <td><?=number_format($price)?>원</td>
    </tr>
</table>


 <?php 
 if (!(empty($_SESSION["userId"])))
	 if($_SESSION["userId"]=="asd"){
?> 		<br>
	<input type="button" value="수정"     onclick="location.href='write2.php?num=<?=$num?>&page=<?=$page?>'">
	<input type="button" value="삭제"     onclick="location.href='del_file.php?num=<?=$num?>&page=<?=$page?>'">
	<br><br>
	<input type="button" value="내 장바구니" onclick="location.href='basket.php'">
	<input type="button" value="구매하기" onclick="location.href='purchase.php'">
 <?php 
	 }else{
?>		
		<br><br>
	<input type="button" value="내 장바구니" onclick="location.href='basket.php'">
	<input type="button" value="구매하기" onclick="location.href='purchase.php'">
<?php 
	 }
?>		
<br><br>
<input type="button" value="목록보기" onclick="location.href='sec02.php?page=<?=$page?>'">
</body>
</html>