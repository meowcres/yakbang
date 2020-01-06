<?php
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

// 일반번호 앞번호
$phone_array = array(
    "02",
    "031",
    "032",
    "033",
    "041",
    "042",
    "043",
    "051",
    "052",
    "053",
    "054",
    "055",
    "061",
    "062",
    "063",
    "064",
    "010",
    "011",
    "016",
    "017",
    "018",
    "019",
    "0130",
    "0502",
    "0503",
    "0505",
    "0506",
    "070",
    "080"
);
reset($phone_array);

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
                <form name="frm" id="frm" method="post" enctype="multipart/form-data" action="./_action/member.do.php"
                      style="display:inline;" target="actionForm">
                    <input type="hidden" id="Mode" name="Mode" value="apply_pharmacy_add">
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
										<input type="number" id="zipcode" name="zipcode" title="우편번호입력폼">
										<input type="button" value="주소">
									</span>
                                    <span>
										<input type="text" id="address" name="address" title="주소입력창">
									</span>
                                    <span>
										<input type="text" id="address_ext" name="address_ext" title="주소입력창">
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
										<select id="phone1" name="phone1">
											<?
                                            foreach ($phone_array as $val) {
                                                $_selected = $val == $_phone_obj[0] ? "selected" : "";
                                                ?>
                                                <option value="<?= $val ?>" <?= $_selected ?>><?= $val ?></option><?
                                            }
                                            ?>
										</select>
									</span><em>-</em>
                                    <span><input type="tel" id="phone2" name="phone2"></span><em>-</em>
                                    <span><input type="tel" id="phone3" name="phone3"></span>
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

<script language="JavaScript" type="text/JavaScript">

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
        /*if ($("#zipcode").val() == "") {
            alert("약국주소 검색을 진행 해 주십시오");
            return false;
        }*/
        $("#frm").submit();
    }

</script>
