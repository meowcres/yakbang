<?
$offset = 20;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = "";
$_page = isNull($_REQUEST["page"]) ? $_clean["page"] : $_REQUEST["page"];

if (!isNull($_page)) {
    $page = $_page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "1" : $_GET["search_type"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

$_where[] = "t1.USER_TYPE='2'";

if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";

    $_where[] = " t1.reg_date BETWEEN '" . date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) . "' AND '" . date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) . "' ";
} else {
    $_checked = "";
    $_disabled = "disabled";
}

// 활동상태
if (!isNull($_search["status"])) {
    $_where[] = "t1.USER_STATUS='{$_search["status"]}'";
}
$_status[$_search["status"]] = "selected";

// 키워드 검색
if (!isNull($_search["keyword"])) {
    $_where[] = $_search["keyfield"] . " = HEX(AES_ENCRYPT('" . $_search["keyword"] . "','" . SECRET_KEY . "'))";
}

$_opt = "&search_status=" . $_search["status"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"] . "&schChkDate=" . $_search["schChkDate"] . "&schReqSDate=" . $_search["schReqSDate"]. "&schReqEDate=" . $_search["schReqEDate"];


$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.IDX desc, t1.USER_NAME";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001 = "SELECT count(t1.IDX)  ";

$_from   = " FROM {$TB_MEMBER} t1  ";
$_from  .= " LEFT JOIN {$TB_MEMBER_INFO} t2 ON (t1.USER_ID = t2.ID_KEY)  ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);

$totalnum = $row_001[0];


unset($qry_001);
unset($res_001);
unset($row_001);
?>
<div id="Contents">
    <h1>약사관리 &gt; 약사 관리 &gt; <strong>약사목록</strong></h1>

    <? include_once "./pharmacist/pharmacist_search.php"; ?>

    <div class="left" style="margin-top:15px;"><b>약사 목록</b> ( 검색 인원 : <?= number_format($totalnum) ?> 명 )</div>
    <table>
        <colgroup>
            <col width="10%"/>
            <col width="5%"/>
            <col width="17%"/>
            <col width="*"/>
            <col width="12%"/>
            <col width="15%"/>
            <col width="8%"/>
        </colgroup>
        <tr>
            <th>가입일</th>
            <th>상태</th>
            <th>약사아이디</th>
            <th>약사명</th>
            <th>연락처</th>
            <th>로그인 정보</th>
            <th>관리</th>
        </tr>
        <?
        if ($totalnum > 0) {

            $qry_002  = " SELECT t1.IDX, t1.*, t2.*  ";
            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

            $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);
            while ($row_002 = $db->sql_fetch_array($res_002)) {

                $information_ref = "./admin.template.php?slot=pharmacist&type=pharmacist_detail&step=information&idx=" . $row_002["IDX"] . $_opt;
                $del_ref = "./_action/pharmacist.do.php?Mode=del_pharmacist_list&u_id=" . $row_002["USER_ID"];

                $member_sex = $row_002["USER_SEX"] == "M" ? "남성" : "여성" ;
                if ($row_002["USER_STATUS"] == "1") {
                    ?>
                    <tr>
                        <td class="center"><?= $row_002["REG_DATE"] ?></td>
                        <td class="center"><?= $pharmacist_status_array[$row_002["USER_STATUS"]] ?></td>
                        <td class="center"><?= $row_002["mm_id"] ?></td>
                        <td><?= $row_002["mm_name"] ?> ( <?= $member_sex ?> ) birth. <?= $row_002["USER_BIRTHDAY"] ?></td>
                        <td class="center"><?= $row_002["mm_phone"] ?></td>
                        <td> &nbsp;&nbsp; <?= "( ".number_format($row_002["LOG_COUNT"])." ) : ". $row_002["LAST_LOGIN"] ?></td>
                        <td class="center">
                            <input type="button" value="관리" class="Small_Button btnGreen"
                                   onClick="location.href='<?= $information_ref ?>'">&nbsp;
                            <input type="button" value="삭제" class="Small_Button btnRed"
                                   onClick="confirm_process('actionForm','회원 정보를 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.','<?= $del_ref ?>');">
                        </td>
                    </tr>
                    <?                    
                } else {
                   ?>
                    <tr>
                        <td class="center"><?= $row_002["REG_DATE"] ?></td>
                        <td class="center"><?= $member_status_array[$row_002["USER_STATUS"]] ?></td>
                        <td colspan="5" class="left" style="line-height:180%;">
                            <b>[ 활동중지시간 : 
                            <?php
                            if ($row_002["USER_STATUS"] == "2") {
                              echo $row_002["DIAPAUSE_DATE"] ;
                            } else if ($row_002["USER_STATUS"] == "3") {
                              echo $row_002["WITHDRAW_DATE"] ;
                            } else if ($row_002["USER_STATUS"] == "6") {
                              echo $row_002["UP_DATE"] ;
                            }                              
                            ?>
                            ] <?= $row_002["mm_name"] ?> ( <?= $row_002["mm_id"] ?> )</b>
                        </td>
                        <td class="center">
                            <input type="button" value="관리" class="Small_Button btnGreen"
                                   onClick="location.href='<?= $information_ref ?>'">&nbsp;
                            <input type="button" value="삭제" class="Small_Button btnRed"
                                   onClick="confirm_process('actionForm','회원 정보를 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.','<?= $del_ref ?>');">
                        </td>
                    </tr>
                    <?                    
                }

            }

        } else {
            ?>
            <tr>
                <td colspan="7" height="200" class="center">등록된 회원이 없습니다.</td>
            </tr>
            <?
        }
       // echo $qry_002 . $_from . $_whereqry . $_order . $_limit;
        ?>
    </table>

    <div align="center" style="padding-top:10px;">
        <?
        $_url = "&slot=member&type=member_list";
        $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
        $paging->pagingArea("", "");
        ?>
    </div>

    <? $db->db_close(); ?>

</div>