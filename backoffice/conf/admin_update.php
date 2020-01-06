<?
$_idx = "";

if(isNull($_GET["admin_id"])){
	alert_js("alert_back","관리자 정보가 옳바르지 않습니다.","") ;
	exit;
}else{
	$_idx = $_GET["admin_id"] ;

	$_sql = "SELECT * FROM {$TB_ADMIN} WHERE ADMIN_ID='{$_idx}'";
	$_res = $db->exec_sql($_sql);
	$_row = $db->sql_fetch_array($_res);

	$_admin_name   = stripslashes($_row["ADMIN_NAME"]);
	$_admin_mobile = explode("-",stripslashes($_row["ADMIN_MOBILE"]));
	$_admin_email  = explode("@",stripslashes($_row["ADMIN_EMAIL"]));

	$_status = array();
	$_status[$_row["ADMIN_STATUS"]] = "selected";	

	$_grade_number = sizeof($_adminMenu) ;
	$_g = array();
	for($i=1;$i<=$_grade_number;$i++){
		$_g[$i] = substr($_row["ADMIN_GRADE"],$i-1,1) == "Y" ? "checked" : "" ;
	}


}
?>
<div id="Contents">
	<h1>CONFIG &gt; 운영자관리 &gt; <strong>운영자수정</strong></h1>

	<form name="frm" method="post" action="./_action/conf.do.php" onSubmit="return chk_admin_form(this);" style="display:inline;" target="actionForm">
	<input type="hidden" name="mode" value="admin_modify">
	<input type="hidden" name="idx" value="<?=$_idx?>">
	<table class="tbl1">
		<colgroup>
			<col width="15%" />
			<col width="35%" />
			<col width="15%" />
			<col width="*"   />
		</colgroup>
		<tr>
			<th>상태</th>
			<td colspan="3" class="left">
				<select id="admin_status" name="admin_status">
					<option value="Y" <?=$_status["Y"]?>>활동</option>
					<option value="N" <?=$_status["N"]?>>중단</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>ID</th>
			<td class="left"><?=$_row["ADMIN_ID"]?></td>
			<th>이름</th>
			<td class="left">
				<input type="text" id="admin_name" name="admin_name" value="<?=$_admin_name?>" class="Text Kor" style="width:200px;">
			</td>
		</tr>
		<tr>
			<th>비밀번호</th>
			<td class="left">
				<input type="password" id="admin_pass" name="admin_pass" value="<?=$_row["ADMIN_PASS"]?>" class="Text Eng" maxlength="16"> ( 4 ~ 16자 )
			</td>
			<th>비밀번호확인</th>
			<td class="left">
				<input type="password" id="re_pass" name="re_pass" value="<?=$_row["ADMIN_PASS"]?>" class="Text Eng" maxlength="16">
			</td>
		</tr>
		<tr>
			<th>핸드폰</th>
			<td class="left" colspan="3">
				<input type="text" id="Mobile1" name="Mobile1" value="<?=$_admin_mobile[0]?>" class="Text Eng" style="width:50px;"> -
				<input type="text" id="Mobile2" name="Mobile2" value="<?=$_admin_mobile[1]?>" class="Text Eng" style="width:50px;"> -
				<input type="text" id="Mobile3" name="Mobile3" value="<?=$_admin_mobile[2]?>" class="Text Eng" style="width:50px;">
			</td>
		</tr>
		<tr>
			<th>EMAIL</th>
			<td colspan="3" class="left">
				<input id="emailID" name="emailID" type="text" value="<?=$_admin_email[0]?>" class="Text Eng" size="20" /> @
				<select name="selectDomin" onChange="document.getElementById('emailDomain').value = this.value; ">
					<option value="">직접입력</option>
					<?
					while(list($key,$value) = each($email_array)){
						echo "<option value='{$value}'>{$value}</option>";
					}
					?>
				</select>
				<input id="emailDomain" name="emailDomain" type="text" value="<?=$_admin_email[1]?>" class="Text Eng" size="20" />
			</td>
		</tr>
		<tr>
			<th>관리등급</th>
			<td colspan="3" class="left">
			<?
			$_menu_num = 1 ;
			while(list($key,$value) = each($_adminMenu)){
				?><input type="checkbox" id="g<?=$_menu_num?>" name="g<?=$_menu_num?>" value="Y" <?=$_g[$_menu_num]?> /> <?=$value[0]?> &nbsp;&nbsp;&nbsp;<?
				$_menu_num++ ;
			}
			?>
			</td>
		</tr>
	</table>
	<div style="margin-top:20px;" class="center">
			<input type="button" value=" 목록 " class="btn btn_blue w80 h32" onClick="location.href='./admin.template.php?slot=conf&type=admin_list&page=<?=$page?>'"> &nbsp;
			<input type="submit" value=" 수정 " class="btn btn_green w80 h32"> &nbsp;
			<input type="button" value=" 취소 " class="btn btn_red w80 h32" onClick="reset();">
		</div>
	</div>
	</form>

</div>



<script>
// 입력폼 체크 자바스크립트
function chk_admin_form() {
	if(!$.trim($("#admin_name").val())){
		alert("운영자 이름를 입력해 주세요.");
		$("#admin_name").focus();
		return false;
	}

  if($.trim($("#admin_pass").val())){
    if ($.trim($("#admin_pass").val()) != $.trim($("#re_pass").val()))
    {
      alert("비밀번호가 일치하지 않습니다.");
      $("#admin_pass").focus();
      return false;
    }
	}else{
    alert("비밀번호를 입력 해 주세요.");
    $("#admin_pass").focus();
    return false;
  }

	$("#frm").submit();
}
</script>