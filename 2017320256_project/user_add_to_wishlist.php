<?php
include "config.php"; //데이터베이스 연결 설정파일 
include "util.php"; //유틸 함수
error_reporting(E_ALL);

ini_set("display_errors", 1);
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$check = $_GET["propertyNO"];

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($connect, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($connect, "set transaction isolation level serializable"); //--isolation level 설정
mysqli_query($connect, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------


$ret = mysqli_query($connect, "select * from property where propertyNO = $check");

// -----------------------TRANSACION code 여기부터-----------------------------------
if (!$ret) {
	mysqli_query($connect, "rollback");			// ------------------------TRANSACION
	msg('불러오기가 실패하였습니다. 다시 시도하여 주십시오.');
}
else {
	mysqli_query($connect, "commit");			// ------------------------TRANSACION
}
// -----------------------TRANSACION code 여기까지-----------------------------------




$row=mysqli_fetch_array($ret);
$propertyNO= $row['propertyNO'];

    
if(!$_COOKIE['cookie_id'] || !$_COOKIE['cookie_name']) {
	msg('로그인 후 이용해주세요');
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";

}
else {
	$id = $_COOKIE['cookie_id'];
	$res = mysqli_query($connect, "insert into wishList (userID, propertyNO) values ('$id', '$propertyNO')");

// -----------------------TRANSACION code 여기부터-----------------------------------
	if(!$res) {
		mysqli_query($connect, "rollback");		// ------------------------TRANSACION
		msg('등록에 실패했습니다.');
	}
	else {

		mysqli_query($connect, "commit");		// ------------------------TRANSACION
		msg('등록에 성공했습니다.');
		echo "<meta http-equiv='refresh' content='0;url=user_likes_property.php?ID={$id}'>";
	}
// -----------------------TRANSACION code 여기까지-----------------------------------
		
}
?>