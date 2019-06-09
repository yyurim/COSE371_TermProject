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

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($conn, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($conn, "set transaction isolation level serializable"); //--isolation level 설정
mysqli_query($conn, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------


$ret = mysqli_query($conn, "update property set propertyName = '$propertyName', type = '$type', area = '$area', floor = '$floor', room = '$room', bathroom = '$bathroom', propertyAddress = '$propertyAddress', contractAs = '$contractAs', comment = '$comment', price = '$price' where realEstateID = '$move' and propertyNO = '$propertyNO'");

// -----------------------TRANSACION code 여기부터-----------------------------------
if(!$ret){
	mysqli_query($conn, "rollback");			// ------------------------TRANSACION 
    msg('Query Error : '.mysqli_error($conn));
}
else{
	mysqli_query($conn, "commit");				// ------------------------TRANSACION 

	$query =  "select * from property natural right join realEstate where realEstateID = '$move' and propertyNO = '$propertyNO'";
	$res = mysqli_query($conn, $query);
	
	if(!$res) {
		mysqli_query($conn, "rollback");		// ------------------------TRANSACION 
	}
	else {
		mysqli_query($conn, "commit");			// ------------------------TRANSACION 
		$property = mysqli_fetch_array($res);
    	s_msg ('매물등록번호 '.$property['propertyNO'].' 매물이름 '.$property['propertyName'].' 매물정보가 성공적으로 수정 되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=property_view.php?propertyNO={$propertyNO}'>";
	}
}
// -----------------------TRANSACION code 여기까지-----------------------------------


?>

