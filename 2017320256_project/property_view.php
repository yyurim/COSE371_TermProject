<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("propertyNO", $_GET)) {
    $propertyNO = $_GET["propertyNO"];
 
// ------------------------------------TRANSACION code 여기부터-------------------------------------
	mysqli_query($conn, "set autocommit = 0");					//---------------autocommit 해제
	mysqli_query($conn, "set transaction isolation level serializable"); //--isolation level 설정
	mysqli_query($conn, "begin");								//-----------begins a transation
// ------------------------------------TRANSACION code 여기까지-------------------------------------
   
    $query = "select * from property natural left join realEstate where propertyNO = $propertyNO";
    $res = mysqli_query($conn, $query);
    
 // -----------------------TRANSACION code 여기부터-----------------------------------
    if(!$res) {
    	mysqli_query($conn, "rollback");		// ------------------------TRANSACION
    }
    else {
    	mysqli_query($conn, "commit");			// ------------------------TRANSACION
    }
// -----------------------TRANSACION code 여기까지-----------------------------------
   
    $property = mysqli_fetch_assoc($res);
    if (!$property) {
        msg("PRODUCT DOESN'T EXIST.");
    }
}
$propertyNO= $_GET["propertyNO"];
$move = $_COOKIE['cookie_id'];
?>
    <div class="container fullwidth">
        <h1>상세정보</h1></br>
        <?php
            switch($_COOKIE['cookie_login_as']){
   				case(1):
					echo "<p align='right'><a href='user_add_to_wishlist.php?propertyNO={$propertyNO}'><button class='button primary small'>관심 매물로 추가</button></a></p>";
				break;
            }
        ?>
		<div class="form-group">
			<label for="propertyNO">매물등록번호</label>
            <input class="form-control" readonly type="text" id="propertyNO" name="propertyNO" value="<?= $property['propertyNO'] ?>"/>
		</div>
		<div class="form-group">
            	<label for="propertyName">매물 이름</label>
                <input class="form-control" readonly type="text" placeholder="이름을 입력해주세요" id="propertyName" name="propertyName" value="<?=$property['propertyName']?>"/>
        </div>
        <div class="form-group">
            	<label for="type">매물 유형</label>
                <input class="form-control" readonly type="text" id="type" name="type" value="<?=$property['type']?>"/>
        </div>
        <div class="form-group">
            <label for="area">전용 면적</label>
            <input class="form-control" readonly type="float" placeholder="단위 : m^2"  id="area" name="area" value="<?=$property['area']?>" />
        </div>

        <div class="form-group">
            <label for="propertyAddress">매물 주소</label>
            <input class="form-control" readonly type="text" placeholder="주소를 입력해주세요" id="propertyAddress" name="propertyAddress" value="<?=$property['propertyAddress']?>"/>
        </div>

        <div class="form-group">
            <label for="price">가격</label>
            <input class="form-control" readonly type="number" placeholder="price" id="price" name="price" value="<?=$property['price']?>" />
        </div>
        <div class="form-group">
            <label for="room">방 수</label>
            <input class="form-control" readonly type="number" placeholder="ONLY INTEGER" id="room" name="room" value="<?=$property['room']?>" />
        </div>
        <div class="form-group">
            <label for="bathroom">화장실 수</label>
            <input class="form-control" readonly type="number" placeholder="ONLY INTEGER" id="bathroom" name="bathroom" value="<?=$property['bathroom']?>" />
        </div>
        <div class="form-group">
            <label for="floor">층수</label>
            <input class="form-control" readonly type="number" placeholder="ONLY INTEGER" id="floor" name="floor" value="<?=$property['floor']?>" />
        </div>
        <div class="form-group">
            	<label for="comment">상세정보</label>
                <textarea class="form-control" readonly placeholder="설명을 입력해주세요" id="comment" name="comment" rows="10"><?=$property['comment']?></textarea>
        </div>
		<div class="form-group">
			<label for="realEstateName">중개사무소</label>
			<input class="form-control" readonly type="text" id="realEstateName" name="realEstateName" value="<?=$property['realEstateName']?>"/>
		</div>

		<?php 
		echo "<p align='center'><a href='visiting_request_list.php?propertyNO={$propertyNO}'><button class='button primary large'>방문신청목록</button></a></p>"

		?>
    </div>
    
   

<? include("footer.php") ?>