<div><b>○ 추가정보</b></div>
<table>
    <colgroup>
        <col style="width:8%"/>
        <col style="width:10%"/>
        <col style="width:*"/>
    </colgroup>
    <tbody>
    <tr>
        <th rowspan="8">추가 정보</th>
        <th>마지막 로그인</th>
        <td><?= $m_main["LAST_LOGIN"] ?></td>
    </tr>
    <tr>
        <th>휴면 날짜</th>
        <td><?= $m_main["DIAPAUSE_DATE"] ?></td>
    </tr>
    <tr>
        <th>탈퇴 날짜</th>
        <td><?= $m_main["WITHDRAW_DATE"] ?></td>
    </tr>
    <tr>
        <th>로그인 횟수</th>
        <td><?= $m_main["LOG_COUNT"] ?></td>
    </tr>
    <tr>
        <th>약사신청여부</th>
        <td><?= $m_main["PHARMACIST_REQUEST"] ?></td>
    </tr>
    <tr>
        <th>약사신청일</th>
        <td><?= $m_main["PHARMACIST_REG_DATE"] ?></td>
    </tr>
    <tr>
        <th>약사면허</th>
        <td><?= $m_main["LICENSE_NUMBER"] ?></td>
    </tr>
    <tr>
        <th>라이센스 이미지</th>
        <td>
            <?php
            if (!isNull($license_img["IDX"])) {
                ?><img src="../Web_Files/pharmacist_license/<?= $license_img["PHYSICAL_NAME"] ?>" width="200"><?
            } else {
                ?>
                라이센스 이미지 없음
                <?
            }
            ?>
        </td>
    </tr>
    </tbody>
</table>