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
	form{position:absolute; 
    top:30%; left:39%; width:300px;
    };
	</style>
</head>
<body>

<?php
    if (empty($_SESSION["userId"])) {
?>    

		<form action="login.php" method="post">
  <div class="form-group">
    <label for="exampleInputText">아이디</label>
    <input type="text" class="form-control" id="exampleInputText" name="id"placeholder="아이디를 입력하세요">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">비밀번호</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="pw"placeholder="비밀번호를 입력하세요">
  </div>
  <div class="form-group">
    <a href='/animal/member/member_info_form.php'>회원이 아니십니까?</a>
  </div>

  <button type="submit" class="btn btn-default">로그인</button>
  <button type="button" class="btn btn-default" onclick="location.href='/animal/animal.php'">취소</button>

</form>
		
<?php
    } 
?>
       
</body>
</html>
