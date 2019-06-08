<?php include ("header.php"); ?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>


<form action="property_list.php" method="post">

    	<div class="container">
    			<p align = 'center'>
    			<h1>내집찾기</h1></br></br>
    			</p>
    			<p align = 'center'>
    				<div class="fullwidth">
            		<label for="contractAs">계약 형태</label>
                	<select style="width:10%; text-align : center" class="fullwidth" name="contractAs" id="contractAs">
                	    <option value="0">선택해주세요</option>
                	    <option  value="월세">월세</option>
            			<option  value="전세">전세</option>
						<option  value="매매">매매</option>  
                	</select>
                	<label for="type">매물유형</label>
                	<select style="width:10%; text-align : center" class="fullwidth" name="type" id="type">
	                    <option value="0">선택해주세요</option>
    	                <option  value="아파트">아파트</option>
        	    		<option  value="단독주택">단독주택</option>
            			<option  value="빌라">빌라</option>
            			<option  value="원룸">원룸</option>
						<option  value="투쓰리룸">투쓰리룸</option>  
                	</select>
            		<label for="search_address">주소</label>
    				<input style="width:30%; text-align : center" type="text" name="search_address" placeholder="주소를 입력하세요">	
    				</div>
    			</p>
    	
    	</div></br></br>
    	<script src="http://rochestb.github.io/jQuery.YoutubeBackground/src/jquery.youtubebackground.js"></script>
		<div id="video" class="background-video"></div>
		<script>
        $('#video').YTPlayer({
            fitToBackground: true,
            videoId: 'FjU_x1106pg'
        });
    	</script>

</form>    

    <div id="page" class="footer">
		<div class="title">

			<span class="byline">DATABASE TERM PROJECT</span> </div>
		<p> 본 사이트에서 사용된 리소스는 학술적 용도로만 사용되었으며, 상업적 사용은 제한됩니다</p>
		<ul class="actions">
			<li><a href="http://www.korea.ac.kr/mbshome/mbs/university/index.do" class="button">KOREA UNIVERSTIY</a></li>
		</ul>
	</div>

<? include ("footer.php"); ?>