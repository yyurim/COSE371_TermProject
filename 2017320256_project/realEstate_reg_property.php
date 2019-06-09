<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
 $move = $_COOKIE[cookie_id];
if (!$move) {
    msg("LOGIN PLEASE.");
}
$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "등록하기";
$action = "property_insert.php";

// --------------------------------TRANSACION code 여기부터-------------------------------------
mysqli_query($conn, "set autocommit = 0");					//---------------autocommit 해제
mysqli_query($conn, "set transaction isolation level read committed"); //isolation level 설정
mysqli_query($conn, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지-------------------------------------


if (array_key_exists("propertyNO", $_GET)) {
    $propertyNO = $_GET["propertyNO"];
    $query =  "select * from property where propertyNO = $propertyNO";
    $res = mysqli_query($conn, $query);
    $property = mysqli_fetch_array($res);
    
    if(!$property) {
        msg("물품이 존재하지 않습니다.");
    }
    $mode = "수정하기";
    $action = "property_modify.php";
}
?>
    <div id="page" class="container">
        <form name="property_insert" action="<?=$action?>" method="post" class="form-group">
            <input type="hidden" name="propertyNO" value="<?=$property['propertyNO']?>"/>
            <input type="hidden" name="realEstateID" value="<?=$move?>"/>
            <h1> 매물 정보 </h1></br>
            <div class="form-group">
            	<label for="contractAs">계약 형태</label></label>
                <select class="form-control" name="contractAs" id="contractAs">
                    <option value="0">선택해주세요</option>
                    <option  value="월세">월세</option>
            		<option  value="전세">전세</option>
					<option  value="매매">매매</option>  
                </select>
            </div>
            <div class="form-group">
            	<label for="propertyName">매물 이름</label>
                <input class="form-control" type="text" placeholder="이름을 입력해주세요" id="propertyName" name="propertyName" value="<?=$property['propertyName']?>"/>
            </div>
            <div class="form-group">
            	<label for="type">매물 유형</label></label>
                <select class="form-control" name="type" id="type">
                    <option value="0">선택해주세요</option>
                    <option  value="아파트">아파트</option>
            		<option  value="단독주택">단독주택</option>
            		<option  value="빌라">빌라</option>
            		<option  value="원룸">원룸</option>
					<option  value="투쓰리룸">투쓰리룸</option>  
                </select>
            </div>
            <div class="form-group">
            	<label for="area">전용 면적</label>
                <input class="form-control" type="int" placeholder="정수로 입력하세요" id="area" name="area" value="<?=$property['area']?>" />
            </div>
            <div class="form-group">
        		<label for="price">가격</label>
        		<input cllass="form-control" type="int" placeholder="price" id="price" name="price" value="<?=$property['price']?>"/>
    		</div>
            <div class="form-group">
            	<label for="propertyAddress">매물 주소</label>
                <input class="form-control" type="text" placeholder="주소를 입력해주세요" id="propertyAddress" name="propertyAddress" value="<?=$property['propertyAddress']?>"/>
            </div>

            <div class="form-group">
            	<label for="room">방 수</label>
                <input class="form-control" type="number" placeholder="ONLY INTEGER" id="room" name="room" value="<?=$property['room']?>" />
            </div>
            <div class="form-group">
            	<label for="bathroom">화장실 수</label>
                <input class="form-control" type="number" placeholder="ONLY INTEGER" id="bathroom" name="bathroom" value="<?=$property['bathroom']?>" />
            </div>
            <div class="form-group">
            	<label for="floor">층수</label>
                <input class="form-control" type="number" placeholder="ONLY INTEGER" id="floor" name="floor" value="<?=$property['floor']?>" />
            </div>
            <div class="form-group">
            	<label for="comment">상세정보</label>
                <textarea class="form-control" placeholder="설명을 입력해주세요" id="comment" name="comment" rows="10"><?=$property['comment']?></textarea>
            </div>
            

            <p align="center"><button class="button primary large" onclick="javascript:return validate();">등록하기</button></p>
			
            <script>
                function validate() {
                    if(document.getElementById("contractAs").value == "0") {
                        alert ("계약 형태를 선택해주세요"); return false;
                    }
                    else if(document.getElementById("area").value == "") {
                        alert ("전용 면적을 입력해주세요"); return false;
                    }
                    else if(document.getElementById("propertyAddress").value == "") {
                        alert ("매물주소를 입력해주세요"); return false;
                    }
                    else if(document.getElementById("price").value == "") {
                        alert ("가격을 입력해주세요"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>