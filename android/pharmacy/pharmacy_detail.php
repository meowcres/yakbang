<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

$idx = $_REQUEST["idx"];

$qry_001  = " SELECT t1.*, t2.*, t3.*, t4.* ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$qry_001 .= " FROM {$TB_PHARMACY} t1 ";
$qry_001 .= " LEFT JOIN {$TB_PP} t2 ON ( t1.PHARMACY_CODE = t2.PHARMACY_CODE )";
$qry_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t2.USER_ID = t3.USER_ID )";

$qry_001 .= " LEFT JOIN {$TB_ATTECH_FILES} t4 ON ( t1.PHARMACY_CODE = t4.REFERENCE_CODE ) ";

$qry_001 .= " WHERE t1.IDX = '{$idx}' ";
$qry_001 .= " ORDER BY t2.P_GRADE DESC, t2.REG_DATE ";

$res_001  = $db->exec_sql($qry_001);
$row_001  = $db->sql_fetch_array($res_001);

$pic_url  = "../../Web_Files/pharmacy/"; 

/*
$qry_002  = " SELECT PHYSICAL_NAME ";
$qry_002 .= " FROM {$TB_ATTECH_FILES} ";
$qry_002 .= " WHERE REFERENCE_CODE = '{$row_001["PHARMACY_CODE"]}' AND TYPE_CODE = 'pharmacy_img' ";

$res_002  = $db->exec_sql($qry_002);
$row_002  = $db->sql_fetch_row($res_002);
*/

$p_name   = $row_001["PHYSICAL_NAME"];


?>
<!-- content start -->
<div class="coNtent">
	<div class="position_wrap">
		<span>스마트 처방조제</span>
		<span>약국선택</span>
		<span>지도</span>
	</div>
	<div class="inner_coNtwrap">
		<div class="fixedbodycoNt2">
			<div class="pharmacy_slide_wrap">
				<div class="pharSlide">
					<div class="swiper-wrapper">
						<div class="swiper-slide" style="background-image:url(' <?=$pic_url.$p_name?> ');"></div>
						<div class="swiper-slide" style="background-image:url(' <?=$pic_url.$p_name?> ');"></div>
						<div class="swiper-slide" style="background-image:url(' <?=$pic_url.$p_name?> ');"></div>
					</div>
				</div>
				<ul class="slide_thumbs">
					<li class="swiper-pagination-switch on"><a href="javascript:void(0);" style="background-image:url(' <?=$pic_url.$p_name?> ');"></a></li>
					<li class="swiper-pagination-switch"><a href="javascript:void(0);" style="background-image:url(' <?=$pic_url.$p_name?> ');"></a></li>
					<li class="swiper-pagination-switch"><a href="javascript:void(0);" style="background-image:url(' <?=$pic_url.$p_name?> ');"></a></li>
				</ul>
			</div>
			<!-- slide area -->
			<div class="pharmacy_tab_wrap">
				<ul class="pharTab">
					<li class="on"><a href="pamc00">소개</a></li>
					<li><a href="pamc01">전문약사</a></li>
					<li><a href="pamc02">추천약품</a></li>
				</ul>
				<div class="pamc_show" id="pamc00">
					<?= $row_001["INTRODUCTION"] ?> 
				<div class="pamc_show" id="pamc01">
                    <?php
                    $res_001  = $db->exec_sql($qry_001);
                    while($row_001  = $db->sql_fetch_array($res_001)) {
                        $grade = $row_001["P_GRADE"] == 1 ? "협동약사" : "메인약사";
                        echo $grade."-".$row_001["mm_name"]."<br>";
                    }
                    ?>
				</div>
				<div class="pamc_show" id="pamc02">
					content3
				</div>
			</div>
			<!-- tab menu -->
		</div>
		<!-- overflow scroll -->
	</div>
	<!-- in content -->
</div>
<!-- content end -->

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>