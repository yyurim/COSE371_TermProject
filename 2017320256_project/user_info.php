<?php 
include "header.php";
include "config.php";  
include "util.php";     

   error_reporting(E_ALL);

ini_set("display_errors", 1);
$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level read committed");
mysqli_query($conn, "begin");

$userID = $_GET["ID"];
$query =  "select * from user where userID = '$userID'";
$ret = mysqli_query($conn, $query);

if(!$ret) {
	mysqli_query($conn, "rollback");
	msg('불러오기가 실패하였습니다. 다시 시도하여 주십시오.');
}

else {
	mysqli_query($conn, "commit");
}

$user = mysqli_fetch_array($ret);
if(!$user) {
	msg("NOT VALID ACCESS."); // 회원이 존재하지 않음
}

?>
	<div class="container">
		<?
		if($_COOKIE['cookie_id']==$userID){
			echo "<h1>내 정보</h1>";
         }
         else{
         	echo "<h1>신청인 정보</h1>";
         }
         
         ?>
        <form name="join_form" action="user_join_modify.php" method="post" class="fullwidth form-group">
            <input type="hidden" id="ID" name="ID" value="<?=$user['userID']?>"/>
            
            <div class="form-group">
                <label for="name">이름</label>
                <input class="form-control" type="text" id="name" name="name" value="<?=$user['userName']?>"/>
            </div>
            <?
            if($_COOKIE['cookie_id']==$userID){
        		echo "<div class=\"form-group\">
        	    	<label for=\"member_password\">비밀번호</label>
            	    <input class=\"form-control\" type=\"password\" id=\"passwd\" name=\"passwd\" rows=\"10\"/>
            	</div>";
            
        		echo "<div class=\"form-group\">
            		<label for=\"c_member_password\">비밀번호 확인</label>
                	<input class=\"form-control\" type=\"password\" id=\"c_passwd\" name=\"c_passwd\" rows=\"10\"/>
            	</div>";
            }
            ?>
            <div class="form-group">
            	<label for="phone">전화번호</label>
                <input class="form-control" type="number" id="m_phone" name="m_phone" value="<?=$user['phone']?>" />
            </div>
			<?
            if($_COOKIE['cookie_id']==$userID){
            echo "<p align=\"center\"><button class=\"button primary large\" onclick=\"javascript:return validate();\">수정하기</button></p>";
	
            echo "<script>
                function validate() {
                    if(document.getElementById(\"name\").value == \"\") {
                        alert (\"이름을 입력해주세요\"); return false;
                    }
                    else if(document.getElementById(\"passwd\").value == \"\") {
                        alert (\"비밀번호를 입력해주세요\"); return false;
                    }
                    else if(document.getElementById(\"m_phone\").value == \"\") {
                        alert (\"전화번호를 입력해주세요\"); return false;
                    }

                    return true;
                }
            </script>";
            }
            ?>
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
    	if($_COOKIE['cookie_id']==$userID)
    		echo "<p align='center'><a href='user_join_delete.php?userID={$userID}'><button class='button primary large'>탈퇴하기</button></a></p>";
        ?>
    </div>
<? include ("footer.php") ?>