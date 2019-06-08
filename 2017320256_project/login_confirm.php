<?php
   include "config.php"; 
   include "util.php"; 
   error_reporting(E_ALL);

   ini_set("display_errors", 1);

   $conn = dbconnect($host,$dbid,$dbpass,$dbname);
   $login_as = $_POST['login_as'];
   $id = $_POST['mem_id'];
   $pwd = $_POST['mem_pwd'];
   
   mysqli_query($conn, "set autocommit = 0");
   mysqli_query($conn, "set transaction isolation level read committed");
   mysqli_query($conn, "begin");
   
   
   if($login_as == "1")
      	$ret = mysqli_query($conn, "select * from user where userID = '$id'");
   else if($login_as == "2")
      	$ret = mysqli_query($conn, "select * from realEstate where realEstateID = '$id'");



   if(!$ret) {
		 mysqli_query($conn, "rollback");
		 msg('불러오기가 실패하였습니다. 다시 시도하여 주십시오.');
   }
   else {
   		mysqli_query($conn, "commit");
   }
   
   $mem_num = mysqli_num_rows($ret); 
   
	if(!$mem_num) {
    	msg('NOT VALID ID');
	}
	else {
    	$mem_array = mysqli_fetch_array($ret);
    	
    	if($login_as == 1)
    		$db_name = $mem_array['userName'];
    	else if($login_as == 2)
    		$db_name = $mem_array['realEstateName'];

    	$db_pwd = $mem_array['password'];
    	if($db_pwd == $pwd) {
        	SetCookie("cookie_id", $id,0,"/"); // 0 : browser lifetime – 0 or omitted : end of session
        	SetCookie("cookie_name", $db_name,0, "/");
        	SetCookie("cookie_login_as", $login_as,0,"/");

        	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    	}
    	else {
      		msg('WRONG PASSWORD');
    	}   
	}
   
   mysqli_close($conn);
?>