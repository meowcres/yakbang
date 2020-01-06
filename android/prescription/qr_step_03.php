<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
?>
<!-- content start -->
<div class="coNtent">
	<div class="position_wrap">
		<span>스마트 처방조제</span>
        <span>처방전 전송동의</span>
        <span>QR코드 촬영</span>
        <span>QR코드 확인</span>
	</div>
	<div class="inner_coNtbtnwrap">
		<div class="fixedbodycoNt">
			<table class="etbble" summary="처방의약품의 명칭, 1회투약량, 1일투여횟수, 총 투약일시 순으로 정의">
				<caption>처방전 상세 내용</caption>
				<colgroup>
					<col width="52%">
					<col width="16%">
					<col width="16%">
					<col width="16%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col">처방의약품의 명칭</th>
						<th scope="col">1회<br/>투약량</th>
						<th scope="col">1일<br/>투여횟수</th>
						<th scope="col">총<br/>투약일시</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope="row">[급여][65646346]더모타손엠엘이로션(모에타손푸로에이트)_(30mg/30g)</th>
						<td>1</td>
						<td>1</td>
						<td>1</td>
					</tr>
					<tr>
						<th scope="row">(4)아클론정(아세클로페낙)(신풍)</th>
						<td>1</td>
						<td>2</td>
						<td>7</td>
					</tr>
					<tr>
						<th scope="row">(5)뉴페리손정(신풍)</th>
						<td>1</td>
						<td>2</td>
						<td>7</td>
					</tr>
					<tr>
						<th scope="row">(6)라니비트정(신풍)</th>
						<td>1</td>
						<td>2</td>
						<td>7</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="coNtBtn">
		<div class="coNtbtn_wrap">
			<a href="./qr_step_02.php" class="ecolor"><span class="btnicon03">QR 재촬영</span></a>
			<a href="../pharmacy/find_map.php" class="ecolor_plus"><span class="btnicon01">처방전 전송</span></a>
		</div>
	</div>
</div>
<!-- content end -->

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>