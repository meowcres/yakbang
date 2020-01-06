<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

$ps_code = $_REQUEST["ps_code"];
$p_code = $_REQUEST["p_code"];

$qry_001  = " SELECT * ";
$qry_001 .= " FROM {$TB_PS} t1 ";
$qry_001 .= " WHERE PS_CODE = '{$ps_code}' ";

$res_001  = $db->exec_sql($qry_001);
$row_001  = $db->sql_fetch_array($res_001);

$qry_002  = " SELECT * ";
$qry_002 .= " FROM {$TB_PHARMACY} t1 ";
$qry_002 .= " WHERE PHARMACY_CODE = '{$p_code}' ";

$res_002  = $db->exec_sql($qry_002);
$row_002  = $db->sql_fetch_array($res_002);

$qry_003  = " SELECT t1.*, t3.PILL_NAME, t4.PHYSICAL_NAME ";
$qry_003 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$qry_003 .= " FROM {$TB_PS_PILL} t1 ";
$qry_003 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.PP_PHARMACIST = t2.USER_ID ) ";
$qry_003 .= " LEFT JOIN {$TB_PILL} t3 ON ( t1.PP_TITLE = t3.IDX ) ";
$qry_003 .= " LEFT JOIN {$TB_ATTECH_FILES} t4 ON ( t1.PP_PHARMACY = t4.REFERENCE_CODE ) ";


$qry_003 .= " WHERE ( PS_CODE = '{$ps_code}' AND PP_PHARMACY = '' ) OR ( PS_CODE = '{$ps_code}' AND PP_PHARMACY = '{$p_code}' ) ";
$qry_003 .= " ORDER BY PARENT_IDX, t1.IDX";
?>
<!-- content start -->
<div class="coNtent">
	<div class="position_wrap">
		<span>스마트 처방조제</span>
		<span>대체복약내역</span>
	</div>
	<div class="inner_coNtbtnwrap">
		<div class="fixedbodycoNt">
			<div class="pspSend_wrap">
				<table class="psptbl" summary="처방전 코드,생성일,처방전 형태순으로 정의">
					<caption>처방전 내용</caption>
					<colgroup>
						<col width="32%">
						<col width="68%">
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">처방전</th>
							<td><?=$ps_code?></td>
						</tr>
						<tr>
							<th scope="row">생성일</th>
							<td><?=$row_001["REG_DATE"]?></td>
						</tr>
						<tr>
							<th scope="row">처방전 형태</th>
							<td>사진<a href="../../Web_Files/pharmacy/<?=$row_001["PHYSICAL_NAME"]?>" class="imglink">이미지</a></td>
						</tr>
					</tbody>
				</table>
				<p class="middleTxx">결제내역</p>
				<table class="psptbl" summary="약국명,조제담당,조제료,조제내역,결제방법순으로 정의">
					<caption>약국정보</caption>
					<colgroup>
						<col width="32%">
						<col width="68%">
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">약국명</th>
							<td><?=stripslashes($row_002["PHARMACY_NAME"])?></td>
						</tr>
						<!--<tr>
							<th scope="row">조제담당</th>
							<td>홍길동</td>
						</tr>-->
						<tr>
							<th scope="row">조제료</th>
							<td>9000원</td>
						</tr>
						<tr>
							<th scope="row">조제내역</th>
                            <td>
                            <?php
                            $i = 1;
                            $res_003  = $db->exec_sql($qry_003);
                            while($row_003  = $db->sql_fetch_array($res_003)) {
                                if($row_003["PP_TYPE"] == 1) {
                                    echo $i . "." . stripslashes($row_003["PILL_NAME"]) . "<br>";
                                    $i++;
                                } else {
                                    echo "&nbsp;&nbsp;&nbsp;ㄴ 대체약품 : ".stripslashes($row_003["PP_TITLE"]) . "<br>";
                                }
                            }
                            ?>
                            </td>
							<!--<td>
								1.A얄약<br/>
								2.B얄약
							</td>-->
						</tr>
						<tr>
							<th scope="row">결제방법</th>
							<td>
								<input type="radio" id="card" checked="checked">
								<label for="card">카드</label>
								<input type="radio" id="hphone">
								<label for="hphone">핸드폰</label>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="coNtBtn">
		<div class="coNtbtn_wrap">
            <a href="./prescription_status.php?ps_code=<?=$ps_code?>" class="ecolor"><span class="btnicon00">목록으로</span></a>
			<a href="javascript:void(0);" onclick="payment('<?=$ps_code?>', '<?=$p_code?>');" class="ecolor_plus"><span class="btnicon01">결제신청</span></a>
		</div>
	</div>
</div>
<!-- content end -->
<script>
    function payment(ps_code, p_code) {
        if(confirm("결제를 신청하시겠습니까?")) {
            var _frm = new FormData();

            _frm.append("Mode", "payment");
            _frm.append("ps_code", ps_code);
            _frm.append("p_code", p_code);

            $.ajax({
                method: 'POST',
                url: "../_action/prescription.do.php",
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "0" :
                            alert("결제가 완료되었습니다.");
                            location.href = "../prescription/prescription_list.php";
                            break;
                        default :
                            alert("결제가 실패하였습니다.");
                            break;
                    }
                }
            });
        }
    }
</script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>