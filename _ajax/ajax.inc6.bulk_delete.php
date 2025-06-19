<?php
// 파일 위치: /www/_ajax/ajax.inc6.bulk_delete.php
// FINAL VERSION - Handles missing sql_affected_rows/sql_error

// --- 기본 설정 파일 Include ---
include_once('../_common.php');

// --- JSON 응답 설정 ---
header('Content-Type: application/json');

// _common.php 로드 및 필수 함수 확인
if (!function_exists('sql_query')) {
    echo json_encode(['success' => false, 'message' => '오류: 기본 설정 로드 실패']);
    exit;
}

// --- 로그인 및 권한 확인 ---
if ($is_guest) { // $is_guest 변수가 _common.php 에서 정의된다고 가정
    echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
    exit;
}
// if (!check_permission(...)) { ... } // 필요 시 권한 체크

// --- 전달받은 데이터 처리 및 유효성 검사 ---
$seq_list_json = $_POST['seq_list'] ?? null;
if ($seq_list_json === null) { echo json_encode(['success' => false, 'message' => '삭제할 항목 데이터(seq_list)가 전달되지 않았습니다.']); exit; }
// 강제 stripslashes 처리
$seq_list_json_processed = stripslashes($seq_list_json);
$seq_list = json_decode($seq_list_json_processed, true);
if ($seq_list === null || !is_array($seq_list)) { error_log("Bulk Delete JSON Decode Error. Input after forced stripslashes: " . $seq_list_json_processed . " | Original Input from POST: " . $seq_list_json); echo json_encode(['success' => false, 'message' => '전달된 데이터 형식이 잘못되었습니다. (JSON Decode 실패)']); exit; }
if (empty($seq_list)) { echo json_encode(['success' => false, 'message' => '삭제할 항목이 선택되지 않았습니다. (빈 목록 수신)']); exit; }

// --- 삭제할 ID 목록 정제 ---
$seq_list_int = [];
foreach ($seq_list as $seq) { $seq_val = intval($seq); if ($seq_val > 0) { $seq_list_int[] = $seq_val; } }
if (empty($seq_list_int)) { echo json_encode(['success' => false, 'message' => '유효한 삭제 대상 ID가 없습니다.']); exit; }

// --- 테이블명 확인 ---
$imprest_table = isset($none['est_imprest']) ? $none['est_imprest'] : null;
if (!$imprest_table) { error_log("Bulk Delete Error: Table name for 'est_imprest' is not defined."); echo json_encode(['success' => false, 'message' => '오류: 테이블 정보를 찾을 수 없습니다.']); exit; }

// --- 데이터베이스 삭제 처리 ---
$seq_list_str = implode(',', $seq_list_int);
$sql = "DELETE FROM {$imprest_table} WHERE seq IN ({$seq_list_str})";
$result = sql_query($sql); // Execute query

// --- ★★★ 결과 처리 수정 (정의되지 않은 함수 호출 제거) ★★★ ---
if ($result) {
    // 삭제 성공. sql_affected_rows 함수가 없으므로 일반 성공 메시지 사용
    echo json_encode(['success' => true, 'message' => '선택한 항목이 삭제되었습니다.']);
} else {
    // 삭제 실패. sql_error 함수가 없으므로 일반 실패 메시지 사용
    error_log("Bulk Delete DB Error: Query failed. SQL: " . $sql); // 로그에는 SQL 기록
    echo json_encode(['success' => false, 'message' => '데이터 삭제 중 오류가 발생했습니다. 관리자에게 문의하세요.']);
}
// --- ★★★ 수정 끝 ★★★ ---

exit;
?>