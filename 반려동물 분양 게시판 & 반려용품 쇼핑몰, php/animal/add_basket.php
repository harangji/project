 <?php
   session_start();
   $num = $_POST['num'];
   $title = $_POST['title'];
   $price = $_POST['price'];
   $userid = $_SESSION["userId"];
   $count = isset($_POST['count']) ? $_POST['count'] :1;
  
   require("db_connect.php");

        $query = $db->query("select * from basket where userid='$userid' and num = '$num'");

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {  
         
         $db->exec("update basket set count= count+$count where userid='$userid' and num = '$num'");
      } else {
		 $db->exec("insert into basket (num, title, price, count, userid)
                       values ('$num', '$title', '$price', '$count', '$userid')");
	  }
   header("Location:sec02.php");  
  ?>
  