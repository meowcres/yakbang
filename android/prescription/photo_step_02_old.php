<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

if ($_POST["chk_agree"] != "y") {
    alert_js("alert_back","전송동의가 정확하지 않습니다","");
}

?>
<!-- content start -->
<div class="coNtent">
	<div class="position_wrap">
		<span>스마트 처방조제</span>
		<span>처방전 전송동의</span>
		<span>촬영하기</span>
	</div>
	<div class="inner_coNtbtnwrap">
		<div class="fixedbodycoNt">

		</div>
	</div>
	<div class="coNtBtn">
		<div class="coNtbtn_wrap">
            <!--a href="javascript:void(0);" class="ecolor"><span class="btnicon02">촬영하기</span></a-->
            <a href="photo_step_03.php" class="ecolor"><span class="btnicon02">촬영하기</span></a>
		</div>
	</div>
    <input type="file" id="preScriptionFile" name="preScriptionFile" capture="camera" style="display:none;">
</div>
<!-- content end -->

<script>

    $(".btnicon02").click(function(){
        $("input[name='preScriptionFile']").click();
    });

</script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>