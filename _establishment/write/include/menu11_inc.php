<?php if(!defined('menu_establishment')) exit;


$sql = "select * from {$none['est_nomu']} where nw_code = '{$work['nw_code']}' and  ne_date = '{$date}' order by seq asc";
$rst = sql_query($sql);
$chk = sql_fetch($sql);

include('./include/a_update_table.php');
include('./include/file_upload_table.php');
?>
<style>
.numb { text-align:right; padding-right:5px }
.bg_grey { background:#f2f2f2 !important}
.text-right {  padding-right:5px !important}
</style>
<form name="frm" action="./update/inc/menu11_update.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="mode" value="<?php echo $mode?>">
<input type="hidden" name="nw_code" id="nw_code" value="<?php echo $work['nw_code']?>">
<input type="hidden" name="ne_date" value="<?php echo $date?>">
<div class="print_frm">
<?php if($chk) {
	
	while($row=sql_fetch_array($rst)) {
?>


 <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0" style="width:1300px;margin-top:30px">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <col class="col11">
        <col class="col12">
        <col class="col13">
        <col class="col14">
        <col class="col15">
        <col class="col16">
        <col class="col17">
        <col class="col18">
        <col class="col19">
        <col class="col20">
        <col class="col21">
        <col class="col22">
        <col class="col23">
        <col class="col24">
        <col class="col25">
        <col class="col26">
        <col class="col27">
        <col class="col28">
        <col class="col29">
        <col class="col30">
        <col class="col31">
        <col class="col32">
        <col class="col33">
        <col class="col34">
        <col class="col35">
        <col class="col36">
        <col class="col37">
        <col class="col38">
        <col class="col39">
        <col class="col40">
        <col class="col41">
        <col class="col42">
        <col class="col43">
        <col class="col44">
        <col class="col45">
        <col class="col46">
        <col class="col47">
        <col class="col48">
        <col class="col49">
        <col class="col50">
        <col class="col51">
        <col class="col52">
        <col class="col53">
        <col class="col54">
        <col class="col55">
        <tbody>
          <tr class="row0">
            <td class="column0 style17 s style17" colspan="56">노 무 비  사  용  내  역  서</td>
          
          </tr>
         
          <tr class="row3">
            <td class="column0 style16 null"></td>
            <td class="column1 style16 null"></td>
            <td class="column2 style16 null"></td>
            <td class="column3 style16 null"></td>
            <td class="column4 style16 null"></td>
            <td class="column5 style16 null"></td>
            <td class="column6 style16 null"></td>
            <td class="column7 style16 null"></td>
            <td class="column8 style16 null"></td>
            <td class="column9 style16 null"></td>
            <td class="column10 style16 null"></td>
            <td class="column11 style16 null"></td>
            <td class="column12 style16 null"></td>
            <td class="column13 style16 null"></td>
            <td class="column14 style16 null"></td>
            <td class="column15 style16 null"></td>
            <td class="column16 style16 null"></td>
            <td class="column17 style16 null"></td>
            <td class="column18 style16 null"></td>
            <td class="column19 style16 null"></td>
            <td class="column20 style16 null"></td>
            <td class="column21 style16 null"></td>
            <td class="column22 style16 null"></td>
            <td class="column23 style16 null"></td>
            <td class="column24 style16 null"></td>
            <td class="column25 style16 null"></td>
            <td class="column26 style16 null"></td>
            <td class="column27 style16 null"></td>
            <td class="column28 style16 null"></td>
            <td class="column29 style16 null"></td>
            <td class="column30 style16 null"></td>
            <td class="column31 style16 null"></td>
            <td class="column32 style16 null"></td>
            <td class="column33 style16 null"></td>
            <td class="column34 style16 null"></td>
            <td class="column35 style16 null"></td>
            <td class="column36 style16 null"></td>
            <td class="column37 style16 null"></td>
            <td class="column38 style16 null"></td>
            <td class="column39 style16 null"></td>
            <td class="column40 style16 null"></td>
            <td class="column41 style16 null"></td>
            <td class="column42 style16 null"></td>
            <td class="column43 style16 null"></td>
            <td class="column44 style16 null"></td>
            <td class="column45 style16 null"></td>
            <td class="column46 style16 null"></td>
            <td class="column47 style16 null"></td>
            <td class="column48 style16 null"></td>
            <td class="column49 style16 null"></td>
            <td class="column50 style16 null"></td>
            <td class="column51 style16 null"></td>
            <td class="column52 style16 null"></td>
            <td class="column53 style16 null"></td>
            <td class="column54 style16 null"></td>
            <td class="column55 style16 null"></td>
          
          </tr>
          <tr class="row4">
            <td class="column0 style107 s style109" colspan="4">현 장 명</td>
            <td class="column4 style104 null style106" colspan="19">&nbsp;<?php echo $work['nw_subject']?></td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29">&nbsp;</td>
            <td class="column30">&nbsp;</td>
            <td class="column31">&nbsp;</td>
            <td class="column32">&nbsp;</td>
            <td class="column33">&nbsp;</td>
            <td class="column34">&nbsp;</td>
            <td class="column35">&nbsp;</td>
            <td class="column36">&nbsp;</td>
            <td class="column37">&nbsp;</td>
            <td class="column38">&nbsp;</td>
            <td class="column39">&nbsp;</td>
            <td class="column40">&nbsp;</td>
            <td class="column41">&nbsp;</td>
            <td class="column42">&nbsp;</td>
            <td class="column43">&nbsp;</td>
            <td class="column44">&nbsp;</td>
            <td class="column45">&nbsp;</td>
            <td class="column46">&nbsp;</td>
            <td class="column47">&nbsp;</td>
            <td class="column48">&nbsp;</td>
            <td class="column49">&nbsp;</td>
            <td class="column50">&nbsp;</td>
            <td class="column51">&nbsp;</td>
            <td class="column52">&nbsp;</td>
            <td class="column53">&nbsp;</td>
            <td class="column54">&nbsp;</td>
            <td class="column55">&nbsp;</td>
      
          </tr>
          <tr class="row5">
            <td class="column0 style96 s style98" colspan="4">업 체 명</td>
            <td class="column4 style93 null style95" colspan="19">
			<input type="hidden" name="seq[]" value="<?php echo $row['seq']?>">
			<input type="text" name="ne_upche[]" class="input ne_upche" value="<?php echo $row['ne_upche']?>" required>
			</td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29">&nbsp;</td>
            <td class="column30">&nbsp;</td>
            <td class="column31">&nbsp;</td>
            <td class="column32">&nbsp;</td>
            <td class="column33">&nbsp;</td>
            <td class="column34">&nbsp;</td>
            <td class="column35">&nbsp;</td>
            <td class="column36">&nbsp;</td>
            <td class="column37">&nbsp;</td>
            <td class="column38">&nbsp;</td>
            <td class="column39">&nbsp;</td>
            <td class="column40">&nbsp;</td>
            <td class="column41">&nbsp;</td>
            <td class="column42">&nbsp;</td>
            <td class="column43">&nbsp;</td>
            <td class="column44">&nbsp;</td>
            <td class="column45">&nbsp;</td>
            <td class="column46">&nbsp;</td>
            <td class="column47">&nbsp;</td>
            <td class="column48">&nbsp;</td>
            <td class="column49">&nbsp;</td>
            <td class="column50">&nbsp;</td>
            <td class="column51">&nbsp;</td>
            <td class="column52">&nbsp;</td>
            <td class="column53">&nbsp;</td>
            <td class="column54">&nbsp;</td>
            <td class="column55">&nbsp;</td>
           
          </tr>
          <tr class="row6">
            <td class="column0 style96 s style98" colspan="4">공 종 명</td>
            <td class="column4 style93 null style95" colspan="19"><input type="text" name="ne_gongjong[]" class="input ne_gongjong " value="<?php echo $row['ne_gongjong']?>"></td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29">&nbsp;</td>
            <td class="column30">&nbsp;</td>
            <td class="column31">&nbsp;</td>
            <td class="column32">&nbsp;</td>
            <td class="column33">&nbsp;</td>
            <td class="column34">&nbsp;</td>
            <td class="column35">&nbsp;</td>
            <td class="column36">&nbsp;</td>
            <td class="column37">&nbsp;</td>
            <td class="column38">&nbsp;</td>
            <td class="column39">&nbsp;</td>
            <td class="column40">&nbsp;</td>
            <td class="column41">&nbsp;</td>
            <td class="column42">&nbsp;</td>
            <td class="column43">&nbsp;</td>
            <td class="column44">&nbsp;</td>
            <td class="column45">&nbsp;</td>
            <td class="column46">&nbsp;</td>
            <td class="column47">&nbsp;</td>
            <td class="column48">&nbsp;</td>
            <td class="column49">&nbsp;</td>
            <td class="column50">&nbsp;</td>
            <td class="column51">&nbsp;</td>
            <td class="column52">&nbsp;</td>
            <td class="column53">&nbsp;</td>
            <td class="column54">&nbsp;</td>
            <td class="column55">&nbsp;</td>
            
          </tr>
          <tr class="row7">
            <td class="column0 style61 s style60" colspan="4">청구기간</td>
            <td class="column4 style102 null style103" colspan="7"><?php echo $date?>-01</td>
            <td class="column11 style59 s style59" colspan="2">~</td>
            <td class="column13 style103 null style103" colspan="7"><?php echo $date?>-<?php echo date('t')?></td>
            <td class="column20 style14 null"></td>
            <td class="column21 style14 null"></td>
            <td class="column22 style13 null"></td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29">&nbsp;</td>
            <td class="column30">&nbsp;</td>
            <td class="column31">&nbsp;</td>
            <td class="column32">&nbsp;</td>
            <td class="column33">&nbsp;</td>
            <td class="column34">&nbsp;</td>
            <td class="column35">&nbsp;</td>
            <td class="column36">&nbsp;</td>
            <td class="column37">&nbsp;</td>
            <td class="column38">&nbsp;</td>
            <td class="column39">&nbsp;</td>
            <td class="column40">&nbsp;</td>
            <td class="column41">&nbsp;</td>
            <td class="column42">&nbsp;</td>
            <td class="column43">&nbsp;</td>
            <td class="column44">&nbsp;</td>
            <td class="column45">&nbsp;</td>
            <td class="column46">&nbsp;</td>
            <td class="column47">&nbsp;</td>
            <td class="column48">&nbsp;</td>
            <td class="column49">&nbsp;</td>
            <td class="column50">&nbsp;</td>
            <td class="column51">&nbsp;</td>
            <td class="column52">&nbsp;</td>
            <td class="column53">&nbsp;</td>
            <td class="column54">&nbsp;</td>
            <td class="column55">&nbsp;</td>
            
          </tr>
          <tr class="row8">
            <td class="column0 style99 s style101" colspan="56">노  무  비  내  역</td>
            
          </tr>
          <tr class="row9">
            <td class="column0 style2 s style22" colspan="3" rowspan="2">구  분</td>
            <td class="column3 style2 s style22" colspan="5" rowspan="2">공  종 &amp; 업체명</td>
            <td class="column8 style69 s style74" colspan="5" rowspan="2">노무비금액</td>
            <td class="column13 style63 s style65" colspan="29">차  감  금  액  내  역</td>
            <td class="column42 style69 s style74" colspan="5" rowspan="2">차감후 금액</td>
            <td class="column47 style2 s style22" colspan="9" rowspan="2">비            고</td>
            
          </tr>
          <tr class="row10">
            <td class="column13 style61 s style62" colspan="4">국민연금</td>
            <td class="column17 style58 s style62" colspan="4">건강보험</td>
            <td class="column21 style58 s style62" colspan="4">장기요양</td>
            <td class="column25 style58 s style62" colspan="4">고용보험</td>
            <td class="column29 style58 s style62" colspan="4">소득세</td>
            <td class="column33 style58 s style60" colspan="4">지방소득세</td>
            <td class="column37 style66 s style68" colspan="5">차 감 계</td>
            
          </tr>
		  <?php for($i=0; $i<10; $i++) {
			  $detail_arr = explode('|', $row['ne_detail']);
			  $detail_row = explode('^', $detail_arr[$i]);
			  
		?>
          <tr class="row11">
            <td class="column0 style90 null style92" colspan="3"><input type="text" name="ne_detail_gubun[<?php echo $i?>][]" class="input ne_detail_gubun" value="<?php echo $detail_row[0]?>"></td>
            <td class="column3 style90 null style92" colspan="5"><input type="text" name="ne_detail_gongjong[<?php echo $i?>][]" class="input ne_detail_gongjong" value="<?php echo $detail_row[1]?>"></td>
            <td class="column8 style80 null style82" colspan="5"><input type="text" name="ne_detail_price1[<?php echo $i?>][]" class="input ne_detail_price1 numb" value="<?php echo number_format($detail_row[2])?>"></td>
            <td class="column13 style83 null style78" colspan="4"><input type="text" name="ne_detail_price2[<?php echo $i?>][]" class="input ne_detail_price2 numb" value="<?php echo number_format($detail_row[3])?>"></td>
            <td class="column17 style76 null style78" colspan="4"><input type="text" name="ne_detail_price3[<?php echo $i?>][]" class="input ne_detail_price3 numb" value="<?php echo number_format($detail_row[4])?>"></td>
            <td class="column21 style76 null style78" colspan="4"><input type="text" name="ne_detail_price4[<?php echo $i?>][]" class="input ne_detail_price4 numb" value="<?php echo number_format($detail_row[5])?>"></td>
            <td class="column25 style76 null style78" colspan="4"><input type="text" name="ne_detail_price5[<?php echo $i?>][]" class="input ne_detail_price5 numb" value="<?php echo number_format($detail_row[6])?>"></td>
            <td class="column29 style76 null style78" colspan="4"><input type="text" name="ne_detail_price6[<?php echo $i?>][]" class="input ne_detail_price6 numb" value="<?php echo number_format($detail_row[7])?>"></td>
            <td class="column33 style76 null style79" colspan="4"><input type="text" name="ne_detail_price7[<?php echo $i?>][]" class="input ne_detail_price7 numb" value="<?php echo number_format($detail_row[8])?>"></td>
            <td class="column37 style87 null style89" colspan="5"><input type="text" name="ne_detail_price8[<?php echo $i?>][]" class="input ne_detail_price8 numb" value="<?php echo number_format($detail_row[9])?>" readonly></td>
            <td class="column42 style80 null style82" colspan="5"><input type="text" name="ne_detail_price9[<?php echo $i?>][]" class="input ne_detail_price9 numb" value="<?php echo number_format($detail_row[10])?>" readonly></td>
            <td class="column47 style84 null style86" colspan="9"><input type="text" name="ne_detail_etc[<?php echo $i?>][]" class="input ne_detail_etc" value="<?php echo $detail_row[11]?>"></td>
         
          </tr>
		  <?php 
			$price1 += $detail_row[0];
			$price2 += $detail_row[1];
			$price3 += $detail_row[2];
			$price4 += $detail_row[3];
			$price5 += $detail_row[4];
			$price6 += $detail_row[5];
			$price7 += $detail_row[6];
			$price8 += $detail_row[7];
			$price9 += $detail_row[8];
		  
		  
		  }?>
        
        
          <tr class="row32">
            <td class="column0 style4 s style15" colspan="8">계</td>
            <td class="column8 style36 null style38 text-right" colspan="5"><?php echo number_format($price1)?></td>
            <td class="column13 style35 null style34 text-right" colspan="4"><?php echo number_format($price2)?></td>
            <td class="column17 style32 null style34 text-right" colspan="4"><?php echo number_format($price3)?></td>
            <td class="column21 style32 null style34 text-right" colspan="4"><?php echo number_format($price4)?></td>
            <td class="column25 style32 null style34 text-right" colspan="4"><?php echo number_format($price5)?></td>
            <td class="column29 style32 null style34 text-right" colspan="4"><?php echo number_format($price6)?></td>
            <td class="column33 style32 null style43 text-right" colspan="4"><?php echo number_format($price7)?></td>
            <td class="column37 style40 null style42 text-right" colspan="5"><?php echo number_format($price8)?></td>
            <td class="column42 style36 null style38 text-right" colspan="5"><?php echo number_format($price9)?></td>
            <td class="column47 style4 null style15" colspan="9"></td>
            
          </tr>
          <tr class="row33">
            <td class="column0 style2 s style23" colspan="4" style="border-bottom:1px solid #000;background:#f2f2f2;text-align:left">특기사항</td>
            <td class="column4 style24 null style24" colspan="52" style="border-right:1px solid #000;border-bottom:1px solid #000;background:#f2f2f2"></td>
            
          </tr>
          <tr class="row34">
            <td class="column0 style18 null style19" colspan="56" rowspan="5" style="border-right:1px solid #000;border-bottom:1px solid #000">
			<textarea name="ne_etc[]" style="width:100%;border:0"><?php echo $row['ne_etc']?></textarea>
			</td>
            
          </tr>
         
        </tbody>
    </table>
	
	<?php 
	$qty_total = $danga_total = $price_total = $vat_total = $all_total = 0;

	}//while end
} else {?>
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0" style="width:1300px;margin-top:30px">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <col class="col11">
        <col class="col12">
        <col class="col13">
        <col class="col14">
        <col class="col15">
        <col class="col16">
        <col class="col17">
        <col class="col18">
        <col class="col19">
        <col class="col20">
        <col class="col21">
        <col class="col22">
        <col class="col23">
        <col class="col24">
        <col class="col25">
        <col class="col26">
        <col class="col27">
        <col class="col28">
        <col class="col29">
        <col class="col30">
        <col class="col31">
        <col class="col32">
        <col class="col33">
        <col class="col34">
        <col class="col35">
        <col class="col36">
        <col class="col37">
        <col class="col38">
        <col class="col39">
        <col class="col40">
        <col class="col41">
        <col class="col42">
        <col class="col43">
        <col class="col44">
        <col class="col45">
        <col class="col46">
        <col class="col47">
        <col class="col48">
        <col class="col49">
        <col class="col50">
        <col class="col51">
        <col class="col52">
        <col class="col53">
        <col class="col54">
        <col class="col55">
        <tbody>
          <tr class="row0">
            <td class="column0 style17 s style17" colspan="56">노 무 비  사  용  내  역  서</td>
          
          </tr>
         
          <tr class="row3">
            <td class="column0 style16 null"></td>
            <td class="column1 style16 null"></td>
            <td class="column2 style16 null"></td>
            <td class="column3 style16 null"></td>
            <td class="column4 style16 null"></td>
            <td class="column5 style16 null"></td>
            <td class="column6 style16 null"></td>
            <td class="column7 style16 null"></td>
            <td class="column8 style16 null"></td>
            <td class="column9 style16 null"></td>
            <td class="column10 style16 null"></td>
            <td class="column11 style16 null"></td>
            <td class="column12 style16 null"></td>
            <td class="column13 style16 null"></td>
            <td class="column14 style16 null"></td>
            <td class="column15 style16 null"></td>
            <td class="column16 style16 null"></td>
            <td class="column17 style16 null"></td>
            <td class="column18 style16 null"></td>
            <td class="column19 style16 null"></td>
            <td class="column20 style16 null"></td>
            <td class="column21 style16 null"></td>
            <td class="column22 style16 null"></td>
            <td class="column23 style16 null"></td>
            <td class="column24 style16 null"></td>
            <td class="column25 style16 null"></td>
            <td class="column26 style16 null"></td>
            <td class="column27 style16 null"></td>
            <td class="column28 style16 null"></td>
            <td class="column29 style16 null"></td>
            <td class="column30 style16 null"></td>
            <td class="column31 style16 null"></td>
            <td class="column32 style16 null"></td>
            <td class="column33 style16 null"></td>
            <td class="column34 style16 null"></td>
            <td class="column35 style16 null"></td>
            <td class="column36 style16 null"></td>
            <td class="column37 style16 null"></td>
            <td class="column38 style16 null"></td>
            <td class="column39 style16 null"></td>
            <td class="column40 style16 null"></td>
            <td class="column41 style16 null"></td>
            <td class="column42 style16 null"></td>
            <td class="column43 style16 null"></td>
            <td class="column44 style16 null"></td>
            <td class="column45 style16 null"></td>
            <td class="column46 style16 null"></td>
            <td class="column47 style16 null"></td>
            <td class="column48 style16 null"></td>
            <td class="column49 style16 null"></td>
            <td class="column50 style16 null"></td>
            <td class="column51 style16 null"></td>
            <td class="column52 style16 null"></td>
            <td class="column53 style16 null"></td>
            <td class="column54 style16 null"></td>
            <td class="column55 style16 null"></td>
          
          </tr>
          <tr class="row4">
            <td class="column0 style107 s style109" colspan="4">현 장 명</td>
            <td class="column4 style104 null style106" colspan="19">&nbsp;<?php echo $work['nw_subject']?></td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29">&nbsp;</td>
            <td class="column30">&nbsp;</td>
            <td class="column31">&nbsp;</td>
            <td class="column32">&nbsp;</td>
            <td class="column33">&nbsp;</td>
            <td class="column34">&nbsp;</td>
            <td class="column35">&nbsp;</td>
            <td class="column36">&nbsp;</td>
            <td class="column37">&nbsp;</td>
            <td class="column38">&nbsp;</td>
            <td class="column39">&nbsp;</td>
            <td class="column40">&nbsp;</td>
            <td class="column41">&nbsp;</td>
            <td class="column42">&nbsp;</td>
            <td class="column43">&nbsp;</td>
            <td class="column44">&nbsp;</td>
            <td class="column45">&nbsp;</td>
            <td class="column46">&nbsp;</td>
            <td class="column47">&nbsp;</td>
            <td class="column48">&nbsp;</td>
            <td class="column49">&nbsp;</td>
            <td class="column50">&nbsp;</td>
            <td class="column51">&nbsp;</td>
            <td class="column52">&nbsp;</td>
            <td class="column53">&nbsp;</td>
            <td class="column54">&nbsp;</td>
            <td class="column55">&nbsp;</td>
      
          </tr>
          <tr class="row5">
            <td class="column0 style96 s style98" colspan="4">업 체 명</td>
            <td class="column4 style93 null style95" colspan="19">
			<input type="hidden" name="seq[]" value="<?php echo $row['seq']?>">
			<input type="text" name="ne_upche[]" class="input ne_upche" value="<?php echo $row['ne_upche']?>" required>
			</td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29">&nbsp;</td>
            <td class="column30">&nbsp;</td>
            <td class="column31">&nbsp;</td>
            <td class="column32">&nbsp;</td>
            <td class="column33">&nbsp;</td>
            <td class="column34">&nbsp;</td>
            <td class="column35">&nbsp;</td>
            <td class="column36">&nbsp;</td>
            <td class="column37">&nbsp;</td>
            <td class="column38">&nbsp;</td>
            <td class="column39">&nbsp;</td>
            <td class="column40">&nbsp;</td>
            <td class="column41">&nbsp;</td>
            <td class="column42">&nbsp;</td>
            <td class="column43">&nbsp;</td>
            <td class="column44">&nbsp;</td>
            <td class="column45">&nbsp;</td>
            <td class="column46">&nbsp;</td>
            <td class="column47">&nbsp;</td>
            <td class="column48">&nbsp;</td>
            <td class="column49">&nbsp;</td>
            <td class="column50">&nbsp;</td>
            <td class="column51">&nbsp;</td>
            <td class="column52">&nbsp;</td>
            <td class="column53">&nbsp;</td>
            <td class="column54">&nbsp;</td>
            <td class="column55">&nbsp;</td>
           
          </tr>
          <tr class="row6">
            <td class="column0 style96 s style98" colspan="4">공 종 명</td>
            <td class="column4 style93 null style95" colspan="19"><input type="text" name="ne_gongjong[]" class="input ne_gongjong " value="<?php echo $row['ne_gongjong']?>"></td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29">&nbsp;</td>
            <td class="column30">&nbsp;</td>
            <td class="column31">&nbsp;</td>
            <td class="column32">&nbsp;</td>
            <td class="column33">&nbsp;</td>
            <td class="column34">&nbsp;</td>
            <td class="column35">&nbsp;</td>
            <td class="column36">&nbsp;</td>
            <td class="column37">&nbsp;</td>
            <td class="column38">&nbsp;</td>
            <td class="column39">&nbsp;</td>
            <td class="column40">&nbsp;</td>
            <td class="column41">&nbsp;</td>
            <td class="column42">&nbsp;</td>
            <td class="column43">&nbsp;</td>
            <td class="column44">&nbsp;</td>
            <td class="column45">&nbsp;</td>
            <td class="column46">&nbsp;</td>
            <td class="column47">&nbsp;</td>
            <td class="column48">&nbsp;</td>
            <td class="column49">&nbsp;</td>
            <td class="column50">&nbsp;</td>
            <td class="column51">&nbsp;</td>
            <td class="column52">&nbsp;</td>
            <td class="column53">&nbsp;</td>
            <td class="column54">&nbsp;</td>
            <td class="column55">&nbsp;</td>
            
          </tr>
          <tr class="row7">
            <td class="column0 style61 s style60" colspan="4">청구기간</td>
            <td class="column4 style102 null style103" colspan="7"><?php echo $date?>-01</td>
            <td class="column11 style59 s style59" colspan="2">~</td>
            <td class="column13 style103 null style103" colspan="7"><?php echo $date?>-<?php echo date('t')?></td>
            <td class="column20 style14 null"></td>
            <td class="column21 style14 null"></td>
            <td class="column22 style13 null"></td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29">&nbsp;</td>
            <td class="column30">&nbsp;</td>
            <td class="column31">&nbsp;</td>
            <td class="column32">&nbsp;</td>
            <td class="column33">&nbsp;</td>
            <td class="column34">&nbsp;</td>
            <td class="column35">&nbsp;</td>
            <td class="column36">&nbsp;</td>
            <td class="column37">&nbsp;</td>
            <td class="column38">&nbsp;</td>
            <td class="column39">&nbsp;</td>
            <td class="column40">&nbsp;</td>
            <td class="column41">&nbsp;</td>
            <td class="column42">&nbsp;</td>
            <td class="column43">&nbsp;</td>
            <td class="column44">&nbsp;</td>
            <td class="column45">&nbsp;</td>
            <td class="column46">&nbsp;</td>
            <td class="column47">&nbsp;</td>
            <td class="column48">&nbsp;</td>
            <td class="column49">&nbsp;</td>
            <td class="column50">&nbsp;</td>
            <td class="column51">&nbsp;</td>
            <td class="column52">&nbsp;</td>
            <td class="column53">&nbsp;</td>
            <td class="column54">&nbsp;</td>
            <td class="column55">&nbsp;</td>
            
          </tr>
          <tr class="row8">
            <td class="column0 style99 s style101" colspan="56">노  무  비  내  역</td>
            
          </tr>
          <tr class="row9">
            <td class="column0 style2 s style22" colspan="3" rowspan="2">구  분</td>
            <td class="column3 style2 s style22" colspan="5" rowspan="2">공  종 &amp; 업체명</td>
            <td class="column8 style69 s style74" colspan="5" rowspan="2">노무비금액</td>
            <td class="column13 style63 s style65" colspan="29">차  감  금  액  내  역</td>
            <td class="column42 style69 s style74" colspan="5" rowspan="2">차감후 금액</td>
            <td class="column47 style2 s style22" colspan="9" rowspan="2">비            고</td>
            
          </tr>
          <tr class="row10">
            <td class="column13 style61 s style62" colspan="4">국민연금</td>
            <td class="column17 style58 s style62" colspan="4">건강보험</td>
            <td class="column21 style58 s style62" colspan="4">장기요양</td>
            <td class="column25 style58 s style62" colspan="4">고용보험</td>
            <td class="column29 style58 s style62" colspan="4">소득세</td>
            <td class="column33 style58 s style60" colspan="4">지방소득세</td>
            <td class="column37 style66 s style68" colspan="5">차 감 계</td>
            
          </tr>
		  <?php for($i=0; $i<10; $i++) {
			 
		?>
          <tr class="row11">
            <td class="column0 style90 null style92" colspan="3"><input type="text" name="ne_detail_gubun[<?php echo $i?>][]" class="input ne_detail_gubun" value="<?php echo $detail_row[0]?>"></td>
            <td class="column3 style90 null style92" colspan="5"><input type="text" name="ne_detail_gongjong[<?php echo $i?>][]" class="input ne_detail_gongjong" value="<?php echo $detail_row[1]?>"></td>
            <td class="column8 style80 null style82" colspan="5"><input type="text" name="ne_detail_price1[<?php echo $i?>][]" class="input ne_detail_price1 numb" value="<?php echo $detail_row[2]?>"></td>
            <td class="column13 style83 null style78" colspan="4"><input type="text" name="ne_detail_price2[<?php echo $i?>][]" class="input ne_detail_price2 numb" value="<?php echo $detail_row[3]?>"></td>
            <td class="column17 style76 null style78" colspan="4"><input type="text" name="ne_detail_price3[<?php echo $i?>][]" class="input ne_detail_price3 numb" value="<?php echo $detail_row[4]?>"></td>
            <td class="column21 style76 null style78" colspan="4"><input type="text" name="ne_detail_price4[<?php echo $i?>][]" class="input ne_detail_price4 numb" value="<?php echo $detail_row[5]?>"></td>
            <td class="column25 style76 null style78" colspan="4"><input type="text" name="ne_detail_price5[<?php echo $i?>][]" class="input ne_detail_price5 numb" value="<?php echo $detail_row[6]?>"></td>
            <td class="column29 style76 null style78" colspan="4"><input type="text" name="ne_detail_price6[<?php echo $i?>][]" class="input ne_detail_price6 numb" value="<?php echo $detail_row[7]?>"></td>
            <td class="column33 style76 null style79" colspan="4"><input type="text" name="ne_detail_price7[<?php echo $i?>][]" class="input ne_detail_price7 numb" value="<?php echo $detail_row[8]?>"></td>
            <td class="column37 style87 null style89" colspan="5"><input type="text" name="ne_detail_price8[<?php echo $i?>][]" class="input ne_detail_price8 numb" value="<?php echo $detail_row[9]?>" readonly></td>
            <td class="column42 style80 null style82" colspan="5"><input type="text" name="ne_detail_price9[<?php echo $i?>][]" class="input ne_detail_price9 numb" value="<?php echo $detail_row[10]?>" readonly></td>
            <td class="column47 style84 null style86" colspan="9"><input type="text" name="ne_detail_etc[<?php echo $i?>][]" class="input ne_detail_etc" value="<?php echo $detail_row[11]?>"></td>
         
          </tr>
		  <?php 
		  
		  
		  }?>
        
        
          <tr class="row32">
            <td class="column0 style4 s style15" colspan="8">계</td>
            <td class="column8 style36 null style38" colspan="5"></td>
            <td class="column13 style35 null style34" colspan="4"></td>
            <td class="column17 style32 null style34" colspan="4"></td>
            <td class="column21 style32 null style34" colspan="4"></td>
            <td class="column25 style32 null style34" colspan="4"></td>
            <td class="column29 style32 null style34" colspan="4"></td>
            <td class="column33 style32 null style43" colspan="4"></td>
            <td class="column37 style40 null style42" colspan="5"></td>
            <td class="column42 style36 null style38" colspan="5"></td>
            <td class="column47 style4 null style15" colspan="9"></td>
            
          </tr>
          <tr class="row33">
            <td class="column0 style2 s style23" colspan="4" style="border-bottom:1px solid #000;background:#f2f2f2;text-align:left">특기사항</td>
            <td class="column4 style24 null style24" colspan="52" style="border-right:1px solid #000;border-bottom:1px solid #000;background:#f2f2f2"></td>
            
          </tr>
          <tr class="row34">
            <td class="column0 style18 null style19" colspan="56" rowspan="5" style="border-right:1px solid #000;border-bottom:1px solid #000">
			<textarea name="ne_etc[]" style="width:100%;border:0"><?php echo $row['ne_etc']?></textarea>
			</td>
            
          </tr>
         
        </tbody>
    </table>

<?php }?>
	</div>
	<div id="copybox" style="display:none"><?php include_once('./include/menu11_inc_copy.php');?></div>
	<div id="add_tb_box"></div>
	
	<div class="modal-footer">
		
		<button type="button" class="btn btn-secondary" onclick="onPrint()" data-dismiss="modal">인쇄</button>
		<button type="button" class="btn btn-secondary"  data-dismiss="modal" id="add_tables">표 추가</button>
		<button type="submit" class="btn btn-primary"data-dismiss="modal">업데이트</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="location.href ='/_establishment/list/menu1_list.php'">목록</button>
	</div>
</form>