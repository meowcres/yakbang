<h3 class="h3_title">추가정보</h3>
<div class="adm_table_style01">
    <table>
        <colgroup>
            <col style="width:10%"/>
            <col style="width:15%"/>
            <col style="width:*"/>
        </colgroup>
        <tbody>
        <tr>
            <th rowspan="8">추가 정보</th>
            <th>마지막 로그인</th>
            <td><?= $_pharmacist["last_login"] ?></td>
        </tr>
        <tr>
            <th>휴면 날짜</th>
            <td><?= $_pharmacist["diapause_date"] ?></td>
        </tr>
        <tr>
            <th>탈퇴 날짜</th>
            <td><?= $_pharmacist["withdraw_date"] ?></td>
        </tr>
        <tr>
            <th>로그인 횟수</th>
            <td><?= $_pharmacist["log_count"] ?></td>
        </tr>
        <tr>
            <th>약사신청여부</th>
            <td><?= $_pharmacist["pharmacist_request"] ?></td>
        </tr>
        <tr>
            <th>약사신청일</th>
            <td><?= $_pharmacist["pharmacist_reg_date"] ?></td>
        </tr>
        <tr>
            <th>약사면허</th>
            <td><?= $row_001["LICENSE_NUMBER"] ?></td>
        </tr>
        <tr>
            <th>라이센스 이미지</th>
            <td>
                <?php
                if (!isNull($license_img["IDX"])) {
                    ?><img src="../Web_Files/pharmacist_license/<?= $license_img["PHYSICAL_NAME"] ?>" width="200"><?
                } else { ?>
                   라이센스 이미지 없음
                <? }
                ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</div>
</div>