<?
#*********************************************************************************************
#  Function : goods_counter($goods_idx,$op)
#  ����     : 
#  ��ȯ��   : 
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
#  ����     : 
#  ��ȯ��   : 
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
#  ����     : 
#  ��ȯ��   : 
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
	$writer     = "����Ʈ���" ;
	$_msg       = "��ǰ [".$order_no."] �� ".$settlement_array[$old_status]." ���� ".$settlement_array[$new_status]." �� ���º�ȭ�� ���� " ;

	if($new_status == 4 || $new_status == 8){

		if($old_status == 6){

			if($use_point > 0){
				// �������Ʈ ����
				$msg1 = $_msg."�������Ʈ ����" ;
				point_process($user_idx,$use_point,"plus",6,$msg1) ;
				
				$msg2   = "[����] ".$msg1." : ".$_user_info." ���� ����Ʈ�� ".number_format($use_point)." ���� ���� �Ǿ����ϴ�." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}

			if($give_point > 0){
				// ��������Ʈ ȸ��
				$msg1 = $_msg."��������Ʈ ȸ��" ;
				point_process($user_idx,$give_point,"minus",7,$msg1) ;

				$msg2   = "[����] ".$msg1." : ".$_user_info." ���� ����Ʈ�� ".number_format($give_point)." ���� ���� �Ǿ����ϴ�." ;
				$lg2 = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg2->write_process() ;
			}

		}else{

			if($use_point > 0){
				// �������Ʈ ����
				$msg1 = $_msg."�������Ʈ ����" ;
				point_process($user_idx,$use_point,"plus",6,$msg1) ;

				$msg2   = "[����] ".$msg1." : ".$_user_info." ���� ����Ʈ�� ".number_format($use_point)." ���� ���� �Ǿ����ϴ�." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}

		}

	}else if($new_status == 6){

		if($old_status == 4 || $old_status == 8){

			if($give_point > 0){
				// ��������Ʈ ����
				$msg1 = $_msg."��������Ʈ ����" ;
				point_process($user_idx,$give_point,"plus",2,$msg1) ;

				$msg2   = "[����] ".$msg1." : ".$_user_info." ���� ����Ʈ�� ".number_format($give_point)." ���� ���� �Ǿ����ϴ�." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}
			

			if($use_point > 0){
				// �������Ʈ ����
				$msg1 = $_msg."�������Ʈ ����" ;
				point_process($user_idx,$use_point,"minus",1,$msg1) ;

				$msg2   = "[����] ".$msg1." : ".$_user_info." ���� ����Ʈ�� ".number_format($use_point)." ���� ���� �Ǿ����ϴ�." ;
				$lg2 = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg2->write_process() ;
			}

			
		}else{
			
			if($give_point > 0){
				// ��������Ʈ ����
				$msg1 = $_msg."��������Ʈ ����" ;
				point_process($user_idx,$give_point,"plus",2,$msg1) ;

				$msg2   = "[����] ".$msg1." : ".$_user_info." ���� ����Ʈ�� ".number_format($give_point)." ���� ���� �Ǿ����ϴ�." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}

		}

	}else{
			
		if($old_status == 4 || $old_status == 8){
			
			if($use_point > 0){
				// �������Ʈ ����
				$msg1 = $_msg."�������Ʈ ����" ;
				point_process($user_idx,$use_point,"minus",1,$msg1) ;

				$msg2   = "[����] ".$msg1." : ".$_user_info." ���� ����Ʈ�� ".number_format($use_point)." ���� ���� �Ǿ����ϴ�." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}
			
		}else if($old_status == 6){

			if($give_point > 0){
				// ��������Ʈ ȸ��
				$msg1 = $_msg."��������Ʈ ȸ��" ;
				point_process($user_idx,$give_point,"minus",7,$msg1) ;

				$msg2   = "[����] ".$msg1." : ".$_user_info." ���� ����Ʈ�� ".number_format($give_point)." ���� ���� �Ǿ����ϴ�." ;
				$lg = new site_log(LOG_DIR,"point",$writer,$msg2) ;
				$lg->write_process() ;
			}

		}

	}

}
?>