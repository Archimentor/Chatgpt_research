<?php 

include('./include/a_update_table.php');

$chk = sql_fetch("select * from {$none['est_foodcost']} where  nw_code = '{$work['nw_code']}' and ne_date = '$date'");
?>
<form name="frm" action="./update/inc/menu5_update.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="mode" value="<?php echo $mode?>">
<input type="hidden" name="nw_code" id="nw_code" value="<?php echo $work['nw_code']?>">
<input type="hidden" name="ne_date" value="<?php echo $date?>">
<input type="hidden" name="seq" value="<?php echo $row['seq']?>">

<div class="print_frm">
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0" style="width:1500px">
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
        <col class="col57">
        <col class="col58">
        <col class="col59">
        <col class="col60">
        <col class="col61">
        <tbody id="rowbody">
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
            <td class="column57">&nbsp;</td>
            <td class="column58">&nbsp;</td>
            <td class="column59">&nbsp;</td>
            <td class="column60">&nbsp;</td>
            <td class="column61">&nbsp;</td>
        
          </tr>
          <tr class="row1">
            <td class="column0 style44 s style44" colspan="31" rowspan="4"><?php echo date('Y년 m월', strtotime($date))?>   식  대  내  역</td>
            <td class="column31 style45 null"></td>
            <td class="column32 style45 null"></td>
            <td class="column33 style45 null"></td>
            <td class="column34 style45 null"></td>
            <td class="column35 style45 null"></td>
            <td class="column36 style45 null"></td>
            <td class="column37 style45 null"></td>
            <td class="column38 style45 null"></td>
            <td class="column39 style45 null"></td>
            <td class="column40 style45 null"></td>
            <td class="column41 style45 null"></td>
            <td class="column42 style45 null"></td>
            <td class="column43 style45 null"></td>
            <td class="column44 style45 null"></td>
            <td class="column45 style45 null"></td>
            <td class="column46 style45 null"></td>
            <td class="column47 style45 null"></td>
            <td class="column48 style45 null"></td>
            <td class="column49 style45 null"></td>
            <td class="column50 style45 null"></td>
            <td class="column51 style45 null"></td>
            <td class="column52 style45 null"></td>
            <td class="column53 style45 null"></td>
            <td class="column54 style45 null"></td>
            <td class="column55 style45 null"></td>
            <td class="column56 style45 null"></td>
            <td class="column57 style45 null"></td>
            <td class="column58 style45 null"></td>
            <td class="column59 style45 null"></td>
            <td class="column60 style45 null"></td>
            <td class="column61 style45 null"></td>
            
          </tr>
          <tr class="row2">
            <td class="column31 style45 null"></td>
            <td class="column32 style45 null"></td>
            <td class="column33 style45 null"></td>
            <td class="column34 style45 null"></td>
            <td class="column35 style45 null"></td>
            <td class="column36 style45 null"></td>
            <td class="column37 style45 null"></td>
            <td class="column38 style45 null"></td>
            <td class="column39 style45 null"></td>
            <td class="column40 style45 null"></td>
            <td class="column41 style45 null"></td>
            <td class="column42 style45 null"></td>
            <td class="column43 style45 null"></td>
            <td class="column44 style45 null"></td>
            <td class="column45 style45 null"></td>
            <td class="column46 style45 null"></td>
            <td class="column47 style45 null"></td>
            <td class="column48 style45 null"></td>
            <td class="column49 style45 null"></td>
            <td class="column50 style45 null"></td>
            <td class="column51 style45 null"></td>
            <td class="column52 style45 null"></td>
            <td class="column53 style45 null"></td>
            <td class="column54 style45 null"></td>
            <td class="column55 style45 null"></td>
            <td class="column56 style45 null"></td>
            <td class="column57 style45 null"></td>
            <td class="column58 style45 null"></td>
            <td class="column59 style45 null"></td>
            <td class="column60 style45 null"></td>
            <td class="column61 style45 null"></td>
           
          </tr>
          <tr class="row3">
            <td class="column31 style45 null"></td>
            <td class="column32 style45 null"></td>
            <td class="column33 style45 null"></td>
            <td class="column34 style45 null"></td>
            <td class="column35 style45 null"></td>
            <td class="column36 style45 null"></td>
            <td class="column37 style45 null"></td>
            <td class="column38 style45 null"></td>
            <td class="column39 style45 null"></td>
            <td class="column40 style45 null"></td>
            <td class="column41 style45 null"></td>
            <td class="column42 style45 null"></td>
            <td class="column43 style45 null"></td>
            <td class="column44 style45 null"></td>
            <td class="column45 style45 null"></td>
            <td class="column46 style45 null"></td>
            <td class="column47 style45 null"></td>
            <td class="column48 style45 null"></td>
            <td class="column49 style45 null"></td>
            <td class="column50 style45 null"></td>
            <td class="column51 style45 null"></td>
            <td class="column52 style45 null"></td>
            <td class="column53 style45 null"></td>
            <td class="column54 style45 null"></td>
            <td class="column55 style45 null"></td>
            <td class="column56 style45 null"></td>
            <td class="column57 style45 null"></td>
            <td class="column58 style45 null"></td>
            <td class="column59 style45 null"></td>
            <td class="column60 style45 null"></td>
            <td class="column61 style45 null"></td>
           
          </tr>
          <tr class="row4">
            <td class="column31 style43 null"></td>
            <td class="column32 style43 null"></td>
            <td class="column33 style43 null"></td>
            <td class="column34 style43 null"></td>
            <td class="column35 style43 null"></td>
            <td class="column36 style43 null"></td>
            <td class="column37 style43 null"></td>
            <td class="column38 style43 null"></td>
            <td class="column39 style43 null"></td>
            <td class="column40 style43 null"></td>
            <td class="column41 style43 null"></td>
            <td class="column42 style43 null"></td>
            <td class="column43 style43 null"></td>
            <td class="column44 style43 null"></td>
            <td class="column45 style43 null"></td>
            <td class="column46 style43 null"></td>
            <td class="column47 style43 null"></td>
            <td class="column48 style43 null"></td>
            <td class="column49 style43 null"></td>
            <td class="column50 style43 null"></td>
            <td class="column51 style43 null"></td>
            <td class="column52 style43 null"></td>
            <td class="column53 style43 null"></td>
            <td class="column54 style43 null"></td>
            <td class="column55 style43 null"></td>
            <td class="column56">&nbsp;</td>
            <td class="column57">&nbsp;</td>
            <td class="column58">&nbsp;</td>
            <td class="column59">&nbsp;</td>
            <td class="column60">&nbsp;</td>
            <td class="column61">&nbsp;</td>
          
          </tr>
          <tr class="row5">
            <td class="column0 style42 s style40" colspan="4" style="background:#f2f2f2">현 장 명</td>
            <td class="column4 style39 s style37" colspan="19"><?php echo $work['nw_subject']?></td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29">&nbsp;</td>
            <td class="column30 style36 null"></td>
            <td class="column31 style19 s style19" colspan="4" style="background:#f2f2f2">식당명</td>
            <td class="column35 style23 null style21" colspan="10"><input type="text" class="input " name="ne_name" value="<?php echo $chk['ne_name']?>"></td>
            <td class="column45 style20 s style20" colspan="4" style="background:#f2f2f2">예금주</td>
            <td class="column49 style20 null style20" colspan="13"><input type="text" class="input " name="ne_bank" value="<?php echo $chk['ne_bank']?>"></td>
           
          </tr>
          <tr class="row6">
            <td class="column0 style35 s style34" colspan="4" style="background:#f2f2f2">청구기간</td>
            <td class="column4 style33 null style31" colspan="7"><?php echo $date?>-01</td>
            <td class="column11 style32 s style32" colspan="2">~</td>
            <td class="column13 style31 null style31" colspan="7"><?php echo date('Y-m-t', strtotime($date))?></td>
            <td class="column20 style30 null"></td>
            <td class="column21 style30 null"></td>
            <td class="column22 style29 null"></td>
            <td class="column23">&nbsp;</td>
            <td class="column24">&nbsp;</td>
            <td class="column25">&nbsp;</td>
            <td class="column26">&nbsp;</td>
            <td class="column27">&nbsp;</td>
            <td class="column28">&nbsp;</td>
            <td class="column29 style28 null"></td>
            <td class="column30 style27 null"></td>
            <td class="column31 style26 s style24" colspan="4" style="background:#f2f2f2">은행</td>
            <td class="column35 style23 null style21" colspan="10"><input type="text" class="input  " name="ne_account" value="<?php echo $chk['ne_account']?>"></td>
            <td class="column45 style20 s style20" colspan="4" style="background:#f2f2f2">계좌번호</td>
            <td class="column49 style20 null style20" colspan="13"><input type="text" class="input  " name="ne_holder" value="<?php echo $chk['ne_holder']?>"></td>
            
          </tr>
          <tr class="row7">
            <td class="column0 style19 s style19" colspan="4" rowspan="2" style="background:#f2f2f2">거래일자</td>
            <td class="column4 style19 s style19" colspan="9" style="background:#f2f2f2">조      식</td>
            <td class="column13 style19 s style19" colspan="9" style="background:#f2f2f2">오  전  참</td>
            <td class="column22 style19 s style19" colspan="9" style="background:#f2f2f2">중      식</td>
            <td class="column31 style19 s style19" colspan="9" style="background:#f2f2f2">오  후  참</td>
            <td class="column40 style19 s style19" colspan="9" style="background:#f2f2f2">석      식</td>
            <td class="column49 style19 s style19" colspan="6" style="background:#f2f2f2">음료 및 간식</td>
            <td class="column55 style19 s style19" colspan="7" rowspan="2" style="background:#f2f2f2">비       고</td>
           
          </tr>
          <tr class="row8">
            <td class="column4 style19 s style19" colspan="2">인원</td>
            <td class="column6 style19 s style19" colspan="3">적요</td>
            <td class="column9 style19 s style19" colspan="4">금  액</td>
            <td class="column13 style19 s style19" colspan="2">인원</td>
            <td class="column15 style19 s style19" colspan="3">적요</td>
            <td class="column18 style19 s style19" colspan="4">금  액</td>
            <td class="column22 style19 s style19" colspan="2">인원</td>
            <td class="column24 style19 s style19" colspan="3">적요</td>
            <td class="column27 style19 s style19" colspan="4">금  액</td>
            <td class="column31 style19 s style19" colspan="2">인원</td>
            <td class="column33 style19 s style19" colspan="3">적요</td>
            <td class="column36 style19 s style19" colspan="4">금  액</td>
            <td class="column40 style19 s style19" colspan="2">인원</td>
            <td class="column42 style19 s style19" colspan="3">적요</td>
            <td class="column45 style19 s style19" colspan="4">금  액</td>
            <td class="column49 style19 s style19" colspan="2">인원</td>
            <td class="column51 style19 s style19" colspan="4">금  액</td>
           
          </tr>
		   <?php 
		  
			if(!$chk) {
			for($i=1; $i<=10; $i++) {
			?>
          <tr class="row9">
            <td class="column0 style18 n style18" colspan="4"><input type="date" class="input numb text-center" name="ne_trade_date[]" value="" placeholder="YYYY-MM-DD"></td>
            <td class="column4 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food1_qty[]" value=""><!--조식--></td>
            <td class="column6 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food1_danga[]" value=""></td>
            <td class="column9 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food1_price[]" value=""> </td>
			
            <td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food2_qty[]" value=""><!--오전참--></td>
            <td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food2_danga[]" value=""></td>
            <td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food2_price[]" value=""></td>
			
            <td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food3_qty[]" value=""><!--중식--></td>
            <td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food3_danga[]" value=""></td>
            <td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food3_price[]" value=""></td>
			
            <td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food4_qty[]" value=""><!--오후참--></td>
            <td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food4_danga[]" value=""></td>
            <td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food4_price[]" value=""></td>
			
            <td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food5_qty[]" value=""><!--석식--></td>
            <td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food5_danga[]" value=""></td>
            <td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food5_price[]" value=""></td>
			
            <td class="column49 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food6_qty[]" value=""></td>
            <td class="column51 style14 null style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food6_price[]" value=""></td>
			
            <td class="column55 style17 null style15" colspan="7"><input type="text" class="input numb " style="width:100%"  name="ne_etc[]" value=""></td>
            
          </tr>
		   <?php }
		  
		  
			} else {
				
				$sql = "select * from {$none['est_foodcost']} where  nw_code = '{$work['nw_code']}' and ne_date = '$date'";
				$rst = sql_query($sql);
				for($i=0; $row=sql_fetch_array($rst); $i++) {
					
					$ne_data = explode('|', $row['ne_data']);
					$food1 = explode('^', $ne_data[0]); //조식
					$food2 = explode('^', $ne_data[1]); //오전참
					$food3 = explode('^', $ne_data[2]); //중식
					$food4 = explode('^', $ne_data[3]); //오후참
					$food5 = explode('^', $ne_data[4]); //석식
					$food6 = explode('^', $ne_data[5]); //음료및간식
					$food7 = $ne_data[6]; //기타
					
					
			?>
			 <tr class="row9">
				<td class="column0 style18 n style18" colspan="4"><input type="date" class="input numb text-center" name="ne_trade_date[]" value="<?php echo $food1[0]?>" placeholder="YYYY-MM-DD"></td>
				<td class="column4 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food1_qty[]" value="<?php echo $food1[1]?>"><!--조식--></td>
				<td class="column6 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food1_danga[]" value="<?php echo $food1[2]?>"></td>
				<td class="column9 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food1_price[]" value="<?php echo $food1[3]?>"> </td>
				
				<td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food2_qty[]" value="<?php echo $food2[0]?>"><!--오전참--></td>
				<td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food2_danga[]" value="<?php echo $food2[1]?>"></td>
				<td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food2_price[]" value="<?php echo $food2[2]?>"></td>
				
				<td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food3_qty[]" value="<?php echo $food3[0]?>"><!--중식--></td>
				<td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food3_danga[]" value="<?php echo $food3[1]?>"></td>
				<td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food3_price[]" value="<?php echo $food3[2]?>"></td>
				
				<td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food4_qty[]" value="<?php echo $food4[0]?>"><!--오후참--></td>
				<td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food4_danga[]" value="<?php echo $food4[1]?>"></td>
				<td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food4_price[]" value="<?php echo $food4[2]?>"></td>
				
				<td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food5_qty[]" value="<?php echo $food5[0]?>"><!--석식--></td>
				<td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food5_danga[]" value="<?php echo $food5[1]?>"></td>
				<td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food5_price[]" value="<?php echo $food5[2]?>"></td>
				
				<td class="column49 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food6_qty[]" value="<?php echo $food6[0]?>"><!--음료및간식--></td>
				<td class="column51 style14 null style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food6_price[]" value="<?php echo $food6[1]?>"></td>
				
				<td class="column55 style17 null style15" colspan="7"><input type="text" class="input numb " name="ne_etc[]" style="width:100%" value="<?php echo $food7?>"></td>
				
			  </tr>
			  
				<?php 
				
				$food1_qty_total += (int)$food1[1];
				$food1_price_total +=  (int)$food1[3];
				
				$food2_qty_total += (int)$food2[0];
				$food2_price_total +=  (int)$food2[2];
				
				$food3_qty_total += (int)$food3[0];
				$food3_price_total +=  (int)$food3[2];
				
				$food4_qty_total += (int)$food4[0];
				$food4_price_total +=  (int)$food4[2];
				
				$food5_qty_total += (int)$food5[0];
				$food5_price_total +=  (int)$food5[2];
				
				$food6_qty_total += (int)$food6[0];
				$food6_price_total +=  (int)$food6[1];
				
				
				}?>
			
        </tbody>
		 <tr class="row11" style="border-top:2px solid #000;background:#EAF1DD">
				<td class="column0 style5 s style5" colspan="4">소 계</td>
				<td class="column4 style4 f style4" style="padding-right:3px;" colspan="2"><?php echo number_format($food1_qty_total)?></td>
				<td class="column6 style4 null style4" colspan="3"></td>
				<td class="column9 style4 f style4" style="padding-right:3px" colspan="4"><?php echo number_format($food1_price_total)?> </td>
				<td class="column13 style4 f style4" style="padding-right:3px" colspan="2"><?php echo number_format($food2_qty_total)?> </td>
				<td class="column15 style4 null style4" colspan="3"></td>
				<td class="column18 style4 f style4" style="padding-right:3px" colspan="4"><?php echo number_format($food2_price_total)?></td>
				<td class="column22 style4 f style4" style="padding-right:3px" colspan="2"><?php echo number_format($food3_qty_total)?> </td>
				<td class="column24 style4 null style4" colspan="3"></td>
				<td class="column27 style4 f style4" style="padding-right:3px" colspan="4"><?php echo number_format($food3_price_total)?></td>
				<td class="column31 style4 f style4" style="padding-right:3px" colspan="2"><?php echo number_format($food4_qty_total)?> </td>
				<td class="column33 style4 null style4" colspan="3"></td>
				<td class="column36 style4 f style4" style="padding-right:3px" colspan="4"><?php echo number_format($food4_price_total)?></td>
				<td class="column40 style4 f style4" style="padding-right:3px" colspan="2"><?php echo number_format($food5_qty_total)?> </td>
				<td class="column42 style4 null style4" colspan="3"></td>
				<td class="column45 style4 f style4" style="padding-right:3px" colspan="4"><?php echo number_format($food5_price_total)?></td>
				<td class="column49 style4 f style4" style="padding-right:3px" colspan="2"><?php echo number_format($food6_qty_total)?> </td>
				<td class="column51 style4 f style4" style="padding-right:3px" colspan="4"><?php echo number_format($food6_price_total)?></td>
				<td class="column55 style6 null style6" colspan="7"></td>
				
			  </tr>
			  <tr class="row12">
				<td class="column0 style5 s style5" colspan="4">합계</td>
				<td class="column4 style4 f style4" style="padding-right:3px" colspan="9">
				<?php
				$price_total = $food1_price_total + $food2_price_total + $food3_price_total + $food4_price_total + $food5_price_total + $food6_price_total;
				echo number_format($price_total)?></td>
				<td class="column13 style3 null style3" colspan="49"></td>
				
			  </tr>
		  <?php }?>
    </table>
	</div>
	<div class="modal-footer">
	
		<button type="button" class="btn btn-secondary" onclick="onPrint()" data-dismiss="modal">인쇄</button>
		<button type="button" class="btn btn-secondary" onclick="add()">칸추가</button>
		<button type="submit" class="btn btn-primary"data-dismiss="modal">업데이트</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">목록</button>
	</div>
	</form>
	
	<script>
		function add() {
			
			//var s = $('#rowbody').find('.row2').length + 1;
			var html = "";
			
			html += '<tr class="row9">';
            html += '<td class="column0 style18 n style18" colspan="4"><input type="date" class="input numb text-center" name="ne_trade_date[]" value="" placeholder="YYYY-MM-DD"></td>';
            html += '<td class="column4 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food1_qty[]" value=""></td>';
            html += '<td class="column6 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food1_danga[]" value=""></td>';
            html += '<td class="column9 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food1_price[]" value=""> </td>';
			
            html += '<td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food2_qty[]" value=""></td>';
            html += '<td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food2_danga[]" value=""></td>';
            html += '<td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food2_price[]" value=""></td>';
			
            html += '<td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food3_qty[]" value=""></td>';
            html += '<td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food3_danga[]" value=""></td>';
            html += '<td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food3_price[]" value=""></td>';
			
            html += '<td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food4_qty[]" value=""></td>';
            html += '<td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food4_danga[]" value=""></td>';
            html += '<td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food4_price[]" value=""></td>';
			
            html += '<td class="column13 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food5_qty[]" value=""></td>';
            html += '<td class="column15 style14 null style14" colspan="3"><input type="text" class="input numb " name="ne_food5_danga[]" value=""></td>';
            html += '<td class="column18 style14 f style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food5_price[]" value=""></td>';
			
            html += '<td class="column49 style14 null style14" colspan="2"><input type="text" class="input numb text-right" name="ne_food6_qty[]" value=""></td>';
            html += '<td class="column51 style14 null style14" colspan="4"><input type="text" class="input numb text-right" name="ne_food6_price[]" value=""></td>';
			
            html += '<td class="column55 style17 null style15" colspan="7"><input type="text" class="input numb " name="ne_etc[]" style="width:100%"  value=""></td>';

			html += '</tr>';
		
			
			
			 $('#rowbody').append(html);
			
		}
		</script>