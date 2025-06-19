<?php 
if(!defined('menu_establishment')) exit;

/***********************************************************************
 * 1) 최신 차수의 도급/계약금액 조회
 ***********************************************************************/
$latest_price1 = (int)$work['nw_price1'];
$latest_price2 = (int)$work['nw_price2'];

// worksite_add 테이블에서 마지막 차수를 조회
if(!empty($work['seq'])) {
    $sql_latest = "
        SELECT nw_price1, nw_price2
          FROM {$none['worksite_add']}
         WHERE nw_id = '".sql_real_escape_string($work['seq'])."'
      ORDER BY nw_num DESC
         LIMIT 1
    ";
    $latest_row = sql_fetch($sql_latest);
    if($latest_row) {
        // 추가 차수 존재 시 => 최신 차수 금액
        $latest_price1 = (int)$latest_row['nw_price1'];
        $latest_price2 = (int)$latest_row['nw_price2'];
    }
}

// 최종 도급금액(계약금액) = 최신 차수 기준
$final_contract_price = $latest_price1 + $latest_price2;

/***********************************************************************
 * 2) 기존 코드
 ***********************************************************************/
$sql = "select * 
          from {$none['est_report']} 
         where ne_date = '{$date}' 
           and nw_code = '{$work['nw_code']}' ";
$rst = sql_query($sql);

$row = sql_fetch($sql);

if($row)
    $mode = 'u';
else 
    $mode = '';

// 전회기성금 공급가액 누계
$pp = sql_fetch("
    select SUM(ne_price9) AS price 
      from {$none['est_jungsan_price']} 
     where nw_code = '{$work['nw_code']}' 
       and ne_date < '{$date}'
");
$pp2 = sql_fetch("
    select SUM(ne_price) AS price 
      from {$none['est_report']}
     where nw_code = '{$work['nw_code']}'
       and ne_date < '{$date}'
");
$pp['price'] = $pp2['price'];

$sql = "
    select * 
      from {$none['est_jungsan_price']}  
     where ne_price9 != 0 
       and nw_code = '{$work['nw_code']}' 
       and ne_date = '{$date}'
";
$rst = sql_query($sql);
for($i=0; $arr=sql_fetch_array($rst); $i++) {
    if($member['mb_level2'] == 2) {
        $jungsan_sql_add = " AND ne_admin = 0 ";
    }
  
    $jungsan = sql_fetch("
        select ne_name, ne_type, ne_admin 
          from {$none['est_jungsan']} 
         where seq = '{$arr['parent_id']}' 
               {$jungsan_sql_add}
    ");
    if(!$jungsan) continue;
  
    $arr2 = sql_fetch("
        select SUM(ne_price9) as price
          from {$none['est_jungsan_price']}
         where nw_code = '{$work['nw_code']}'
           and ne_date < '{$date}'
           and parent_id = '{$arr['parent_id']}'
    ");

    $data['ne_name'] = $jungsan['ne_name'];
    $data['price']   = (int)$arr['ne_price9'];
    $month[$jungsan['ne_type']][] = $data;
}

// 최대 갯수 
$max_data = max(
    count($month[1]), 
    count($month[2]), 
    count($month[3]), 
    count($month[4]), 
    count($month[5])
);

// 4번 전월
$sql = "
    select * 
      from {$none['est_jungsan_price']}
     where ne_price9 != 0
       and nw_code = '{$work['nw_code']}'
       and ne_date < '{$date}'
";
$rst = sql_query($sql);
for($i=0; $arr=sql_fetch_array($rst); $i++) {
    if($member['mb_level2'] == 2) {
        $jungsan_sql_add = " AND ne_admin = 0 ";
    }
  
    $jungsan = sql_fetch("
        select ne_name, ne_type 
          from {$none['est_jungsan']} 
         where seq = '{$arr['parent_id']}' 
               {$jungsan_sql_add}
    ");
    if(!$jungsan) continue;
  
    $pre['price'] = (int)$arr['ne_price9'];
    $pre_month[$jungsan['ne_type']]['total'] += $pre['price'];
}

// 금월투입비 누계
for($i=0; $i<$max_data; $i++) {
    $price1_total += $month[1][$i]['price'];
    $price2_total += $month[2][$i]['price'];
    $price3_total += $month[3][$i]['price'];
    $price4_total += $month[4][$i]['price'];
    $price5_total += $month[5][$i]['price'];
}

$month_input_cost = 
    (int)$price1_total + 
    (int)$price2_total + 
    $price3_total + 
    $price4_total + 
    $price5_total;

unset($price1_total, $price2_total, $price3_total, $price4_total, $price5_total);

// 투입비 전월누계
$pmonth_input_cost = 
    $pre_month[1]['total'] + 
    $pre_month[2]['total'] + 
    $pre_month[3]['total'] + 
    $pre_month[4]['total'] + 
    $pre_month[5]['total'];

$month_input_cost_total = $month_input_cost + $pmonth_input_cost;
?>

<form name="frm" action="./update/inc/menu1_update.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="mode"    value="<?php echo $mode; ?>">
<input type="hidden" name="nw_code" id="nw_code" value="<?php echo $work['nw_code']; ?>">
<input type="hidden" name="ne_date" value="<?php echo $date; ?>">
<input type="hidden" name="seq"     value="<?php echo $row['seq']; ?>">

<div class="print_frm">
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines page">
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
    <tbody>
      <!-- 상단: (m)월 정산 보고서, 현장명, 착공일, 도급금액 -->
      <tr class="row0">
        <td class="column0 style1 s style1" colspan="6" rowspan="2">
          ( <?php echo date('m', strtotime($date)); ?> )월 정산 보고서
        </td>
        <td class="column6 style2 s style13" colspan="2" rowspan="2" style="background-color:#f2f2f2">
          현장명
        </td>
        <td class="column8 style4 f style16" colspan="6" rowspan="2">
          <?php echo $work['nw_subject']; ?>
        </td>
        <td class="column14 style7 s style7" colspan="2" style="background-color:#f2f2f2">
          착공일
        </td>
        <td class="column16 style8 f style9" colspan="5">
          &nbsp;<?php echo $work['nw_sdate']; ?>
        </td>
        <!-- ▼ 도급금액: "최신 차수"로 교체 -->
        <td class="column21 style10 s style10" colspan="2" style="background-color:#f2f2f2">
          도급금액
        </td>
        <td class="column23 style11 n style11" colspan="5">
          <?php echo number_format($final_contract_price); ?>
        </td>
        <td class="column28 style2 s style13" colspan="2" rowspan="2" style="background-color:#f2f2f2">
          현장소장
        </td>
        <td class="column30 style2 null style13" colspan="2" rowspan="2">
          <?php echo get_manager_txt($work['nw_ptype1_1']); ?>
        </td>
      </tr>

      <tr class="row1">
        <td class="column14 style7 s style7" colspan="2" style="background-color:#f2f2f2">
          준공일
        </td>
        <td class="column16 style8 f style9" colspan="5">
          &nbsp;<?php echo $work['nw_edate']; ?>
        </td>
        <!-- 실행금액 그대로 -->
        <td class="column21 style10 s style10" colspan="2" style="background-color:#f2f2f2">
          실행금액
        </td>
        <td class="column23 style11 null style11 text-right" colspan="5">
          <?php echo number_format($month_input_cost_total); ?>
        </td>
      </tr>

      <!-- 1. 손익현황 영역 -->
      <tr class="row2">
        <td class="column0 style75 s style75" colspan="16">
          1.손익현황
        </td>
        <td class="column16 style18 s style18" colspan="3">
          (부가세별도)
        </td>
        <td class="column19 style17 null"></td>
        <td class="column20 style17 null"></td>
        <td class="column21 style17 null"></td>
        <td class="column22 style17 null"></td>
        <td class="column23 style17 null"></td>
        <td class="column24 style17 null"></td>
        <td class="column25 style17 null"></td>
        <td class="column26 style17 null"></td>
        <td class="column27 style17 null"></td>
        <td class="column28 style17 null"></td>
        <td class="column29 style17 null"></td>
        <td class="column30 style17 null"></td>
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
        <td class="column20 style2 s style76" colspan="12" style="font-size:13px;border-right:1px solid #000;text-align:left">
          * 도급기성대비 과투입 사유 및 특기사항
        </td>
      </tr>

      <tr class="row4" style="background-color:#f2f2f2">
        <td class="column6 style23 s">%</td>
        <td class="column12 style23 s">%</td>
        <td class="column18 style23 s">%</td>
        <td class="column20 style77 null style82" colspan="12" rowspan="5">
          <textarea name="ne_memo" class="form-control" style="height:115px;border:0">
            <?php echo $row['ne_memo']; ?>
          </textarea>
        </td>
      </tr>

      <!-- 계약금액(최신 차수) -->
      <tr class="row5">
        <td class="column0 style10 s style10" colspan="2">
          계약금액
        </td>
        <td class="column2 style24 f style24 text-right" colspan="4">
          <?php echo number_format($final_contract_price); ?>
        </td>
        <td class="column6 style23 null"></td>
        <td class="column7 style25 null style25" colspan="5"></td>
        <td class="column12 style23 null"></td>
        <td class="column13 style24 null style24" colspan="5"></td>
        <td class="column18 style23 null"></td>
      </tr>

      <!-- 전월누계 -->
      <tr class="row6">
        <td class="column0 style10 s style10" colspan="2">
          전월누계
        </td>
        <td class="column2 style26 null style26" colspan="4">
          <?php echo number_format($pp['price']); ?>
        </td>
        <td class="column6 style27 f">
          <!-- 전월누계 / 최신차수금액 * 100 -->
          <?php
          $tmp = ($pp['price'] / $final_contract_price) * 100;
          echo number_format($tmp, 2);
          ?>%
        </td>
        <td class="column7 style28 f style28" colspan="5">
          <?php echo number_format($pmonth_input_cost); ?>
        </td>
        <td class="column12 style27 f">
          <?php
          $tmp = ($pmonth_input_cost / $final_contract_price) * 100;
          echo number_format($tmp, 2);
          ?>%
        </td>
        <td class="column13 style26 f style26" colspan="5">
          <?php echo number_format($pp['price'] - $pmonth_input_cost); ?>
        </td>
        <td class="column18 style27 f">
          <?php
          $tmp = (($pp['price'] - $pmonth_input_cost) / $final_contract_price) * 100;
          echo number_format($tmp, 2);
          ?>%
        </td>
      </tr>

      <!-- 금월 -->
      <tr class="row7">
        <td class="column0 style10 s style10" colspan="2">
          금    월
        </td>
        <td class="column2 style26 f style26" colspan="4">
          <?php echo number_format($row['ne_price']); ?>
        </td>
        <td class="column6 style27 f">
          <?php
          $tmp = ($row['ne_price'] / $final_contract_price) * 100;
          echo number_format($tmp, 2);
          ?>%
        </td>
        <td class="column7 style28 f style28" colspan="5">
          <?php echo number_format($month_input_cost); ?>
        </td>
        <td class="column12 style27 f">
          <?php
          $tmp = ($month_input_cost / $final_contract_price) * 100;
          echo number_format($tmp, 2);
          ?>%
        </td>
        <td class="column13 style26 f style26" colspan="5">
          <?php echo number_format($row['ne_price'] - $month_input_cost); ?>
        </td>
        <td class="column18 style27 f">
          <?php
          $tmp = (($row['ne_price'] - $month_input_cost) / $final_contract_price) * 100;
          echo number_format($tmp, 2);
          ?>%
        </td>
      </tr>

      <!-- 누계 -->
      <tr class="row8">
        <td class="column0 style10 s style10" colspan="2">
          누    계
        </td>
        <td class="column2 style26 f style26" colspan="4">
          <?php echo number_format($pp['price'] + $row['ne_price']); ?>
        </td>
        <td class="column6 style27 f">
          <?php
          $tmp = (($pp['price'] + $row['ne_price']) / $final_contract_price) * 100;
          echo number_format($tmp, 2);
          ?>%
        </td>
        <td class="column7 style26 f style26" colspan="5">
          <?php echo number_format($month_input_cost_total); ?>
        </td>
        <td class="column12 style27 f">
          <?php
          $tmp = ($month_input_cost_total / $final_contract_price) * 100;
          echo number_format($tmp, 2);
          ?>%
        </td>
        <td class="column13 style26 f style26" colspan="5">
          <?php echo number_format(($pp['price'] + $row['ne_price']) - $month_input_cost_total); ?>
        </td>
        <td class="column18 style27 f">
          <?php
          $tmp = ((($pp['price'] + $row['ne_price']) - $month_input_cost_total) / $final_contract_price) * 100;
          echo number_format($tmp, 2);
          ?>%
        </td>
      </tr>

      <!-- 2.원도급 발주처 기성금 수령 현황, 3.자금수지 계획 등 -->
      <tr class="row9">
        <td class="column0 style75 s style75" colspan="19">
          2.원도급 발주처 기성금 수령 현황
        </td>
        <td class="column19 style30 s style18" colspan="3" style="border-top:0 !important">
          (부가세별도)
        </td>
        <td class="column22 style29 null"></td>
        <td class="column23 style75 s style75" colspan="6">
          3.자금수지 계획
        </td>
        <td class="column29 style18 s style18" colspan="3">
          (부가세별도)
        </td>
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

      <!-- 하단 (계약금액, 전회기성, 금회기성, 누계기성 등) input -->
      <tr class="row12">
        <td class="column0 style24 f style24" colspan="4" rowspan="2">
          <!-- 최신차수로 교체 -->
          <input type="text" 
                 name="ne_contract_price" 
                 id="ne_contract_price" 
                 value="<?php echo number_format($final_contract_price); ?>" 
                 class="input text-right">
        </td>
        <td class="column4 style48 null style50" colspan="3" rowspan="2">
          <input type="text" 
                 name="ne_prev_price" 
                 id="ne_prev_price" 
                 class="input text-right" 
                 readonly 
                 value="<?php echo number_format($pp['price']); ?>">
        </td>
        <td class="column7 style48 f style50" colspan="3" rowspan="2">
          <input type="number" 
                 name="ne_price" 
                 id="ne_price" 
                 class="input text-right" 
                 value="<?php echo $row['ne_price']; ?>">
        </td>
        <td class="column10 style48 f style50" colspan="3" rowspan="2">
          <input type="text" 
                 name="ne_total_price" 
                 id="ne_total_price" 
                 class="input text-right" 
                 readonly 
                 value="<?php echo number_format($pp['price'] + $row['ne_price']); ?>">
        </td>
        <td class="column13 style48 f style50" colspan="3" rowspan="2">
          <input type="text" 
                 name="ne_etc_price" 
                 id="ne_etc_price" 
                 class="input text-right" 
                 readonly 
                 value="<?php echo number_format($final_contract_price - ($pp['price'] + $row['ne_price'])); ?>">
        </td>
        <td class="column16 style48 f style50" colspan="3" rowspan="2">
          <input type="text"
                 id="month_input_cost_total" 
                 class="input text-right" 
                 readonly 
                 value="<?php echo number_format($month_input_cost_total); ?>">
        </td>
        <td class="column19 style48 f style50" colspan="3" rowspan="2">
          <input type="text"
                 id="jango"
                 class="input text-right" 
                 readonly 
                 value="<?php echo number_format(($pp['price'] + $row['ne_price']) - $month_input_cost_total); ?>">
        </td>
        <td class="column22 style51 null"></td>
        <td class="column23 style24 null style24" colspan="3" rowspan="2">
          <input type="number" 
                 name="ne_price2" 
                 id="ne_price2" 
                 class="input text-right" 
                 value="<?php echo $row['ne_price2']; ?>">
        </td>
        <td class="column26 style24 null style24" colspan="3" rowspan="2">
          <input type="number" 
                 name="ne_price3" 
                 id="ne_price3"
                 class="input text-right" 
                 value="<?php echo $row['ne_price3']; ?>">
        </td>
        <td class="column29 style24 f style24" colspan="3" rowspan="2">
          <input type="text" 
                 id="yester_jango"
                 class="input text-right" 
                 value="<?php echo number_format(
                     (($pp['price'] + $row['ne_price']) - $month_input_cost_total) + 
                     $row['ne_price2'] - $row['ne_price3']
                 ); ?>">
        </td>
      </tr>

      <tr class="row13">
        <td class="column22 style51 null"></td>
      </tr>

      <!-- 4.금월 공사비 투입원가 산출내역 -->
      <tr class="row14">
        <td class="column0 style83 s style83" colspan="29">
          4.금월 공사비 투입원가 산출내역
        </td>
        <td class="column29 style18 s style18" colspan="3">
          (부가세별도)
        </td>
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

      <!-- 금월 투입내역 -->
      <?php for($i=0; $i<$max_data; $i++) { ?>
      <tr class="row17">
        <?php if($i==0) { ?>
        <td class="column0 style52 s style62" colspan="2" rowspan="<?php echo $max_data; ?>" style="background-color:#f2f2f2">
          금월<br>투입내역
        </td>
        <?php } ?>

        <td class="column2 style54 f style54" colspan="3">
          <?php echo $month[1][$i]['ne_name']; ?>
        </td>
        <td class="column5 style55 f style55 text-right" colspan="3">
          <?php echo number_format($month[1][$i]['price']); ?>
        </td>
        <td class="column8 style54 f style54" colspan="3">
          <?php echo $month[2][$i]['ne_name']; ?>
        </td>
        <td class="column11 style55 f style55 text-right" colspan="3">
          <?php echo number_format($month[2][$i]['price']); ?>
        </td>
        <td class="column14 style54 f style54" colspan="3">
          <?php echo $month[3][$i]['ne_name']; ?>
        </td>
        <td class="column17 style55 f style55 text-right" colspan="3">
          <?php echo number_format($month[3][$i]['price']); ?>
        </td>
        <td class="column20 style54 f style54" colspan="3">
          <?php echo $month[4][$i]['ne_name']; ?>
        </td>
        <td class="column23 style55 f style55 text-right" colspan="3">
          <?php echo number_format($month[4][$i]['price']); ?>
        </td>
        <td class="column26 style54 f style54" colspan="3">
          <?php echo $month[5][$i]['ne_name']; ?>
        </td>
        <td class="column29 style55 f style55 text-right" colspan="3">
          <?php echo number_format($month[5][$i]['price']); ?>
        </td>
      </tr>
      <?php } ?>

      <!-- 금월/전월/총 누계 -->
      <tr class="row35">
        <td class="column0 style69 s style69" colspan="2">금 월</td>
        <td class="column2 style70 null style70" colspan="3"></td>
        <td class="column5 style71 f style71 text-right" colspan="3">
          <?php echo number_format($price1_total); ?>
        </td>
        <td class="column8 style70 null style70" colspan="3"></td>
        <td class="column11 style71 f style71 text-right" colspan="3">
          <?php echo number_format($price2_total); ?>
        </td>
        <td class="column14 style72 null style72" colspan="3"></td>
        <td class="column17 style71 f style71 text-right" colspan="3">
          <?php echo number_format($price3_total); ?>
        </td>
        <td class="column20 style72 null style72" colspan="3"></td>
        <td class="column23 style71 f style71 text-right" colspan="3">
          <?php echo number_format($price4_total); ?>
        </td>
        <td class="column26 style72 null style72" colspan="3"></td>
        <td class="column29 style71 f style71 text-right" colspan="3">
          <?php echo number_format($price5_total); ?>
        </td>
      </tr>
      <tr class="row36">
        <td class="column0 style10 s style10" colspan="2">전 월</td>
        <td class="column2 style73 null style73" colspan="3"></td>
        <td class="column5 style55 f style55 text-right" colspan="3">
          <?php echo number_format($pre_month[1]['total']); ?>
        </td>
        <td class="column8 style73 null style73" colspan="3"></td>
        <td class="column11 style55 f style55 text-right" colspan="3">
          <?php echo number_format($pre_month[2]['total']); ?>
        </td>
        <td class="column14 style54 null style54" colspan="3"></td>
        <td class="column17 style55 f style55 text-right" colspan="3">
          <?php echo number_format($pre_month[3]['total']); ?>
        </td>
        <td class="column20 style73 null style73" colspan="3"></td>
        <td class="column23 style55 f style55 text-right" colspan="3">
          <?php echo number_format($pre_month[4]['total']); ?>
        </td>
        <td class="column26 style54 null style54" colspan="3"></td>
        <td class="column29 style55 f style55 text-right" colspan="3">
          <?php echo number_format($pre_month[5]['total']); ?>
        </td>
      </tr>
      <tr class="row37">
        <td class="column0 style10 s style10" colspan="2">총 누 계</td>
        <td class="column2 style73 null style73" colspan="3"></td>
        <td class="column5 style55 f style55 text-right" colspan="3">
          <?php echo number_format($price1_total + $pre_month[1]['total']); ?>
        </td>
        <td class="column8 style55 null style55" colspan="3"></td>
        <td class="column11 style55 f style55 text-right" colspan="3">
          <?php echo number_format($price2_total + $pre_month[2]['total']); ?>
        </td>
        <td class="column14 style74 null style74" colspan="3"></td>
        <td class="column17 style55 f style55 text-right" colspan="3">
          <?php echo number_format($price3_total + $pre_month[3]['total']); ?>
        </td>
        <td class="column20 style55 null style55" colspan="3"></td>
        <td class="column23 style55 f style55 text-right" colspan="3">
          <?php echo number_format($price4_total + $pre_month[4]['total']); ?>
        </td>
        <td class="column26 style74 null style74" colspan="3"></td>
        <td class="column29 style55 f style55 text-right" colspan="3">
          <?php echo number_format($price5_total + $pre_month[5]['total']); ?>
        </td>
      </tr>
    </tbody>
</table>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-success" onclick="onExcel()">
        <span class="glyphicon fa fa-file-excel-o"></span> 엑셀출력
    </button>
    <button type="button" class="btn btn-secondary" onclick="onPrint()" data-dismiss="modal">
        인쇄
    </button>
    <button type="submit" class="btn btn-primary" data-dismiss="modal">
        업데이트
    </button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">
        목록
    </button>
</div>

</form>
