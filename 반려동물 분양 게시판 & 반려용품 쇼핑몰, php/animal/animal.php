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
        .table-bordered{width: 50%; text-align:center; float:left;}
        th        { width: 230px; text-align:center; background-color:cyan; }
		img       { background-size:100% 100%; }
        #menu{height:90px; background-color:white; border-bottom:1px solid black;}
		.basket	  { width:80px; }
		.purchase { width:80px; }
        .num      { width: 80px; }
        .title    { width:230px; }
        .writer   { width:100px; }
        .regtime  { width:180px; }
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


<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="https://i.pinimg.com/736x/2e/7f/ce/2e7fce754fe9d35da7af6780b2977119.jpg" alt="...">
      <div class="carousel-caption">
        
      </div>
    </div>
    <div class="item">
      <img src="https://i.pinimg.com/736x/98/80/69/98806954d6cf4401b4f81e8bb2de0da5.jpg" alt="...">
      <div class="carousel-caption">
        
      </div>
    </div>
    
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<script>
$('.carousel').carousel({
interval: 5000,
wrap: true
});
</script>


<table class="table table-bordered">
	<tr>
	<th colspan="3"><a href="sec01.php">게시판+</a></th>
	</tr>
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

<table class="table table-bordered">
	<tr>
	<th colspan="2"><a href="sec02.php">반려용품+</a></th>
	</tr>
    <tr>
        <th class="image">제품 이미지</th>
        <th class="title"  >제품명</th>
        <th class="price" >가격</th>

    </tr>
    
<?php
    $listSize = 3;
    $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];
    
    try {
        require("db_connect.php");

        // 페이지네이션 시작/끝 번호 계산
        $paginationSize = 3;
        
        $firstLink = floor(($page - 1) / $paginationSize) * $paginationSize + 1;
        $lastLink = $firstLink + $paginationSize - 1;
        
        $numRecords = $db->query("select count(*) from shopping")->fetchColumn();
        $numPages = ceil($numRecords / $listSize);
        if ($lastLink > $numPages) {
            $lastLink = $numPages;
        }
        
        // 페이지에 해당하는 데이터 읽기 + 출력
        $start = ($page - 1) * $listSize;
        $query = $db->query("select * from shopping order by num desc limit $start, $listSize");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
?>            
        <tr>
			<td style="vertical-align: middle;">
				<a href="view2.php?num=<?=$row["num"]?>&page=<?=$page?>">
					<img src="files/<?=$row["fname"]?>" width="150px" height="130px">
				</a>
			</td>
            <td style="vertical-align: middle;">
			<a href="view2.php?num=<?=$row["num"]?>&page=<?=$page?>"><?=$row["title"]?></a>
			</td>	
			
			<td style="vertical-align: middle;"><?=number_format($row["price"])?>원</td>
        </tr>  
<?php            
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>
   
</table>
<div style="clear:both"></div>
<div id="footer"></div>
</div>

</body>
</html>