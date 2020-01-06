<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

$ps_code = $_REQUEST["ps_code"];

$_where[] = " PHARMACY_STATUS = '4' ";

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.IDX DESC, t1.PHARMACY_NAME";

$qry_cnt = " SELECT count(t1.IDX) ";
$_from   = " FROM {$TB_PHARMACY} AS t1  ";
$_from   .= " LEFT JOIN {$TB_ATTECH_FILES} AS t2 ON (t1.PHARMACY_CODE = t2.REFERENCE_CODE) ";

$res_cnt = $db->exec_sql($qry_cnt . $_from . $_whereqry);
$row_cnt = $db->sql_fetch_row($res_cnt);
$totalnum = $row_cnt[0];
?>
    <!-- content start -->
    <div class="coNtent">
        <div class="position_wrap">
            <span>스마트 처방조제</span>
            <span>약국선택</span>
            <span>목록형</span>
        </div>
        <div class="inner_coNtwrap">
            <div class="etabsection">
                <ul class="etAb">
                    <li class="on"><span>목록형 (<?=number_format($totalnum)?>)</span></li>
                    <li onClick="location.href='./find_map.php?ps_code=<?=$ps_code?>';"><span>지도형</span></li>
                </ul>

                <div class="show_wrap" id="list" style="display:block;">
                    <div class="liSt_wrap">
						<div class="slidepanel">
							<div class="panelhead">
								<input type="text" class="mapSch" placeholder="검색어 입력...">
								<input type="button" class="mapSch_btn" value="검색">
							   <!--  <a href="javascript:void(0);">1Km</a>
								<a href="javascript:void(0);">3Km</a>
								<a href="javascript:void(0);">5Km</a>
								<span class="total_btn">
									<span>Tatal (<?= number_format($totalnum) ?>)</span>
								</span> -->
							</div>
						</div>
                        <div class="overscroll">
                            <ul>
                                <?php
                                if ($totalnum > 0) {
                                    $qry_001  = " SELECT t1.*, t2.PHYSICAL_NAME ";
                                    $qry_001 .= " , (SELECT COUNT(IDX) FROM {$TB_PP} WHERE PHARMACY_CODE = t1.PHARMACY_CODE) as in_count  ";
                                    $res_001  = $db->exec_sql($qry_001 . $_from . $_whereqry . $_order);

                                    while ($row_001 = $db->sql_fetch_array($res_001)) {
                                        $qry_002  = " SELECT CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                                        $qry_002 .= " FROM {$TB_PP} t1 ";
                                        $qry_002 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.USER_ID = t2.USER_ID ) ";
                                        $qry_002 .= " WHERE t1.PHARMACY_CODE = '{$row_001["PHARMACY_CODE"]}' AND t1.P_STATUS = '1' ";
                                        $qry_002 .= " ORDER BY t1.P_GRADE DESC, t1.REG_DATE ";
                                        $qry_002 .= " LIMIT 0,1 ";

                                        $res_002  = $db->exec_sql($qry_002);
                                        $row_002 = $db->sql_fetch_row($res_002);
                                        $pharmacist_name = $row_002[0];

                                        $count = $row_001["in_count"] - 1;
                                        ?>
                                        <li>
                                            <div class="oNebx">
                                                <!--img src="../images/sub/testimg.jpg" alt="e약방 이미지"-->

                                                <?php
                                                if (!isNull($row_001["IDX"])) {
                                                    ?><img src="../../Web_Files/pharmacy/<?= $row_001["PHYSICAL_NAME"] ?>" width="300"><?
                                                }
                                                ?>
                                            </div>
                                            <div class="tWobx">
                                                <h4><?=$row_001["PHARMACY_NAME"]?></h4>
                                                <p class="subtxx"><?=$pharmacist_name?> 전문약사 외 <?=$count?>명</p>
                                                <p class="subtxx">Tel. <?=$row_001["PHARMACY_PHONE"]?></p>
                                            </div>
                                            <div class="tHreebx">
                                                <a href="javascript:void(0);" onclick="add_ps_pharmacy('<?=$ps_code?>', '<?=$row_001["PHARMACY_CODE"]?>');"  class="lineBtn">처방전 전송</a>
                                                <!--<a href="../prescription/prescription_status.php?ps_code=<?/*=$ps_code*/?>" class="lineBtn">처방전 전송</a>-->
                                                <a href="./pharmacy_detail.php?idx=<?=$row_001["IDX"]?>" class="grayBtn">상세보기</a>
                                            </div>
                                        </li>
                                        <?
                                    }
                                }
                                ?>
                            </ul>
                            <!-- list -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content end -->
    <script>
        function add_ps_pharmacy(ps_code, p_code) {
            location.href="../_action/prescription.do.php?Mode=add_ps_pharmacy&ps_code="+ps_code+"&p_code="+p_code;
        }
    </script>


    <input type="text" name="this_latitude" id="this_latitude" value="">
    <input type="text" name="this_longitude" id="this_longitude" value="">
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=01be6ff4715e28cb5a4ccfc18ae25c84"></script>
    <script>


        // 시작하면 현재 위치를 찍는 로직
        // $(document).ready(function(){

        /*
                    if(navigator.geolocation)
                    {
                        navigator.geolocation.getCurrentPosition(onGeoSuccess,onGeoError);
                    } else {
                        $("#this_latitude").val("33.450701");
                        $("#this_longitude").val("126.570667");
                    }


                var ThisLat = "33.450701";
                var ThisLng = "126.570667";


        //            alert(ThisLat);
        //            alert(ThisLng);


                    var mapContainer = document.getElementById("map"), // 지도를 표시할 div
                        mapOption = {
                            center: new daum.maps.LatLng(33.450701, 126.570667),
                            level: 3 // 지도의 확대 레벨
                        } ;

                    // 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
                    var map = new daum.maps.Map(mapContainer, mapOption)  ;

                }) ;

                // 현재위치 정보를 가져오기 성공했을 때
                function onGeoSuccess(event)
                {
                    $("#this_latitude").val(event.coords.latitude);
                    $("#this_longitude").val(event.coords.longitude);
                }

                function onGeoError(event)
                {
                    $("#this_latitude").val("33.450701");
                    $("#this_longitude").val("126.570667");
                }*/
    </script>













<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>