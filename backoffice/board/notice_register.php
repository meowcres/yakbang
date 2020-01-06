<div id="Contents">
    <h1>커뮤니티 &gt; 게시판 &gt; <strong>NOTICE 등록</strong></h1>

    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/board.do.php"  onSubmit="return chk_form(this);" style="display:inline;" target="!actionForm">
        <input type="hidden" id="mode" name="mode" value="add_notice">
        <table class="tbl1">
            <colgroup>
                <col width="12%"/>
                <col width="38%"/>
                <col width="12%"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>분류</th>
                <td class="left">
                    <select id="n_type" name="n_type" class="w95p">
                        <?
                        $qry_type = "SELECT * FROM {$TB_CODE} WHERE CD_STATUS in ('y') AND CD_TYPE in ('NOTICE')  ORDER BY ORDER_SEQ";
                        $res_type = $db->exec_sql($qry_type);
                        while ($row_type = $db->sql_fetch_array($res_type)) {
                            ?>
                            <option
                            value="<?= $row_type["CD_KEY"] ?>" <?= $_selected ?>><?= clear_escape($row_type["CD_TITLE"]) ?></option><?
                        }
                        ?>
                    </select>
                </td>
                <th>공지여부</th>
                <td class="left">
                    <input type="radio" id="n_status_y" name="n_status" value="y"> <label
                            for="n_status_y">공지</label> &nbsp;&nbsp;&nbsp;
                    <input type="radio" id="n_status_n" name="n_status" value="n" checked> <label for="n_status_n">일반</label>
                </td>
            </tr>

            <tr>
                <th>작성자</th>
                <td class="left">
                    <input type="text" id="n_writer" name="n_writer" value="<?= $_admin["name"] ?>" class="w95p">
                </td>
                <th>작성일</th>
                <td class="left">
                    <input type="text" id="reg_date" name="reg_date" value="<?= date("Y-m-d") ?>" style="width:200px;">
                </td>
            </tr>

            <tr>
                <th>제목</th>
                <td class="left" colspan="3">
                    <input type="text" id="n_title" name="n_title" value="" class="w95p">
                </td>
            </tr>

            <tr>
                <th style="line-height:180%;">내용</th>
                <td colspan="3">
                    <textarea id="n_contents" name="n_contents" class="w95p h150"><?= $_SITE["n_contents"] ?></textarea>
                </td>
            </tr>

            <tr>
                <th>목록이미지 (og:image)</th>
                <td colspan="3">
                    <input type="file" id="n_img" name="n_img" value="" class="w95p">
                </td>
            </tr>

            <tr>
                <th style="line-height:180%;">간단설명<br>(og:description)</th>
                <td colspan="3">
                    <textarea id="og_desc" name="og_desc" class="w95p h90"></textarea>
                </td>
            </tr>


            <tr>
                <th>원문주소</th>
                <td colspan="3">
                    <input type="text" id="n_addr" name="n_addr" value="" class="w95p">
                </td>
            </tr>


        </table>

        <div style="margin-top:20px;" class="center">
            <input type="submit" value="등록" class="Button btnGreen w100"> &nbsp;
            <input type="button" value="취소" class="Button btnRed w100" onClick="history.back();">
        </div>
    </form>

</div>


<script language="JavaScript" type="text/JavaScript">

        function chk_form(f) {
            if ($("#n_writer").val() == "") {
                alert("작성자를 입력 해 주시기 바랍니다");
                $("#b_writer").focus();
                return false;
            }

            if ($("#n_title").val() == "") {
                alert("제목을 입력 해 주시기 바랍니다");
                $("#b_title").focus();
                return false;
            }

            return;
        }

</script>