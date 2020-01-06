<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

// 검색변수
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];

$_where[] = " 1 ";

// 키워드 검색
if (!isNull($_search["keyword"])) {
    $_where[] = " t1.PILL_IDX LIKE '%{$_search['keyword']}%' OR t1.PILL_NAME LIKE '%{$_search['keyword']}%' OR t1.PILL_COMPONENT LIKE '%{$_search['keyword']}%' OR t1.PILL_ADDITIVE LIKE '%{$_search['keyword']}%' ";
}

$_opt = "&keyword={$_search["keyword"]}";

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";

$_limit = " LIMIT 0, 20 ";

$qry_001 = " SELECT t1.* FROM {$TB_PILL} AS t1 ";
$res_001 = $db->exec_sql($qry_001 . $_whereqry . $_limit);
?>
<div class="content">
    <div class="btnWrap">
        <!--     <a href="javascript:void(0)" class="blk">약국 / 약품 page</a> -->

        <div class="tab_wrap">
            <a href="./find_step1.php" class="tab3">약국찾기</a>
            <a href="javascript:void(0);" class="tab1">약품찾기</a>
        </div>

        <div class="cttAll_wrap" id="cttAll_wrap">
            <div class="serch_wrap">
                <form action="./find_pill.php" method="get">
                    <input type="text" name="keyword" id="keyword" class="serch_box" value="<?= $_search["keyword"] ?>" placeholder="검색어 입력">
                    <input type="submit" class="serch_btn" value="찾기">
                </form>
            </div>
            <ul class="serchRst_wrap" id="serchRst_wrap">
                <?php
                while( $row_001 = $db->sql_fetch_array($res_001) ) {
                    if ( mb_strlen($row_001["PILL_NAME"]) > 20 ) {
                        $pill_name = mb_substr( $row_001["PILL_NAME"], 0, 20 )."...";
                    } else {
                        $pill_name = $row_001["PILL_NAME"];
                    }

                    if ( mb_strlen($row_001["PILL_COMPONENT"]) > 20 ) {
                        $pill_component = mb_substr( $row_001["PILL_COMPONENT"], 0, 20 )."...";
                    } else {
                        $pill_component = $row_001["PILL_COMPONENT"];
                    }
                    ?>
                    <li>
                        <a href="./find_pill_detail.php?idx=<?=$row_001["IDX"]?>" class="serchRst">
					<span>
						<em><?=$pill_name?> ( <?=$row_001["PILL_CLASS"]?> )</em>
						<em>성분:<?=$pill_component?></em>
					</span>
                            <input type="bottom" class="serch_view" value="보기">
                        </a>
                    </li>
                    <?
                }
                ?>
                <!--<li>
                    <a href="" class="serchRst">
                        <span>
                            <em>1. 노브랜드데일리치약 2. 탐사덴탈솔루션치... ( 의약외품 )</em>
                            <em>성분:!@#!@# 함유량: !@#!@#!#</em>
                        </span>
                        <input type="bottom" class="serch_view" value="보기">
                    </a>
                </li>-->
            </ul>
        </div>
    </div>
</div>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>
<!--무한스크롤 --> <!--적용안됨-->
<script>
    var page = 1;

    $(window).scroll(function() {
        console.log(++page);
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            console.log(++page);
            console.log($(window).scrollTop());
            $("#cttAll_wrap").append("<h1>Page " + page + "</h1><BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~<BR/>So<BR/>MANY<BR/>BRS<BR/>YEAHHH~");

        }
    });

</script>
