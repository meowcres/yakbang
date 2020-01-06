<?php
/**
*  파일명 : lib.common.php
*  비고   : 기본 함수 및 클래스 라이브러리
**/


/**
*  @brief session_register 가 5.3.0 부터 사라졌으므로 강제 생성
*  @param 
*  @return session_register 기능 복원
**/
if (!function_exists('session_register')) {
    // var_dump($_SESSION);
    foreach($_SESSION as $sKey => $sVal)
    {
        if (!isset(${$sKey})) {
            ${$sKey} = $sVal;
        }
    }
    
    function session_register($key)
    {
        $_SESSION[$key] = $GLOBALS[$key];
    }
}


/**
*  @brief 문자열 변수의 값이 존재하는 지 검사
*  @param string 자를 원 문자열
*  @return Null 값이나 빈값일 경우 true , Null 값이 아니거나 값이 존재하면 false
**/
function isNull($var=Null)
{
    $temp = trim($var);
    $temp = str_replace(" ","",$temp);
    $result = empty($temp) ? true : false;
    return $result;
}


/**
*  @brief 자바스크립트의 alert 과 페이지 이동기능을 담당
*  @param act _으로 모아둔 구분자
*  @param Message alert이 작동될 때 메시지
**/
function alert_js($act,$Message=Null,$url)
{
    $Message = str_replace("'", "\"", trim($Message));
    $act_obj = explode("_",$act);
    
    echo "<script language='javascript'>";
    
    for ($_i=0;$_i<sizeof($act_obj);$_i++) {
        switch($act_obj[$_i]){
            case("alert"):
                echo "alert('".$Message."');";
            break;

            case("move"):
                echo "location.href = '".$url."';";
            break;
            
            case("back"):
                echo "history.back();";
            break;
            
            case("reload"):
                echo "location.reload();";
            break;
            
            case("openreload"):
                echo "reload();";
            break;

            case("opener"):
                echo "opener.";
            break;
            
            case("parent"):
                echo "parent.";
            break;
            
            case("selfclose"):
                echo "self.close();";
            break;
        }
    }
    echo "</script>";
}


/**
*  @brief 주어진 문자를 주어진 크기로 자르고 잘라졌을 경우 주어진 꼬리를 붙힘
*  @param string 자를 원 문자열
*  @param cut_size 주어진 원 문자열을 자를 크기
*  @param tail 잘라졌을 경우 문자열의 제일 뒤에 붙을 꼬리
*  @return string
**/
function cut_str($string,$cut_size=0,$tail='...')
{
    if ($cut_size<1 || !$string) {
        return $string;
    }

    $chars = Array(12, 4, 3, 5, 7, 7, 11, 8, 4, 5, 5, 6, 6, 4, 6, 4, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 4, 4, 8, 6, 8, 6, 10, 8, 8, 9, 8, 8, 7, 9, 8, 3, 6, 7, 7, 11, 8, 9, 8, 9, 8, 8, 7, 8, 8, 10, 8, 8, 8, 6, 11, 6, 6, 6, 4, 7, 7, 7, 7, 7, 3, 7, 7, 3, 3, 6, 3, 9, 7, 7, 7, 7, 4, 7, 3, 7, 6, 10, 6, 6, 7, 6, 6, 6, 9);
    $max_width = $cut_size*$chars[0]/2;
    $char_width = 0;
    
    $string_length = strlen($string);
    $char_count = 0;
    
    $idx = 0;
    
    while ($idx < $string_length && $char_count < $cut_size && $char_width <= $max_width) {
        $c = ord(substr($string, $idx,1));
        $char_count++;
        
        if ($c<128) {
            $char_width += (int)$chars[$c-32];
            $idx++;
        } else if (191<$c && $c < 224) {
            $char_width += $chars[4];
            $idx += 2;
        } else {
            $char_width += $chars[0];
            $idx += 3;
        }
    }
    
    $output = substr($string,0,$idx);
    
    if (strlen($output)<$string_length) {
        $output .= $tail;
    }
    
    return $output;
}


/**
*  @brief 암호를 체크한다. ( 길이 영역, 특수문자(!"#$%&'()*+), 영문자, 숫자 )
*  @param password 검사 할 암호
*  @param min_num 해당 숫자 이상
*  @param max_num 해당 숫자 미만
*  @return 조건을 만족하면 true 조건을 만족 못하면 false
**/
function check_password($pass, $min_num, $max_num)
{
    $pass = strtolower($pass);
    $len  = strlen($pass);
    
    if ($len >= $min_num && $len <= $max_num) {
        return false;
    }
    
    $nubmer_flag  = 0;
    $alpha_flag   = 0;
    $spechar_flag = 0;
    
    for ($i=0; $i<$len; $i++) {
        $order = ord($pass{$i});

        if ($order > 32 && $order < 48) {
            $spechar_flag = 1;
        }
        
        if ($order > 47 && $order < 58) {
            $nubmer_flag  = 1;
        }
        
        if ($order > 96 && $order < 123) {
            $alpha_flag   = 1;
        }
    }

    $flag_sum = $nubmer_flag + $alpha_flag + $spechar_flag;

    if ($flag_sum > 1) {
        return true;
    } else {
        return false;
    }
}


/**
*  @brief 주민등록번호를 검사한다.
*  @param regNum 검사 할 주민등록번호
*  @return 조건을 만족하면 true 조건을 만족 못하면 false
**/
function check_jumin($regNum) 
{
	$weight = '234567892345'; // 자리수 weight 지정 
	$len = strlen($regNum); 
	$sum = 0; 

	if ($len <> 13) { 
        return false;
    }

	for ($i = 0; $i < 12; $i++) {
		$sum = $sum + (substr($regNum,$i,1)*substr($weight,$i,1));
	}

	$rst = $sum%11; 
	$result = 11 - $rst; 

	if ($result == 10) {
        $result = 0;
    } else if ($result == 11) {
        $result = 1;
    }
    
    $ju13 = substr($regNum,12,1);
    
    if ($result <> $ju13) {
        return false;
    }
    
    return true;
}


/**
*  @brief 문장을 이스케이프 시킨다
*  @param val 변환시킬 문장
*  @return 변환시킨 문장
**/
function add_escape($val){
    $val = str_replace("'","&#39;",$val);
    $val = str_replace('"',"&#34;",$val);
    $val = htmlspecialchars($val);
    $val = addslashes($val);
    return $val;
}


/**
*  @brief 이스케이프 된 문장을 복원한다
*  @param val 복원된 문장
*  @return 복원된 문장
**/
function clear_escape($val){
	$val = str_replace("&#39;","'",$val);
	$val = str_replace("&#34;",'"',$val);
    $val = htmlspecialchars_decode($val);
	$val = stripslashes($val);
	return $val;
}


/**
 *  @brief 이스케이프 된 문장을 복원한다
 *  @param val 복원된 문장
 *  @return 복원된 문장
 **/
function check_pill($pidx, $pCode, $pName){

    global $db ;
    global $TB_PILL ;

    $result = "";

    if(isNull($pidx)) {

        if (!isNull($pCode)) {

            $qry = "SELECT IDX FROM {$TB_PILL} WHERE PILL_CODE='{$pCode}' AND PILL_NAME='{$pName}'";
            $res = $db->exec_sql($qry);
            $row = $db->sql_fetch_row($res);

            if ($row[0] > 0) {
                $up_qry = "UPDATE {$TB_PILL} SET HIT = HIT+1, UP_DATE=now() WHERE IDX='{$row[0]}'";
                $db->exec_sql($up_qry);

                $result = $row[0];
            } else {

                $ch = curl_init();
                $url = 'http://apis.data.go.kr/B551182/msupCmpnMeftInfoService/getMajorCmpnNmCdList'; /*URL*/
                $queryParams = '?' . urlencode('ServiceKey') . '=A9lVTk8Qv60WwcDbP%2FZQGgVta2l3vJPqg1adProicrKh3VnchZ3lCJDRzokpT0QbnrLkt4Dooa3orjeqgiztxw%3D%3D'; /*Service Key*/
                $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('10');
                $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1');
                $queryParams .= '&' . urlencode('gnlNmCd') . '=' . urlencode($pCode);
                $queryParams .= '&' . urlencode('gnlNm') . '=' . urlencode($pName);

                curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                $response = curl_exec($ch);
                curl_close($ch);

                $xml = simplexml_load_string($response);

                foreach ($xml->body->items->item as $obj) {

                    $pill_category = $obj->divNm;
                    $pill_class = $obj->fomnTpCdNm;
                    $pill_name = $obj->gnlNm;
                    $pill_code = $obj->gnlNmCd;
                    $pill_injection = $obj->injcPthCdNm;
                    $pill_material = $obj->iqtyTxt;
                    $pill_medicine_code = $obj->meftDivNo;
                    $pill_unit = $obj->unit;

                }

                $in_qry = " INSERT INTO {$TB_PILL} SET PILL_CATEGORY='{$pill_category}' ";
                $in_qry .= ", PILL_CLASS='{$pill_class}' ";
                $in_qry .= ", PILL_NAME='{$pill_name}' ";
                $in_qry .= ", PILL_CODE='{$pill_code}' ";
                $in_qry .= ", PILL_INJECTION='{$pill_injection}' ";
                $in_qry .= ", PILL_MATERIAL='{$pill_material}' ";
                $in_qry .= ", PILL_MEDICINE_CODE='{$pill_medicine_code}' ";
                $in_qry .= ", PILL_UNIT='{$pill_unit}' ";
                $in_qry .= ", HIT = 1, UP_DATE=now() ";

                $db->exec_sql($in_qry);

                $result = $db->sql_insert_id();
            }

        }

    } else {

        $up_qry = "UPDATE {$TB_PILL} SET HIT = HIT+1, UP_DATE=now() WHERE IDX='{$pidx}'";
        $db->exec_sql($up_qry);

        $result = $pidx;

    }

    return $result;

}













#****************************************************************************
#  Function : userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
#  내용     : 에러핸들러 등록
#  반환값   : errorLog 호출
#****************************************************************************
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
	$errortype = array (
                E_ERROR           => "Error",
                E_WARNING         => "Warning",
                E_PARSE           => "Parsing Error",
                E_NOTICE          => "Notice",
                E_CORE_ERROR      => "Core Error",
                E_CORE_WARNING    => "Core Warning",
                E_COMPILE_ERROR   => "Compile Error",
                E_COMPILE_WARNING => "Compile Warning",
                E_USER_ERROR      => "User Error",
                E_USER_WARNING    => "User Warning",
                E_USER_NOTICE     => "User Notice",
                E_ALL             => "All",
                E_STRICT          => "Strict"
               );
	$err = "<b>" . $errortype[$errno] . "</b>: ".$errmsg." in <b>".$filename."</b> on line <b>".$linenum."</b><br>";
	if($errno < 1025) {
		echo $err;
		errorLog("error", $_SERVER['PHP_SELF']." - ".strip_tags($err));
	}
}

#****************************************************************************
#  Function : errorLog($sending_data)
#  내용     : 에러 로그 기록
#  반환값   : 에러 기록
#****************************************************************************
function errorLog($prefix="log", $msg="", $df='Ym') {
	$logFile = LOG_DIR . "/" . $prefix . "-" . date($df) . ".log";
	$msg = $_SERVER['REMOTE_ADDR'] . " [".date("Y-m-d H:i:s")."] " . $msg . "\r\n";
	if(is_writable(LOG_DIR)) {
		return error_log($msg, 3, $logFile);
	} else {
		return error(LOG_DIR . " is not writable");
	}
}


#****************************************************************************
#  Function : fileUpload($attachFile, $attachFileName, $saveDir = '.')
#  내용     : 파일을 업로드 한다.
#  반환값   : 업로드된 파일정보 
#****************************************************************************
function fileUpload($attachFile, $attachFileName, $saveDir = '.')
{
	$saveDir = preg_replace("/$/", "", $saveDir);
	$saveDir .= '/';
	
	$ext = strrchr($attachFileName, '.');

	$tName = substr($attachFileName, 0, strlen($attachFileName) - strlen($ext));
	$saveFileName = $tName . $ext;
	$i = 0;
	while (file_exists($saveDir . $saveFileName))
	{
		$i++;
		$saveFileName =  $tName . $i . $ext;
	}
	if(!is_dir($saveDir))
	{
		// 파일 저장디렉토리가 존재하지 않으면
		@mkdir($saveDir, 0777);
	}
	move_uploaded_file($attachFile, $saveDir . $saveFileName);
	chmod($saveDir . $saveFileName, 0777);

	$attc["size"] = filesize($saveDir . $saveFileName);	//byte
	$attc["savedName"] = $saveFileName;					// 저장되는 파일 이름
	$attc["upName"] = $attachFileName;					// 업로드시 파일네임
	return $attc;
}


#****************************************************************************
#  Function : isImageExt($fileName)
#  내용     : 이미지 파일인지 확인한다.
#  반환값   : 이미지 파일 : true  일반파일 : false
#****************************************************************************
function isImageExt($fileName)
{
	$imgExt = array("jpg", "jpeg", "gif", "png", "bmp");
	$isImg = false;
	
	$ext = getFileExtension($fileName, true);
	if (in_array($ext, $imgExt))
	{
		$isImg = true;
	}
	return $isImg;
}


#****************************************************************************
#  Function : getFileExtension($fileName, $toLower = false)
#  내용     : 파일의 확장명을 가져온다.
#  반환값   : 파일확장명
#****************************************************************************
function getFileExtension($fileName, $toLower = false)
{
	$ext = strrchr($fileName, '.');
	$ext = substr($ext, 1);
	if ($toLower)
	{
		$ext = strtolower($ext);
	}
	return $ext;
}


#****************************************************************************
#  Function : getImgReSize($fileName,$url,$size,$type=Null,$title=Null)
#  내용     : 이미지 ReSize
#  반환값   : reSize 된 파일 정보
#****************************************************************************
function getImgReSize($fileName,$url,$size,$type=Null,$title=Null)
{
	$reSize = array();
	if(isImageExt($fileName)){

		$fileDir  = preg_replace("/$/", "", $url);
		$fileDir .= '/';		
		$fullName = $fileDir.$fileName ;

		$fileSize = @GetImageSize($fullName);
		$_width   = $fileSize[0] ;
		$_height  = $fileSize[1] ;

		if($type == "wh"){

			if($size < $_width){
				$_ratio1    = getReSizeRatio($_width,$_height,$size,"w") ;

				$re_width1  = round($_width * $_ratio1) ;
				$re_height1 = round($_height * $_ratio1) ;
			}else{
				$re_width1  = $_width ;
				$re_height1 = $_height ;
			}

			if($size < $re_height1){
				$_ratio2    = getReSizeRatio($re_width1,$re_height1,$size,"h") ;

				$re_width  = round($re_width1 * $_ratio2) ;
				$re_height = round($re_height1 * $_ratio2) ;
			}else{
				$re_width  = $re_width1 ;
				$re_height = $re_height1 ;
			}

		}else{

			$_tmpSize = $type == "h" ? $_height : $_width ;

			if($size < $_tmpSize){
				$_ratio    = getReSizeRatio($_width,$_height,$size,$type) ;

				$re_width  = round($_width * $_ratio) ;
				$re_height = round($_height * $_ratio) ;
			}else{
				$re_width  = $_width ;
				$re_height = $_height ;
			}

		}

		$reSize[0] = "<img src='".$fullName."' width='".$re_width."' height='".$re_height."' alt='".$title."' border='0' align='absmiddle' />" ;
		$reSize[1] = $re_width ;
		$reSize[2] = $re_height ;
        $reSize[3] = $fullName ;
	}else{
		$reSize[0] = "<font color='#BEBEBE'>NO IMAGE</font>" ;
		$reSize[1] = 0 ;
		$reSize[2] = 0 ;
        $reSize[3] = "" ;
	}
	return $reSize ;
}


#****************************************************************************
#  Function : getReSizeRatio($_width,$_height,$size,$type=Null)
#  내용     : 축소률을 반환한다
#  반환값   : 파일확장명
#****************************************************************************
function getReSizeRatio($_width,$_height,$size,$type=Null){
	if($type == "w"){
		return round(((1 * $size) / $_width),3) ;
	}else if($type == "h"){
		return round(((1 * $size) / $_height),3) ;
	}else{
		return 1 ;
	}
}


#-----------------------------------

#*********************************************************************************************
#  Function : SendMail($to_mail, $from_mail, $from_name, $subject, $content, $fileupload='')
#  내용     : to_mail : 받는 전자우편주소
#             from_mail : 보내는 전자우편주소
#             from_name : 보내는 사람 이름
#             subject : 제목
#             content : 메일내용
#             fileupload : 파일 첨부시
#  반환값   : 
#**********************************************************************************************
function SendMail($to_mail, $from_mail, $from_name, $subject, $content, $fileupload='')
{
	$date=date("D, d M Y H:i:s +0900");

	$_headers = "Date: $date\r\n";
	$_headers .= "From: $from_name <$from_mail>\r\n";
	$_headers .= "Sender: $from_mail\r\n";
	$_headers .= "Reply-To: $from_mail\r\n";
	$_headers .= "MIME-Version: 1.0\r\n";

	if ($fileupload)
	{
		$filename =basename($fileupload_name); 
		$result = fopen($fileupload,"r"); 
		$file = fread($result,$fileupload_size); 
		fclose($result);
		$temp_file = explode(".",$fileupload_name);
		if ($temp_file[1]=="zip" || $temp_file[1]=="ZIP") $fileupload_type = "application/octet-stream"; 
		if ($fileupload_type == "")
		$fileupload_type = "application/octet-stream";
		$boundary = "--------" . uniqid("part"); 
	}

	if ($filename)
	{
		$_headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
		$message = "--$boundary\r\n";
		$message.= "Content-Type: text/html; charset=euc-kr\r\n";
		$message.= "Content-Transfer-Encoding: 8bit\r\n";
		$message.= "\r\n".$content."\r\n";
		$message.= "--$boundary\r\n"; 
		$message.= "Content-Type: $fileupload_type; name=\"$filename\"\r\n";
		$message.= "Content-Disposition: inline; filename=\"$filename\"\r\n";
		$message.= "Content-Transfer-Encoding: base64\r\n";
		$message.= "X-HM-IDENT: attach\r\n\r\n";
		$tmp_contents = @fread(@fopen($fileupload, 'r'), @filesize($fileupload));

		@unlink($fileupload);

		$message.= chunk_split(base64_encode($tmp_contents));
		$message.= "\r\n";

		$message.= "--$boundary--\r\n"; 
	}
	else
	{
		$_headers .= "Content-Type: text/html; charset=euc-kr\r\n";
		$_headers .= "Content-Transfer-Encoding: 8bit\r\n";
		$message = $content."\r\n";
	}
	mail($to_mail, $subject, $message, $_headers);
}


#****************************************************************************
#  Function : getAuthNumber($num)
#  내용     : 
#  반환값   : 랜덤수 생성
#****************************************************************************
function getAuthNumber($num=0)
{
	$s_num    = "";
	$e_num    = "";
	$rand_num = "" ;

	$num = $num < 1 ? 1 : $num ;

	for($i=1;$i<=$num;$i++){
		$s_num .= "1" ;
		$e_num .= "9" ;
	}

	srand ((double) microtime () * 1000000) ;
	$rand_num = rand($s_num,$e_num) ;

	return $rand_num;
}


#****************************************************************************
#  Function : chk_ban_word($_word)
#  내용     : 
#  반환값   : 금지어 필터링
#****************************************************************************
function chk_ban_word($_word){

	global $db ;
	global $BAN_WORD_TB ;
	
	$_sql = "SELECT * FROM {$BAN_WORD_TB}" ;
	$_res = $db->exec_sql($_sql);
	$_row = $db->sql_fetch_array($_res);

	$_banWord = explode(",",$_row["ban_word"]) ;
	$_size    = sizeof($_banWord);

	for($i=0;$i<=$_size;$i++){
		$_word = str_replace($_banWord[$i],"***",$_word);
	}

	return $_word ;

}


#****************************************************************************
#  Function : get_total_days($_mm,$_yy)
#  내용     : 
#  반환값   : 총 일수
#****************************************************************************
function get_total_days($_mm,$_yy){

	$date = date("t",mktime(0,0,1,$_mm,1,$_yy));
	return $date ;

}


#****************************************************************************
#  Function : is_auth($_mm,$_yy)
#  내용     : 
#  반환값   : 권한에 합당하면 ture, 아니면 false
#****************************************************************************
function is_auth($_obj1, $_obj2){

	$_bool = false ;

	if(is_array($_obj1) && is_array($_obj2)){

		$_objNum = sizeof($_obj1) ;

		for($_i=0;$_i<$_objNum;$_i++){
			if(in_array($_obj1[$_i],$_obj2)){
				$_bool = true ;
			}
		}

	}

	return $_bool ;

}




/*******************************************************************************
* session_register
* FOR PHP < 5.3.0
*******************************************************************************/
if(!function_exists('session_register'))
{
	// var_dump($_SESSION);

	foreach($_SESSION as $sKey => $sVal)
	{
		if(!isset(${$sKey}))
		{
			${$sKey} = $sVal;
		}
	}

	function session_register($key)
	{
		$_SESSION[$key] = $GLOBALS[$key];
	}
}





#****************************************************************************
#  Function : getExpertStudioInformation($_idx)
#  내용     : 
#  반환값   : 전문가 홈 정보
#****************************************************************************
function getExpertStudioInformation($_idx){

	global $db ;
	global $MEMBER_TB ;
	global $STUDIO_TB ;
	global $REVIEW_TB ;
	global $PF_TB ;
	global $L_TYPE_TB ;
	global $M_TYPE_TB ;


	// 기본정보
	$_sql = "SELECT t1.*, t2.* FROM {$MEMBER_TB} t1 LEFT JOIN {$STUDIO_TB} t2 ON (t1.mm_email=t2.user_id) WHERE t1.idx='{$_idx}' AND t1.mm_type='2'" ;
	$_res = $db->exec_sql($_sql);
	$_row = $db->sql_fetch_array($_res);


	// 후기카운터
	$_sql1 = "SELECT COUNT(t1.idx) FROM {$REVIEW_TB} t1 WHERE t1.expert_idx='{$_idx}' AND t1.view_yn in ('y')" ;
	$_res1 = $db->exec_sql($_sql1);
	$_row1 = $db->sql_fetch_row($_res1);

	// 후기 별총점
	$_sql2 = "SELECT SUM(t1.star_point) FROM {$REVIEW_TB} t1 WHERE t1.expert_idx='{$_idx}' AND t1.view_yn in ('y')" ;
	$_res2 = $db->exec_sql($_sql2);
	$_row2 = $db->sql_fetch_row($_res2);

	if($_row1[0] > 0){

		// 후기 만점
		$_100 =  $_row1[0] * 5 ;

		$_after_star =  round($_row2[0]/$_row1[0]) ;
		$_after_point = round((100 * $_row2[0]) / $_100) ;

		$_obj["r_star"]  = $_after_star ;
		$_obj["r_point"] = $_after_point ;

	}else{

		$_obj["r_star"]  = 0 ;
		$_obj["r_point"] = 0 ;
	}


	// 포트폴리오 등록 분야 확인 최대 3개

	$_sql3 = "SELECT large_idx, middle_idx FROM {$PF_TB} WHERE expert_id='".$_row["mm_email"]."' GROUP BY middle_idx" ;
	$_res3 = $db->exec_sql($_sql3);
	$_lmt = 1;

	while($_row3 = $db->sql_fetch_array($_res3)){
		if($_lmt > 5){
			break;
		}

		$_large_sql = "SELECT l1.large_name FROM {$L_TYPE_TB} l1 WHERE l1.idx='".$_row3['large_idx']."'" ;
		$_large_res = $db->exec_sql($_large_sql);
		$_large_row = $db->sql_fetch_array($_large_res);
		
		$_middle_sql = "SELECT m1.middle_name FROM {$M_TYPE_TB} m1 WHERE m1.idx='".$_row3['middle_idx']."'" ;
		$_middle_res = $db->exec_sql($_middle_sql);
		$_middle_row = $db->sql_fetch_array($_middle_res);

		$_obj["type_".$_lmt] = $_large_row["large_name"].">".$_middle_row["middle_name"] ;

		$_lmt++;
	}

	$_obj["e_status"] = $_row["mm_status"] ;
	$_obj["e_id"]     = $_row["mm_email"] ;
	$_obj["e_name"]   = $_row["mm_name"] ;
	$_obj["e_phone"]  = $_row["mm_phone"] ;
	
	$_obj["s_name"]      = $_row["studio_name"] ;
	$_obj["s_introduce"] = $_row["studio_introduce"] ;
	$_obj["s_sido"]      = $_row["sido_code"] ;
	$_obj["s_gugun"]     = $_row["gugun_code"] ;
	$_obj["s_addr"]      = $_row["studio_addr"] ;
	$_obj["s_main_img"]  = $_row["main_img"] ;
	$_obj["s_img_1"]     = $_row["sub_img_1"] ;
	$_obj["s_img_2"]     = $_row["sub_img_2"] ;
	$_obj["s_img_3"]     = $_row["sub_img_3"] ;
	$_obj["open_yn"]     = $_row["last_date"] ;
	

	return $_obj ;

}

?>