<?
include_once "../../_core/_init.php";

$mode = "";
$mode = $_REQUEST["mode"];

$_link = "";        // 이동할 주소 변수

// 약국 찾기 무한스크롤 메소드
if ($mode == "find_step1_more") {

    $option = '';

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
    $_search["yadmNm"] = isNull($_GET["yadmNm"]) ? "" : $_GET["yadmNm"];
    $_search["emdongNm"] = isNull($_GET["emdongNm"]) ? "" : $_GET["emdongNm"];
    $_search["sidoCdNm"] = isNull($_GET["sidoCdNm"]) ? "" : $_GET["sidoCdNm"];
    $_search["telno"] = isNull($_GET["telno"]) ? "" : $_GET["telno"];

    $_where[] = "1";

// 약국명
    if (!isNull($_search["yadmNm"])) {
        $queryParams .= '&' . urlencode('yadmNm') . '=' . urlencode($_search["yadmNm"]);
    }
// 주소명
    if (!isNull($_search["emdongNm"])) {
        $queryParams .= '&' . urlencode('emdongNm') . '=' . urlencode($_search["emdongNm"]);
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

    foreach ($xml->body->items->item as $obj) {

        $in_qry = "SELECT * FROM {$TB_PHARMACY} t1 WHERE t1.YKIHO='" . $obj->ykiho . "'";
        $in_res = $db->exec_sql($in_qry);
        $in_row = $db->sql_fetch_array($in_res);

        if (isNull($in_row["IDX"])) {
            $option .= "<li>";
            $option .= '<a href="#" class="serchRst">';
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
    /*$option .= '<input type="hidden" name="page_plus" id="page_plus" value="'.$page.'">';*/
    $vt3 = array(
        'option' => $option,
        'page' => $page,
        );

    echo json_encode($vt3);
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
    $_search["gnlNm"] = isNull($_REQUEST["gnlNm"]) ? "" : $_REQUEST["gnlNm"];

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

            $option .= "<li>";
            $option .= '<a href="javascript:void(0);" class="serchRst">';
            $option .= "<span>";
            $option .= "<p>" . $pill_name . " ( " . $obj->unit . "/" . $obj->injcPthCdNm . " )</p>";
            $option .= "<p>" . $obj->fomnTpCdNm . " / " . $pill_component . "</p>";
            $option .= "</span>";
            $option .= '<input type="bottom" class="serch_view" value="보기" onClick="location.href=\'./find_pill_detail.php?pCode='. urlencode($obj->gnlNmCd) .'&pName='. urlencode($obj->gnlNm) .'\'" >';
            $option .= "</a>";
            $option .= "</li>";

        }
    }

    echo $option;
    exit;



}

$db->db_close();
