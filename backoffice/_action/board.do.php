<?php
include_once "../../_core/_init.php";

$mode = "";
$mode = $_REQUEST["mode"];

$link = ""; // 이동할 주소 변수

// 정보등록
##### 공지사항 분류 입력
if ($mode == "add_board_type") {

    $parent_code = "";
    $group_code = $_POST['cd_key'];

    $cd_key = $_POST['cd_key'];
    $cd_status = $_POST['cd_status'];
    $cd_type = $_POST['cd_type'];
    $order_seq = $_POST['order_seq'];
    $cd_title = add_escape(strip_tags($_POST['cd_title']));
    $cd_url = add_escape($_POST['cd_url']);
    $cd_depth = $_POST['cd_depth'];

    $qry_001 = "INSERT INTO {$TB_CODE} SET";
    $qry_001 .= "  CD_KEY = '{$cd_key}'";
    $qry_001 .= ", CD_STATUS = '{$cd_status}'";
    $qry_001 .= ", CD_TYPE = '{$cd_type}'";
    $qry_001 .= ", CD_TITLE = '{$cd_title}'";
    $qry_001 .= ", CD_URL = '{$cd_url}'";
    $qry_001 .= ", PARENT_CODE = '{$parent_code}'";
    $qry_001 .= ", GRUOP_CODE = '{$group_code}'";
    $qry_001 .= ", ORDER_SEQ = '{$order_seq}'";
    $qry_001 .= ", CD_DEPTH = '{$cd_depth}'";

    $db->exec_sql($qry_001);

    alert_js("parent_opener_reload", "", "");
    alert_js("alert_parent_reload", "분류정보를 등록하였습니다.", "");
    exit;


##### 공지사항 분류 수정
} else if ($mode == "up_board_type") {

    $cd_key = $_POST['cd_key'];
    $cd_status = $_POST['cd_status'];
    $cd_type = $_POST['cd_type'];
    $order_seq = $_POST['order_seq'];
    $cd_depth = $_POST['cd_depth'];
    $cd_url = add_escape($_POST['cd_url']);
    $cd_title = add_escape($_POST['cd_title']);
    $group_code = $_POST['group_code'];
    $parent_code = $_POST['parent_code'];

    $qry_001 = "UPDATE {$TB_CODE} SET";
    $qry_001 .= "  CD_STATUS = '{$cd_status}'";
    $qry_001 .= ", CD_TYPE = '{$cd_type}'";
    $qry_001 .= ", CD_TITLE = '{$cd_title}'";
    $qry_001 .= ", CD_URL = '{$cd_url}'";
    $qry_001 .= ", PARENT_CODE = '{$parent_code}'";
    $qry_001 .= ", GRUOP_CODE = '{$group_code}'";
    $qry_001 .= ", ORDER_SEQ = '{$order_seq}'";
    $qry_001 .= ", CD_DEPTH = '{$cd_depth}'";
    $qry_001 .= " WHERE CD_KEY = '{$cd_key}'";

    $db->exec_sql($qry_001);

    alert_js("parent_opener_reload", "", "");
    alert_js("alert_parent_reload", "분류정보를 수정하였습니다.", "");
    exit;


##### 공지사항 분류 삭제
} else if ($mode == "del_board_type") {

    if (isNull($_GET["cd_key"])) {
        alert_js("alert_parent_reload", "옳바르지 않은 정보입니다.", "");
        exit;
    }

    $qry_001 = "DELETE FROM {$TB_CODE} WHERE CD_KEY='{$_GET["cd_key"]}' ";
    $db->exec_sql($qry_001);

    alert_js("alert_parent_reload", "분류정보를 삭제하였습니다.", "");
    exit;


##### 공지사항 입력
} else if ($mode == "add_notice") {

    // SITE 정보 변경
    $n_type = $_POST["n_type"];
    $n_status = $_POST["n_status"];
    $n_writer = add_escape($_POST["n_writer"]);
    $reg_date = $_POST["reg_date"];
    $n_title = add_escape($_POST["n_title"]);
    $n_contents = add_escape($_POST["n_contents"]);
    $n_tag = add_escape($_POST["n_tag"]);
    $og_desc = add_escape($_POST["og_desc"]);
    $n_addr = add_escape($_POST["n_addr"]);


    $_sql = "INSERT INTO {$TB_NOTICE} SET    ";
    $_sql .= " N_STATUS   = '{$n_status}'   ";
    $_sql .= ",N_TYPE     = '{$n_type}'     ";
    $_sql .= ",N_TITLE    = '{$n_title}'    ";
    $_sql .= ",N_CONTENTS = '{$n_contents}' ";
    $_sql .= ",OG_DESC    = '{$og_desc}'    ";
    $_sql .= ",N_WRITE    = '{$n_writer}'   ";

    if (isset($_FILES['n_img']) && $_FILES['n_img']['name'] != "") {

        $fileNameInfo = explode(".", $_FILES['n_img']["name"]);
        $logicalName = uniqid("notice_");
        $notice_file = $logicalName . "." . $fileNameInfo[1];

        move_uploaded_file($_FILES['n_img']["tmp_name"], "../" . $BOARD_URL . $notice_file);

        $_sql .= ", N_IMG='" . $notice_file . "' ";

    }


    $_sql .= ",N_TAG      = '{$n_tag}'      ";
    $_sql .= ",HIT        = '0'             ";
    $_sql .= ",N_ADDR     = '{$n_addr}'     ";
    $_sql .= ",REG_DATE   = '{$reg_date}'   ";


    $db->exec_sql($_sql);

    alert_js('alert_parent_move', '공지사항을 등록하였습니다', '../admin.template.php?slot=board&type=notice_list');
    exit;


##### 게시판 수정
} else if ($mode == "up_notice") {


    // SITE 정보 변경

    $idx = $_POST["idx"];

    $n_type = $_POST["n_type"];
    $n_status = $_POST["n_status"];
    $n_writer = add_escape($_POST["n_writer"]);
    $reg_date = $_POST["reg_date"];
    $n_title = add_escape($_POST["n_title"]);
    $n_contents = add_escape($_POST["n_contents"]);
    $n_tag = add_escape($_POST["n_tag"]);
    $og_desc = add_escape($_POST["og_desc"]);
    $n_addr = add_escape($_POST["n_addr"]);
    $hit = $_POST["hit"];

    $old_file = $_POST["old_file"];

    // 첨부파일1 삭제로직
    if ($_POST["del_file"] == "Y") {
        @unlink("../" . $BOARD_URL . $old_file);
        $del_qry = "UPDATE {$TB_NOTICE} SET N_IMG='' WHERE IDX='{$idx}'";
        @$db->exec_sql($del_qry);
    }

    $_sql = "UPDATE {$TB_NOTICE} SET         ";
    $_sql .= " N_STATUS   = '{$n_status}'   ";
    $_sql .= ",N_TYPE     = '{$n_type}'     ";
    $_sql .= ",N_TITLE    = '{$n_title}'    ";
    $_sql .= ",N_CONTENTS = '{$n_contents}' ";
    $_sql .= ",OG_DESC    = '{$og_desc}'    ";
    $_sql .= ",N_WRITE    = '{$n_writer}'   ";

    if (isset($_FILES['n_img']) && $_FILES['n_img']['name'] != "") {

        @unlink("../" . $BOARD_URL . $old_file);

        $fileNameInfo = explode(".", $_FILES['n_img']["name"]);
        $logicalName = uniqid("notice_");
        $notice_file = $logicalName . "." . $fileNameInfo[1];

        move_uploaded_file($_FILES['n_img']["tmp_name"], "../" . $BOARD_URL . $notice_file);

        $_sql .= ", N_IMG='" . $notice_file . "' ";

    }

    $_sql .= ",N_TAG      = '{$n_tag}'      ";
    $_sql .= ",HIT        = '{$hit}'        ";
    $_sql .= ",N_ADDR     = '{$n_addr}'     ";
    $_sql .= ",REG_DATE   = '{$reg_date}'   ";
    $_sql .= " WHERE IDX='{$idx}'           ";

    $db->exec_sql($_sql);

    alert_js('alert_parent_reload', '공지사항을 수정하였습니다', '');
    exit;


} else if ($mode == "del_notice") {

    $_idx = $_GET["idx"];

    $_sql = "SELECT N_IMG FROM {$TB_NOTICE} WHERE IDX= '{$_idx}'";
    $_res = $db->exec_sql($_sql);
    $_row = $db->sql_fetch_row($_res);

    if (!isNull($_row[0])) {
        @unlink("../" . $BOARD_URL . $_row[0]);
    }

    $_sql = "DELETE FROM {$TB_NOTICE} WHERE IDX = '{$_idx}' ";
    $db->exec_sql($_sql);

    alert_js('parent_reload', '', '');
    exit;



##### FAQ 입력
} else if ($mode == "add_faq") {

    // SITE 정보 변경
    $f_type = $_POST["f_type"];
    $f_status = $_POST["f_status"];
    $f_question = add_escape($_POST["f_question"]);
    $f_answer = add_escape($_POST["f_answer"]);
    $order_seq = $_POST["order_seq"];
    
    $_sql = "INSERT INTO {$TB_FAQ} SET      ";
    $_sql .= " F_STATUS   = '{$f_status}'   ";
    $_sql .= ",F_TYPE     = '{$f_type}'     ";
    $_sql .= ",F_QUESTION = '{$f_question}' ";
    $_sql .= ",F_ANSWER   = '{$f_answer}'   ";
    $_sql .= ",ORDER_SEQ  = '{$order_seq}'  ";
    $_sql .= ",REG_DATE   = now()           ";

    $db->exec_sql($_sql);

    alert_js('alert_parent_move', 'FAQ를 등록하였습니다', '../admin.template.php?slot=board&type=faq_list');
    exit;


##### FAQ 수정
} else if ($mode == "up_faq") {

    $idx = $_POST["idx"];

    $f_type = $_POST["f_type"];
    $f_status = $_POST["f_status"];
    $f_question = add_escape($_POST["f_question"]);
    $f_answer = add_escape($_POST["f_answer"]);
    $order_seq = $_POST["order_seq"];

    $_sql = "UPDATE {$TB_FAQ} SET           ";
    $_sql .= " F_STATUS   = '{$f_status}'   ";
    $_sql .= ",F_TYPE     = '{$f_type}'     ";
    $_sql .= ",F_QUESTION = '{$f_question}' ";
    $_sql .= ",F_ANSWER   = '{$f_answer}'   ";
    $_sql .= ",ORDER_SEQ  = '{$order_seq}'  ";
    $_sql .= " WHERE IDX  = '{$idx}'        ";

    $db->exec_sql($_sql);

    alert_js('alert_parent_reload', 'FAQ를 수정하였습니다', '');
    exit;


##### FAQ 삭제
} else if ($mode == "del_faq") {

    $_idx = $_GET["idx"];

    $_sql = "DELETE FROM {$TB_FAQ} WHERE IDX = '{$_idx}' ";
    $db->exec_sql($_sql);

    alert_js('parent_reload', '', '');
    exit;




##### 문의 수정
} else if ($mode == "up_request") {

    $idx = $_POST["idx"];
    $r_status = $_POST["r_status"];
    $admin_desc = add_escape($_POST["admin_desc"]);

    $_sql = "UPDATE {$TB_REQUEST} SET           ";
    $_sql .= " R_STATUS   = '{$r_status}'   ";
    $_sql .= ",ADMIN_DESC = '{$admin_desc}' ";
    $_sql .= ",UP_DATE = now() ";
    $_sql .= " WHERE IDX  = '{$idx}'        ";

    $db->exec_sql($_sql);

    alert_js('alert_parent_reload', '문의를 수정하였습니다', '');
    exit;


##### 문의 삭제
} else if ($mode == "del_request") {

    $_idx = $_GET["idx"];

    $_sql = "DELETE FROM {$TB_REQUEST} WHERE IDX = '{$_idx}' ";
    $db->exec_sql($_sql);

    alert_js('parent_reload', '', '');
    exit;













}


$db->db_close();
?>