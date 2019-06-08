<?php 
include "header.php";
include "config.php";  
include "util.php";     

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

?>
	<div class="container">
		<p align="center">당신은 누구신가요?</p>
		<p align="center"><a href='join_as_user.php'><button class="button primary large">일반 회원</button></a></p>
		<p align="center"><a href='join_as_realestate.php'><button class="button primary large">중개사무소</button></a></p>
		
	</div>