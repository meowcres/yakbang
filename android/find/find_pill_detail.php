<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

$pidx = $_REQUEST["pidx"];
$pCode = $_REQUEST["pCode"];
$pName = $_REQUEST["pName"];

$pill_idx = check_pill($pidx, $pCode, $pName);

$qry_001 = " SELECT t1.* FROM {$TB_PILL} AS t1 WHERE t1.IDX = '{$pill_idx}' ";
$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001)
?>
<!-- content start -->
<div class="coNtent">

	<div class="position_wrap">
		<span>약품 찾기</span>
		<span>의약품</span>
		<span>의약품 상세정보</span>
	</div>

    <div class="inner_coNtbtnwrap2">
        <div class="fixedbodycoNt">
            <div class="consulting_detail_wrap">           
                <ul class="cNdtBxList">
                    <li>
                        <span style="width:30%">분류명</span>
                        <span><?=$row_001["PILL_CATEGORY"]?></span>
                    </li>
                    <li>
                        <span style="width:30%">제형구분명</span>
                        <span><?=$row_001["PILL_CLASS"]?></span>
                    </li>
                    <li>
                        <span style="width:30%">일반명</span>
                        <span><?=$row_001["PILL_NAME"]?></span>
                    </li>
                    <li>
                        <span style="width:30%">일반명코드</span>
                        <span><?=$row_001["PILL_CODE"]?></span>
                    </li>
                    <li>
                        <span style="width:30%">투여경로명</span>
                        <span><?=$row_001["PILL_INJECTION"]?></span>
                    </li>
                    <li>
                        <span style="width:30%">함량내용</span>
                        <span><?=$row_001["PILL_MATERIAL"]?></span>
                    </li>
                    <li>
                        <span style="width:30%">약효분류코드</span>
                        <span><?=$row_001["PILL_MEDICINE_CODE"]?></span>
                    </li>
                    <li>
                        <span style="width:30%">단위</span>
                        <span><?=$row_001["PILL_UNIT"]?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="coNtBtn">
        <div class="coNtbtn_wrap">
            <a href="javascript:void(0);" onclick="history.back();" class="ecolor"><span class="noiMg">목록</span></a>
        </div>
    </div>

</div>
<!-- content end -->

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";