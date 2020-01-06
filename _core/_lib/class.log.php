<?
/******************************************************************************
 *
 * 파일명        : class.log.php
 * 최초작성일    : 2009-01-01
 * 비고          : 
 *
 * = method list =
 *
 *  1)db       
 *  2)Open     
 *  3)num_rows    
 *
 *****************************************************************************/

class site_log
{
	var $_fp       = null;
	var $_fileName = "" ;
	var $_msg      = "" ;
	var $_url      = "" ;

	//
	// 생성자
	//
	function site_log($file_url,$type,$writer,$msg) 
	{

		switch($type){
			case("admin"):
				$this->_fileName = "admin_log_".date("Ymd").".log";
			break;

			case("point"):
				$this->_fileName = "point_log_".date("Ymd").".log";
			break;

			case("member"):
				$this->_fileName = "member_log_".date("Ymd").".log";
			break;
		}

		$this->_url    = $file_url."/".$type."/".$this->_fileName ;
		$this->_msg    = date("Y년 m월 d일 H시 i분 s초 ")." :: 작성자 정보 [ ".$writer." ] \n".$msg."\n\n";
		
	}

	function write_process()
	{
		$this->file_open();
		$this->file_write();
		$this->file_close();
	}

	function file_open()
	{
		$this->_fp = fopen($this->_url,"a+") ;
	}

	function file_write()
	{
		fwrite($this->_fp,$this->_msg) ;
	}

	function file_close()
	{
		fclose($this->_fp) ;
	}
	
}
?>