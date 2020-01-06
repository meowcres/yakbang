<?
$view_slot = $_GET["slot"];

if ($view_slot != "modify") {
    if ($view_slot != "myconsult") {
        if ($view_slot != "signout") {
            if ($_SESSION["s_id"]) {
                $url = "/";
                alert_js("alert_parent_move", "로그인중입니다.", $url);
                exit;
            }
        }
    }
} else {
    if ($_SESSION["s_id"] == "") {
        alert_js("alert_parent_move", "로그인 후 수정 가능합니다.", "/");
        exit;
    }
}
?>