<?php
// 파일 위치: /www/_establishment/write/include/menu6_inc.php

// --- 기본 설정 파일 Include ---
@include_once($_SERVER['DOCUMENT_ROOT'] . '/_common.php');
if (!function_exists('sql_query')) { die('FATAL ERROR: 필수 설정 파일 로드 실패 또는 필수 함수(sql_query)가 정의되지 않았습니다.'); }
// --- 테이블 정보 Include ---
@include_once('./a_update_table.php'); // ★★★ 경로 확인 ★★★
if (!isset($none) || !isset($none['est_imprest'])) { $none['est_imprest'] = 'g5_estimate_imprest'; /* ★★★ 임시 테이블명 ★★★ */ }

// --- 담당자 정보 가져오기 및 선택된 담당자 결정 ---
$site_managers = []; $manager_ids = []; $manager1_id = null;
if (isset($work) && is_array($work)) {
    for ($i = 1; $i <= 6; $i++) {
        $field_name = 'nw_ptype1_' . $i;
        if (!empty($work[$field_name])) {
            $manager_id = $work[$field_name];
            if ($i == 1 && $manager1_id === null) { $manager1_id = $manager_id; }
            $manager_name = function_exists('get_manager_txt') ? get_manager_txt($manager_id) : '';
            if (empty($manager_name)) { $manager_name = "[ID: " . $manager_id . "]"; }
            if (!isset($site_managers[$manager_id])) { $site_managers[$manager_id] = $manager_name; $manager_ids[] = $manager_id; }
        }
    }
    $current_nw_code = $work['nw_code'] ?? '';
    $current_nw_subject = $work['nw_subject'] ?? '현장명 없음';
} else { $current_nw_code = $_GET['nw_code'] ?? ''; $current_nw_subject = '현장 정보 없음'; }
$selected_user_id = '';
if (isset($_GET['selected_user']) && isset($site_managers[$_GET['selected_user']])) { $selected_user_id = $_GET['selected_user']; }
else if (isset($member['mb_id']) && isset($site_managers[$member['mb_id']])) { $selected_user_id = $member['mb_id']; }
else if ($manager1_id !== null) { $selected_user_id = $manager1_id; }
else if (!empty($manager_ids)) { $selected_user_id = $manager_ids[0]; }
$selected_user_name = '담당자 미선택';
if (!empty($selected_user_id) && isset($site_managers[$selected_user_id])) { $selected_user_name = $site_managers[$selected_user_id]; }
// --- ▲ 담당자 정보 ---

// --- 데이터 조회 로직 ---
$chk = null; $prev = null; $rst = null; $has_data = false;
$imprest_table = $none['est_imprest'];
$current_date = isset($date) ? sql_real_escape_string($date) : ($_GET['date'] ?? date('Y-m-d'));
if (!empty($selected_user_id) && !empty($current_nw_code)) {
    $common_where_sql = " WHERE nw_code = '" . sql_real_escape_string($current_nw_code) . "' AND ne_date = '" . sql_real_escape_string($current_date) . "'";
    $user_where_sql = '';
    if ($manager1_id !== null && $selected_user_id == $manager1_id) { $user_where_sql = " AND (ne_settlement_user_id = '" . sql_real_escape_string($selected_user_id) . "' OR ne_settlement_user_id IS NULL OR ne_settlement_user_id = '')"; }
    else { $user_where_sql = " AND ne_settlement_user_id = '" . sql_real_escape_string($selected_user_id) . "'"; }
    $list_sql = "SELECT * FROM {$imprest_table} " . $common_where_sql . $user_where_sql . " ORDER BY ne_trade_date ASC, seq ASC";
    $rst = sql_query($list_sql);
    if ($rst) { $has_data = (sql_num_rows($rst) > 0); }
    $chk_sql = "SELECT * FROM {$imprest_table} " . $common_where_sql . $user_where_sql . " LIMIT 1";
    $chk = sql_fetch($chk_sql);
    $prev_date_ym = date('Y-m', strtotime($current_date . " -1 month"));
    $prev_where_sql = " WHERE nw_code = '" . sql_real_escape_string($current_nw_code) . "' AND ne_date LIKE '" . sql_real_escape_string($prev_date_ym) . "%'";
    // 전월 잔액 조회 시에는 담당자 조건을 제거하여 현장 전체의 마지막 잔액을 확인한다
    // 선택된 담당자의 전월 데이터가 없더라도 직전 달의 잔액이 표시되도록 한다.
    $prev_sql = "SELECT ne_balance FROM {$imprest_table} " . $prev_where_sql . " ORDER BY ne_date DESC, seq DESC LIMIT 1";
    $prev = sql_fetch($prev_sql);
    $prev_balance = isset($prev['ne_balance']) ? $prev['ne_balance'] : 0;
}
// --- ▲ 데이터 조회 ---
?>

<style>
/* 기본 스타일 */
.chk_col { width: 5%; text-align: center; vertical-align: middle; }
.fa-trash-o { color:red; cursor:pointer; margin-right: 5px; }
.manager-select-label { font-weight: bold; margin-right: 10px;}
.input { box-sizing: border-box; width: 100%; border: none; padding: 1px 2px; background-color: transparent; vertical-align: middle; font-size: inherit; }
.text-right { text-align: right; }
.sound_only { position: absolute; height: 1px; width: 1px; overflow: hidden; clip: rect(1px, 1px, 1px, 1px); clip-path: inset(50%); } /* 접근성용 숨김 텍스트 */
.btn_fixed_top { display: none; } /* 기존 선택 삭제 버튼 영역 숨김 */
.modal-footer { display: flex; justify-content: flex-end; align-items: center; } /* Flexbox 정렬 */
.modal-footer .btn-left { margin-right: auto; } /* 왼쪽 정렬용 클래스 */

/* ★★★★★ 선택된 행 하이라이트 색상 변경 ★★★★★ */
.selected-row {
    background-color: #fffacd !important; /* LemonChiffon (연노랑) */
}

/* 인쇄 시 숨길 요소 설정 */
@media print {
    .chk_col, .column_chk, .btn_fixed_top,
    .modal-footer button:not(.btn-secondary), /* 인쇄 버튼 제외 모두 숨김 */
    .modal-footer .btn-left, /* 왼쪽 정렬된 버튼도 숨김 */
    .fa-trash-o, #manager_select, .manager-select-label,
    div[style*="margin-bottom: 15px"] span { display: none !important; }
}
</style>

<div style="margin-bottom: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 5px;">
    <label for="manager_select" class="manager-select-label">정산 담당자:</label>
    <select name="manager_select" id="manager_select" onchange="changeManager(this.value)">
        <?php
        if (empty($site_managers)) { echo '<option value="">지정된 담당자 없음</option>'; }
        else { foreach ($site_managers as $id => $name) { echo '<option value="' . htmlspecialchars($id) . '" ' . ($selected_user_id == $id ? 'selected' : '') . '>' . htmlspecialchars($name) . '</option>'; } }
        ?>
    </select>
    <span style="margin-left: 15px; font-size: 0.9em; color: #6c757d;">(담당자를 변경하면 해당 담당자의 정산서가 표시됩니다.)</span>
</div>

<form name="frm" id="fboardlist" action="./update/inc/menu6_update.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="mode" value="<?php echo isset($mode) ? $mode : ''; ?>">
<input type="hidden" name="nw_code" id="nw_code" value="<?php echo htmlspecialchars($current_nw_code); ?>">
<input type="hidden" name="ne_date" value="<?php echo htmlspecialchars($current_date); ?>">
<input type="hidden" name="ne_settlement_user_id" id="ne_settlement_user_id" value="<?php echo htmlspecialchars($selected_user_id); ?>">

<div class="print_frm">
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width:100%">
        <col class="chk_col" style="width:5%;">
        <col class="col0" style="width:12%;">
        <col class="col1" style="width:15%;">
        <col class="col2" style="width:20%;">
        <col class="col3" style="width:10%;">
        <col class="col4" style="width:10%;">
        <col class="col5" style="width:10%;">
        <col class="col6" style="width:10%;">
        <col class="col7" style="width:13%;">
        <thead>
          <tr class="row0"><td class="column0 style42 s style42" colspan="9" >(<?php echo date('Y년 m월', strtotime($current_date))?>) 전도금 정산서 - <?php echo htmlspecialchars($selected_user_name); ?></td></tr>
          <tr class="row1"><td class="column0 style41 s" colspan="8">현장명: <?php echo htmlspecialchars($current_nw_subject); ?></td><td class="column_chk style43 f style43" ></td></tr>
          <tr class="row2">
            <td class="column_chk style39 s style39" rowspan="2"><label for="chkall" class="sound_only">전체선택</label><input type="checkbox" id="chkall" onclick="check_all(this.form)"></td>
            <td class="column0 style39 s style39" rowspan="2">일 자</td><td class="column1 style39 s style39" rowspan="2">거래처</td><td class="column2 style39 s style39" rowspan="2">적 요</td><td class="column3 style39 s style39" rowspan="2">전도금 사용자</td><td class="column4 style40 s style40" colspan="3">사 용 금 액</td><td class="column7 style38 s style38" rowspan="2">비 고</td>
          </tr>
          <tr class="row3"><td class="column4 style33 s">개인사용</td><td class="column5 style33 s">법인사용</td><td class="column6 style10 s">합 계</td></tr>
        </thead>
      <tbody id="rowbody">
      <?php
        $cash_total = 0; $card_total = 0; $all_total = 0;
        if ($has_data) {
             while ($row = sql_fetch_array($rst)) {
                $cash_val = (int)($row['ne_cash'] ?? 0); $card_val = (int)($row['ne_card'] ?? 0); $total_val = (int)($row['ne_total'] ?? ($cash_val + $card_val));
                $cash_total += $cash_val; $card_total += $card_val; $all_total += $total_val;
      ?>
            <tr class="row4" >
                 <td class="column_chk"><label for="chk_seq_<?php echo $row['seq']; ?>" class="sound_only"><?php echo $row['seq']; ?>번 항목</label><input type="checkbox" name="chk_seq[]" value="<?php echo $row['seq']; ?>" id="chk_seq_<?php echo $row['seq']; ?>"></td>
                 <td class="column0 style34 null"><span class="glyphicon fa fa-trash-o" onclick="delete_row(<?php echo $row['seq']; ?>)" title="개별 삭제"></span><input type="date" name="ne_trade_date[]" class="input ne_trade_date" value="<?php echo htmlspecialchars($row['ne_trade_date']); ?>" style="width:80%"><input type="hidden" name="row_seq[]" value="<?php echo $row['seq']; ?>"></td>
                 <td class="column1 style24 null"><input type="text" name="ne_account_name[]" class="input " value="<?php echo htmlspecialchars($row['ne_account_name']); ?>"> </td>
                 <td class="column2 style24 null"><input type="text" name="ne_summary[]" class="input" value="<?php echo htmlspecialchars($row['ne_summary']); ?>"></td>
                 <td class="column3 style24 null"><input type="text" name="ne_user[]" class="input" value="<?php echo htmlspecialchars($row['ne_user']); ?>"></td>
                 <td class="column4 style23 null"><input type="text" name="ne_cash[]" class="input numb text-right" value="<?php echo number_format($cash_val); ?>"></td>
                 <td class="column5 style37 null"><input type="text" name="ne_card[]" class="input numb text-right" value="<?php echo number_format($card_val); ?>"></td>
                 <td class="column6 style10 null"><input type="text" name="ne_total[]" class="input numb text-right" value="<?php echo number_format($total_val); ?>" readonly></td>
                 <td class="column7 style32 null"><input type="text" name="ne_etc[]" class="input " value="<?php echo htmlspecialchars($row['ne_etc']); ?>"></td>
            </tr>
        <?php } } else { for ($i = 0; $i < 5; $i++) { ?>
            <tr class="row4" >
                 <td class="column_chk"></td><td class="column0 style34 null"><span class="glyphicon fa fa-trash-o" onclick="delete_new_row(this)"></span><input type="date" name="ne_trade_date[]" class="input ne_trade_date" value=""><input type="hidden" name="row_seq[]" value=""></td><td class="column1 style24 null"><input type="text" name="ne_account_name[]" class="input" value=""> </td><td class="column2 style24 null"><input type="text" name="ne_summary[]" class="input" value=""></td><td class="column3 style24 null"><input type="text" name="ne_user[]" class="input" value=""></td><td class="column4 style23 null"><input type="text" name="ne_cash[]" class="input numb text-right" value=""></td><td class="column5 style37 null"><input type="text" name="ne_card[]" class="input numb text-right" value=""></td><td class="column6 style10 null"><input type="text" name="ne_total[]" class="input numb text-right" value="" readonly></td><td class="column7 style32 null"><input type="text" name="ne_etc[]" class="input " value=""></td>
            </tr>
        <?php } } ?>
          </tbody>
      <tfoot>
          <tr class="row39"><td class="column_chk style6 s"></td><td class="column0 style6 s">합 계</td><td class="column1 style8 null"></td><td class="column2 style8 null"></td><td class="column3 style8 null"></td><td class="column4 style7 f cash_total text-right"><?php echo number_format($cash_total); ?></td><td class="column5 style7 f card_total text-right"><?php echo number_format($card_total); ?></td><td class="column6 style7 f all_total text-right"><?php echo number_format($all_total); ?></td><td class="column7 style2 null"></td></tr>
          <tr class="row40"><td class="column_chk style6 s"></td><td class="column0 style6 s">전월잔액</td><td class="column1 f style3 text-right" colspan="7" style="background:#fff"><input type="text" name="ne_prev_deposit" class="input numb text-right" readonly value="<?php echo number_format($prev['ne_balance'] ?? 0); ?>"></td></tr>
          <tr class="row40"><td class="column_chk style6 s"></td><td class="column0 style6 s">금월입금</td><td class="column1 f style3 text-right" colspan="7" style="background:#fff"><input type="text" name="ne_deposit" class="input numb text-right" value="<?php echo number_format($chk['ne_deposit'] ?? 0); ?>"></td></tr>
          <tr class="row40"><td class="column_chk style6 s"></td><td class="column0 style6 s">금월지출</td><td class="column1 f style3 text-right" colspan="7" style="background:#fff"><input type="text" name="ne_expenses" class="input numb text-right" readonly value="<?php echo number_format($all_total); ?>"></td></tr>
          <tr class="row40"><td class="column_chk style6 s"></td><td class="column0 style6 s">전도금 잔액</td><td class="column1 f style3 text-right" colspan="7" style="background:#fff"><input type="text" name="ne_balance" class="input numb text-right" readonly value="<?php $prev_balance_val = (int)($prev['ne_balance'] ?? 0); $current_deposit_val = (int)($chk['ne_deposit'] ?? 0); $current_expenses_val = $all_total; $current_balance = $prev_balance_val + $current_deposit_val - $current_expenses_val; echo number_format($current_balance); ?>"></td></tr>
      </tfoot>
    </table>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm btn-left" onclick="select_delete()">선택 항목 삭제</button> <button type="button" class="btn btn-success" onclick="onExcel()"><span class="glyphicon fa fa-file-excel-o"></span> 엑셀출력</button>
    <button type="button" class="btn btn-secondary" onclick="onPrint()">인쇄</button>
    <button type="button" class="btn btn-info" onclick="add()">칸추가</button>
    <button type="submit" class="btn btn-primary" onclick="remove_comma_before_submit()">저장 (업데이트)</button>
    <button type="button" class="btn btn-default" onclick="location.href='<?php echo defined('G5_URL') ? G5_URL : ''; ?>/path/to/list_page.php'">목록</button> </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <script>
// 콤마 관련 함수
function comma(str) { str = String(str); return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,'); }
function uncomma(str) { str = String(str); return str.replace(/[^\d]+/g, ''); }
function number_format(number, decimals, dec_point, thousands_sep) { number = (number + '').replace(/[^0-9+\-Ee.]/g, ''); var n = !isFinite(+number) ? 0 : +number, prec = !isFinite(+decimals) ? 0 : Math.abs(decimals), sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, dec = (typeof dec_point === 'undefined') ? '.' : dec_point, s = '', toFixedFix = function(n, prec) { var k = Math.pow(10, prec); return '' + Math.round(n * k) / k; }; s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.'); if (s[0].length > 3) { s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep); } if ((s[1] || '').length < prec) { s[1] = s[1] || ''; s[1] += new Array(prec - s[1].length + 1).join('0'); } return s.join(dec); }

// 행 추가/삭제 관련 함수
function add() {
    var newRow = $('<tr class="row4"></tr>');
    var today = new Date().toISOString().slice(0, 10);
    var defaultUserName = "<?php echo addslashes(htmlspecialchars($selected_user_name)); ?>";
    var html = `
        <td class="column_chk"><input type="checkbox" name="chk_seq[]" value="" disabled></td>
        <td class="column0 style34 null">
            <span class="glyphicon fa fa-trash-o" onclick="delete_new_row(this)"></span>
            <input type="date" name="ne_trade_date[]" class="input ne_trade_date" value="${today}">
            <input type="hidden" name="row_seq[]" value="">
        </td>
        <td class="column1 style24 null"><input type="text" name="ne_account_name[]" class="input" value=""></td>
        <td class="column2 style24 null"><input type="text" name="ne_summary[]" class="input" value=""></td>
        <td class="column3 style24 null"><input type="text" name="ne_user[]" class="input" value="${defaultUserName}"></td>
        <td class="column4 style23 null"><input type="text" name="ne_cash[]" class="input numb text-right" value=""></td>
        <td class="column5 style37 null"><input type="text" name="ne_card[]" class="input numb text-right" value=""></td>
        <td class="column6 style10 null"><input type="text" name="ne_total[]" class="input numb text-right" value="" readonly></td>
        <td class="column7 style32 null"><input type="text" name="ne_etc[]" class="input " value=""></td>
    `;
    newRow.html(html);
    $('#rowbody').append(newRow);
    bindNumberEvents(newRow.find('.numb'));
    bindCalculationEvents(newRow.find('input[name="ne_cash[]"], input[name="ne_card[]"]'));
}
function delete_new_row(element) { $(element).closest('tr').remove(); calculateTotals(); }

// 개별 삭제 (AJAX - fetch 사용)
function delete_row(seq) {
    if (confirm('이 항목을 데이터베이스에서 즉시 삭제하시겠습니까?\n삭제 후에는 복구할 수 없습니다.')) {
        const delete_url = '/_ajax/ajax.inc6.delrow.php'; // ★★★ 경로 확인 ★★★
        const formData = new FormData();
        formData.append('seq', seq);
        fetch(delete_url, { method: 'POST', body: formData })
        .then(response => { if (!response.ok) { throw new Error(`HTTP error! status: ${response.status}`); } return response.text(); })
        .then(data => { if (data && data.trim().toLowerCase() === 'y') { alert('항목이 삭제되었습니다.'); location.reload(); } else { alert(data.trim() || '삭제 처리 중 오류가 발생했습니다.'); } })
        .catch(error => { console.error('개별 삭제 Fetch 요청 오류:', error); alert('삭제 요청 중 오류가 발생했습니다. (' + error.message + ')'); });
    }
}

// 담당자 변경
function changeManager(selectedUserId) {
    const url = new URL(window.location.href);
    url.searchParams.set('selected_user', selectedUserId);
    const currentUrlParams = new URLSearchParams(window.location.search);
    const dateParam = currentUrlParams.get('date') || '<?php echo htmlspecialchars($current_date); ?>';
    const nwCodeParam = currentUrlParams.get('nw_code') || '<?php echo htmlspecialchars($current_nw_code); ?>';
    if (dateParam) url.searchParams.set('date', dateParam);
    if (nwCodeParam) url.searchParams.set('nw_code', nwCodeParam);
    window.location.href = url.toString();
}

// 숫자 필드 콤마 처리 및 이벤트 바인딩
function bindNumberEvents(jquery_selector) {
    jquery_selector.off('input.numb').on('input.numb', function(e) { var $this = $(this); var value = $this.val().replace(/[^0-9]/g, ''); $this.val(value ? parseInt(value, 10).toLocaleString('ko-KR') : ''); }).css('text-align', 'right');
    jquery_selector.each(function(){ var $this = $(this); var value = $this.val().replace(/[^0-9]/g, ''); if (value) { $this.val(parseInt(value, 10).toLocaleString('ko-KR')); } });
}

// 금액 계산 이벤트 바인딩
function bindCalculationEvents(jquery_selector) {
    jquery_selector.off('input.calc').on('input.calc', function() { var $row = $(this).closest('tr'); var cash = parseInt(uncomma($row.find('input[name="ne_cash[]"]').val()) || 0); var card = parseInt(uncomma($row.find('input[name="ne_card[]"]').val()) || 0); var total = cash + card; $row.find('input[name="ne_total[]"]').val(comma(total)); calculateTotals(); });
}

// 전체 합계 계산 함수
function calculateTotals() {
    var totalCash = 0, totalCard = 0, totalAll = 0;
    $('#rowbody tr').each(function() { var $row = $(this); totalCash += parseInt(uncomma($row.find('input[name="ne_cash[]"]').val()) || 0); totalCard += parseInt(uncomma($row.find('input[name="ne_card[]"]').val()) || 0); totalAll += parseInt(uncomma($row.find('input[name="ne_total[]"]').val()) || 0); });
    $('tfoot .cash_total').text(comma(totalCash)); $('tfoot .card_total').text(comma(totalCard)); $('tfoot .all_total').text(comma(totalAll));
    var prevBalance = parseInt(uncomma($('input[name="ne_prev_deposit"]').val()) || 0); var deposit = parseInt(uncomma($('input[name="ne_deposit"]').val()) || 0); var expenses = totalAll;
    $('input[name=ne_expenses]').val(comma(expenses)); var currentBalance = prevBalance + deposit - expenses; $('input[name=ne_balance]').val(comma(currentBalance));
}

// 전체선택 체크박스 기능
function check_all(form) {
    var chk = form.elements['chk_seq[]']; var isChecked = form.chkall.checked; if (!chk) return;
    var applyClass = function(checkboxElement, checkedState) { $(checkboxElement).closest('tr').toggleClass('selected-row', checkedState); };
    if (chk.length === undefined) { if (!chk.disabled) { chk.checked = isChecked; applyClass(chk, isChecked); } }
    else { for (var i = 0; i < chk.length; i++) { if (!chk[i].disabled) { chk[i].checked = isChecked; applyClass(chk[i], isChecked); } } }
}

// 선택 삭제 기능 (URLSearchParams 사용)
function select_delete() {
    var f = document.getElementById('fboardlist'); var chk_count = 0; var seq_list = []; var chk = f.elements['chk_seq[]'];
    if (!chk) { alert("삭제할 항목이 없습니다."); return false; }
    if (chk.length === undefined) { if (chk.checked && !chk.disabled) { chk_count++; seq_list.push(chk.value); } }
    else { for (var i = 0; i < chk.length; i++) { if (chk[i].checked && !chk[i].disabled) { chk_count++; seq_list.push(chk[i].value); } } }
    if (!chk_count) { alert("삭제할 항목을 하나 이상 선택하세요."); return false; }
    if (!confirm("선택한 " + chk_count + "개의 항목을 정말 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.")) { return false; }
    var delete_url = '/_ajax/ajax.inc6.bulk_delete.php'; // ★★★ 웹루트 기준 경로
    const params = new URLSearchParams(); params.append('seq_list', JSON.stringify(seq_list));
    console.log("선택 삭제 전송 파라미터:", params.toString());
    fetch(delete_url, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded', }, body: params })
    .then(response => { if (!response.ok) { throw new Error(`HTTP error! status: ${response.status}`); } return response.json(); })
    .then(data => { console.log("선택 삭제 서버 응답 (JSON):", data); if (data && data.success) { alert(data.message || '선택한 항목이 삭제되었습니다.'); location.reload(); } else { alert(data.message || '삭제 처리 중 오류가 발생했습니다.'); } })
    .catch(error => { console.error('선택 삭제 Fetch 요청 오류:', error); alert('삭제 요청 처리 중 오류가 발생했습니다. (' + error.message + ')'); });
}

// 폼 제출 전 콤마 제거 함수
function remove_comma_before_submit() { $('#fboardlist .numb').each(function() { $(this).val(uncomma($(this).val())); }); }

// 엑셀 출력/인쇄 함수 (내용은 필요에 따라 구현)
function onExcel() { alert('엑셀 출력 기능은 준비 중입니다.'); }
function onPrint() { window.print(); }

// 페이지 로드 시 초기화
$(document).ready(function() {
    bindNumberEvents($('.numb')); // .numb 클래스 요소 전체 대상
    bindCalculationEvents($('#rowbody input[name="ne_cash[]"], #rowbody input[name="ne_card[]"]'));
    $('input[name="ne_deposit"]').on('input', function() { bindNumberEvents($(this)); calculateTotals(); });
    calculateTotals(); // 초기 합계 계산

    // 체크박스 변경 시 행 하이라이트
    $('#fboardlist').on('change', 'input[name="chk_seq[]"]:not(:disabled)', function() { // 비활성화된 체크박스 제외
        $(this).closest('tr').toggleClass('selected-row', this.checked);
    });
});
</script>