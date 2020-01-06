<?php
include_once "../../_core/_init.php" ;

$Mode = $_REQUEST["Mode"] ;

switch ($Mode) {
    // 로그인
    case "login" :
        $admin_array = array();
        $admin_id    = $_POST["admin_id"];
        $admin_pass  = $_POST["admin_pass"];

        // 아이디 확인
        $sql_001  = " SELECT               ";
        $sql_001 .= " t1.IDX               ";
        $sql_001 .= " ,t1.ADMIN_PASS       ";
        //$sql_001 .= ",cast(AES_DECRYPT(UNHEX(t1.ADMIN_PASS),'".$_SITE['SITE_ID']."') AS CHAR (10000) CHARACTER SET UTF8)  AS STR" ;
        $sql_001 .= " FROM {$TB_ADMIN} t1  ";
        $sql_001 .= " WHERE t1.ADMIN_ID='{$admin_id}' ";
        $sql_001 .= " AND t1.ADMIN_STATUS in ('Y')    ";
        $res_001  = $db->exec_sql($sql_001) ;
        $row_001  = $db->sql_fetch_row($res_001) ;

        if(isNull($row_001[0])){
            alert_js("alert","일치하는 아이디 정보가 없습니다. \\n\\n다시 확인해 주세요!","");
            exit;
        }

        if($row_001[1] == $admin_pass){
            $admin_array["idx"] = $row_001[0] ;
            $admin_array["id"]  = $admin_id ;
        }else{
            alert_js("alert","비밀번호가 틀립니다. \\n\\n다시 확인해 주세요!","");
            exit;
        }

        if (!isNull($admin_array["idx"])) {
            $_SESSION["admin"]["idx"] = $admin_array['idx'] ;
            $_SESSION["admin"]["id"]  = $admin_array['id'] ;
            
            if($ADMIN_COOKIE_YN == "yes"){
                SetCookie("cookie_admin_idx", $admin_array["idx"], time()+(3600*24*365),"/") ;
                SetCookie("cookie_admin_id" , $admin_array["id"],  time()+(3600*24*365),"/") ;
            }

            // 접속 카운터 증가
            $sql_002  = " UPDATE {$TB_ADMIN} t1 SET ";
            $sql_002 .= " t1.ADMIN_HIT=t1.ADMIN_HIT+1, t1.LAST_DATE=now() " ;
            $sql_002 .= " WHERE t1.IDX='".$admin_array["idx"]."'" ;
            
            @$db->exec_sql($sql_002) ;

            $return_path = "../admin.template.php?slot=main&type=dashboard" ;
            alert_js("parent_move","",$return_path) ;
        }else{
            alert_js("alert_parent_reload","로그인 정보 오류입니다.","") ;
        }
    break;

    // 로그아웃
    case "logout" :
        $_SESSION["admin"]["idx"] = $admin_array['idx'] ;
        $_SESSION["admin"]["id"]  = $admin_array['id'] ;
        
        if($ADMIN_COOKIE_YN == "yes"){
            SetCookie("cookie_admin_idx", "",time()-3600,"/");
            SetCookie("cookie_admin_id", "",time()-3600,"/");
        }
        
        $Return_Path = "../admin.login.php?slot=login&type=form" ;
        alert_js("alert_parent_move","로그아웃 되었습니다.",$Return_Path);
	break;
}


$db->db_close();