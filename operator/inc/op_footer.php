<div class="footer_scroller">
	<div class="inner">
		<div class="scroller">
			<ul id="ft_precleaning">
      <?php
      $f_qry  = " SELECT t1.PS_CODE, t1.PS_STATUS, t1.REG_DATE, IFNULL(t2.PRE_STATUS,1) as preStatus ";
      $f_qry .= " FROM {$TB_PS} t1   ";
      $f_qry .= " LEFT JOIN {$TB_PS_PRECLEANING} t2 ON (t1.PS_CODE = t2.PS_CODE)  ";
      $f_qry .= " LEFT JOIN {$TB_PS_IMAGE} t3 ON (t1.PS_CODE = t3.PS_CODE)  ";
      $f_qry .= " WHERE t1.PS_STATUS = 1 AND t1.SEND_TYPE = 1 ";
      $f_qry .= " ORDER BY t1.REG_DATE desc";
      
      $f_res = $db->exec_sql($f_qry);
      while ($f_row = $db->sql_fetch_array($f_res)) {
        if ($f_row["preStatus"] == 1 || $f_row["preStatus"] == 4) {
          ?>
          <li>
            <?php
            echo $pre_status_array[$f_row["preStatus"]]; 
            if ($f_row["PS_CODE"] > 1) {
              ?> / 김말동<?
            }
            ?>
            <br>
            <b><?= $f_row["PS_CODE"] ?></b><br>
            <?= $f_row["REG_DATE"] ?>
          </li>
          <?
        }
      }
      ?>
			</ul>
		</div>
	</div>
</div>

<script>

	var scrollBt = $('.inner ul').outerHeight()
	var coNhei = $('.footer_scroller').height()

	$('.inner').css('height', coNhei);
	$('.scroller').css('max-height', coNhei);
	$('.inner .scroller').scrollTop(scrollBt);

	$(window).resize(function(){
		var coNhei = $('.footer_scroller').height()

		$('.inner').css('height', coNhei);
		$('.scroller').css('max-height', coNhei);
	});

  // 자동실행시키는 함수
  setInterval(function() {
    aync_prescription();   
  }, 5000);

  function aync_prescription() {

        $.ajax({
            method: 'POST',
            url: './_action/redraw.do.php',
            processData: false,
            contentType: false,
            data: "",
            success: function (_res) {
                //console.log(_res) ;

                $("#ft_precleaning").html(_res);

                var lilen = $('.inner ul li').length * 10 ;
                var scrollBt = $('.inner .scroller').scrollTop() + $('.inner ul').outerHeight() + lilen ;
                $('.inner .scroller').scrollTop(scrollBt);

            }
        });

    
  }

</script>

<div id="footer">
	© 2019 이팜헬스케어 Co., Ltd. All rights reserved. 
</div><!-- footer e -->
<iframe id="actionForm" name="actionForm" width="0" height="0" style="display:none;"></iframe>