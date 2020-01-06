<?php
include_once "../../_core/_init.php";
//$__member_chk = "main";
//include_once "../_member.php";
include_once "../../_core/_lib/class.attach.php";
// 파일 클래스
$obj = new Attech_Works();

$qry_001 = " SELECT * FROM {$TB_PHARMACY}  ";
//$where_001 = " WHERE DAY(START_DATE) = DAY(NOW()) ";
$order_001 = " ORDER BY START_DATE DESC ";
$limit_001 = " LIMIT 0,4 ";

// 약품 찾기
$pill_qry = " SELECT count(t1.IDX) ";
$pill_from = " FROM {$TB_PILL} AS t1  ";
$pill_limit = " LIMIT 0,5 ";

// 약품 HOT 5
$pill_hot_order = " ORDER BY t1.HIT DESC ";

// 최근 검색 목록
$pill_recently_order = " ORDER BY t1.UP_DATE DESC ";

$pill_res = $db->exec_sql($pill_qry . $pill_from);
$pill_row = $db->sql_fetch_row($pill_res);

$pill_total = $pill_row[0];

?>

<!doctype html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="imagetoolbar" content="no">
    <title>e약방 | 메인페이지</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/swiper.min.css">
    <script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="../js/swiper.min.js"></script>
</head>

<body>
<div class="wrap">
    <!-- header start -->
    <div class="header">
        <img src="../images/common/elogo.png" alt="e약방 로고 이미지">
        <?php
        if(isNull($_COOKIE["cookie_user_id"])) {
            ?>
            <a href="../member/login.php" class="htop_icoN">
                <img src="../images/common/toplink.png" alt="e약방">
            </a>
            <?php
        }else{
            ?>
            <a href="../prescription/prescription_list.php" class="htop_icoN">
                <img src="../images/common/toplink.png" alt="e약방">
            </a>
            <?php
        }
        ?>
    </div>
    <!-- header end -->

    <!-- container start -->
    <div class="main_container">
        <!-- content start -->
        <div class="fullSlide_wrap">
            <!-- <div class="scrolling_container"></div> -->
			<div class="fuls_TabPag">
				<ul>
					<li class="swiper-pagination-switch on"><a href="javascript:void(0);">처방조제</a></li>
					<li class="swiper-pagination-switch"><a href="javascript:void(0);">약국찾기</a></li>
					<li class="swiper-pagination-switch"><a href="javascript:void(0);">약품찾기</a></li>
					<li class="swiper-pagination-switch"><a href="javascript:void(0);">약사상담</a></li>
				</ul>
				<div class="fuls_TabPagbar"></div>
			</div>
            <div class="full_Slide">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="btnWrap">
                            <div class="inwrap">
                                <a href="../prescription/photo_step_01.php" class="img1">사진전송</a>
                                <a href="../prescription/qr_step_01.php" class="img2">QR코드전송</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="innercoNt">
                            <h2><span>New 약국</span></h2>
                            <ul class="eList">
                                <?php
                                $res_001 = $db->exec_sql($qry_001 . $order_001 . $limit_001);
                                while ($row_001 = $db->sql_fetch_array($res_001)) {
                                    $img_obj = $obj->getFile($TB_PHARMACY, $row_001["PHARMACY_CODE"], "pharmacy_img");
                                    ?>
                                    <li>
                                        <a href="../pharmacy/pharmacy_detail.php?idx=<?= $row_001["IDX"] ?>">
                                            <div class="liimg">
                                                <img src="../../Web_Files/pharmacy/<?= $img_obj["PHYSICAL_NAME"] ?>"
                                                     width="180">
                                            </div>
                                            <h4><?= $row_001["PHARMACY_NAME"] ?></h4>
                                            <p class="suTx"><?= $row_001["ADDRESS"] ?></p>
                                        </a>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                            <hr>
                            <h2><span>추천 약국</span></h2>
                            <ul class="eList">
                                <?php
                                $res_001 = $db->exec_sql($qry_001 . $order_001 . $limit_001);
                                while ($row_001 = $db->sql_fetch_array($res_001)) {
                                    $img_obj = $obj->getFile($TB_PHARMACY, $row_001["PHARMACY_CODE"], "pharmacy_img");
                                    ?>
                                    <li>
                                        <a href="">
                                            <div class="liimg">
                                                <img src="../../Web_Files/pharmacy/<?= $img_obj["PHYSICAL_NAME"] ?>"
                                                     width="180">
                                            </div>
                                            <h4><?= $row_001["PHARMACY_NAME"] ?></h4>
                                            <p class="suTx"><?= $row_001["ADDRESS"] ?></p>
                                        </a>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="innercoNt">
                            <h2><span>약품 HOT5</span></h2>
                            <ol class="eNList">
                                <?
                                if ($pill_total > 0) {
                                    $i = 1;
                                    $qry_pill_hot5  = " SELECT t1.IDX, t1.PILL_NAME ";
                                    $res_pill_hot5 = $db->exec_sql($qry_pill_hot5 . $pill_from . $pill_hot_order . $pill_limit);
                                    while ($row_pill_hot5 = $db->sql_fetch_array($res_pill_hot5)) {
                                            ?>
                                                <li>
                                                    <a href="javascript:void(0);" onClick="location.href='../find/find_pill_detail.php?pidx=<?= $row_pill_hot5["IDX"] ?>'"><?=$i?>. <?=$row_pill_hot5["PILL_NAME"]?></a>
                                                </li>
                                            <?                    
                                        $i++;
                                    }
                                } else {
                                    ?>
                                        <li><a href="javascript:void(0);">등록된 의약품이 없습니다.</a></li>
                                    <?
                                }
                                ?>
                            </ol>
                        </div>
                        <div class="eadimg">
                            <a href="">
                                <img src="../images/sub/adimg1.jpg" alt="e약방 광고이미지">
                            </a>
                        </div>
                        <hr>
                        <div class="innercoNt">
                            <h2><span>최근 검색 목록</span></h2>
                            <ol class="eNList iNgnum">
                                <?
                                if ($pill_total > 0) {
                                    $i = 1;
                                    $qry_pill_recently  = " SELECT t1.IDX, t1.PILL_NAME ";
                                    $res_pill_recently = $db->exec_sql($qry_pill_recently . $pill_from . $pill_recently_order . $pill_limit);
                                    while ($row_pill_recently = $db->sql_fetch_array($res_pill_recently)) {
                                            ?>
                                                <li>
                                                    <a href="javascript:void(0);" onClick="location.href='../find/find_pill_detail.php?pidx=<?= $row_pill_recently["IDX"] ?>'"><?=$i?>. <?=$row_pill_recently["PILL_NAME"]?></a>
                                                </li>
                                            <?                    
                                        $i++;
                                    }
                                } else {
                                    ?>
                                        <li><a href="javascript:void(0);">등록된 의약품이 없습니다.</a></li>
                                    <?
                                }
                                ?>
                            </ol>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="innercoNt">
                            <h2><span>질문있어요</span></h2>
                            <ul class="eFList">
                                <?php
                                $qry_002 = " SELECT t1.* ";
                                $qry_002 .= " FROM {$TB_COUNSEL} t1 ";
                                $qry_002 .= " WHERE ( t1.C_MENTOR = '' OR ( t1.C_MENTOR != '' AND t1.C_WRITE = '{$mm_row["USER_ID"]}' ) ) ";
                                $qry_002 .= " ORDER BY t1.REG_DATE DESC ";
                                $qry_002 .= " LIMIT 0, 5 ";
                                $res_002 = $db->exec_sql($qry_002);
                                while ($row_002 = $db->sql_fetch_array($res_002)) {
                                    $qry_003 = " SELECT COUNT(*) ";
                                    $qry_003 .= " FROM {$TB_CR} ";
                                    $qry_003 .= " WHERE PARENT_KEY = '{$row_002["IDX"]}' ";
                                    $res_003 = $db->exec_sql($qry_003);
                                    $row_003 = $db->sql_fetch_row($res_003);
                                    $cr = $row_003[0];
                                    if ($cr > 0) {
                                        $i = "<span class='answer'>답변완료</span>";
                                    } else {
                                        $i = "<span>미답변</span>";
                                    }
                                    ?>
                                    <li>
                                        <a href="../counsel/counsel_detail.php?idx=<?= $row_002["IDX"] ?>"><?= $i ?><?= $row_002["C_TITLE"] ?></a>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="eadimg">
                            <a href="">
                                <img src="../images/sub/adimg1.jpg" alt="e약방 광고이미지">
                            </a>
                        </div>
                        <hr>
                        <div class="innercoNt">
                            <h2><span>멘토 추천</span></h2>
                            <ul class="eMList">
                                <?php
                                $qry_004 = " SELECT t1.*, t2.*, t3.* ";
                                $qry_004 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                                $qry_004 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
                                $qry_004 .= " FROM {$TB_PP} t1 ";
                                $qry_004 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.USER_ID = t2.USER_ID ) ";
                                $qry_004 .= " LEFT JOIN {$TB_PHARMACY} t3 ON ( t1.PHARMACY_CODE = t3.PHARMACY_CODE ) ";
                                $qry_004 .= " WHERE t1.P_STATUS = '1' ";
                                $qry_004 .= " GROUP BY t1.PHARMACY_CODE ";
                                $qry_004 .= " ORDER BY t1.REG_DATE DESC ";
                                $qry_004 .= " LIMIT 0, 4 ";

                                $_pic_url = "../../Web_Files/pharmacist/";

                                $res_004 = $db->exec_sql($qry_004);
                                while ($row_004 = $db->sql_fetch_array($res_004)) {
                                    $qry_005 = " SELECT * FROM {$TB_ATTECH_FILES} WHERE REFERENCE_CODE = '{$row_004["mm_id"]}' AND TYPE_CODE = 'pharmacist_img' ";
                                    $res_005 = $db->exec_sql($qry_005);
                                    $row_005 = $db->sql_fetch_array($res_005);
                                    ?>
                                    <li>
                                        <a href="">
                                            <div class="liimg">
                                                <img src="<?= $_pic_url . $row_005["PHYSICAL_NAME"] ?>">
                                            </div>
                                            <div class="emhei">
                                                <span class="mtName"> <?= $row_004["mm_name"] ?> </span>
                                                <em><?= $row_004["PHARMACY_NAME"] ?></em><br>
                                                <em><?= $row_004["ADDRESS"] ?></em>
                                            </div>
                                        </a>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- slide section-->
        </div>
        <!-- content end -->
        <?php
        include_once "../inc/footer.php";
        ?>
    </div>
    <!-- container end -->

</div>

<script type="text/javascript" src="../js/ui_jqAction.js"></script>
</body>
</html>