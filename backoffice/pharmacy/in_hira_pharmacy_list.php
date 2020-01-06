<?php
include_once "../../_core/_init.php";
include_once "../inc/in_top.php";

$offset = 10;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = "";
$_page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

if (!isNull($_page)) {
    $page = $_page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

$ch = curl_init();
$url = 'http://apis.data.go.kr/B551182/pharmacyInfoService/getParmacyBasisList'; /*URL*/
$queryParams = '?' . urlencode('ServiceKey') . '=A9lVTk8Qv60WwcDbP%2FZQGgVta2l3vJPqg1adProicrKh3VnchZ3lCJDRzokpT0QbnrLkt4Dooa3orjeqgiztxw%3D%3D'; /*Service Key*/
$queryParams .= '&' . urlencode('ServiceKey') . '=' . urlencode('-'); /*서비스키*/
$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode($page); /*페이지 번호*/
$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode($offset); /*한 페이지 결과 수*/

// 검색 변수
$_search = array();
$_search["emdongNm"] = isNull($_GET["emdongNm"]) ? "" : $_GET["emdongNm"];
$_search["yadmNm"] = isNull($_GET["yadmNm"]) ? "" : $_GET["yadmNm"];
$_search["sidoCdNm"] = isNull($_GET["sidoCdNm"]) ? "" : $_GET["sidoCdNm"];
$_search["telno"] = isNull($_GET["telno"]) ? "" : $_GET["telno"];

$_where[] = "1";

/*주소*/
if (!isNull($_search["emdongNm"])) {
    $queryParams .= '&' . urlencode('emdongNm') . '=' . urlencode($_search["emdongNm"]);
}

/*약국명*/
if (!isNull($_search["yadmNm"])) {
    $queryParams .= '&' . urlencode('yadmNm') . '=' . urlencode($_search["yadmNm"]);
}

/*x좌표*/
if (!isNull($_search["xPos"])) {
    $queryParams .= '&' . urlencode('xPos') . '=' . urlencode('127.0965441346012');
}

/*y좌표*/
if (!isNull($_search["yPos"])) {
    $queryParams .= '&' . urlencode('yPos') . '=' . urlencode('37.60765568915000');
}

/*반경*/
if (!isNull($_search["radius"])) {
    $queryParams .= '&' . urlencode('radius') . '=' . urlencode('3000');
}

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$response = curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($response);
$totalnum = (int)$xml->body->totalCount;

$_opt = "&emdongNm={$_search["emdongNm"]}&yadmNm={$_search["yadmNm"]}";
?>
    <div id="Popup_Contents">

        <div class="left" style="margin-top:15px;"><b>심평원 - 약국리스트 ( 총 검색약국 : <?= number_format($totalnum) ?> )</b></div>
        <form id="sfrm" name="sfrm" method="GET" action="./in_hira_pharmacy_list.php">
            <table class='tbl1'>
                <colgroup>
                    <col width="15%">
                    <col width="*">
                </colgroup>
                <tr>
                    <th>주소</th>
                    <td>
                        <input type="text" id="emdongNm" name="emdongNm" value="<?= $_search["emdongNm"] ?>"
                               class="w50p">
                    </td>
                </tr>
                <tr>
                    <th>약국명</th>
                    <td>
                        <input type="text" id="yadmNm" name="yadmNm" value="<?= $_search["yadmNm"] ?>" class="w50p">
                    </td>
                </tr>
                <tr>
                    <th>겁색버튼</th>
                    <td>
                        <input type="submit" value="검색" class="btnOrange w80 h24"> &nbsp;
                        <input type="button" value="초기화" class="btnGray w80 h24"
                               onClick="location.href='./in_hira_pharmacy_list.php'">
                    </td>
                </tr>
            </table>
        </form>
        <table>
            <colgroup>
                <col width="25%"/>
                <col width="*"/>
                <col width="15%"/>
                <col width="7%"/>
            </colgroup>
            <tr>
                <th>약국명</th>
                <th>도로명</th>
                <th>연락처</th>
                <th>관리</th>
            </tr>
            <?php
            if ($totalnum > 0) {

                $qry_002 = " SELECT t1.*, (SELECT COUNT(IDX) FROM {$TB_PP} WHERE PHARMACY_CODE = t1.PHARMACY_CODE) as in_count  ";
                $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);

                foreach ($xml->body->items->item as $obj) {

                    $in_qry = "SELECT * FROM {$TB_PHARMACY} t1 WHERE t1.YKIHO='" . $obj->ykiho . "'";
                    $in_res = $db->exec_sql($in_qry);
                    $in_row = $db->sql_fetch_array($in_res);


                    ?>
                    <tr>
                        <td class="center"><?= $obj->yadmNm ?></td>
                        <td style="padding-left:10px"><?= $obj->addr ?></td>
                        <td class="center"><?= $obj->telno ?></td>
                        <td class="center">
                            <?php
                            if (isNull($in_row["IDX"])) {
                                ?>
                                <input type="button" value="복사" class="Small_Button btnGreen w80"
                                       onClick="parent.document.getElementById('ykiho_number').value='<?= $obj->ykiho ?>';">
                                <?php
                            } else {
                                ?><input type="button" value="등록완료" class="Small_Button btnGray w80"><?
                            }
                            ?>
                        </td>
                    </tr>
                    <?php

                }

            } else {
                ?>
                <tr>
                    <td colspan="6" height="200" class="center">검색 된 약국이 없습니다.</td>
                </tr>
                <?
            }
            ?>
        </table>

        <div align="center" style="padding:20px;">
            <?
            $_url = "";
            $paging = new paging("./in_hira_pharmacy_list.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
            $paging->pagingArea("", "");
            ?>
        </div>

        <? $db->db_close(); ?>

    </div>

<?php
include_once "../inc/in_bottom.php";