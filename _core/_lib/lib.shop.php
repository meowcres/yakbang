<?
#*********************************************************************************************
#  Function : goods_counter($goods_idx,$op)
#  내용     : 
#  반환값   : 
#*********************************************************************************************
function goods_counter($goods_idx,$op){
	global $GOODS_M_TB ;
	global $db ;

	if($op == "add"){
		$_sql = "UPDATE {$GOODS_M_TB} SET hit_number = hit_number + 1  WHERE idx='{$goods_idx}' ";
	}else{
		$_sql = "UPDATE {$GOODS_M_TB} SET hit_number = hit_number - 1  WHERE idx='{$goods_idx}' ";
	}

	$db->exec_sql($_sql) ;

}


#*********************************************************************************************
#  Function : buy_counter($goods_idx,$count,$op)
#  내용     : 
#  반환값   : 
#*********************************************************************************************
function buy_counter($goods_idx,$count,$op){
	global $GOODS_M_TB ;
	global $GOODS_S_TB ;
	global $db ;

	if($op == "sell"){
		$_sql  = "UPDATE {$GOODS_M_TB} t1, {$GOODS_S_TB} t2  SET    " ;
		$_sql .= " t1.buy_number = t1.buy_number + {$count}         " ;
		$_sql .= ",t2.goods_ea   = t2.goods_ea - {$count}           " ;
		$_sql .= "WHERE t1.idx = t2.goods_idx                       " ;
		$_sql .= "AND t1.idx='{$goods_idx}'                         " ;
	}else{
		$_sql  = "UPDATE {$GOODS_M_TB} t1, {$GOODS_S_TB} t2  SET    " ;
		$_sql .= " t1.buy_number = t1.buy_number - {$count}         " ;
		$_sql .= ",t2.goods_ea   = t2.goods_ea + {$count}           " ;
		$_sql .= "WHERE t1.idx = t2.goods_idx                       " ;
		$_sql .= "AND t1.idx='{$goods_idx}'                         " ;
	}

	$db->exec_sql($_sql) ;

}



#****************************************************************************************************
#  Function : shop_point_process($order_no,$user_idx,$old_status,$new_status,$use_point,$give_point)
#  내용     : 
#  반환값   : 
#****************************************************************************************************
function shop_point_process($order_no,$user_idx,$old_status,$new_status,$use_point,$give_point){
	global $MEMBER_TB ;
	global $db ;
	global $settlement_array ;
	//global LOG_DIR ;

	$_sql = "SELECT * FROM {$MEMBER_TB} t1 WHERE t1.idx='{$user_idx}'" ;
	$_res = $db->exec_sql($_sql);
	$_row = $db->sql_fetch_array($_res);

	$_user_info = $_row["user_name"]."(".$_row["user_id"].")" ;
	$writer     = "포인트기록" ;
	$_msg       = "상품 [".$order_no."] 의 ".$settlement_array[$old_status]." 에서 ".$settlement_array[$new_status]." 의 상태변화로 인한 " ;

	if($new_status == 4 || $new_status == 8){

		if($old_status == 6){

			if($use_point > 0){
				// 사용포인트 복구
				$msg1 = $_msg."사용포인트 복구" ;
				point_process($user_idx,$use_point,"plus",6,$msg1) ;
				
				$msg2   = "[증가] ".$msg1." : ".$_user_info." 님의 포인트에 ".number_format($use_point)." 점이 증가 되었습니다." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}

			if($give_point > 0){
				// 적립포인트 회수
				$msg1 = $_msg."적립포인트 회수" ;
				point_process($user_idx,$give_point,"minus",7,$msg1) ;

				$msg2   = "[차감] ".$msg1." : ".$_user_info." 님의 포인트에 ".number_format($give_point)." 점이 차감 되었습니다." ;
				$lg2 = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg2->write_process() ;
			}

		}else{

			if($use_point > 0){
				// 사용포인트 복구
				$msg1 = $_msg."사용포인트 복구" ;
				point_process($user_idx,$use_point,"plus",6,$msg1) ;

				$msg2   = "[증가] ".$msg1." : ".$_user_info." 님의 포인트에 ".number_format($use_point)." 점이 증가 되었습니다." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}

		}

	}else if($new_status == 6){

		if($old_status == 4 || $old_status == 8){

			if($give_point > 0){
				// 적립포인트 지급
				$msg1 = $_msg."적립포인트 지급" ;
				point_process($user_idx,$give_point,"plus",2,$msg1) ;

				$msg2   = "[증가] ".$msg1." : ".$_user_info." 님의 포인트에 ".number_format($give_point)." 점이 증가 되었습니다." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}
			

			if($use_point > 0){
				// 사용포인트 차감
				$msg1 = $_msg."사용포인트 차감" ;
				point_process($user_idx,$use_point,"minus",1,$msg1) ;

				$msg2   = "[차감] ".$msg1." : ".$_user_info." 님의 포인트에 ".number_format($use_point)." 점이 차감 되었습니다." ;
				$lg2 = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg2->write_process() ;
			}

			
		}else{
			
			if($give_point > 0){
				// 적립포인트 지급
				$msg1 = $_msg."적립포인트 지급" ;
				point_process($user_idx,$give_point,"plus",2,$msg1) ;

				$msg2   = "[증가] ".$msg1." : ".$_user_info." 님의 포인트에 ".number_format($give_point)." 점이 증가 되었습니다." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}

		}

	}else{
			
		if($old_status == 4 || $old_status == 8){
			
			if($use_point > 0){
				// 사용포인트 차감
				$msg1 = $_msg."사용포인트 차감" ;
				point_process($user_idx,$use_point,"minus",1,$msg1) ;

				$msg2   = "[차감] ".$msg1." : ".$_user_info." 님의 포인트에 ".number_format($use_point)." 점이 차감 되었습니다." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}
			
		}else if($old_status == 6){

			if($give_point > 0){
				// 적립포인트 회수
				$msg1 = $_msg."적립포인트 회수" ;
				point_process($user_idx,$give_point,"minus",7,$msg1) ;

				$msg2   = "[차감] ".$msg1." : ".$_user_info." 님의 포인트에 ".number_format($give_point)." 점이 차감 되었습니다." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}

		}

	}

}
?>