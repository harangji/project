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
		body{overflow-x:hidden;}
        .table-bordered{width: 75%; text-align:center; vertical-align:middle; margin:auto;}
        th        { width: 100px; text-align:center; background-color:cyan; }	
		img       { background-size:100% 100%; }
        #menu{height:90px; background-color:white; border-bottom:1px solid black;}
		.image	  { width:80px; }
		.price 	  { width:60px; }
		.basket	  { width:80px; }
		.purchase { width:70px; }
        .num      { width: 80px; }
        .title    { width:100px; }
        .writer   { width:100px; }
        .regtime  { width:180px; }
		 #btn{margin-top:20px; margin-left:250px;}
        .hea li{ width:24%; height:60px; top:15px; text-align:center; line-height: 60px; font-size:23px;
		list-style-type:none; float:left; background-color:white; position:relative;}    
		#header{width:100%;height:100px;background-color:pink;}
		#login{float:right; margin:28px;}
		#footer{width:100%;height:110px;background-color:gray; margin-top:140px;}
        a{ text-decoration:none; color:black; }
        //a:visited { text-decoration:none; color:gray; }
        a:hover   { text-decoration:none; color:red;  }
		
		.left     { text-align:left; }
		
       	 
	
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
 <div style="clear:both"></div>
 
<p style="color:red; font-size:25px; margin-left:190px;"><?=$_SESSION["userId"]?>님의 장바구니입니다.</p>

<table class="table table-bordered">
    <tr>
        <th class="title" >제품명</th>
		<th class="count">수량</th>
		<th class="price">가격</th>
		<th>장바구니에서 제거</th>
    </tr>

<?php
    $listSize = 9;
    $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];
    
    try {
        require("db_connect.php");

        // 페이지네이션 시작/끝 번호 계산
        $paginationSize = 3;
        
        $firstLink = floor(($page - 1) / $paginationSize) * $paginationSize + 1;
        $lastLink = $firstLink + $paginationSize - 1;
        
        $numRecords = $db->query("select count(*) from basket")->fetchColumn();
        $numPages = ceil($numRecords / $listSize);
        if ($lastLink > $numPages) {
            $lastLink = $numPages;
        }
         
        // 페이지에 해당하는 데이터 읽기 + 출력
        $start = ($page - 1) * $listSize;
		$userid = $_SESSION["userId" ] ;
		$sum = $db->query("select SUM(price*count) from basket where userid='$userid'")->fetchColumn();
        $query = $db->query("select * from basket where userid='$userid'");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {  
         $num  = $row["num" ];
         $title  = $row["title" ];
         $price  = $row["price" ];
         $count = $row["count" ];
?>        
		<tr>
            <td style="vertical-align: middle;">
			<a href="view2.php?num=<?=$row["num"]?>&page=<?=$page?>"><?=$row["title"]?></a>
			</td>
			<td style="vertical-align: middle;"><?= $row["count"]?></td>
			<td style="vertical-align: middle;"><?= number_format($price * $count)?>원</td>
			<td style="vertical-align: middle;"><a href="del_basket.php?num=<?=$row["num"]?>">x</a></td>
        </tr>
		  
	<?php           
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>
<tr><td style="vertical-align: middle;"  colspan="4">총합 <?= $sum?>원</td></tr>
</table>
<input type="button" id="btn" value="구매하기" onclick="location.href='purchase.php?page=<?=$page?>'">
<div style="clear:both"></div>
<div id="footer"></div>


</body>
</html>