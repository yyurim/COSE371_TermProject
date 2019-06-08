<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by TEMPLATED
http://templated.co
Released for free under the Creative Commons Attribution License

Name       : Effeminate 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20140123

-->
<html lang='ko'>
<head>
	<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
	<title>HOME SWEET HOME</title>
		<meta charset = "UTF-8">
		<meta name = "viewport" content = "width = device - width, initial - scale = 1.0">
		<link rel = "stylesheet" href = "styles.css">
</head>

<body>
	<form action="property_list_monthly.php" method="post">
			<div class='navbar fixed'>
        		<div class='container'>
				<a class='pull-left title' href="index.php">HOME SWEET HOME</a>
				<ul class='pull-right'>
					<li class="search">
            		<label for="search_address">어느 동네를 찾고 계신가요?</label>
    				<input type="text" name="search_address" placeholder="(예) 서울시 성북구">	
                	</li>
    				<li><a href='property_list_monthly.php'>월세</a></li>
    				<li><a href='property_list_yearly.php'>전세</a></li>
    				<li><a href='property_list_buynsell.php'>매매</a></a></li>
    				
    				<?php
                	$move = $_COOKIE['cookie_id'];
                		if(!$_COOKIE['cookie_id'] || !$_COOKIE['cookie_name']) {
                			echo "<li><a href='join_who.php'>회원가입</a></li>
                			<li><a href='login.php'>로그인</a></li>";
                		}
                		else {
                			switch($_COOKIE['cookie_login_as']){
								case(1):
									echo"<li><a href='user_likes_property.php?ID={$move}'>관심 매물</a></li>";
									echo"<li><a href='user_info.php?ID={$move}'>내 정보</a></li>";
   									break;
   								case(2):
									echo"<li><a href='realEstate_my_property.php?ID={$move}'>나의 매물</a></li>";
									echo"<li><a href='realEstate_info.php?ID={$move}'>내 정보</a></li>";
									break;
                			}
                			echo"<li><a href='logout.php'>로그아웃</a></li>";
                			
                		}
                	?>
    			</ul>
			</div>
			</div>
	 </form>
