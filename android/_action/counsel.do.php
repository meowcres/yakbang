<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";


$Mode = "";
$Mode = $_REQUEST["Mode"];

$_link = "";        // 이동할 주소 변수


// 상담 등록
if ($Mode == "add_counsel") {

    $c_type = $_REQUEST["c_type"];
    $sub_type = $_REQUEST["sub_type"];
    $c_sex = $_REQUEST["c_sex"];
    $c_title = add_escape($_REQUEST["c_title"]);
    $c_question = add_escape($_REQUEST["c_question"]);
    $c_mentor = $_REQUEST["c_mentor_list"];
    $c_write = $_REQUEST["c_write"];

    if ($c_type == "2") {

      if ($sub_type == "c_mentor") {
        $c_sex = "";
      } else {
            if ($c_sex == "all") {
                $c_sex = "";
                $c_mentor = "";
            } else {
                $c_mentor = "";
            }        
      }     
      
    } else {

      $c_sex = "";
      $c_mentor = "";
      
    }

    $qry_001  = " INSERT INTO {$TB_COUNSEL} SET ";
    $qry_001 .= "  C_STATUS = 'y' ";
    $qry_001 .= ", C_TYPE = '{$c_type}' ";
    $qry_001 .= ", C_SEX = '{$c_sex}' ";
    $qry_001 .= ", C_TITLE = '{$c_title}' ";
    $qry_001 .= ", C_QUESTION = '{$c_question}' ";
    $qry_001 .= ", C_MENTOR = '{$c_mentor}' ";
    $qry_001 .= ", C_WRITE = '{$c_write}' ";
    $qry_001 .= ", REG_DATE = now() ";
    
    $db->exec_sql($qry_001);
    echo 0;
    exit;

} else if ($Mode == "add_mentor") {

    $mentee_id = add_escape($_REQUEST["mentee_id"]);
    $mentor_id = add_escape($_REQUEST["mentor_id"]);
    $i = 0;

    if (isNull($mentee_id)) {
        $i = 1;
    }

    $qry_001 = " SELECT * FROM {$TB_MENTOR} ";
    $res_001 = $db->exec_sql($qry_001);
    while($row_001 = $db->sql_fetch_array($res_001)) {
        if ($row_001["MENTEE_ID"] == $mentee_id && $row_001["MENTOR_ID"] == $mentor_id) {
            $i = 2;
        }
    }

    if ($i == 0) {
        $qry_002 = "INSERT INTO {$TB_MENTOR} SET ";
        $qry_002 .= " MENTEE_ID = '{$mentee_id}' ";
        $qry_002 .= " , MENTOR_ID = '{$mentor_id}' ";
        $qry_002 .= " , REG_DATE = now() ";
        $db->exec_sql($qry_002);
        echo $i;
    } else if ($i == 1 || $i == 2) {
        echo $i;
    } else {
        echo 3;
    }

    exit;



// 약사 답변 등록
} else if ($Mode == "reply_counsel") {

    $parent_key = $_REQUEST["parent_key"];
    $r_write = $_REQUEST["r_write"];
    $r_answer = add_escape($_REQUEST["r_answer"]);


    $qry_001 = "INSERT INTO {$TB_CR} SET";
    $qry_001 .= "  PARENT_KEY = '{$parent_key}'";
    $qry_001 .= ", R_ANSWER = '{$r_answer}'";
    //$qry_001 .= ", R_WRITE = HEX(AES_ENCRYPT('" . $r_write . "','" . SECRET_KEY . "'))";
    $qry_001 .= ", R_WRITE = '{$r_write}'";
    $qry_001 .= ", REG_DATE   = now() ";

    $db->exec_sql($qry_001);

    echo 100;
    exit;

}


$db->db_close();