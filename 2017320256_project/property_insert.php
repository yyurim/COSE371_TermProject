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

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($conn, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($conn, "set transaction isolation level serializable"); //--isolation level 설정
mysqli_query($conn, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------


$insert_query = "insert into property(realEstateID, propertyName, type, area, floor, room, bathroom, propertyAddress, contractAs, comment, regDate, price) values('$realEstateID', '$propertyName', '$type', '$area', '$floor', '$room', '$bathroom', '$propertyAddress', '$contractAs', '$comment', NOW(), '$price')";
$ret = mysqli_query($conn, $insert_query);

// -----------------------TRANSACION code 여기부터-----------------------------------
if(!$ret){
	mysqli_query($conn, "rollback");			// ------------------------TRANSACION 
    msg('Query Error : '.mysqli_error($conn));
}
else{
	
	mysqli_query($conn, "commit");				// ------------------------TRANSACION 

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
// -----------------------TRANSACION code 여기까지-----------------------------------


?>

