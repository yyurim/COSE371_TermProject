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


mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$ret1 = mysqli_query($conn, "select count(*) as count from visitingRequest natural join wishList where year = '$year' and month = '$month' and date = '$date' and propertyNO = '$propertyNO'");
$count = mysqli_fetch_array($ret1);

if($count['count']!='0')
{
	mysqli_query($conn, "rollback");
    msg('예약된 날짜입니다 '.mysqli_error($conn));
}
else{
	mysqli_query($conn, "commint");
}

$ret = mysqli_query($conn, "insert into visitingRequest (wishListNO, year, month, date, comment) values ('$wishListNO', '$year', '$month', '$date', '$comment')");

if(!$ret)
{
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit");
    s_msg ('방문 신청이 접수되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=user_visiting_request.php?userID=$userID'>";
}

?>

