<?php 
include "header.php";
include "config.php";  
include "util.php";     

   error_reporting(E_ALL);

ini_set("display_errors", 1);
$conn = dbconnect($host, $dbid, $dbpass, $dbname);

// --------------------------------TRANSACION code 여기부터--------------------------------------
mysqli_query($conn, "set autocommit = 0");					//----------------autocommit 해제
mysqli_query($conn, "set transaction isolation level read committed"); //-isolation level 설정
mysqli_query($conn, "begin");								//-----------begins a transation
// --------------------------------TRANSACION code 여기까지--------------------------------------


$realEstateID = $_GET["ID"];
$query =  "select * from realEstate where realEstateID = '$realEstateID'";
$ret = mysqli_query($conn, $query);

// -----------------------TRANSACION code 여기부터-----------------------------------
if(!$ret) {
	mysqli_query($conn, "rollback");			// ------------------------TRANSACION
	msg('불러오기가 실패하였습니다. 다시 시도하여 주십시오.');
}

else {
	mysqli_query($conn, "commit");				// ------------------------TRANSACION
}
// -----------------------TRANSACION code 여기까지-----------------------------------


$realEstate = mysqli_fetch_array($ret);
if(!$realEstate) {
	msg("NOT VALID ACCESS."); // 회원이 존재하지 않음
}

?>
	<div class="container">
		<h1>내 정보</h1>

        <form name="join_form" action="realEstate_join_modify.php" method="post" class="fullwidth form-group">
            <input type="hidden" id="ID" name="ID" value="<?=$realEstate['realEstateID']?>"/>
            <div class="form-group">
                <label for="corpRegNum">사업자등록번호</label>
            	<input lass="form-control" readonly type="text"  id="corpRegNum" name="corpRegNum" value="<?=$realEstate['corpRegNum']?>"/>
            </div>
            <div class="form-group">
                <label for="ID">아이디</label>
            	<input lass="form-control" readonly type="text"  id="ID" name="ID" value="<?=$realEstate['realEstateID']?>"/>
            </div>
            <div class="form-group">
            	<label for="member_password">비밀번호</label>
                <input class="form-control" type="password" id="passwd" name="passwd" rows="10"/>
            </div>
            
            <div class="form-group">
            	<label for="c_member_password">비밀번호 확인</label>
                <input class="form-control" type="password" id="c_passwd" name="c_passwd" rows="10"/>
            </div>
            <div class="form-group">
                <label for="name">사업장이름</label>
                <input class="form-control" type="text" id="name" name="name" value="<?=$realEstate['realEstateName']?>"/>
            </div>
			<div class="form-group">
            	<label for="address">사업장주소</label>
                <input class="form-control" type="text" id="m_address" name="m_address" value="<?=$realEstate['location']?>" />
            </div>
            <div class="form-group">
            	<label for="agentName">대표</label>
                <input class="form-control" readonly type="text" id="agentName" name="agentName" value="<?=$realEstate['agentName']?>" />
            </div>
            <div class="form-group">
            	<label for="phone">전화번호</label>
                <input class="form-control" type="int" id="m_phone" name="m_phone" value="<?=$realEstate['phone']?>" />
            </div>
            
            <p align="center"><button class="button primary large" onclick="javascript:return validate();">수정하기</button></p>
	
            <script>
                function validate() {
                    if(document.getElementById("passwd").value == "") {
                        alert ("비밀번호를 입력해주세요"); return false;
                    }
                    else if(document.getElementById("name").value == "") {
                        alert ("사업장이름을 입력해주세요"); return false;
                    }
                    else if(document.getElementById("m_address").value == "") {
                        alert ("사업장주소를 입력해주세요"); return false;
                    }
                    else if(document.getElementById("m_phone").value == "") {
                        alert ("전화번호를 입력해주세요"); return false;
                    }

                    return true;
                }
            </script>
        </form>
   <!--
        <script>
        function deleteConfirm(member_id) {
            if (confirm("정말 탈퇴하시겠습니까?") == true){    //확인
                window.location = "join_delete.php?d_ID=" + member_id;
            }else{   //취소
                return;
            }
        }
    	</script>
    -->
    	<?php
    		echo "<p align='center'><a href='realEstate_join_delete.php?realEstateID={$realEstateID}'><button class='button primary large'>탈퇴하기</button></a></p>";
        ?>
    </div>
<? include ("footer.php") ?>