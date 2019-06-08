<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$wishListNO = $_GET['wishListNO'];
$userID = $_COOKIE['cookie_id'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level read uncommitted");
mysqli_query($conn, "begin");

$ret = mysqli_query($conn, "delete from visitingRequest where wishListNO = $wishListNO");
?>

<?php
	if(!$ret){
		mysqli_query($conn, "rollback");
		msg('Query Error : '.mysqli_error($conn));
	}
	else {
		mysqli_query($conn, "commit");
    	s_msg ('방문신청이 취소되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=user_visiting_request.php?userID=$userID'>";
	}
?>
