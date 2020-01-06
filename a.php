<?php
$ch = curl_init();
$url = 'http://apis.data.go.kr/B551182/msupCmpnMeftInfoService/getMajorCmpnNmCdList'; /*URL*/
$queryParams = '?' . urlencode('ServiceKey') . '=A9lVTk8Qv60WwcDbP%2FZQGgVta2l3vJPqg1adProicrKh3VnchZ3lCJDRzokpT0QbnrLkt4Dooa3orjeqgiztxw%3D%3D'; /*Service Key*/
$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('100');
$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1');
$queryParams .= '&' . urlencode('gnlNmCd') . '='  . urlencode('600600BIJ');
//$queryParams .= '&' . urlencode('gnlNm') . '='  . urlencode('600600BIJ');
//$queryParams .= '&' . urlencode('meftDivNo') . '='  . urlencode('421');
//$queryParams .= '&' . urlencode('divNm') . '='  . urlencode('항악성');

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);



$xml = simplexml_load_string($response);
$totalnum = (int)$xml->body->totalCount;

echo $totalnum;
echo "<br><br><br><br>";

//print_r($xml->body->items);

foreach ($xml->body->items->item as $obj) {
    print_r($obj);
    echo "<br><Br>=============<br><br>";
}