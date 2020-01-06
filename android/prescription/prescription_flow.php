<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

$ps_code = $_REQUEST["ps_code"];

$qry_sel  = " SELECT * ";
$qry_001  = " FROM {$TB_PS} ";
$qry_001 .= " WHERE PS_CODE = '{$ps_code}' ";

$res_001 = $db->exec_sql($qry_sel . $qry_001);
$row_001 = $db->sql_fetch_array($res_001);
?>
<!-- content start -->
<div class="coNtent">
	<div class="position_wrap">
		<span>스마트 처방조제</span>
		<span>e처방전</span>
	</div>
	<div class="inner_coNtwrap">
		<div class="fixedbodycoNt">
			<div class="pspSend_wrap2">
			   <div class="eINgList_head"><?=$ps_code?></div>
			   <ul class="eINgList">
                   <?php
                   foreach ($prescription_status_array as $key => $val) {
                       ?>
                       <li <?=$key == $row_001["PS_STATUS"] ? "class='on'" : ""?>>
                           <span>Step0<?=$key?>. <?=$val?></span>
                       </li>
                       <?
                   }
                   ?>
				   <!--<li class="on"><span>Step01. 처방전 확인 (선택없음)</span></li>
				   <li><span>Step02. 약국 선택 (의뢰대기)</span></li>
				   <li><span>Step03. 결제정보 선택 (선택없음)</span></li>
				   <li><span>Step04. 조제상태 (대기)</span></li>
				   <li><span>Step05. 처방전 완료 (대기)</span></li>-->
			   </ul>
			</div>
            <div class="coNtBtn">
                <div class="coNtbtn_wrap">
                    <a href="./prescription_status.php?ps_code=<?=$ps_code?>" class="ecolor"><span class="btnicon00">상세보기</span></a>
                    <a href="javascript:void(0);" onclick="history.back();" class="ecolor_plus"><span class="btnicon01">목록으로</span></a>
                </div>
            </div>
		</div>
	</div>
</div>

<!-- content end -->

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>