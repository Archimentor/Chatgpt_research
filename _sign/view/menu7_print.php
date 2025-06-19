<?php
/***************************************************
 * [menu7_print.php]
 *  - 근태사유서 단건 인쇄용
 ***************************************************/
include_once('../../_common.php');
define('menu_sign', true);

$seq = isset($_GET['seq']) ? trim($_GET['seq']) : '';
if(!$seq) alert_close('잘못된 접근입니다.');

// DB 조회
$row = sql_fetch("SELECT * FROM {$none['sign_draft7']} WHERE seq='$seq'");
if(!$row) alert('존재하지 않는 문서입니다.');

$mb = get_member($row['mb_id']);

?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>근태사유서 - 인쇄</title>
<style>
@page {
  size: A4 portrait;
  margin: 10mm;
}
@media print {
  .print-btn { display: none !important; }
  body { margin:0; padding:0; }
}
table {
  width:100%;
  border-collapse: collapse;
}
th, td {
  border:1px solid #ccc;
  padding:6px;
  vertical-align:middle;
}
.th-title { background:#f2f2f2; width:120px; text-align:right; }
</style>
</head>
<body>

<div style="max-width:800px; margin:0 auto;">
  <!-- 인쇄버튼 (화면에서만 보이기) -->
  <div class="print-btn" style="margin-bottom:10px; text-align:right;">
    <button type="button" onclick="window.print()">인쇄</button>
    <button type="button" onclick="window.close()">닫기</button>
  </div>

  <h2 style="text-align:center; margin:20px 0;">근태사유서</h2>

  <table>
    <tr>
      <th class="th-title">문서번호</th>
      <td><?php echo $row['ns_docnum'];?></td>
      <th class="th-title">기안일</th>
      <td><?php echo substr($row['ns_date'],0,10);?></td>
    </tr>
    <tr>
      <th class="th-title">기안자</th>
      <td><?php echo $mb['mb_name'];?></td>
      <th class="th-title">보존기간</th>
      <td>5년</td>
    </tr>
    <tr>
      <th class="th-title">중요도</th>
      <td><?php echo $row['ns_importance'];?></td>
      <th class="th-title">참조자</th>
      <td><?php echo get_mb_name($row['ns_cc']);?></td>
    </tr>
    <tr>
      <th class="th-title">제목</th>
      <td colspan="3"><?php echo $row['ns_subject'];?></td>
    </tr>
    <tr>
      <th class="th-title">사유</th>
      <td colspan="3"><?php echo $row['ns_reason'];?></td>
    </tr>
    <tr>
      <th class="th-title">기간</th>
      <td colspan="3">
        <?php echo $row['ns_startdate'].' ~ '.$row['ns_enddate'];?>
      </td>
    </tr>
    <tr>
      <th class="th-title">소요시간</th>
      <td><?php echo $row['ns_hours'];?> 시간</td>
      <th class="th-title">소요일</th>
      <td><?php echo $row['ns_days'];?> 일</td>
    </tr>
    <tr>
      <th class="th-title">상세사유</th>
      <td colspan="3" style="height:200px; vertical-align:top;">
        <?php echo get_view_thumbnail($row['ns_content']);?>
      </td>
    </tr>
  </table>
</div>

<script>
window.onafterprint = function() {
  window.close();
}
</script>
</body>
</html>
