<!-- jQuery UI CSS -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> 

<?php 
include('./include/b_update_table.php');

// for문으로 sql, rst, chk, mode 변수 생성
for($a=1;$a<=5;$a++){ 
    ${'sql'.$a} = "SELECT * FROM {$none['est_jungsan']} 
                  WHERE nw_code = '{$work['nw_code']}' 
                  AND ne_type = {$a}";

    // 권한 레벨이 2인 경우(현장소장 등) admin 구분이 0 인 항목만 출력
    if($member['mb_level2'] == 2) {
        ${'sql'.$a} .= " AND ne_admin = 0 ";
    }

    ${'rst'.$a} = sql_query(${'sql'.$a});
    ${'chk'.$a} = sql_fetch(${'sql'.$a});

    if(${'chk'.$a}) {
        ${'mode'.$a} = 'u';
    } else {
        ${'mode'.$a} = '';
    }
}
?>

<style>
  /* 툴팁(hover) CSS */
.hover-enlarge {
  position: relative;
  cursor: pointer;
}
.hover-enlarge:hover::after {
  content: attr(data-value);
  position: absolute;
  left: 100%;
  top: 50%;
  transform: translateY(-50%);
  background: #fff;
  border: 1px solid #ccc;
  padding: 4px 8px;
  font-size: 16px;
  white-space: nowrap;
  box-shadow: 0 0 5px rgba(0,0,0,0.3);
  z-index: 1000;
}

.delete-icon{
  cursor:pointer;
  color:#dc3545;           /* 빨간색 */
  font-size:14px;
  margin-right:4px;
}


/* ---------------------------------
   1) 기본 테이블 / 열 숨김 / 레이아웃
----------------------------------- */

/* 은행계좌 및 수령자(은행명, 계좌번호, 예금주, 대표자) 열 숨기기 */
th.column24, td.column24,
th.column25, td.column25,
th.column26, td.column26 {
    display: none !important;
}

/* 스크롤 영역용 */
.print_frm {
  width: 100%;
  overflow-x: auto;
  margin-bottom: 1em;
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
}

/* 표 공통 스타일 */
table.write2_table {
  border-collapse: collapse;
  table-layout: fixed;
  width: 100%;
  font-size: 12px;
  color: #333;
}

/* 테이블 셀 공통 */
table.write2_table th,
table.write2_table td {
  border: 1px solid #ccc !important;
  padding: 2px;
  text-align: center;
  overflow: visible;
  text-overflow: clip;
}

/* input을 셀 크기에 맞춤 */
table.write2_table td input[type="text"] {
  width: 95%;
  box-sizing: border-box;
  border: 1 solid #ccc;
  height: 100%;
}

/* ---------------------------------
   2) 열 별 가로폭 및 줄바꿈
----------------------------------- */
.col0 {
  width: 40px !important;
}
.col1, .col2 {
  width: 80px !important;
}
.col3 {
  width: 110px !important;
  white-space: normal !important;
  word-wrap: break-word;
  overflow: visible !important;
  text-overflow: clip !important;
}
.col4, .col5 {
  width: 50px !important;
  overflow: visible !important;
}
.col6, .col7, .col8, .col9,
.col10, .col11, .col12, .col13,
.col14, .col15, .col16, .col17,
.col18, .col19, .col20, .col21,
.col22, .col23, .col24, .col25,
.col26 {
  width: 100px !important;
  overflow: visible !important;
}
.col27 {
  width: 80px !important;
  white-space: normal !important;
  word-wrap: break-word;
  overflow: visible !important;
  text-overflow: clip !important;
}

/* ---------------------------------
   4) 그룹(tbody) 상하 굵은선
----------------------------------- */
tbody[id^="s"] > tr:first-child td {
  border-top: 2px solid #000 !important;
}

/* ---------------------------------
   5) 소계(subtotal) / 헤더 스타일
----------------------------------- */
table.write2_table thead tr {
  background-color: #f7f7f7;
  white-space: normal !important;
  overflow: visible !important;
  text-overflow: clip !important;
}
.write2_table tr.subtotal {
  background-color: #fefbea;
  font-weight: bold;
}
.write2_table tr.subtotal td {
  color: #333;
  font-size:11px !important;
}

/* ---------------------------------
   6) 그 외 스타일들
----------------------------------- */    
.text-right {
  text-align: right;
}
.input {
  box-sizing: border-box;
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 3px;
}
/* hover 효과 */
.write2_table tbody tr:hover {
  background-color: #fafafa;
}

/* ========================================
   ★★★ 인쇄 스타일 ★★★
   ======================================== */
   @media print {

/* --- 기본 인쇄 스타일 --- */
body, table.write2_table {
  font-family: 'Verdana', 'Tahoma', sans-serif;
  /* ★ 주석: font-size 규칙 삭제됨. */
  /* ★ 주석: color 규칙 삭제됨. */
}
body {
  margin: 1cm !important;
   /* 배경색 등 다른 색상은 인쇄되도록 유지 */
   -webkit-print-color-adjust: exact !important;
   print-color-adjust: exact !important;
}
.print_frm {
  overflow: visible !important; border: none !important; width: auto !important;
  padding: 0 !important; margin: 0 !important; background: #fff !important;
}

/* --- 테이블 레이아웃 및 셀 스타일 --- */
table.write2_table {
  border-collapse: collapse !important; width: 100% !important;
  table-layout: fixed !important;
}
thead {
   display: table-header-group !important; /* 헤더 매 페이지 반복 (유지) */
}
table.write2_table th,
table.write2_table td {
  border: 1px solid #ccc !important;
  padding: 4px 3px !important;   /* 행 높이: 상하 패딩 (유지) */
  line-height: 1.5 !important;   /* 행 높이: 줄 간격 (유지) */
  height: auto !important;
  white-space: normal !important; /* 텍스트 줄바꿈 (유지) */
  word-wrap: break-word !important;/* 단어 단위 줄바꿈 (유지) */
  overflow: visible !important;
  text-overflow: clip !important;
  /* ★ 주석: vertical-align 및 text-align 규칙 삭제됨. */
}

input[type="text"],
table.write2_table td input[type="text"] {
  border: none !important; background: transparent !important; box-shadow: none !important;
  pointer-events: none !important; width: 100% !important;
  font-family: inherit !important;
  /* ★ 주석: color 규칙 삭제됨 */
  padding: 0 !important; margin: 0 !important; display: inline-block !important;
  white-space: normal !important; /* Input 내용 줄바꿈 (유지) */
  word-wrap: break-word !important;/* Input 내용 줄바꿈 (유지) */
}
.write2_table tr.subtotal {
   background-color: #fefbea !important; /* 소계 배경색 인쇄는 유지 */
   font-weight: bold !important;
}
.write2_table tr.subtotal td {
   /* ★ 주석: color 규칙 삭제됨 */
}
tbody[id^="s"] > tr:first-child td {
  border-top: 2px solid #000 !important; /* 섹션 상단 굵은 선 (유지) */
}

/* --- 페이지 나누기 제어 (해결되었으므로 유지) --- */
#s2_add_line,
#s3_add_line,
#s4_add_line,
#s5_add_line {
  page-break-before: avoid;
}
tr {
  page-break-inside: avoid !important;
}
tbody {
   page-break-inside: auto !important;
}
 #s1_add_line > tr:first-child,
 #s2_add_line > tr:first-child,
 #s3_add_line > tr:first-child,
 #s4_add_line > tr:first-child,
 #s5_add_line > tr:first-child
 {
    page-break-inside: auto !important;
 }

/* --- 불필요한 요소 숨기기 (유지) --- */
.modal-footer, #cell-display-menu2, i.fa-plus-square,
span.fa-trash-o, .hover-enlarge:hover::after {
  display: none !important; visibility: hidden !important;
}
th.column24, td.column24, th.column25, td.column25,
th.column26, td.column26 {
    display: none !important;
}

 /* 삭제·추가 버튼, 편집용 input 전체 숨김 */
  .delete-icon,
  .fa-plus-square,
  input[type="text"].name1,   /* 또는 .input.no-print 처럼 별도 클래스 */
  input[type="text"].gongjong,
  input[type="text"].bank,
  input[type="text"].account,
  input[type="text"].accname,
  input[type="text"].ceo,
  input[type="text"].sdate,
  input[type="text"].edate
  { display:none !important; }
}

} /* @media print 끝 */




/* --- Style for the cell content popup --- */
#cell-display-menu2 {
    position: absolute; /* Needed for top/left positioning */
    display: none;      /* Hidden initially */
    background-color: white;
    border: 1px solid #adb5bd; /* Light gray border */
    padding: 5px 8px;        /* Some padding inside */
    font-size: 0.9em;        /* Slightly smaller font */
    z-index: 1000;           /* Ensure it's above other elements */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15); /* Subtle shadow */
    border-radius: 3px;      /* Slightly rounded corners */
    white-space: nowrap;     /* Prevent text wrapping if not desired */
    box-sizing: border-box;  /* --- 추가: padding/border를 높이에 포함 --- */
    /* Add any other styles you need */
}

/* --- Styles for highlighting (assuming you have these) --- */
.selected-row-bg {
    background-color: #e9ecef; /* Example row highlight */
}

.selected-cell {
    outline: 2px solid #0d6efd; /* Example cell highlight */
    outline-offset: -1px;
}


</style>



<form name="frm" id="frm" action="./update/inc/menu2_update.php" method="post" onsubmit="return removeComma()">
  <!-- hidden 파라미터 -->
  <input type="hidden" name="mode1" value="<?php echo $mode1?>">
  <input type="hidden" name="mode2" value="<?php echo $mode2?>">
  <input type="hidden" name="mode3" value="<?php echo $mode3?>">
  <input type="hidden" name="mode4" value="<?php echo $mode4?>">
  <input type="hidden" name="mode5" value="<?php echo $mode5?>">
  <input type="hidden" name="nw_code" id="nw_code" value="<?php echo $work['nw_code']?>">
  <input type="hidden" name="ne_date" value="<?php echo $date?>">

  <div class="print_frm" style="width:100%; overflow-x: scroll;">

    <!-- 테이블 ID를 data-table-menu2로 변경하여 방향키 이동에 대응 -->
    <table cellpadding="0" cellspacing="0" id="data-table-menu2" class="sheet0 gridlines write2_table">
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

      <!-- 헤더 -->
      <thead>
        <tr class="row0">
          <th class="column0 style1" colspan="25" rowspan="3">
            <?php echo date('Y년 m월', strtotime($date))?> 기성 정산서
          </th>
        </tr>
        <tr class="row1"></tr>
        <tr class="row2"></tr>
        <tr class="row3">
          <th class="column0" colspan="25">
            현 장 명 : <?php echo $work['nw_subject']?> 
          </th>
        </tr>
        <tr class="row4">
          <th class="column0" rowspan="2">구분</th>
          <th class="column1" colspan="2" rowspan="2">업  체  명</th>
          <th class="column3" rowspan="2">공종/<br>적요</th>
          <th class="column4" colspan="2">공사기간</th>
          <th class="column6">도급<br>금액</th>
          <th class="column7">실행<br>금액</th>
          <th class="column8" colspan="3">계약금액</th>
          <th class="column11" colspan="3">전회기성금</th>
          <th class="column14" colspan="6">금회기성</th>
          <th class="column20" colspan="3">누계기성</th>
          <th class="column23">잔여<br>기성</th>
          <th class="column24" colspan="4">은행계좌 및 수령자</th>
          <th class="column27" rowspan="2">비 고</th>
        </tr>
        <tr class="row5">
          <th class="column4">착공<br>일자</th>
          <th class="column5">준공<br>일자</th>
          <th class="column6"><small>(VAT별도)</small></th>
          <th class="column7"><small>(VAT별도)</small></th>
          <th class="column8">공급<br>가액</th>
          <th class="column9">부가세</th>
          <th class="column10">합계</th>
          <th class="column11">공급<br>가액</th>
          <th class="column12">부가세</th>
          <th class="column13">합계</th>
          <th class="column14">공급<br>가액</th>
          <th class="column15">부가세</th>
          <th class="column16">합계</th>
          <th class="column17">공제,<br>유보</th>
          <th class="column18">기불금<br>(지결)</th>
          <th class="column19">지급<br>금액</th>
          <th class="column20">공급<br>가액</th>
          <th class="column21">부가세</th>
          <th class="column22">합계</th>
          <th class="column23"><small>(VAT포함)</small></th>
          <th class="column24">은행명</th>
          <th class="column25">계좌<br>번호</th>
          <th class="column26">예금주</th>
          <th class="column26">대표자</th>
        </tr>
      </thead>


      <!-- 본문(각 공종별) -->
      
        <!--
          이하부터는 기존 코드를 유지하면서
          반복되는 부분(외주비, 자재비, 장비비, 노무비, 기타경비 등)
          mode별로 나뉘어 출력.
        -->

        <!-- =========================
             외주비 (mode1) 
        ========================== -->
        <tbody id="s1_add_line">
          <?php if($mode1 == '') { ?>
            <!-- 신규 입력 폼 (외주비) -->
            <!-- (생략) 동일한 구조의 빈 행 11개 -->
            <!-- 이하 샘플 2~3줄만 그대로 두고 필요만큼 반복 사용 -->
            <tr class="row6">
              <td class="column0 style36 s style80" rowspan="1" id="s1_add_tit">
                외<br><br>주<br><br>비<br>
                <i class="fa fa-plus-square" id="s1_add_row" aria-hidden="true"></i>
              </td>
              <td class="column1 style37 null style38" colspan="2">
                <input type="hidden" name="ne_type[]" value="1">
                <input type="text" name="s1_name[]" class="name1 input">
              </td>
              <td class="column3 style39 null"><input type="text" name="s1_gongjong[]" class="gongjong input"></td>
              <td class="column4 style40 null"><input type="text" name="s1_sdate[]" class="sdate input"></td>
              <td class="column5 style41 null"><input type="text" name="s1_edate[]" class="edate input"></td>
              <td class="column6 style42 null"><input type="text" name="s1_price1[]" class="price1 num input text-right"></td>
              <td class="column7 style43 null"><input type="text" name="s1_price2[]" class=" input num text-right"></td>
              <td class="column8 style44 null"><input type="text" name="s1_price3[]" class="price3 num input text-right"></td>
              <td class="column9 style45 null"><input type="text" name="s1_price4[]" class="price4 num input text-right"></td>
              <td class="column10 style46 null"><input type="text" name="s1_price5[]" class="price5 num input text-right"></td>
              <td class="column11 style47 null"><input type="text" name="s1_price6[]" class="price6 num input text-right"></td>
              <td class="column12 style45 null"><input type="text" name="s1_price7[]" class="price7 num input text-right"></td>
              <td class="column13 style48 null"><input type="text" name="s1_price8[]" class="price8 num input text-right"></td>
              <td class="column14 style49 null"><input type="text" name="s1_price9[]" class="price8 num input text-right"></td>
              <td class="column15 style50 null"><input type="text" name="s1_price10[]" class="price8 num input text-right"></td>
              <td class="column16 style45 null"><input type="text" name="s1_price11[]" readonly class="price8 num input text-right"></td>
              <td class="column17 style45 null"><input type="text" name="s1_price12[]" class="price8 num input text-right"></td>
              <td class="column18 style45 null"><input type="text" name="s1_price13[]" class="price8 num input text-right"></td>
              <td class="column19 style51 null"><input type="text" name="s1_price14[]" class="price8 num input text-right"></td>
              <td class="column20 style47 null"><input type="text" name="s1_price15[]" class="price8 num input text-right"></td>
              <td class="column21 style45 null"><input type="text" name="s1_price16[]" class="price8 num input text-right"></td>
              <td class="column22 style46 null"><input type="text" name="s1_price17[]" class="price8 num input text-right"></td>
              <td class="column23 style52 null"><input type="text" name="s1_price18[]" class="price18 num input text-right"></td>
              <td class="column24 style53 null"><input type="text" name="s1_bank[]" class="bank input "></td>
              <td class="column25 style54 null"><input type="text" name="s1_account[]" class="account input "></td>
              <td class="column26 style55 null"><input type="text" name="s1_accname[]" class="accname input "></td>
              <td class="column26 style55 null"><input type="text" name="s1_ceo[]" class="ceo input "></td>
              <td class="column27 style56 null"><input type="text" name="s1_etc[]" class="input "></td>
            </tr>
            <!-- ... 이하 동일 구조 반복 ... -->

          <?php } else if($mode1 == 'u') {
            // 외주비 DB 조회 후 출력
            $cnt1 = sql_num_rows($rst1);

            for($i=0; $row=sql_fetch_array($rst1); $i++) {

              if($date != $row['ne_date']) $readonly = "readonly";
              
              // 금회기성 금액 등 별도 테이블 참조
              $p = sql_fetch("SELECT * 
                              FROM {$none['est_jungsan_price']} 
                              WHERE parent_id = '{$row['seq']}' 
                              AND ne_date = '{$date}'");

              $row['ne_price9']  = $p['ne_price9'];
              $row['ne_price10'] = $p['ne_price10'];
              $row['ne_price11'] = $p['ne_price11'];
              $row['ne_price12'] = $p['ne_price12'];
              $row['ne_price13'] = $p['ne_price13'];
              $row['ne_price14'] = $p['ne_price14'];

              // 전회 기성
              $ppsql = "SELECT SUM(ne_price9) AS price6,
                               SUM(ne_price10) AS price7,
                               SUM(ne_price11) AS price8
                        FROM {$none['est_jungsan_price']}
                        WHERE parent_id = '{$row['seq']}'
                        AND ne_date < '{$date}'";
              $pprst = sql_query($ppsql);

              $price6 = $price7 = $price8 = 0;
              while($pp=sql_fetch_array($pprst)) {
                  $price6 = (int)$pp['price6'];
                  $price7 = (int)$pp['price7'];
                  $price8 = (int)$pp['price8'];
              }

              // 누계
              $row['ne_price15'] = $price6 + $row['ne_price9'];
              $row['ne_price16'] = $price7 + $row['ne_price10'];
              $row['ne_price17'] = $price8 + $row['ne_price11'];

              // 잔여기성
              $row['ne_price18'] = $row['ne_price5'] - $row['ne_price17'];
          ?>
            <tr class="row6 dataRow_<?php echo $row['seq'];?>">
              <?php if($i==0) { ?>
                <td class="column0 style36 s style80" rowspan="<?php echo $cnt1?>" id="s1_add_tit">
                  외<br><br>주<br><br>비<br>
                  <i class="fa fa-plus-square" id="s1_add_row" aria-hidden="true"></i>
                </td>
              <?php } ?>
              <td class="column1 style37 null style38" colspan="2">
                <input type="hidden" name="s1_seq[]" value="<?php echo $row['seq']?>">
                <span class="glyphicon glyphicon-trash delete-icon" onclick="delete_row(<?php echo $row['seq']?>, '1', this)"></span>
                <input type="text" name="s1_name[]" value="<?php echo $row['ne_name']?>" class="name1 input" style="width:80%">
              </td>
              <td class="column3 style39 null"><input type="text" name="s1_gongjong[]"  value="<?php echo $row['ne_gongjong']?>" class="gongjong input"></td>
              <td class="column4 style40 null"><input type="text" name="s1_sdate[]"    value="<?php echo $row['ne_sdate']?>"   class="sdate input"></td>
              <td class="column5 style41 null"><input type="text" name="s1_edate[]"    value="<?php echo $row['ne_edate']?>"   class="edate input"></td>
              <td class="column6 style42 null"><input type="text" name="s1_price1[]"   value="<?php echo $row['ne_price1']?>"  class="price1 num input text-right"></td>
              <td class="column7 style43 null"><input type="text" name="s1_price2[]"   value="<?php echo $row['ne_price15']?>" class="input num text-right"></td>
              <td class="column8 style44 null"><input type="text" name="s1_price3[]"   value="<?php echo $row['ne_price3']?>"  class="price3 num input text-right"></td>
              <td class="column9 style45 null"><input type="text" name="s1_price4[]"   value="<?php echo $row['ne_price4']?>"  class="price4 num input text-right"></td>
              <td class="column10 style46 null"><input type="text" name="s1_price5[]"  value="<?php echo $row['ne_price5']?>"  class="price5 num input text-right"></td>
              <td class="column11 style47 null"><input type="text" name="s1_price6[]"  value="<?php echo $price6?>"            class="price6 num input text-right"></td>
              <td class="column12 style45 null"><input type="text" name="s1_price7[]"  value="<?php echo $price7?>"            class="price7 num input text-right"></td>
              <td class="column13 style48 null"><input type="text" name="s1_price8[]"  value="<?php echo $price8?>"            class="price8 num input text-right"></td>
              <td class="column14 style49 null"><input type="text" name="s1_price9[]"  value="<?php echo $row['ne_price9']?>"  class="price8 num input text-right"></td>
              <td class="column15 style50 null"><input type="text" name="s1_price10[]" value="<?php echo $row['ne_price10']?>" class="price8 num input text-right"></td>
              <td class="column16 style45 null"><input type="text" name="s1_price11[]" value="<?php echo $row['ne_price11']?>" class="price8 num input text-right" readonly></td>
              <td class="column17 style45 null"><input type="text" name="s1_price12[]" value="<?php echo $row['ne_price12']?>" class="price8 num input text-right"></td>
              <td class="column18 style45 null"><input type="text" name="s1_price13[]" value="<?php echo $row['ne_price13']?>" class="price8 num input text-right"></td>
              <td class="column19 style51 null"><input type="text" name="s1_price14[]" value="<?php echo $row['ne_price14']?>" class="price8 num input text-right"></td>
              <td class="column20 style47 null"><input type="text" name="s1_price15[]" value="<?php echo $row['ne_price15']?>" class="price8 num input text-right"></td>
              <td class="column21 style45 null"><input type="text" name="s1_price16[]" value="<?php echo $row['ne_price16']?>" class="price8 num input text-right"></td>
              <td class="column22 style46 null"><input type="text" name="s1_price17[]" value="<?php echo $row['ne_price17']?>" class="price8 num input text-right"></td>
              <td class="column23 style52 null"><input type="text" name="s1_price18[]" value="<?php echo $row['ne_price18']?>" class="price18 num input text-right"></td>
              <td class="column24 style53 null"><input type="text" name="s1_bank[]"    value="<?php echo $row['ne_bank']?>"     class="bank input"></td>
              <td class="column25 style54 null"><input type="text" name="s1_account[]" value="<?php echo $row['ne_account']?>"  class="account input"></td>
              <td class="column26 style55 null"><input type="text" name="s1_accname[]" value="<?php echo $row['ne_accname']?>" class="accname input"></td>
              <td class="column26 style55 null"><input type="text" name="s1_ceo[]"     value="<?php echo $row['ne_ceo']?>"      class="ceo input"></td>
              <td class="column27 style56 null"><input type="text" name="s1_etc[]"     value="<?php echo $row['ne_etc']?>"      class="input"></td>
            </tr>
            <?php 
            // 누적합계 계산
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
            } // end for
          } // end else if($mode1=='u')
        ?>
        </tbody>

        <!-- 외주비 소계 표시 (subtotal 클래스) -->
        <!-- 외주비 소계 표시 (subtotal 클래스) - 툴팁 적용 -->
        <tr class="row19 subtotal">
          <td class="column1 style81 s style83" colspan="3">소&nbsp;&nbsp;계</td>
          <td class="column4 style84 null"></td>
          <td class="column5 style85 null"></td>
          <td class="column6 style86 f"></td>
          <td class="column7 style86 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price1_total); ?>">
              <?php echo number_format($s1_price1_total); ?>
            </span>
          </td>
          <td class="column8 style87 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price2_total); ?>">
              <?php echo number_format($s1_price2_total); ?>
            </span>
          </td>
          <td class="column8 style87 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price3_total); ?>">
              <?php echo number_format($s1_price3_total); ?>
            </span>
          </td>
          <td class="column9 style88 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price4_total); ?>">
              <?php echo number_format($s1_price4_total); ?>
            </span>
          </td>
          <td class="column10 style89 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price5_total); ?>">
              <?php echo number_format($s1_price5_total); ?>
            </span>
          </td>
          <td class="column11 style90 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price6_total); ?>">
              <?php echo number_format($s1_price6_total); ?>
            </span>
          </td>
          <td class="column12 style88 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price7_total); ?>">
              <?php echo number_format($s1_price7_total); ?>
            </span>
          </td>
          <td class="column13 style91 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price8_total); ?>">
              <?php echo number_format($s1_price8_total); ?>
            </span>
          </td>
          <td class="column14 style92 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price9_total); ?>">
              <?php echo number_format($s1_price9_total); ?>
            </span>
          </td>
          <td class="column15 style88 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price10_total); ?>">
              <?php echo number_format($s1_price10_total); ?>
            </span>
          </td>
          <td class="column16 style88 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price11_total); ?>">
              <?php echo number_format($s1_price11_total); ?>
            </span>
          </td>
          <td class="column17 style88 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price12_total); ?>">
              <?php echo number_format($s1_price12_total); ?>
            </span>
          </td>
          <td class="column18 style88 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price13_total); ?>">
              <?php echo number_format($s1_price13_total); ?>
            </span>
          </td>
          <td class="column19 style93 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price14_total); ?>">
              <?php echo number_format($s1_price14_total); ?>
            </span>
          </td>
          <td class="column20 style90 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price15_total); ?>">
              <?php echo number_format($s1_price15_total); ?>
            </span>
          </td>
          <td class="column21 style88 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price16_total); ?>">
              <?php echo number_format($s1_price16_total); ?>
            </span>
          </td>
          <td class="column22 style89 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price17_total); ?>">
              <?php echo number_format($s1_price17_total); ?>
            </span>
          </td>
          <td class="column23 style86 f">
            <span class="hover-enlarge" data-value="<?php echo number_format($s1_price18_total); ?>">
              <?php echo number_format($s1_price18_total); ?>
            </span>
          </td>
          <td class="column24 style94 null"></td>
          <td class="column25 style95 null"></td>
          <td class="column26 style95 null"></td>
          <td class="column26 style95 null"></td>
          <td class="column27 style96 null"></td>
        </tr>

        <!-- ==================================
             자재비 (mode2) 
             (이하 구조 동일, 주석/내용 생략)
        ================================== -->
        <tbody id="s2_add_line">
		  <?php if($mode2 == '') {?>
          <tr class="row20">
            <td class="column0 style97 s style104" rowspan="1" id="s2_add_tit">자<br><br>재<br><br>비<br><i class="fa fa-plus-square" id="s2_add_row" aria-hidden="true"></i></td>
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="2">
			<input type="text" name="s2_name[]" class="input"></td>
            <td class="column3 style39 null"><input type="text" name="s2_gongjong[]" class="gongjong input"></td>
            <td class="column4 style40 null"><input type="text" name="s2_sdate[]" class="sdate input"></td>
            <td class="column5 style41 null"><input type="text" name="s2_edate[]" class="edate input"></td>
            <td class="column6 style42 null"><input type="text" name="s2_price1[]" class="price1 num input text-right"></td>
            <td class="column7 style43 null"><input type="text" name="s2_price2[]" class=" input num text-right"></td>
            <td class="column8 style44 null"><input type="text" name="s2_price3[]" class="price3 num input text-right"></td>
            <td class="column9 style45 null"><input type="text" name="s2_price4[]" class="price4 num input text-right"></td>
            <td class="column10 style46 null"><input type="text" name="s2_price5[]" class="price5 num input text-right"></td>
            <td class="column11 style47 null"><input type="text" name="s2_price6[]" class="price6 num input text-right"></td>
            <td class="column12 style45 null"><input type="text" name="s2_price7[]" class="price7 num input text-right"></td>
            <td class="column13 style48 null"><input type="text" name="s2_price8[]" class="price8 num input text-right"></td>
            <td class="column14 style49 null"><input type="text" name="s2_price9[]" class="price8 num input text-right"></td>
            <td class="column15 style50 null"><input type="text" name="s2_price10[]" class="price8 num input text-right"></td>
            <td class="column16 style45 null"><input type="text" name="s2_price11[]" readonly class="price8 num input text-right"></td>
            <td class="column17 style45 null"><input type="text" name="s2_price12[]" class="price8 num input text-right"></td>
            <td class="column18 style45 null"><input type="text" name="s2_price13[]" class="price8 num input text-right"></td>
            <td class="column19 style51 null"><input type="text" name="s2_price14[]" class="price8 num input text-right"></td>
            <td class="column20 style47 null"><input type="text" name="s2_price15[]" class="price8 num input text-right"></td>
            <td class="column21 style45 null"><input type="text" name="s2_price16[]" class="price8 num input text-right"></td>
            <td class="column22 style46 null"><input type="text" name="s2_price17[]" class="price8 num input text-right"></td>
            <td class="column23 style52 null"><input type="text" name="s2_price18[]" class="price18 num input text-right"></td>
            <td class="column24 style53 null"><input type="text" name="s2_bank[]" class="bank input "></td>
            <td class="column25 style54 null"><input type="text" name="s2_account[]" class="account input "></td>
            <td class="column26 style55 null"><input type="text" name="s2_accname[]" class="accname input "></td>
            <td class="column26 style55 null"><input type="text" name="s2_ceo[]" class="ceo input "></td>
            <td class="column27 style56 null"><input type="text" name="s2_etc[]" class="input "></td>
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
				<td class="column0 style36 s style104" rowspan="<?php echo $cnt2?>" id="s2_add_tit">자<br><br>재<br><br>비<br><i class="fa fa-plus-square" id="s2_add_row" aria-hidden="true"></i></td>
				<?php }?>
				<td class="column1 style37 null style38" colspan="2">
				<input type="hidden" name="s2_seq[]" value="<?php echo $row['seq']?>">
				<span class="glyphicon glyphicon-trash delete-icon" onclick="delete_row(<?php echo $row['seq']?>, '2', this)"></span>
				<input type="text" name="s2_name[]" value="<?php echo $row['ne_name']?>" class="name1 input" style="width:80%"></td>
				<td class="column3 style39 null"><input type="text" name="s2_gongjong[]" class="gongjong input"  value="<?php echo $row['ne_gongjong']?>"></td>
				<td class="column4 style40 null"><input type="text" name="s2_sdate[]" class="sdate input"  value="<?php echo $row['ne_sdate']?>"></td>
				<td class="column5 style41 null"><input type="text" name="s2_edate[]" class="edate input"  value="<?php echo $row['ne_edate']?>"></td>
				<td class="column6 style42 null"><input type="text" name="s2_price1[]" class="price1 num input text-right"  value="<?php echo $row['ne_price1']?>"></td>
				<td class="column7 style43 null"><input type="text" name="s2_price2[]" class=" input num text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column8 style44 null"><input type="text" name="s2_price3[]" class="price3 num input text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column9 style45 null"><input type="text" name="s2_price4[]" class="price4 num input text-right" value="<?php echo $row['ne_price16']?>"></td>
				<td class="column10 style46 null"><input type="text" name="s2_price5[]" class="price5 num input text-right" value="<?php echo $row['ne_price17']?>"></td>
				<td class="column11 style47 null"><input type="text" name="s2_price6[]" class="price6 num input text-right" readonly value="<?php echo $price6?>"></td>
				<td class="column12 style45 null"><input type="text" name="s2_price7[]" class="price7 num input text-right" readonly value="<?php echo $price7?>"></td>
				<td class="column13 style48 null"><input type="text" name="s2_price8[]" class="price8 num input text-right" readonly value="<?php echo $price8?>"></td>
				<td class="column14 style49 null"><input type="text" name="s2_price9[]" class="price8 num input text-right" value="<?php echo $row['ne_price9']?>"></td>
				<td class="column15 style50 null"><input type="text" name="s2_price10[]" class="price8 num input text-right" value="<?php echo $row['ne_price10']?>"></td>
				<td class="column16 style45 null"><input type="text" name="s2_price11[]" readonly class="price8 num input text-right" value="<?php echo $row['ne_price11']?>"></td>
				<td class="column17 style45 null"><input type="text" name="s2_price12[]" class="price8 num input text-right" value="<?php echo $row['ne_price12']?>"></td>
				<td class="column18 style45 null"><input type="text" name="s2_price13[]" class="price8 num input text-right" value="<?php echo $row['ne_price13']?>"></td>
				<td class="column19 style51 null"><input type="text" name="s2_price14[]" class="price8 num input text-right" value="<?php echo $row['ne_price14']?>"></td>
				<td class="column20 style47 null"><input type="text" name="s2_price15[]" class="price8 num input text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column21 style45 null"><input type="text" name="s2_price16[]" class="price8 num input text-right" value="<?php echo $row['ne_price16']?>"></td>
				<td class="column22 style46 null"><input type="text" name="s2_price17[]" class="price8 num input text-right" value="<?php echo $row['ne_price17']?>"></td>
				<td class="column23 style52 null"><input type="text" name="s2_price18[]" class="price18 num input text-right" value="<?php echo $row['ne_price18']?>"></td>
				<td class="column24 style53 null"><input type="text" name="s2_bank[]" class="bank input " value="<?php echo $row['ne_bank']?>"></td>
				<td class="column25 style54 null"><input type="text" name="s2_account[]" class="account input " value="<?php echo $row['ne_account']?>"></td>
				<td class="column26 style55 null"><input type="text" name="s2_accname[]" class="accname input " value="<?php echo $row['ne_accname']?>"></td>
				<td class="column26 style55 null"><input type="text" name="s2_ceo[]" class="ceo input " value="<?php echo $row['ne_ceo']?>"></td>
				<td class="column27 style56 null"><input type="text" name="s2_etc[]" class="input " value="<?php echo $row['ne_etc']?>"></td>
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
          
         <tr class="row35 subtotal">
    <td class="column1 style105 s style107" colspan="3">소&nbsp;&nbsp;계</td>
    <td class="column4 style108 null"></td>
    <td class="column5 style109 null"></td>
    <td class="column6 style110 f"></td>
    <td class="column7 style110 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price1_total); ?>">
        <?php echo number_format($s2_price1_total); ?>
      </span>
    </td>
    <td class="column8 style111 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price2_total); ?>">
        <?php echo number_format($s2_price2_total); ?>
      </span>
    </td>
    <td class="column9 style112 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price3_total); ?>">
        <?php echo number_format($s2_price3_total); ?>
      </span>
    </td>
    <td class="column10 style113 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price4_total); ?>">
        <?php echo number_format($s2_price4_total); ?>
      </span>
    </td>
    <td class="column11 style114 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price5_total); ?>">
        <?php echo number_format($s2_price5_total); ?>
      </span>
    </td>
    <td class="column12 style112 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price6_total); ?>">
        <?php echo number_format($s2_price6_total); ?>
      </span>
    </td>
    <td class="column13 style115 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price7_total); ?>">
        <?php echo number_format($s2_price7_total); ?>
      </span>
    </td>
    <td class="column14 style116 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price8_total); ?>">
        <?php echo number_format($s2_price8_total); ?>
      </span>
    </td>
    <td class="column15 style112 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price9_total); ?>">
        <?php echo number_format($s2_price9_total); ?>
      </span>
    </td>
    <td class="column16 style112 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price10_total); ?>">
        <?php echo number_format($s2_price10_total); ?>
      </span>
    </td>
    <td class="column17 style112 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price11_total); ?>">
        <?php echo number_format($s2_price11_total); ?>
      </span>
    </td>
    <td class="column18 style112 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price12_total); ?>">
        <?php echo number_format($s2_price12_total); ?>
      </span>
    </td>
    <td class="column19 style117 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price13_total); ?>">
        <?php echo number_format($s2_price13_total); ?>
      </span>
    </td>
    <td class="column20 style114 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price14_total); ?>">
        <?php echo number_format($s2_price14_total); ?>
      </span>
    </td>
    <td class="column21 style112 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price15_total); ?>">
        <?php echo number_format($s2_price15_total); ?>
      </span>
    </td>
    <td class="column22 style113 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price16_total); ?>">
        <?php echo number_format($s2_price16_total); ?>
      </span>
    </td>
    <td class="column23 style110 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s2_price17_total); ?>">
        <?php echo number_format($s2_price17_total); ?>
      </span>
    </td>
    <td class="column24 style114 null"></td>
    <td class="column25 style112 null"></td>
    <td class="column26 style112 null"></td>
    <td class="column26 style112 null"></td>
    <td class="column27 style118 null"></td>
</tr>


        <!-- ==================================
             장비비 (mode3)
        ================================== -->
        <tbody id="s3_add_line">
		   <?php if($mode3 == '') {?>
		  
          <tr class="row36">
            <td class="column0 style119 s style119" rowspan="1" id="s3_add_tit">장<br><br>비<br><br>비<br><i class="fa fa-plus-square" aria-hidden="true" id="s3_add_row"></i></td>
            <td class="column1 style37 nell style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="3">
			<input type="text" name="s3_name[]" class="input"></td>
            <td class="column3 style39 null"><input type="text" name="s3_gongjong[]" class="gongjong input"></td>
            <td class="column4 style40 null"><input type="text" name="s3_sdate[]" class="sdate input"></td>
            <td class="column5 style41 null"><input type="text" name="s3_edate[]" class="edate input"></td>
            <td class="column6 style42 null"><input type="text" name="s3_price1[]" class="price1 num input text-right"></td>
            <td class="column7 style43 null"><input type="text" name="s3_price2[]" class=" input num text-right"></td>
            <td class="column8 style44 null"><input type="text" name="s3_price3[]" class="price3 num input text-right"></td>
            <td class="column9 style45 null"><input type="text" name="s3_price4[]" class="price4 num input text-right"></td>
            <td class="column10 style46 null"><input type="text" name="s3_price5[]" class="price5 num input text-right"></td>
            <td class="column11 style47 null"><input type="text" name="s3_price6[]" class="price6 num input text-right"></td>
            <td class="column12 style45 null"><input type="text" name="s3_price7[]" class="price7 num input text-right"></td>
            <td class="column13 style48 null"><input type="text" name="s3_price8[]" class="price8 num input text-right"></td>
            <td class="column14 style49 null"><input type="text" name="s3_price9[]" class="price8 num input text-right"></td>
            <td class="column15 style50 null"><input type="text" name="s3_price10[]" class="price8 num input text-right"></td>
            <td class="column16 style45 null"><input type="text" name="s3_price11[]" readonly class="price8 num input text-right"></td>
            <td class="column17 style45 null"><input type="text" name="s3_price12[]" class="price8 num input text-right"></td>
            <td class="column18 style45 null"><input type="text" name="s3_price13[]" class="price8 num input text-right"></td>
            <td class="column19 style51 null"><input type="text" name="s3_price14[]" class="price8 num input text-right"></td>
            <td class="column20 style47 null"><input type="text" name="s3_price15[]" class="price8 num input text-right"></td>
            <td class="column21 style45 null"><input type="text" name="s3_price16[]" class="price8 num input text-right"></td>
            <td class="column22 style46 null"><input type="text" name="s3_price17[]" class="price8 num input text-right"></td>
            <td class="column23 style52 null"><input type="text" name="s3_price18[]" class="price18 num input text-right"></td>
            <td class="column24 style53 null"><input type="text" name="s3_bank[]" class="bank input "></td>
            <td class="column25 style54 null"><input type="text" name="s3_account[]" class="account input "></td>
            <td class="column26 style55 null"><input type="text" name="s3_accname[]" class="accname input "></td>
			<td class="column26 style55 null"><input type="text" name="s3_ceo[]" class="ceo input " ></td>
            <td class="column27 style56 null"><input type="text" name="s3_etc[]" class="input "></td>
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
				<td class="column0 style36 s style119" rowspan="<?php echo $cnt3?>" id="s3_add_tit">장<br><br>비<br><br>비<br><i class="fa fa-plus-square" id="s3_add_row" aria-hidden="true"></i></td>
				<?php }?>
				<td class="column1 style37 null style38" colspan="2">
				<input type="hidden" name="s3_seq[]" value="<?php echo $row['seq']?>">
				<span class="glyphicon glyphicon-trash delete-icon" onclick="delete_row(<?php echo $row['seq']?>, '3', this)"></span>
				<input type="text" name="s3_name[]" value="<?php echo $row['ne_name']?>" class="name1 input"  style="width:80%"></td>
				<td class="column3 style39 null"><input type="text" name="s3_gongjong[]" class="gongjong input"  value="<?php echo $row['ne_gongjong']?>"></td>
				<td class="column4 style40 null"><input type="text" name="s3_sdate[]" class="sdate input"  value="<?php echo $row['ne_sdate']?>"></td>
				<td class="column5 style41 null"><input type="text" name="s3_edate[]" class="edate input"  value="<?php echo $row['ne_edate']?>"></td>
				<td class="column6 style42 null"><input type="text" name="s3_price1[]" class="price1 num input text-right"  value="<?php echo $row['ne_price1']?>"></td>
				<td class="column7 style43 null"><input type="text" name="s3_price2[]" class=" input num text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column8 style44 null"><input type="text" name="s3_price3[]" class="price3 num input text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column9 style45 null"><input type="text" name="s3_price4[]" class="price4 num input text-right" value="<?php echo $row['ne_price16']?>"></td>
				<td class="column10 style46 null"><input type="text" name="s3_price5[]" class="price5 num input text-right" value="<?php echo $row['ne_price17']?>"></td>
				<td class="column11 style47 null"><input type="text" name="s3_price6[]" class="price6 num input text-right" value="<?php echo $price6?>"></td>
				<td class="column12 style45 null"><input type="text" name="s3_price7[]" class="price7 num input text-right" value="<?php echo $price7?>"></td>
				<td class="column13 style48 null"><input type="text" name="s3_price8[]" class="price8 num input text-right" value="<?php echo $price8?>"></td>
				<td class="column14 style49 null"><input type="text" name="s3_price9[]" class="price8 num input text-right" value="<?php echo $row['ne_price9']?>"></td>
				<td class="column15 style50 null"><input type="text" name="s3_price10[]" class="price8 num input text-right" value="<?php echo $row['ne_price10']?>"></td>
				<td class="column16 style45 null"><input type="text" name="s3_price11[]" readonly class="price8 num input text-right" value="<?php echo $row['ne_price11']?>"></td>
				<td class="column17 style45 null"><input type="text" name="s3_price12[]" class="price8 num input text-right" value="<?php echo $row['ne_price12']?>"></td>
				<td class="column18 style45 null"><input type="text" name="s3_price13[]" class="price8 num input text-right" value="<?php echo $row['ne_price13']?>"></td>
				<td class="column19 style51 null"><input type="text" name="s3_price14[]" class="price8 num input text-right" value="<?php echo $row['ne_price14']?>"></td>
				<td class="column20 style47 null"><input type="text" name="s3_price15[]" class="price8 num input text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column21 style45 null"><input type="text" name="s3_price16[]" class="price8 num input text-right" value="<?php echo $row['ne_price16']?>"></td>
				<td class="column22 style46 null"><input type="text" name="s3_price17[]" class="price8 num input text-right" value="<?php echo $row['ne_price17']?>"></td>
				<td class="column23 style52 null"><input type="text" name="s3_price18[]" class="price18 num input text-right" value="<?php echo $row['ne_price18']?>"></td>
				<td class="column24 style53 null"><input type="text" name="s3_bank[]" class="bank input " value="<?php echo $row['ne_bank']?>"></td>
				<td class="column25 style54 null"><input type="text" name="s3_account[]" class="account input " value="<?php echo $row['ne_account']?>"></td>
				<td class="column26 style55 null"><input type="text" name="s3_accname[]" class="accname input " value="<?php echo $row['ne_accname']?>"></td>
				<td class="column26 style55 null"><input type="text" name="s3_ceo[]" class="ceo input " value="<?php echo $row['ne_ceo']?>"></td>
				<td class="column27 style56 null"><input type="text" name="s3_etc[]" class="input " value="<?php echo $row['ne_etc']?>"></td>
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
         
          <tr class="row50 subtotal">
    <td class="column1 style120 s style128" colspan="3">소&nbsp;&nbsp;계</td>
    <td class="column4 style123 null"></td>
    <td class="column5 style124 null"></td>
    <td class="column6 style125 f"></td>
    <td class="column6 style125 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price1_total); ?>">
        <?php echo number_format($s3_price1_total); ?>
      </span>
    </td>
    <td class="column7 style125 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price2_total); ?>">
        <?php echo number_format($s3_price2_total); ?>
      </span>
    </td>
    <td class="column8 style126 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price3_total); ?>">
        <?php echo number_format($s3_price3_total); ?>
      </span>
    </td>
    <td class="column9 style127 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price4_total); ?>">
        <?php echo number_format($s3_price4_total); ?>
      </span>
    </td>
    <td class="column10 style128 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price5_total); ?>">
        <?php echo number_format($s3_price5_total); ?>
      </span>
    </td>
    <td class="column11 style129 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price6_total); ?>">
        <?php echo number_format($s3_price6_total); ?>
      </span>
    </td>
    <td class="column12 style127 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price7_total); ?>">
        <?php echo number_format($s3_price7_total); ?>
      </span>
    </td>
    <td class="column13 style130 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price8_total); ?>">
        <?php echo number_format($s3_price8_total); ?>
      </span>
    </td>
    <td class="column14 style131 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price9_total); ?>">
        <?php echo number_format($s3_price9_total); ?>
      </span>
    </td>
    <td class="column15 style127 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price10_total); ?>">
        <?php echo number_format($s3_price10_total); ?>
      </span>
    </td>
    <td class="column16 style127 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price11_total); ?>">
        <?php echo number_format($s3_price11_total); ?>
      </span>
    </td>
    <td class="column17 style127 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price12_total); ?>">
        <?php echo number_format($s3_price12_total); ?>
      </span>
    </td>
    <td class="column18 style127 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price13_total); ?>">
        <?php echo number_format($s3_price13_total); ?>
      </span>
    </td>
    <td class="column19 style132 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price14_total); ?>">
        <?php echo number_format($s3_price14_total); ?>
      </span>
    </td>
    <td class="column20 style129 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price15_total); ?>">
        <?php echo number_format($s3_price15_total); ?>
      </span>
    </td>
    <td class="column21 style127 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price16_total); ?>">
        <?php echo number_format($s3_price16_total); ?>
      </span>
    </td>
    <td class="column22 style128 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price17_total); ?>">
        <?php echo number_format($s3_price17_total); ?>
      </span>
    </td>
    <td class="column23 style125 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s3_price18_total); ?>">
        <?php echo number_format($s3_price18_total); ?>
      </span>
    </td>
    <td class="column24 style129 null"></td>
    <td class="column25 style127 null"></td>
    <td class="column26 style133 null"></td>
    <td class="column26 style133 null"></td>
    <td class="column27 style134 null"></td>
</tr>

		  <tbody id="s4_add_line">
         
			<?php if($mode4 == '') {?>
			<tr class="row51">
            <td class="column0 style135 s style135" rowspan="1"  id="s4_add_tit">노<br><br>무<br><br>비<br><i class="fa fa-plus-square" aria-hidden="true" id="s4_add_row"></i></td>
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="4">
			<input type="text" name="s4_name[]" class="input"></td>
            <td class="column3 style39 null"><input type="text" name="s4_gongjong[]" class="gongjong input"></td>
            <td class="column4 style40 null"><input type="text" name="s4_sdate[]" class="sdate input"></td>
            <td class="column5 style41 null"><input type="text" name="s4_edate[]" class="edate input"></td>
            <td class="column6 style42 null"><input type="text" name="s4_price1[]" class="price1 num input text-right"></td>
            <td class="column7 style43 null"><input type="text" name="s4_price2[]" class=" input num text-right"></td>
            <td class="column8 style44 null"><input type="text" name="s4_price3[]" class="price3 num input text-right"></td>
            <td class="column9 style45 null"><input type="text" name="s4_price4[]" class="price4 num input text-right"></td>
            <td class="column10 style46 null"><input type="text" name="s4_price5[]" class="price5 num input text-right"></td>
            <td class="column11 style47 null"><input type="text" name="s4_price6[]" class="price6 num input text-right"></td>
            <td class="column12 style45 null"><input type="text" name="s4_price7[]" class="price7 num input text-right"></td>
            <td class="column13 style48 null"><input type="text" name="s4_price8[]" class="price8 num input text-right"></td>
            <td class="column14 style49 null"><input type="text" name="s4_price9[]" class="price8 num input text-right"></td>
            <td class="column15 style50 null"><input type="text" name="s4_price10[]" class="price8 num input text-right"></td>
            <td class="column16 style45 null"><input type="text" name="s4_price11[]" readonly class="price8 num input text-right"></td>
            <td class="column17 style45 null"><input type="text" name="s4_price12[]" class="price8 num input text-right"></td>
            <td class="column18 style45 null"><input type="text" name="s4_price13[]" class="price8 num input text-right"></td>
            <td class="column19 style51 null"><input type="text" name="s4_price14[]" class="price8 num input text-right"></td>
            <td class="column20 style47 null"><input type="text" name="s4_price15[]" class="price8 num input text-right"></td>
            <td class="column21 style45 null"><input type="text" name="s4_price16[]" class="price8 num input text-right"></td>
            <td class="column22 style46 null"><input type="text" name="s4_price17[]" class="price8 num input text-right"></td>
            <td class="column23 style52 null"><input type="text" name="s4_price18[]" class="price18 num input text-right"></td>
            <td class="column24 style53 null"><input type="text" name="s4_bank[]" class="bank input "></td>
            <td class="column25 style54 null"><input type="text" name="s4_account[]" class="account input "></td>
            <td class="column26 style55 null"><input type="text" name="s4_accname[]" class="accname input "></td>
            <td class="column26 style55 null"><input type="text" name="s4_ceo[]" class="ceo input "></td>
            <td class="column27 style56 null"><input type="text" name="s4_etc[]" class="input "></td>
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
				<td class="column0 style36 s style135" rowspan="<?php echo $cnt4?>" id="s4_add_tit">노<br><br>무<br><br>비<br><i class="fa fa-plus-square" id="s4_add_row" aria-hidden="true"></i></td>
				<?php }?>
				<td class="column1 style37 null style38" colspan="2">
				<input type="hidden" name="s4_seq[]" value="<?php echo $row['seq']?>">
				<span class="glyphicon glyphicon-trash delete-icon" onclick="delete_row(<?php echo $row['seq']?>, '4', this)"></span>
				<input type="text" name="s4_name[]" value="<?php echo $row['ne_name']?>" class="name1 input"  style="width:80%"></td>
				<td class="column3 style39 null"><input type="text" name="s4_gongjong[]" class="gongjong input"  value="<?php echo $row['ne_gongjong']?>"></td>
				<td class="column4 style40 null"><input type="text" name="s4_sdate[]" class="sdate input"  value="<?php echo $row['ne_sdate']?>"></td>
				<td class="column5 style41 null"><input type="text" name="s4_edate[]" class="edate input"  value="<?php echo $row['ne_edate']?>"></td>
				<td class="column6 style42 null"><input type="text" name="s4_price1[]" class="price1 num input text-right"  value="<?php echo $row['ne_price1']?>"></td>
				<td class="column7 style43 null"><input type="text" name="s4_price2[]" class=" input num text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column8 style44 null"><input type="text" name="s4_price3[]" class="price3 num input text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column9 style45 null"><input type="text" name="s4_price4[]" class="price4 num input text-right" value="<?php echo $row['ne_price16']?>"></td>
				<td class="column10 style46 null"><input type="text" name="s4_price5[]" class="price5 num input text-right" value="<?php echo $row['ne_price17']?>"></td>
				<td class="column11 style47 null"><input type="text" name="s4_price6[]" class="price6 num input text-right" value="<?php echo $price6?>"></td>
				<td class="column12 style45 null"><input type="text" name="s4_price7[]" class="price7 num input text-right" value="<?php echo $price7?>"></td>
				<td class="column13 style48 null"><input type="text" name="s4_price8[]" class="price8 num input text-right" value="<?php echo $price8?>"></td>
				<td class="column14 style49 null"><input type="text" name="s4_price9[]" class="price8 num input text-right" value="<?php echo $row['ne_price9']?>"></td>
				<td class="column15 style50 null"><input type="text" name="s4_price10[]" class="price8 num input text-right" value="<?php echo $row['ne_price10']?>"></td>
				<td class="column16 style45 null"><input type="text" name="s4_price11[]" readonly class="price8 num input text-right" value="<?php echo $row['ne_price11']?>"></td>
				<td class="column17 style45 null"><input type="text" name="s4_price12[]" class="price8 num input text-right" value="<?php echo $row['ne_price12']?>"></td>
				<td class="column18 style45 null"><input type="text" name="s4_price13[]" class="price8 num input text-right" value="<?php echo $row['ne_price13']?>"></td>
				<td class="column19 style51 null"><input type="text" name="s4_price14[]" class="price8 num input text-right" value="<?php echo $row['ne_price14']?>"></td>
				<td class="column20 style47 null"><input type="text" name="s4_price15[]" class="price8 num input text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column21 style45 null"><input type="text" name="s4_price16[]" class="price8 num input text-right" value="<?php echo $row['ne_price16']?>"></td>
				<td class="column22 style46 null"><input type="text" name="s4_price17[]" class="price8 num input text-right" value="<?php echo $row['ne_price17']?>"></td>
				<td class="column23 style52 null"><input type="text" name="s4_price18[]" class="price18 num input text-right" value="<?php echo $row['ne_price18']?>"></td>
				<td class="column24 style53 null"><input type="text" name="s4_bank[]" class="bank input " value="<?php echo $row['ne_bank']?>"></td>
				<td class="column25 style54 null"><input type="text" name="s4_account[]" class="account input " value="<?php echo $row['ne_account']?>"></td>
				<td class="column26 style55 null"><input type="text" name="s4_accname[]" class="accname input " value="<?php echo $row['ne_accname']?>"></td>
				<td class="column26 style55 null"><input type="text" name="s4_ceo[]" class="ceo input " value="<?php echo $row['ne_ceo']?>"></td>
				<td class="column27 style56 null"><input type="text" name="s4_etc[]" class="input " value="<?php echo $row['ne_etc']?>"></td>
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
      <tr class="row81 subtotal">
    <td class="column1 style136 s style138" colspan="3">소&nbsp;&nbsp;계</td>
    <td class="column4 style139 null"></td>
    <td class="column5 style140 null"></td>
    <td class="column6 style141 f"></td>
    <td class="column6 style141 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price1_total); ?>">
        <?php echo number_format($s4_price1_total); ?>
      </span>
    </td>
    <td class="column7 style141 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price2_total); ?>">
        <?php echo number_format($s4_price2_total); ?>
      </span>
    </td>
    <td class="column8 style142 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price3_total); ?>">
        <?php echo number_format($s4_price3_total); ?>
      </span>
    </td>
    <td class="column9 style143 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price4_total); ?>">
        <?php echo number_format($s4_price4_total); ?>
      </span>
    </td>
    <td class="column10 style144 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price5_total); ?>">
        <?php echo number_format($s4_price5_total); ?>
      </span>
    </td>
    <td class="column11 style145 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price6_total); ?>">
        <?php echo number_format($s4_price6_total); ?>
      </span>
    </td>
    <td class="column12 style143 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price7_total); ?>">
        <?php echo number_format($s4_price7_total); ?>
      </span>
    </td>
    <td class="column13 style146 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price8_total); ?>">
        <?php echo number_format($s4_price8_total); ?>
      </span>
    </td>
    <td class="column14 style147 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price9_total); ?>">
        <?php echo number_format($s4_price9_total); ?>
      </span>
    </td>
    <td class="column15 style143 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price10_total); ?>">
        <?php echo number_format($s4_price10_total); ?>
      </span>
    </td>
    <td class="column16 style143 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price11_total); ?>">
        <?php echo number_format($s4_price11_total); ?>
      </span>
    </td>
    <td class="column17 style143 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price12_total); ?>">
        <?php echo number_format($s4_price12_total); ?>
      </span>
    </td>
    <td class="column18 style143 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price13_total); ?>">
        <?php echo number_format($s4_price13_total); ?>
      </span>
    </td>
    <td class="column19 style148 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price14_total); ?>">
        <?php echo number_format($s4_price14_total); ?>
      </span>
    </td>
    <td class="column20 style145 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price15_total); ?>">
        <?php echo number_format($s4_price15_total); ?>
      </span>
    </td>
    <td class="column21 style143 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price16_total); ?>">
        <?php echo number_format($s4_price16_total); ?>
      </span>
    </td>
    <td class="column22 style144 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price17_total); ?>">
        <?php echo number_format($s4_price17_total); ?>
      </span>
    </td>
    <td class="column23 style141 f">
      <span class="hover-enlarge" data-value="<?php echo number_format($s4_price18_total); ?>">
        <?php echo number_format($s4_price18_total); ?>
      </span>
    </td>
    <td class="column24 style149 null"></td>
    <td class="column25 style150 null"></td>
    <td class="column26 style150 null"></td>
    <td class="column26 style150 null"></td>
    <td class="column27 style151 null"></td>
</tr>


        

        <!-- ==================================
             기타경비 (mode5)
        ================================== -->
        <tbody id="s5_add_line">
			<?php if($mode5 == '') {?>
          <tr class="row82">
            <td class="column0 style152 s style160" rowspan="1" id="s5_add_tit">기<br><br>타<br><br>경<br><br>비<br><i class="fa fa-plus-square" aria-hidden="true" id="s5_add_row"></i></td>
            <td class="column1 style37 null style38" colspan="2">
			<input type="hidden" name="ne_type[]" value="5">
			<input type="text" name="s5_name[]" class="input"></td>
            <td class="column3 style39 null"><input type="text" name="s5_gongjong[]" class="gongjong input"></td>
            <td class="column4 style40 null"><input type="text" name="s5_sdate[]" class="sdate input"></td>
            <td class="column5 style41 null"><input type="text" name="s5_edate[]" class="edate input"></td>
            <td class="column6 style42 null"><input type="text" name="s5_price1[]" class="price1 num input text-right"></td>
            <td class="column7 style43 null"><input type="text" name="s5_price2[]" class=" input num text-right"></td>
            <td class="column8 style44 null"><input type="text" name="s5_price3[]" class="price3 num input text-right"></td>
            <td class="column9 style45 null"><input type="text" name="s5_price4[]" class="price4 num input text-right"></td>
            <td class="column10 style46 null"><input type="text" name="s5_price5[]" class="price5 num input text-right"></td>
            <td class="column11 style47 null"><input type="text" name="s5_price6[]" class="price6 num input text-right"></td>
            <td class="column12 style45 null"><input type="text" name="s5_price7[]" class="price7 num input text-right"></td>
            <td class="column13 style48 null"><input type="text" name="s5_price8[]" class="price8 num input text-right"></td>
            <td class="column14 style49 null"><input type="text" name="s5_price9[]" class="price9 num input text-right"></td>
            <td class="column15 style50 null"><input type="text" name="s5_price10[]" class="price10 num input text-right"></td>
            <td class="column16 style45 null"><input type="text" name="s5_price11[]" readonly class="price11 num input text-right"></td>
            <td class="column17 style45 null"><input type="text" name="s5_price12[]" class="price8 num input text-right"></td>
            <td class="column18 style45 null"><input type="text" name="s5_price13[]" class="price8 num input text-right"></td>
            <td class="column19 style51 null"><input type="text" name="s5_price14[]" class="price8 num input text-right"></td>
            <td class="column20 style47 null"><input type="text" name="s5_price15[]" class="price8 num input text-right"></td>
            <td class="column21 style45 null"><input type="text" name="s5_price16[]" class="price8 num input text-right"></td>
            <td class="column22 style46 null"><input type="text" name="s5_price17[]" class="price8 num input text-right"></td>
            <td class="column23 style52 null"><input type="text" name="s5_price18[]" class="price18 num input text-right"></td>
            <td class="column24 style53 null"><input type="text" name="s5_bank[]" class="bank input "></td>
            <td class="column25 style54 null"><input type="text" name="s5_account[]" class="account input "></td>
            <td class="column26 style55 null"><input type="text" name="s5_accname[]" class="accname input "></td>
            <td class="column26 style55 null"><input type="text" name="s5_ceo[]" class="ceo input "></td>
            <td class="column27 style56 null"><input type="text" name="s5_etc[]" class="input "></td>
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
				 <td class="column0 style152 s style160" rowspan="<?php echo $cnt5?>" id="s5_add_tit">기<br><br>타<br><br>경<br><br>비<br><i class="fa fa-plus-square" aria-hidden="true" id="s5_add_row"></i></td>
				<?php }?>
				<td class="column1 style37 null style38" colspan="2">
				<input type="hidden" name="s5_seq[]" value="<?php echo $row['seq']?>">
				<span class="glyphicon glyphicon-trash delete-icon" onclick="delete_row(<?php echo $row['seq']?>, '5', this)"></span>
				<input type="text" name="s5_name[]" value="<?php echo $row['ne_name']?>" class="name1 input"  <?php echo $bonsa?>  style="width:80%"></td>
				<td class="column3 style39 null"><input type="text" name="s5_gongjong[]" class="gongjong input"  value="<?php echo $row['ne_gongjong']?>"></td>
				<td class="column4 style40 null"><input type="text" name="s5_sdate[]" class="sdate input"  value="<?php echo $row['ne_sdate']?>"></td>
				<td class="column5 style41 null"><input type="text" name="s5_edate[]" class="edate input"  value="<?php echo $row['ne_edate']?>"></td>
				<td class="column6 style42 null"><input type="text" name="s5_price1[]" class="price1 num input text-right"  value="<?php echo $row['ne_price1']?>"></td>
				<td class="column7 style43 null"><input type="text" name="s5_price2[]" class=" input num text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column8 style44 null"><input type="text" name="s5_price3[]" class="price3 num input text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column9 style45 null"><input type="text" name="s5_price4[]" class="price4 num input text-right" value="<?php echo $row['ne_price16']?>"></td>
				<td class="column10 style46 null"><input type="text" name="s5_price5[]" class="price5 num input text-right" value="<?php echo $row['ne_price17']?>"></td>
				<td class="column11 style47 null"><input type="text" name="s5_price6[]" class="price6 num input text-right" value="<?php echo $price6?>"></td>
				<td class="column12 style45 null"><input type="text" name="s5_price7[]" class="price7 num input text-right" value="<?php echo $price7?>"></td>
				<td class="column13 style48 null"><input type="text" name="s5_price8[]" class="price8 num input text-right" value="<?php echo $price8?>"></td>
				<td class="column14 style49 null"><input type="text" name="s5_price9[]" class="price8 num input text-right" value="<?php echo $row['ne_price9']?>"></td>
				<td class="column15 style50 null"><input type="text" name="s5_price10[]" class="price8 num input text-right" value="<?php echo $row['ne_price10']?>"></td>
				<td class="column16 style45 null"><input type="text" name="s5_price11[]" readonly class="price8 num input text-right" value="<?php echo $row['ne_price11']?>"></td>
				<td class="column17 style45 null"><input type="text" name="s5_price12[]" class="price8 num input text-right" value="<?php echo $row['ne_price12']?>"></td>
				<td class="column18 style45 null"><input type="text" name="s5_price13[]" class="price8 num input text-right" value="<?php echo $row['ne_price13']?>"></td>
				<td class="column19 style51 null"><input type="text" name="s5_price14[]" class="price8 num input text-right" value="<?php echo $row['ne_price14']?>"></td>
				<td class="column20 style47 null"><input type="text" name="s5_price15[]" class="price8 num input text-right" value="<?php echo $row['ne_price15']?>"></td>
				<td class="column21 style45 null"><input type="text" name="s5_price16[]" class="price8 num input text-right" value="<?php echo $row['ne_price16']?>"></td>
				<td class="column22 style46 null"><input type="text" name="s5_price17[]" class="price8 num input text-right" value="<?php echo $row['ne_price17']?>"></td>
				<td class="column23 style52 null"><input type="text" name="s5_price18[]" class="price18 num input text-right" value="<?php echo $row['ne_price18']?>"></td>
				<td class="column24 style53 null"><input type="text" name="s5_bank[]" class="bank input " value="<?php echo $row['ne_bank']?>"></td>
				<td class="column25 style54 null"><input type="text" name="s5_account[]" class="account input " value="<?php echo $row['ne_account']?>"></td>
				<td class="column26 style55 null"><input type="text" name="s5_accname[]" class="accname input " value="<?php echo $row['ne_accname']?>"></td>
				<td class="column26 style55 null"><input type="text" name="s5_ceo[]" class="ceo input " value="<?php echo $row['ne_ceo']?>"></td>
				<td class="column27 style56 null"><input type="text" name="s5_etc[]" class="input " value="<?php echo $row['ne_etc']?>"></td>
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
        
         <tr class="row101 subtotal">
            <td class="column1 style161 s style163" colspan="3">소&nbsp;&nbsp;계</td>
            <td class="column4 style164 null"></td>
            <td class="column5 style165 null"></td>
            <td class="column6 style166 f"></td>
            <td class="column6 style166 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price1_total); ?>">
                <?php echo number_format($s5_price1_total); ?>
              </span>
            </td>
            <td class="column7 style166 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price2_total); ?>">
                <?php echo number_format($s5_price2_total); ?>
              </span>
            </td>
            <td class="column8 style167 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price3_total); ?>">
                <?php echo number_format($s5_price3_total); ?>
              </span>
            </td>
            <td class="column9 style168 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price4_total); ?>">
                <?php echo number_format($s5_price4_total); ?>
              </span>
            </td>
            <td class="column10 style169 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price5_total); ?>">
                <?php echo number_format($s5_price5_total); ?>
              </span>
            </td>
            <td class="column11 style170 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price6_total); ?>">
                <?php echo number_format($s5_price6_total); ?>
              </span>
            </td>
            <td class="column12 style168 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price7_total); ?>">
                <?php echo number_format($s5_price7_total); ?>
              </span>
            </td>
            <td class="column13 style171 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price8_total); ?>">
                <?php echo number_format($s5_price8_total); ?>
              </span>
            </td>
            <td class="column14 style172 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price9_total); ?>">
                <?php echo number_format($s5_price9_total); ?>
              </span>
            </td>
            <td class="column15 style168 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price10_total); ?>">
                <?php echo number_format($s5_price10_total); ?>
              </span>
            </td>
            <td class="column16 style168 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price11_total); ?>">
                <?php echo number_format($s5_price11_total); ?>
              </span>
            </td>
            <td class="column17 style168 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price12_total); ?>">
                <?php echo number_format($s5_price12_total); ?>
              </span>
            </td>
            <td class="column18 style168 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price13_total); ?>">
                <?php echo number_format($s5_price13_total); ?>
              </span>
            </td>
            <td class="column19 style173 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price14_total); ?>">
                <?php echo number_format($s5_price14_total); ?>
              </span>
            </td>
            <td class="column20 style170 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price15_total); ?>">
                <?php echo number_format($s5_price15_total); ?>
              </span>
            </td>
            <td class="column21 style168 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price16_total); ?>">
                <?php echo number_format($s5_price16_total); ?>
              </span>
            </td>
            <td class="column22 style169 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price17_total); ?>">
                <?php echo number_format($s5_price17_total); ?>
              </span>
            </td>
            <td class="column23 style166 f">
              <span class="hover-enlarge" data-value="<?php echo number_format($s5_price18_total); ?>">
                <?php echo number_format($s5_price18_total); ?>
              </span>
            </td>
            <td class="column24 style174 null"></td>
            <td class="column25 style175 null"></td>
            <td class="column26 style175 null"></td>
            <td class="column26 style175 null"></td>
            <td class="column27 style176 null"></td>
          </tr>
        

    </table>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-success" onclick="onExcel()">
      <span class="glyphicon fa fa-file-excel-o"></span> 엑셀출력
    </button>
    <button type="button" class="btn btn-secondary" onclick="onPrint3()" data-dismiss="modal">
      인쇄
    </button>
    <button type="submit" class="btn btn-primary">업데이트</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">목록</button>
  </div>
</form>


<!-- 
  선택된 셀 내용 표시용 팝업영역
  (스크립트에서 position: absolute;로 위치를 조정하기 위해 style은 최소화)
-->
<div id="cell-display-menu2" style="position:absolute; display:none;"></div>

<script>
// window.onload 시점에 폰트 축소/줄바꿈 로직을 적용
window.addEventListener('load', function() {
  // 1) 업체명/공종/비고 등 자동 축소 대상
  const shrinkTargets = document.querySelectorAll(
    '.name1, .gongjong, .column4 .input, .column5 .input, .column27 .input'
  );
  shrinkTargets.forEach(el => {
    shrinkTextToFit(el);
  });
  
  // 2) 소계(subtotal) 행의 모든 셀
  const subtotalCells = document.querySelectorAll('tr.subtotal td');
  subtotalCells.forEach(el => {
    shrinkTextToFit(el);
  });
});

/**
 * 셀의 내용이 셀 너비보다 길면 폰트를 줄여 맞추고,
 * 폰트를 8px까지 줄여도 안 들어가면 white-space를 normal로 설정
 */
function shrinkTextToFit(el) {
  const computedStyle = window.getComputedStyle(el);
  const originalWhiteSpace = computedStyle.whiteSpace || 'normal';
  el.style.whiteSpace = 'nowrap';
  
  let fontSize = parseFloat(computedStyle.fontSize);
  while (el.scrollWidth > el.clientWidth && fontSize > 8) {
    fontSize--;
    el.style.fontSize = fontSize + 'px';
  }
  
  if (fontSize <= 8 && el.scrollWidth > el.clientWidth) {
    el.style.whiteSpace = 'normal';
    el.style.wordWrap = 'break-word';
    el.style.textOverflow = 'clip';
  } else {
    el.style.whiteSpace = originalWhiteSpace;
  }
}


function removeComma() {
  // 제출 전, 숫자 콤마 제거
  return true;
}


function onExcel() {
  // 엑셀 출력 기능 구현
}

function onPrint3() {
  window.print();
}



/* 
  ---------------------------------
    1) 각 <input>에 방향키 이벤트
    2) 선택된 행 강조
    3) 선택된 셀 내용 팝업
  -----------------------------------
*/
document.addEventListener('DOMContentLoaded', () => {
  const table = document.getElementById('data-table-menu2');
  const displayArea = document.getElementById('cell-display-menu2');
  if (!table || !displayArea) {
    console.error("테이블(#data-table-menu2) 또는 팝업(#cell-display-menu2) 요소가 없음");
    return;
  }

  // (A) tbody 안의 모든 행
  const rows = table.querySelectorAll('tbody tr');
  if (!rows.length) return;

  // (B) 2차원 배열: inputs2D[rowIndex][colIndex] = <input> DOM
  let inputs2D = [];

  // 각 행별로, "등장 순서대로" <input> 태그를 모은다
  rows.forEach((row, rIndex) => {
    // 이 행에서 DOM 순서로 <input>을 모두 수집
    const inputsInRow = row.querySelectorAll('input');
    let rowInputs = [];
    inputsInRow.forEach(inp => rowInputs.push(inp));

    inputs2D.push(rowInputs);
  });

  // 이제 inputs2D[rowIndex][colIndex] 접근 가능

  // (C) 각 <input>에 대해 focus 시 팝업+강조, 방향키 이동
  inputs2D.forEach((rowArr, rIndex) => {
    rowArr.forEach((inp, cIndex) => {

      // 데이터셋에 현재 행/열 인덱스 저장
      inp.dataset.rIndex = rIndex;
      inp.dataset.cIndex = cIndex;

      // Focus 시 팝업+강조
      inp.addEventListener('focus', (e) => {
        // 모든 tr/td 강조 해제
        table.querySelectorAll('tr').forEach(tr => tr.classList.remove('selected-row-bg'));
        table.querySelectorAll('td').forEach(td => td.classList.remove('selected-cell'));

        // 이 <input>이 들어있는 tr, td 찾아서 강조
        const td = inp.closest('td');
        const tr = inp.closest('tr');
        if (td) td.classList.add('selected-cell');
        if (tr) tr.classList.add('selected-row-bg');

        // 팝업 표시
        let text = inp.value.trim() || "(빈 셀)";
        displayArea.textContent = text;
        displayArea.style.display = 'block';

        // 위치를 input의 바로 위/아래로 잡는다
        positionPopupAbove(inp, displayArea);
      });

      // Blur 시 팝업을 숨기고 싶으면 아래 주석 해제
      /*
      inp.addEventListener('blur', (e) => {
        // 혹시 다른 <input>에 곧바로 focus가 이동할 수 있으니 약간 지연
        setTimeout(() => {
          // document.activeElement가 popup이나 테이블 내부라면 냅둠
          if (!displayArea.contains(document.activeElement)
           && !table.contains(document.activeElement)) {
            displayArea.style.display = 'none';
          }
        }, 150);
      });
      */

      // 방향키 이동
      inp.addEventListener('keydown', (e) => {
        const key = e.key;
        if (['ArrowLeft','ArrowRight','ArrowUp','ArrowDown'].includes(key)) {
          e.preventDefault();
          let rr = parseInt(inp.dataset.rIndex,10);
          let cc = parseInt(inp.dataset.cIndex,10);

          if (key === 'ArrowLeft')  cc--;
          if (key === 'ArrowRight') cc++;
          if (key === 'ArrowUp')    rr--;
          if (key === 'ArrowDown')  rr++;

          // 범위 체크
          if (rr>=0 && rr<inputs2D.length) {
            if (cc>=0 && cc<inputs2D[rr].length) {
              const nextInput = inputs2D[rr][cc];
              if (nextInput) {
                nextInput.focus();
              }
            }
          }
        }
      });
    });
  });

  // 테이블 밖 클릭 시 팝업 숨기기
  document.addEventListener('click', (e) => {
    if (!table.contains(e.target) && !displayArea.contains(e.target)) {
      displayArea.style.display = 'none';
      table.querySelectorAll('tr.selected-row-bg').forEach(tr => tr.classList.remove('selected-row-bg'));
      table.querySelectorAll('td.selected-cell').forEach(td => td.classList.remove('selected-cell'));
    }
  });

}); // DOMContentLoaded 끝

/**
 * 팝업을 input 요소 위(또는 아래)에 위치
 */
function positionPopupAbove(input, popup) {
  const rect = input.getBoundingClientRect();

  const scrollX = window.scrollX || document.documentElement.scrollLeft;
  const scrollY = window.scrollY || document.documentElement.scrollTop;

  // input의 문서상 절대 좌표
  const offsetLeft = rect.left + scrollX;
  const offsetTop  = rect.top  + scrollY;

  // 팝업 보이게 한 뒤 크기 측정
  popup.style.display = 'block';
  const popupW = popup.offsetWidth;
  const popupH = popup.offsetHeight;
  const inputH = rect.height;

  // 기본은 위에 배치
  let topPos  = offsetTop - popupH - 170;
  let leftPos = offsetLeft -260;

  // 위가 모자라면 아래
  if (topPos < 0) {
    topPos = offsetTop + inputH + 5;
  }

  // 오른쪽 경계
  const vw = window.innerWidth;
  if (leftPos + popupW > vw - 5) {
    leftPos = vw - popupW - 5;
  }

  popup.style.left = leftPos + 'px';
  popup.style.top  = topPos  + 'px';
}


// 공통 함수
function comma(str) {
    str = String(str);
    return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}

function uncomma(str) {
    str = String(str);
    return str.replace(/[^\d]+/g, '');
}

function removeComma() {
    $('.num').each(function() {
        $(this).val(uncomma($(this).val()));
    });
}

function delete_row(seq, type, el) {
  if (!confirm('이 항목을 삭제하시겠습니까?')) return;
  // 실제 삭제 처리 로직
  // document.querySelector('.dataRow_' + seq).remove();
}

function deleteRow(button) {
  var row = button.closest('tr');
  var inputs = row.querySelectorAll('input[type="text"]');
  var isEmpty = true;
  inputs.forEach(function(input) {
    if (input.value.trim() !== '') {
      isEmpty = false;
    }
  });
  if (isEmpty || confirm("이 행에 내용이 있습니다. 삭제하시겠습니까?")) {
    row.remove();
  }
}

</script>
