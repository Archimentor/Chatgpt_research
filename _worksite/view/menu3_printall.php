<?php
/********************************************************************
 * menu3_printall.php
 * - 특정 현장(work_id)에 대한 공사일보(스마트일보) '여러 일자'를
 * menu3_view.php 스타일로 "연속" 출력하는 페이지 (A4 최적화)
 *
 * 1) work_id를 GET으로 받는다 (?work_id=XXXX)
 * 2) DB에서 "해당 현장의 공사일보 전부"를 ns_date ASC로 조회
 * 3) while문으로 돌면서, menu3_view의 '인쇄용 레이아웃'을 반복
 * 4) 하루(한 건) 끝나면 page-break-after로 페이지 구분
 ********************************************************************/

// 경로 관련 설정 및 공통 파일 포함 (실제 환경에 맞게 경로 수정 필요)
include_once('../../_common.php'); // 기존 경로 유지

// --- 헤더 포함 전에 필요한 설정 ---
define('menu_worksite', true);

// --- 헤더 포함 ---
// include_once(NONE_PATH.'/header.php'); // 필요시 주석 해제 또는 수정

// 1) 파라미터 확인
if (!isset($_GET['work_id']) || !$_GET['work_id']) {
    alert('잘못된 접근입니다. (work_id 누락)');
    exit; // 오류 시 종료
}
$work_id = trim($_GET['work_id']);

// 2) 현장 정보 가져오기 (한 번만 조회)
$work_info = sql_fetch("SELECT * FROM {$none['worksite']} WHERE nw_code = '{$work_id}'");
if (!$work_info) {
    alert('존재하지 않는 현장입니다.');
    exit; // 오류 시 종료
}

// 3) 공사일보 목록 (해당 현장의 모든 일자)
$sql = "
    SELECT *
    FROM {$none['smart_list']}
    WHERE work_id = '{$work_id}'
    ORDER BY ns_date ASC
";
$result = sql_query($sql);
$total_count = sql_num_rows($result);

// 4) 고정된 결재라인 정보 가져오기 (seq=6 고정 가정)
$signline_seq = 6;
$signline = sql_fetch("SELECT * FROM {$none['sign_line']} WHERE seq = '{$signline_seq}'");

// 담당자(기안자) 이름 설정 (일괄 출력에서는 각 일보 작성자 대신 현장 정보의 담당자 사용 예시)
// 또는 $row['writer_field'] 등 각 일보 데이터에서 가져오도록 수정 필요
$drafter_name_raw = isset($work_info['nw_write']) ? htmlspecialchars($work_info['nw_write']) : '담당자 정보 없음';

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>[<?php echo htmlspecialchars($work_info['nw_code'] ?? ''); ?>] <?php echo htmlspecialchars($work_info['nw_subject'] ?? ''); ?> - 공사일보 일괄출력</title>

<style>
/* ===== 기본 스타일 (이전과 동일 + people_table thead 추가) ===== */
body { font-family: 'Malgun Gothic', Dotum, sans-serif; font-size: 10pt; color: #000; background-color: #fff; margin: 0; padding: 0; }
.print_area { width: 100%; margin: 0 auto; }
.table_wrap { width: 100%; border-collapse: collapse; border: 1px solid #000; table-layout: fixed; margin-bottom: 0; /* 페이지 나눔으로 대체 */ }
.table_wrap th, .table_wrap td { border: 1px solid #888; padding: 4px 5px; vertical-align: middle; text-align: center; word-wrap: break-word; line-height: 1.4; font-size: 9pt; }
.table_wrap th { background-color: #f2f2f2; font-weight: bold; }
.main_title { font-size: 18pt; font-weight: bold; letter-spacing: 5px; padding: 10px 0; margin: 0; text-align: center; }
.sign_table { width: 100%; border-collapse: collapse; table-layout: fixed; border: none; }
.sign_table thead th { background: #f2f2f2; text-align: center; font-weight: bold; font-size: 9pt; padding: 3px; line-height: 1.3; border: 1px solid #888; }
.sign_table thead th small { font-size: 8pt; font-weight: normal; color: #333; }
.sign_table tbody td { text-align: center; vertical-align: middle; height: 60px; padding: 0; border: 1px solid #888; }
.sign_table input[type="hidden"] { display: none; }
.info_label { background-color: #f9f9f9; font-weight: bold; text-align: center; }
.info_value { text-align: left; padding-left: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.history_list { list-style: none; margin: 0; padding: 4px 5px; }
.history_list li { padding: 1px 0; line-height: 1.3; }
.history_cell { vertical-align: top !important; padding: 0 !important; }

/* 인원투입 테이블 스타일 (thead 추가) */
.people_table { width: 100%; border-collapse: collapse; border: none; }
.people_table thead th { /* ★ thead th 스타일 추가 */
    background-color: #f9f9f9;
    font-weight: bold;
    padding: 3px 4px; /* 높이 조절 */
    border: 1px solid #ccc;
    font-size: 8.5pt;
    text-align: center;
}
.people_table td { border: 1px solid #ccc; padding: 2px 4px; font-size: 9pt; } /* 높이 조절 */
.people_table td:first-child { text-align: left; padding-left: 5px; }
.people_table tr:last-child td { font-weight: bold; background-color: #f9f9f9; }

.material_machine_cell { width: 60%; vertical-align: top !important; padding: 0 !important; border-right: 1px solid #ccc; }
.machine_cell { width: 40%; vertical-align: top !important; padding: 0 !important; }
.sub_table { width: 100%; border-collapse: collapse; border: none; }
.sub_table th, .sub_table td { border-bottom: 1px solid #eee; border-right: 1px solid #eee; padding: 2px 4px; font-size: 9pt; } /* 높이 조절 */
.sub_table th { background-color: #f9f9f9; font-size: 8.5pt; padding: 3px 4px; } /* 높이 조절 */
.sub_table tr:last-child td { border-bottom: none; }
.sub_table td:last-child { border-right: none; }
.section_title_left { text-align: left !important; padding-left: 10px !important; font-weight: bold; background-color: #e0eef9; }
.special_notes_cell { text-align: left; vertical-align: top; padding: 5px 8px !important; } /* 높이 조절 */

/* 인쇄 설정 */
@page { size: A4 portrait; margin: 10mm 12mm 10mm 12mm; }
@media print {
    html, body { width: 100%; height: auto; margin: 0 !important; padding: 0 !important; font-size: 9.5pt; background-color: #fff !important; color: #000 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .print_area { width: 100%; margin: 0; padding: 0; }
    .table_wrap { margin-bottom: 0; border: 1px solid #000 !important; }
    .table_wrap th, .table_wrap td { border: 1px solid #555 !important; font-size: 8.5pt !important; padding: 3px 4px !important; }
    .main_title { font-size: 16pt !important; }
    .print_none { display: none !important; }
    .page_break { page-break-after: always; height: 0; display: block; border: none; }
    tr, li, .sub_table tbody tr, .people_table tbody tr { page-break-inside: avoid; }
    .table_wrap, .sub_table, .people_table { page-break-inside: avoid; }
    .sign_table td, .sign_table th { height: 60px !important; vertical-align: middle !important; }
    .sign_table th { vertical-align: middle !important; }
    .info_value { white-space: normal !important; overflow: visible !important; text-overflow: clip !important; }
    /* 인쇄 시 높이 조절 스타일 */
    .people_table thead th { padding: 3px 4px !important; font-size: 8pt !important;}
    .people_table td { padding: 2px 4px !important; }
    .sub_table th { padding: 3px 4px !important; font-size: 8pt !important;}
    .sub_table td { padding: 2px 4px !important; }
    .history_list li { padding: 1px 0 !important; line-height: 1.3 !important; }
    .special_notes_cell { padding: 5px 8px !important; }
}

/* 화면 인쇄 버튼 영역 */
.print_controls { padding: 15px; text-align: center; background-color: #f0f0f0; border-bottom: 1px solid #ccc; }
.print_controls h2 { margin: 0 0 10px 0; font-size: 16px; }
.print_controls button, .print_controls a { padding: 8px 15px; margin: 0 5px; font-size: 14px; cursor: pointer; text-decoration: none; border: 1px solid #aaa; border-radius: 4px; }
.print_controls button { background-color: #4CAF50; color: white; }
.print_controls a { background-color: #eee; color: #333; }
</style>
</head>
<body>

<div class="print_controls print_none">
    <h2>
        [<?php echo htmlspecialchars($work_info['nw_code'] ?? ''); ?>] <?php echo htmlspecialchars($work_info['nw_subject'] ?? ''); ?> - 공사일보 일괄출력 (<?php echo $total_count; ?>건)
    </h2>
    <button type="button" onclick="window.print();"> 전체 인쇄 </button>
    <a href="../list/menu3_list.php"> 목록으로 </a>
    <p style="font-size:12px; margin-top:10px; color:#555;">※ 인쇄 미리보기에서 '머리글/바닥글' 옵션을 해제하고 '배경 그래픽' 옵션을 체크하면 더 깔끔하게 인쇄됩니다.</p>
</div>

<div class="print_area">
<?php
// 만약 일보가 하나도 없으면 메시지
if ($total_count == 0) {
    echo "<p style='text-align:center; padding: 50px;'>작성된 공사일보가 없습니다.</p>";
} else {
    $report_index = 0; // 현재 몇 번째 보고서인지 추적
    // 여러 건을 while문으로
    while ($row = sql_fetch_array($result)) {
        $report_index++;

        // 현장 / 날짜
        $date = $row['ns_date'];
        $seq = $row['seq']; // 현재 일보의 고유 ID

        // 인원투입현황 불러오기
        $gongjongSql = "SELECT * FROM {$none['smart_gongjong']} WHERE ns_id = '{$seq}' ORDER BY seq ASC";
        $gongjongRst = sql_query($gongjongSql);

        // 자재반입
        $jajaeSql = "SELECT * FROM {$none['smart_jajae']} WHERE ns_id = '{$seq}' ORDER BY seq ASC";
        $jajaeRst = sql_query($jajaeSql);

        // 장비반입
        $machineSql = "SELECT * FROM {$none['smart_machine']} WHERE ns_id = '{$seq}' ORDER BY seq ASC";
        $machineRst = sql_query($machineSql);

        // 요일 구하기
        $yoil = function_exists('get_yoil') ? get_yoil($date) : '';

        // 작성자 (각 일보의 작성자 정보 사용 시 - $row['writer_field'] 등 확인 필요)
        // $current_drafter_name = isset($row['writer_field']) ? htmlspecialchars($row['writer_field']) : '';
        // 여기서는 일괄출력이므로 상단에서 정의한 $drafter_name_raw 사용 (담당자 정보 없을 시 공백 처리)
        $current_drafter_display = ($drafter_name_raw === '담당자 정보 없음') ? '&nbsp;' : $drafter_name_raw;

?>
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
                                <td><?php echo $current_drafter_display; // 담당자 표시 (공백 처리됨) ?></td>
                                <?php if ($signline) { for($i=1; $i<=5; $i++) { if(empty($signline['ns_id'.$i])) continue; ?>
                                <td><input type="hidden" name="ns_id<?php echo $i?>" value="<?php echo $signline['ns_id'.$i]?>"></td>
                                <?php } } else { echo "<td colspan='5'></td>"; } ?>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="info_label" colspan="2">현 장 명</td><td class="info_value" colspan="7"><?php echo htmlspecialchars($work_info['nw_subject'] ?? '현장명 없음'); ?></td><td class="info_label" colspan="2">공 정 률</td><td class="info_value" colspan="3"><?php echo number_format((float)($row['ns_persent'] ?? 0), 1); ?> %</td><td class="info_label" colspan="2">작 성 자</td><td class="info_value" colspan="4"><?php echo function_exists('get_manager_txt') ? get_manager_txt($work_info['nw_ptype1_1'] ?? '') : htmlspecialchars($work_info['nw_ptype1_1'] ?? ''); ?></td>
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
                 <th colspan="12" class="section_title_left">⊙ 자재 반입 현황</th> <th colspan="8" class="section_title_left">⊙ 장비 사용 현황</th> </tr>
            <tr>
                <td colspan="12" class="material_machine_cell"> <table class="sub_table">
                         <thead> <tr> <th style="width:25%;">품명</th><th style="width:20%;">규격</th><th style="width:10%;">단위</th> <th style="width:10%;">전일</th><th style="width:10%;">금일</th><th style="width:10%;">누계</th> <th style="width:15%;">비고</th> </tr> </thead>
                         <tbody> <?php $jajae_count = 0; sql_data_seek($jajaeRst, 0); while ($jajae = sql_fetch_array($jajaeRst)) { $jajae_count++; ?> <tr> <td style="text-align:left;"><?php echo htmlspecialchars($jajae['ns_name']); ?></td> <td style="text-align:left;"><?php echo htmlspecialchars($jajae['ns_option']); ?></td> <td><?php echo htmlspecialchars($jajae['ns_dan']); ?></td> <td style="text-align:right;"><?php echo number_format((int)$jajae['ns_ycnt']); ?></td> <td style="text-align:right;"><?php echo number_format((int)$jajae['ns_tcnt']); ?></td> <td style="text-align:right;"><?php echo number_format((int)$jajae['ns_stotal']); ?></td> <td style="text-align:left;"><?php echo htmlspecialchars($jajae['ns_etc']); ?></td> </tr> <?php } ?> <?php if ($jajae_count == 0): ?> <tr><td colspan="7" style="text-align: center; height: 40px; border: none; color: #aaa;">&nbsp;</td></tr> <?php endif; ?> </tbody>
                    </table>
                </td>
                <td colspan="8" class="material_machine_cell"> <table class="sub_table">
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
        <?php
        // 마지막 보고서가 아니면 페이지 나누기 추가
        if ($report_index < $total_count) {
            echo '<div class="page_break"></div>';
        }
        ?>

<?php
    } // end while
} // end if ($total_count > 0)
?>
</div><?php
// --- 푸터 포함 ---
// include_once(NONE_PATH.'/footer.php'); // 필요시 주석 해제 또는 수정
?>

<script>
// function onPrint() { window.print(); } // JS 버튼 사용 시
</script>

</body>
</html>