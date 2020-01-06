<?php
include_once "../../_core/_init.php";
    
    $qry       = " SELECT * FROM {$TB_STIPULATION} ";
    $where_001 = " WHERE IDX = '2' ";
    $where_002 = " WHERE IDX = '1' ";
    $where_003 = " WHERE IDX = '5' ";

    $res_001 = $db->exec_sql($qry. $where_001);
    $row_001 = $db->sql_fetch_array($res_001);

    $res_002 = $db->exec_sql($qry. $where_002);
    $row_002 = $db->sql_fetch_array($res_002);

    $res_003 = $db->exec_sql($qry. $where_003);
    $row_003 = $db->sql_fetch_array($res_003);

?>

</div>
<iframe name="actionForm" width="0" height="0" frameborder="0" style="display:none;"> </iframe>

<!-- script custom -->
<script type="text/javascript" src="../js/ui_script.js?ver=1;"></script>
<!-- 개인정보취급정보 / 이용약관 / 위치기반서비스 -->
<div class="modal_fbody">
	<div class="modal_wrap">
		<div class="modal_coNt">
			<ul class="eTabMenu">
				<li class="open"><a href="agreemEnt00" id="show_info00"><?=$row_001["A_TITLE"]?></a></li>
				<li><a href="agreemEnt01" id="show_info01"><?=$row_002["A_TITLE"]?></a></li>
				<li><a href="agreemEnt02" id="show_info02"><?=$row_003["A_TITLE"]?></a>	</li>
			</ul>
			<div class="showfield" id="agreemEnt00">
				<div class="coNtscroller">
                    <?=nl2br(clear_escape($row_001["A_CONTENTS"]))?><br>

				</div>
			</div>
			<div class="showfield" id="agreemEnt01">
				<div class="coNtscroller">
					<?=nl2br(clear_escape($row_002["A_CONTENTS"]))?><br>
				</div>
			</div>
			<div class="showfield" id="agreemEnt02">
				<div class="coNtscroller">
					<?=nl2br(clear_escape($row_003["A_CONTENTS"]))?><br>
				</div>
			</div>
		</div>
		<a href="" class="close_modal">close button</a>
	</div>
</div>

</body>
</html>