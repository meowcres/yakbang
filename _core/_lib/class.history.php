<?php

class DateHistory{

	var $chker, $field;

	function DateHistory(){
		$this->chker = "n" ;
	}

	function checkYear($db,$tb,$year){
		if($tb == "hm_history_tb"){
			$this->field = "h_type" ;
		}else if($tb == "hm_business_tb"){
			$this->field = "b_type" ;
		}

		$_sql = "SELECT COUNT(*) FROM {$tb} WHERE {$this->field}='{$year}'" ;
		$_res = $db->exec_sql($_sql);
		$_row = $db->sql_fetch_row($_res);

		if($_row[0] > 0){
			$this->chker = "y" ;
		}else{
			$this->chker = "n" ;
		}
	}

}

?>