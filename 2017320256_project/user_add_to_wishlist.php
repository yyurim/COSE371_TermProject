<?php
include "config.php"; //데이터베이스 연결 설정파일 
include "util.php"; //유틸 함수
error_reporting(E_ALL);

ini_set("display_errors", 1);
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$check = $_GET["propertyNO"];


mysqli_query($connect, "set autocommit = 0");
mysqli_query($connect, "set transaction isolation level serializable");
mysqli_query($connect, "begin");

$ret = mysqli_query($connect, "select * from property where propertyNO = $check");


if (!$ret) {
	mysqli_query($connect, "rollback");
	msg('불러오기가 실패하였습니다. 다시 시도하여 주십시오.');
}
else {
	mysqli_query($connect, "commit");
}



$row=mysqli_fetch_array($ret);
$propertyNO= $row['propertyNO'];

    
if(!$_COOKIE['cookie_id'] || !$_COOKIE['cookie_name']) {
	msg('로그인 후 이용해주세요');
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";

}
else {
	$id = $_COOKIE['cookie_id'];
	$res = mysqli_query($connect, "insert into wishList (userID, propertyNO) values ('$id', '$propertyNO')");
		
	if(!$res) {
		mysqli_query($connect, "rollback");
		msg('등록에 실패했습니다.');
	}
	else {

		mysqli_query($connect, "commit");
		msg('등록에 성공했습니다.');
		echo "<meta http-equiv='refresh' content='0;url=user_likes_property.php?ID={$id}'>";
	}
		
}
?>