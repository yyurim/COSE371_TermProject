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

mysqli_query($connect, "set autocommit = 0");
mysqli_query($connect, "set transaction isolation level read committed");
mysqli_query($connect, "begin");

$res = mysqli_query($connect, "select * from property natural left outer join realEstate where realEstateID = '$check'");
if (!$res) {
 	mysqli_query($connect, "rollback");
    die('Query Error : ' . mysqli_error());
}
else {
	mysqli_query($connect, "commit");
}
?>
<div id="page" class="container">
	<h1>나의 매물</h1></br>

	<table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>매물 번호</th>
            <th>매물 이름</th>
            <th>등록 일자</th>

            <th>옵션</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td><a href='property_view.php?propertyNO={$row['propertyNO']}'>{$row['propertyNO']}</a></td>";
            echo "<td><a href='property_view.php?propertyNO={$row['propertyNO']}'>{$row['propertyName']}</td>";
            echo "<td>{$row['regDate']}</td>";
         
            echo "<td width='17%'>
            	<a href='visiting_request_list.php?propertyNO={$row['propertyNO']}'><button class='button primary small'>방문신청확인</button></a>
                <a href='property_form.php?propertyNO={$row['propertyNO']}'><button class='button primary small'>수정하기</button></a>
                 <button onclick='javascript:deleteConfirm({$row['propertyNO']})' class='button danger small'>삭제하기</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(propertyNO) {
            if (confirm("매물을 삭제하시겠습니까??") == true){    //확인
                window.location = "realEstate_property_delete.php?propertyNO=" + propertyNO;
            }else{   //취소
                return;
            }
        }
    </script>
    
    <p align="center"><a href='realEstate_reg_property.php'><button class="button primary large">매물 등록</button></a></p>
</div>



<?include ("footer.php") ?>
