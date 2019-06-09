<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$move = $_COOKIE['cookie_id'];
if (!$move) {
    msg("로그인 후 이용해주세요.");
}
$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "수정하기";
$action = "visit_modify.php";

$wishListNO = $_GET["wishListNO"];

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($conn, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($conn, "set transaction isolation level read committed"); //isolation level 설정
mysqli_query($conn, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------




	$query =  "select * from visitingRequest natural join wishList  where wishListNO = '$wishListNO'";
	$res = mysqli_query($conn, $query);

// -----------------------TRANSACION code 여기부터-----------------------------------
	if(!$res) {
		mysqli_query($conn, "rollback");		// ------------------------TRANSACION
	}
	else {
		
		$request = mysqli_fetch_array($res);
		
		if(!$request) {
    		$mode = "신청하기";
    		$action = "visit_insert.php";
		}
		
		$query2 = "select * from visitingRequest natural right outer join wishList where wishListNO = '$wishListNO'";
		$res2 = mysqli_query($conn, $query2);

		if(!$res2) {
			mysqli_query($conn, "rollback");	// ------------------------TRANSACION
		}
		else {
			mysqli_query($conn, "commit");		// ------------------------TRANSACION
			$property = mysqli_fetch_array($res2);
		}
	}
// -----------------------TRANSACION code 여기까지-----------------------------------



?>
    <div id="page" class="container">
        <form name="visit_request" action="<?=$action?>" method="post" class="fullwidth">
        	<input type="hidden" id="requestNO" name="requestNO" value="<?=$property['requestNO']?>"/>
        	<input type="hidden" id="wishListNO" name="wishListNO" value="<?=$wishListNO?>"/>
        	
            <h1>방문신청</h1></br></br>
            <p>
                <label for="propertyNO">property</label>
                <input readonly type="number" id="propertyNO" name="propertyNO" value="<?=$property['propertyNO'] ?>"/>
            </p>

            <div class="form-group">
            	<label for="visitingDate">방문일자</label>
            	<?php
                echo "<select class=\"form-control\" name=\"year\" id=\"year\">";
                echo "<option value=\"0\">선택해주세요</option>";
                for($year = 2019 ; $year <= 2024 ; $year++)
                    echo "<option value=\"$year\">$year</option>";
                echo "</select>";
                ?>
                <label for="year">년</label>

            	<?php
                echo "<select class=\"form-control\" name=\"month\" id=\"month\">";
                echo "<option value=\"0\">선택해주세요</option>";
                for($month = 1 ; $month <= 12 ; $month++)
                    echo "<option value=\"$month\">$month</option>";
                echo "</select>";
                ?>
                <label for="month">월</label>
                
            	<?php
                echo "<select class=\"form-control\" name=\"date\" id=\"date\">";
                echo "<option value=\"0\">선택해주세요</option>";
                for($date = 1 ; $date <= 31 ; $date++)
                    echo "<option value=\"$date\">$date</option>";
                echo "</select>";
                ?>
                <label for="date">일</label>
            </div>
            
            <div class="form-group">
            	<label for="comment">상세정보</label>
                <textarea class="form-control" placeholder="설명을 입력해주세요" id="comment" name="comment" rows="10"><?=$property['comment']?></textarea>
            </div>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("year").value == "0") {
                        alert ("방문하실 년도를 선택해주세요"); return false;
                    }
                    else if(document.getElementById("month").value == "0") {
                        alert ("방문하실 달을 선택해주세요"); return false;
                    }
                    else if(document.getElementById("month").value == "0") {
                        alert ("방문하실 날짜를 선택해주세요"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>