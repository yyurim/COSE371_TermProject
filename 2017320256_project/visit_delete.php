<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$wishListNO = $_GET['wishListNO'];
$userID = $_COOKIE['cookie_id'];

// -----------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($conn, "set autocommit = 0");					//------------------autocommit 해제
mysqli_query($conn, "set transaction isolation level read uncommitted"); //-isolation level 설정
mysqli_query($conn, "begin");								//--------------begins a transation
// -----------------------------------TRANSACION code 여기까지-------------------------------------

$ret = mysqli_query($conn, "delete from visitingRequest where wishListNO = $wishListNO");
?>

<?php
// -----------------------TRANSACION code 여기부터-----------------------------------
	if(!$ret){
		mysqli_query($conn, "rollback");		// ------------------------TRANSACION
		msg('Query Error : '.mysqli_error($conn));
	}
	else {
		mysqli_query($conn, "commit");			// ------------------------TRANSACION
    	s_msg ('방문신청이 취소되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=user_visiting_request.php?userID=$userID'>";
	}
// -----------------------TRANSACION code 여기까지-----------------------------------

?>
