<?php
include "config.php"; //데이터베이스 연결 설정파일 
include "util.php"; //유틸 함수
   error_reporting(E_ALL);

ini_set("display_errors", 1);
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$id = $_POST['mem_id'];
$pass = $_POST['passwd']; 
$c_pass = $_POST['c_passwd'];
$name = $_POST['mem_name'];
$phone = $_POST['phone'];

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($connect, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($connect, "set transaction isolation level serializable"); //--isolation level 설정
mysqli_query($connect, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------



$res = mysqli_query($connect, "select userID from user where userID='$id'"); //ID 조사

// -----------------------TRANSACION code 여기부터-----------------------------------
if(!$res) {
	mysqli_query($connect, "rollback");			// ------------------------TRANSACION 
	msg('불러오기에 실패하였습니다. 다시 시도하여 주십시오.');
}
else {
	$num = mysqli_num_rows($res);

	if($num) {
		mysqli_query($connect, "commit");		// ------------------------TRANSACION 
		msg('존재하는 ID입니다');
	}
	else if(check_pass($pass,$c_pass)!=0) {
		mysqli_query($connect, "commit");		// ------------------------TRANSACION 
		msg('비밀번호가 다릅니다'); 
	}	
	else {

	$insert_query = "insert into user (userID, userName, password, phone) values ('$id','$name','$pass', '$phone')";


	$insert_ret = mysqli_query($connect, $insert_query);
	
		if(!$insert_ret) {
			mysqli_query($connect, "rollback");	// ------------------------TRANSACION 
			msg('가입하기에 실패하였습니다. 다시 시도하여 주십시오');
		}
		else {
			mysqli_query($connect, "commit");	// ------------------------TRANSACION 
			s_msg('환영합니다');
			echo "<meta http-equiv='refresh' content='0;url=login.php'>";
		}
	}
}
// -----------------------TRANSACION code 여기까지-----------------------------------

mysqli_close($connect);
?>