<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

   error_reporting(E_ALL);

ini_set("display_errors", 1);


$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$propertyNO = $_GET["propertyNO"];
    
mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level read committed");
mysqli_query($conn, "begin");
    
$query = "select * from (visitingRequest natural join wishList) natural left outer join property where propertyNO = '$propertyNO'";
    
$res = mysqli_query($conn, $query);
if (!$res) {
	mysqli_query($conn, "rollback");
    die('Query Error : ' . mysqli_error());
}
else {
   	mysqli_query($conn, "commit");
}


?>

<div class="container">
	<h1>방문신청목록</h1></br></br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>방문신청번호</th>
            <th>매물등록번호</th>
            <th>방문예정일</th>
            <th>신청인</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td><a href='request_view.php?requestNO={$row['requestNO']}'>{$row['requestNO']}</td>";
            echo "<td><a href='property_view.php?propertyNO={$row['propertyNO']}'>{$row['propertyNO']}</td>";
            echo "<td>{$row['year']}년{$row['month']}월{$row['date']}일</td>";
            echo "<td>{$row['userID']}</td>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
</div>
<? include("footer.php") ?>
