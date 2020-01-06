<?php
include_once "../_core/_init.php";

/** PHPExcel */
require_once("../PHPExcel/Classes/PHPExcel.php"); 
require_once("../PHPExcel/Classes/PHPExcel/IOFactory.php");
$filename = './07.xlsx';
exit;

try {
  
  // 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
  $objReader = PHPExcel_IOFactory::createReaderForFile($filename);
  
  // 읽기전용으로 설정
  $objReader->setReadDataOnly(true);
  
  // 엑셀파일을 읽는다
  $objExcel = $objReader->load($filename);
  
  // 첫번째 시트를 선택
  $objExcel->setActiveSheetIndex(0);  
  $objWorksheet = $objExcel->getActiveSheet();
  $rowIterator = $objWorksheet->getRowIterator();
  
  foreach ($rowIterator as $row) { // 모든 행에 대해서
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(false); 
  }
  
  $maxRow = $objWorksheet->getHighestRow();

  $_i=0;

  for ($no = 2 ; $no <= 5000 ; $no++) {

    //echo $no ;
    //echo "===<br>";

    $A = $objWorksheet->getCell('A' . $no)->getValue(); // 
    $B = $objWorksheet->getCell('B' . $no)->getValue(); // 
    $C = $objWorksheet->getCell('C' . $no)->getValue(); // 
    $D = $objWorksheet->getCell('D' . $no)->getValue(); // 
    $E = $objWorksheet->getCell('E' . $no)->getValue(); // 
    $F = $objWorksheet->getCell('F' . $no)->getValue(); // 
    $G = $objWorksheet->getCell('G' . $no)->getValue(); // 
    $H = $objWorksheet->getCell('H' . $no)->getValue(); // 
    $I = $objWorksheet->getCell('I' . $no)->getValue(); // 
    $J = $objWorksheet->getCell('J' . $no)->getValue(); // 
    $K = $objWorksheet->getCell('K' . $no)->getValue(); // 
    $L = $objWorksheet->getCell('L' . $no)->getValue(); // 
    $M = $objWorksheet->getCell('M' . $no)->getValue(); // 
    $N = $objWorksheet->getCell('N' . $no)->getValue(); // 
    $O = $objWorksheet->getCell('O' . $no)->getValue(); // 
    $P = $objWorksheet->getCell('P' . $no)->getValue(); // 
    $Q = $objWorksheet->getCell('Q' . $no)->getValue(); // 
    $R = $objWorksheet->getCell('R' . $no)->getValue(); // 
    $S = $objWorksheet->getCell('S' . $no)->getValue(); // 
    $T = $objWorksheet->getCell('T' . $no)->getValue(); // 
    $U = $objWorksheet->getCell('U' . $no)->getValue(); // 
    $V = $objWorksheet->getCell('V' . $no)->getValue(); // 
    $W = $objWorksheet->getCell('W' . $no)->getValue(); // 
    $X = $objWorksheet->getCell('X' . $no)->getValue(); // 


    $_sql  = "  INSERT INTO EY_PILL SET ";
    $_sql .= "  PILL_IDX                = '{$A}' ";
    $_sql .= ", PILL_NAME               = '".addslashes($B)."' ";
    $_sql .= ", PILL_COMPANY            = '".addslashes($C)."' ";    
    $_sql .= ", PILL_ACCEPT_DATE        = '".addslashes($D)."' ";
    $_sql .= ", PILL_CLASS              = '".addslashes($E)."' ";
    $_sql .= ", PILL_ACCEPT_NUMBER      = '".addslashes($F)."' ";
    $_sql .= ", PILL_ACCEPT_STATUS      = '".addslashes($G)."' ";
    $_sql .= ", PILL_ACCEPT_STATUS_DATE = '".addslashes($H)."' ";
    $_sql .= ", PILL_COMPONENT          = '".addslashes($I)."' ";
    $_sql .= ", PILL_ADDITIVE           = '".addslashes($J)."' ";
    $_sql .= ", PILL_CATEGORY           = '".addslashes($K)."' ";
    $_sql .= ", PILL_SPECIALLY_WEATHER  = '".addslashes($L)."' ";
    $_sql .= ", PILL_MATERIAL           = '".addslashes($M)."' ";
    $_sql .= ", PILL_ACCEPT_METHOD      = '".addslashes($N)."' ";
    $_sql .= ", PILL_SALES_METHOD       = '".addslashes($O)."' ";
    $_sql .= ", DRUG_CHECK_WEATHER      = '".addslashes($P)."' ";
    $_sql .= ", PILL_SHAPE              = '".addslashes($Q)."' ";
    $_sql .= ", PILL_COLOR              = '".addslashes($R)."' ";
    $_sql .= ", PILL_HOOF_SHAPE         = '".addslashes($S)."' ";
    $_sql .= ", PILL_MAJOR_AXIS         = '".addslashes($T)."' ";
    $_sql .= ", PILL_MINOR_AXIS         = '".addslashes($U)."' ";
    $_sql .= ", PILL_NEW_TYPE           = '".addslashes($V)."' ";
    $_sql .= ", PILL_STANDARD_CODE      = '".addslashes($W)."' ";
    $_sql .= ", PILL_ATC_CODE           = '".addslashes($X)."' ";

    if (!isNull($A)) {

      if($res = $db->exec_sql($_sql)){
        

      } else {
        echo $_sql;
        echo "<br><br><br><br><br>";
        $_i++;


      }

    }
      

 }



 echo $_i." 오류발생";







} 
catch (exception $e) {
  echo '엑셀파일을 읽는도중 오류가 발생하였습니다.';
}
