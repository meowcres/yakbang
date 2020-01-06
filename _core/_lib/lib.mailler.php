<?
// 메일 보내기 (파일 여러개 첨부 가능)
// type : text=0, html=1, text+html=2
function mailer($fname, $fmail, $to, $subject, $content, $type=0, $file="", $cc="", $bcc=""){

	$_charset = "UTF-8" ;
	$fname    = "=?".$_charset."?B?" . base64_encode($fname) . "?=";
	$subject  = "=?".$_charset."?B?" . base64_encode($subject) . "?=";

	$fmail = "istans@kiet.re.kr";

	$header   = "Return-Path: <$fmail>\n";
	$header  .= "From: $fname <$fmail>\n";
	$header  .= "Reply-To: <$fmail>\n";

	if ($cc)  $header .= "Cc: $cc\n";

	if ($bcc) $header .= "Bcc: $bcc\n";

	$header .= "MIME-Version: 1.0\n";
	//$header .= "X-Mailer: SIR Mailer 0.91 (sir.co.kr) : $_SERVER[SERVER_ADDR] : $_SERVER[REMOTE_ADDR] : $g4[url] : $_SERVER[PHP_SELF] : $_SERVER[HTTP_REFERER] \n";
	// UTF-8 관련 수정
	$header .= "X-Mailer: SIR Mailer 0.92 (sir.co.kr) : $_SERVER[SERVER_ADDR] : $_SERVER[REMOTE_ADDR] : '' : $_SERVER[PHP_SELF] : $_SERVER[HTTP_REFERER] \n";
	
	if ($file != "") {
		$boundary = uniqid("http://sir.co.kr/");
		$header  .= "Content-type: MULTIPART/MIXED; BOUNDARY=\"$boundary\"\n\n";
		$header .= "--$boundary\n";
	}
	
	if ($type) {
		$header .= "Content-Type: TEXT/HTML; charset=$_charset\n";
		if ($type == 2) {
			$content = nl2br($content);
		} else {
			$header .= "Content-Type: TEXT/PLAIN; charset=$_charset\n";
			$content = stripslashes($content);
		}
		$header .= "Content-Transfer-Encoding: BASE64\n\n";
		$header .= chunk_split(base64_encode($content)) . "\n";
		
		if ($file != "") {
			foreach ($file as $f) {
				$header .= "\n--$boundary\n";
				$header .= "Content-Type: APPLICATION/OCTET-STREAM; name=\"$f[name]\"\n";
				$header .= "Content-Transfer-Encoding: BASE64\n";
				$header .= "Content-Disposition: inline; filename=\"$f[name]\"\n";
				
				$header .= "\n";
				$header .= chunk_split(base64_encode($f[data]));
				$header .= "\n";
			}
			$header .= "--$boundary--\n";
		}
		
		@mail($to, $subject, "", $header);

	}

}

// 파일 첨부시
/*
$fp = fopen(__FILE__, "r");
$file[] = array(
    "name"=>basename(__FILE__),
    "data"=>fread($fp, filesize(__FILE__)));
fclose($fp);
*/

// 파일을 첨부함
function attach_file($filename, $file)
{
	$fp = fopen($file, "r");
	$tmpfile = array(
								"name" => $filename,
								"data" => fread($fp, filesize($file)));
	fclose($fp);
	return $tmpfile;
}
?>