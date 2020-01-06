<div id="Contents">
    <h1>커뮤니티 &gt; 게시판 &gt; <strong>FAQ 등록</strong></h1>

    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/board.do.php"
          onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
        <input type="hidden" id="mode" name="mode" value="add_faq">
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
                    <select id="f_type" name="f_type" class="w30p">
                        <?
                        $qry_type = "SELECT * FROM {$TB_CODE} WHERE CD_STATUS in ('y') AND CD_TYPE in ('FAQ')  ORDER BY ORDER_SEQ";
                        $res_type = $db->exec_sql($qry_type);
                        while ($row_type = $db->sql_fetch_array($res_type)) {
                            ?>
                            <option
                            value="<?= $row_type["CD_KEY"] ?>" <?= $_selected ?>><?= clear_escape($row_type["CD_TITLE"]) ?></option><?
                        }
                        ?>
                    </select>
                </td>
                <th>노출여부</th>
                <td class="left">
                    <input type="radio" id="f_status_y" name="f_status" value="y"> <label
                            for="f_status_y">노출</label> &nbsp;&nbsp;&nbsp;
                    <input type="radio" id="f_status_n" name="f_status" value="n" checked> <label for="f_status_n">숨김</label>
                </td>
            </tr>

            <tr>
                <th>질문</th>
                <td class="left">
                    <input type="text" id="f_question" name="f_question" value="" class="w90p">
                </td>
				<th>정렬순서</th>
				<td>
				<select id="order_seq" name="order_seq" class="w30p">
					<?php
					for($i=1; $i<=50; $i++) {
						$selected = $i == 25 ? "selected" : "";
					?>
						<option value="<?=$i?>" <?=$selected?>><?=$i?></option>
					<?
					}
					?>
				</select>
				</td>
            </tr>

            <tr>
                <th style="line-height:180%;">답변</th>
                <td colspan="3">
                    <textarea id="f_answer" name="f_answer" class="w95p h150"></textarea>
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

            if ($("#f_question").val() == "") {
                alert("질문을 입력 해 주시기 바랍니다");
                $("#f_question").focus();
                return false;
            }

            return;
        }

</script>