<?
$phone_obj = explode("-", $_SITE["phone"]);
$fax_obj = explode("-", $_SITE["fax"]);
$email_obj = explode("@", $_SITE["email"]);
?>
<div id="Contents">
    <h1>환경설정 &gt; 환경 설정 &gt; <strong>사이트 정보관리</strong></h1>

    <form id="frm" name="frm">
        <input type="hidden" id="site_id" name="site_id" value="<?= $_SITE["id"] ?>" class="w90p">
        <input type="hidden" id="use_cookie" name="use_cookie" value="<?= $_SITE["use_cookie"] ?>" class="w90p">
        <table class="tbl1" summary="항목별 리스트 테이블">
            <colgroup>
                <col width="8%">
                <col width="13%">
                <col width="33%">
                <col width="13%">
                <col width="33">
            </colgroup>
            <tbody>
            <tr>
                <th colspan="2">Site Key</th>
                <td>
                    <?= $_SITE["id"] ?>
                </td>
                <th>Site ICON</th>
                <td>
                    <?
                    if (isNull($_SITE["icon"])) {
                        ?><input type="file" id="site_icon" name="site_icon" value="" class="w70p"><?
                    } else {
                        ?>
                        <input type="file" id="site_icon" name="site_icon" value="" class="w70p" style="display:none">
                        <div style="padding:10px 0;">
                            <img src="http://<?= $_SERVER["SERVER_NAME"] ?>/OG/<?= $_SITE["icon"] ?>" width="24"
                                 height="24"> &nbsp;
                            <input type="button" id="btn_del_icon" value="DELETE" class="button_red"
                                   style="height:24px;padding:0 5px;">
                        </div>
                        <?
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">적립금 요율방식</th>
                <td>
                    <select id="give_type" name="give_type">
                        <option value="point" <?php if ($_SITE["give_type"] == "point") {
                            echo "selected";
                        } ?>>point
                        </option>
                        <option value="percent" <?php if ($_SITE["give_type"] == "percent") {
                            echo "selected";
                        } ?>>percent
                        </option>
                    </select>
                </td>
                <th>요율설정</th>
                <td>
                    <input type="text" id="site_point" name="site_point" value="<?= $_SITE["point"] ?>" dir="rtl"
                           maxlength="2" class="w70 onlyNumbers"> Point &nbsp;&nbsp;/&nbsp;&nbsp;
                    <input type="text" id="site_percent" name="site_percent" value="<?= $_SITE["percent"] ?>" dir="rtl"
                           class="w70"> %
                </td>
            </tr>
            <tr>
                <th rowspan="5">META Info</th>
                <th>Site Name (og:title)</th>
                <td>
                    <input type="text" id="site_title" name="site_title" value="<?= $_SITE["title"] ?>" class="w90p">
                </td>
                <th>Site Type (og:type)</th>
                <td>
                    <input type="text" id="site_type" name="site_type" value="<?= $_SITE["type"] ?>" class="w90p">
                </td>
            </tr>
            <tr>
                <th>Image (og:image)</th>
                <td colspan="3">
                    <?
                    if (isNull($_SITE["image"])) {
                        ?><input type="file" id="site_image" name="site_image" value="" class="w90p"><?
                    } else {
                        ?>
                        <input type="file" id="site_image" name="site_image" value="" class="w90p" style="display:none">
                        <div style="padding:10px 0;">
                            <img src="http://<?= $_SERVER["SERVER_NAME"] ?>/OG/<?= $_SITE["image"] ?>" width="150">
                        </div>
                        <div style="padding:10px 0;">
                            <input type="button" id="btn_del_img" value="DELETE" class="button_red"
                                   style="height:24px;padding:0 5px;">
                        </div>
                        <?
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Site Url (og:url)</th>
                <td colspan="3">
                    http://<input type="text" id="site_url" name="site_url" value="<?= $_SITE["url"] ?>" class="w80p">
                </td>
            </tr>
            <tr>
                <th style="line-height:180%;">Site Comment<br>(og:description)</th>
                <td colspan="3">
                    <textarea id="site_description" name="site_description" class="w90p"
                              style="height:90px;"><?= $_SITE["description"] ?></textarea>
                </td>
            </tr>
            <tr>
                <th style="line-height:180%;">Site Keywords</th>
                <td colspan="3">
                    <textarea id="site_keywords" name="site_keywords" class="w90p"
                              style="height:90px;"><?= $_SITE["keywords"] ?></textarea>
                </td>
            </tr>

            <tr>
                <th rowspan="6">Footer Info</th>
                <th>상단 정보</th>
                <td>
                    <input id="site_up_name" name="site_up_name" type="text" value="<?= $_SITE["site_up_name"] ?>"
                           class="w80p">
                </td>
                <th>하단 정보</th>
                <td>
                    <input id="site_down_name" name="site_down_name" type="text" value="<?= $_SITE["site_down_name"] ?>"
                           class="w80p">
                </td>
            </tr>

            <tr>
                <th>대표자 성명</th>
                <td>
                    <input id="site_owner" name="site_owner" type="text" value="<?= $_SITE["owner"] ?>" class="w80p">
                </td>
                <th>개인정보 책임관리자</th>
                <td>
                    <input id="site_charge" name="site_charge" type="text" value="<?= $_SITE["charge"] ?>" class="w80p">
                </td>
            </tr>

            <tr>
                <th>사업자등록번호</th>
                <td>
                    <input id="business_number" name="business_number" type="text"
                           value="<?= $_SITE["business_number"] ?>" class="w80p">
                </td>
                <th>통신판매신고번호</th>
                <td>
                    <input id="sale_number" name="sale_number" type="text" value="<?= $_SITE["sale_number"] ?>"
                           class="w80p">
                </td>
            </tr>

            <tr>
                <th>대표번호</th>
                <td>
                    <input type="tel" id="phone1" name="phone1" value="<?= $phone_obj[0] ?>" maxlength="4" class="w60
                    onlyNumbers" onkeyup="passTab('phone1','phone3',4);"> -
                    <input type="tel" id="phone2" name="phone2" value="<?= $phone_obj[1] ?>" maxlength="4" class="w60
                    onlyNumbers" onkeyup="passTab('phone2','phone3',4);"> -
                    <input type="tel" id="phone3" name="phone3" value="<?= $phone_obj[2] ?>" maxlength="4" class="w60
                    onlyNumbers" onkeyup="passTab('phone3','phone4',4);">
                </td>
                <th>FAX 번호</th>
                <td>
                    <input type="tel" id="fax1" name="fax1" value="<?= $fax_obj[0] ?>" maxlength="4"
                           class="w60 onlyNumbers" onkeyup="passTab('fax1','fax2',4);"> -
                    <input type="tel" id="fax2" name="fax2" value="<?= $fax_obj[1] ?>" maxlength="4"
                           class="w60 onlyNumbers" onkeyup="passTab('fax2','fax3',4);"> -
                    <input type="tel" id="fax3" name="fax3" value="<?= $fax_obj[2] ?>" maxlength="4"
                           class="w60 onlyNumbers" onkeyup="passTab('fax3','fax4',4);">
                </td>
            </tr>

            <tr>
                <th>대표 메일</th>
                <td colspan="3">
                    <input id="email_id" name="email_id" type="text" value="<?= $email_obj[0] ?>" size="25"
                           style="ime-mode:disabled;"/> @
                    <input id="email_domain" name="email_domain" type="text" value="<?= $email_obj[1] ?>" size="30"
                           style="ime-mode:disabled;"/>
                    <select id="select_domin" name="select_domin" onChange="$('#email_domain').val(this.value)">
                        <option value="">Direct Entry</option>
                        <?
                        foreach ($email_array as $val) {
                            ?>
                            <option value="<?= $val ?>"><?= $val ?></option><?
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th>주소</th>
                <td colspan="3">
                    <input id="site_address" name="site_address" type="text" value="<?= $_SITE["address"] ?>"
                           class="w80p">
                </td>
            </tr>

            <tr>
                <th colspan="2">Copyright</th>
                <td colspan="3">
                    <input id="site_copyright" name="site_copyright" type="text" value="<?= $_SITE["copyright"] ?>"
                           class="w80p">
                </td>
            </tr>
            </tbody>
        </table>

        <div style="text-align:center; margin-top:30px;">
            <input type="button" id="btn_submit" value=" 정보변경 " class="Button btnOrange w120 h32"
                   onClick="form_submit()">
        </div>

</div>

<script language="javascript">

    function double_touch(id, bool) {
        var msg = bool === true ? "처리중" : "정보변경";
        $("#" + id).val(msg);
        $("#" + id).attr("disabled", bool);
    }


    //숫자만 입력
    $('.onlyNumbers').bind('keydown', function (e) {
        var keyCode = e.which;

        // 48-57 Standard Keyboard Numbers
        var isStandard = (keyCode > 47 && keyCode < 58);

        // 96-105 Extended Keyboard Numbers (aka Keypad)
        var isExtended = (keyCode > 95 && keyCode < 106);

        // 8 Backspace, 46 Forward Delete
        // 37 Left Arrow,   38 Up Arrow,        39 Right Arrow,
        // 40 Down Arrow
        var validKeyCodes = ',8,37,38,39,40,46,';
        var isOther = (-1 < validKeyCodes.indexOf(',' + keyCode + ','));
        if (isStandard || isExtended || isOther) {
            return true;
        } else {
            return false;
        }
    }).bind('blur', function () {
        // regular expression that matches everything that is
        // not a number
        var pattern = new RegExp('[^0-9]+', 'g');
        var $input = $(this);
        var value = $input.val();

        // clean the value using the regular expression
        value = value.replace(pattern, '');
        $input.val(value)
    });

    $('#btn_del_img').bind('click', function (e) {

        if (confirm("이미지를 삭제 하시겠습니까?")) {

            var _frm = new FormData();

            _frm.append("mode", "del_og_img");
            _frm.append("site_id", $("#site_id").val());

            $.ajax({
                method: 'POST',
                url: './_action/conf.do.php',
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "200" :
                            location.reload();
                            break;

                        case "400" :
                            alert("요청에 실패하였습니다");
                            break;

                        case "900" :
                            alert("Error");
                            break;
                    }
                }
            });
        }
    });


    $('#btn_del_icon').bind('click', function (e) {

        if (confirm("아이콘을 삭제하시겠습니까?")) {

            var _frm = new FormData();

            _frm.append("mode", "del_og_icon");
            _frm.append("site_id", $("#site_id").val());

            $.ajax({
                method: 'POST',
                url: './_action/conf.do.php',
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "200" :
                            location.reload();
                            break;

                        case "400" :
                            alert("요청에 실패하였습니다");
                            break;

                        case "900" :
                            alert("Error");
                            break;
                    }
                }
            });
        }
    });


    function form_submit() {
        // 두번클릭방지
        double_touch("btn_submit", true);

        // data validation
        if ($("#site_title").val() == "") {
            alert("Enter site name of META tag");
            $("#site_title").focus();
            double_touch("btn_submit", false);
            return false;
        }

        if ($("#site_up_name").val() == "") {
            alert("Please enter the top site name.");
            $("#site_up_name").focus();
            double_touch("btn_submit", false);
            return false;
        }

        if ($("#site_down_name").val() == "") {
            alert("Please enter the name of the lower site.");
            $("#site_down_name").focus();
            double_touch("btn_submit", false);
            return false;
        }

        var $icon_file = $("input[name=site_icon]");
        var $image_file = $("input[name=site_image]");
        var _site_phone = $("#phone1").val() + "-" + $("#phone2").val() + "-" + $("#phone3").val();
        var _site_fax = $("#fax1").val() + "-" + $("#fax2").val() + "-" + $("#fax3").val();
        var _site_email = $("#email_id").val() + "@" + $("#email_domain").val();
        var _frm = new FormData();

        _frm.append("mode", "update_information");

        _frm.append("site_id", $("#site_id").val());

        _frm.append("give_type", $("#give_type").val());
        _frm.append("site_point", $("#site_point").val());
        _frm.append("site_percent", $("#site_percent").val());
        _frm.append("site_title", $("#site_title").val());
        _frm.append("site_type", $("#site_type").val());
        _frm.append("site_url", $("#site_url").val());
        _frm.append("site_description", $("#site_description").val());
        _frm.append("site_keywords", $("#site_keywords").val());
        _frm.append("site_up_name", $("#site_up_name").val());
        _frm.append("site_down_name", $("#site_down_name").val());
        _frm.append("site_owner", $("#site_owner").val());
        _frm.append("site_charge", $("#site_charge").val());
        _frm.append("business_number", $("#business_number").val());
        _frm.append("sale_number", $("#sale_number").val());
        _frm.append("site_phone", _site_phone);
        _frm.append("site_fax", _site_fax);
        _frm.append("site_email", _site_email);
        _frm.append("site_address", $("#site_address").val());
        _frm.append("site_copyright", $("#site_copyright").val());
        _frm.append("use_cookie", $("#use_cookie").val());
        _frm.append("site_message", $("#site_message").val());

        /* 다중파일일 경우
        for(var _i = 0 ; _i < $image_file.length ; _i++){
            var _file = $image_file[_i].files[0];
            var _idx = (_i + 1) < 10 ? "0" + (_i + 1) : _i + 1;

            if(_file !== null){
                _frm.append("image_file_" + _idx, _file);
            }
        }
        */

        if ($icon_file[0].files[0] !== null) {
            _frm.append("icon_file", $icon_file[0].files[0]);
        }

        if ($image_file[0].files[0] !== null) {
            _frm.append("image_file", $image_file[0].files[0]);
        }


        $.ajax({
            method: 'POST',
            url: './_action/conf.do.php',
            processData: false,
            contentType: false,
            data: _frm,
            success: function (_res) {
                //console.log(_res) ;
                switch (_res) {
                    case "200" :
                        alert("정보변경이 완료되었습니다");
                        location.reload();
                        break;

                    case "400" :
                        alert("요청에 실패하였습니다");
                        double_touch("btn_submit", false);
                        break;

                    case "900" :
                        alert("Error");
                        double_touch("btn_submit", false);
                        break;
                }
            }
        });

    }

</script>