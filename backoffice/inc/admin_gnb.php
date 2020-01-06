<div id="GNB">
	<ul>
		<li style="width:30px;">&nbsp;</li>
		<?
		$_top_num = 0 ;
		while(list($key,$value) = each($_adminMenu)){
			
			$_lnb_display[$key] = "none" ;

			if(substr($_admin["grade"],$_top_num,1) == "Y"){
					
					if($_slot == $key){
						$_lnb_display[$key] = "block" ;
						?><li class="GNB_ON">&nbsp;&nbsp;&nbsp;&nbsp;<?=$value[0]?>&nbsp;&nbsp;&nbsp;&nbsp;</li><?
					}else{
						?><li>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$value[1]?>"><?=$value[0]?></a>&nbsp;&nbsp;&nbsp;&nbsp;</li><?
					}

			}
			//$_top_num++ ;
		}

		reset($_adminMenu) ;

    $_lnb_display["main"] = $_type == "dashboard" ? "block" : "none" ;
		?>
	</ul>
</div>


