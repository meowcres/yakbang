<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

if (isNull($_COOKIE["cookie_user_id"])) {
    alert_js("alert_parent_back","로그인 후 이용가능합니다.","");
}

?>
    <div class="coNtent">
        <div class="position_wrap">
            <span>상담</span>
            <span>상담목록</span>
            <span>상담등록</span>
        </div>
        <div class="inner_coNtbtnwrap">
            <div class="fixedbodycoNt">
                <div class="login_wrap">
                    <form method="POST" id="frm" name="frm" action="../_action/counsel.do.php" target="actionForm">
                        <input type="hidden" id="Mode" name="Mode" value="add_counsel">
                        <input type="hidden" name="c_write" id="c_write" value="<?= $mm_row["USER_ID"] ?>">
                        <input type="hidden" id="c_type" name="c_type" value="1">
                        <input type="hidden" id="sub_type" name="sub_type" value="">
                        
                        <fieldset>
                            <div class="inp_field">
                                <label for="c_title">제목<span class="imporTbullet">*</span></label>
                                <input type="text" name="c_title" id="c_title">
                            </div>
                            <div class="inp_field">
                                <label for="c_question">내용<span class="imporTbullet">*</span></label>
                                <textarea name="c_question" id="c_question" style="height: 150px"></textarea>
                            </div>
                            <p class="titTxxx">공개설정<span class="imporTbullet">*</span></p>

                            <ul class="tabChoice">
                                <li><a href="javascript:void(0);" class="oN">전체공개</a></li>
                                <li><a href="javascript:void(0);" class="showoN">비공개</a></li>
                            </ul>
                            
                            <div id="show_type" style="display:none">
                            <p class="titTxxx">비공개 대상선택</p>
                            <ul class="taBm">
                                <li><a href="c_mentor">멘토</a></li>
                                <li><a href="c_sex">약사</a></li>
                            </ul>

                            <div id="c_sex" class="inp_field2 showhidefield">
                                <p class="titTxxx">약사성별선택</p>
                                
                                <input type="radio" id="c_sex_all" name="c_sex" value="all">
                                <label for="c_sex_all">전체약사</label>

                                <input type="radio" id="c_sex_m" name="c_sex" value="M">
                                <label for="c_sex_m">남성약사</label>
                                
                                <input type="radio" id="c_sex_f" name="c_sex" value="F">
                                <label for="c_sex_f">여성약사</label>
                            </div>

                            <div id="c_mentor" class="inp_field showhidefield">
                                <span class="selectBox">
                                    <label for="c_mentor">멘토선택</label>
                                    <select name="c_mentor_list" id="c_mentor_list">
                                        <option value="">멘토선택</option>
                                        <?php
                                        $qry_001 = " SELECT t1.*, t2.* ";
                                        $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                                        $qry_001 .= " FROM {$TB_MENTOR} t1 ";
                                        $qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.MENTOR_ID = t2.USER_ID ) ";
                                        $qry_001 .= " WHERE t1.MENTEE_ID = '{$mm_row["USER_ID"]}' ";
                                        $res_001 = $db->exec_sql($qry_001);
                                        while ($row_001 = $db->sql_fetch_array($res_001)) {
                                            ?>
                                            <option value="<?= $row_001["USER_ID"] ?>"> <?= $row_001["mm_name"] ?> </option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                </span>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <!-- content end -->
            </div>
        </div>
        <div class="coNtBtn">
            <div class="coNtbtn_wrap">
                <a href="javascript:void(0);" onclick="chk_form();" class="ecolor"><span class="noiMg">상담 등록</span></a>
            </div>
        </div>
    </div>


<script>

function chk_form() {
    if ($("#c_title").val() == "") {
        alert("제목을 입력 해 주세요");
        $("#c_title").focus();
        return false;
    }
    if ($("#c_question").val() == "") {
        alert("내용 입력 해 주세요");
        $("#c_question").focus();
        return false;
    }

    var c_type = $('#c_type').val();
    var sub_type = $('#sub_type').val();
    var c_title = $('#c_title').val();
    var c_question = $('#c_question').val();
    var c_mentor_list = $('#c_mentor_list').val();
    var c_sex = $('input[name="c_sex"]:checked').val();
    var c_write = $('#c_write').val();

    if (c_type == "2" && sub_type == "" ) {
        alert("비공개 대상을 선택해 주세요.");
        return false;
    }

    if (sub_type == "c_mentor" && c_mentor_list == "" ) {
        alert("멘토를 선택해 주세요.");
        return false;
    }

    if (sub_type == "c_sex" && c_sex == undefined ) {
        alert("약사 성별을 선택해 주세요.");
        return false;
    }

    var _frm = new FormData();

    _frm.append("Mode", "add_counsel");
    _frm.append("c_type", c_type);
    _frm.append("sub_type", sub_type);
    _frm.append("c_title", c_title);
    _frm.append("c_question", c_question);
    _frm.append("c_mentor_list", c_mentor_list);
    _frm.append("c_sex", c_sex);
    _frm.append("c_write", c_write);

    $.ajax({
        method: 'POST',
        url: "../_action/counsel.do.php",
        processData: false,
        contentType: false,
        data: _frm,
        success: function (_res) {
            console.log(_res);
            switch (_res) {
                case "0" :
                    alert("상담을 등록하였습니다.");
                    location.href = "../counsel/counsel_list.php";
                    break;
                default :
                    alert("상담 등록 실패");
                    break;
            }
        }
    });
}

$(window).load(function(){
  $('.tabChoice > li > a').on('click', function(event) {

    event.preventDefault();
    
    if(!$(this).hasClass('oN')) {
      $(this).parent().siblings().find('a').removeClass('oN');
      $(this).addClass('oN');
    }

		if($('.showoN').hasClass('oN')){
      $('#c_type').val("2");
			$('#show_type').show();
		}else{
      $('#c_type').val("1");
			$('#show_type').hide();
		}
    });


	$('.taBm > li > a').on('click', function(evt) {
		evt.preventDefault();
		var target = $(this).attr('href');    
		$(this).parent().siblings().find('a').removeClass('onshow');
		$('.showhidefield').hide();
		$(this).addClass('onshow');
		$('#' + target).show();
    $('#sub_type').val(target);

	});
});

</script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
