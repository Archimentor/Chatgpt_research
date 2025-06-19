<?php
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php');

// --- 데이터 조회 ---
if (!isset($seq) || !$seq) {
    // $seq = $_GET['seq'] ?? null; // GET 방식으로 seq 값을 받는 경우 예시 (null 병합 연산자 사용)
    if (!isset($seq) || !$seq) { alert('잘못된 접근입니다. (seq 누락)'); exit; }
}
$row = sql_fetch("select * from {$none['smart_list']} where seq = '$seq'");
if(!$row) { alert('데이터가 삭제되었거나 이동되었습니다.'); exit; }
$work_id = $row['work_id'];
$date    = $row['ns_date'];
$work = sql_fetch("select * from {$none['worksite']} where nw_code = '$work_id'");
if(!$work) { alert('현장 정보를 찾을 수 없습니다.'); exit; }

// --- 관련 데이터 미리 조회 ---
$signline_seq = 6;
$signline = sql_fetch("SELECT * FROM {$none['sign_line']} WHERE seq = '{$signline_seq}'");
$gongjongSql = "SELECT * FROM {$none['smart_gongjong']} WHERE ns_id = '{$row['seq']}' ORDER BY seq ASC";
$gongjongRst = sql_query($gongjongSql);
$jajaeSql = "SELECT * FROM {$none['smart_jajae']} WHERE ns_id = '{$row['seq']}' ORDER BY seq ASC";
$jajaeRst = sql_query($jajaeSql);
$machineSql = "SELECT * FROM {$none['smart_machine']} WHERE ns_id = '{$row['seq']}' ORDER BY seq ASC";
$machineRst = sql_query($machineSql);
$yoil = function_exists('get_yoil') ? get_yoil($date) : '';
// 기안자(담당자) 이름 설정
$drafter_name_raw = isset($mb['mb_name']) ? htmlspecialchars($mb['mb_name']) : '담당자 정보 없음';

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>[<?php echo htmlspecialchars($work['nw_code'] ?? ''); ?>] <?php echo htmlspecialchars($work['nw_subject'] ?? ''); ?> - 공사일보</title>
<style>
/* ===== 기본 스타일 + 개선된 스타일 병합 ===== */
body { font-family: 'Malgun Gothic', Dotum, sans-serif; }
.print_wrap { max-width: 1000px; margin: 20px auto; font-family: 'Malgun Gothic', Dotum, sans-serif; color: #333; }
.print_frm { width: 100%; }

/* 테이블 기본 */
.table_wrap { width: 100%; border-collapse: collapse; border: 1px solid #ccc; table-layout: fixed; margin: 0; padding: 0; font-size: 9pt; }
.table_wrap th, .table_wrap td { border: 1px solid #ccc; padding: 4px 5px; vertical-align: middle; text-align: center; word-wrap: break-word; line-height: 1.4; }
.table_wrap th { background-color: #f2f2f2; font-weight: bold; }

/* 상단 제목 */
.main_title { font-size: 18pt; font-weight: bold; letter-spacing: 5px; padding: 10px 0; margin: 0; text-align: center; }

/* 결재 라인 테이블 */
.sign_table { width: 100%; border-collapse: collapse; table-layout: fixed; border: none; }
.sign_table thead th { background: #f2f2f2; text-align: center; font-weight: bold; font-size: 9pt; padding: 3px; line-height: 1.3; border: 1px solid #888; }
.sign_table thead th small { font-size: 8pt; font-weight: normal; color: #333; }
.sign_table tbody td { text-align: center; vertical-align: middle; height: 60px; padding: 0; border: 1px solid #888; }
.sign_table input[type="hidden"] { display: none; }

/* 작업현황 리스트 (높이 조절) */
.history_list { list-style: none; margin: 0; padding: 4px 5px; text-align: left; } /* 패딩 약간 조정 */
.history_list li {
    padding: 1px 0; /* 상하 패딩 줄임 */
    line-height: 1.3; /* 줄 간격 약간 줄임 */
}
.history_cell { vertical-align: top !important; padding: 0 !important; }

/* 인원투입 테이블 (높이 조절) */
.people_table { width: 100%; border-collapse: collapse; border: none; }
.people_table thead th { background-color: #f9f9f9; font-weight: bold; padding: 3px 4px; border: 1px solid #ccc; font-size: 8.5pt; text-align: center; } /* 패딩 약간 줄임 */
.people_table td { border: 1px solid #ccc; padding: 2px 4px; font-size: 9pt; } /* 패딩 약간 줄임 */
.people_table td:first-child { text-align: left; padding-left: 5px; }
.people_table tr:last-child td { font-weight: bold; background-color: #f9f9f9; }

/* 자재/장비 테이블 (높이 조절) */
.material_machine_cell { width: 60%; vertical-align: top !important; padding: 0 !important; border-right: 1px solid #ccc; }
.machine_cell { width: 40%; vertical-align: top !important; padding: 0 !important; }
.sub_table { width: 100%; border-collapse: collapse; border: none; }
.sub_table th, .sub_table td { border-bottom: 1px solid #eee; border-right: 1px solid #eee; padding: 2px 4px; font-size: 9pt; } /* 패딩 약간 줄임 */
.sub_table th { background-color: #f9f9f9; font-size: 8.5pt; padding: 3px 4px; } /* 패딩 약간 줄임 */
.sub_table tr:last-child td { border-bottom: none; }
.sub_table td:last-child { border-right: none; }

/* 기본 정보 라벨/값 */
.info_label { background: #f9f9f9; font-weight: bold; text-align: center; padding-right: 0; }
.info_value { text-align: left; padding-left: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* 섹션 제목 */
.section_title_left { text-align: left !important; padding-left: 10px !important; font-weight: bold; background-color: #e0eef9; }

/* 특기사항 (높이 조절) */
.special_notes_cell { text-align: left; vertical-align: top; padding: 5px 8px !important; } /* 패딩 약간 줄임 */

/* 화면 버튼 */
.view_controls { margin-top: 20px; text-align: right; }
.view_controls button, .view_controls a { padding: 8px 15px; margin-left: 10px; font-size: 14px; cursor: pointer; text-decoration: none; border: 1px solid #aaa; border-radius: 4px; }
.view_controls button { background-color: #007bff; color: white; border-color: #007bff; }
.view_controls a { background-color: #6c757d; color: white; border-color: #6c757d; }


/* ===== 인쇄 관련 CSS (원본 메커니즘 기반) ===== */
@page { size: A4 portrait; margin: 10mm; }
@media print {
    /* 1. 원본 숨김 규칙 + 추가 UI 요소 */
    .print_none, #header, #sidebar-nav, #left-sidebar, .sidebar, .main-nav, .page-header, .block-header, .breadcrumb, .view_controls, #footer, .main-footer, .go-top { display: none !important; }
    body { margin: 0 !important; padding: 0 !important; background: #fff !important; color: #000 !important; }

    /* 2. 원본 .print-div 스타일 (JS가 생성하는 임시 div 용) - 원본 유지 */
    .print-div { word-wrap: break-word; white-space: normal; }
    .print-div table { font-size: 12px !important; width: 100% !important; border-collapse: collapse; }
    .print-div table td { padding: 4px !important; border: 1px solid #ccc !important; vertical-align: middle; text-align: center; }
    .print-div table tr { height: 20px; }
    .print-div table th { padding: 4px !important; border: 1px solid #ccc !important; vertical-align: middle; text-align: center; background-color: #f2f2f2; font-weight: bold; }

    /* 3. 개선된 인쇄 스타일 일부 적용 (원본 스타일과 충돌 주의) */
    .print-div .table_wrap { border: 1px solid #000 !important; }
    .print-div .table_wrap th, .print-div .table_wrap td { border: 1px solid #555 !important; }
    .print-div .main_title { font-size: 16pt !important; }
    .print-div .info_value { white-space: normal !important; }
    .print-div tr, .print-div li { page-break-inside: avoid; }
    .print-div .people_table thead th { font-size: 11px !important; padding: 3px 4px !important; } /* 높이 조절 반영 */
    .print-div .people_table td { padding: 2px 4px !important; } /* 높이 조절 반영 */
    .print-div .sub_table th { font-size: 11px !important; padding: 3px 4px !important; } /* 높이 조절 반영 */
    .print-div .sub_table td { padding: 2px 4px !important; } /* 높이 조절 반영 */
    .print-div .history_list li { padding: 1px 0 !important; line-height: 1.3 !important; } /* 높이 조절 반영 */
    .print-div .special_notes_cell { padding: 5px 8px !important; } /* 높이 조절 반영 */
}
/* ===== 인쇄 관련 CSS 끝 ===== */
</style>
</head>
<body>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header print_none">
           <div class="row"> <div class="col-lg-5 col-md-8 col-sm-12"> <h2> <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"> <i class="fa fa-arrow-left"></i> </a> 공사일보 상세보기 </h2> <ul class="breadcrumb"> <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li> <li class="breadcrumb-item">현장 관리</li> <li class="breadcrumb-item active">공사일보</li> </ul> </div> </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="print_wrap">
                             <div class="print_frm" id="printableArea">
                                <table class="table_wrap">
                                    <colgroup span="20"></colgroup>
                                    <tr>
                                        <td colspan="13" rowspan="2" style="border: none; vertical-align: middle;"><h1 class="main_title">공&nbsp;사&nbsp;일&nbsp;보</h1></td>
                                        <td colspan="7" style="height: 25px; font-weight: bold; border-bottom: 1px solid #000;">결&nbsp;&nbsp;&nbsp;&nbsp;재</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="padding: 0; border-left: 1px solid #000;">
                                            <table class="sign_table">
                                                <thead>
                                                    <tr>
                                                        <th>담당자</th>
                                                        <?php if ($signline) { for($i=1; $i<=5; $i++) { if(empty($signline['ns_id'.$i])) continue; $ns_member_info = function_exists('get_member') ? get_member($signline['ns_id'.$i], 'mb_name, mb_3') : ['mb_name' => '결재자'.$i, 'mb_3' => '']; $signer_name = isset($ns_member_info['mb_name']) ? htmlspecialchars($ns_member_info['mb_name']) : ''; $signer_position = (function_exists('get_mposition_txt') && isset($ns_member_info['mb_3'])) ? htmlspecialchars(get_mposition_txt($ns_member_info['mb_3'])) : ''; ?>
                                                        <th><?php echo $signer_name . ($signer_position ? '<br><small>' . $signer_position . '</small>' : ''); ?></th>
                                                        <?php } } else { echo "<th colspan='5'>결재 정보 없음</th>"; } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <?php // 1. 담당자 정보 없을 시 공백 처리
                                                            echo ($drafter_name_raw === '담당자 정보 없음') ? '&nbsp;' : $drafter_name_raw;
                                                            ?>
                                                        </td>
                                                        <?php if ($signline) { for($i=1; $i<=5; $i++) { if(empty($signline['ns_id'.$i])) continue; ?>
                                                        <td><input type="hidden" name="ns_id<?php echo $i?>" value="<?php echo $signline['ns_id'.$i]?>"></td>
                                                        <?php } } else { echo "<td colspan='5'></td>"; } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="info_label" colspan="2">현 장 명</td><td class="info_value" colspan="7"><?php echo htmlspecialchars($work['nw_subject'] ?? '현장명 없음'); ?></td><td class="info_label" colspan="2">공 정 률</td><td class="info_value" colspan="3"><?php echo number_format((float)($row['ns_persent'] ?? 0), 1); ?> %</td><td class="info_label" colspan="2">작 성 자</td><td class="info_value" colspan="4"><?php echo function_exists('get_manager_txt') ? get_manager_txt($work['nw_ptype1_1'] ?? '') : htmlspecialchars($work['nw_ptype1_1'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                         <td class="info_label" colspan="2">일 자</td><td class="info_value" colspan="7"><?php echo date('Y년 m월 d일', strtotime($date)) . ' (' . $yoil . '요일)'; ?></td><td class="info_label" colspan="2">날 씨</td><td class="info_value" colspan="9"><?php echo htmlspecialchars($row['ns_wather'] ?? ''); ?></td>
                                    </tr>

                                    <tr>
                                        <th colspan="14" class="section_title_left">⊙ 작업현황</th>
                                        <th colspan="6" class="section_title_left">⊙ 인원투입현황</th>
                                    </tr>
                                    <tr>
                                        <th colspan="7">금일 실시 현황</th>
                                        <th colspan="7">명일 주요 작업 내용</th>
                                        <th colspan="6">&nbsp;</th> </tr>
                                    <tr>
                                        <td colspan="7" class="history_cell">
                                            <ul class="history_list">
                                                <?php $today_his_notes = trim($row['ns_today_his'] ?? ''); echo $today_his_notes ? nl2br(htmlspecialchars($today_his_notes)) : '&nbsp;'; ?>
                                            </ul>
                                        </td>
                                        <td colspan="7" class="history_cell">
                                            <ul class="history_list">
                                                <?php $tomorrow_his_notes = trim($row['ns_tomorrow_his'] ?? ''); echo $tomorrow_his_notes ? nl2br(htmlspecialchars($tomorrow_his_notes)) : '&nbsp;'; ?>
                                            </ul>
                                        </td>
                                        <td colspan="6" style="vertical-align: top; padding: 0;">
                                            <table class="people_table">
                                                 <colgroup><col style="width: 40%;"><col style="width: 20%;"><col style="width: 20%;"><col style="width: 20%;"></colgroup>
                                                 <thead><tr><th>공종</th><th>전일</th><th>금일</th><th>누계</th></tr></thead>
                                                 <tbody>
                                                    <?php $ycnt_sum = 0; $tcnt_sum = 0; $stotal_sum = 0; $gongjong_count = 0; sql_data_seek($gongjongRst, 0); while ($gongjong = sql_fetch_array($gongjongRst)) { $ycnt = (int)$gongjong['ns_ycnt']; $tcnt = (int)$gongjong['ns_tcnt']; $stotal = (int)$gongjong['ns_stotal']; $ycnt_sum += $ycnt; $tcnt_sum += $tcnt; $stotal_sum += $stotal; $gongjong_count++; ?>
                                                    <tr> <td><?php echo htmlspecialchars($gongjong['ns_name']); ?></td> <td style="text-align:right;"><?php echo number_format($ycnt); ?></td> <td style="text-align:right;"><?php echo number_format($tcnt); ?></td> <td style="text-align:right;"><?php echo number_format($stotal); ?></td> </tr>
                                                    <?php } ?>
                                                    <?php if ($gongjong_count == 0): ?> <tr><td colspan="4" style="text-align: center; height: 40px;">내역 없음</td></tr> <?php endif; ?>
                                                    <tr> <td><strong>합 계</strong></td> <td style="text-align:right;"><strong><?php echo number_format($ycnt_sum); ?></strong></td> <td style="text-align:right;"><strong><?php echo number_format($tcnt_sum); ?></strong></td> <td style="text-align:right;"><strong><?php echo number_format($stotal_sum); ?></strong></td> </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                         <th colspan="10" class="section_title_left">⊙ 자재 반입 현황</th>
                                         <th colspan="10" class="section_title_left">⊙ 장비 사용 현황</th>
                                    </tr>
                                    <tr>
                                        <td colspan="10" class="material_machine_cell">
                                            <table class="sub_table">
                                                 <thead> <tr> <th style="width:25%;">품명</th><th style="width:20%;">규격</th><th style="width:10%;">단위</th> <th style="width:10%;">전일</th><th style="width:10%;">금일</th><th style="width:10%;">누계</th> <th style="width:15%;">비고</th> </tr> </thead>
                                                 <tbody> <?php $jajae_count = 0; sql_data_seek($jajaeRst, 0); while ($jajae = sql_fetch_array($jajaeRst)) { $jajae_count++; ?> <tr> <td style="text-align:left;"><?php echo htmlspecialchars($jajae['ns_name']); ?></td> <td style="text-align:left;"><?php echo htmlspecialchars($jajae['ns_option']); ?></td> <td><?php echo htmlspecialchars($jajae['ns_dan']); ?></td> <td style="text-align:right;"><?php echo number_format((int)$jajae['ns_ycnt']); ?></td> <td style="text-align:right;"><?php echo number_format((int)$jajae['ns_tcnt']); ?></td> <td style="text-align:right;"><?php echo number_format((int)$jajae['ns_stotal']); ?></td> <td style="text-align:left;"><?php echo htmlspecialchars($jajae['ns_etc']); ?></td> </tr> <?php } ?> <?php if ($jajae_count == 0): ?> <tr><td colspan="7" style="text-align: center; height: 40px; border: none; color: #aaa;">&nbsp;</td></tr> <?php endif; ?> </tbody>
                                            </table>
                                        </td>
                                        <td colspan="10" class="machine_cell">
                                            <table class="sub_table">
                                                 <thead> <tr> <th style="width:30%;">장비명</th><th style="width:25%;">규격</th> <th style="width:15%;">전일</th><th style="width:15%;">금일</th><th style="width:15%;">누계</th> </tr> </thead>
                                                 <tbody> <?php $machine_count = 0; sql_data_seek($machineRst, 0); while ($machine = sql_fetch_array($machineRst)) { $machine_count++; ?> <tr> <td style="text-align:left;"><?php echo htmlspecialchars($machine['ns_name']); ?></td> <td style="text-align:left;"><?php echo htmlspecialchars($machine['ns_option']); ?></td> <td style="text-align:right;"><?php echo number_format((float)$machine['ns_ycnt'], 1); ?></td> <td style="text-align:right;"><?php echo number_format((float)$machine['ns_tcnt'], 1); ?></td> <td style="text-align:right;"><?php echo number_format((float)$machine['ns_stotal'], 1); ?></td> </tr> <?php } ?> <?php if ($machine_count == 0): ?> <tr><td colspan="5" style="text-align: center; height: 40px;">내역 없음</td></tr> <?php endif; ?> </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                     <tr>
                                         <th colspan="20" class="section_title_left">⊙ 특기사항</th>
                                     </tr>
                                     <tr>
                                         <td colspan="20" class="special_notes_cell">
                                             <?php $special_notes = trim($row['ns_special'] ?? ''); echo $special_notes ? nl2br(htmlspecialchars($special_notes)) : '&nbsp;'; ?>
                                         </td>
                                     </tr>

                                </table>
                                </div><div class="m-t-30 align-right print_none view_controls" style="margin-top:20px; text-align:right;">
                                 <button type="button" class="btn btn-primary" style="margin-left:20px" onclick="onPrint()"> 인쇄 </button>
                                 <a href="../list/menu3_list.php" class="btn btn-outline-secondary"> 목록으로 </a>
                             </div>
                        </div></div></div></div></div></div></div><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// ★★★★★ 원본 JavaScript 함수 (수정 없음 - 원본 요청) ★★★★★
function onPrint() {
  const html = document.querySelector('html');
    // col 제거 시도 (jQuery 필요)
    try { $('.print_frm').find('col').remove(); } catch(e) {}

  const printContents = $('.print_frm').html(); // jQuery 사용

  if (!printContents) { // 내용 확인 추가
      alert("인쇄할 내용을 찾을 수 없습니다!");
      return;
  }

  const printDiv = document.createElement("DIV");
  printDiv.className = "print-div";

  html.appendChild(printDiv); // 원본 방식 (html에 추가)
  printDiv.innerHTML = printContents;
  document.body.style.display = 'none'; // 원본 방식
  window.print();
  document.body.style.display = 'block'; // 원본 방식
  printDiv.style.display = 'none'; // 원본 방식 (제거 대신 숨김)

  // 인쇄 후 잠시 후 printDiv 제거 시도 (선택적 개선)
  setTimeout(() => {
      if (printDiv.parentNode === html) {
         try { html.removeChild(printDiv); } catch(e) {}
      } else if (printDiv.parentNode === document.body) {
         // 이전 수정에서 body에 추가하는 것으로 변경했었으므로 이쪽도 확인
         try { document.body.removeChild(printDiv); } catch(e) {}
      }
  }, 500); // 0.5초 후 제거
}
</script>

<?php include_once(NONE_PATH.'/footer.php'); ?>
</body>
</html>