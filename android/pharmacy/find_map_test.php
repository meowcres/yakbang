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
            <span>지도형</span>
        </div>

        <div class="inner_coNtwrap">
            <div class="etabsection">
                <ul class="etAb">
                    <li onClick="location.href='./find_ylist.php?ps_code=<?= $ps_code ?>';"><span>목록형</span></li>
                    <li class="on"><span>지도형 (<?= $totalnum ?>)</span></li>
                </ul>

                <div class="show_wrap" style="display:block;">
                    <div id="map" style="width:100%; height:100%;"></div>
                    <div class="slidepanel">
                        <div class="panelhead">
                            <a href="javascript:void(0);">1Km</a>
                            <a href="javascript:void(0);">3Km</a>
                            <a href="javascript:void(0);">5Km</a>
                            <span class="total_btn">
              <span>Tatal <?= $totalnum ?></span>
            </span>
                        </div>
                    </div>
                    <!-- slide panel end -->
                </div>
                <div class="show_wrap" id="list">
                    <div class="liSt_wrap">
                        <div class="panelhead">
                            <a href="">1Km</a>
                            <a href="">3Km</a>
                            <a href="">5Km</a>
                            <span class="total_btn">
              <span>Tatal <?= $totalnum ?></span>
            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content end -->
<?php
// 약국 지도상에 표시하기
$p_sql  = " SELECT t1.*, t2.PHYSICAL_NAME FROM {$TB_PHARMACY} AS t1 ";
$p_sql .= " LEFT JOIN {$TB_ATTECH_FILES} AS t2 ON (t1.PHARMACY_CODE = t2.REFERENCE_CODE) ";
$p_sql .= " WHERE t1.PHARMACY_STATUS = '4' ORDER BY t1.PHARMACY_NAME";
$p_res = $db->exec_sql($p_sql);

$p_obj = "";

$ii=1;
while($p_row = $db->sql_fetch_array($p_res)) {

    if($ii>1) {
        $p_obj .= ",";
    }

    $p_obj .= "{title:'".$p_row["PHARMACY_NAME"]."'";
    $p_obj .= ", content:''";
    $p_obj .= ", mainPhone:'".$p_row["PHARMACY_PHONE"]."'";
    $p_obj .= ", pharmacyIDX:'".$p_row["IDX"]."'";
    $p_obj .= ", psCode:'".$ps_code."'";
    $p_obj .= ", pharmacyCode:'".$p_row["PHARMACY_CODE"]."'";
    $p_obj .= ", fileUrl:'<img src=\"http://yakbang.org/Web_Files/pharmacy/".$p_row["PHYSICAL_NAME"]."\" style=\"width:160px;margin-top:5px;\">'";
    $p_obj .= ", latlng: new kakao.maps.LatLng(".$p_row["LATITUDE"].",".$p_row["LONGTITUDE"].")}";
    $ii++;
}
?>

    <input type="text" name="this_latitude" id="this_latitude" value="">
    <input type="text" name="this_longitude" id="this_longitude" value="">
    <script type="text/javascript"
            src="//dapi.kakao.com/v2/maps/sdk.js?appkey=aae9bbac4d27fc532a36565aae5cbc80"></script>
    <script>

        // 시작하면 현재 위치를 찍는 로직
        $(document).ready(function () {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(onGeoSuccess, onGeoError);
            } else {
                $("#this_latitude").val("37.46803850908603");
                $("#this_longitude").val("126.95929603302525");
            }

            // 현재위치 정보를 가져오기 성공했을 때
            function onGeoSuccess(event) {
                $("#this_latitude").val(event.coords.latitude);
                $("#this_longitude").val(event.coords.longitude);
            }

            function onGeoError(event) {
                $("#this_latitude").val("37.46803850908603");
                $("#this_longitude").val("126.95929603302525");
            }

        });

        var ThisLat = $("#this_latitude").val() == "" ? "37.46803850908603" : $("#this_latitude").val() ;
        var ThisLng = $("#this_longitude").val() == "" ? "126.95929603302525" : $("#this_longitude").val() ;

        var mapContainer = document.getElementById('map'), // 지도를 표시할 div
            mapOption = {
                center: new kakao.maps.LatLng(ThisLat, ThisLng), // 지도의 중심좌표
                level: 3 // 지도의 확대 레벨
            };

        // 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
        var map = new kakao.maps.Map(mapContainer, mapOption);

        var imageSrc = 'http://yakbang.org/android/images/common/my_marker.png', // 마커이미지의 주소입니다
            imageSize = new kakao.maps.Size(45, 50), // 마커이미지의 크기입니다
            imageOption = {offset: new kakao.maps.Point(27, 69)}; // 마커이미지의 옵션입니다. 마커의 좌표와 일치시킬 이미지 안에서의 좌표를 설정합니다.

        // 마커의 이미지정보를 가지고 있는 마커이미지를 생성합니다
        var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption),
            markerPosition = new kakao.maps.LatLng(ThisLat, ThisLng); // 마커가 표시될 위치입니다

        // 마커를 생성합니다
        var marker = new kakao.maps.Marker({
            position: markerPosition,
            image: markerImage // 마커이미지 설정
        });

        // 마커가 지도 위에 표시되도록 설정합니다
        marker.setMap(map);

        var positions = [
            <?= $p_obj ?>
        ];

        // 마커 이미지의 이미지 주소입니다
        var imageSrc = "http://yakbang.org/android/images/common/pharmacy_marker3.png";


        for (var i = 0; i < positions.length; i ++) {

            // 마커 이미지의 이미지 크기 입니다
            var imageSize = new kakao.maps.Size(43, 50);

            // 마커 이미지를 생성합니다
            var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize);

            // 마커를 생성합니다
            var marker = new kakao.maps.Marker({
                map: map, // 마커를 표시할 지도
                position: positions[i].latlng, // 마커를 표시할 위치
                image : markerImage // 마커 이미지
            });

            //띄울 인포윈도우 정의
            var iwContent = '<div style="padding:5px;"><b>'+ positions[i].title +'</b><br/>';


            var iwContent  = '<div class="all_wrap">';
            iwContent += '<h2 class="pop_tit">'+ positions[i].title +'</h2>';
            iwContent += '<div class="popImgNExp_wrap">';
            iwContent += '<div class="popImg">'+ positions[i].fileUrl +'</div>';
            //iwContent += '<div class="popExp">'+ positions[i].content +'</div>';
            iwContent += '</div><div class="popBtn_wrap">';
            iwContent += '<a href="./pharmacy_detail.php?idx='+ positions[i].pharmacyIDX +'" class="btn3">약국바로가기</a>';
            iwContent += '</div><div class="popBtn_wrap">';
            iwContent += '<a href="javascript:void(0);" onClick="add_ps_pharmacy(\''+ positions[i].psCode +'\',\''+ positions[i].pharmacyCode +'\')" class="btn1">처방전송</a>';
            iwContent += '<a href="tel://'+ positions[i].mainPhone +'" class="btn2">전화문의</a>';
            iwContent += '</div>';
            iwContent += '</div>';

            var iwRemoveable = true; // removeable 속성을 ture 로 설정하면 인포윈도우를 닫을 수 있는 x버튼이 표시됩니다

            // 인포윈도우를 생성합니다
            var infowindow = new kakao.maps.InfoWindow({
                content : iwContent, // 인포윈도우에 표시할 내용
                removable : iwRemoveable
            });

            // 마커에 mouseover 이벤트와 mouseout 이벤트를 등록합니다
            // 이벤트 리스너로는 클로저를 만들어 등록합니다
            // for문에서 클로저를 만들어 주지 않으면 마지막 마커에만 이벤트가 등록됩니다
            kakao.maps.event.addListener(marker, 'click', makeClick(map, marker, infowindow));
        }



        // 인포윈도우를 표시하는 클로저를 만드는 함수입니다
        function makeClick(map, marker, infowindow) {
            return function() {
                infowindow.open(map, marker);
            };
        }
    </script>

    <script>
        function add_ps_pharmacy(ps_code, p_code) {
            location.href = "../_action/prescription.do.php?Mode=add_ps_pharmacy&ps_code=" + ps_code + "&p_code=" + p_code;
        }
    </script>


<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>