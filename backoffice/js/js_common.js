/**
* js_common.js
**/


/**
*  @brief null 값을 확인 한다
*  @param 
*  @return 
**/
function isNull(obj)
{
	return (typeof obj != "underfined" && obj!= null && obj != "") ? false : true ;
}


/**
*  @brief 페이지를 이동시킨다
*  @param 
*  @return 
**/
function goLink(url,step)
{
	var pageGo = step ? eval(step + ".location") : eval("location") ;
	pageGo.href = url ;
}


/**
*  @brief 계속 진행할 지 물어본다
*  @param 
*  @return 
**/
function confirm_process(step,msg,ref)
{
    var pageGo = step ? eval(step + ".document") : eval("document") ;

    if(confirm(msg)){
        pageGo.location.href = ref ;
    }else{
        return false ;
    }
}


/**
*  @brief null 값을 확인 한다
*  @param 
*  @return 
*
*  @example 1: stripslashes('Kevin\'s code')
*  @returns 1: "Kevin's code"
*  @example 2: stripslashes('Kevin\\\'s code')
*  @returns 2: "Kevin\'s code"
**/
function stripslashes(str)
{
	return (str + '').replace(/\\(.?)/g, function (s, n1) {
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
			}) ;
}


/**
*  @brief 3자리수마다 콤마를 찍는다
*  @param 
*  @return 
**/
function comma(str)
{
	str = String(str);
	return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}


/**
*  @brief 콤마를 없앤다
*  @param 
*  @return 
**/
function uncomma(str)
{
	str = String(str);
	return str.replace(/[^\d]+/g, '');
}


/**
*  @brief 입력창의 숫자에 콤마를 찍는다
*  @param 
*  @return 
**/
function inputNumberFormat(obj)
{
	obj.value = comma(uncomma(obj.value));
}


/**
*  @brief 새로운 창을 연다
*  @param mypage 파일 경로
*  @param myname 새창 ID
*  @param w 가로사이즈
*  @param h 세로사이즈
*  @param opt 옵션 
*  @return 새창
**/
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
 * 함수명    : trim
 * 함수내용  : 좌우가운데 모두 스페이스 제거
 * 반환값    : String
 *****************************************************************************/
function trim(parm_str)
{
	return rtrim(ltrim(parm_str));
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