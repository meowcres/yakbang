<?
include_once "./_init.php" ;

$_idx = $_GET["idx"];

$_edu_sql = "SELECT * FROM {$EDU_SCHEDULE_TB} where idx='{$_idx}'" ;

$_edu_res = $db->exec_sql($_edu_sql);
$_edu_row = $db->sql_fetch_array($_edu_res);

if($_edu_row["entry_type"]){
    $_coupon_count_sql = "SELECT count(idx) FROM {$COUPON_USER_TB} where cp_type='{$_edu_row["entry_type"]}' AND use_type='N' AND buyer_id='{$_SESSION[s_id]}' " ;
    $_coupon_count_res = $db->exec_sql($_coupon_count_sql);
    $_coupon_count_row = $db->sql_fetch_row($_coupon_count_res);

    $_totalNum = $_coupon_count_row[0];
}


?>
<html>
<head>
    <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
    <meta http-equiv='imagetoolbar' content='no' />
    <title>## 쿠폰 결재 ##</title>
    <style type="text/css">
        <!--
        body, table, tr, td, select, input, div, form, textarea
        {
            font-family:"굴림", "Geneva", "Arial", "Helvetica", "Verdana", "sans-serif";
            font-size: 12px;
            color: #464646;
            line-height: 120%;
            scrollbar-face-color: #d6d6d6;
            scrollbar-shadow-color: #bebebe;
            scrollbar-highlight-color: #ffffff;
            scrollbar-3dlight-color: #ffffff;
            scrollbar-darkshadow-color: #606060;
            scrollbar-track-color: #f7f7f7;
            scrollbar-arrow-color: #ffffff
        }

        img {border:0}

        A {selector-dummy : expression(this.hideFocus=true);}
        A:active {color: #464646;text-decoration : none;}
        A:link {color: #464646; text-decoration: none;}
        A:visited {color: #464646; text-decoration : none;}
        A:hover {color: #464646; text-decoration : underline;}

        .input {
            border: 1px solid #C3C2C2;
            background-color:#FFFFFF;
            font-size: 9pt;
            color: #666666;
            height:16px;
            text-indent: 4px;
            line-height: 16px;
            ime-mode:active;
        }

        .black_profile {
            font-size: 9pt;
            color: #6A6A6A;
            font-family: "굴림";
            font-weight: bold;
        }

        .black_addition {
            font-size: 9pt;
            color: #797979;
            font-family: "굴림";
            letter-spacing: -1px;
        }
        //-->
    </style>
    <script language=javascript>
        <!--
        /******************************************************************************
         * 함수명    : Coupon_Select(coupon_num)
         * 함수내용  : 주소 정보 값 전달
         * 반환값    : String
         *****************************************************************************/
        function Coupon_Select(coupon_num)
        {
            opener.document.getElementById("coupon_num").value  = coupon_num;
            this.close();
        }
        //-->
    </script>
</head>

<body topmargin="0" leftmargin="0">
<table width="400" height="320" border="0" cellpadding="0" cellspacing="0" background="./img/loginlog_box_bg.gif">
    <tr>
        <td height="15" valign="top"><img src="./img/loginlog_box_top.gif" width="400" height="15"></td>
    </tr>
    <tr>
        <td align="center" valign="top">

            <table width="320" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="310" align="center" valign="top">

                        <table width="368" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><span class="black_profile" style="padding-left:10px">검색결과</span> <span class="black_addition">(쿠폰번호를 클릭하세요) </span></td>
                            </tr>
                            <tr>
                                <td align="center" width="362" height="310" style="padding-top:5px;">
                                    <!--'주소' 나오는 부분-->
                                    <?if($_totalNum > 0){?>
                                        <div style="overflow:auto;height:310px;">
                                            <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="1">
                                                <?
                                                $_sql      = "SELECT * FROM {$COUPON_USER_TB} where cp_type='{$_edu_row["entry_type"]}' AND use_type='N' AND buyer_id='{$_SESSION[s_id]}' ";

                                                $_res = $db->exec_sql($_sql);

                                                while($_row = $db->sql_fetch_array($_res)){
                                                ?>
                                                    <tr>
                                                        <td style="cursor:pointer;" onClick="Coupon_Select('<?=$_row["cp_code"]?>')" onMouseOver="this.style.backgroundColor='#F0F0F0'" onMouseOut="this.style.backgroundColor=''"><?=$_row["cp_code"]?></td>
                                                    </tr>
                                                <?
                                                }
                                                ?>
                                            </table>
                                        </div>
                                        <?
                                    }else{
                                        ?><span class="black_addition">검색 된 쿠폰이 없습니다.</span><?
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <!--'닫기' 버튼-->
                        <img src="./_zipcode/img/btn_close.gif" width="48" height="23" onClick="self.close();" style="cursor:pointer;">
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td height="17" valign="bottom"><img src="./img/loginlog_box_bottom.gif" width="400" height="17"></td>
    </tr>
</table>
</body>
</html>