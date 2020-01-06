<?php
include_once "../_core/_lib/class.attach.php";
include_once "../_core/_init.php";

$qry_001 = " SELECT t1.* ";
$qry_001 .= " FROM {$TB_PORTFOLIO} t1 ";
$qry_001 .= " ORDER BY ORDER_SEQ, REG_DATE DESC ";

$_pic_url = "../_core/_files/etc/";


?>


<div id="Contents">
    <h1>기타 관리 > 포트폴리오 관리 > <strong>포트폴리오 목록</strong></h1><br>
    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/etc.do.php" style="display:inline;"
          target="actionForm">
        <input type="hidden" id="mode" name="mode" value="portfolio_add">
        <table class='tbl1'>
            <table class='tbl1'>
                <colgroup>
                    <col width="20%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                    <col width="*"/>
                    <col width="10%"/>
                </colgroup>

                <tr>
                    <th>이미지</th>
                    <th>COMPANY</th>
                    <th>상태</th>
                    <th>제목</th>
                    <th>관리</th>
                </tr>
                <?php
                $res_001 = $db->exec_sql($qry_001);


                while ($row_001 = $db->sql_fetch_array($res_001)) {

                    $information_ref = "./admin.template.php?slot=etc&type=portfolio_update&pf_code=" . $row_001["PF_CODE"];
                    $del_ref = "./_action/etc.do.php?mode=portfolio_delete&pf_code=" . $row_001["PF_CODE"];
                 
                    ?>
                    <tr>
                        <td>
                        <?php
                        $att_qry  = " SELECT * FROM {$TB_ATTECH_FILES} ";
                        $att_qry .= " WHERE PARENT_CODE = '{$TB_PORTFOLIO}' AND REFERENCE_CODE = '{$row_001["PF_CODE"]}'";
                        $att_qry .= " ORDER BY IDX DESC ";
                        
                        $att_res  = $db->exec_sql($att_qry);
                        
                        while ($att_row = $db->sql_fetch_array($att_res)) {
                          ?><img src="<?= $_pic_url . $att_row["PHYSICAL_NAME"]?>" width="50"><?
                        }
                        ?>
                        </td>
                        <td class="center"><?= $row_001["PF_COMPANY"] ?></td>
                        <td class="center"><?= $row_001["PF_STATUS"] ?></td>
                        <td class="center"><?= $row_001["PF_TITLE"] ?></td>
                        <td class="center">
                            <input type="button" value="수정" class="Small_Button btnGreen w80"
                                   onClick="location.href='<?= $information_ref ?>'">
                            <input type="button" value="삭제" class="Small_Button btnRed w80"
                                   onClick="del_ok('<?= $row_001["PF_CODE"] ?>');">
                        </td>
                    </tr>
                    <?
                }
                ?>
                <br>
            </table>
    </form>
</div>


<script>
function del_ok(cn){

  if (confirm("정말삭제하시겠습니까?"))
  {
    actionForm.location.href='./_action/etc.do.php?mode=portfolio_delete&pf_code='+ cn ;
  }

}
</script>