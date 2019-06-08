<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$propertyNO = $_GET['propertyNO'];
$move = $_COOKIE['cookie_id'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level read committed");
mysqli_query($conn, "begin");

$query =  "select * from property natural join realEstate where propertyNO = $propertyNO";
$res = mysqli_query($conn, $query);

if (!$res) {
 	mysqli_query($conn, "rollback");
 	msg('불러오기에 실패하였습니다. 다시 시도하여 주십시오');
}

else {
	$property = mysqli_fetch_array($res);
	$ret = mysqli_query($conn, "delete from wishList where propertyNO = $propertyNO");

	if(!$ret){
		mysqli_query($conn, "rollback");
    	msg('Query Error : '.mysqli_error($conn));
	}
	else{
		mysqli_query($conn, "commit");
    	s_msg ('propertyNO : '.$property['propertyNO'].' property NAME : '.$property['propertyName'].' 성공적으로 삭제되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=user_likes_property.php?ID=$move'>";
	}	
}



?>

