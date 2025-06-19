<?php if(!defined('menu_establishment')) exit;

$sql = "select * from {$none['est_execution']} where nw_code = '{$work['nw_code']}' and  ne_date <= '{$date}' order by seq asc";
$rst = sql_query($sql);
$chk = sql_fetch($sql);

include('./include/a_update_table.php');
include('./include/file_upload_table.php');
?>


<style>
.numb { text-align:right; padding-right:5px }
.bg_grey { background:#f2f2f2 !important}
</style>
<?php if($chk) {
include_once('./include/menu7_inc_list.php');
}?>

<form name="frm" action="./update/inc/menu7_update.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="mode" value="<?php echo $mode?>">
<input type="hidden" name="nw_code" id="nw_code" value="<?php echo $work['nw_code']?>">
<input type="hidden" name="ne_date" value="<?php echo $date?>">
<div class="print_frm">
<?php if($chk) {
	
	
	include_once('./include/menu7_inc_list2.php');
	
} else {?>

<div id="copybox">
<table border="0" cellpadding="0" cellspacing="0" id="datasheet" class="sheet0" style="border-top:1px solid #ddd">
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
            <td class="column1 style33 s style33" colspan="56" rowspan="3">기 성 집 행 내 역 서</td>
          </tr>
          <tr class="row2">
            <td class="column0">&nbsp;</td>
          </tr>
          <tr class="row3">
            <td class="column0">&nbsp;</td>
          </tr>
          <tr class="row4">
            <td class="column0">&nbsp;</td>
            <td class="column1 style32 null"></td>
            <td class="column2 style32 null"></td>
            <td class="column3 style32 null"></td>
            <td class="column4 style32 null"></td>
            <td class="column5 style32 null"></td>
            <td class="column6 style32 null"></td>
            <td class="column7 style32 null"></td>
            <td class="column8 style32 null"></td>
            <td class="column9 style32 null"></td>
            <td class="column10 style32 null"></td>
            <td class="column11 style32 null"></td>
            <td class="column12 style32 null"></td>
            <td class="column13 style32 null"></td>
            <td class="column14 style32 null"></td>
            <td class="column15 style32 null"></td>
            <td class="column16 style32 null"></td>
            <td class="column17 style32 null"></td>
            <td class="column18 style32 null"></td>
            <td class="column19 style32 null"></td>
            <td class="column20 style32 null"></td>
            <td class="column21 style32 null"></td>
            <td class="column22 style32 null"></td>
            <td class="column23 style32 null"></td>
            <td class="column24 style32 null"></td>
            <td class="column25 style32 null"></td>
            <td class="column26 style32 null"></td>
            <td class="column27 style32 null"></td>
            <td class="column28 style32 null"></td>
            <td class="column29 style32 null"></td>
            <td class="column30 style32 null"></td>
            <td class="column31 style32 null"></td>
            <td class="column32 style32 null"></td>
            <td class="column33 style32 null"></td>
            <td class="column34 style32 null"></td>
            <td class="column35 style32 null"></td>
            <td class="column36 style32 null"></td>
            <td class="column37 style32 null"></td>
            <td class="column38 style32 null"></td>
            <td class="column39 style32 null"></td>
            <td class="column40 style32 null"></td>
            <td class="column41 style32 null"></td>
            <td class="column42 style32 null"></td>
            <td class="column43 style32 null"></td>
            <td class="column44 style32 null"></td>
            <td class="column45 style32 null"></td>
            <td class="column46 style32 null"></td>
            <td class="column47 style32 null"></td>
            <td class="column48 style32 null"></td>
            <td class="column49 style32 null"></td>
            <td class="column50 style32 null"></td>
            <td class="column51 style32 null"></td>
            <td class="column52 style32 null"></td>
            <td class="column53 style32 null"></td>
            <td class="column54 style32 null"></td>
            <td class="column55 style32 null"></td>
            <td class="column56 style32 null"></td>
          </tr>
          <tr class="row5">
            <td class="column0">&nbsp;</td>
            <td class="column1 style25 null style25" colspan="4"></td>
            <td class="column5 style31 null style31" colspan="19"></td>
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
            <td class="column1 style18 s style16" colspan="4">현 장 명</td>
            <td class="column5 style28 null style29" colspan="19">&nbsp;<?php echo $work['nw_subject']?></td>
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
            <td class="column1 style18 s style16" colspan="4">업 체 명</td>
            <td class="column5 style28 null style26 upche_td" colspan="19">
			<select name="ns_upche[]" class="input ns_upche" style="">
				<option value="">선택하세요.</option>
				<option value="add">직접입력</option>
				<?php 
				$sql = "select * from {$none['subcontract']} where work_id = '{$work['nw_code']}' group by ns_bname";
				$rst = sql_query($sql);
				while($row=sql_fetch_array($rst)) {
				
					echo '<option value="'.$row['ns_bname'].'">'.get_enterprise_txt($row['ns_bname']).'</option>';

				}?>
			</select>
			
			<div class="upche_txt_box" style="display:none">
			<input type="text" name="ns_upche_txt[]" class="ns_upche_txt input" value="<?php echo $row['ne_name']?>" style="width:95%">
			<i class="fa fa-refresh" aria-hidden="true" title="선택박스로 전환"></i>
			</div>
			</td>
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
            <td class="column1 style18 s style16" colspan="4">공 종 명</td>
            <td class="column5 style28 null style26" colspan="19">
			<input type="text" name="ne_gongjong[]" class="ns_gongjong input"  value="<?php echo $row['ne_gongjong']?>">
			</td>
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
          <tr class="row9 price_row1" >
            <td class="column0">&nbsp;</td>
            <td class="column1 style18 s style16" colspan="7">원도급금액</td>
            <td class="column8 style24 null style22" colspan="7"><input type="text" name="ne_price1[]"  class="numb input ne_price1" value="<?php echo $row['ne_price1']?>"></td>
            <td class="column15 style18 s style16" colspan="7">실 행  금 액</td>
            <td class="column22 style24 null style22" colspan="7"><input type="text" name="ne_price2[]" class="numb input ne_price2" value="<?php echo $row['ne_price2']?>"></td>
            <td class="column29 style18 s style16" colspan="7">외주 계약 금액</td>
            <td class="column36 style24 null style22" colspan="7"><input type="text" name="ne_price3[]" class="numb input ne_price3" value="<?php echo $row['ne_price3']?>"></td>
            <td class="column43 style18 s style16" colspan="7">도급대비 계약율</td>
            <td class="column50 style21 f style19 persent" colspan="7">0%</td>
          </tr>
          <tr class="row10 price_row2"  id="">
            <td class="column0">&nbsp;</td>
            <td class="column1 style18 s style16" colspan="7">추 가 공사</td>
            <td class="column8 style24 null style22" colspan="7"><input type="text" name="ne_price4[]"  class="numb input ne_price4" value="<?php echo $row['ne_price4']?>"></td>
            <td class="column15 style18 s style16" colspan="7">실행추가공사</td>
            <td class="column22 style24 null style22" colspan="7"><input type="text" name="ne_price5[]" class="numb input ne_price5" value="<?php echo $row['ne_price5']?>"></td>
            <td class="column29 style18 s style16" colspan="7">외주 추가 공사</td>
            <td class="column36 style24 null style22" colspan="7"><input type="text" name="ne_price6[]" class="numb input ne_price6" value="<?php echo $row['ne_price6']?>"></td>
            <td class="column43 style18 s style16" colspan="7">도급대비 계약율</td>
            <td class="column50 style21 f style19 persent" colspan="7">0%</td>
          </tr>
          <tr class="row11 price_row3"  id="">
            <td class="column0">&nbsp;</td>
            <td class="column1 style18 s style16" colspan="7">부  가  세</td>
            <td class="column8 style24 f style22" colspan="7"><input type="text" name="vat1[]"  class="numb input vat1" value="<?php echo $row['ne_vat1']?>"></td>
            <td class="column15 style18 s style16" colspan="7">부   가   세</td>
            <td class="column22 style24 f style22" colspan="7"><input type="text" name="vat2[]" class="numb input vat2" value="<?php echo $row['ne_vat2']?>"></td>
            <td class="column29 style18 s style16" colspan="7">부    가    세</td>
            <td class="column36 style24 f style22" colspan="7"><input type="text" name="vat3[]" class="numb input vat3" value="<?php echo $row['ne_vat3']?>"></td>
            <td class="column43 style18 s style16" colspan="7">도급대비 계약율</td>
            <td class="column50 style21 f style19 vat_persent persent" colspan="7">0%</td>
          </tr>
          <tr class="row12 price_row4"  id="">
            <td class="column0">&nbsp;</td>
            <td class="column1 style18 s style16" colspan="7">총 공사금액</td>
            <td class="column8 style24 f style22" colspan="7"><input type="text" name="ne_total_price1[]" class="numb input ne_total_price1" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column15 style18 s style16" colspan="7">총 공사 금액</td>
            <td class="column22 style24 f style22" colspan="7"><input type="text" name="ne_total_price2[]"  class="numb input ne_total_price2" value="<?php echo $row['ne_total_price2']?>"></td>
            <td class="column29 style18 s style16" colspan="7">외주 총 공사금액</td>
            <td class="column36 style24 f style22" colspan="7"><input type="text" name="ne_total_price3[]"  class="numb input ne_total_price3" value="<?php echo $row['ne_total_price3']?>"></td>
            <td class="column43 style18 s style16" colspan="7">도급대비 계약율</td>
            <td class="column50 style21 f style19 persent total_persent" colspan="7">0%</td>
          </tr>
          <tr class="row13">
            <td class="column0">&nbsp;</td>
            <td class="column1 style18 s style16" colspan="56">기     성     현     황</td>
          </tr>
          <tr class="row14">
            <td class="column0">&nbsp;</td>
            <td class="column1 style18 s style16" colspan="4">구    분</td>
            <td class="column5 style18 s style16" colspan="4">기성일자</td>
            <td class="column9 style18 s style16" colspan="7">업체 청구금액</td>
            <td class="column16 style18 s style16" colspan="7">사정금액</td>
            <td class="column23 style18 s style16" colspan="7">실지급액</td>
            <td class="column30 style18 s style16" colspan="7">부 가 세</td>
            <td class="column37 style18 s style16" colspan="7">기성합계</td>
            <td class="column44 style18 s style16" colspan="7">기성누계</td>
            <td class="column51 style18 s style16" colspan="6">기성율</td>
          </tr>
		  <?php for($i=1; $i<=10; $i++) {?>
          <tr class="row15">
            <td class="column0">&nbsp;</td>
            <td class="column1 style18 s style16" colspan="4">제 <?php echo $i?> 회</td>
            <td class="column5 style15 null style13" colspan="4"><input type="date" name="ne_detail_date[<?php echo $i?>][]" class="numb input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column9 style12 null style10" colspan="7"><input type="text" name="ne_detail_price1[<?php echo $i?>][]"  class="numb input ne_detail_price1 dp" value="<?php echo $row['ne_detail_price1']?>"></td>
            <td class="column16 style12 null style10" colspan="7"><input type="text" name="ne_detail_price2[<?php echo $i?>][]"  class="numb input ne_detail_price2 dp" value="<?php echo $row['ne_detail_price2']?>"></td>
            <td class="column23 style12 null style10" colspan="7"><input type="text" name="ne_detail_price3[<?php echo $i?>][]"  class="numb input ne_detail_price3 dp" value="<?php echo $row['ne_detail_price3']?>"></td>
            <td class="column30 style12 null style10" colspan="7"><input type="text" name="ne_detail_price4[<?php echo $i?>][]"  class="numb input ne_detail_price4 vat" value="<?php echo $row['ne_detail_price4']?>"></td>
            <td class="column37 style12 null style10" colspan="7"><input type="text" name="ne_detail_price5[<?php echo $i?>][]"  class="numb input ne_detail_price5 dp" value="<?php echo $row['ne_detail_price5']?>"></td>
            <td class="column44 style12 null style10" colspan="7"><input type="text" name="ne_detail_price6[<?php echo $i?>][]"  class="numb input ne_detail_price6 " value="<?php echo $row['ne_detail_price6']?>"></td>
            <td class="column51 style9 f style7" colspan="6">0%</td>
          </tr>
		  <?php }?>
         
          <tr class="row25">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="8">소         계</td>
            <td class="column9 style5 f style5" colspan="7"><input type="text" class="detail_price1_total input numb" readonly></td>
            <td class="column16 style5 f style5" colspan="7"><input type="text" class="detail_price2_total input numb" readonly> </td>
            <td class="column23 style5 f style5" colspan="7"><input type="text" class="detail_price3_total input numb" readonly></td>
            <td class="column30 style5 f style5" colspan="7"><input type="text" class="detail_price4_total input numb" readonly></td>
            <td class="column37 style5 f style5" colspan="7"><input type="text" class="detail_price5_total input numb" readonly> </td>
            <td class="column44 style5 f style5" colspan="7"></td>
            <td class="column51 style4 f style4" colspan="6">0%</td>
          </tr>
          <tr class="row26">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="30">제 출 서 류</td>
            <td class="column31 style2 s style2 bg_grey" colspan="20">직 불 처 리</td>
            <td class="column51 style2 s style2 bg_grey" colspan="6" rowspan="2">비      고</td>
          </tr>
          <tr class="row27">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="5">세금계산서</td>
            <td class="column6 style2 s style2 bg_grey" colspan="5">기성청구내역서</td>
            <td class="column11 style2 s style2 bg_grey" colspan="5">계약보증서</td>
            <td class="column16 style2 s style2 bg_grey" colspan="5">근재보험</td>
            <td class="column21 style2 s style2 bg_grey" colspan="5">하자보증서</td>
            <td class="column26 style2 s style2 bg_grey" colspan="5">기타보증서</td>
            <td class="column31 style2 s style2 bg_grey" colspan="5">자  재</td>
            <td class="column36 style2 s style2 bg_grey" colspan="5">용  역</td>
            <td class="column41 style2 s style2 bg_grey" colspan="5">장  비</td>
            <td class="column46 style2 s style2 bg_grey" colspan="5">경  비</td>
          </tr>
          <tr class="row28">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt1[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column6 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt2[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column11 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt3[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column16 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt4[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column21 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt5[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column26 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt6[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column31 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt7[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column36 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt8[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column41 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt9[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column46 style2 null style2" colspan="5" rowspan="2"><input type="text" name="ne_txt10[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
            <td class="column51 style2 null style2" colspan="6" rowspan="2"><input type="text" name="ne_txt11[]" class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
          </tr>
          <tr class="row29">
            <td class="column0">&nbsp;</td>
          </tr>
          <tr class="row30">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="5">구    분</td>
            <td class="column6 style2 s style2 bg_grey" colspan="10">내              역</td>
            <td class="column16 style2 s style2 bg_grey" colspan="5" rowspan="4">특기사항</td>
            <td class="column21 style3 s style3" colspan="36" rowspan="4"><textarea class="input" name="ne_etc[]" style="height:100px"><?php echo $row['ne_etc']?></textarea></td>
          </tr>
          <tr class="row31">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="5">청구내역서</td>
            <td class="column6 style2 null style2" colspan="10"><input type="text" name="ne_txt12[]"  class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
          </tr>
          <tr class="row32">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="5">노무비대장</td>
            <td class="column6 style2 null style2" colspan="10"><input type="text" name="ne_txt13[]"  class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
          </tr>
          <tr class="row33">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s style2 bg_grey" colspan="5">성  과  금</td>
            <td class="column6 style2 null style2" colspan="10"><input type="text" name="ne_txt14[]"  class=" input" value="<?php echo $row['ne_total_price1']?>"></td>
          </tr>
		  <tr>
		
        </tbody>
    </table>
	</div>
	<?php } ?>
	</div>
	<div id="add_tb_box"></div>
	
	<div class="modal-footer">
	
		<button type="button" class="btn btn-secondary"  onclick="onPrint()" data-dismiss="modal">인쇄</button>
		<button type="button" class="btn btn-secondary"  data-dismiss="modal" id="add_tables">표 추가</button>
		<button type="submit" class="btn btn-primary" data-dismiss="modal">업데이트</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">목록</button>
	</div>
	</form>
	