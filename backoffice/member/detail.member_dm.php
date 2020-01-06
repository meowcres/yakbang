<div><b>○ 쪽지 관리</b></div>
<table>
    <colgroup>
        <col style="width:15%"/>
        <col style="width:35%"/>
        <col style="width:15%"/>
        <col style="width:35%"/>
    </colgroup>
    <tr>
        <th>받은 쪽지함</th>
        <td>
            <input type="button" value="받은 쪽지함 열기" class="Button btnSky"
                   onClick="popup_receive('<?=$m_main["USER_ID"]?>');">
        </td>
        <th>보낸 쪽지함</th>
        <td>
            <input type="button" value="보낸 쪽지함 열기" class="Button btnSky"
                   onClick="popup_send('<?=$m_main["USER_ID"]?>');">
        </td>
    </tr>
</table>

<script>
    function popup_receive(user_id) {
        var url = "./member/popup.receive_dm.php?user_id=" + user_id;
        window.open(url,"", "width=1200, height=900");
    }
    function popup_send(user_id) {
        var url = "./member/popup.send_dm.php?user_id=" + user_id;
        window.open(url,"", "width=1200, height=900");
    }
</script>