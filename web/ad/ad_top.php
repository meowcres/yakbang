<?php
	include_once "../../_core/_init.php";

	$qry_001  = " SELECT t1.*, t2.PHYSICAL_NAME ";
	$qry_001 .= " FROM {$TB_AD} t1 ";
	$qry_001 .= " LEFT JOIN {$TB_ATTECH_FILES} t2 ON (t1.AD_CODE = t2.REFERENCE_CODE) ";
    $qry_001 .= " WHERE AD_STATUS = 'y' AND AD_TYPE = '1' ";
    $qry_001 .= " ORDER BY t1.IDX DESC ";
	$res_001  = $db->exec_sql($qry_001);
	$row_001  = $db->sql_fetch_array($res_001);

?>

<!-- 상단 광고 -->
<div class="htop">
  <div class="section_wrap heipx" style="background-image:url(../../_core/_files/ad/<?=$row_001["PHYSICAL_NAME"]?>);">
    <p class="txtin"><?=$row_001["AD_TITLE"]?><span><em><strong><?=$row_001["AD_TXT_1"]?></strong><?=$row_001["AD_TXT_2"]?></em><?=$row_001["AD_TXT_3"]?></span></p>
    <span class="chkbox">
      <input type="checkbox" id="winclose" name="">
      <label for="winclose">오늘 하루 이 창 열지 않기</label>
      <a href="" class="closeTbtn">닫기</a>
    </span>
  </div>
</div>


<script>
$(document).ready(function() {
    $(".htop .closeTbtn").click(function() {
        setCookie("todayCookie", "done", 1);
        $(".htop").hide();
    });
});
 
function setCookie(name, value, expiredays) {
    var todayDate = new Date();
    todayDate.setDate( todayDate.getDate() + expiredays );
    document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function getCookie () {
    var cookiedata = document.cookie;
    if (cookiedata.indexOf("todayCookie=done") < 0 ){
         $(".htop").show();
    }
    else {
        $(".htop").hide();
    }
}

getCookie();
</script>