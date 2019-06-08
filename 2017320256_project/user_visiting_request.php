<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

   error_reporting(E_ALL);

ini_set("display_errors", 1);


$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$userID = $_GET["userID"];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level read committed");
mysqli_query($conn, "begin");
    
$query = "select * from (visitingRequest natural join wishList) natural left outer join property where userID = '$userID'";
    
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
	<h1>모든 방문 신청 목록</h1></br></br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>방문신청번호</th>
            <th>매물등록번호</th>
            <th>방문예정일</th>
            <th>옵션</th>
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
            echo "<td width='17%'>
                <a href='visit_request.php?wishListNO={$row['wishListNO']}'><button class='button primary small'>수정하기</button></a>
                 <button onclick='javascript:deleteConfirm({$row['wishListNO']})' class='button danger small'>삭제하기</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(wishListNO) {
            if (confirm("방문 신청을 취소하시겠습니까??") == true){    //확인
                window.location = "visit_delete.php?wishListNO=" + wishListNO;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
