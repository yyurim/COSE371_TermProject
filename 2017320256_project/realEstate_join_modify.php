<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
 error_reporting(E_ALL);

ini_set("display_errors", 1);
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$corpRegNum = $_POST['corpRegNum'];
$id = $_POST['ID'];
$pass = $_POST['passwd']; 
$c_pass = $_POST['c_passwd'];
$name = $_POST['name'];
$phone = $_POST['m_phone'];
$add = $_POST['m_address'];
$agentName = $_POST['agentName'];


if(check_pass($pass,$c_pass)!=0) {
    msg('WRONG PASSWORD'); 
}

mysqli_query($connect, "set autocommit = 0");
mysqli_query($connect, "set transaction isolation level serializable");
mysqli_query($connect, "begin");

$ret = mysqli_query($connect, "update realEstate set corpRegNum = '$corpRegNum', password = '$pass', realEstateName = '$name', phone = '$phone', location = '$add', agentName = '$agentName' where realEstateID = '$id'");

if(!$ret){
	mysqli_query($connect, "rollback");
	msg('Query Error : '.mysqli_error($connect));
}
else
{
	mysqli_query($connect, "commit");
    s_msg ('수정되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=realEstate_info.php?ID={$id}'>";
}

?>

