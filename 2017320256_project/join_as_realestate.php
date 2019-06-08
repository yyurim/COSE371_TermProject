<?php 
include "header.php";
include "config.php";  
include "util.php";     

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

?>
	<div class="container">
        <form name="join_form" action="join_insert_realestate.php" method="post" class="form-group">
            <h1>JOIN</h1>
            </br>
            <div class="form-group">
            	<label for="corpRegNum">사업자번호</label>
                <input class="form-control" type="text" id="corpRegNum" name="corpRegNum"/>
            </div>
            <div class="form-group">
            	<label for="member_id">아이디</label>
                <input class="form-control" type="text" id="member_id" name="member_id"/>
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
            	<label for="realEstateName">사업장이름</label>
                <input class="form-control" type="text" id="realEstateName" name="realEstateName" value="<?=$member['realEstateName']?>"/>
            </div>
            <div class="form-group">
            	<label for="phone">사업장주소</label>
                <input class="form-control" type="text" id="address" name="address" value="<?=$member['address']?>" />
            </div>
            <div class="form-group">
            	<label for="agentName">중개인</label>
                <input class="form-control" type="text" id="agentName" name="agentName" value="<?=$member['agentName']?>"/>
            </div>
            <div class="form-group">
            	<label for="phone">전화번호 (-없이 입력)</label>
                <input class="form-control" type="number" id="phone" name="phone" value="<?=$member['phone']?>" />
            </div>
            
            <p align="center"><button class="button primary large" onclick="javascript:return validate();">가입하기</button></p>

            <script>
                function validate() {
                	if(document.getElementById("corpRegNum").value == "") {
                        alert ("사업자번호를 입력하세요"); return false;
                    }
                	else if(document.getElementById("mem_id").value == "") {
                        alert ("아이디 입력하세요"); return false;
                    }
                    else if(document.getElementById("passwd").value == "") {
                        alert ("비밀번호를 입력하세요"); return false;
                    }
                    else if(document.getElementById("realEstateName").value == "") {
                        alert ("사업장이름을 입력하세요"); return false;
                    }
                    else if(document.getElementById("address").value == "") {
                        alert ("사업장주소를 입력하세요"); return false;
                    }
                    else if(document.getElementById("agentName").value == "") {
                        alert ("중개인이름을 입력하세요"); return false;
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
