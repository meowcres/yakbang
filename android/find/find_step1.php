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

$_opt = "&emdongNm={$_search["emdongNm"]}&yadmNm={$_search["yadmNm"]}";
?>
<div class="content">
    <!-- <a href="javascript:void(0)" class="blk">약국 / 약품 page</a> -->

    <div class="tab_wrap">
        <a href="./find_step1.php" class="on">약국찾기 (<?= $totalnum ?>)</a>
        <a href="./find_pill.php">약품찾기</a>
    </div>

    <div class="cttAll_wrap">
        <div class="serch_wrap">
            <form action="./find_step1.php" method="get">
                <input type="text" name="yadmNm" id="yadmNm" value="<?= $_search["yadmNm"] ?>" class="serch_box"
                       placeholder="약국명">
                <input type="text" name="emdongNm" id="emdongNm" value="<?= $_search["emdongNm"] ?>" class="serch_box"
                       placeholder="주소명">
                <input type="submit" class="serch_btn" value="찾기">
            </form>
        </div>
        <?php
        if ($totalnum > 0) {
            ?>
            <div class="serchRst_wrap" id="serchRst_wrap">
                <input type="hidden" name="page_plus" id="page_plus" value="<?= $page ?>">
                <ul class="pillList">
                    <?php
                    foreach ($xml->body->items->item as $obj) {

                        $in_qry = "SELECT * FROM {$TB_PHARMACY} t1 WHERE t1.YKIHO='" . $obj->ykiho . "'";
                        $in_res = $db->exec_sql($in_qry);
                        $in_row = $db->sql_fetch_array($in_res);

                        if (isNull($in_row["IDX"])) {
                            ?>
                            <li>
                                <a href="javascript:void(0)" class="serchRst">
									<span>
										<p><?= $obj->yadmNm ?></p>
										<p><?= $obj->addr ?></p>
									</span>		
									
                                </a>
								<div class="serchBtn_wrap">
								   <input type="bottom" class="serch_view" value="통화">
								</div>

                            </li>
                            <?
                        } else {
                            ?>
                            <li>
                                <a href="../pharmacy/pharmacy_detail.php?idx=<?= $in_row["IDX"] ?>" class="serchRst serchRst_wd">
									<span>
										<p><?= $obj->yadmNm ?></p>
										<p><?= $obj->addr ?></p>
									</span>
									
                                </a>
								<div class="serchBtn_wrap">										
									<input type="bottom" class="serch_view2" value="보기">
									<input type="bottom" class="serch_view" value="통화">
								</div>
                            </li>
                            <?
                        }
                    }
                    ?>
                </ul>
                <div style="padding:20px 0 50px 0;text-align:center;">
                    <span class="addscroller" onclick="morePage()">+ 더보기</span>
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
<!--무한스크롤 -->
<script>
    function morePage() {

        var page = parseInt($('#page_plus').val());
        var page_plus = page + 1;

        var yadmNm = $('#yadmNm').val();
        var emdongNm = $('#emdongNm').val();

        var _frm = new FormData();
        _frm.append("mode", "find_step1_more");
        _frm.append("page", page_plus);
        _frm.append("yadmNm", yadmNm);
        _frm.append("emdongNm", emdongNm);

        $.ajax({
            method: 'POST',
            url: "../_action/find.do1.php",
            processData: false,
            contentType: false,
            data: _frm,
            success: function (data) {
                $("#page_plus").val(page_plus);
                $(".pillList").append(data);
            }
        });
    }
</script>

