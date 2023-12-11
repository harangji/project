<?php
	session_start();
	$sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : "fname";
	$dir = isset($_REQUEST["dir"]) ? $_REQUEST["dir"] : "asc";
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
        th        { width: 100px; text-align:center; vertical-align:middle; background-color:cyan; }	
		img       { background-size:100% 100%; }
        #menu{height:90px; background-color:white; border-bottom:1px solid black;}
		.image	  { width:80px; }
		.count	  { width:60px; }
		.price 	  { width:60px; }
		.basket	  { width:90px; }
		.purchase { width:70px; }
		.delete{ width:70px; }
        .num      { width: 80px; }
        .title    { width:100px; }
        .writer   { width:100px; }
        .regtime  { width:180px; }
		 #btn{margin-top:20px; margin-left:250px;}
        .hea li{ width:24%; height:60px; top:15px; text-align:center; line-height: 60px; font-size:23px;
		list-style-type:none; float:left; background-color:white; position:relative;}    
		#header{width:100%;height:100px;background-color:pink;}
		#login{float:right; margin:28px;}
		#footer{width:100%;height:110px;background-color:gray; margin-top:30px;}
        a{ text-decoration:none; color:black; }
        //a:visited { text-decoration:none; color:gray; }
        a:hover   { text-decoration:none; color:red;  }
		
		.left     { text-align:left; }
    </style>
</head>
<body>
<script>
function plus(elem){
    let targetElem = elem.parentNode.previousElementSibling.childNodes[0];
    let targetCount = parseInt(targetElem.value);
    targetCount++;
    targetElem.value = targetCount;
}
function minus(elem){
    let targetElem = elem.parentNode.previousElementSibling.childNodes[0];
    let targetCount = parseInt(targetElem.value);
	
    if (targetCount > 1) {
        targetCount--;
        targetElem.value = targetCount;
    }
}
function basket(){
    alert('장바구니에 상품을 추가하였습니다.');
    history.back();
}
</script>

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

<table class="table table-bordered">
    <tr>
        <th class="image"  style="vertical-align: middle;">제품 이미지</th>
        <th class="title" style="vertical-align: middle;">제품명</th>
		<th class="price" style="vertical-align: middle;">가격</th>
					<?php
					 if(!(empty($_SESSION["userId"]))){
					   ?> 
		<th class="count" style="vertical-align: middle;">수량</th>
		<th style="width:50px;"></th>
		<th class="basket" style="vertical-align: middle;">장바구니에 담기</th>
		<th class="purchase" style="vertical-align: middle;">구매하기</th>
					<?php
					 }
					   ?> 
					<?php
					 if(!(empty($_SESSION["userId"])))
							if($_SESSION["userId"]=="asd"){
					   ?> 
		<th class="delete" style="vertical-align: middle;">삭제</th>
					<?php
								 }
					?> 
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
		<form action = "add_basket.php" method = "post">
			<td style="vertical-align: middle;">
				<a href="view2.php?num=<?=$row["num"]?>&page=<?=$page?>">
					<img src="files/<?=$row["fname"]?>" width="150px" height="130px">
				</a>
			</td>
            <td style="vertical-align: middle;">
				<a href="view2.php?num=<?=$row["num"]?>&page=<?=$page?>"><?=$row["title"]?></a>
			</td>
			<td style="vertical-align: middle;"><?=number_format($row["price"])?>원</td>
			
			<input type="hidden" name="num" value="<?=$row["num"] ?>" />
            <input type="hidden" name="title" value="<?=$row["title"] ?>" />
            <input type="hidden" name="price" value="<?=$row["price"] ?>" />
					<?php
					 if(!(empty($_SESSION["userId"]))){
					   ?> 
            <td style="vertical-align: middle;"><input type="text" name="count" value="1"  style="width:50px; height:30px; font-size:25px; text-align:center;"></td>
			<td style="vertical-align: middle;"><button type="button" onclick="plus(this);">▲</button>
				<button type="button" onclick="minus(this);">▼</button></td>
            <td style="vertical-align: middle;">
			<input TYPE="IMAGE" src="image/basket.png" onclick="basket();" width="40px" height="40px"></td>
			<td style="vertical-align: middle;">
				<a href="purchase.php">
					<img src="image/purchase.png" width="40px" height="40px">
				</a>
			</td>
						<?php
						}
					   ?> 
					 <?php
					 if(!(empty($_SESSION["userId"])))
							if($_SESSION["userId"]=="asd"){
					   ?> 
			<td style="vertical-align: middle;"><a href="del_file.php?num=<?=$row["num"]?>&sort=<?=$sort?>&dir=<?=$dir?>">x</a></td>
						<?php
							}
					   ?> 
			</form>
        </tr>
		  
	<?php           
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>
</table>
<?php
	if (!(empty($_SESSION["userId"]))) {
	?>
		<input type="button" value="내 장바구니" id="btn" onclick="location.href='basket.php?page=<?=$page?>'">
<?php
		}
	?>
 <?php 
 if (!(empty($_SESSION["userId"])))
	 if($_SESSION["userId"]=="asd"){
?>
<br>
<input type="button" value="상품추가" id="btn" onclick="location.href='write2.php'">
 <?php
    } 
?>
<div style="clear:both"></div>
<div id="footer"></div>


</body>
</html>