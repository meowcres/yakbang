<?php
include_once "../_core/_lib/class.attach.php";
include_once "../_core/_init.php";

$pf_code = $_REQUEST["pf_code"];

$sel_001  = " SELECT t1.* ";
$from_001 = " FROM {$TB_PORTFOLIO} t1 ";
$qry_where_001 = " WHERE PF_CODE='{$pf_code}'" ;



$qry_001 = ($sel_001 .$from_001 .$qry_where_001);
$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

$_pic_url = "../_core/_files/etc/";

?>
<div id="Contents">
    <h1>기타관리 &gt; 포트폴리오 관리 &gt; <strong>포트폴리오 수정</strong></h1>

    <form id="frm" name="frm" method="post" action="./_action/etc.do.php" style="display:inline;"
          target="actionForm" enctype="multipart/form-data" >
        <input type="text" id="mode" name="mode" value="portfolio_update">
        <input type="text" id="pf_code"  name="pf_code"  value="<?=$pf_code?>">

        <table class="tbl1">
            <colgroup>
                <col width="10%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="15%"/>
            </colgroup>
            <tr>
                <th>코드</th>
                <td class="left">
                    <input type="text" id="pf_code" name="pf_code" value="<?= $pf_code ?>" readonly class="w90p"/>
                </td>
                <th>회사</th>
                <td class="left">
                    <select id="pf_company" name="pf_company" class="w100">
                        <option value="1" <?= row_001["PF_COMPANY"] == "1" ? "selected" : "" ?> > 1 </option>
                        <option value="2" <?= row_001["PF_COMPANY"] == "2" ? "selected" : "" ?> > 2 </option>
                    </select>
                </td>
                <th>상태</th>
                <td class="left">
                    <select id="pf_status" name="pf_status" class="w100">
                        <option value="Y" <?= row_001["PF_STATUS"] == "Y" ? "selected" : "" ?> > Y </option>
                        <option value="N" <?= row_001["PF_STATUS"] == "N" ? "selected" : "" ?> > N </option>
                    </select>
                </td>
                <th>분류</th>
                <td class="left">
                    <select id="pf_type" name="pf_type" class="w100">
                        <option value="1" <?= row_001["PF_TYPE"] == "1" ? "selected" : "" ?> > 1 </option>
                    </select>
                </td>

            </tr>
            <tr>
                <th>제목</th>
                <td class="left" colspan="8">
                    <input type="text" id="pf_title" name="pf_title" value="<?= $row_001["PF_TITLE"] ?>" class="w90p"/>
                </td>
            </tr>
            <tr>
                <th>내용</th>
                <td class="left" colspan="8">
                    <textarea id="pf_contents" name="pf_contents" class="w90p h150"><?= $row_001["PF_CONTENTS"] ?></textarea>
                </td>
            </tr>

            <?php
            $att_qry  = " SELECT * FROM {$TB_ATTECH_FILES} ";
            $att_qry .= " WHERE PARENT_CODE = '{$TB_PORTFOLIO}' AND REFERENCE_CODE = '{$pf_code}'";
            $att_qry .= " ORDER BY IDX DESC ";

            $att_res  = $db->exec_sql($att_qry);
            
            $_ph_num = 1;
            while ($att_row = $db->sql_fetch_array($att_res)) {

              ?>
              <tr>
                  <th>이미지 <?= $_ph_num ?></th>
                  <td class="left" colspan="8">
                          <div style="padding:10px;">
                              <img src="<?=$_pic_url.$att_row["PHYSICAL_NAME"]?>" width="300">
                          </div>
                          <div style="padding:10px 0;">
                              <input type="checkbox" id="del_portfolio_<?=$_ph_num?>" name="del_portfolio_<?=$_ph_num?>" value="<?=$att_row["PHYSICAL_NAME"]?>"/>
                              <label for="del_portfolio_<?=$_ph_num?>">portfolio_<?=$_ph_num?> 삭제</label>
                          </div>
                          
                          <input type="hidden" id="hidden_file_<?=$_ph_num?>" name="hidden_file_<?=$_ph_num?>" value="<?=$att_row["PHYSICAL_NAME"]?>">
                          <input type="file" id="up_portfolio_<?=$_ph_num?>" class="uploadBtn" name="up_portfolio_<?=$_ph_num?>" style="width:80%;">
                  </td>
              </tr>

              <?
              $_ph_num++;
            }

            for ($ii = $_ph_num; $ii <= 4; $ii++ ) {
              ?>
              <tr>
                  <th>이미지 <?= $ii ?></th>
                  <td class="left" colspan="8">
                          <input type="file" id="up_portfolio_<?=$ii?>" class="uploadBtn" name="up_portfolio_<?=$ii?>" style="width:80%;">
                  </td>
              </tr>
              <?
            }
            ?>

            <br>
        </table>
        <div style="margin-top:20px;" class="center">
            <input type="submit" value="수정" class="Button btnGreen w100"> &nbsp;
        </div>
    </form>

</div>
