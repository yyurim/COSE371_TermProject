<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

   error_reporting(E_ALL);

ini_set("display_errors", 1);
?>

<div id="page" class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    mysqli_query($conn, "set autocommit = 0");
	mysqli_query($conn, "set transaction isolation level read committed");
	mysqli_query($conn, "begin");
    
    $query = "select * from property natural left join realEstate where contractAs = '전세'";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where propertyNO like '%$search_keyword%' or realEstateID like '%$search_keyword%'";
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
    	mysqli_query($conn, "rollback");
        die('Query Error : ' . mysqli_error());
    }
    else {
    	mysqli_query($conn, "commit");
    }
    ?>
	<h1>전세</h1></br></br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
        	<th>매물등록번호</th>
            <th>매물이름</th>
            <th>매물위치</th>
            <th>전용면적</th>
            <th>층수</th>
			<th>가격</th>
            <th>중개사무소</th>
            <th>REGISTERED DATE</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td><a href='property_view.php?propertyNO={$row['propertyNO']}'>{$row['propertyNO']}</a></td>";
            echo "<td><a href='property_view.php?propertyNO={$row['propertyNO']}'>{$row['propertyName']}</td>";
            echo "<td>{$row['propertyAddress']}</td>";
            echo "<td>{$row['area']}</td>";
            echo "<td>{$row['floor']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td>{$row['realEstateName']}</td>";
            echo "<td>{$row['regDate']}</td>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
</div>
<? include("footer.php") ?>
