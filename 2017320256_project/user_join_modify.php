<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
 error_reporting(E_ALL);

ini_set("display_errors", 1);
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$userID = $_POST['ID'];
$pass = $_POST['passwd']; 
$c_pass = $_POST['c_passwd'];
$userName = $_POST['name'];
$phone = $_POST['m_phone'];


if(check_pass($pass,$c_pass)!=0) {
    msg('WRONG PASSWORD'); 
}

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($connect, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($connect, "set transaction isolation level serializable"); //--isolation level 설정
mysqli_query($connect, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------


$ret = mysqli_query($connect, "update user set password = '$pass', userName = '$userName', phone = '$phone' where userID = '$userID'");

// -----------------------TRANSACION code 여기부터-----------------------------------
if(!$ret){
	mysqli_query($connect, "rollback");			// ------------------------TRANSACION	
	msg('Query Error : '.mysqli_error($connect));
}
else
{
	mysqli_query($connect, "commit");			// ------------------------TRANSACION
    s_msg ('수정되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=user_info.php?ID={$userID}'>";
}
// -----------------------TRANSACION code 여기까지-----------------------------------

?>

