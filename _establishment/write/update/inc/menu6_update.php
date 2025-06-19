<?php
include_once('../../../../_common.php'); // 경로 확인 필요

// 로그인 및 권한 확인 (기존 코드 유지)
if($is_guest) alert('로그인 후 이용바랍니다.');

// --- 폼 데이터 가져오기 및 기본 검증/보안 처리 ---
$nw_code = isset($_POST['nw_code']) ? sql_real_escape_string(trim($_POST['nw_code'])) : '';
$ne_date = isset($_POST['ne_date']) ? sql_real_escape_string(trim($_POST['ne_date'])) : '';
$ne_settlement_user_id = isset($_POST['ne_settlement_user_id']) ? sql_real_escape_string(trim($_POST['ne_settlement_user_id'])) : '';

// 필수 값 체크
if (empty($nw_code) || empty($ne_date) || empty($ne_settlement_user_id)) {
    alert('필수 정보가 누락되었습니다. (현장코드, 정산일자, 담당자)');
}
// --- ▲ 폼 데이터 처리 ---


// --- ▼ [수정됨] 기존 데이터 삭제 로직 ---
// 해당 현장코드와 정산일자의 데이터를 삭제합니다.
// 이때, 담당자 ID가 현재 폼에서 넘어온 ID와 같거나,
// 또는 담당자 ID가 지정되지 않은(NULL 또는 공백) 과거 데이터도 함께 삭제합니다.

$delete_sql = "DELETE FROM {$none['est_imprest']}
               WHERE nw_code = '{$nw_code}'
               AND ne_date = '{$ne_date}'
               AND (
                       ne_settlement_user_id = '{$ne_settlement_user_id}'
                       OR ne_settlement_user_id IS NULL
                       OR ne_settlement_user_id = ''
                   )";

// 생성된 DELETE 쿼리를 실행합니다. (@ 기호 없이 실행)
sql_query($delete_sql);

// --- ▲ [수정됨] 기존 데이터 삭제 로직 ---


// --- ▼ 폼에서 전송된 각 행(row) 데이터 처리 및 INSERT ---
// count() 함수의 대상이 배열인지 확인
$row_count = isset($_POST['ne_trade_date']) && is_array($_POST['ne_trade_date']) ? count($_POST['ne_trade_date']) : 0;

for ($i = 0; $i < $row_count; $i++) {

    // 빈 행은 건너뛸 수 있도록 (선택적: 모든 필드가 비어있는지 체크 등 강화 가능)
    if (empty($_POST['ne_trade_date'][$i]) && empty($_POST['ne_account_name'][$i]) && empty($_POST['ne_summary'][$i])) {
        continue; // 필수적인 내용이 없으면 해당 행은 INSERT하지 않음
    }

    // 콤마 제거
    $ne_cash = isset($_POST['ne_cash'][$i]) ? str_replace(',', '', $_POST['ne_cash'][$i]) : 0;
    $ne_card = isset($_POST['ne_card'][$i]) ? str_replace(',', '', $_POST['ne_card'][$i]) : 0;
    // 요약 정보는 각 행 데이터에는 불필요해 보임 (주석 처리 또는 삭제 고려)
    // $ne_expenses_summary = isset($_POST['ne_expenses']) ? str_replace(',', '', $_POST['ne_expenses']) : 0;
    // $ne_deposit_summary = isset($_POST['ne_deposit']) ? str_replace(',', '', $_POST['ne_deposit']) : 0;
    // $ne_balance_summary = isset($_POST['ne_balance']) ? str_replace(',', '', $_POST['ne_balance']) : 0;

    // 각 배열 요소 값 가져오기 및 이스케이프 처리 (SQL Injection 방지)
    $ne_trade_date = isset($_POST['ne_trade_date'][$i]) ? sql_real_escape_string($_POST['ne_trade_date'][$i]) : '';
    $ne_account_name = isset($_POST['ne_account_name'][$i]) ? sql_real_escape_string($_POST['ne_account_name'][$i]) : '';
    $ne_summary = isset($_POST['ne_summary'][$i]) ? sql_real_escape_string($_POST['ne_summary'][$i]) : '';
    $ne_user = isset($_POST['ne_user'][$i]) ? sql_real_escape_string($_POST['ne_user'][$i]) : ''; // 항목별 사용자
    $ne_cash_val = sql_real_escape_string($ne_cash); // 숫자형도 이스케이프 권장
    $ne_card_val = sql_real_escape_string($ne_card);
    $ne_total_val = sql_real_escape_string($ne_cash + $ne_card); // 서버에서 직접 계산 권장
    $ne_etc = isset($_POST['ne_etc'][$i]) ? sql_real_escape_string($_POST['ne_etc'][$i]) : '';

    // INSERT 쿼리
    $sql = "INSERT INTO {$none['est_imprest']} SET
        ne_settlement_user_id = '{$ne_settlement_user_id}', /* 담당자 ID */
        mb_id = '{$member['mb_id']}', /* 작성자 ID (로그인 사용자) */
        nw_code = '{$nw_code}',
        ne_date = '{$ne_date}',
        ne_deposit = '{$ne_deposit}', /* ★★★ 금월입금액 저장 ★★★ */
        ne_trade_date = '{$ne_trade_date}',
        ne_account_name = '{$ne_account_name}',
        ne_summary = '{$ne_summary}',
        ne_user = '{$ne_user}', /* 항목별 사용자 */
        ne_cash = '{$ne_cash_val}',
        ne_card = '{$ne_card_val}',
        ne_total = '{$ne_total_val}', /* 서버 계산값 */
        /* 아래 요약 정보는 각 행에 저장할 필요가 없어 보입니다. (필요시 주석 해제) */
        /* ne_expenses = '" . sql_real_escape_string($ne_expenses_summary) . "', */
        /* ne_deposit = '" . sql_real_escape_string($ne_deposit_summary) . "', */
        /* ne_balance = '" . sql_real_escape_string($ne_balance_summary) . "', */
        ne_etc = '{$ne_etc}',
        ne_datetime = '".G5_TIME_YMDHIS."',
        ne_ip = '".$_SERVER['REMOTE_ADDR']."'
    ";

    sql_query($sql, false); // INSERT 실패 시 오류 확인 위해 두 번째 인자 false 또는 생략 권장

    // INSERT 실패 시 오류 메시지 확인 (디버깅용)
    /*
    $result = sql_query($sql);
    if (!$result) {
        die("<p>INSERT 오류 발생:<br>" . sql_error() . "<br>Query: " . $sql . "</p>");
    }
    */

} // end for
// --- ▲ 데이터 처리 및 INSERT ---


// --- ▼ 완료 메시지 후 이동 경로 설정 ---
// 이전 페이지(수정폼)로 돌아가거나 목록으로 이동 등
$redirect_url = $_SERVER['HTTP_REFERER'] ?? '../list/menu6_list.php'; // 이전 페이지가 없으면 목록으로 (경로 확인 필요)

alert('전도금 정산서가 업데이트 되었습니다.', $redirect_url);
// --- ▲ 완료 메시지 ---

?>