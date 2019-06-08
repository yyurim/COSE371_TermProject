<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$propertyNO = $_POST['propertyNO'];
$propertyName = $_POST['propertyName'];
$type = $_POST['type'];
$area = $_POST['area'];
$floor = $_POST['floor'];
$room = $_POST['room'];
$bathroom = $_POST['bathroom'];
$propertyAddress = $_POST['propertyAddress'];
$contractAs = $_POST['contractAs'];
$comment = $_POST['comment'];
$price = $_POST['price'];

$move = $_COOKIE['cookie_id'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$ret = mysqli_query($conn, "update property set propertyName = '$propertyName', type = '$type', area = '$area', floor = '$floor', room = '$room', bathroom = '$bathroom', propertyAddress = '$propertyAddress', contractAs = '$contractAs', comment = '$comment', price = '$price' where realEstateID = '$move' and propertyNO = '$propertyNO'");


if(!$ret){
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else{
	mysqli_query($conn, "commit");

	$query =  "select * from property natural right join realEstate where realEstateID = '$move' and propertyNO = '$propertyNO'";
	$res = mysqli_query($conn, $query);
	
	if(!$res) {
		mysqli_query($conn, "rollback");
	}
	else {
		mysqli_query($conn, "commit");
		$property = mysqli_fetch_array($res);
    	s_msg ('매물등록번호 '.$property['propertyNO'].' 매물이름 '.$property['propertyName'].' 매물정보가 성공적으로 수정 되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=property_view.php?propertyNO={$propertyNO}'>";
	}
}

?>

