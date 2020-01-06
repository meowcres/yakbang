<?php
include $_SERVER['DOCUMENT_ROOT']."/kor/inc/doctype.php";

$page_type 	= "sub";
$dep1_id 	= "07";
$dep2_id 	= "04";
$dep1_tit 	= "마이페이지";

include $_SERVER['DOCUMENT_ROOT']."/kor/inc/header.php";

$_idx = $_GET["idx"]   ;

$_sql = "SELECT t1.* FROM {$PF_TB} t1 WHERE t1.idx='{$_idx}'" ;
echo $_sql;
$_res = $db->exec_sql($_sql);
$_row = $db->sql_fetch_array($_res);
?>
    <script type="text/javascript" src="../../../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../../../js/jquery.form.min.js"></script>
    <script language="javascript" type="text/javascript" src="../../../js/js_ajax.js"> </script>
    <script language="javascript" type="text/javascript" src="../../../js/js_common.js"> </script>
    <script type="text/javascript" src="../../../js/ajax_select_client.js"></script>
    <script language="JavaScript">
        function chk_portfolio_form(){

            var large_idx = $("#large_idx").val();
            var middle_idx = $("#middle_idx").val();

            if(!large_idx){
                alert("대분류를 선택해 주세요.");
                $("#large_idx").val('');
                $("#large_idx").focus();
                return false;
            }

            if(!middle_idx){
                alert("소분류를 선택해 주세요.");
                $("#middle_idx").val('');
                $("#middle_idx").focus();
                return false;
            }

            $("#sfrm").ajaxForm({
                url : "../../../_action/expert.do.php",
                enctype : "multipart/form-data",
                dataType : "text",
                error:function(request,status,error){
                    alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                },
                success : function(result){
                    if(result=="non_idx"){
                        alert("수정 정보가 잘못되었습니다.") ;
                        return false;
                    }else{
                        alert(result);
                        alert("포트폴리오 등록이 완료되었습니다.") ;
                        location.reload();
                    }
                }
            });

            $("#sfrm").submit() ;
        }
    </script>
    <div id="container">
        <div id="s_title">
            <h2><?=$dep1_tit?></h2>
            <ul class="location">
                <li>HOME</li>
                <li><?=$dep1_tit?></li>
            </ul>
        </div><!-- //s_title -->

        <div id="contents">
            <?php include $_SERVER['DOCUMENT_ROOT']."/kor/inc/expert.mypage.php"; ?>
            <h3 class="p_title">포트폴리오관리</h3>
            <form name="sfrm" id="sfrm" method="post">
                <input type="hidden" name="Mode"   value="up_portfolio">
                <input type="hidden" name="idx" id="idx"   value="<?=$_idx?>" >

                <div class="mypage">
                    <div class="layout">
                        <h3 class="h3_txt">포트폴리오 수정</h3>
                        <div class="table_style05">
                            <table>
                                <caption>포트폴리오 수정</caption>
                                <colgroup>
                                    <col style="width:13%" />
                                    <col />
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th scope="row">분류선택</th>
                                    <td>
                                        <select name="large_idx" id="large_idx" onChange="change_middle_type(this.value);" class="wid30 mr10">
                                            <option value="">대분류선택</option>
                                            <?
                                            $_sl_sql  = "SELECT * FROM {$L_TYPE_TB} WHERE type_status='y' ORDER BY line_up desc " ;
                                            $_sl_res  = $db->exec_sql($_sl_sql);

                                            while($_sl_row  = $db->sql_fetch_array($_sl_res)){
                                                $selected = $_row["large_idx"] == $_sl_row["idx"] ? "selected" : "" ;
                                                ?><option value="<?=$_sl_row["idx"]?>" <?=$selected?>><?=$_sl_row["large_name"]?></option><?
                                            }
                                            ?>
                                        </select>
                                        <select name="middle_idx" id="middle_idx" class="wid30">
                                            <option value="">소분류선택</option>
                                            <?
                                            if(!isNull($_row["large_idx"])){
                                                $_sm_sql  = "SELECT * FROM {$M_TYPE_TB} WHERE type_status='y' AND large_idx = '".$_row["large_idx"]."' ORDER BY line_up desc " ;
                                                $_sm_res  = $db->exec_sql($_sm_sql);

                                                while($_sm_row  = $db->sql_fetch_array($_sm_res)){
                                                    $_selected = $_row["middle_idx"] == $_sm_row["idx"] ? "selected" : "" ;
                                                    ?><option value="<?=$_sm_row["idx"]?>" <?=$_selected?>><?=$_sm_row["middle_name"]?></option><?
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <!-- 분류 선택시 사진등록일 경우 -->
                                <tr>
                                    <th scope="row">이미지등록</th>
                                    <td>
                                        <div class="fileBox">
                                            <input type="text" class="fileName" readonly="readonly">
                                            <label for="uploadBtn" onclick="$('#img_1').click();" class="btn_file">첨부파일</label>
                                            <input type="file" name="img_1" id="img_1" class="uploadBtn">
                                        </div>
                                        <div class="fileBox pt10">
                                            <input type="text" class="fileName" readonly="readonly">
                                            <label for="uploadBtn1" onclick="$('#img_2').click();" class="btn_file">첨부파일</label>
                                            <input type="file" name="img_2" id="img_2" class="uploadBtn">
                                        </div>
                                        <div class="fileBox pt10">
                                            <input type="text" class="fileName" readonly="readonly">
                                            <label for="uploadBtn2" onclick="$('#img_3').click();" class="btn_file">첨부파일</label>
                                            <input type="file" name="img_3" id="img_3" class="uploadBtn">
                                        </div>
                                        <ul class="list_style01 pt5">
                                            <li>＊ 최적 사이즈 1200px X 800px (등록한 이미지는 가로사이즈에 맞춰 리사이징 되어 보여집니다.)</li>
                                            <li>＊ 첨부파일의 총 용량이 <em>00Mbite</em> 이상 일 경우 파일업로드가 실패할 수 있습니다.</li>
                                        </ul>
                                    </td>
                                </tr>

                                <!-- 분류 선택시 영상등록일 경우 -->
                                <tr>
                                    <th scope="row">영상등록</th>
                                    <td>
                                        <p>
                                            <input type="text" class="wid60" id="movie_url_1" name="movie_url_1" placeholder="youtube나 vimeo의 영상 URL 주소 붙여넣기" />
                                        </p>
                                        <p class="pt10">
                                            <input type="text" class="wid60" id="movie_url_2" name="movie_url_2" placeholder="youtube나 vimeo의 영상 URL 주소 붙여넣기" />
                                        </p>
                                        <p class="pt10">
                                            <input type="text" class="wid60" id="movie_url_3" name="movie_url_3" placeholder="youtube나 vimeo의 영상 URL 주소 붙여넣기" />
                                        </p>
                                        <p class="pt10">
                                            <input type="text" class="wid60" id="movie_url_4" name="movie_url_4" placeholder="youtube나 vimeo의 영상 URL 주소 붙여넣기" />
                                        </p>
                                        <p class="pt10">
                                            <input type="text" class="wid60" id="movie_url_5" name="movie_url_5" placeholder="youtube나 vimeo의 영상 URL 주소 붙여넣기" />
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- mypage e -->

                <div class="btn_area t_c">
                    <a href="#" onclick="javasript:reset();" class="btn_ev">등록 취소</a>
                    <a href="#" href="javascript:void(0);" onclick="chk_portfolio_form();" class="btn_ev btn01">등록 완료</a>
                </div>
            </form>
        </div><!-- //contents -->
    </div><!-- //container -->
<?php include $_SERVER['DOCUMENT_ROOT']."/kor/inc/footer.php"; ?>