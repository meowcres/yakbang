<div id="Contents">
	<h1>환경설정 &gt; 운영자관리 &gt; <strong>운영자등록</strong></h1>

	<form name="frm" method="post" action="./_action/conf.do.php" onSubmit="return chk_admin_form(this);" style="display:inline;" target="actionForm">
	<input type="hidden" id="mode" name="mode" value="admin_add">
	<input type="hidden" id="chk_id" name="chk_id" value="">
	<table class="tbl1">
		<colgroup>
			<col width="15%" />
			<col width="35%" />
			<col width="15%" />
			<col width="*" />
		</colgroup>
		<tr>
			<th>ID</th>
			<td class="left">
				<input type="text" id="admin_id" name="admin_id" value="" style="width:120px;ime-mode:disabled;"> <input type="button" value="중복찾기" class="Small_Button btnOrange" onClick="chk_double_admin_id();">
			</td>
			<th>이름</th>
			<td class="left">
				<input type="text" id="admin_name" name="admin_name" value="" class="Text Kor" style="width:200px;">
			</td>
		</tr>
		<tr>
			<th>비밀번호</th>
			<td class="left">
				<input type="password" id="admin_pass" name="admin_pass" value="" class="Text Eng" style="width:100px;" maxlength="15"> ( 4 ~ 16자 )
			</td>
			<th>비밀번호확인</th>
			<td class="left">
				<input type="password" id="re_pass" name="re_pass" value="" class="Text Eng" style="width:100px;" maxlength="15">
			</td>
		</tr>
		<tr>
			<th>핸드폰</th>
			<td class="left" colspan="3">
				<input type="text" id="Mobile1" name="Mobile1" value="" class="Text Eng" style="width:50px;"> -
				<input type="text" id="Mobile2" name="Mobile2" value="" class="Text Eng" style="width:50px;"> -
				<input type="text" id="Mobile3" name="Mobile3" value="" class="Text Eng" style="width:50px;">
			</td>
		</tr>
		<tr>
			<th>EMAIL</th>
			<td colspan="3" class="left">
				<input id="emailID" name="emailID" type="text" class="Text Eng" style="width:250px;ime-mode:disabled;" /> @
				<select id="selectDomin" name="selectDomin" onChange="document.getElementById('emailDomain').value = this.value; ">
					<option value="">직접입력</option>
					<?
					while(list($key,$value) = each($email_array)){
						echo "<option value='{$value}'>{$value}</option>";
					}
					?>
				</select>
				<input id="emailDomain" name="emailDomain" type="text" class="Text Eng" style="width:250px;ime-mode:disabled;" /> 
			</td>
		</tr>
		<tr>
			<th>관리등급</th>
			<td colspan="3" style="padding:5px 5px 5px 10px;" class="left">
			<?
			$_menu_num = 1 ;
			while(list($key,$value) = each($_adminMenu)){
				?><input type="checkbox" id="g<?=$_menu_num?>" name="g<?=$_menu_num?>" value="Y" /> <?=$value[0]?> &nbsp;&nbsp;&nbsp;<?
				$_menu_num++ ;
			}
			
			reset($_adminMenu) ;
			?>
			</td>
		</tr>
	</table>

	<div style="margin-top:20px;" class="center">
		<input type="submit" value="등록" class="Button btnGreen"> &nbsp; 
		<input type="button" value="취소" class="Button btnOrange" onClick="reset();">
	</div>
	</form>

</div>

<script>
function chk_double_admin_id() {
	var ID = document.getElementById("admin_id").value;
  if(!ID || ID.length < 4 || ID.length > 16) {
		alert('아이디(ID)를 확인하세요. \n\n아이디는 4~16 입니다.');
		document.getElementById("admin_id").value = "";
		document.getElementById("admin_id").focus();
		return false;
	} else {
		actionForm.location.href="./_action/conf.do.php?mode=id_find&admin_id="+ID;
	}
}


// 입력폼 체크 자바스크립트
function chk_admin_form() {
	if(!$.trim($("#chk_id").val())){
		alert("아이디 중복 검사를 진행하여 주세요.");
		$("#admin_id").focus();
		return false;
	}

	if(!$.trim($("#admin_name").val())){
		alert("관리자 이름를 입력해 주세요.");
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