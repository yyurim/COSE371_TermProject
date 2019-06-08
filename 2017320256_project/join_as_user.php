<?php 
include "header.php";
include "config.php";  
include "util.php";     

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

?>
	<div class="container">
        <form name="join_form" action="join_insert_user.php" method="post" class="form-group">
            <h1>회원가입</h1>
            </br>
            <div class="form-group">
            	<label for="mem_id">아이디</label>
                <input class="form-control" type="text" id="mem_id" name="mem_id"/>
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
            	<label for="mem_name">이름</label>
                <input class="form-control" type="text" id="mem_name" name="mem_name" value="<?=$member['mem_name']?>"/>
            </div>
            <div class="form-group">
            	<label for="phone">전화번호(-없이 입력)</label>
                <input class="form-control" type="number" id="phone" name="phone" value="<?=$member['phone']?>" />
            </div>
            <p align="center"><button class="button primary large" onclick="javascript:return validate();">회원가입</button></p>

            <script>
                function validate() {
                	if(document.getElementById("mem_id").value == "") {
                        alert ("아이디 입력하세요"); return false;
                    }
                    else if(document.getElementById("mem_name").value == "") {
                        alert ("이름을 입력하세요"); return false;
                    }
                    else if(document.getElementById("passwd").value == "") {
                        alert ("비밀번호를 입력하세요"); return false;
                    }
                    else if(document.getElementById("phone").value == "") {
                        alert ("전화번호를 입력하세요"); return false;
                    }
                    return true;
                }
            </script>
            
        </form>
    </div>
<? include ("footer.php") ?>