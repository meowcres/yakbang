<?php
$offset = 20;
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

$_opt =  "&emdongNm={$_search["emdongNm"]}&yadmNm={$_search["yadmNm"]}";
?>
<div id="Contents">
    <h1>약국관리 &gt; 심평원 &gt; <strong>약국목록</strong></h1>

    <form id="sfrm" name="sfrm" method="GET" action="./admin.template.php">
        <input type="hidden" id="slot" name="slot" value="<?= $_slot ?>">
        <input type="hidden" id="type" name="type" value="<?= $_type ?>">
        <table class='tbl1'>
            <colgroup>
                <col width="8%">
                <col width="8%">
                <col width="*">
            </colgroup>
            <tr>
                <th rowspan="3">검색조건</th>
                <th>주소</th>
                <td>
                    <input type="text" id="emdongNm" name="emdongNm" value="<?= $_search["emdongNm"] ?>" class="w50p">
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
                           onClick="location.href='./admin.template.php?slot=<?= $_slot ?>&type=<?= $_type ?>'">
                </td>
            </tr>
        </table>
    </form>

    <div class="left" style="margin-top:15px;"><b>약국 리스트</b> ( 총 검색약국 : <?= number_format($totalnum) ?> 점 )</div>
    <table>
        <colgroup>
            <col width="8%"/>
            <col width="12%"/>
            <col width="25%"/>
            <col width="*"/>
            <col width="12%"/>
            <col width="7%"/>
        </colgroup>
        <tr>
            <th>관리번호</th>
            <th>약국코드</th>
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

                $in_qry = "SELECT * FROM {$TB_PHARMACY} t1 WHERE t1.YKIHO='".$obj->ykiho."'";
                $in_res = $db->exec_sql($in_qry);
                $in_row = $db->sql_fetch_array($in_res);

                if (isNull($in_row["IDX"])) {
                    ?>
                    <tr>
                        <td colspan="2" class="center">미등록 약국</td>
                        <td class="center"><?= $obj->yadmNm ?></td>
                        <td style="padding-left:10px"><?= $obj->addr ?></td>
                        <td class="center"><?= $obj->telno ?></td>
                        <td class="center">
                            <input type="button" value="관리불가" class="Small_Button btnGray w80">
                        </td>
                    </tr>
                    <?php
                } else {

                    $information_ref = "./admin.template.php?slot=pharmacy&type=pharmacy_core&step=information&pcode=" . $in_row["PHARMACY_CODE"] ;

                    ?>
                    <tr>
                        <td class="center"><?= $in_row["PHARMACY_NUMBER"] ?></td>
                        <td class="center"><?= $in_row["PHARMACY_CODE"] ?></td>
                        <td class="center"><?= $obj->yadmNm ?></td>
                        <td style="padding-left:10px"><?= $obj->addr ?></td>
                        <td class="center"><?= $obj->telno ?></td>
                        <td class="center">
                            <input type="button" value="관리" class="Small_Button btnGreen w80"
                                   onClick="location.href='<?= $information_ref ?>'">
                        </td>
                    </tr>
                    <?

                }

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
        $_url = "&slot=pharmacy&type=hira_pharmacy_list";
        $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
        $paging->pagingArea("", "");
        ?>
    </div>

    <? $db->db_close(); ?>

</div>