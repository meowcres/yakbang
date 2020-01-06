<?
$_file_obj  = "../kisec_doc/member_sample.csv" ;
$_real_name = "member_sample.csv" ;


if(file_exists($_file_obj)) {

	//IE인가 HTTP_USER_AGENT로 확인
	$ie= isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false;

	//IE인경우 한글파일명이 깨지는 경우를 방지하기 위한 코드
	if( $ie ){
		$_real_name = iconv('utf-8', 'euc-kr', $_real_name);
//        $_real_name = iconv('euc-kr', 'utf-8', $_real_name);
	}

	$_real_name = iconv('utf-8', 'euc-kr', $_real_name);
    
	header('Content-Type: doesn/matter');
	header('Content-Length: '. filesize($_file_obj));
	header('Content-Disposition: attachment; filename="'.$_real_name.'"');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');

	// IE를 위한 헤더 적용
	if( $ie ){
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Pragma: no-cache');
	}


	if(is_file($_file_obj)) {
		$fp = fopen($_file_obj, "r");

		if(!fpassthru($fp)) {
			fclose($fp);
		}
	}
	
} else {
	echo "<Script> alert('첨부파일이 존재하지 않습니다.');</Script>";
	exit;
}
?>