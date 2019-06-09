<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$property;

if (array_key_exists("requestNO", $_GET)) {
    $requestNO = $_GET["requestNO"];

// ------------------------------------TRANSACION code 여기부터-------------------------------------
	mysqli_query($conn, "set autocommit = 0");					//---------------autocommit 해제
	mysqli_query($conn, "set transaction isolation level serializable"); //--isolation level 설정
	mysqli_query($conn, "begin");								//-----------begins a transation
// ------------------------------------TRANSACION code 여기까지-------------------------------------

    
    $query = "select * from (visitingRequest natural join wishList) natural left outer join property where requestNO = '$requestNO'";
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
        msg("방문신청이 존재하지 않습니다.");
    }
}
$requestNO= $_GET["requestNO"];
$move = $_COOKIE['cookie_id'];
?>
    <div class="container fullwidth">
        <h1>방문신청서</h1></br>
        
		<div class="form-group">
			<label for="propertyNO">매물등록번호</label>
            <input class="form-control" readonly type="text" id="propertyNO" name="propertyNO" value="<?= $property['propertyNO'] ?>"/>
		</div>

        
        <div class="form-group">
            	<label for="visitingDate">방문일자</label>
            	<input class="form-control" readonly type = "int" name="year" id="year" value="<?=$property['year']?>"/>
                <label for="year">년</label>
                <input class="form-control" readonly type = "int" name="month" id="month" value="<?=$property['month']?>"/>
                <label for="month">월</label>
                <input class="form-control" readonly type = "int" name="date" id="date" value="<?=$property['date']?>"/>
                <label for="date">일</label>
        </div>
        
        <div class="form-group">
            	<label for="comment">문의 사항</label>
                <textarea class="form-control" placeholder="설명을 입력해주세요" id="comment" name="comment" rows="10"><?=$property['comment']?></textarea>
            </div>
       
		<div class="form-group">
			<label for="realEstateName">신청인</label>
			<input class="form-control" readonly type="text" id="userID" name="userID" value="<?=$property['userID']?>"/>
		</div>


    </div>
    
   

<? include("footer.php") ?>