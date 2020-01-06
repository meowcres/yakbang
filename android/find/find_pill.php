<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

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

//$queryParams .= '&' . urlencode('gnlNmCd') . '='  . urlencode('1');
//$queryParams .= '&' . urlencode('gnlNm') . '='  . urlencode('상황균');
//$queryParams .= '&' . urlencode('meftDivNo') . '='  . urlencode('421');
//$queryParams .= '&' . urlencode('divNm') . '='  . urlencode('항악성');

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$response = curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($response);
$totalnum = (int)$xml->body->totalCount;
?>

<div class="content">
    <!--     <a href="javascript:void(0)" class="blk">약국 / 약품 page</a> -->

    <div class="tab_wrap">
        <a href="./find_step1.php">약국찾기</a>
        <a href="javascript:void(0);" class="on">약품찾기 ( <?= $totalnum ?> )</a>
    </div>

    <div class="cttAll_wrap">
        <div class="serch_wrap">
            <form action="./find_pill.php" method="get">
                <input type="text" name="gnlNm" id="gnlNm" class="serch_box2" value="<?= $_search["gnlNm"] ?>"
                       placeholder="검색어 입력">
                <input type="submit" class="serch_btn" value="찾기">
            </form>
        </div>
        <?php
        if ($totalnum > 0) {
            ?>
            <div class="serchRst_wrap" id="serchRst_wrap">
                <ul class="pillList">
                    <input type="hidden" id="next_page" name="next_page" value="2">
                    <?php


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
                        <li>
                            <a href="javascript:void(0);" class="serchRst">

                        <span>
                            <p><?= $pill_name ?> ( <?= $obj->unit . "/" . $obj->injcPthCdNm ?> )</p>
                            <p><?= $obj->fomnTpCdNm ?> / <?= $pill_component ?></p>
                        </span>
                                <input type="bottom" class="serch_view" value="보기"
                                       onClick="location.href='./find_pill_detail.php?pCode=<?= urlencode($obj->gnlNmCd) ?>&pName=<?= urlencode($obj->gnlNm) ?>'">
                            </a>
                        </li>


                        <?php
                    }
                    ?>
                </ul>

                <div style="padding:20px 0 50px 0;text-align:center;">
                    <span onclick="morePage()" class="addscroller">더보기</span>
                </div>
            </div>
            <?
        } else {
            ?>
            <div>
                <a href="javascript:void(0);" class="serchRst">
					<span class="noneSch">
						<em>검색된 약품이 없습니다</em>
					</span>
                </a>
            </div>
            <?
        }
        ?>
    </div>
</div>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>
<!--무한스크롤 --> <!--적용안됨-->
<script>

    function morePage() {

        var next_page = $("#next_page").val();

        var _frm = new FormData();

        _frm.append("mode", "find_pill_more");
        _frm.append("page", next_page);
        _frm.append("gnlNm", $("#gnlNm").val());

        $.ajax({
            method: 'POST',
            url: "../_action/find.do.php",
            processData: false,
            contentType: false,
            data: _frm,
            success: function (_res) {
                if ( _res == '' ) {
                    alert('더보기가 없습니다.');
                    return false;
                }
                //console.log(_res);
                //console.log(next_page);
                //$(".pillList").append("<li> <span><p>" + next_page + "</p></span></li>");
                $(".pillList").append(_res);
                $("#next_page").val(++next_page);
            }
        });
    }

</script>
