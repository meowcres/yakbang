/**
* js_common.js
**/

/**
*  @brief null 값을 확인 한다
*  @param 
*  @return 
**/
function isNull(obj){
	return (typeof obj != "underfined" && obj!= null && obj != "") ? false : true ;
}


/**
*  @brief null 값을 확인 한다
*  @param 
*  @return 
**/

 /******************************************************************************
 * 함수명    : comma
 * 함수내용  : 3자리수마다 콤마를 찍는다
 * 반환값    : 
 * 사용법    : 
 *****************************************************************************/

 function stripslashes (str) {
  //       discuss at: http://locutus.io/php/stripslashes/
  //      original by: Kevin van Zonneveld (http://kvz.io)
  //      improved by: Ates Goral (http://magnetiq.com)
  //      improved by: marrtins
  //      improved by: rezna
  //         fixed by: Mick@el
  //      bugfixed by: onno Marsman (https://twitter.com/onnomarsman)
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //         input by: Rick Waldron
  //         input by: Brant Messenger (http://www.brantmessenger.com/)
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  //        example 1: stripslashes('Kevin\'s code')
  //        returns 1: "Kevin's code"
  //        example 2: stripslashes('Kevin\\\'s code')
  //        returns 2: "Kevin\'s code"

  return (str + '')
	.replace(/\\(.?)/g, function (s, n1) {
	  switch (n1) {
		case '\\':
		  return '\\'
		case '0':
		  return '\u0000'
		case '':
		  return ''
		default:
		  return n1
	  }
		})
}


function comma(str) {
	str = String(str);
	return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}


function uncomma(str) {
	str = String(str);
	return str.replace(/[^\d]+/g, '');
}


function inputNumberFormat(obj) {
	obj.value = comma(uncomma(obj.value));
}


/******************************************************************************
 * 함수명    : isNumber
 * 함수내용  : 문자열이 숫자 여부를 체크한다.
 * 반환값    : 숫자 이외의 것이면 false
 *****************************************************************************/
function isNumber(name) 
{
	var ch = "\0";
	var flag = true;

	for (var i = 0, ch=name.charAt(i); (i <name.length) && (flag); ch = name.charAt(++i))
	{
		if ((ch >= '0') && (ch <= '9'))	flag = true;
		else														flag = false;
	}
	
	return flag;
}


/******************************************************************************
 * 함수명    : isAlphaNum
 * 함수내용  : 문자열이 영문 또는 숫자 여부를 체크한다.
 * 반환값    : 영문,숫자 이외의 것이면 false
 ******************************************************************************/
function isAlphaNum(name)
{
	var ch = "\0";
	var flag = true;

	for (var i = 0, ch = name.charAt(i); (i <name.length) && (flag); ch = name.charAt(++i)) 
	{
		if ((ch >= '0') && (ch <= '9'))				flag = true;
		else if ((ch >= 'a') && (ch <= 'z'))	flag = true;
		else if ((ch >= 'A') && (ch <= 'Z'))	flag = true;
		else if (ch >= '_')										flag = true;
		else																	flag = false;
	}
	return (flag);
}


/******************************************************************************
 * 함수명    : isKorean
 * 함수내용  : 문자열이 한글 여부를 체크한다.
 * 반환값    : 한글 이외의 것이면 false
 *****************************************************************************/
function isKorean(name) 
{
	var ch = "\0";
	var flag = true;

	for (var i = 0, ch = name.charAt(i);(i <name.length) && (flag); ch = name.charAt(++i))
	{
		if ((ch >= '0') && (ch <= '9'))					flag = false;
		else if ((ch >= 'a') && (ch <= 'z'))		flag = false;
		else if ((ch >= 'A') && (ch <= 'Z'))		flag = false;
		else if ( ch == ' ' || ch == '~' || ch == '`' || ch == '\\'||
							ch == '-' || ch == '_' || ch == '|' || ch == '+' ||
							ch == '=' || ch == ',' || ch == '.' || ch == '/' ||
							ch == '<' || ch == '>' || ch == '?' || ch == '!' ||
							ch == '@' || ch == '#' || ch == '$' || ch == '%' || 
							ch == '^' || ch == '&' || ch == '*' || ch == '(' || 
							ch == ')' || ch == '\"' || ch == '[' || ch == '(' )
			flag = false;
	}

	return (flag);
}


/******************************************************************************
 * 함수명    : getByteLength
 * 함수내용  : 문자열의 바이트 길이를 구한다.
 * 반환값    : byte Length
 ******************************************************************************/
function getByteLength(strValue)
{
	var byteLength = 0;

	for (inx = 0; inx < strValue.length; inx++)
	{
		var oneChar = escape(strValue.charAt(inx));

		if ( oneChar.length == 1 ) 
		{
			byteLength ++;
		}
		else if (oneChar.indexOf("%u") != -1)
		{
			byteLength += 2;
		}
		else if (oneChar.indexOf("%") != -1) 
		{
			byteLength += oneChar.length/3;
		}
	}
	
	return byteLength;
}


/******************************************************************************
 * 함수명    : isSpaces
 * 함수내용  : 문자열 내의 space를 체크한다.
 * 반환값    : space가 있으면 false
 *****************************************************************************/
function isSpaces(strValue) 
{
	for (i = 0; i < strValue.length; i++)
	{
		if (strValue.charAt(i) != " ") 
		{
			return false;
		}
	}

	return true;
}


/*****************************************************************************
 * 함수명    : isCheckTextArea
 * 함수내용  : TextArea로 된 문자열에서 EnterKey 또는 Spcae를 체크한다.
 * 반환값    : EnterKey 값이 없고, Spcae 값도 없으면 true
 *****************************************************************************/
function isCheckTextArea(strValue)
{
	var cnt = 0;

	for (var i = 0; i < strValue.length; i++)
	{
		if (strValue.charCodeAt(i) != 13 && strValue.charCodeAt(i) != 32 )
		{
			return true;
		}

		if ( strValue.charCodeAt(i) == 13 ) 
		{
			i++;
		}
	}

	return false;
}


/******************************************************************************
 * 함수명    : trim
 * 함수내용  : 좌우가운데 모두 스페이스 제거
 * 반환값    : String
 *****************************************************************************/
function trim(parm_str)
{
	return rtrim(ltrim(parm_str));
}


/******************************************************************************
 * 함수명    : ltrim
 * 함수내용  : 좌측 스페이스 제거
 * 반환값    : String
 *****************************************************************************/
function ltrim(parm_str)
{
	var str_temp = parm_str;

	while (str_temp.length != 0) {
		if (str_temp.substring(0, 1) == " ") {
			str_temp = str_temp.substring(1, str_temp.length) ;
		}
		else
		{
			return str_temp ;
		}
	}
	
	return str_temp ;
}


/******************************************************************************
 * 함수명    : rtrim
 * 함수내용    : 우측 스페이스 제거
 * 반환값    : String
 *****************************************************************************/
function rtrim(parm_str)
{
	var str_temp = parm_str ;

	while (str_temp.length != 0) {
		int_last_blnk_pos = str_temp.lastIndexOf(" ");
		
		if ((str_temp.length - 1) == int_last_blnk_pos) {
			str_temp = str_temp.substring(0, str_temp.length - 1);
		}
		else
		{
			return str_temp;
		}
	}

	return str_temp;
}


/******************************************************************************
 * 함수명    : passTab(f1,f2,num)
 * 함수내용  : num 길이가 되었을때 자동으로 f2로 이동
 * 반환값    : 길이가 num 이면 지정필드로 자동 이동
 *****************************************************************************/
function passTab(f1,f2,num)
{
	var field = document.getElementById(f1).value;

	if(field.length == parseInt(num))
	{
		document.getElementById(f2).focus();
	}
}


/******************************************************************************
 * 함수명    : openWin
 * 함수내용  : 새로운 Window를 open 
 * 반환값    : 새창 출력
 * 사용법    : openWin('파일경로','팝업ID','가로사이즈','세로사이즈','옵션')
 *****************************************************************************/
function openWin(mypage, myname, w, h, opt) 
{
	var winl = ((screen.width  - w) / 2) - 100 ;
	var wint = ((screen.height - h) / 2) - 80 ;
	
	winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl ;
	winprops = opt ? winprops + ", "+ opt : winprops ;

	win = window.open(mypage, myname, winprops) ;
	win.window.focus();
}


/******************************************************************************
 * 함수명    : chkBizNumber
 * 함수내용  : 사업자등록번호를 체크 한다
 * 반환값    : 사업자등록번호가 아닐 경우 false
 *****************************************************************************/
function chkBizNumber(num1, num2, num3)
{
	biz_value = new Array(10);

	if (isBizInteger(num1,3) == false) 
	{
		return false;
	}

	if (isBizInteger(num2,2) == false) 
	{
		return false;
	}

	if (isBizInteger(num3,5) == false) {
		return false;
	}

	var numString = num1 +"-"+ num2 +"-"+ num3;
	var li_temp, li_lastid;

	if ( numString.length == 12 ) {
		biz_value[0] = ( parseFloat(numString.substring(0 ,1)) * 1 ) % 10;
		biz_value[1] = ( parseFloat(numString.substring(1 ,2)) * 3 ) % 10;
		biz_value[2] = ( parseFloat(numString.substring(2 ,3)) * 7 ) % 10;
		biz_value[3] = ( parseFloat(numString.substring(4 ,5)) * 1 ) % 10;
		biz_value[4] = ( parseFloat(numString.substring(5 ,6)) * 3 ) % 10;
		biz_value[5] = ( parseFloat(numString.substring(7 ,8)) * 7 ) % 10;
		biz_value[6] = ( parseFloat(numString.substring(8 ,9)) * 1 ) % 10;
		biz_value[7] = ( parseFloat(numString.substring(9,10)) * 3 ) % 10;

		li_temp = parseFloat(numString.substring(10,11)) * 5 + "0";

		biz_value[8] = parseFloat(li_temp.substring(0,1)) + parseFloat(li_temp.substring(1,2));
		biz_value[9] = parseFloat(numString.substring(11,12));

		li_lastid = (10 - ( ( biz_value[0] + biz_value[1] + biz_value[2] + biz_value[3] + biz_value[4] + biz_value[5] + biz_value[6] + biz_value[7] + biz_value[8] ) % 10 ) ) % 10;

		if (biz_value[9] != li_lastid) 
		{
			return false;
		} 
		else 
		{
			return true;
		}
	} 
	else 
	{
		return false;
	}
}


/******************************************************************************
 * 함수명    : isBizInteger
 * 함수내용  : 각 순번의 사업자등록번호 길이를 체크한다
 * 반환값    : 길이가 다를 경우 false
 *****************************************************************************/
function isBizInteger(st,maxLength)
{
	if (st.length == maxLength) 
	{
		for (j=0;j<maxLength;j++) 
		{
			if (((st.substring(j, j+1) < "0") || (st.substring(j, j+1) > "9")))
				return false;
		}
	}
	else
	{
		return false;
	}

	return true;
}


/******************************************************************************
 * 함수명    : chkForm / chkPatten / chkText / chkCheckbox / 
 *             chkCheckbox / chkRadio / getLength / chkLength
 * 함수내용  : 폼값을 형식에 따라 체크한다
 * 반환값    : 해당 조건과 다를 경우 false, hname 값을 출력한다.
 * 사용법    : 각 필드 마다 required 의 키워드를 검색하여 조건을 구분
 *****************************************************************************/
function chkForm(f)
{
	var i,currEl;
	for(i = 0; i < f.elements.length; i++)
	{
		currEl = f.elements[i];
		if (currEl.getAttribute("required") != null || currEl.getAttribute("required") == 1)
		{
			if(currEl.type.toUpperCase() == "TEXT" || currEl.tagName.toUpperCase() == "SELECT" || currEl.tagName.toUpperCase() == "TEXTAREA" ||currEl.type.toUpperCase() == "PASSWORD" ||currEl.type.toUpperCase() == "FILE" ||currEl.type.toUpperCase() == "HIDDEN")
			{
				if(!chkText(currEl,currEl.getAttribute("hname"))) return false;
			}
			else if(currEl.type.toUpperCase() == "CHECKBOX")
			{
				if(!chkCheckbox(f, currEl,currEl.getAttribute("hname"))) return false;
			}
			else if(currEl.type.toUpperCase() == "RADIO")
			{
				if(!chkRadio(f, currEl,currEl.getAttribute("hname"))) return false;
			}
		}
		if(currEl.getAttribute("option") != null && currEl.value.length > 0)
		{
			if(!chkPatten(currEl,currEl.getAttribute("option"),currEl.getAttribute("hname"))) return false;
		}
		if(currEl.getAttribute("lengthchk") != null && currEl.value.length > 0)
		{
			if(!chkLength(currEl,currEl.getAttribute("lengthchk"),currEl.getAttribute("hname"))) return false;
		}
	}
	return true;
}

function chkPatten(field,patten,name)
{
	var regNum =/^[0-9]+$/;
	var regPhone =/^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$/;
	var regPhone2 =/^[0-9]{2,3}[-]{0,1}[0-9]{3,4}[-]{0,1}[0-9]{4}$/;
	var regMobilePhone = /01[16789]-[0-9]{3,4}-[0-9]{4}/;
	var regMail =/^[_a-zA-Z0-9-]+@[._a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	var regDomain =/^[.a-zA-Z가-힣0-9-]+.[a-zA-Z]+$/;
	var regAlpha =/^[a-zA-Z]+$/;
	var regHost =/^[a-zA-Z-]+$/;
	//-- 한글체크
	var regHangul =/[가-힣]/;
	//-- 한영체크
	var regHangulEng =/[가-힣a-zA-Z]/;
	//-- 한글체크
	var regHangulOnly =/^[가-힣]*$/;
	//-- 아이디체크   영문으로 시작 숫자결합 4자 ~ 16자(대,소문자,숫자)
	var regId = /^[a-zA-Z]{1}[a-zA-Z0-9_-]{2,9}$/;
	//-- 비밀번호체크 영문소문자와 숫자결합 4자 ~ 16자(소문자,숫자)
	var regPass = /^[a-zA-Z0-9]{1}[a-zA-Z0-9_-]{2,9}$/;
	//-- 날짜체크 2003-06-12
	var regDate =/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
	var regAlphaNum =/[a-zA-Z0-9]/;
	patten = eval(patten);
	if(!patten.test(field.value))
	{
		alert(name + "\n\n항목의 형식이 올바르지 않습니다!");
		field.focus();
		return false;
	}
	return true;
}

function chkText(field, name)
{
	if(field.value.length < 1)
	{
		alert(name);
		if(field.type.toUpperCase() != "HIDDEN") field.focus();
		return false;
	}
	return true;
}

function chkCheckbox(form, field, name)
{
	fieldname = eval(form.name+'.'+field.name);
	if (!fieldname.checked)
	{
		alert(name);
		field.focus();
		return false;
	}
	return true;
}

function chkRadio(form, field, name)
{
	fieldname = eval(form.name+'.'+field.name);
	for (i=0;i<fieldname.length;i++)
	{
		if (fieldname[i].checked) return true; 
	}
	alert(name);
	field.focus();
	return false;
}

function getLength(str)
{
	return (str.length + (escape(str) + "/%u").match(/%u/g).length-1);
}

function chkLength(field,length,name)
{
	if(getLength(field.value) > length)
	{
		alert(name + "\n\n영문,숫자 "+length+"자 , 한글 "+(length/2)+"자 이하로 입력을 제한합니다!"); 
		field.focus();
		return false;
	}
	return true;
}


/******************************************************************************
 * 함수명    : goLink
 * 함수내용  : 페이지를 이동시킨다
 * 반환값    : 없음
 *****************************************************************************/
function goLink(url,step)
{
	var pageGo = step ? eval(step + ".location") : eval("location") ;
	pageGo.href = url ;
}


/******************************************************************************
 * 함수명    : wordCounter(field, countfield, maxlimit)
 * 함수내용  : 단어의 갯수를 확인하여 제한을 넘기지 않도록 확인
 * 반환값    : 
 ******************************************************************************/
function wordCounter(field, countfield, maxlimit) {
	wordcounter=0;
	for (x=0;x<field.value.length;x++) {
		if (field.value.charAt(x) == " " && field.value.charAt(x-1) != " ")  {wordcounter++}  // Counts the spaces while ignoring double spaces, usually one in between each word.
		if (wordcounter > 250) {field.value = field.value.substring(0, x);}
		else {countfield.value = maxlimit - wordcounter;}
	}
}


/******************************************************************************
 * 함수명    : textCounter(field, countfield, maxlimit)
 * 함수내용  : 문자의 갯수를 확인하여 제한을 넘기지 않도록 확인
 * 반환값    : 
 ******************************************************************************/
function textCounter(field, countfield, maxlimit) {

	if (document.getElementById(field).value.length > maxlimit){
		alert("내용은 "+ maxlimit +" 자까지 가능합니다.");
		document.getElementById(field).value = document.getElementById(field).value.substring(0, maxlimit);
	}

	document.getElementById(countfield).innerHTML = maxlimit - document.getElementById(field).value.length;

}


/******************************************************************************
 * 함수명    : showLayer(tp,idx,step,ref,opt,aEvent,w)
 * 함수내용  : 레이어를 활성화 시키는 함수
 * 반환값    :
 * 사용법    : 
 *****************************************************************************/
function showLayer(tp,idx,step,ref,opt,aEvent,w){

	var pageGo = step ? eval(step + ".document") : eval("document") ;
	var ifrm   = "ifrm_"+ idx ;
	var x, y ;
	w = w ? w : 0 ;

	switch(tp){
		case("1"):	// 중간 위치에 출력
			y = (screen.height - 768) / 2;
			x = (screen.width  - w) / 2;

			x = x + "px" ;
			y = y + "px" ;
		break;

		case("2"):	// 마우스 위치에 출력 ( 마우스 왼쪽으로 배치 )
			x = window.event ? window.event.clientX + document.body.scrollLeft : aEvent.pageX;
			y = window.event ? window.event.clientY + document.body.scrollTop : aEvent.pageY;

			x = x - w - (w * 0.2) ;
			y = y - 100 ;

			x = x + "px" ;
			y = y + "px" ;
		break;

		case("3"):	// 마우스 위치에 출력 ( 마우스 오른쪽으로 배치 )
			x = window.event ? window.event.clientX + document.body.scrollLeft : aEvent.pageX;
			y = window.event ? window.event.clientY + document.body.scrollTop : aEvent.pageY;

			x = x - (w * 0.2) ;
			y = y - 100 ;

			x = x + "px" ;
			y = y + "px" ;
		break;

		case("4"):	// 고정위치 출력
			x = 100 + "px" ;
			y = 100 + "px" ;
		break;

		case("5"):	// 중간 위치에 출력
			y = ((screen.height - 768) / 2) + 200;
			x = (screen.width  - w) / 2;

			x = x + "px" ;
			y = y + "px" ;
		break;

		case("6"):	// 마우스 위치에 출력 ( 마우스 오른쪽으로 배치 )
			x = window.event ? window.event.clientX + document.body.scrollLeft : aEvent.pageX;
			y = window.event ? window.event.clientY + document.body.scrollTop : aEvent.pageY;

			x = x - (w * 0.2) ;
			y = y - 200 ;

			x = x + "px" ;
			y = y + "px" ;
		break;

		case("7"):	// 마우스 위치에 출력 ( 마우스 오른쪽으로 배치 )
			x = window.event ? window.event.clientX + document.body.scrollLeft : aEvent.pageX;
			y = window.event ? window.event.clientY + document.body.scrollTop : aEvent.pageY;

			x = x - w - 70 ;
			y = y - 200 ;

			x = x + "px" ;
			y = y + "px" ;
		break;
	
		case("8"):	// 마우스 위치에 출력
			x = window.event ? window.event.clientX + document.body.scrollLeft : aEvent.pageX;
			y = window.event ? window.event.clientY + document.body.scrollTop : aEvent.pageY;

			x = x - (w * 0.5) ;
			y = y - 50 ;

			x = x + "px" ;
			y = y + "px" ;
		break;
		
		
		default:		// 기본위치 출력
			x = "0px" ;
			y = "0px" ;
	
	}

	pageGo.getElementById(idx).style.top     = y ;
	pageGo.getElementById(idx).style.left    = x ;
	pageGo.getElementById(ifrm).style.width  = w ;
	pageGo.getElementById(idx).style.display = "block" ;

	if(ref != ""){
		pageGo.getElementById(ifrm).src = ref + opt ;
	}
	
}


/******************************************************************************
 * 함수명    : closeLayer(idx,step)
 * 함수내용  : 활성화 된 레이어를 닫는다
 * 반환값    :
 * 사용법    : 
 *****************************************************************************/
function closeLayer(idx,step){

	var pageGo = step ? eval(step + ".document") : eval("document") ;
	pageGo.getElementById(idx).style.display = "none" ;
	
}


/******************************************************************************
 * 함수명    : allCheckbox(f,btn)
 * 함수내용  : 
 * 반환값    :
 * 사용법    : 
 *****************************************************************************/
function allCheckbox(f,btn){

	var _btn_obj  = eval(document.getElementById(btn));
	var _list_obj = eval(f);
	var _num      = _list_obj.length ;
	var i ;

	if(_btn_obj.checked == true){

		for(i=0;i<_num;i++){
			_list_obj[i].checked=true;
		}
		
	}else{

		for(i=0;i<_num;i++){
			_list_obj[i].checked=false;
		}
		
	}
	
}


 /******************************************************************************
 * 함수명    : resize_win(width, height)
 * 함수내용  : 윈도우 창 크기 맞추기
 * 반환값    :
 * 사용법    : 
 *****************************************************************************/
function resize_win() {
	
		/*
	var frameBody = document.body;
	var ly_width  = frameBody.scrollWidth  + 10 ;
	var ly_height = frameBody.scrollHeight + 50 ;
	*/

	var frameBody = self.document.body;
	var ly_width  = frameBody.scrollWidth + (frameBody.offsetWidth-frameBody.clientWidth);
	var ly_height = frameBody.scrollHeight + (frameBody.offsetHeight-frameBody.clientHeight);

	this.resizeTo(ly_width, ly_height+100);
}


 /******************************************************************************
 * 함수명    : resize_frame(frm)
 * 함수내용  : iframe 창 크기 맞추기
 * 반환값    :
 * 사용법    : 
 *****************************************************************************/
function resize_frame(frm) {
	var pFrame = eval(frm + ".document.body;");
	var iFrame = eval("document.all." + frm + ";");

	iFrame.style.height = pFrame.scrollHeight + (pFrame.offsetHeight - pFrame.clientHeight);
}



 /******************************************************************************
 * 함수명    : resize_image(img,maxWidth,maxHeight)
 * 함수내용  : 이미지 사이즈 조정
 * 반환값    : 조정된 이미지
 * 사용법    : <img src="이미지URL" onload="resize_image(this)">
 *****************************************************************************/
function resize_image(img,maxWidth,maxHeight){
	// 원본 이미지 사이즈 저장
	var width  = img.width;
	var height = img.height;

	// 가로나 세로의 길이가 최대 사이즈보다 크면 실행  
	if(width > maxWidth || height > maxHeight){
		// 가로가 세로보다 크면 가로는 최대사이즈로, 세로는 비율 맞춰 리사이즈
		if(width > height){
			resizeWidth  = maxWidth;
			resizeHeight = ((height * resizeWidth) / width);

			// 세로가 가로보다 크면 세로는 최대사이즈로, 가로는 비율 맞춰 리사이즈
		}else{
			resizeHeight = maxHeight;
			resizeWidth  = ((width * resizeHeight) / height);
		}

	// 최대사이즈보다 작으면 원본 그대로
	}else{
		resizeWidth  = width;
		resizeHeight = height;
	}

	// 리사이즈한 크기로 이미지 크기 다시 지정
	img.width  = resizeWidth;
	img.height = resizeHeight;

}


 /******************************************************************************
 * 함수명    : line_detail(nm)
 * 함수내용  : 상세정보 출력
 *****************************************************************************/
var old_line_num = "";
function line_detail(nm){
	var nRecord = "line_"+nm ;
	var oRecord = "" ;

	if(old_line_num != nm){
		
		if(old_line_num != ""){			
			oRecord = "line_" + old_line_num ;
			document.getElementById(oRecord).style.display = "none" ;
		}

		document.getElementById(nRecord).style.display = "table-row" ;
		old_line_num = nm ;
	}
}


 /******************************************************************************
 * 함수명    : add_faq_hit(idx)
 * 함수내용  : faq 확인수 증가하기
 * 반환값    :
 * 사용법    : 
 *****************************************************************************/
function add_faq_hit(idx) {
	actionForm.location.href = "../_action/add.hit.php?idx="+ idx ;
	return true ;
}


 /******************************************************************************
 * 함수명    : confirm_process(step,msg,ref)
 * 함수내용  : 삭제 확인 루틴
 * 반환값    :
 * 사용법    : 
 *****************************************************************************/

function confirm_process(step,msg,ref)
{	
	var pageGo = step ? eval(step + ".document") : eval("document") ;

	if(confirm(msg)){
		pageGo.location.href = ref ;
	}else{
		return false ;
	}
}


 /******************************************************************************
 * 함수명    : idontknow(id1,id2)
 * 함수내용  : id2 필드를 disabled 시키는 함수
 * 반환값    :
 * 사용법    : 
 *****************************************************************************/
function idontknow(id1,id2)
{

	if(document.getElementById(id1).checked === true){
		document.getElementById(id2).disabled = true ;
		document.getElementById(id2).style.backgroundColor = "#E9E9E9" ;
		document.getElementById(id2).value = "" ;
	}else{
		document.getElementById(id2).disabled = false ;
		document.getElementById(id2).style.backgroundColor = "" ;
		document.getElementById(id2).focus() ;
	}
}


 /******************************************************************************
 * 함수명    : 
 * 함수내용  : 
 * 반환값    : 
 * 사용법    : 
 *****************************************************************************/
function replaceText(el, text) {
  if (el != null) {
    clearText(el);
    var newNode = document.createTextNode(text);
    el.appendChild(newNode);
  }
}

function clearText(el) {
  if (el != null) {
    if (el.childNodes) {
      for (var i = 0; i < el.childNodes.length; i++) {
        var childNode = el.childNodes[i];
        el.removeChild(childNode);
      }
    }
  }
}

function getText(el) {
  var text = "";
  if (el != null) {
    if (el.childNodes) {
      for (var i = 0; i < el.childNodes.length; i++) {
        var childNode = el.childNodes[i];
        if (childNode.nodeValue != null) {
          text = text + childNode.nodeValue;
        }
      }
    }
  }
  return text;
}


function clear_field(id,imgUrl,tp){
	var val = trim(document.getElementById(id).value) ;

	if (tp == "1")
	{
		if (val == "")
		{
			document.getElementById(id).style.background = "" ;
		}
	}else{
		if (val == "")
		{
			//alert(imgUrl) ;
			document.getElementById(id).style.backgroundImage  = "url("+imgUrl+")" ;
			document.getElementById(id).style.backgroundRepeat = "no-repeat" ;
		}

	}
	
}

