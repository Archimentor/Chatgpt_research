<?php if(!defined('menu_establishment')) exit;

$sql = "select * from {$none['est_material']} where nw_code = '{$work['nw_code']}' and  ne_date = '{$date}' order by seq asc";
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


<form name="frm" action="./update/inc/menu9_update.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="mode" value="<?php echo $mode?>">
<input type="hidden" name="nw_code" id="nw_code" value="<?php echo $work['nw_code']?>">
<input type="hidden" name="ne_date" value="<?php echo $date?>">

<div class="print_frm">

<?php if($chk) {
	
	while($row=sql_fetch_array($rst)) {
?>

<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">
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
        <col class="col56">
        <tbody>
          <tr class="row0">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
            <td class="column11">&nbsp;</td>
            <td class="column12">&nbsp;</td>
            <td class="column13">&nbsp;</td>
            <td class="column14">&nbsp;</td>
            <td class="column15">&nbsp;</td>
            <td class="column16">&nbsp;</td>
            <td class="column17">&nbsp;</td>
            <td class="column18">&nbsp;</td>
            <td class="column19">&nbsp;</td>
            <td class="column20">&nbsp;</td>
            <td class="column21">&nbsp;</td>
            <td class="column22">&nbsp;</td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row1">
            <td class="column0">&nbsp;</td>
            <td class="column1 style5 s style5" colspan="56" rowspan="3">자  재  사  용  내  역  서</td>
          </tr>
          <tr class="row2">
            <td class="column0">&nbsp;</td>
          </tr>
          <tr class="row3">
            <td class="column0">&nbsp;</td>
          </tr>
          <tr class="row4">
            <td class="column0">&nbsp;</td>
            <td class="column1 style4 null"></td>
            <td class="column2 style4 null"></td>
            <td class="column3 style4 null"></td>
            <td class="column4 style4 null"></td>
            <td class="column5 style4 null"></td>
            <td class="column6 style4 null"></td>
            <td class="column7 style4 null"></td>
            <td class="column8 style4 null"></td>
            <td class="column9 style4 null"></td>
            <td class="column10 style4 null"></td>
            <td class="column11 style4 null"></td>
            <td class="column12 style4 null"></td>
            <td class="column13 style4 null"></td>
            <td class="column14 style4 null"></td>
            <td class="column15 style4 null"></td>
            <td class="column16 style4 null"></td>
            <td class="column17 style4 null"></td>
            <td class="column18 style4 null"></td>
            <td class="column19 style4 null"></td>
            <td class="column20 style4 null"></td>
            <td class="column21 style4 null"></td>
            <td class="column22 style4 null"></td>
            <td class="column23 style4 null"></td>
            <td class="column24 style4 null"></td>
            <td class="column25 style4 null"></td>
            <td class="column26 style4 null"></td>
            <td class="column27 style4 null"></td>
            <td class="column28 style4 null"></td>
            <td class="column29 style4 null"></td>
            <td class="column30 style4 null"></td>
            <td class="column31 style4 null"></td>
            <td class="column32 style4 null"></td>
            <td class="column33 style4 null"></td>
            <td class="column34 style4 null"></td>
            <td class="column35 style4 null"></td>
            <td class="column36 style4 null"></td>
            <td class="column37 style4 null"></td>
            <td class="column38 style4 null"></td>
            <td class="column39 style4 null"></td>
            <td class="column40 style4 null"></td>
            <td class="column41 style4 null"></td>
            <td class="column42 style4 null"></td>
            <td class="column43 style4 null"></td>
            <td class="column44 style4 null"></td>
            <td class="column45 style4 null"></td>
            <td class="column46 style4 null"></td>
            <td class="column47 style4 null"></td>
            <td class="column48 style4 null"></td>
            <td class="column49 style4 null"></td>
            <td class="column50 style4 null"></td>
            <td class="column51 style4 null"></td>
            <td class="column52 style4 null"></td>
            <td class="column53 style4 null"></td>
            <td class="column54 style4 null"></td>
            <td class="column55 style4 null"></td>
            <td class="column56 style4 null"></td>
          </tr>
          <tr class="row5">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">현 장 명</td>
            <td class="column5 style6 null style7" colspan="19"> <?php echo $work['nw_subject']?></td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row6">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">업 체 명</td>
            <td class="column5 style8 null style9" colspan="19">
			<input type="hidden" name="seq[]" value="<?php echo $row['seq']?>">
			<input type="text" name="ne_upche[]" class="input ne_upche" value="<?php echo $row['ne_upche']?>"></td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row7">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">공 종 명</td>
            <td class="column5 style8 null style8" colspan="19"><input type="text" name="ne_gongjong[]" class="input ne_gongjong " value="<?php echo $row['ne_gongjong']?>"></td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row8">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">청구기간</td>
            <td class="column5 style10 null style11" colspan="7"><?php echo date('Y-m', strtotime($date))?>-01</td>
            <td class="column12 style12 s style12" colspan="2">~</td>
            <td class="column14 style11 null style11" colspan="7"><?php echo date('Y-m-t', strtotime($date))?></td>
            <td class="column21 style13 null"></td>
            <td class="column22 style13 null"></td>
            <td class="column23 style14 null"></td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row9">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="56">자   재   사   용   내   역</td>
          </tr>
          <tr class="row10">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="5">거래일자</td>
            <td class="column6 style2 s style2 bg_grey" colspan="7">품      명</td>
            <td class="column13 style2 s style2 bg_grey" colspan="5">규    격</td>
            <td class="column18 style2 s style2 bg_grey" colspan="2">단위</td>
            <td class="column20 style2 s style2 bg_grey" colspan="4">수  량</td>
            <td class="column24 style2 s style2 bg_grey" colspan="5">단    가</td>
            <td class="column29 style2 s style2 bg_grey" colspan="6">공급가액</td>
            <td class="column35 style2 s style2 bg_grey" colspan="6">부 가 세</td>
            <td class="column41 style2 s style2 bg_grey" colspan="6">합    계</td>
            <td class="column47 style2 s style2 bg_grey" colspan="10">비         고</td>
          </tr>
		  <?php
		  for($i=0; $i<25; $i++) {
			  
			  $detail_arr = explode('|', $row['ne_detail']);
			  $detail_row = explode('^', $detail_arr[$i]);
			  
		   ?>
          <tr class="row11">
            <td class="column0">&nbsp;</td>
		  <td class="column1 style15 null style16" colspan="5"><input type="date" name="ne_detail_date[<?php echo $i?>][]" class="input ne_detail_date" value="<?php echo $detail_row[0]?>"></td>
            <td class="column6 style16 null style16" colspan="7"><input type="text" name="ne_detail_name[<?php echo $i?>][]" class="input ne_detail_name"  value="<?php echo $detail_row[1]?>"></td>
            <td class="column13 style16 null style16" colspan="5"><input type="text" name="ne_detail_standard[<?php echo $i?>][]" class="input  ne_detail_standard"  value="<?php echo $detail_row[2]?>"></td>
            <td class="column18 style16 null style16" colspan="2"><input type="text" name="ne_detail_unit[<?php echo $i?>][]" class="input  ne_detail_unit"  value="<?php echo $detail_row[3]?>"></td>
            <td class="column20 style17 null style17" colspan="4"><input type="text" name="ne_detail_qty[<?php echo $i?>][]" class="input numb ne_detail_qty"  value="<?php echo $detail_row[4]?>"></td>
            <td class="column24 style17 null style17" colspan="5"><input type="text" name="ne_detail_danga[<?php echo $i?>][]" class="input numb ne_detail_danga"  value="<?php echo number_format($detail_row[5])?>"></td>
            <td class="column29 style17 null style17" colspan="6"><input type="text" name="ne_detail_price[<?php echo $i?>][]" class="input numb ne_detail_price"  value="<?php echo number_format($detail_row[6])?>"></td>
            <td class="column35 style17 null style17" colspan="6"><input type="text" name="ne_detail_vat[<?php echo $i?>][]" class="input numb ne_detail_vat"  value="<?php echo number_format($detail_row[7])?>"></td>
            <td class="column41 style17 null style17" colspan="6"><input type="text" name="ne_detail_total[<?php echo $i?>][]" class="input numb ne_detail_total"  value="<?php echo number_format($detail_row[8])?>"></td>
            <td class="column47 style18 null style16" colspan="10"><input type="text" name="ne_detail_etc[<?php echo $i?>][]" class="input ne_detail_etc"  value="<?php echo $detail_row[9]?>" style="width:95%"></td>
          </tr>
          <?php 
			$qty_total += $detail_row[4];
			$danga_total += $detail_row[5];
			$price_total += $detail_row[6];
			$vat_total += $detail_row[7];
			$all_total += $detail_row[8];
		  
		  }?>
          <tr class="row36">
            <td class="column0">&nbsp;</td>
            <td class="column1 style16 s style16 bg_grey" colspan="19">계</td>
            <td class="column20 style17 null style17 qty_total text-right" colspan="4"><?php echo $qty_total?></td>
            <td class="column24 style17 null style17 danga_total text-right" colspan="5"><?php echo number_format($danga_total)?></td>
            <td class="column29 style17 null style17 text-right price_total" colspan="6"><?php echo number_format($price_total)?></td>
            <td class="column35 style17 null style17 text-right vat_total" colspan="6"><?php echo number_format($vat_total)?></td>
            <td class="column41 style17 null style17 text-right total_total" colspan="6"><?php echo number_format($all_total)?></td>
            <td class="column47 style16 null style16 text-right" colspan="10"></td>
          </tr>
          <tr class="row37">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">첨 부 서류</td>
            <td class="column5 style2 s style2 bg_grey" colspan="4">첨부</td>
            <td class="column9 style2 s style21 bg_grey " colspan="49" style="font-family:'돋움체'; font-size:9pt"> 특기사항</td>
          </tr>
          <tr class="row38">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">세금계산서</td>
            <td class="column5 style2 null style2" colspan="4"><input type="text" name="ne_file1[]" class="input ne_file1"  value="<?php echo $row['ne_file1']?>"></td>
            <td class="column9 style6 null style6" colspan="48" rowspan="3">
			<textarea name="ne_etc[]" class="input" style="height:75px"><?php echo $row['ne_etc']?></textarea>
			</td>
          </tr>
          <tr class="row39">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">거래명세서</td>
            <td class="column5 style2 null style2" colspan="4"><input type="text" name="ne_file2[]" class="input ne_file2"  value="<?php echo $row['ne_file2']?>"></td>
          </tr>
          <tr class="row40">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">통 장 사본</td>
            <td class="column5 style2 null style2" colspan="4"><input type="text" name="ne_file3[]" class="input ne_file3"  value="<?php echo $row['ne_file3']?>"></td>
          </tr>
        </tbody>
    </table>



<?php 
	$qty_total = $danga_total = $price_total = $vat_total = $all_total = 0;

	}//while end
} else {?>

<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">
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
        <col class="col56">
        <tbody>
          <tr class="row0">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
            <td class="column11">&nbsp;</td>
            <td class="column12">&nbsp;</td>
            <td class="column13">&nbsp;</td>
            <td class="column14">&nbsp;</td>
            <td class="column15">&nbsp;</td>
            <td class="column16">&nbsp;</td>
            <td class="column17">&nbsp;</td>
            <td class="column18">&nbsp;</td>
            <td class="column19">&nbsp;</td>
            <td class="column20">&nbsp;</td>
            <td class="column21">&nbsp;</td>
            <td class="column22">&nbsp;</td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row1">
            <td class="column0">&nbsp;</td>
            <td class="column1 style5 s style5" colspan="56" rowspan="3">자  재  사  용  내  역  서</td>
          </tr>
          <tr class="row2">
            <td class="column0">&nbsp;</td>
          </tr>
          <tr class="row3">
            <td class="column0">&nbsp;</td>
          </tr>
          <tr class="row4">
            <td class="column0">&nbsp;</td>
            <td class="column1 style4 null"></td>
            <td class="column2 style4 null"></td>
            <td class="column3 style4 null"></td>
            <td class="column4 style4 null"></td>
            <td class="column5 style4 null"></td>
            <td class="column6 style4 null"></td>
            <td class="column7 style4 null"></td>
            <td class="column8 style4 null"></td>
            <td class="column9 style4 null"></td>
            <td class="column10 style4 null"></td>
            <td class="column11 style4 null"></td>
            <td class="column12 style4 null"></td>
            <td class="column13 style4 null"></td>
            <td class="column14 style4 null"></td>
            <td class="column15 style4 null"></td>
            <td class="column16 style4 null"></td>
            <td class="column17 style4 null"></td>
            <td class="column18 style4 null"></td>
            <td class="column19 style4 null"></td>
            <td class="column20 style4 null"></td>
            <td class="column21 style4 null"></td>
            <td class="column22 style4 null"></td>
            <td class="column23 style4 null"></td>
            <td class="column24 style4 null"></td>
            <td class="column25 style4 null"></td>
            <td class="column26 style4 null"></td>
            <td class="column27 style4 null"></td>
            <td class="column28 style4 null"></td>
            <td class="column29 style4 null"></td>
            <td class="column30 style4 null"></td>
            <td class="column31 style4 null"></td>
            <td class="column32 style4 null"></td>
            <td class="column33 style4 null"></td>
            <td class="column34 style4 null"></td>
            <td class="column35 style4 null"></td>
            <td class="column36 style4 null"></td>
            <td class="column37 style4 null"></td>
            <td class="column38 style4 null"></td>
            <td class="column39 style4 null"></td>
            <td class="column40 style4 null"></td>
            <td class="column41 style4 null"></td>
            <td class="column42 style4 null"></td>
            <td class="column43 style4 null"></td>
            <td class="column44 style4 null"></td>
            <td class="column45 style4 null"></td>
            <td class="column46 style4 null"></td>
            <td class="column47 style4 null"></td>
            <td class="column48 style4 null"></td>
            <td class="column49 style4 null"></td>
            <td class="column50 style4 null"></td>
            <td class="column51 style4 null"></td>
            <td class="column52 style4 null"></td>
            <td class="column53 style4 null"></td>
            <td class="column54 style4 null"></td>
            <td class="column55 style4 null"></td>
            <td class="column56 style4 null"></td>
          </tr>
          <tr class="row5">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">현 장 명</td>
            <td class="column5 style6 null style7" colspan="19"> <?php echo $work['nw_subject']?></td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row6">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">업 체 명</td>
            <td class="column5 style8 null style9" colspan="19">
			<input type="hidden" name="seq[]" value="<?php echo $row['seq']?>">
			<input type="text" name="ne_upche[]" class="input ne_upche" value="<?php echo $row['ne_upche']?>"></td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row7">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">공 종 명</td>
            <td class="column5 style8 null style8" colspan="19"><input type="text" name="ne_gongjong[]" class="input ne_gongjong " value="<?php echo $row['ne_gongjong']?>"></td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row8">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">청구기간</td>
            <td class="column5 style10 null style11" colspan="7"><?php echo date('Y-m', strtotime($date))?>-01</td>
            <td class="column12 style12 s style12" colspan="2">~</td>
            <td class="column14 style11 null style11" colspan="7"><?php echo date('Y-m-t', strtotime($date))?></td>
            <td class="column21 style13 null"></td>
            <td class="column22 style13 null"></td>
            <td class="column23 style14 null"></td>
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
            <td class="column56">&nbsp;</td>
          </tr>
          <tr class="row9">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="56">자   재   사   용   내   역</td>
          </tr>
          <tr class="row10">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="5">거래일자</td>
            <td class="column6 style2 s style2 bg_grey" colspan="7">품      명</td>
            <td class="column13 style2 s style2 bg_grey" colspan="5">규    격</td>
            <td class="column18 style2 s style2 bg_grey" colspan="2">단위</td>
            <td class="column20 style2 s style2 bg_grey" colspan="4">수  량</td>
            <td class="column24 style2 s style2 bg_grey" colspan="5">단    가</td>
            <td class="column29 style2 s style2 bg_grey" colspan="6">공급가액</td>
            <td class="column35 style2 s style2 bg_grey" colspan="6">부 가 세</td>
            <td class="column41 style2 s style2 bg_grey" colspan="6">합    계</td>
            <td class="column47 style2 s style2 bg_grey" colspan="10">비         고</td>
          </tr>
		  <?php
		  for($i=0; $i<25; $i++) {?>
          <tr class="row11">
            <td class="column0">&nbsp;</td>
		  <td class="column1 style15 null style16" colspan="5"><input type="date" name="ne_detail_date[<?php echo $i?>][]" class="input ne_detail_date"></td>
            <td class="column6 style16 null style16" colspan="7"><input type="text" name="ne_detail_name[<?php echo $i?>][]" class="input ne_detail_name"  value="<?php echo $row['ne_detail_name']?>"></td>
            <td class="column13 style16 null style16" colspan="5"><input type="text" name="ne_detail_standard[<?php echo $i?>][]" class="input  ne_detail_standard"  value="<?php echo $row['ne_detail_standard']?>"></td>
            <td class="column18 style16 null style16" colspan="2"><input type="text" name="ne_detail_unit[<?php echo $i?>][]" class="input  ne_detail_unit"  value="<?php echo $row['ne_detail_unit']?>"></td>
            <td class="column20 style17 null style17" colspan="4"><input type="text" name="ne_detail_qty[<?php echo $i?>][]" class="input numb ne_detail_qty"  value="<?php echo $row['ne_detail_qty']?>"></td>
            <td class="column24 style17 null style17" colspan="5"><input type="text" name="ne_detail_danga[<?php echo $i?>][]" class="input numb ne_detail_danga"  value="<?php echo $row['ne_detail_danga']?>"></td>
            <td class="column29 style17 null style17" colspan="6"><input type="text" name="ne_detail_price[<?php echo $i?>][]" class="input numb ne_detail_price"  value="<?php echo $row['ne_detail_price']?>"></td>
            <td class="column35 style17 null style17" colspan="6"><input type="text" name="ne_detail_vat[<?php echo $i?>][]" class="input numb ne_detail_vat"  value="<?php echo $row['ne_detail_vat']?>"></td>
            <td class="column41 style17 null style17" colspan="6"><input type="text" name="ne_detail_total[<?php echo $i?>][]" class="input numb ne_detail_total"  value="<?php echo $row['ne_detail_total']?>"></td>
            <td class="column47 style18 null style16" colspan="10"><input type="text" name="ne_detail_etc[<?php echo $i?>][]" class="input ne_detail_etc"  value="<?php echo $row['ne_detail_name']?>"></td>
          </tr>
          <?php }?>
          <tr class="row36">
            <td class="column0">&nbsp;</td>
            <td class="column1 style16 s style16 bg_grey" colspan="19">계</td>
            <td class="column20 style17 null style17 qty_total text-right" colspan="4"></td>
            <td class="column24 style17 null style17 danga_total text-right" colspan="5"></td>
            <td class="column29 style17 null style17 text-right price_total" colspan="6"></td>
            <td class="column35 style17 null style17 text-right vat_total" colspan="6"></td>
            <td class="column41 style17 null style17 text-right total_total" colspan="6"></td>
            <td class="column47 style16 null style16 text-right" colspan="10"></td>
          </tr>
           <tr class="row37">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">첨 부 서류</td>
            <td class="column5 style2 s style2 bg_grey" colspan="4">첨부</td>
            <td class="column9 style2 s style21 bg_grey " colspan="49" style="font-family:'돋움체'; font-size:9pt"> 특기사항</td>
          </tr>
          <tr class="row38">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">세금계산서</td>
            <td class="column5 style2 null style2" colspan="4"><input type="text" name="ne_file1[]" class="input ne_file1"  value="<?php echo $row['ne_file1']?>"></td>
            <td class="column9 style6 null style6" colspan="48" rowspan="3">
			<textarea name="ne_etc[]" class="input" style="height:75px"><?php echo $row['ne_etc']?></textarea>
			</td>
          </tr>
          <tr class="row39">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">거래명세서</td>
            <td class="column5 style2 null style2" colspan="4"><input type="text" name="ne_file2[]" class="input ne_file2"  value="<?php echo $row['ne_file2']?>"></td>
          </tr>
          <tr class="row40">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="4">통 장 사본</td>
            <td class="column5 style2 null style2" colspan="4"><input type="text" name="ne_file3[]" class="input ne_file3"  value="<?php echo $row['ne_file3']?>"></td>
          </tr>
        </tbody>
        </tbody>
    </table>
<?php }?>
	</div>
	<div id="copybox" style="display:none"><?php include_once('./include/menu9_inc_copy.php');?></div>
	<div id="add_tb_box"></div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" onclick="onPrint()" data-dismiss="modal">인쇄</button>
		<button type="button" class="btn btn-secondary"  data-dismiss="modal" id="add_tables">표추가</button>
		<button type="submit" class="btn btn-primary"data-dismiss="modal">업데이트</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">목록</button>
	</div>
</form>