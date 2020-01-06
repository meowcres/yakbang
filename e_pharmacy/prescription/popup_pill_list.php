<?php

include_once "../../_core/_init.php" ;
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
$url = 'http://apis.data.go.kr/B551182/msupCmpnMeftInfoService/getMajorCmpnNmCdList'; /*URL*/
$queryParams = '?' . urlencode('ServiceKey') . '=A9lVTk8Qv60WwcDbP%2FZQGgVta2l3vJPqg1adProicrKh3VnchZ3lCJDRzokpT0QbnrLkt4Dooa3orjeqgiztxw%3D%3D'; /*Service Key*/
$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode($page);
$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode($offset);

// 검색변수
$_search["gnlNm"] = isNull($_GET["gnlNm"]) ? "" : $_GET["gnlNm"];

/*약국명*/
if (!isNull($_search["gnlNm"])) {
    $queryParams .= '&' . urlencode('gnlNm') . '=' . urlencode($_search["gnlNm"]);
}

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$response = curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($response);
$totalnum = (int)$xml->body->totalCount;

$ps_code = $_GET["ps_code"];
$pharmacy_code = $_GET["pharmacy_code"];
?>

<div class="adm_table_style02">
    <h3 class="h3_title ">처방약 목록</h3>

    <div>
        <form action="./popup_pill_list.php" method="get">

        <table class='tbl1'>
            <colgroup>
                <col width="10%">
                <col width="*">
            </colgroup>

            <tr>
                <th>검색어</th>
                <td style="text-align:left">
                    <input type="text" name="gnlNm" id="gnlNm" value="<?= $_search["gnlNm"] ?>" style="width:85%;">
                    <input type="hidden" name="ps_code" value="<?= $ps_code ?>">
                    <input type="hidden" name="pharmacy_code" value="<?= $pharmacy_code ?>">
                    <input type="submit" value="찾기" style="width:80px;">
                </td>
            </tr>
        </table>
        </form>
    </div><br>

    <table>
        <col width="35%"/>
        <col width="*"/>
        <col width="8%"/>

        <?php
        if ($totalnum > 0) {

            foreach ($xml->body->items->item as $obj) {

                if (mb_strlen($obj->gnlNm) > 20) {
                    $pill_name = mb_substr($obj->gnlNm, 0, 20) . "...";
                } else {
                    $pill_name = $obj->gnlNm;
                }

                if (mb_strlen($obj->divNm) > 20) {
                    $pill_component = mb_substr($obj->divNm, 0, 20) . "...";
                } else {
                    $pill_component = $obj->divNm;
                }
                ?>
                <tr>
                    <td><?= $pill_name ?> ( <?= $obj->unit . "/" . $obj->injcPthCdNm ?> )</td>
                    <td><?= $obj->fomnTpCdNm ?> / <?= $pill_component ?></td>
                    <td>
                        <input type="button" style="width:70px;height:24px;background-color:#51c33a;color:white;border-radius:5px;" id="pre_status_btn"
                       onClick="location.href='../_action/prescription.do.php?Mode=add_pill_order&pCode=<?= urlencode($obj->gnlNmCd) ?>&pName=<?= urlencode($obj->gnlNm) ?>&ps_code=<?=$ps_code?>&pharmacy_code=<?=$pharmacy_code?>'" value="선택">
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
                <tr>
                    <td>검색된 약품이 없습니다</td>
                </tr>
            <?
        }
        ?>
    </table>
</div>


<?
include_once "../inc/in_bottom.php";
?>


