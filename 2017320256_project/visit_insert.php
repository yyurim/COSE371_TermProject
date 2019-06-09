<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
error_reporting(E_ALL);

ini_set("display_errors", 1);
$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$year = $_POST['year'];
$month = $_POST['month'];
$date = $_POST['date'];
$comment = $_POST['comment'];
$wishListNO = $_POST['wishListNO'];
$propertyNO = $_POST['propertyNO'];
$userID = $_COOKIE['cookie_id'];

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($conn, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($conn, "set transaction isolation level serializable"); //--isolation level 설정
mysqli_query($conn, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------


$ret1 = mysqli_query($conn, "select count(*) as count from visitingRequest natural join wishList where year = '$year' and month = '$month' and date = '$date' and propertyNO = '$propertyNO'");
$count = mysqli_fetch_array($ret1);

// -----------------------TRANSACION code 여기부터-----------------------------------
if($count['count']!='0')
{
	mysqli_query($conn, "rollback");			// ------------------------TRANSACION
    msg('예약된 날짜입니다 '.mysqli_error($conn));
}
else{
	mysqli_query($conn, "commint");				// ------------------------TRANSACION
}
// -----------------------TRANSACION code 여기까지-----------------------------------

$ret = mysqli_query($conn, "insert into visitingRequest (wishListNO, year, month, date, comment) values ('$wishListNO', '$year', '$month', '$date', '$comment')");

// -----------------------TRANSACION code 여기부터-----------------------------------
if(!$ret)
{
	mysqli_query($conn, "rollback");			// ------------------------TRANSACION
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit");				// ------------------------TRANSACION
    s_msg ('방문 신청이 접수되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=user_visiting_request.php?userID=$userID'>";
}
// -----------------------TRANSACION code 여기까지-----------------------------------

?>

