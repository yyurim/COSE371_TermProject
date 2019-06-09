<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$propertyNO = $_GET['propertyNO'];
$move = $_COOKIE['cookie_id'];

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($conn, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($conn, "set transaction isolation level read committed"); //isolation level 설정
mysqli_query($conn, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------


$query =  "select * from property natural join realEstate where propertyNO = $propertyNO";
$res = mysqli_query($conn, $query);

// -----------------------TRANSACION code 여기부터-----------------------------------
if (!$res) {
 	mysqli_query($conn, "rollback");			// ------------------------TRANSACION
 	msg('불러오기에 실패하였습니다. 다시 시도하여 주십시오');
}

else {
	$property = mysqli_fetch_array($res);
	$ret = mysqli_query($conn, "delete from property where propertyNO = $propertyNO");

	if(!$ret){
		mysqli_query($conn, "rollback");		// ------------------------TRANSACION
    	msg('Query Error : '.mysqli_error($conn));
	}
	else{
		mysqli_query($conn, "commit");			// ------------------------TRANSACION
    	s_msg ('propertyNO : '.$property['propertyNO'].' PRODUCT NAME : '.$property['propertyName'].' SUCCESSFULLY DELETED');
    	echo "<meta http-equiv='refresh' content='0;url=realEstate_my_property.php?ID=$move'>";
	}	
}
// -----------------------TRANSACION code 여기까지-----------------------------------




?>

