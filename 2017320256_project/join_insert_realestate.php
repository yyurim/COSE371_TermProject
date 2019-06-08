<?php
include "config.php"; //데이터베이스 연결 설정파일 
include "util.php"; //유틸 함수
   error_reporting(E_ALL);

ini_set("display_errors", 1);
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$corp_reg_num = $_POST['corp_reg_num'];
$id = $_POST['member_id'];
$pass = $_POST['passwd']; 
$c_pass = $_POST['c_passwd'];
$realEstateName = $_POST['realEstateName'];
$phone = $_POST['phone'];
$add = $_POST['address'];
$agentName = $_POST['agentName'];

mysqli_query($connect, "set autocommit = 0");
mysqli_query($connect, "set transaction isolation level serializable");
mysqli_query($connect, "begin");

$ret = mysqli_query($connect, "select realEstateID from realEstate where realEstateID='$id'"); //ID 조사

if(!$ret) {
	mysqli_query($connect, "rollback");
	msg('불러오기에 실패하였습니다. 다시 시도하여 주십시오.');
}

else {
	$num = mysqli_num_rows($ret);

	if($num) {
		mysqli_query($connect, "commit");
		msg('존재하는 아이디입니다');
	}
	else if(check_pass($pass,$c_pass)!=0) {
		mysqli_query($connect, "commit");
		msg('비밀번호가 다릅니다'); 
	}	
	else {
//PASS 조사
	
	$insert_query = "insert into realEstate (corpRegNum, realEstateID, realEstateName, password, phone, location, agentName) values ('$corp_reg_num','$id','$realEstateName','$pass', '$phone', '$add', ' $agentName')";
	$insert_ret = mysqli_query($connect, $insert_query);
	
		if(!$insert_ret) {
			mysqli_query($connect, "rollback");
			msg('가입하기에 실패하였습니다. 다시 시도하여 주십시오');
		}
		else {
			mysqli_query($connect, "commit");
			s_msg('환영합니다');
			echo "<meta http-equiv='refresh' content='0;url=login.php'>";
		}
	}
}
mysqli_close($connect);
?>