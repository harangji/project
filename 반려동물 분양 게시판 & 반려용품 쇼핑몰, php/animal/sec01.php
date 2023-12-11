<?php
	session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        .table-bordered{width: 100%; text-align:center; float:left;}
        th        { width: 230px; text-align:center; background-color:cyan; }
		img       { background-size:100% 100%; }
        #menu{height:90px; background-color:white; border-bottom:1px solid black;}
		
        .num      { width: 80px; }
        .title    { width:230px; }
        .writer   { width:100px; }
        .regtime  { width:180px; }
		 #btn{margin-top:20px; margin-left:100px;}
        .hea li{ width:24%; height:60px; top:15px; text-align:center; line-height: 60px; font-size:23px;
		list-style-type:none; float:left; background-color:white; position:relative;}    
		#header{width:100%;height:100px;background-color:pink;}
		#login{float:right; margin:28px;}
		#footer{width:100%;height:110px;background-color:gray; margin-top:30px;}
        a{ text-decoration:none; color:black; }
        //a:visited { text-decoration:none; color:gray; }
        a:hover   { text-decoration:none; color:red;  }
		
		.left     { text-align:left; }
		
		 .carousel-inner > .item > img {
		  top: 0;
		  left: 0;
		  min-width: 100%;
		  max-height: 430px;
		} 
    </style>
</head>
<body>

<div id="header"><div id="login">
<?php
    if (empty($_SESSION["userId"])) {
?>    
        <form action="member/login.php" method="post">
		
            <a href="login_page.php"><img src="image/Guest.png" width="50px" height="50px"></a>
			게스트
            <input type="button" value="로그인" onclick="location.href='member/login_page.php'"> 
            <input type="button" value="회원 가입" 
                   onclick="location.href='member/member_info_form.php'">
				   
        </form>
		
<?php
    } else {  // 로그인 되었으면
?>
       <form action="member/logout.php" method="post">
		   <a href="profile.php"><img src="image/Member.png" width="50px" height="50px"></a>
           <?=$_SESSION["userId"]?>님 로그인		   
           <input type="submit" value="로그아웃">
           <input type="button" value="회원정보 수정" 
                  onclick="location.href='member/member_info_form.php'">
       </form>
<?php
    } 
?>
	</div>
</div>

<div id = "container">
<div id="menu">
<ul class="hea">
<li><a href="animal.php">메인</a></li>
<li><a href="sec01.php">게시판</a></li>
<li><a href="sec02.php">반려용품</a></li>
<?php
	if (empty($_SESSION["userId"])) {
?>
		<li><a href="basket_Login.php">장바구니</a></li>
<?php
	}else{
?>
		<li><a href="basket.php">장바구니</a></li>
<?php
	}
?>
</ul>
</div>

<table class="table table-bordered">
    <tr>
        <th class="num">번호</th>
        <th class="title"  >제목</th>
        <th class="writer" >작성자</th>
        <th class="regtime">작성일시</th>
    </tr>
    
<?php
    $listSize = 12;
    $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];
    
    try {
        require("db_connect.php");

        // 페이지네이션 시작/끝 번호 계산
        $paginationSize = 3;
        
        $firstLink = floor(($page - 1) / $paginationSize) * $paginationSize + 1;
        $lastLink = $firstLink + $paginationSize - 1;
        
        $numRecords = $db->query("select count(*) from board")->fetchColumn();
        $numPages = ceil($numRecords / $listSize);
        if ($lastLink > $numPages) {
            $lastLink = $numPages;
        }
        
        // 페이지에 해당하는 데이터 읽기 + 출력
        $start = ($page - 1) * $listSize;
        $query = $db->query("select * from board order by num desc limit $start, $listSize");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
?>            
        <tr>
            <td><?=$row["num"]?></td>
            <td><a href="view.php?num=<?=$row["num"]?>&page=<?=$page?>"><?=$row["title"]?></a></td>
            <td><?=$row["writer"]?></td>
            <td><?=$row["regtime"]?></td>
        </tr>
<?php            
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>
   
</table>
<?php
if (!(empty($_SESSION["userId"]))){
?>        
<input type="button" value="글쓰기" id="btn" onclick="location.href='write.php'">
<br>
<?php
}
?>
<div style="width:100%; text-align:center">
<?php
    if ($firstLink > 1) {
?>
        <a href="sec01.php?page=<?=($firstLink - 1)?>">&lt;</a>
<?php
    }
    
    for($i = $firstLink; $i <= $lastLink; $i++) {
?>
        <a href="sec01.php?page=<?=$i?>"><?=$i?></a> 
<?php
    }
    
     if ($lastLink < $numPages) {
?>
         <a href="sec01.php?page=<?=($lastLink + 1)?>">&gt;</a>
<?php
     }         
?>    
</div>


<div style="clear:both"></div>
<div id="footer"></div>
</div>

</body>
</html>