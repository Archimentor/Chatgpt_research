<?php if(!defined('menu_establishment')) exit;

$chk2 = sql_fetch("select count(*) as cnt from {$none['est_noim2']}  where ne_name != '' and ne_sort = 2 and ne_date = '{$date}' and nw_code = '{$work['nw_code']}'");
$chk3 = sql_fetch("select count(*) as cnt from {$none['est_noim2']}  where ne_name != '' and ne_sort = 3 and ne_date = '{$date}' and nw_code = '{$work['nw_code']}'");
?>

<?php if($chk2['cnt']) {?>
<div style="overflow-x:scroll;margin-top:40px">

<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width:180%">

 <tbody>
          <tr class="row0">
            <td class="column0">&nbsp;</td>
            <td class="column1 style52 s style24" colspan="4" rowspan="2">기    간</td>
            <td class="column5 style44 null style45" colspan="4" rowspan="2"><input type="text" class="input" value="<?php echo $date?>-01" style="width:80px" readonly></td>
            <td class="column9 style23 s style23" rowspan="2" style="width:200px">~</td>
            <td class="column10 style30 null style31" colspan="4" rowspan="2" style="width:200px"><input type="text" class="input"  style="width:80px"value="<?php echo $date?>-<?php echo date('t')?>" style="width:80px" readonly></td>
            <td class="column14 style32 null style35" colspan="2" rowspan="2" style="width:100px"><input type="text" class="input text-right" readonly value="<?php echo date('t')?>"></td>
            <td class="column16 style23 s style24" colspan="2" rowspan="2" style="width:100px">일간</td>
            <td class="column18 style103 s style106 text-left"  rowspan="4" style="padding-left:15px" ><?php echo date('Y년 m월', strtotime($date))?>  일용노무비지급명세서</td>
		
            
          </tr>
          <tr class="row1">
            <td class="column0">&nbsp;</td>
            
          </tr>
          <tr class="row2">
            <td class="column0">&nbsp;</td>
            <td class="column1 style52 s style24" colspan="4" rowspan="2">현 장 명</td>
            <td class="column5 style46 f style51" colspan="13" rowspan="2" style="font-size:10pt;width:20%">&nbsp;<?php echo $work['nw_subject']?></td>
            
          </tr>
          <tr class="row3">
            <td class="column0">&nbsp;</td>
            
          </tr>
	</tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width:180%">
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
        <col class="col62">
        <col class="col63">
        <col class="col64">
        <col class="col65">
        <col class="col66">
        <col class="col67">
        <col class="col68">
        <col class="col69">
        <col class="col70">
        <col class="col71">
        <col class="col72">
        <col class="col73">
        <col class="col74">
        <col class="col75">
        <tbody>
          
          <tr class="row4">
            <td class="column0">&nbsp;</td>
            <td class="column1 style25 s style25" rowspan="4">NO</td>
            <td class="column2 style25 s style25" colspan="3" rowspan="4" style="width:150px">성  명</td>
            <td class="column5 style25 s style25" colspan="3" rowspan="4" style="width:100px">직  종</td>
            <td class="column8 style115 s style61 jumin_td" colspan="4" rowspan="4" style="width:115px">주민번호
            <td class="column8 style115 s style61 tel_td" colspan="4" rowspan="4" style="width:105px">휴대폰번호</td>
            <td class="column12 style68 s style61 addr_td" colspan="6" rowspan="4" style="width:215px">주        소</td>
            <td class="column18 style72 s style74" colspan="16" style="width:415px">출  력  일  자</td>
            <td class="column34 style75 s style27" colspan="2" rowspan="2" style="width:70px">출력</td>
            <td class="column36 style68 s style61" colspan="2" rowspan="4" style="width:70px">공수</td>
            <td class="column38 style25 s style25" colspan="3" rowspan="4" style="width:100px">단  가</td>
            <td class="column41 style25 s style25" colspan="4" rowspan="4" style="width:150px">총    액</td>
            <td class="column45 style53 s style53" colspan="13">공  제  내  역</td>
            <td class="column58 style25 s style25" colspan="4" rowspan="4"  style="width:150px">차인지급액</td>
            <td class="column62 style72 s style19" colspan="11" rowspan="2">결 제 정 보</td>
            <td class="column73 style25 s style25" colspan="3" rowspan="4" style="width:100px">비  고</td>
            <td class="column73 style25 s style25" colspan="3" rowspan="4" style="width:100px">업체선택</td>
            <td class="column73 style25 s style25" colspan="3" rowspan="4"  rowspan="4" style="width:60px">기산일</td>
            
          </tr>
          <tr class="row5">
            <td class="column0">&nbsp;</td>
            <td class="column18 style29 s style29" rowspan="2">01</td>
            <td class="column19 style26 s style26" rowspan="2">02</td>
            <td class="column20 style26 s style26" rowspan="2">03</td>
            <td class="column21 style26 s style26" rowspan="2">04</td>
            <td class="column22 style26 s style26" rowspan="2">05</td>
            <td class="column23 style26 s style26" rowspan="2">06</td>
            <td class="column24 style26 s style26" rowspan="2">07</td>
            <td class="column25 style26 s style26" rowspan="2">08</td>
            <td class="column26 style26 s style26" rowspan="2">09</td>
            <td class="column27 style26 s style26" rowspan="2">10</td>
            <td class="column28 style26 s style26" rowspan="2">11</td>
            <td class="column29 style26 s style26" rowspan="2">12</td>
            <td class="column30 style26 s style26" rowspan="2">13</td>
            <td class="column31 style26 s style26" rowspan="2">14</td>
            <td class="column32 style26 s style26" rowspan="2">15</td>
            <td class="column33 style71 null style71" rowspan="2"></td>
            <td class="column45 style67 s style18" colspan="3" rowspan="2" style="width:80px">국민연금</td>
            <td class="column48 style18 s style18" colspan="3" rowspan="2" style="width:80px">장기요양</td>
            <td class="column51 style18 s style19" colspan="3" rowspan="2" style="width:80px">소득세</td>
            <td class="column54 style54 s style55" colspan="4" rowspan="3" style="width:80px">공제금액</td>
            
          </tr>
          <tr class="row6">
            <td class="column0">&nbsp;</td>
            <td class="column34 style27 s style28" colspan="2" rowspan="2">일수</td>
            <td class="column62 style67 s style20" colspan="2" rowspan="2" style="width:100px">은행명</td>
            <td class="column64 style18 s style20" colspan="6" rowspan="2" style="width:215px">계좌번호</td>
            <td class="column70 style18 s style21" colspan="3" rowspan="2"  style="width:100px">예금주</td>
            
          </tr>
          <tr class="row7">
            <td class="column0 style4 s">나이</td>
            <td class="column18 style13 s">16</td>
            <td class="column19 style12 s">17</td>
            <td class="column20 style12 s">18</td>
            <td class="column21 style12 s">19</td>
            <td class="column22 style12 s">20</td>
            <td class="column23 style12 s">21</td>
            <td class="column24 style12 s">22</td>
            <td class="column25 style12 s">23</td>
            <td class="column26 style12 s">24</td>
            <td class="column27 style12 s">25</td>
            <td class="column28 style12 s">26</td>
            <td class="column29 style12 s">27</td>
            <td class="column30 style12 s">28</td>
            <td class="column31 style12 s">29</td>
            <td class="column32 style12 s">30</td>
            <td class="column33 style11 s">31</td>
            <td class="column45 style22 s style20" colspan="3" style="width:80px">건강보험</td>
            <td class="column48 style20 s style20" colspan="3" style="width:80px">고용보험</td>
            <td class="column51 style20 s style21" colspan="3" style="width:80px">지방소득세</td>
            
          </tr>
		  
		  <?php 
			unset($i);
			unset($row);
		  
		  for($i=1; $i<=15; $i++){
			$limit = " limit ".($i-1).", 15";
			$row2 = sql_fetch("select * from  {$none['est_noim2']}  where ne_sort = 2 and ne_date = '{$date}' and nw_code = '{$work['nw_code']}' order by seq asc $limit  ");
			
			$day = explode('|', $row2['ne_day']);
			for($a=0; $a<count($day); $a++) {
					
					if($day[$a] == 0)
						$day[$a] = "";
					else 
						$day[$a] = $day[$a];
				}
		  ?>
          <tr class="row8">
            <td class="column0 style63 f style63" rowspan="2"></td>
            <td class="column1 style64 s style64 no" rowspan="2"><?php echo ($i+15)?></td>
            <td class="column2 style65 f style65" colspan="3" rowspan="2"><input type="text" class="input name" name="ne_name[]" value="<?php echo $row2['ne_name']?>"></td>
            <td class="column5 style65 f style65" colspan="3" rowspan="2"><input type="text" class="input gongjong" name="ne_gongjong[]" value="<?php echo $row2['ne_gongjong']?>"></td>
            <td class="column8 style108 f style113" colspan="4" rowspan="2"><input type="text" class="input numb" name="ne_num[]" value="<?php echo $row2['ne_num']?>"></td>
            <td class="column8 style108 f style113" colspan="4" rowspan="2"><input type="text" class="input hp" name="ne_hp[]" value="<?php echo $row2['ne_hp']?>"></td>
            <td class="column12 style66 f style66" colspan="6"><input type="text" class="input addr1" name="ne_addr1[]" value="<?php echo $row2['ne_addr1']?>"></td>
            <td class="column18 style17 null"><input type="text" class="input dayinput" name="ne_day1[]" value="<?php echo $day[0]?>"></td>
            <td class="column19 style16 null"><input type="text" class="input dayinput" name="ne_day2[]" value="<?php echo $day[1]?>"></td>
            <td class="column20 style16 null"><input type="text" class="input dayinput" name="ne_day3[]" value="<?php echo $day[2]?>"></td>
            <td class="column21 style16 null"><input type="text" class="input dayinput" name="ne_day4[]" value="<?php echo $day[3]?>"></td>
            <td class="column22 style16 null"><input type="text" class="input dayinput" name="ne_day5[]" value="<?php echo $day[4]?>"></td>
            <td class="column23 style16 null"><input type="text" class="input dayinput" name="ne_day6[]" value="<?php echo $day[5]?>"></td>
            <td class="column24 style16 null"><input type="text" class="input dayinput" name="ne_day7[]" value="<?php echo $day[6]?>"></td>
            <td class="column25 style16 null"><input type="text" class="input dayinput" name="ne_day8[]" value="<?php echo $day[7]?>"></td>
            <td class="column26 style16 null"><input type="text" class="input dayinput" name="ne_day9[]" value="<?php echo $day[8]?>"></td>
            <td class="column27 style16 null"><input type="text" class="input dayinput" name="ne_day10[]" value="<?php echo $day[9]?>"></td>
            <td class="column28 style16 null"><input type="text" class="input dayinput" name="ne_day11[]" value="<?php echo $day[10]?>"></td>
            <td class="column29 style16 null"><input type="text" class="input dayinput" name="ne_day12[]" value="<?php echo $day[11]?>"></td>
            <td class="column30 style16 null"><input type="text" class="input dayinput" name="ne_day13[]" value="<?php echo $day[12]?>"></td>
            <td class="column31 style16 null"><input type="text" class="input dayinput" name="ne_day14[]" value="<?php echo $day[13]?>"></td>
            <td class="column32 style16 null"><input type="text" class="input dayinput" name="ne_day15[]" value="<?php echo $day[14]?>"></td>
            <td class="column33 style15 null"></td>
            <td class="column34 style84 f style85" colspan="2" rowspan="2"><input type="text" class="input text-center ne_day_total" name="ne_day_total[]" value="<?php echo $row2['ne_day_total']?>" readonly> </td>
            <td class="column36 style42 f style43" colspan="2" rowspan="2"><input type="text" class="input text-center ne_gongsu" name="ne_gongsu[]" value="<?php echo $row2['ne_gongsu']?>"> </td>
            <td class="column38 style42 null style43" colspan="3" rowspan="2"><input type="text" class="input text-right ne_danga" name="ne_danga[]"  value="<?php echo $row2['ne_danga']?>"></td>
            <td class="column41 style42 f style43" colspan="4" rowspan="2"><input type="text" class="input text-right ne_mny_total" name="ne_mny_total[]" value="<?php echo $row2['ne_mny_total']?>"></td>
            <td class="column45 style83 f style76" colspan="3"><input type="text" class="input text-right ne_tax1" name="ne_tax1[]"  value="<?php echo $row2['ne_tax1']?>"></td>
            <td class="column48 style76 f style76" colspan="3"><input type="text" class="input text-right ne_tax2" name="ne_tax2[]"  value="<?php echo $row2['ne_tax2']?>"></td>
            <td class="column51 style76 f style77" colspan="3"><input type="text" class="input text-right ne_tax3" name="ne_tax3[]"  value="<?php echo $row2['ne_tax3']?>"></td>
            <td class="column54 style42 f style43" colspan="4" rowspan="2"><input type="text" class="input text-right ne_tax_total" name="ne_tax_total[]"  value="<?php echo $row2['ne_tax_total']?>"></td>
            <td class="column58 style42 f style43" colspan="4" rowspan="2"><input type="text" class="input text-right ne_mny_last" name="ne_mny_last[]"  value="<?php echo $row2['ne_mny_last']?>"></td>
            <td class="column62 style36 f style39" colspan="2" rowspan="2"><input type="text" class="input bank" name="ne_bank[]"  value="<?php echo $row2['ne_bank']?>"></td>
            <td class="column64 style37 f style39" colspan="6" rowspan="2"><input type="text" class="input account" name="ne_account[]"  value="<?php echo $row2['ne_account']?>"></td>
            <td class="column70 style37 f style80" colspan="3" rowspan="2"><input type="text" class="input accname" name="ne_accname[]"  value="<?php echo $row2['ne_accname']?>"></td>
            <td class="column73 style81 null style82" colspan="3" rowspan="2"><input type="text" class="input" name="ne_etc[]"  value="<?php echo $row2['ne_etc']?>"></td>
            <td class="column73 style81 null style82" colspan="3" rowspan="2">
			<select name="ne_company[]" class="ne_company input" >
				<option value="">선택하세요.</option>
				<?php 
				$sql = "select * from {$none['est_noim']} where ne_date <= '{$date}'  and nw_code = '{$work['nw_code']}' and ne_type = 2";
				$rst = sql_query($sql);
				while($com = sql_fetch_array($rst)) {
				?>
				<option value="<?php echo $com['seq']?>" <?php echo get_selected($row2['ne_company'], $com['seq'])?>><?php echo $com['ne_name']?>(<?php echo $com['ne_gongjong']?>)</option>
				<?php }?>
			</select>
			
			</td>
            <td class="column73 style81 null style82" colspan="3" rowspan="2"><input type="checkbox" name="ne_gisan[2][<?php echo ($i-1)?>]" class="ne_gisan"  value="1" <?php echo get_checked($row2['ne_gisan'], 1)?>></td>
            
          </tr>
          <tr class="row9">
            <td class="column12 style62 f style62" colspan="6"><input type="text" class="input addr2" name="ne_addr2[]" value="<?php echo $row2['ne_addr2']?>"></td>
            <td class="column18 style14 null"><input type="text" class="input dayinput2 white" name="ne_day16[]" value="<?php echo $day[15]?>"></td>
            <td class="column19 style14 null"><input type="text" class="input dayinput2 white" name="ne_day17[]" value="<?php echo $day[16]?>"></td>
            <td class="column20 style14 null"><input type="text" class="input dayinput2 white" name="ne_day18[]" value="<?php echo $day[17]?>"></td>
            <td class="column21 style14 null"><input type="text" class="input dayinput2 white" name="ne_day19[]" value="<?php echo $day[18]?>"></td>
            <td class="column22 style14 null"><input type="text" class="input dayinput2 white" name="ne_day20[]" value="<?php echo $day[19]?>"></td>
            <td class="column23 style14 null"><input type="text" class="input dayinput2 white" name="ne_day21[]" value="<?php echo $day[20]?>"></td>
            <td class="column24 style14 null"><input type="text" class="input dayinput2 white" name="ne_day22[]" value="<?php echo $day[21]?>"></td>
            <td class="column25 style14 null"><input type="text" class="input dayinput2 white" name="ne_day23[]" value="<?php echo $day[22]?>"></td>
            <td class="column26 style14 null"><input type="text" class="input dayinput2 white" name="ne_day24[]" value="<?php echo $day[23]?>"></td>
            <td class="column27 style14 null"><input type="text" class="input dayinput2 white" name="ne_day25[]" value="<?php echo $day[24]?>"></td>
            <td class="column28 style14 null"><input type="text" class="input dayinput2 white" name="ne_day26[]" value="<?php echo $day[25]?>"></td>
            <td class="column29 style14 null"><input type="text" class="input dayinput2 white" name="ne_day27[]" value="<?php echo $day[26]?>"></td>
            <td class="column30 style14 null"><input type="text" class="input dayinput2 white" name="ne_day28[]" value="<?php echo $day[27]?>"></td>
            <td class="column31 style14 null"><input type="text" class="input dayinput2 white" name="ne_day29[]" value="<?php echo $day[28]?>"></td>
            <td class="column32 style14 null"><input type="text" class="input dayinput2 white" name="ne_day30[]" value="<?php echo $day[29]?>"></td>
            <td class="column33 style14 null"><input type="text" class="input dayinput2 white" name="ne_day31[]" value="<?php echo $day[30]?>"></td>
            <td class="column45 style78 f style40" colspan="3"><input type="text" class="input text-right ne_tax4" name="ne_tax4[]"  value="<?php echo $row2['ne_tax4']?>"></td>
            <td class="column48 style40 f style40" colspan="3"><input type="text" class="input text-right ne_tax5" name="ne_tax5[]"  value="<?php echo $row2['ne_tax5']?>"></td>
            <td class="column51 style40 f style41" colspan="3"><input type="text" class="input text-right ne_tax6" name="ne_tax6[]"  value="<?php echo $row2['ne_tax6']?>"> </td>
            
          </tr>
		  <?php 
			$ne_day_total2 += $row2['ne_day_total'];
			$ne_gongsu2 += $row2['ne_gongsu'];
			$ne_danga2 += $row2['ne_danga'];
			$ne_mny_total2 += $row2['ne_mny_total'];
			$ne_tax12 += $row2['ne_tax1'];
			$ne_tax22 += $row2['ne_tax2'];
			$ne_tax32 += $row2['ne_tax3'];
			$ne_tax42 += $row2['ne_tax4'];
			$ne_tax52 += $row2['ne_tax5'];
			$ne_tax62 += $row2['ne_tax6'];
			$ne_tax_total2 += $row2['ne_tax_total'];
			$ne_mny_last2 += $row2['ne_mny_last'];
		  
		  }?>
		 <tr class="total_row" style="border-top:2px solid #000">
			<td  class="column12 style62 f style62 text-center" style="background:#92d4d7;font-weight:bold"  rowspan="2" colspan="37">소계</td>
			<td  class="column12 style62 f style62 text-center" colspan="2" rowspan="2"><?php echo number_format($ne_day_total2)?></td>
			<td  class="column12 style62 f style62 text-center" colspan="2" rowspan="2"><?php echo $ne_gongsu2?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" rowspan="2"><?php echo number_format($ne_danga2)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_mny_total2)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax12)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax22)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax32)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_tax_total2)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_mny_last2)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="21" rowspan="2">&nbsp;</td>
		  </tr>
		  <tr class="total_row" >
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax42)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax52)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax62)?></td>
		  </tr>
		  <tr class="total_row" >
			<td  class="column12 style62 f style62 text-center" style="background:#a1d3f7;font-weight:bold"  rowspan="2" colspan="37">누계</td>
			<td  class="column12 style62 f style62 text-center" colspan="2" rowspan="2"><?php echo number_format($ne_day_total+$ne_day_total2)?></td>
			<td  class="column12 style62 f style62 text-center" colspan="2" rowspan="2"><?php echo ($ne_gongsu + $ne_gongsu2)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" rowspan="2"><?php echo number_format($ne_danga+$ne_danga2)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_mny_total+$ne_mny_total2)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax1+$ne_tax12)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax2+$ne_tax22)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax3+$ne_tax32)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_tax_total+$ne_tax_total2)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_mny_last+$ne_mny_last2)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="21" rowspan="2">&nbsp;</td>
		  </tr>
		  <tr class="total_row" >
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax4+$ne_tax42)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax5+$ne_tax52)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax6+$ne_tax62)?></td>
		  </tr>
		 
        </tbody>
		</table>
		</div>

<?php }?>


<?php if($chk3['cnt']) {?>
<div style="overflow-x:scroll;margin-top:40px">

<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width:180%">

 <tbody>
          <tr class="row0">
            <td class="column0">&nbsp;</td>
            <td class="column1 style52 s style24" colspan="4" rowspan="2">기    간</td>
            <td class="column5 style44 null style45" colspan="4" rowspan="2"><input type="text" class="input" value="<?php echo $date?>-01" style="width:80px" readonly></td>
            <td class="column9 style23 s style23" rowspan="2" style="width:200px">~</td>
            <td class="column10 style30 null style31" colspan="4" rowspan="2" style="width:200px"><input type="text" class="input"  style="width:80px"value="<?php echo $date?>-<?php echo date('t')?>" style="width:80px" readonly></td>
            <td class="column14 style32 null style35" colspan="2" rowspan="2" style="width:100px"><input type="text" class="input text-right" readonly value="<?php echo date('t')?>"></td>
            <td class="column16 style23 s style24" colspan="2" rowspan="2" style="width:100px">일간</td>
            <td class="column18 style103 s style106 text-left"  rowspan="4" style="padding-left:15px" ><?php echo date('Y년 m월', strtotime($date))?>  일용노무비지급명세서</td>
		
            
          </tr>
          <tr class="row1">
            <td class="column0">&nbsp;</td>
            
          </tr>
          <tr class="row2">
            <td class="column0">&nbsp;</td>
            <td class="column1 style52 s style24" colspan="4" rowspan="2">현 장 명</td>
            <td class="column5 style46 f style51" colspan="13" rowspan="2" style="font-size:10pt;width:20%">&nbsp;<?php echo $work['nw_subject']?></td>
            
          </tr>
          <tr class="row3">
            <td class="column0">&nbsp;</td>
            
          </tr>
	</tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width:180%">
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
        <col class="col62">
        <col class="col63">
        <col class="col64">
        <col class="col65">
        <col class="col66">
        <col class="col67">
        <col class="col68">
        <col class="col69">
        <col class="col70">
        <col class="col71">
        <col class="col72">
        <col class="col73">
        <col class="col74">
        <col class="col75">
        <tbody>
          
          <tr class="row4">
            <td class="column0">&nbsp;</td>
            <td class="column1 style25 s style25" rowspan="4">NO</td>
            <td class="column2 style25 s style25" colspan="3" rowspan="4" style="width:150px">성  명</td>
            <td class="column5 style25 s style25" colspan="3" rowspan="4" style="width:100px">직  종</td>
            <td class="column8 style115 s style61" colspan="4" rowspan="4" style="width:115px">주민번호
            <td class="column8 style115 s style61" colspan="4" rowspan="4" style="width:105px">휴대폰번호</td>
            <td class="column12 style68 s style61" colspan="6" rowspan="4" style="width:215px">주        소</td>
            <td class="column18 style72 s style74" colspan="16" style="width:415px">출  력  일  자</td>
            <td class="column34 style75 s style27" colspan="2" rowspan="2" style="width:70px">출력</td>
            <td class="column36 style68 s style61" colspan="2" rowspan="4" style="width:70px">공수</td>
            <td class="column38 style25 s style25" colspan="3" rowspan="4" style="width:100px">단  가</td>
            <td class="column41 style25 s style25" colspan="4" rowspan="4" style="width:150px">총    액</td>
            <td class="column45 style53 s style53" colspan="13">공  제  내  역</td>
            <td class="column58 style25 s style25" colspan="4" rowspan="4"  style="width:150px">차인지급액</td>
            <td class="column62 style72 s style19" colspan="11" rowspan="2">결 제 정 보</td>
            <td class="column73 style25 s style25" colspan="3" rowspan="4" style="width:100px">비  고</td>
            <td class="column73 style25 s style25" colspan="3" rowspan="4" style="width:100px">업체선택</td>
            <td class="column73 style25 s style25" colspan="3" rowspan="4"  rowspan="4" style="width:60px">기산일</td>
            
          </tr>
          <tr class="row5">
            <td class="column0">&nbsp;</td>
            <td class="column18 style29 s style29" rowspan="2">01</td>
            <td class="column19 style26 s style26" rowspan="2">02</td>
            <td class="column20 style26 s style26" rowspan="2">03</td>
            <td class="column21 style26 s style26" rowspan="2">04</td>
            <td class="column22 style26 s style26" rowspan="2">05</td>
            <td class="column23 style26 s style26" rowspan="2">06</td>
            <td class="column24 style26 s style26" rowspan="2">07</td>
            <td class="column25 style26 s style26" rowspan="2">08</td>
            <td class="column26 style26 s style26" rowspan="2">09</td>
            <td class="column27 style26 s style26" rowspan="2">10</td>
            <td class="column28 style26 s style26" rowspan="2">11</td>
            <td class="column29 style26 s style26" rowspan="2">12</td>
            <td class="column30 style26 s style26" rowspan="2">13</td>
            <td class="column31 style26 s style26" rowspan="2">14</td>
            <td class="column32 style26 s style26" rowspan="2">15</td>
            <td class="column33 style71 null style71" rowspan="2"></td>
            <td class="column45 style67 s style18" colspan="3" rowspan="2" style="width:80px">국민연금</td>
            <td class="column48 style18 s style18" colspan="3" rowspan="2" style="width:80px">장기요양</td>
            <td class="column51 style18 s style19" colspan="3" rowspan="2" style="width:80px">소득세</td>
            <td class="column54 style54 s style55" colspan="4" rowspan="3" style="width:80px">공제금액</td>
            
          </tr>
          <tr class="row6">
            <td class="column0">&nbsp;</td>
            <td class="column34 style27 s style28" colspan="2" rowspan="2">일수</td>
            <td class="column62 style67 s style20" colspan="2" rowspan="2" style="width:100px">은행명</td>
            <td class="column64 style18 s style20" colspan="6" rowspan="2" style="width:215px">계좌번호</td>
            <td class="column70 style18 s style21" colspan="3" rowspan="2"  style="width:100px">예금주</td>
            
          </tr>
          <tr class="row7">
            <td class="column0 style4 s">나이</td>
            <td class="column18 style13 s">16</td>
            <td class="column19 style12 s">17</td>
            <td class="column20 style12 s">18</td>
            <td class="column21 style12 s">19</td>
            <td class="column22 style12 s">20</td>
            <td class="column23 style12 s">21</td>
            <td class="column24 style12 s">22</td>
            <td class="column25 style12 s">23</td>
            <td class="column26 style12 s">24</td>
            <td class="column27 style12 s">25</td>
            <td class="column28 style12 s">26</td>
            <td class="column29 style12 s">27</td>
            <td class="column30 style12 s">28</td>
            <td class="column31 style12 s">29</td>
            <td class="column32 style12 s">30</td>
            <td class="column33 style11 s">31</td>
            <td class="column45 style22 s style20" colspan="3" style="width:80px">건강보험</td>
            <td class="column48 style20 s style20" colspan="3" style="width:80px">고용보험</td>
            <td class="column51 style20 s style21" colspan="3" style="width:80px">지방소득세</td>
            
          </tr>
		  
		  <?php 
			unset($i);
			unset($row);
		  
		  for($i=1; $i<=15; $i++){
			$limit = " limit ".($i-1).", 15";
			$row3 = sql_fetch("select * from  {$none['est_noim2']}  where ne_sort = 3 and ne_date = '{$date}' and nw_code = '{$work['nw_code']}' order by seq asc $limit  ");
			
			$day = explode('|', $row3['ne_day']);
		  ?>
          <tr class="row8">
            <td class="column0 style63 f style63" rowspan="2"></td>
            <td class="column1 style64 s style64 no" rowspan="2"><?php echo ($i+30)?></td>
            <td class="column2 style65 f style65" colspan="3" rowspan="2"><input type="text" class="input name" name="ne_name[]" value="<?php echo $row3['ne_name']?>"></td>
            <td class="column5 style65 f style65" colspan="3" rowspan="2"><input type="text" class="input gongjong" name="ne_gongjong[]" value="<?php echo $row3['ne_gongjong']?>"></td>
            <td class="column8 style108 f style113" colspan="4" rowspan="2"><input type="text" class="input numb" name="ne_num[]" value="<?php echo $row3['ne_num']?>"></td>
            <td class="column8 style108 f style113" colspan="4" rowspan="2"><input type="text" class="input hp" name="ne_hp[]" value="<?php echo $row3['ne_hp']?>"></td>
            <td class="column12 style66 f style66" colspan="6"><input type="text" class="input addr1" name="ne_addr1[]" value="<?php echo $row3['ne_addr1']?>"></td>
            <td class="column18 style17 null"><input type="text" class="input dayinput" name="ne_day1[]" value="<?php echo $day[0]?>"></td>
            <td class="column19 style16 null"><input type="text" class="input dayinput" name="ne_day2[]" value="<?php echo $day[1]?>"></td>
            <td class="column20 style16 null"><input type="text" class="input dayinput" name="ne_day3[]" value="<?php echo $day[2]?>"></td>
            <td class="column21 style16 null"><input type="text" class="input dayinput" name="ne_day4[]" value="<?php echo $day[3]?>"></td>
            <td class="column22 style16 null"><input type="text" class="input dayinput" name="ne_day5[]" value="<?php echo $day[4]?>"></td>
            <td class="column23 style16 null"><input type="text" class="input dayinput" name="ne_day6[]" value="<?php echo $day[5]?>"></td>
            <td class="column24 style16 null"><input type="text" class="input dayinput" name="ne_day7[]" value="<?php echo $day[6]?>"></td>
            <td class="column25 style16 null"><input type="text" class="input dayinput" name="ne_day8[]" value="<?php echo $day[7]?>"></td>
            <td class="column26 style16 null"><input type="text" class="input dayinput" name="ne_day9[]" value="<?php echo $day[8]?>"></td>
            <td class="column27 style16 null"><input type="text" class="input dayinput" name="ne_day10[]" value="<?php echo $day[9]?>"></td>
            <td class="column28 style16 null"><input type="text" class="input dayinput" name="ne_day11[]" value="<?php echo $day[10]?>"></td>
            <td class="column29 style16 null"><input type="text" class="input dayinput" name="ne_day12[]" value="<?php echo $day[11]?>"></td>
            <td class="column30 style16 null"><input type="text" class="input dayinput" name="ne_day13[]" value="<?php echo $day[12]?>"></td>
            <td class="column31 style16 null"><input type="text" class="input dayinput" name="ne_day14[]" value="<?php echo $day[13]?>"></td>
            <td class="column32 style16 null"><input type="text" class="input dayinput" name="ne_day15[]" value="<?php echo $day[14]?>"></td>
            <td class="column33 style15 null"></td>
            <td class="column34 style84 f style85" colspan="2" rowspan="2"><input type="text" class="input text-center ne_day_total" name="ne_day_total[]" value="<?php echo $row3['ne_day_total']?>" readonly> </td>
            <td class="column36 style42 f style43" colspan="2" rowspan="2"><input type="text" class="input text-center ne_gongsu" name="ne_gongsu[]" value="<?php echo $row3['ne_gongsu']?>"> </td>
            <td class="column38 style42 null style43" colspan="3" rowspan="2"><input type="text" class="input text-right ne_danga" name="ne_danga[]"  value="<?php echo $row3['ne_danga']?>"></td>
            <td class="column41 style42 f style43" colspan="4" rowspan="2"><input type="text" class="input text-right ne_mny_total" name="ne_mny_total[]" value="<?php echo $row3['ne_mny_total']?>"></td>
            <td class="column45 style83 f style76" colspan="3"><input type="text" class="input text-right ne_tax1" name="ne_tax1[]"  value="<?php echo $row3['ne_tax1']?>"></td>
            <td class="column48 style76 f style76" colspan="3"><input type="text" class="input text-right ne_tax2" name="ne_tax2[]"  value="<?php echo $row3['ne_tax2']?>"></td>
            <td class="column51 style76 f style77" colspan="3"><input type="text" class="input text-right ne_tax3" name="ne_tax3[]"  value="<?php echo $row3['ne_tax3']?>"></td>
            <td class="column54 style42 f style43" colspan="4" rowspan="2"><input type="text" class="input text-right ne_tax_total" name="ne_tax_total[]"  value="<?php echo $row3['ne_tax_total']?>"></td>
            <td class="column58 style42 f style43" colspan="4" rowspan="2"><input type="text" class="input text-right ne_mny_last" name="ne_mny_last[]"  value="<?php echo $row3['ne_mny_last']?>"></td>
            <td class="column62 style36 f style39" colspan="2" rowspan="2"><input type="text" class="input bank" name="ne_bank[]"  value="<?php echo $row3['ne_bank']?>"></td>
            <td class="column64 style37 f style39" colspan="6" rowspan="2"><input type="text" class="input account" name="ne_account[]"  value="<?php echo $row3['ne_account']?>"></td>
            <td class="column70 style37 f style80" colspan="3" rowspan="2"><input type="text" class="input accname" name="ne_accname[]"  value="<?php echo $row3['ne_accname']?>"></td>
            <td class="column73 style81 null style82" colspan="3" rowspan="2"><input type="text" class="input" name="ne_etc[]"  value="<?php echo $row3['ne_etc']?>"></td>
            <td class="column73 style81 null style82" colspan="3" rowspan="2">
			<select name="ne_company[]" class="ne_company input" >
				<option value="">선택하세요.</option>
				<?php 
				$sql = "select * from {$none['est_noim']} where ne_date <= '{$date}'  and nw_code = '{$work['nw_code']}' and ne_type = 2";
				$rst = sql_query($sql);
				while($com = sql_fetch_array($rst)) {
				?>
				<option value="<?php echo $com['seq']?>" <?php echo get_selected($row3['ne_company'], $com['seq'])?>><?php echo $com['ne_name']?>(<?php echo $com['ne_gongjong']?>)</option>
				<?php }?>
			</select>
			
			</td>
            <td class="column73 style81 null style82" colspan="3" rowspan="2"><input type="checkbox" name="ne_gisan[3][<?php echo ($i-1)?>]" class="ne_gisan"  value="1" <?php echo get_checked($row3['ne_gisan'], 1)?>></td>
            
          </tr>
          <tr class="row9">
            <td class="column12 style62 f style62" colspan="6"><input type="text" class="input addr2" name="ne_addr2[]" value="<?php echo $row3['ne_addr2']?>"></td>
            <td class="column18 style14 null"><input type="text" class="input dayinput2 white" name="ne_day16[]" value="<?php echo $day[15]?>"></td>
            <td class="column19 style14 null"><input type="text" class="input dayinput2 white" name="ne_day17[]" value="<?php echo $day[16]?>"></td>
            <td class="column20 style14 null"><input type="text" class="input dayinput2 white" name="ne_day18[]" value="<?php echo $day[17]?>"></td>
            <td class="column21 style14 null"><input type="text" class="input dayinput2 white" name="ne_day19[]" value="<?php echo $day[18]?>"></td>
            <td class="column22 style14 null"><input type="text" class="input dayinput2 white" name="ne_day20[]" value="<?php echo $day[19]?>"></td>
            <td class="column23 style14 null"><input type="text" class="input dayinput2 white" name="ne_day21[]" value="<?php echo $day[20]?>"></td>
            <td class="column24 style14 null"><input type="text" class="input dayinput2 white" name="ne_day22[]" value="<?php echo $day[21]?>"></td>
            <td class="column25 style14 null"><input type="text" class="input dayinput2 white" name="ne_day23[]" value="<?php echo $day[22]?>"></td>
            <td class="column26 style14 null"><input type="text" class="input dayinput2 white" name="ne_day24[]" value="<?php echo $day[23]?>"></td>
            <td class="column27 style14 null"><input type="text" class="input dayinput2 white" name="ne_day25[]" value="<?php echo $day[24]?>"></td>
            <td class="column28 style14 null"><input type="text" class="input dayinput2 white" name="ne_day26[]" value="<?php echo $day[25]?>"></td>
            <td class="column29 style14 null"><input type="text" class="input dayinput2 white" name="ne_day27[]" value="<?php echo $day[26]?>"></td>
            <td class="column30 style14 null"><input type="text" class="input dayinput2 white" name="ne_day28[]" value="<?php echo $day[27]?>"></td>
            <td class="column31 style14 null"><input type="text" class="input dayinput2 white" name="ne_day29[]" value="<?php echo $day[28]?>"></td>
            <td class="column32 style14 null"><input type="text" class="input dayinput2 white" name="ne_day30[]" value="<?php echo $day[29]?>"></td>
            <td class="column33 style14 null"><input type="text" class="input dayinput2 white" name="ne_day31[]" value="<?php echo $day[30]?>"></td>
            <td class="column45 style78 f style40" colspan="3"><input type="text" class="input text-right ne_tax4" name="ne_tax4[]"  value="<?php echo $row3['ne_tax4']?>"></td>
            <td class="column48 style40 f style40" colspan="3"><input type="text" class="input text-right ne_tax5" name="ne_tax5[]"  value="<?php echo $row3['ne_tax5']?>"></td>
            <td class="column51 style40 f style41" colspan="3"><input type="text" class="input text-right ne_tax6" name="ne_tax6[]"  value="<?php echo $row3['ne_tax6']?>"> </td>
            
          </tr>
		
          <?php 
			$ne_day_total3 += $row3['ne_day_total'];
			$ne_gongsu3 += $row3['ne_gongsu'];
			$ne_danga3 += $row3['ne_danga'];
			$ne_mny_total3 += $row3['ne_mny_total'];
			$ne_tax13 += $row3['ne_tax1'];
			$ne_tax23 += $row3['ne_tax2'];
			$ne_tax33 += $row3['ne_tax3'];
			$ne_tax43 += $row3['ne_tax4'];
			$ne_tax53 += $row3['ne_tax5'];
			$ne_tax63 += $row3['ne_tax6'];
			$ne_tax_total3 += $row3['ne_tax_total'];
			$ne_mny_last3 += $row3['ne_mny_last'];
		  
		  }?>
		 <tr class="total_row" style="border-top:2px solid #000">
			<td  class="column12 style62 f style62 text-center" style="background:#92d4d7;font-weight:bold"  rowspan="2" colspan="37">소계</td>
			<td  class="column12 style62 f style62 text-center" colspan="2" rowspan="2"><?php echo number_format($ne_day_total3)?></td>
			<td  class="column12 style62 f style62 text-center" colspan="2" rowspan="2"><?php echo ($ne_gongsu3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" rowspan="2"><?php echo number_format($ne_danga3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_mny_total3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax13)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax23)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax33)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_tax_total3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_mny_last3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="21" rowspan="2">&nbsp;</td>
		  </tr>
		  <tr class="total_row" >
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax43)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax53)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax63)?></td>
		  </tr>
		  <tr class="total_row" >
			<td  class="column12 style62 f style62 text-center" style="background:#a1d3f7;font-weight:bold"  rowspan="2" colspan="37">누계</td>
			<td  class="column12 style62 f style62 text-center" colspan="2" rowspan="2"><?php echo number_format($ne_day_total+$ne_day_total2+$ne_day_total3)?></td>
			<td  class="column12 style62 f style62 text-center" colspan="2" rowspan="2"><?php echo ($ne_gongsu + $ne_gongsu2+ $ne_gongsu3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" rowspan="2"><?php echo number_format($ne_danga+$ne_danga2+$ne_danga3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_mny_total+$ne_mny_total2+$ne_mny_total3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax1+$ne_tax12+$ne_tax13)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax2+$ne_tax22+$ne_tax23)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3" ><?php echo number_format($ne_tax3+$ne_tax32+$ne_tax33)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_tax_total+$ne_tax_total2+$ne_tax_total3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="4" rowspan="2"><?php echo number_format($ne_mny_last+$ne_mny_last2+$ne_mny_last3)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="21" rowspan="2">&nbsp;</td>
		  </tr>
		  <tr class="total_row" >
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax4+$ne_tax42+$ne_tax43)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax5+$ne_tax52+$ne_tax53)?></td>
			<td  class="column12 style62 f style62 text-right" colspan="3"><?php echo number_format($ne_tax6+$ne_tax62+$ne_tax63)?></td>
		  </tr>
        </tbody>
		</table>
		</div>
<?php }?>
