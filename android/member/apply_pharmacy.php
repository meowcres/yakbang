<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

?>

<!-- content start -->
<div class="coNtent">
    <div class="position_wrap">
        <span>My Page</span>
        <span>약국신청</span>
    </div>

    <div class="inner_coNtbtnwrap">
        <div class="fixedbodycoNt">
            <div class="pspSend_wrap">

                <p class="middleTxx">약국정보입력</p>
                <form name="frm" id="frm" method="post" enctype="multipart/form-data" action="../_action/member.do.php" style="display:inline;" target="actionForm">
                    <input type="hidden" id="Mode" name="Mode" value="apply_pharmacy_add">
                    <input type="hidden" id="user_id" name="user_id" value="<?= $mm_row["USER_ID"] ?>">

                    <table class="psptbl" summary="약국명,조제담당,조제료,조제내역,결제방법순으로 정의">
                        <caption>약국정보</caption>
                        <colgroup>
                            <col width="32%">
                            <col width="68%">
                        </colgroup>

                        <tbody>
                            <tr>
                                <th scope="row">약국명</th>
                                <td><input type="text" id="pharmacy_name" name="pharmacy_name"></td>
                            </tr>

                            <tr>
                                <th scope="row">약국주소</th>
                                <td>
                                    <div class="addr_wrap">
                                        <span class="pBtn">
                                            <input type="number" id="zipcode" name="zipcode" placeholder="우편번호를 입력해주세요" title="우편번호입력폼">
                                            <input type="button" value="주소" onClick="execDaumPostcode();">
                                        </span>

                                        <span>
                                            <input type="text" id="address" name="address" placeholder="주소를 입력해주세요" title="주소입력창">
                                        </span>

                                        <span>
                                            <input type="text" id="address_ext" name="address_ext" placeholder="세부주소를 입력해주세요" title="주소입력창">
                                        </span>
                                    </div>
                                </td>

                                <input type="hidden" value="" id="latitude" name="latitude"/>
                                <input type="hidden" value="" id="longtitude" name="longtitude"/>
                            </tr>

                            <tr>
                                <th scope="row">약국 연락처</th>
                                <td>
                                    <div class="phone_wrap">
                                        <span class="selectBox">
                                            <label for="phone1">02</label>
                                            <select id="phone1" name="phone1">
                                                <?
                                                foreach ($phone_array as $val) {
                                                    ?>
                                                    <option value="<?= $val ?>"><?= $val ?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </span>
                                        <em>-</em>
                                        <span><input type="tel" id="phone2" name="phone2" value="" maxlength="4"
                                               onkeyup="passTab('phone2','phone3',4);"></span>
                                        <em>-</em>
                                        <span><input type="tel" id="phone3" name="phone3" value="" maxlength="4"></span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">약국 메일</th>
                                <td>
                                    <div class="email_wrap">
                                        <span><input type="text" id="emailID" name="emailID"></span>
                                        <em>@</em>
                                        <span><input type="text" id="emailDomain" name="emailDomain"></span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">운영시간</th>
                                <td><textarea id="operation_hours" name="operation_hours"></textarea></td>
                            </tr>

                            <tr>
                                <th scope="row">약국소개</th>
                                <td><textarea id="introduction" name="introduction"></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </form>

            </div>
        </div>

        <!-- overflow scroll -->
    </div>
    <!-- in content -->

    <div class="coNtBtn">
        <div class="coNtbtn_wrap">
            <a href="javascript:void(0);" onclick="chk_form();" class="ecolor"><span class="btnicon04">약국 신청</span></a>
        </div>
    </div>
</div>
<!-- content end -->







<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>


<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script> <!-- 다음 주소 검색 api -->
<script language="JavaScript" type="text/JavaScript">

// 다음 우편번호 API
function execDaumPostcode(){
	new daum.Postcode({
		oncomplete: function(data) {
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

			// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
			// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
			var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
			var extraRoadAddr = ''; // 도로명 조합형 주소 변수

			// 법정동명이 있을 경우 추가한다. (법정리는 제외)
			// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
			if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
				extraRoadAddr += data.bname;
			}
			// 건물명이 있고, 공동주택일 경우 추가한다.
			if(data.buildingName !== '' && data.apartment === 'Y'){
				extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
			}

			// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
			if(extraRoadAddr !== ''){
				extraRoadAddr = ' (' + extraRoadAddr + ')';
			}

			// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
			if(fullRoadAddr !== ''){
				fullRoadAddr += extraRoadAddr;
			}

			// 우편번호와 주소 정보를 해당 필드에 넣는다.
			document.getElementById('zipcode').value = data.zonecode; //5자리 새우편번호 사용
			document.getElementById('address').value = fullRoadAddr;

			$("#address_ext").focus() ;

		}
	}).open();
}



function chk_form() {

    if ($("#pharmacy_name").val() == "") {
        alert("약국의 이름을 입력 해 주십시오");
        $("#pharmacy_name").val('');
        $("#pharmacy_name").focus();
        return false;
    }
    if ($("#phone2").val() == "") {
        alert("약국의 연락처를 입력 해 주십시오");
        $("#phone2").val('');
        $("#phone2").focus();
        return false;
    }
    if ($("#phone3").val() == "") {
        alert("약국의 연락처를 입력 해 주십시오");
        $("#phone3").val('');
        $("#phone3").focus();
        return false;
    }
    if ($("#emailID").val() == "") {
        alert("약국의 이메일을 입력 해 주십시오");
        $("#emailID").val('');
        $("#emailID").focus();
        return false;
    }
    if ($("#emailDomain").val() == "") {
        alert("약국의 이메일을 입력 해 주십시오");
        $("#emailDomain").val('');
        $("#emailDomain").focus();
        return false;
    }
    if ($("#zipcode").val() == "") {
        alert("약국주소 검색을 진행 해 주십시오");
        return false;
    }
    $("#frm").submit();
}

</script>
