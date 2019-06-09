<?php 
include ("header.php");
include "config.php"; //데이터베이스 연결 설정파일 
include "util.php"; //유틸 함수
error_reporting(E_ALL);

ini_set("display_errors", 1);
if (!array_key_exists("ID", $_GET)) {
    msg("로그인 후 이용해주세요.");
}
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$check = $_GET["ID"];

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($connect, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($connect, "set transaction isolation level read committed"); //isolation level 설정
mysqli_query($connect, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------


$ret = mysqli_query($connect, "select * from visitingRequest natural right outer join (wishList natural join property) where userID = '$check'");

// -----------------------TRANSACION code 여기부터-----------------------------------
if (!$ret) {
 	mysqli_query($connect, "rollback");			// ------------------------TRANSACION
    die('Query Error : ' . mysqli_error());
}
else {
	mysqli_query($connect, "commit");			// ------------------------TRANSACION
}
// -----------------------TRANSACION code 여기까지-----------------------------------


?>

<div id="page" class="container">
	<h1>관심 매물</h1></br>
	<?
	echo "<p align = 'right'><a href='user_visiting_request.php?userID={$check}'><button class='button primary large'>모든 방문 신청 목록</button></a></p>";
	?>
	<table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>매물 번호</th>
            <th>매물 이름</th>
            <th>옵션</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($ret)) {
            echo "<tr>";
            echo "<td><a href='property_view.php?propertyNO={$row['propertyNO']}'>{$row['propertyNO']}</a></td>";
            echo "<td><a href='property_view.php?propertyNO={$row['propertyNO']}'>{$row['propertyName']}</td>";
            echo "<td width='17%'><a href='visit_request.php?wishListNO={$row['wishListNO']}'><button class='button primary small'>방문신청</button></a>
				  <button onclick='javascript:deleteConfirm({$row['propertyNO']})' class='button danger small'>삭제</button></td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(propertyNO) {
            if (confirm("관심매물에서 삭제하시겠습니까?") == true){    //확인
                window.location = "user_wishlist_delete.php?propertyNO=" + propertyNO;
            }else{   //취소
                return;
            }
        }
    </script>
</div>



<?include ("footer.php") ?>
