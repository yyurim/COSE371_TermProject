 <?php
include "header.php";
include "config.php";  
include "util.php";    
 
 ?>
	<div id="page" class="container">
		<form name="form" action="login_confirm.php" method="post" class="fullwidth">
			<p align = "center">
				<label for="login_as">LOGIN AS</label>
            			<select style="width:10%; text-align : center" name="login_as">
            			<option  value= "1">일반회원</option>
						<option  value= "2">중개사무소</option>  
            			</select>
        	</p>
            <p align = "center">
            	<label for="mem_id">아이디</label>
                <input style="width:30%; text-align : center" type="text" id="mem_id" name="mem_id"/>
			</p>
            <p align = "center">
            	<label for="mem_pwd">비밀번호</label>
                <input style="width:35%; text-align : center" type="password"id="mem_pwd" name="mem_pwd"/>
            </p>
			<p align="center"><button class="button primary large">로그인</button></p>
        </form>
        <p align="center"><a href="join_who.php"><button class='button primary large'>회원가입</button></a></p>
    </div>
	
<?php include “footer.php”; ?>