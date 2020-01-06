<table>
    <colgroup>
        <col style="width:8%"/>
        <col style="width:8%"/>
        <col style="width:*"/>
    </colgroup>
    <tbody>
    <tr>
        <th rowspan="4">추가정보</th>
        <th>로고이미지</th>
        <td>
            <?php
            if (!isNull($logo_obj["IDX"])) {
                ?><img src="../Web_Files/pharmcy/<?= $logo_obj["PHYSICAL_NAME"] ?>" width="150"><?
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>약국이미지</th>
        <td>
            <?php
            if (!isNull($img_obj["IDX"])) {
                ?><img src="../Web_Files/pharmacy/<?= $img_obj["PHYSICAL_NAME"] ?>" width="300"><?
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>영업시간</th>
        <td class="p10px">
            <?= nl2br(clear_escape($p_main["OPERATION_HOURS"])) ?>
        </td>
    </tr>

    <tr>
        <th>약국소개</th>
        <td class="p10px">
            <?= nl2br(clear_escape($p_main["INTRODUCTION"])) ?>
        </td>
    </tr>

    <tr>
        <th rowspan="2">관리정보</th>
        <th>관리자</th>
        <td>
            <?= $p_main["ADMIN_ID"] ?>
        </td>
    </tr>

    <tr>
        <th>관리메모</th>
        <td class="p10px">
            <?= nl2br(clear_escape($p_main["ADMIN_CMT"])) ?>
        </td>
    </tr>

    </tbody>
</table>