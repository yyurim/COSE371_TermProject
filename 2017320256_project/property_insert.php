<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$propertyName = $_POST['propertyName'];
$realEstateID = $_POST['realEstateID'];
$type = $_POST['type'];
$area = $_POST['area'];
$floor = $_POST['floor'];
$room = $_POST['room'];
$bathroom = $_POST['bathroom'];
$propertyAddress = $_POST['propertyAddress'];
$contractAs = $_POST['contractAs'];
$comment = $_POST['comment'];
$price = $_POST['price'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$insert_query = "insert into property(realEstateID, propertyName, type, area, floor, room, bathroom, propertyAddress, contractAs, comment, regDate, price) values('$realEstateID', '$propertyName', '$type', '$area', '$floor', '$room', '$bathroom', '$propertyAddress', '$contractAs', '$comment', NOW(), '$price')";
$ret = mysqli_query($conn, $insert_query);


if(!$ret){
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else{
	
	mysqli_query($conn, "commit");

	s_msg ('성공적으로 입력 되었습니다');

	if($contractAs == '월세'){
		    echo "<meta http-equiv='refresh' content='0;url=property_list_monthly.php'>";
	}
	else if($contractAs == '전세'){
			echo "<meta http-equiv='refresh' content='0;url=property_list_yearly.php'>";
	}
	else{
			echo "<meta http-equiv='refresh' content='0;url=property_list_buynsell.php'>";
	}
}

?>

