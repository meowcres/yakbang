<?php

/*
 * 이 클래스는 다음과 같은 구조의 테이블에 맞게 설계 되어 있습니다.
 *
 *`p_Title` varchar(255) NOT NULL DEFAULT '',
 *`p_View` varchar(2) NOT NULL DEFAULT 'Y',
 *`p_Status` varchar(20) NOT NULL,
 *`p_Cookie` varchar(20) NOT NULL,
 *`p_Cookie_Date` varchar(50) NOT NULL,
 *`p_StartDate` int(11) NOT NULL DEFAULT '0',
 *`p_EndDate` int(11) NOT NULL DEFAULT '0',
 *`p_Width` int(11) NOT NULL DEFAULT '0',
 *`p_Height` int(11) NOT NULL DEFAULT '0',
 *`p_Top` int(11) DEFAULT NULL,
 *`p_Left` int(11) DEFAULT NULL,
 *`p_Contents` mediumtext,
 *`file_1` varchar(100) DEFAULT NULL,
 *`real_name1` varchar(250) DEFAULT NULL,
 *`reg_date` datetime DEFAULT NULL,
 */

class PopUp{

	function PopUp($db,$tb,$cookie_name,$popup_url){

		$this->db = $db;
		$this->tb = $tb;
		$this->cookie_name = $cookie_name."_";
		$this->popup_url = $popup_url;
		$this->day = mktime(0,0,0,date("m"),date("d"),date("Y"));
	}

	function openPopup(){

		$_z_index = 100;
		$_sql = "SELECT *, replace(replace(p_Contents, char(13), ''), char(10), '') AS p_Contents2 FROM {$this->tb} WHERE p_View = 'y' AND p_StartDate <= '{$this->day}' AND p_EndDate >= '{$this->day}'";
		$_res = $this->db->exec_sql($_sql);
		while($_row = $this->db->sql_fetch_array($_res)){
			if($_COOKIE[$this->cookie_name.$_row['idx']] != "1015"){
				if($_row['p_Status'] == "popup"){
					$this->popupInfo($_row,"");
				}else if($_row['p_Status'] == "layer"){
					$this->layerInfo($_row,"");
				$_z_index++;
				}
			}
		}
		$this->closeLayer();
	}

	function testPopup($idx){

		$_sql = "SELECT *, replace(replace(p_Contents, char(13), ''), char(10), '') AS p_Contents2 FROM {$this->tb} WHERE idx = {$idx}";
		$_res = $this->db->exec_sql($_sql);
		$_row = $this->db->sql_fetch_array($_res);

		if($_row['p_Status'] == 'popup'){
			//$this->popupInfo($_row,"test");
		}else if($_row['p_Status'] == 'layer'){
			$this->layerInfo($_row,"test");
		}
	}

	function popupInfo($_array,$TEST){

		$_popup_height = $_array["p_Cookie"] == "y" ? $_array['p_Width'] + 20 : $_array['p_Height'] ; ?>

		<script language="javascript" type="text/javascript">
			//var test = "<?=$TEST?>";
			window.open("<?=$this->popup_url.'?idx='.$_array['idx'].'&cookieName='.$this->cookie_name.$_array['idx']?>","<?=$this->cookie_name.$_array['idx']?>","width=<?=$_array['p_Width']?>,height=<?=$_popup_height?>,left=<?=$_array['p_Left']?>,top=<?=$_array['p_Top']?>");
		</script>
		<?
	}

	function layerInfo($_array,$TEST){

		//레이어를 띄우기 위해 content의 쌍따옴표를 외따옴표로 변경
		$_layer_cont = str_replace("\"","\'",$_array['p_Contents2']);

		//쿠키 시간정보
		$_cookie_date[$_array['idx']] = (int)$_array['p_Cookie_Date']; ?>

		<script language="javascript" type="text/javascript">

			var test = "<?=$TEST?>";
			var eDiv = document.createElement("div");
			//레이어 내용
			var innerDiv = "";

			if(test == "test"){
				var display = "display:none;";
			}else{
				var display = "display:block;";
			}

			innerDiv += "<div id='popup_div_<?=$_array['idx']?>' class='popup_div' style='position:absolute; z-index:200;" + display + "left:<?=$_array['p_Left']?>px; top:<?=$_array['p_Top']?>px;width:<?=$_array['p_Width']?>px;height:<?=$_array['p_Height']?>px; '>";
			innerDiv += "<div style='background-color:#fff;'>";
			innerDiv += "<?=$_layer_cont?>";
			innerDiv += "</div>";
			innerDiv += "<div style='background-color:black; color:white; font-size:0.85em; line-height:20px; padding:10px'>";
			if("<?=$_array['p_Cookie_Date']?>" != 0){
				innerDiv += "<input type='checkbox' id='checkbox_<?=$_array['idx']?>'>";
				innerDiv += "오늘 하루 이 창을 열지 않음";
				innerDiv += "<span style='float:right;'>";
				innerDiv += "<input type=button id='closeBtn_<?=$_array['idx']?>_<?=$_array['p_Cookie_Date']?>' value='닫기' onClick='closeDiv(this.id);'>";
				innerDiv += "</span>";
			}else{
				innerDiv += "<span style='float:right;'>";
				innerDiv += "<input type=button id='closeBtn_<?=$_array['idx']?>_<?=$_array['p_Cookie_Date']?>' value='닫기' onClick='closeDiv2(this.id);'>";
				innerDiv += "</span>";
			}
			innerDiv += "</div>";
			innerDiv += "</div>";

			document.body.appendChild(eDiv);
			eDiv.innerHTML = innerDiv;

		</script>
		<?
		$this->closeLayer();
	}

	function closeLayer(){

		?>
		<script>
			function closeDiv(id_res){
				var idx = id_res.split("_");
				if(document.getElementById("checkbox_"+idx[1]).checked == true){
					document.cookie = "<?=$this->cookie_name?>"+idx[1]+"=1015; path=/; expires=time()+("+idx[2]+" * 86400)';";
				}
				//document.getElementById("popup_div_"+idx[1]).removeNode(true);
				document.getElementById("popup_div_"+idx[1]).style.display="none";  
			}

			function closeDiv2(id_res){
				var idx = id_res.split("_");
				//document.getElementById("popup_div_"+idx[1]).removeNode(true);
				document.getElementById("popup_div_"+idx[1]).style.display="none";  
			}
		</script>
		<?
	}

}
?>