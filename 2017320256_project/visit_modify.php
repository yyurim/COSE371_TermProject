<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$userID = $_COOKIE['cookie_id'];
$year = $_POST['year'];
$month = $_POST['month'];
$date = $_POST['date'];
$comment = $_POST['comment'];
$wishListNO = $_POST['wishListNO'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$ret = mysqli_query($conn, "update visitingRequest set year = '$year', month = '$month', date = '$date', comment = '$comment' where wishListNO = '$wishListNO'");

if(!$ret)
{
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit");
    s_msg ('방문일정이 변경되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=user_likes_property.php?ID=$userID'>";
}

?>

