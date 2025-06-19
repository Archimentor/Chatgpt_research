<?php if(!defined('menu_establishment')) exit;

$sql = "select * from {$none['est_report']} where ne_date = '{$date}' and nw_code = '{$work['nw_code']}' ";
$rst = sql_query($sql);

$row = sql_fetch($sql);

if($row)
	$mode = 'u';
else 
	$mode = '';

//전회기성금 공급가액 누계
$pp = sql_fetch("select  SUM(ne_price9) AS price from {$none['est_jungsan_price']} where nw_code = '{$work['nw_code']}' and ne_date < '{$date}'");
$pp2 = sql_fetch("select  SUM(ne_price) AS price from {$none['est_report']} where nw_code = '{$work['nw_code']}' and ne_date < '{$date}'");

$pp['price'] = $pp2['price'];

$sql = "select * from {$none['est_jungsan_price']}  where ne_price9 != 0 and nw_code = '{$work['nw_code']}' and ne_date = '{$date}'  ";
$rst = sql_query($sql);
for($i=0; $arr=sql_fetch_array($rst); $i++) {
  if($member['mb_level2'] == 2) {
	  
	  $jungsan_sql_add = " and ne_admin = 0 ";
	  
  }
  
  $jungsan = sql_fetch("select ne_name, ne_type, ne_admin from {$none['est_jungsan']} where seq = '{$arr['parent_id']}' {$jungsan_sql_add} ");
  
	if(!$jungsan) continue;
  
  $arr2 = sql_fetch("select  SUM(ne_price9) as price from {$none['est_jungsan_price']}  where nw_code = '{$work['nw_code']}' and ne_date < '{$date}' and parent_id = '{$arr['parent_id']}' ");

  $data['ne_name'] = $jungsan['ne_name'];
  $data['price'] = (int)$arr['ne_price9'];
  $month[$jungsan['ne_type']][] = $data;
 
}

//최대 갯수 
$max_data = max(count($month[1]), count($month[2]), count($month[3]), count($month[4]), count($month[5]));


//4번 전월
$sql = "select * from {$none['est_jungsan_price']}  where ne_price9 != 0 and nw_code = '{$work['nw_code']}' and ne_date < '{$date}'  ";
$rst = sql_query($sql);
for($i=0; $arr=sql_fetch_array($rst); $i++) {
    if($member['mb_level2'] == 2) {
	  
	  $jungsan_sql_add = " and ne_admin = 0 ";
	  
  }
  
  $jungsan = sql_fetch("select ne_name, ne_type from {$none['est_jungsan']} where seq = '{$arr['parent_id']}' {$jungsan_sql_add}");
  if(!$jungsan) continue;
  
  
  $pre['price'] = (int)$arr['ne_price9'];
  $pre_month[$jungsan['ne_type']]['total'] += $pre['price'];
 
}



//금월투입비 누계
for($i=0; $i<$max_data; $i++) {
	$price1_total += $month[1][$i]['price'];
	$price2_total += $month[2][$i]['price'];
	$price3_total += $month[3][$i]['price'];
	$price4_total += $month[4][$i]['price'];
	$price5_total += $month[5][$i]['price'];
}


$month_input_cost = (int)$price1_total+(int)$price2_total+$price3_total+$price4_total+$price5_total;
unset($price1_total);
unset($price2_total);
unset($price3_total);
unset($price4_total);
unset($price5_total);

//투입비 전월누계 
$pmonth_input_cost = $pre_month[1]['total']+$pre_month[2]['total']+$pre_month[3]['total']+$pre_month[4]['total']+$pre_month[5]['total'];

$month_input_cost_total = $month_input_cost + $pmonth_input_cost;




?>
<!--
<div id="loading_box" style="position:relative">
	<div id="loading"></div>
	<span>전월 데이터 동기화 중</span>
</div>
-->

<table border="1"   width="1200">
  <col class="col0" style="width:50px">
        <col class="col1" style="width:50px">
        <col class="col2" style="width:50px">
        <col class="col3" style="width:50px">
        <col class="col4" style="width:50px">
        <col class="col5" style="width:50px">
        <col class="col6" style="width:60px">
        <col class="col7"  style="width:50px">
        <col class="col8"  style="width:50px">
        <col class="col9"  style="width:50px">
        <col class="col10"  style="width:50px">
        <col class="col11"  style="width:50px">
        <col class="col12"  style="width:60px">
        <col class="col13"  style="width:50px">
        <col class="col14"  style="width:50px">
        <col class="col15"  style="width:50px">
        <col class="col16"  style="width:50px">
        <col class="col17"  style="width:50px">
        <col class="col18"  style="width:60px">
        <col class="col19"  style="width:50px">
        <col class="col20"  style="width:50px">
        <col class="col21"  style="width:50px">
        <col class="col22"  style="width:50px">
        <col class="col23"  style="width:50px">
        <col class="col24"  style="width:50px">
        <col class="col25"  style="width:50px">
        <col class="col26"  style="width:50px">
        <col class="col27"  style="width:50px">
        <col class="col28"  style="width:50px">
        <col class="col29"  style="width:50px">
        <col class="col30"  style="width:50px">
        <col class="col31"  style="width:50px">
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style1" colspan="6" rowspan="2" style="font-size:16px;font-weight:bold">( <?php echo date('m', strtotime($date))?> )월 정산 보고서</td>
            <td class="column6 style2 s style13" colspan="2" rowspan="2" style="background-color:#f2f2f2">현장명</td>
            <td class="column8 style4 f style16" colspan="6" rowspan="2"><?php echo $work['nw_subject']?></td>
            <td class="column14 style7 s style7" colspan="2" style="background-color:#f2f2f2">착공일</td>
            <td class="column16 style8 f style9" colspan="5" >&nbsp;<?php echo $work['nw_sdate']?></td>
            <td class="column21 style10 s style10" colspan="2" style="background-color:#f2f2f2">도급금액</td>
            <td class="column23 style11 n style11" colspan="5" > <?php echo number_format($work['nw_price1'])?></td>
            <td class="column28 style2 s style13" colspan="2" rowspan="2" style="background-color:#f2f2f2">현장소장</td>
            <td class="column30 style2 null style13" colspan="2" rowspan="2"><?php echo get_manager_txt($work['nw_ptype1_1'])?></td>
          </tr>
          <tr class="row1">
            <td class="column14 style7 s style7" colspan="2" style="background-color:#f2f2f2">준공일</td>
            <td class="column16 style8 f style9" colspan="5">&nbsp;<?php echo $work['nw_edate']?></td>
            <td class="column21 style10 s style10" colspan="2" style="background-color:#f2f2f2">실행금액</td>
            <td class="column23 style11 null style11 text-right" colspan="5"><?php echo number_format( $month_input_cost_total)?></td>
          </tr>

  
        <tbody>
          <tr class="row2" style="border:0">
            <td class="column0 style75 s style75" colspan="16" style="font-size:14px;font-weight:bold">1.손익현황</td>
            <td class="column16 style18 s style18" colspan="3" style="border-right:0">(부가세별도)</td>
            <td class="column19 style17 null" style="border-right:0px"></td>
            <td class="column20 style17 null" style="border-right:0px"></td>
            <td class="column21 style17 null" style="border-right:0"></td>
            <td class="column22 style17 null" style="border-right:0"></td>
            <td class="column23 style17 null" style="border-right:0"></td>
            <td class="column24 style17 null" style="border-right:0"></td>
            <td class="column25 style17 null" style="border-right:0"></td>
            <td class="column26 style17 null" style="border-right:0"></td>
            <td class="column27 style17 null" style="border-right:0"></td>
            <td class="column28 style17 null" style="border-right:0"></td>
            <td class="column29 style17 null" style="border-right:0"></td>
            <td class="column30 style17 null" style="border-right:0"></td>
            <td class="column31 style17 null"></td>
          </tr>
          <tr class="row3" style="background-color:#f2f2f2">
            <td class="column0 style10 s style10" colspan="2" rowspan="2">구   분</td>
            <td class="column2 style31 s style39" colspan="4" rowspan="2">도급기성 ①</td>
            <td class="column6 style84 null"></td>
            <td class="column7 style10 s style19" colspan="5" rowspan="2">투 입 비 ②</td>
            <td class="column12 style20 null"></td>
            <td class="column13 style10 s style19" colspan="5" rowspan="2">현장손익(①-②)</td>
            <td class="column18 style20 null"></td>
            <td class="column19 style85 null style85" rowspan="6" style="background-color:white"></td>
            <td class="column20 style2 s style76" colspan="12" style="font-size:13px;border-right:1px solid #000;text-align:left">* 도급기성대비 과투입 사유 및 특기사항</td>
     
          </tr>
          <tr class="row4" style="background-color:#f2f2f2">
            <td class="column6 style23 s" >%</td>
            <td class="column12 style23 s" >%</td>
            <td class="column18 style23 s" >%</td>
            <td class="column20 style77 null style82" colspan="12" rowspan="5"><?php echo nl2br($row['ne_memo'])?>
			</td>
          </tr>
          <tr class="row5" >
            <td class="column0 style10 s style10" colspan="2">계약금액</td>
            <td class="column2 style24 f style24 text-right" colspan="4"><?php echo number_format($work['nw_price1']+$work['nw_price2'])?> </td>
            <td class="column6 style23 null"></td>
            <td class="column7 style25 null style25" colspan="5"></td>
            <td class="column12 style23 null"></td>
            <td class="column13 style24 null style24" colspan="5"></td>
            <td class="column18 style23 null"></td>
          </tr>
          <tr class="row6">
            <td class="column0 style10 s style10" colspan="2">전월누계</td>
            <td class="column2 style26 null style26" colspan="4"><?php echo number_format($pp['price'])?></td>
            <td class="column6 style27 f"><?php echo number_format(($pp['price']/($work['nw_price1']+$work['nw_price2'])*100), 2)?>%</td>
            <td class="column7 style28 f style28" colspan="5"><?php echo number_format($pmonth_input_cost)?></td>
            <td class="column12 style27 f"><?php echo number_format(($pmonth_input_cost/($work['nw_price1']+$work['nw_price2'])*100), 2)?>%</td>
            <td class="column13 style26 f style26" colspan="5"><?php echo number_format($pp['price'] - $pmonth_input_cost)?></td>
            <td class="column18 style27 f"><?php echo number_format((($pp['price'] - $pmonth_input_cost)/($work['nw_price1']+$work['nw_price2'])*100), 2)?>%</td>
          </tr>
          <tr class="row7">
            <td class="column0 style10 s style10" colspan="2">금    월</td>
            <td class="column2 style26 f style26" colspan="4"><?php echo number_format($row['ne_price'])?></td>
            <td class="column6 style27 f"><?php echo number_format(($row['ne_price']/($work['nw_price1']+$work['nw_price2'])*100), 2)?>%</td>
            <td class="column7 style28 f style28" colspan="5"><?php echo number_format($month_input_cost)?></td>
            <td class="column12 style27 f"><?php echo number_format(($month_input_cost/($work['nw_price1']+$work['nw_price2'])*100), 2)?>%</td>
            <td class="column13 style26 f style26" colspan="5"><?php echo number_format($row['ne_price'] - $month_input_cost)?></td>
            <td class="column18 style27 f"><?php echo number_format((($row['ne_price'] - $month_input_cost)/($work['nw_price1']+$work['nw_price2'])*100), 2)?>%</td>
          </tr>
          <tr class="row8">
            <td class="column0 style10 s style10" colspan="2">누    계</td>
            <td class="column2 style26 f style26" colspan="4"><?php echo number_format($pp['price']+$row['ne_price'])?></td>
            <td class="column6 style27 f"><?php echo number_format((($pp['price']+$row['ne_price'])/($work['nw_price1']+$work['nw_price2'])*100), 2)?>%</td>
            <td class="column7 style26 f style26" colspan="5"><?php echo number_format($month_input_cost_total)?></td>
            <td class="column12 style27 f"><?php echo number_format(($month_input_cost_total/($work['nw_price1']+$work['nw_price2'])*100), 2)?>%</td>
            <td class="column13 style26 f style26" colspan="5"><?php echo number_format( ($pp['price']+$row['ne_price']) - $month_input_cost_total)?></td>
            <td class="column18 style27 f"><?php echo number_format(((($pp['price']+$row['ne_price']) - $month_input_cost_total)/($work['nw_price1']+$work['nw_price2'])*100), 2)?>%</td>
          </tr>
          <tr class="row9">
            <td class="column0 style75 s style75" colspan="19" style="font-size:14px;font-weight:bold" >2.원도급 발주처 기성금 수령 현황</td>
            <td class="column19 style30 s style18" colspan="3" style="border-top:0 !important">(부가세별도)</td>
            <td class="column22 style29 null"></td>
            <td class="column23 style75 s style75" colspan="6" style="font-size:14px;font-weight:bold">3.자금수지 계획</td>
            <td class="column29 style18 s style18" colspan="3">(부가세별도)</td>
          </tr>
          <tr class="row10" style="background-color:#f2f2f2">
            <td class="column0 style31 s style40" colspan="4" rowspan="2">계약금액</td>
            <td class="column4 style31 s style43" colspan="3" rowspan="2">전회기성</td>
            <td class="column7 style31 s style43" colspan="3" rowspan="2">금회기성</td>
            <td class="column10 style31 s style33" colspan="3">누계기성</td>
            <td class="column13 style31 s style43" colspan="3" rowspan="2">잔여기성</td>
            <td class="column16 style31 s style33" colspan="3">현장투입금액</td>
            <td class="column19 style31 s style33" colspan="3">현장기성잔고</td>
            <td class="column22 style36 null" style="background-color:#fff"></td>
            <td class="column23 style37 s style37" colspan="3">명월 원도급 청구</td>
            <td class="column26 style37 s style37" colspan="3">명월 현장투입</td>
            <td class="column29 style37 s style37" colspan="3">명월잔고</td>
          </tr>
          <tr class="row11" style="background-color:#f2f2f2">
            <td class="column10 style44 s style46" colspan="3">(A)</td>
            <td class="column16 style44 s style46" colspan="3">(B)</td>
            <td class="column19 style44 s style46" colspan="3">C(A-B)</td>
            <td class="column22 style36 null" style="background-color:#fff"></td>
            <td class="column23 style38 s style40" colspan="3">예상금액(D)</td>
            <td class="column26 style47 s style47" colspan="3">예상금액(E)</td>
            <td class="column29 style47 s style47" colspan="3">예상금액(C+D-E)</td>
          </tr>
          <tr class="row12">
            <td class="column0 style24 f style24" colspan="4" rowspan="2"><?php echo number_format($work['nw_price1']+$work['nw_price2'])?> </td>
            <td class="column4 style48 null style50" colspan="3" rowspan="2"><?php echo number_format($pp['price'])?></td>
            <td class="column7 style48 f style50" colspan="3" rowspan="2"><?php echo $row['ne_price']?></td>
            <td class="column10 style48 f style50" colspan="3" rowspan="2"><?php echo number_format($pp['price']+$row['ne_price'])?></td>
            <td class="column13 style48 f style50" colspan="3" rowspan="2"><?php echo number_format(($work['nw_price1']+$work['nw_price2'])-($pp['price']+$row['ne_price']))?></td>
            <td class="column16 style48 f style50" colspan="3" rowspan="2">
			<?php echo number_format($month_input_cost_total)?>
			</td>
            <td class="column19 style48 f style50" colspan="3" rowspan="2">
			<?php echo number_format(($pp['price']+$row['ne_price']) -$month_input_cost_total)?>
			</td>
            <td class="column22 style51 null"></td>
            <td class="column23 style24 null style24" colspan="3" rowspan="2"><?php echo $row['ne_price2']?></td>
            <td class="column26 style24 null style24" colspan="3" rowspan="2"><?php echo $row['ne_price3']?></td>
            <td class="column29 style24 f style24" colspan="3" rowspan="2">
			
			<?php echo number_format((($pp['price']+$row['ne_price']) - $month_input_cost_total) + $row['ne_price2'] - $row['ne_price3'])?>
			</td>
          </tr>
          <tr class="row13">
            <td class="column22 style51 null"></td>
          </tr>
          <tr class="row14">
            <td class="column0 style83 s style83" colspan="29" style="font-size:14px;font-weight:bold">4.금월 공사비 투입원가 산출내역</td>
            <td class="column29 style18 s style18" colspan="3">(부가세별도)</td>
          </tr>
          <tr class="row15" style="background-color:#f2f2f2">
            <td class="column0 style10 s style10 print_td" colspan="2" rowspan="2">구   분</td>
            <td class="column2 style10 s style10" colspan="6">외 주 비</td>
            <td class="column8 style10 s style10" colspan="6">자 재 비</td>
            <td class="column14 style10 s style10" colspan="6">장 비 비</td>
            <td class="column20 style10 s style10" colspan="6">노 무 비</td>
            <td class="column26 style10 s style10" colspan="6">기타경비</td>
          </tr>
          <tr class="row16" style="background-color:#f2f2f2">
            <td class="column2 style10 s style10" colspan="3">업체명</td>
            <td class="column5 style10 s style10" colspan="3">금액</td>
            <td class="column8 style10 s style10" colspan="3">업체명</td>
            <td class="column11 style10 s style10" colspan="3">금액</td>
            <td class="column14 style10 s style10" colspan="3">업체명</td>
            <td class="column17 style10 s style10" colspan="3">금액</td>
            <td class="column20 style10 s style10" colspan="3">이름/업체명</td>
            <td class="column23 style10 s style10" colspan="3">금액</td>
            <td class="column26 style10 s style10" colspan="3">업체명</td>
            <td class="column29 style10 s style10" colspan="3">금액</td>
          </tr>
		  
		  <?php for($i=0; $i<$max_data; $i++) {?>
          <tr class="row17">
			<?php if($i==0) {?>
            <td class="column0 style52 s style62" colspan="2" rowspan="<?php echo $max_data?>" style="background-color:#f2f2f2">금월<br>투입내역</td>
			<?php }?>
			
			
            <td class="column2 style54 f style54" colspan="3"><?php echo $month[1][$i]['ne_name']?></td>
            <td class="column5 style55 f style55 text-right" colspan="3"><?php echo number_format($month[1][$i]['price'])?></td>
			
            <td class="column8 style54 f style54" colspan="3"><?php echo $month[2][$i]['ne_name']?></td>
            <td class="column11 style55 f style55 text-right" colspan="3"><?php echo number_format($month[2][$i]['price'])?></td>
            <td class="column14 style54 f style54 " colspan="3"><?php echo $month[3][$i]['ne_name']?></td>
            <td class="column17 style55 f style55 text-right" colspan="3"><?php echo number_format($month[3][$i]['price'])?></td>
            <td class="column20 style54 f style54" colspan="3"><?php echo $month[4][$i]['ne_name']?></td>
            <td class="column23 style55 f style55 text-right" colspan="3"><?php echo number_format($month[4][$i]['price'])?></td>
            <td class="column26 style54 f style54" colspan="3"><?php echo $month[5][$i]['ne_name']?></td>
            <td class="column29 style55 f style55 text-right" colspan="3"><?php echo number_format($month[5][$i]['price'])?></td>
          </tr>
		  <?php 
			$price1_total += $month[1][$i]['price'];
			$price2_total += $month[2][$i]['price'];
			$price3_total += $month[3][$i]['price'];
			$price4_total += $month[4][$i]['price'];
			$price5_total += $month[5][$i]['price'];
		  
		  }?>
		  
          <tr class="row35">
            <td class="column0 style69 s style69" colspan="2">금 월</td>
            <td class="column2 style70 null style70" colspan="3"></td>
            <td class="column5 style71 f style71 text-right" colspan="3"><?php echo number_format($price1_total)?></td>
            <td class="column8 style70 null style70" colspan="3"></td>
            <td class="column11 style71 f style71 text-right" colspan="3"><?php echo number_format($price2_total)?></td>
            <td class="column14 style72 null style72" colspan="3"></td>
            <td class="column17 style71 f style71 text-right" colspan="3"><?php echo number_format($price3_total)?></td>
            <td class="column20 style72 null style72" colspan="3"></td>
            <td class="column23 style71 f style71 text-right" colspan="3"><?php echo number_format($price4_total)?></td>
            <td class="column26 style72 null style72" colspan="3"></td>
            <td class="column29 style71 f style71 text-right" colspan="3"><?php echo number_format($price5_total)?></td>
          </tr>
          <tr class="row36">
            <td class="column0 style10 s style10" colspan="2">전 월</td>
            <td class="column2 style73 null style73" colspan="3"></td>
            <td class="column5 style55 f style55 text-right" colspan="3"><?php echo number_format($pre_month[1]['total'])?></td>
            <td class="column8 style73 null style73" colspan="3"></td>
            <td class="column11 style55 f style55 text-right" colspan="3"><?php echo number_format($pre_month[2]['total'])?></td>
            <td class="column14 style54 null style54" colspan="3"></td>
            <td class="column17 style55 f style55 text-right" colspan="3"><?php echo number_format($pre_month[3]['total'])?></td>
            <td class="column20 style73 null style73" colspan="3"></td>
            <td class="column23 style55 f style55 text-right" colspan="3"><?php echo number_format($pre_month[4]['total'])?></td>
            <td class="column26 style54 null style54" colspan="3"></td>
            <td class="column29 style55 f style55 text-right" colspan="3"><?php echo number_format($pre_month[5]['total'])?></td>
          </tr>
          <tr class="row37">
            <td class="column0 style10 s style10" colspan="2">총 누 계</td>
            <td class="column2 style73 null style73" colspan="3"></td>
            <td class="column5 style55 f style55 text-right" colspan="3"><?php echo number_format($price1_total + $pre_month[1]['total'])?> </td>
            <td class="column8 style55 null style55" colspan="3"></td>
            <td class="column11 style55 f style55 text-right" colspan="3"><?php echo number_format($price2_total + $pre_month[2]['total'])?> </td>
            <td class="column14 style74 null style74" colspan="3"></td>
            <td class="column17 style55 f style55 text-right" colspan="3"><?php echo number_format($price3_total + $pre_month[3]['total'])?> </td>
            <td class="column20 style55 null style55" colspan="3"></td>
            <td class="column23 style55 f style55 text-right" colspan="3"><?php echo number_format($price4_total + $pre_month[4]['total'])?> </td>
            <td class="column26 style74 null style74" colspan="3"></td>
            <td class="column29 style55 f style55 text-right" colspan="3"><?php echo number_format($price5_total + $pre_month[5]['total'])?> </td>
          </tr>
        </tbody>
    </table>


 