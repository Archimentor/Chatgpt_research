<?php
include_once('../_common.php');

// 1. 로그인 확인 (원본과 동일)
if($is_guest) {
    // AJAX 호출이므로 alert 대신 오류 메시지 출력 후 종료
    echo '로그인 후 이용바랍니다.';
    exit;
}

// 2. seq 값 가져오기 (AJAX는 $_POST 또는 $_GET 사용)
// menu1_write.php에서 $.post 를 사용했으므로 $_POST['seq'] 사용
$seq = isset($_POST['seq']) ? (int)$_POST['seq'] : 0;
if ($seq <= 0) {
    echo '잘못된 요청입니다. (seq 오류)';
    exit;
}

// 3. 파일 정보 조회 (원본과 동일, @ 제거)
$file = sql_fetch("select * from {$g5['board_file_table']} where seq = '$seq'");
if(!$file) {
    echo '삭제할 파일 정보가 존재하지 않습니다.';
    exit;
}

// 4. 디렉토리 이름 결정 (원본과 동일)
$dirName = '';
switch($file['bf_category']) {
    case "현장사진" : $dirName = 1; break;
    case "도급계약서" : $dirName = 2; break;
    case "계약내역서" : $dirName = 3; break;
    case "건축허가서" : $dirName = 4; break;
    case "착공계서류" : $dirName = 5; break;
    case "건강연금" : $dirName = 6; break;
    case "고용산재" : $dirName = 7; break;
    case "퇴직공제" : $dirName = 8; break;
    case "근재영업배상" : $dirName = 9; break;
    case "폐기물신고" : $dirName = 10; break;
    case "계약보증서" : $dirName = 11; break;
    case "하자보증서" : $dirName = 12; break;
    case "선급금보증서" : $dirName = 13; break;
    case "기타보증서" : $dirName = 14; break;
    case "기타서류" : $dirName = 15; break;
    default:
        // 카테고리가 없을 경우 기본값 또는 오류 처리
        $dirName = 'unknown'; // 혹은 오류 메시지 출력 후 종료
        // echo '알 수 없는 파일 분류입니다.'; exit;
        break;
}

// 5. 파일 경로 구성 및 삭제 시도 (원본 기반, @ 제거, NONE_PATH 확인)
if (!defined('NONE_PATH')) {
    error_log("[File Delete Error] NONE_PATH constant is not defined. Check common.php include.");
    echo '서버 설정 오류 (NONE_PATH)';
    exit;
}
if (empty($dirName) || empty($file['bf_file'])) {
     error_log("[File Delete Error] Cannot construct file path. Dir: {$dirName}, File: {$file['bf_file']}");
     echo '파일 경로 구성 오류.';
     exit;
}

$filename = basename($file['bf_file']); // 보안 강화
$dest_file = NONE_PATH.'/_data/worksite/'.$dirName.'/'.$filename;

$file_unlink_success = true; // 파일이 없어도 DB는 삭제 시도하도록 기본값 true
if (file_exists($dest_file)) {
    // 파일 삭제 시도 (@ 제거)
    if (!unlink($dest_file)) {
        // 파일 삭제 실패 시 로그 남기고 오류 응답
        $error = error_get_last();
        error_log("[File Delete Error] unlink failed for {$dest_file}. Error: " . ($error['message'] ?? 'Unknown error'));
        echo '서버 파일 삭제 실패. 권한 또는 경로를 확인하세요.';
        exit; // DB 삭제 시도 안 함
    } else {
        error_log("[File Delete Info] File successfully unlinked: {$dest_file}");
    }
} else {
    error_log("[File Delete Info] File not found, proceeding to DB delete: {$dest_file}");
}

// 6. DB 삭제 시도 (@ 제거)
// 파일 삭제 성공 또는 파일이 원래 없었을 경우 DB 삭제 시도
$sql = "DELETE FROM {$g5['board_file_table']} WHERE seq = '$seq'";
$result = sql_query($sql);

// 7. 최종 결과 응답
if ($result) {
    // DB 삭제 쿼리가 성공적으로 실행되면 (오류 없이)
    echo 'success'; // JavaScript에서 받을 성공 텍스트
} else {
    // DB 삭제 쿼리 실행 중 오류 발생 시
    $db_error = function_exists('sql_error') ? sql_error() : 'DB error check function not available';
    error_log("[File Delete Error] DB delete failed for seq {$seq}. SQL: {$sql}. DB Error: {$db_error}");
    echo '데이터베이스 정보 삭제 실패.'; // 실패 메시지 텍스트
}

exit; // 스크립트 종료

?>