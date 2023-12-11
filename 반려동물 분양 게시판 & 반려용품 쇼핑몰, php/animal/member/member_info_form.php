<?php
    // 신규 회원 가입 양식을 가정한 변수 설정
    $pw     = "";
    $name   = "";
	$gender = "";
	$CellPhone = "";
    $ro     = "";
    $action = "member_join.php";
    
    // 회원 정보 수정 모드로 실행되어야 하는 상황이라면
    session_start();
    $id = isset($_SESSION["userId"]) ? $_SESSION["userId"] : "";
    
    if ($id) {
        try {
            require("db_connect.php");
       
            $query = $db->query("select * from member where id='$id'");
            $row = $query->fetch(PDO::FETCH_ASSOC);
            
            $pw     = $row["pw"  ];
            $name   = $row["name"];
			$gender = $row["gender"];
			$CellPhone = $row["CellPhone"];
            $ro     = "readonly";
            $action = "member_update.php";
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }   
    
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
	
</head>
<body>


<center>
    <form action="<?=$action?>" method="post">
        <table width="800">
            <tr height="40">
                <td align="center"><b>[회원가입]</b></td>
            </tr>
        </table>    
        <table width="700" height="600" cellpadding="0" style="border-collapse:collapse; font-size:9pt;">
            <tr class="register" height="30">
                <td width="5%" align="center">*</td>
                <td width="15%">회원 ID</td>
                <td><input type="text" name="id" value="<?=$id?>" <?=$ro?>></td>
            </tr>
            <tr height="7">
                <td colspan="3"><hr /></td>
            </tr>
            <tr class="register" height="30">
                <td width="5%" align="center">*</td>
                <td width="15%">비밀번호</td>
                <td><input type="password" name="pw" id="pw" value="<?=$pw?>" onchange="isSame()" ></td>
            </tr>
            <tr height="7">
                <td colspan="3"><hr /></td>
            </tr>
            <tr class="register" height="30">
                <td width="5%" align="center">*</td>
                <td width="15%">이 름</td>
                <td><input type="text" name="name" value="<?=$name?>"></td>
            </tr>
            <tr height="7">
                <td colspan="3"><hr /></td>
            </tr>
            <tr class="register" height="30">
                <td width="5%" align="center">*</td>
                <td width="15%">성 별</td>
                <td>
                    <input type="radio" name="gender" value="male" <?php if ($gender == "male") echo "checked";?>>남성
					&nbsp;<input type="radio" name="gender" value="female" <?php if ($gender == "female") echo "checked";?>>여성
                </td>
            </tr>
            <tr height="7">
                <td colspan="3"><hr /></td>
            </tr>
            <tr class="register" height="30">
                <td width="5%" align="center">*</td>
                <td width="15%">휴대전화</td>
                <td><input type="tel" name="CellPhone" value="<?=$CellPhone?>"></td>
            </tr>
            <tr height="7">
                <td colspan="3"><hr /></td>
            </tr>
        </table>
        <br />
        <table>
            <tr height="40">
                <td>
					<input type="submit" value="확인"  width="120">&nbsp;
					<input type="button" value="취소"  width="120" onclick="location.href='/animal/animal.php'">	
				</td>
            </tr>
        </table>
    </form>
</center>

</body>
</html>