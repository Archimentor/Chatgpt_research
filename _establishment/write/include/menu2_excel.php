<?php 
for($a=1;$a<=5;$a++){ 

${'sql'.$a} = "select * from {$none['est_jungsan']} where nw_code = '{$work['nw_code']}' and ne_type = {$a}";

	if($member['mb_level2'] == 2)
		${'sql'.$a} .= " and ne_admin = 0 ";

${'rst'.$a} = sql_query(${'sql'.$a});

${'chk'.$a} = sql_fetch(${'sql'.$a});
if(${'chk'.$a})
	${'mode'.$a} = 'u';
else 
	${'mode'.$a} = '';
}
?>


<table border="1"  class="sheet0 gridlines write2_table" >
        <col class="col0" style="width:50px"> 
        <col class="col1" style="width:100px">
        <col class="col2" style="width:100px">
        <col class="col3" style="width:120px">
        <col class="col4" style="width:100px">
        <col class="col5" style="width:100px">
        <col class="col6" style="width:100px">
        <col class="col7"  style="width:100px">
        <col class="col8"  style="width:100px">
        <col class="col9"  style="width:100px">
        <col class="col10"  style="width:100px">
        <col class="col11"  style="width:100px">
        <col class="col12"  style="width:100px">
        <col class="col13"  style="width:100px">
        <col class="col14"  style="width:100px">
        <col class="col15"  style="width:100px">
        <col class="col16"  style="width:100px">
        <col class="col17"  style="width:100px">
        <col class="col18"  style="width:100px">
        <col class="col19"  style="width:100px">
        <col class="col20"  style="width:100px">
        <col class="col21"  style="width:100px">
        <col class="col22"  style="width:100px">
        <col class="col23"  style="width:100px">
        <col class="col24"  style="width:100px">
        <col class="col25"  style="width:100px">
        <col class="col26"  style="width:100px">
        <col class="col27"  style="width:100px">
    
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style1" colspan="18" rowspan="3" style="font-size:20px"><?php echo date('Y년 m월', strtotime($date))?> 기성 정산서</td>
            <td class="column18 style2 null"></td>
            <td class="column19 style2 null"></td>
            <td class="column20 style3 null"></td>
            <td class="column21 style3 null"></td>
            <td class="column22 style3 null"></td>
            <td class="column23 style3 null"></td>
            <td class="column24 style3 null"></td>
            <td class="column25 style3 null"></td>
            <td class="column26 style3 null"></td>
            <td class="column27 style3 null"></td>
          </tr>
          <tr class="row1">
            <td class="column18 style2 null"></td>
            <td class="column19 style2 null"></td>
            <td class="column20 style3 null"></td>
            <td class="column21 style3 null"></td>
            <td class="column22 style3 null"></td>
            <td class="column23 style3 null"></td>
            <td class="column24 style3 null"></td>
            <td class="column25 style3 null"></td>
            <td class="column26 style3 null"></td>
            <td class="column27 style3 null"></td>
          </tr>
          <tr class="row2">
            <td class="column18 style2 null"></td>
            <td class="column19 style2 null"></td>
            <td class="column20 style3 null"></td>
            <td class="column21 style3 null"></td>
            <td class="column22 style3 null"></td>
            <td class="column23 style3 null"></td>
            <td class="column24 style3 null"></td>
            <td class="column25 style3 null"></td>
            <td class="column26 style3 null"></td>
            <td class="column27 style3 null"></td>
          </tr>
          <tr class="row3">
            <td class="column0 style177 s style177" colspan="18">현 장 명 : <?php echo $work['nw_subject']?> </td>
            <td class="column18 style2 null"></td>
            <td class="column19 style2 null"></td>
            <td class="column20 style3 null"></td>
            <td class="column21 style3 null"></td>
            <td class="column22 style3 null"></td>
            <td class="column23 style3 null"></td>
            <td class="column24 style3 null"></td>
            <td class="column25 style3 null"></td>
            <td class="column26 style3 null"></td>
            <td class="column27 style3 null"></td>
          </tr>
          <tr class="row4">
            <td class="column0 style4 s style18" rowspan="2" align="center">구분</td>
            <td class="column1 style5 s style20" colspan="2" rowspan="2" align="center">업  체  명</td>
            <td class="column3 style7 s style21" rowspan="2" align="center">공종/<br>적요</td>
            <td class="column4 style5 s style7" colspan="2" align="center">공사기간</td>
            <td class="column6 style8 s" align="center">도급<br>금액</td>
            <td class="column7 style8 s" align="center">실행<br>금액</td>
            <td class="column8 style5 s style7" colspan="3" align="center" align="center">계약금액</td>
            <td class="column11 style9 s style10" colspan="3" align="center">전회기성금</td>
            <td class="column14 style11 s style12" colspan="6" align="center">금회기성</td>
            <td class="column20 style13 s style15" colspan="3" align="center">누계기성</td>
            <td class="column23 style16 s" align="center">잔여<br>기성</td>
            <td class="column24 style13 s style14" colspan="4" align="center">은행계좌 및 수령자</td>
            <td class="column27 style17 s style35" rowspan="2" align="center">비 고</td>
          </tr>
          <tr class="row5">
            <td class="column4 style22 s text-center" align="center">착공<br>일자</td>
            <td class="column5 style23 s text-center" align="center">준공<br>일자</td>
            <td class="column6 style24 s" align="center"><small>(VAT별도)</small></td>
            <td class="column7 style24 s" align="center"><small>(VAT별도)</small></td>
            <td class="column8 style25 s" align="center">공급<br>가액</td>
            <td class="column9 style26 s" align="center">부가세</td>
            <td class="column10 style27 s" align="center">합계</td>
            <td class="column11 style28 s" align="center">공급<br>가액</td>
            <td class="column12 style26 s" align="center">부가세</td>
            <td class="column13 style29 s" align="center">합계</td>
            <td class="column14 style30 s" align="center">공급<br>가액</td>
            <td class="column15 style26 s" align="center">부가세</td>
            <td class="column16 style29 s" align="center">합계</td>
            <td class="column17 style26 s" align="center">공제,<br>유보</td>
            <td class="column18 style26 s" align="center">기불금<br>(지결)</td>
            <td class="column19 style31 s" align="center">지급<br>금액</td>
            <td class="column20 style28 s" align="center">공급<br>가액</td>
            <td class="column21 style26 s" align="center">부가세</td>
            <td class="column22 style27 s"align="center">합계</td>
            <td class="column23 style32 s" align="center"><small>(VAT포함)</small></td>
            <td class="column24 style33 s" align="center">은행명</td>
            <td class="column25 style34 s" align="center">계좌<br>번호</td>
            <td class="column26 style34 s" align="center">예금주</td>
            <td class="column26 style34 s" align="center">대표자</td>
          </tr>
		  </tbody>
		  <tbody id="s1_add_line">
		  <?php if($mode1 == '') {?>
          <tr class="row6" >
            <td class="column0 style36 s style80" rowspan="11" id="s1_add_tit" align="center" style="background:#FDE9D9">외<br><br>주<br><br>비<br></td>
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
          <tr class="row6" >
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
          <tr class="row6" >
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
          <tr class="row6" >
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
          <tr class="row6" >
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
          <tr class="row6" >
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
          <tr class="row6" >
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
          <tr class="row6" >
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
          <tr class="row6" >
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
          <tr class="row6" >
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="1">
			<input type="text" name="s1_name[]" class="name1 input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
			<?php } else if($mode1 == 'u') {
				
			   $cnt1 = sql_num_rows($rst1);
			  
			  for($i=0; $row=sql_fetch_array($rst1); $i++) {
					
				if($date != $row['ne_date']) $readonly = "readonly";
				
				$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date = '{$date}'");
				
				
				$row['ne_price9'] = $p['ne_price9'];
				$row['ne_price10'] = $p['ne_price10'];
				$row['ne_price11'] = $p['ne_price11'];
				$row['ne_price12'] = $p['ne_price12'];
				$row['ne_price13'] = $p['ne_price13'];
				$row['ne_price14'] = $p['ne_price14'];
				
				//전회 
				$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$date}'";
				$pprst = sql_query($ppsql);
				
				while($pp=sql_fetch_array($pprst)) {
					$price6 = (int)$pp['price6'];
					$price7 = (int)$pp['price7'];
					$price8 = (int)$pp['price8']; 
				}
				
				//누계
				$row['ne_price15'] = $price6 + $row['ne_price9'];
				$row['ne_price16'] = $price7 + $row['ne_price10'];
				$row['ne_price17'] = $price8 + $row['ne_price11'];
			
				$row['ne_price18'] = $row['ne_price5']  - $row['ne_price17'];
			?>
			<tr class="row6 dataRow_<?php echo $row['seq']?>"-> 
				<?php if($i==0) {?>
				<td class="column0 style36 s style80" rowspan="<?php echo $cnt1?>" id="s1_add_tit"  align="center" style="background:#FDE9D9">외<br><br>주<br><br>비<br><i class="fa fa-plus-square" id="s1_add_row" aria-hidden="true"></i></td>
				<?php }?>
				<td class="column1 style37 null style38" colspan="2"><?php echo $row['ne_name']?></td>
				<td class="column3 style39 null"><?php echo $row['ne_gongjong']?></td>
				<td class="column4 style40 null"><?php echo $row['ne_sdate']?></td>
				<td class="column5 style41 null"><?php echo $row['ne_edate']?></td>
				<td class="column6 style42 null"><?php echo $row['ne_price1']?></td>
				<td class="column7 style43 null"><?php echo $row['ne_price15']?></td>
				<td class="column8 style44 null"><?php echo $row['ne_price3']?></td>
				<td class="column9 style45 null"><?php echo $row['ne_price4']?></td>
				<td class="column10 style46 null"><?php echo $row['ne_price5']?></td>
				<td class="column11 style47 null"><?php echo $price6?></td>
				<td class="column12 style45 null"><?php echo $price7?></td>
				<td class="column13 style48 null"><?php echo $price8?></td>
				<td class="column14 style49 null"><?php echo $row['ne_price9']?></td>
				<td class="column15 style50 null"><?php echo $row['ne_price10']?></td>
				<td class="column16 style45 null"><?php echo $row['ne_price11']?></td>
				<td class="column17 style45 null"><?php echo $row['ne_price12']?></td>
				<td class="column18 style45 null"><?php echo $row['ne_price13']?></td>
				<td class="column19 style51 null"><?php echo $row['ne_price14']?></td>
				<td class="column20 style47 null"><?php echo $row['ne_price15']?></td>
				<td class="column21 style45 null"><?php echo $row['ne_price16']?></td>
				<td class="column22 style46 null"><?php echo $row['ne_price17']?></td>
				<td class="column23 style52 null"><?php echo $row['ne_price18']?></td>
				<td class="column24 style53 null"><?php echo $row['ne_bank']?></td>
				<td class="column25 style54 null"><?php echo $row['ne_account']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_accname']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_ceo']?></td>
				<td class="column27 style56 null"><?php echo $row['ne_etc']?></td>
			  </tr>
		  
			<?php 
			$s1_price1_total += $row['ne_price1'];
			$s1_price2_total += $row['ne_price15'];
			$s1_price3_total += $row['ne_price3'];
			$s1_price4_total += $row['ne_price4'];
			$s1_price5_total += $row['ne_price5'];
			$s1_price6_total += $price6;
			$s1_price7_total += $price7;
			$s1_price8_total += $price8;
			$s1_price9_total += $row['ne_price9'];
			$s1_price10_total += $row['ne_price10'];
			$s1_price11_total += $row['ne_price11'];
			$s1_price12_total += $row['ne_price12'];
			$s1_price13_total += $row['ne_price13'];
			$s1_price14_total += $row['ne_price14'];
			$s1_price15_total += $row['ne_price15'];
			$s1_price16_total += $row['ne_price16'];
			$s1_price17_total += $row['ne_price17'];
			$s1_price18_total += $row['ne_price18'];
			}
			
			unset($i);
			unset($row);
			}
		  ?>
          </tbody>
          <tr class="row19" style="background:#FDE9D9">
            <td class="column1 style81 s style83" colspan="3">소     계</td>
            <td class="column4 style84 null"></td>
            <td class="column5 style85 null"></td>
            <td class="column6 style86 f"></td>
            <td class="column7 style86 f"><?php echo number_format($s1_price1_total)?></td>
            <td class="column8 style87 f"><?php echo number_format($s1_price2_total)?></td>
            <td class="column8 style87 f"><?php echo number_format($s1_price3_total)?></td>
            <td class="column9 style88 f"><?php echo number_format($s1_price4_total)?></td>
            <td class="column10 style89 f"><?php echo number_format($s1_price5_total)?></td>
            <td class="column11 style90 f"><?php echo number_format($s1_price6_total)?></td>
            <td class="column12 style88 f"><?php echo number_format($s1_price7_total)?></td>
            <td class="column13 style91 f"><?php echo number_format($s1_price8_total)?></td>
            <td class="column14 style92 f"><?php echo number_format($s1_price9_total)?></td>
            <td class="column15 style88 f"><?php echo number_format($s1_price10_total)?></td>
            <td class="column16 style88 f"><?php echo number_format($s1_price11_total)?></td>
            <td class="column17 style88 f"><?php echo number_format($s1_price12_total)?></td>
            <td class="column18 style88 f"><?php echo number_format($s1_price13_total)?></td>
            <td class="column19 style93 f"><?php echo number_format($s1_price14_total)?></td>
            <td class="column20 style90 f"><?php echo number_format($s1_price15_total)?></td>
            <td class="column21 style88 f"><?php echo number_format($s1_price16_total)?></td>
            <td class="column22 style89 f"><?php echo number_format($s1_price17_total)?></td>
            <td class="column23 style86 f"><?php echo number_format($s1_price18_total)?></td>
            <td class="column24 style94 null"></td>
            <td class="column25 style95 null"></td>
            <td class="column26 style95 null"></td>
            <td class="column26 style95 null"></td>
            <td class="column27 style96 null"></td>
          </tr>
		  <tbody id="s2_add_line">
		  <?php if($mode2 == '') {?>
          <tr class="row20">
            <td class="column0 style97 s style104" rowspan="11" id="s2_add_tit"  align="center"  style="background:#DAEEF3">자<br><br>재<br><br>비<br></td>
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
		  <tr class="row20">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row20">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row20">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row20">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row20">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row20">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row20">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row20">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row20">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
		 <?php } else if($mode2 == 'u') {
				
			   $cnt2 = sql_num_rows($rst2);
			  
			  for($i=0; $row=sql_fetch_array($rst2); $i++) {
					
				if($date != $row['ne_date']) $readonly = "readonly";
				
				$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date = '{$date}'");
				
				
				$row['ne_price9'] = $p['ne_price9'];
				$row['ne_price10'] = $p['ne_price10'];
				$row['ne_price11'] = $p['ne_price11'];
				$row['ne_price12'] = $p['ne_price12'];
				$row['ne_price13'] = $p['ne_price13'];
				$row['ne_price14'] = $p['ne_price14'];
				
				//전회 
				$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$date}'";
				$pprst = sql_query($ppsql);
				
				while($pp=sql_fetch_array($pprst)) {
					
					
					$price6 = (int)$pp['price6'];
					$price7 = (int)$pp['price7'];
					$price8 = (int)$pp['price8'];
					
				}
				
				//누계
				$row['ne_price15'] = $price6 + $row['ne_price9'];
				$row['ne_price16'] = $price7 + $row['ne_price10'];
				$row['ne_price17'] = $price8 + $row['ne_price11'];
				
				//잔여 계약 - 누계
				$row['ne_price18'] = ($row['ne_price15'] + $row['ne_price16']) - $row['ne_price17'];
			?>
			<tr class="row20 dataRow_<?php echo $row['seq']?>" >
				<?php if($i==0) {?>
				<td class="column0 style36 s style104" rowspan="<?php echo $cnt2?>" id="s2_add_tit"  align="center"  style="background:#DAEEF3">자<br><br>재<br><br>비<br>
				<?php }?>
				<td class="column1 style37 null style38" colspan="2">
				<?php echo $row['ne_name']?></td>
				<td class="column3 style39 null"><?php echo $row['ne_gongjong']?></td>
				<td class="column4 style40 null"><?php echo $row['ne_sdate']?></td>
				<td class="column5 style41 null"><?php echo $row['ne_edate']?></td>
				<td class="column6 style42 null"><?php echo $row['ne_price1']?></td>
				<td class="column7 style43 null"><?php echo $row['ne_price15']?></td>
				<td class="column8 style44 null"><?php echo $row['ne_price15']?></td>
				<td class="column9 style45 null"><?php echo $row['ne_price16']?></td>
				<td class="column10 style46 null"><?php echo $row['ne_price17']?></td>
				<td class="column11 style47 null"><?php echo $price6?></td>
				<td class="column12 style45 null"><?php echo $price7?></td>
				<td class="column13 style48 null"><?php echo $price8?></td>
				<td class="column14 style49 null"><?php echo $row['ne_price9']?></td>
				<td class="column15 style50 null"><?php echo $row['ne_price10']?></td>
				<td class="column16 style45 null"><?php echo $row['ne_price11']?></td>
				<td class="column17 style45 null"><?php echo $row['ne_price12']?></td>
				<td class="column18 style45 null"><?php echo $row['ne_price13']?></td>
				<td class="column19 style51 null"><?php echo $row['ne_price14']?></td>
				<td class="column20 style47 null"><?php echo $row['ne_price15']?></td>
				<td class="column21 style45 null"><?php echo $row['ne_price16']?></td>
				<td class="column22 style46 null"><?php echo $row['ne_price17']?></td>
				<td class="column23 style52 null"><?php echo $row['ne_price18']?></td>
				<td class="column24 style53 null"><?php echo $row['ne_bank']?></td>
				<td class="column25 style54 null"><?php echo $row['ne_account']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_accname']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_ceo']?></td>
				<td class="column27 style56 null"><?php echo $row['ne_etc']?></td>
			  </tr>
		  
			<?php
			$s2_price1_total += $row['ne_price1'];
			$s2_price2_total += $row['ne_price15'];
			$s2_price3_total += $row['ne_price15'];
			$s2_price4_total += $row['ne_price16'];
			$s2_price5_total += $row['ne_price17'];
			$s2_price6_total += $price6;
			$s2_price7_total += $price7;
			$s2_price8_total += $price8;
			$s2_price9_total += $row['ne_price9'];
			$s2_price10_total += $row['ne_price10'];
			$s2_price11_total += $row['ne_price11'];
			$s2_price12_total += $row['ne_price12'];
			$s2_price13_total += $row['ne_price13'];
			$s2_price14_total += $row['ne_price14'];
			$s2_price15_total += $row['ne_price15'];
			$s2_price16_total += $row['ne_price16'];
			$s2_price17_total += $row['ne_price17'];
			$s2_price18_total += $row['ne_price18'];
			
			}
			
			unset($i);
			unset($row);
			}
		  ?>
		  
		  
         </tbody>
          
          <tr class="row35" style="background:#DAEEF3">
            <td class="column1 style105 s style107" colspan="3">소     계</td>
            <td class="column4 style108 null"></td>
            <td class="column5 style109 null"></td>
            <td class="column6 style110 f"></td>
            <td class="column7 style110 f"><?php echo number_format($s2_price1_total)?></td>
            <td class="column7 style110 f"><?php echo number_format($s2_price2_total)?></td>
            <td class="column8 style111 f"><?php echo number_format($s2_price3_total)?></td>
            <td class="column9 style112 f"><?php echo number_format($s2_price4_total)?></td>
            <td class="column10 style113 f"><?php echo number_format($s2_price5_total)?></td>
            <td class="column11 style114 f"><?php echo number_format($s2_price6_total)?></td>
            <td class="column12 style112 f"><?php echo number_format($s2_price7_total)?></td>
            <td class="column13 style115 f"><?php echo number_format($s2_price8_total)?></td>
            <td class="column14 style116 f"><?php echo number_format($s2_price9_total)?></td>
            <td class="column15 style112 f"><?php echo number_format($s2_price10_total)?></td>
            <td class="column16 style112 f"><?php echo number_format($s2_price11_total)?></td>
            <td class="column17 style112 f"><?php echo number_format($s2_price12_total)?></td>
            <td class="column18 style112 f"><?php echo number_format($s2_price13_total)?></td>
            <td class="column19 style117 f"><?php echo number_format($s2_price14_total)?></td>
            <td class="column20 style114 f"><?php echo number_format($s2_price15_total)?></td>
            <td class="column21 style112 f"><?php echo number_format($s2_price16_total)?></td>
            <td class="column22 style113 f"><?php echo number_format($s2_price17_total)?></td>
            <td class="column23 style110 f"><?php echo number_format($s2_price18_total)?></td>
            <td class="column24 style114 null"></td>
            <td class="column25 style112 null"></td>
            <td class="column26 style112 null"></td>
            <td class="column26 style112 null"></td>
            <td class="column27 style118 null"></td>
          </tr>
		  <tbody id="s3_add_line">
		   <?php if($mode3 == '') {?>
		  
          <tr class="row36">
            <td class="column0 style119 s style119" rowspan="11" id="s3_add_tit"  align="center" style="background:#E5DFEC">장<br><br>비<br><br>비<br></td>
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> 
		  <tr class="row36">
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
		  <tr class="row36">
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row36">
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row36">
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row36">
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row36">
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row36">
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row36">
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row36">
             <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			<td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
		   
		    <?php } else if($mode3 == 'u') {
				
			   $cnt3 = sql_num_rows($rst3);
			  
			  for($i=0; $row=sql_fetch_array($rst3); $i++) {
					
				if($date != $row['ne_date']) $readonly = "readonly";
				
				$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date = '{$date}'");
				
				
				$row['ne_price9'] = $p['ne_price9'];
				$row['ne_price10'] = $p['ne_price10'];
				$row['ne_price11'] = $p['ne_price11'];
				$row['ne_price12'] = $p['ne_price12'];
				$row['ne_price13'] = $p['ne_price13'];
				$row['ne_price14'] = $p['ne_price14'];
				
				//전회 
				$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$date}'";
				$pprst = sql_query($ppsql);
				
				while($pp=sql_fetch_array($pprst)) {
					$price6 = (int)$pp['price6'];
					$price7 = (int)$pp['price7'];
					$price8 = (int)$pp['price8'];
				}
				
				//누계
				$row['ne_price15'] = $price6 + $row['ne_price9'];
				$row['ne_price16'] = $price7 + $row['ne_price10'];
				$row['ne_price17'] = $price8 + $row['ne_price11'];
				
				//잔여 계약 - 누계
				$row['ne_price18'] = ($row['ne_price15'] + $row['ne_price16']) - $row['ne_price17'];
			?>
			<tr class="row36 dataRow_<?php echo $row['seq']?>" >
				<?php if($i==0) {?>
				<td class="column0 style36 s style119" rowspan="<?php echo $cnt3?>" id="s3_add_tit" align="center" style="background:#E5DFEC">장<br><br>비<br><br>비<br></td>
				<?php }?>
				<td class="column1 style37 null style38" colspan="2">
				
				<?php echo $row['ne_name']?></td>
				<td class="column3 style39 null"><?php echo $row['ne_gongjong']?></td>
				<td class="column4 style40 null"><?php echo $row['ne_sdate']?></td>
				<td class="column5 style41 null"><?php echo $row['ne_edate']?></td>
				<td class="column6 style42 null"><?php echo $row['ne_price1']?></td>
				<td class="column7 style43 null"><?php echo $row['ne_price15']?></td>
				<td class="column8 style44 null"><?php echo $row['ne_price15']?></td>
				<td class="column9 style45 null"><?php echo $row['ne_price16']?></td>
				<td class="column10 style46 null"><?php echo $row['ne_price17']?></td>
				<td class="column11 style47 null"><?php echo $price6?></td>
				<td class="column12 style45 null"><?php echo $price7?></td>
				<td class="column13 style48 null"><?php echo $price8?></td>
				<td class="column14 style49 null"><?php echo $row['ne_price9']?></td>
				<td class="column15 style50 null"><?php echo $row['ne_price10']?></td>
				<td class="column16 style45 null"><?php echo $row['ne_price11']?></td>
				<td class="column17 style45 null"><?php echo $row['ne_price12']?></td>
				<td class="column18 style45 null"><?php echo $row['ne_price13']?></td>
				<td class="column19 style51 null"><?php echo $row['ne_price14']?></td>
				<td class="column20 style47 null"><?php echo $row['ne_price15']?></td>
				<td class="column21 style45 null"><?php echo $row['ne_price16']?></td>
				<td class="column22 style46 null"><?php echo $row['ne_price17']?></td>
				<td class="column23 style52 null"><?php echo $row['ne_price18']?></td>
				<td class="column24 style53 null"><?php echo $row['ne_bank']?></td>
				<td class="column25 style54 null"><?php echo $row['ne_account']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_accname']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_ceo']?></td>
				<td class="column27 style56 null"><?php echo $row['ne_etc']?></td>
			  </tr>
		  
			<?php 
			$s3_price1_total += $row['ne_price1'];
			$s3_price2_total += $row['ne_price15'];
			$s3_price3_total += $row['ne_price3'];
			$s3_price4_total += $row['ne_price4'];
			$s3_price5_total += $row['ne_price5'];
			$s3_price6_total += $price6;
			$s3_price7_total += $price7;
			$s3_price8_total += $price8;
			$s3_price9_total += $row['ne_price9'];
			$s3_price10_total += $row['ne_price10'];
			$s3_price11_total += $row['ne_price11'];
			$s3_price12_total += $row['ne_price12'];
			$s3_price13_total += $row['ne_price13'];
			$s3_price14_total += $row['ne_price14'];
			$s3_price15_total += $row['ne_price15'];
			$s3_price16_total += $row['ne_price16'];
			$s3_price17_total += $row['ne_price17'];
			$s3_price18_total += $row['ne_price18'];
			
			}
			
			unset($i);
			unset($row);
			}
		  ?>
		   
		   
		  
          </tbody>
         
          <tr class="row50" style="background:#E5DFEC">
            <td class="column1 style120 s style122" colspan="3">소     계</td>
            <td class="column4 style123 null"></td>
            <td class="column5 style124 null"></td>
            <td class="column5 style124 null"></td>
            <td class="column6 style125 f"><?php echo number_format($s3_price1_total)?></td>
            <td class="column7 style125 f"><?php echo number_format($s3_price2_total)?></td>
            <td class="column8 style126 f"><?php echo number_format($s3_price3_total)?></td>
            <td class="column9 style127 f"><?php echo number_format($s3_price4_total)?></td>
            <td class="column10 style128 f"><?php echo number_format($s3_price5_total)?></td>
            <td class="column11 style129 f"><?php echo number_format($s3_price6_total)?></td>
            <td class="column12 style127 f"><?php echo number_format($s3_price7_total)?></td>
            <td class="column13 style130 f"><?php echo number_format($s3_price8_total)?></td>
            <td class="column14 style131 f"><?php echo number_format($s3_price9_total)?></td>
            <td class="column15 style127 f"><?php echo number_format($s3_price10_total)?></td>
            <td class="column16 style127 f"><?php echo number_format($s3_price11_total)?></td>
            <td class="column17 style127 f"><?php echo number_format($s3_price12_total)?></td>
            <td class="column18 style127 f"><?php echo number_format($s3_price13_total)?></td>
            <td class="column19 style132 f"><?php echo number_format($s3_price14_total)?></td>
            <td class="column20 style129 f"><?php echo number_format($s3_price15_total)?></td>
            <td class="column21 style127 f"><?php echo number_format($s3_price16_total)?></td>
            <td class="column22 style128 f"><?php echo number_format($s3_price17_total)?></td>
            <td class="column23 style125 f"><?php echo number_format($s3_price18_total)?></td>
            <td class="column24 style129 null"></td>
            <td class="column25 style127 null"></td>
            <td class="column26 style133 null"></td>
            <td class="column26 style133 null"></td>
            <td class="column27 style134 null"></td>
          </tr>
		  <tbody id="s4_add_line">
         
			<?php if($mode4 == '') {?>
			<tr class="row51">
            <td class="column0 style135 s style135" rowspan="11"  style="background:#EAF1DD" id="s4_add_tit"  align="center">노<br><br>무<br><br>비<br><i class="fa fa-plus-square" aria-hidden="true" id="s4_add_row"></i></td>
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
		  <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr> <tr class="row51">
            
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
           <?php } else if($mode4 == 'u') {
				
			   $cnt4 = sql_num_rows($rst4);
			  
			  for($i=0; $row=sql_fetch_array($rst4); $i++) {
					
				if($date != $row['ne_date']) $readonly = "readonly";
				
				$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date = '{$date}'");
				
				
				$row['ne_price9'] = $p['ne_price9'];
				$row['ne_price10'] = $p['ne_price10'];
				$row['ne_price11'] = $p['ne_price11'];
				$row['ne_price12'] = $p['ne_price12'];
				$row['ne_price13'] = $p['ne_price13'];
				$row['ne_price14'] = $p['ne_price14'];
				
				
				//전회 
				$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$date}'";
				$pprst = sql_query($ppsql);
				
				while($pp=sql_fetch_array($pprst)) {
					$price6 = (int)$pp['price6'];
					$price7 = (int)$pp['price7'];
					$price8 = (int)$pp['price8'];
				}
				
				//누계
				$row['ne_price15'] = $price6 + $row['ne_price9'];
				$row['ne_price16'] = $price7 + $row['ne_price10'];
				$row['ne_price17'] = $price8 + $row['ne_price11'];
				
				//잔여 계약 - 누계
				$row['ne_price18'] = ($row['ne_price15'] + $row['ne_price16']) - $row['ne_price17'];
			?>
			<tr class="row51 dataRow_<?php echo $row['seq']?>" >
				<?php if($i==0) {?>
				<td class="column0 style36 s style135"  style="background:#EAF1DD" rowspan="<?php echo $cnt4?>" id="s4_add_tit" align="center">노<br><br>무<br><br>비<br></td>
				<?php }?>
				<td class="column1 style37 null style38" colspan="2"><?php echo $row['ne_name']?></td>
				<td class="column3 style39 null"><?php echo $row['ne_gongjong']?></td>
				<td class="column4 style40 null"><?php echo $row['ne_sdate']?></td>
				<td class="column5 style41 null"><?php echo $row['ne_edate']?></td>
				<td class="column6 style42 null"><?php echo $row['ne_price1']?></td>
				<td class="column7 style43 null"><?php echo $row['ne_price15']?></td>
				<td class="column8 style44 null"><?php echo $row['ne_price15']?></td>
				<td class="column9 style45 null"><?php echo $row['ne_price16']?></td>
				<td class="column10 style46 null"><?php echo $row['ne_price17']?></td>
				<td class="column11 style47 null"><?php echo $price6?></td>
				<td class="column12 style45 null"><?php echo $price67?></td>
				<td class="column13 style48 null"><?php echo $price8?></td>
				<td class="column14 style49 null"><?php echo $row['ne_price9']?></td>
				<td class="column15 style50 null"><?php echo $row['ne_price10']?></td>
				<td class="column16 style45 null"><?php echo $row['ne_price11']?></td>
				<td class="column17 style45 null"><?php echo $row['ne_price12']?></td>
				<td class="column18 style45 null"><?php echo $row['ne_price13']?></td>
				<td class="column19 style51 null"><?php echo $row['ne_price14']?></td>
				<td class="column20 style47 null"><?php echo $row['ne_price15']?></td>
				<td class="column21 style45 null"><?php echo $row['ne_price16']?></td>
				<td class="column22 style46 null"><?php echo $row['ne_price17']?></td>
				<td class="column23 style52 null"><?php echo $row['ne_price18']?></td>
				<td class="column24 style53 null"><?php echo $row['ne_bank']?></td>
				<td class="column25 style54 null"><?php echo $row['ne_account']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_accname']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_ceo']?></td>
				<td class="column27 style56 null"><?php echo $row['ne_etc']?></td>
			  </tr>
		  
			<?php 
			$s4_price1_total += $row['ne_price1'];
			$s4_price2_total += $row['ne_price15'];
			$s4_price3_total += $row['ne_price15'];
			$s4_price4_total += $row['ne_price16'];
			$s4_price5_total += $row['ne_price17'];
			$s4_price6_total += $price6;
			$s4_price7_total += $price7;
			$s4_price8_total += $price8;
			$s4_price9_total += $row['ne_price9'];
			$s4_price10_total += $row['ne_price10'];
			$s4_price11_total += $row['ne_price11'];
			$s4_price12_total += $row['ne_price12'];
			$s4_price13_total += $row['ne_price13'];
			$s4_price14_total += $row['ne_price14'];
			$s4_price15_total += $row['ne_price15'];
			$s4_price16_total += $row['ne_price16'];
			$s4_price17_total += $row['ne_price17'];
			$s4_price18_total += $row['ne_price18'];
			}
			
			unset($i);
			unset($row);
			}
		  ?>
		  </tbody>
          <tr class="row81" style="background:#EAF1DD">
            <td class="column1 style136 s style138" colspan="3">소     계</td>
            <td class="column4 style139 null"></td>
            <td class="column5 style140 null"></td>
            <td class="column6 style141 f"></td>
            <td class="column6 style141 f"><?php echo number_format($s4_price1_total)?></td>
            <td class="column7 style141 f"><?php echo number_format($s4_price2_total)?></td>
            <td class="column8 style142 f"><?php echo number_format($s4_price3_total)?></td>
            <td class="column9 style143 f"><?php echo number_format($s4_price4_total)?></td>
            <td class="column10 style144 f"><?php echo number_format($s4_price5_total)?></td>
            <td class="column11 style145 f"><?php echo number_format($s4_price6_total)?></td>
            <td class="column12 style143 f"><?php echo number_format($s4_price7_total)?></td>
            <td class="column13 style146 f"><?php echo number_format($s4_price8_total)?></td>
            <td class="column14 style147 f"><?php echo number_format($s4_price9_total)?></td>
            <td class="column15 style143 f"><?php echo number_format($s4_price10_total)?></td>
            <td class="column16 style143 f"><?php echo number_format($s4_price11_total)?></td>
            <td class="column17 style143 f"><?php echo number_format($s4_price12_total)?></td>
            <td class="column18 style143 f"><?php echo number_format($s4_price13_total)?></td>
            <td class="column19 style148 f"><?php echo number_format($s4_price14_total)?></td>
            <td class="column20 style145 f"><?php echo number_format($s4_price15_total)?></td>
            <td class="column21 style143 f"><?php echo number_format($s4_price16_total)?></td>
            <td class="column22 style144 f"><?php echo number_format($s4_price17_total)?></td>
            <td class="column23 style141 f"><?php echo number_format($s4_price18_total)?></td>
            <td class="column24 style149 null"></td>
            <td class="column25 style150 null"></td>
            <td class="column26 style150 null"></td>
            <td class="column26 style150 null"></td>
            <td class="column27 style151 null"></td>
          </tr>
		  
		  <tbody id="s5_add_line">
			<?php if($mode5 == '') {?>
          <tr class="row82">
            <td class="column0 style152 s style160" rowspan="11" id="s5_add_tit" align="center">기<br><br>타<br><br>경<br><br>비<br></td>
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
		  <tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr><tr class="row82">
           
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"></td>
            <td class="column4 style40 null"></td>
            <td class="column5 style41 null"></td>
            <td class="column6 style42 null"></td>
            <td class="column7 style43 null"></td>
            <td class="column8 style44 null"></td>
            <td class="column9 style45 null"></td>
            <td class="column10 style46 null"></td>
            <td class="column11 style47 null"></td>
            <td class="column12 style45 null"></td>
            <td class="column13 style48 null"></td>
            <td class="column14 style49 null"></td>
            <td class="column15 style50 null"></td>
            <td class="column16 style45 null"></td>
            <td class="column17 style45 null"></td>
            <td class="column18 style45 null"></td>
            <td class="column19 style51 null"></td>
            <td class="column20 style47 null"></td>
            <td class="column21 style45 null"></td>
            <td class="column22 style46 null"></td>
            <td class="column23 style52 null"></td>
            <td class="column24 style53 null"></td>
            <td class="column25 style54 null"></td>
            <td class="column26 style55 null"></td>
			
            <td class="column26 style55 null"></td>
            <td class="column27 style56 null"></td>
          </tr>
		  
		  <?php } else if($mode5 == 'u') {
				
			   $cnt5 = sql_num_rows($rst5);
			  unset($i);
			  unset($row);
			  for($i=0; $row=sql_fetch_array($rst5); $i++) {
					
				if($date != $row['ne_date']) {
					$readonly = "readonly";
					$row['ne_etc'] = '';
				}
				
					
				$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date = '{$date}'");
				
				$row['ne_price9'] = $p['ne_price9'];
				$row['ne_price10'] = $p['ne_price10'];
				$row['ne_price11'] = $p['ne_price11'];
				$row['ne_price12'] = $p['ne_price12'];
				$row['ne_price13'] = $p['ne_price13'];
				$row['ne_price14'] = $p['ne_price14'];
					
				
				if($row['ne_admin'] == 1) $bonsa = 'style="color:red;font-weight:600;width:80%;"';
				else $bonsa = "";
				
				
				//전회 
				$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$date}'";
				$pprst = sql_query($ppsql);
				
				while($pp=sql_fetch_array($pprst)) {
					$price6 = (int)$pp['price6']; //공급가액
					$price7 = (int)$pp['price7']; //부가세
					$price8 = (int)$pp['price8']; //합계
				}
				
				
				//누계
				$row['ne_price15'] = $price6 + $row['ne_price9'];
				$row['ne_price16'] = $price7 + $row['ne_price10'];
				$row['ne_price17'] = $price8 + $row['ne_price11'];
				
				//잔여 계약 - 누계
				$row['ne_price18'] = ($row['ne_price15'] + $row['ne_price16']) - $row['ne_price17'];
				
			?>
			<tr class="row82 dataRow_<?php echo $row['seq']?>" >
				<?php if($i==0) {?>
				 <td class="column0 style152 s style160" style="background:#F2DBDB" rowspan="<?php echo $cnt5?>" id="s5_add_tit" align="center">기<br><br>타<br><br>경<br><br>비<br></td>
				<?php }?>
				<td class="column1 style37 null style38" colspan="2">
				
				<?php echo $row['ne_name']?></td>
				<td class="column3 style39 null"><?php echo $row['ne_gongjong']?></td>
				<td class="column4 style40 null"><?php echo $row['ne_sdate']?></td>
				<td class="column5 style41 null"><?php echo $row['ne_edate']?></td>
				<td class="column6 style42 null"><?php echo $row['ne_price1']?></td>
				<td class="column7 style43 null"><?php echo $row['ne_price15']?></td>
				<td class="column8 style44 null"><?php echo $row['ne_price15']?></td>
				<td class="column9 style45 null"><?php echo $row['ne_price16']?></td>
				<td class="column10 style46 null"><?php echo $row['ne_price17']?></td>
				<td class="column11 style47 null"><?php echo $price6?></td>
				<td class="column12 style45 null"><?php echo $price7?></td>
				<td class="column13 style48 null"><?php echo $price8?></td>
				<td class="column14 style49 null"><?php echo $row['ne_price9']?></td>
				<td class="column15 style50 null"><?php echo $row['ne_price10']?></td>
				<td class="column16 style45 null"><?php echo $row['ne_price11']?></td>
				<td class="column17 style45 null"><?php echo $row['ne_price12']?></td>
				<td class="column18 style45 null"><?php echo $row['ne_price13']?></td>
				<td class="column19 style51 null"><?php echo $row['ne_price14']?></td>
				<td class="column20 style47 null"><?php echo $row['ne_price15']?></td>
				<td class="column21 style45 null"><?php echo $row['ne_price16']?></td>
				<td class="column22 style46 null"><?php echo $row['ne_price17']?></td>
				<td class="column23 style52 null"><?php echo $row['ne_price18']?></td>
				<td class="column24 style53 null"><?php echo $row['ne_bank']?></td>
				<td class="column25 style54 null"><?php echo $row['ne_account']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_accname']?></td>
				<td class="column26 style55 null"><?php echo $row['ne_ceo']?></td>
				<td class="column27 style56 null"><?php echo $row['ne_etc']?></td>
			  </tr>
		  
			<?php 
			$s5_price1_total += $row['ne_price1'];
			$s5_price2_total += $row['ne_price15'];
			$s5_price3_total += $row['ne_price15'];
			$s5_price4_total += $row['ne_price16'];
			$s5_price5_total += $row['ne_price17'];
			$s5_price6_total += $price6;
			$s5_price7_total += $price7;
			$s5_price8_total += $price8;
			$s5_price9_total += $row['ne_price9'];
			$s5_price10_total += $row['ne_price10'];
			$s5_price11_total += $row['ne_price11'];
			$s5_price12_total += $row['ne_price12'];
			$s5_price13_total += $row['ne_price13'];
			$s5_price14_total += $row['ne_price14'];
			$s5_price15_total += $row['ne_price15'];
			$s5_price16_total += $row['ne_price16'];
			$s5_price17_total += $row['ne_price17'];
			$s5_price18_total += $row['ne_price18'];
			}
			
			unset($i);
			unset($row);
			}
		  ?>
		  
         </tbody>
        
          <tr class="row101" style="background:#F2DBDB">
            <td class="column1 style161 s style163" colspan="3">소     계</td>
            <td class="column4 style164 null"></td>
            <td class="column5 style165 null"></td>
            <td class="column6 style166 f"></td>
            <td class="column6 style166 f"><?php echo number_format($s5_price1_total)?></td>
            <td class="column7 style166 f"><?php echo number_format($s5_price2_total)?></td>
            <td class="column8 style167 f"><?php echo number_format($s5_price3_total)?></td>
            <td class="column9 style168 f"><?php echo number_format($s5_price4_total)?></td>
            <td class="column10 style169 f"><?php echo number_format($s5_price5_total)?></td>
            <td class="column11 style170 f"><?php echo number_format($s5_price6_total)?></td>
            <td class="column12 style168 f"><?php echo number_format($s5_price7_total)?></td>
            <td class="column13 style171 f"><?php echo number_format($s5_price8_total)?></td>
            <td class="column14 style172 f"><?php echo number_format($s5_price9_total)?></td>
            <td class="column15 style168 f"><?php echo number_format($s5_price10_total)?></td>
            <td class="column16 style168 f"><?php echo number_format($s5_price11_total)?></td>
            <td class="column17 style168 f"><?php echo number_format($s5_price12_total)?></td>
            <td class="column18 style168 f"><?php echo number_format($s5_price13_total)?></td>
            <td class="column19 style173 f"><?php echo number_format($s5_price14_total)?></td>
            <td class="column20 style170 f"><?php echo number_format($s5_price15_total)?></td>
            <td class="column21 style168 f"><?php echo number_format($s5_price16_total)?></td>
            <td class="column22 style169 f"><?php echo number_format($s5_price17_total)?></td>
            <td class="column23 style166 f"><?php echo number_format($s5_price18_total)?></td>
            <td class="column24 style174 null"></td>
            <td class="column25 style175 null"></td>
            <td class="column26 style175 null"></td>
            <td class="column26 style175 null"></td>
            <td class="column27 style176 null"></td>
          </tr>
        </tbody>
    </table>
	