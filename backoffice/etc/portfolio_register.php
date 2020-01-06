<?php
$pf_code = substr(date("D"), 0, 1) . mktime();
?>
<div id="Contents">
    <h1>기타 관리 > 포트폴리오 관리 > <strong>포트폴리오 목록</strong></h1>
    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/etc.do.php" style="display:inline;"
          target="actionForm">
        <input type="hidden" id="mode" name="mode" value="portfolio_add">
        <table class='tbl1'>
            <colgroup>
                <col width="10%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="15%"/>
            </colgroup>
            <tr>
                <th>코드</th>
                <td class="left">
                    <input type="text" id="pf_code" name="pf_code" value="<?= $pf_code ?>" readonly class="w90p"/>
                </td>
                <th>회사</th>
                <td class="left">
                    <select id="pf_company" name="pf_company" class="w100">
                        <option value="1" selected>1</option>
                        <option value="2" >2</option>
                    </select>
                </td>
                <th>상태</th>
                <td class="left">
                    <select id="pf_status" name="pf_status" class="w100">
                        <option value="Y" selected>Y</option>
                        <option value="N" >N</option>
                    </select>
                </td>
                <th>분류</th>
                <td class="left">
                    <select id="pf_type" name="pf_type" class="w100">
                        <option value="1" selected>1</option>
                    </select>
                </td>

            </tr>
            <br>
            <tr>
                <th>제목</th>
                <td class="left" colspan="8">
                    <input type="text" id="pf_title" name="pf_title" class="w90p"/>
                </td>
            </tr>
            <br>
            <tr>
                <th>내용</th>
                <td class="left" colspan="8">
                    <textarea id="pf_contents" name="pf_contents" class="w90p h150"></textarea>
                </td>
            </tr>
            <br>
            <tr>
                <th>이미지1</th>
                <td class="left" colspan="8">
                    <input type="file" id="file1" name="file1" class="w70p"/>
                </td>
            </tr>
            <tr>
                <th>이미지2</th>
                <td class="left" colspan="8">
                    <input type="file" id="file2" name="file2" class="w70p"/>
                </td>
            </tr>
            <tr>
                <th>이미지3</th>
                <td class="left" colspan="8">
                    <input type="file" id="file3" name="file3" class="w70p"/>
                </td>
            </tr>
            <tr>
                <th>이미지4</th>
                <td class="left" colspan="8">
                    <input type="file" id="file4" name="file4" class="w70p"/>
                </td>
            </tr>
            <br>
        </table>
        <div style="margin-top:20px;" class="center">
            <input type="submit" value="등록" class="Button btnGreen w100"> &nbsp;
        </div>
    </form>
</div>