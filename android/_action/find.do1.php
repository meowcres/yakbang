<?php
include_once "../../_core/_init.php";

$mode = "";
$mode = $_REQUEST["mode"];

$_link = "";        // 이동할 주소 변수

// 약국 찾기 무한스크롤 메소드
if ($mode == "find_step1_more") {

    $option = "";
    $offset = 20;
    $page_block = 10;
    $startNum = "";
    $totalnum = "";

    $page = isNull($_POST["page"]) ? 0 : $_POST["page"];

    $ch = curl_init();
    $url = 'http://apis.data.go.kr/B551182/pharmacyInfoService/getParmacyBasisList'; /*URL*/
    $queryParams = '?' . urlencode('ServiceKey') . '=A9lVTk8Qv60WwcDbP%2FZQGgVta2l3vJPqg1adProicrKh3VnchZ3lCJDRzokpT0QbnrLkt4Dooa3orjeqgiztxw%3D%3D'; /*Service Key*/
    $queryParams .= '&' . urlencode('ServiceKey') . '=' . urlencode('-'); /*서비스키*/
    $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode($page); /*페이지 번호*/
    $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode($offset); /*한 페이지 결과 수*/

    // 검색 변수
    $_search = array();
    $_search["yadmNm"] = isNull($_POST["yadmNm"]) ? "" : $_POST["yadmNm"];
    $_search["emdongNm"] = isNull($_POST["emdongNm"]) ? "" : $_POST["emdongNm"];

    // 약국명
    if (!isNull($_search["yadmNm"])) {
        $queryParams .= '&' . urlencode('yadmNm') . '=' . urlencode($_search["yadmNm"]);
    }

    // 주소명
    if (!isNull($_search["emdongNm"])) {
        $queryParams .= '&' . urlencode('emdongNm') . '=' . urlencode($_search["emdongNm"]);
    }

    curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);
    curl_close($ch);

    $xml = simplexml_load_string($response);
    $totalnum = (int)$xml->body->totalCount;

    foreach ($xml->body->items->item as $obj) {

        $in_qry = "SELECT * FROM {$TB_PHARMACY} t1 WHERE t1.YKIHO='" . $obj->ykiho . "'";
        $in_res = $db->exec_sql($in_qry);
        $in_row = $db->sql_fetch_array($in_res);

        if (isNull($in_row["IDX"])) {
            $option .= "<li>";
            $option .= '<a href="javascript:void(0);" class="serchRst">';
            $option .= "<span>";
            $option .= "<p>".$obj->yadmNm."</p>";
            $option .= "<p>".$obj->addr."</p>";
            $option .= "</span>";
            $option .= '<input type="bottom" class="serch_view" value="미등록">';
            $option .= "</a>";
            $option .= "</li>";
        } else {
            $option .= "<li>";
            $option .= '<a href="../pharmacy/pharmacy_detail.php?idx='.$in_row["IDX"].'" class="serchRst">';
            $option .= "<span>";
            $option .= "<p>".$obj->yadmNm."</p>";
            $option .= "<p>".$obj->addr."</p>";
            $option .= "</span>";
            $option .= '<input type="bottom" class="serch_view" value="보기">';
            $option .= "</a>";
            $option .= "</li>";
        }
    }

    echo $option;
    exit;


} else if ($mode == "find_pill_more") {

    $option = '';

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
    }

    echo $option;
    exit;



}

$db->db_close();
