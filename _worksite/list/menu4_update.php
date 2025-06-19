<?php
// 파일 경로 및 공통 파일 포함 (실제 환경에 맞게 조정 필요)
include_once('../../_common.php');

// 로그인 및 권한 확인 (필요에 따라 관리자 또는 특정 레벨 이상만 허용)
// 예시: 관리자 레벨(10) 이상만 허용
if($is_guest || $member['mb_level'] < 10) {
    alert('수정 권한이 없습니다.', G5_URL);
}


// POST 데이터 유효성 확인
if (!isset($_POST['seqs']) || !is_array($_POST['seqs'])) {
    alert('잘못된 요청입니다. (seqs 누락)');
}

$seqs = $_POST['seqs'];

// 각 프로젝트 정보 필드 배열 가져오기 (없을 경우 빈 배열로 초기화)
$pj_person = $_POST['pj_person'] ?? [];
$pj_upche = $_POST['pj_upche'] ?? [];
$pj_addr_d = $_POST['pj_addr_d'] ?? []; // menu4_list.php에서 사용한 이름
$pj_type = $_POST['pj_type'] ?? [];
$pj_photo = $_POST['pj_photo'] ?? [];
$pj_year = $_POST['pj_year'] ?? [];
// menu1_update.php 참고하여 추가 필드 확인 (pj_title_kr, pj_title_en 등)
$pj_title_kr = $_POST['pj_title_kr'] ?? []; // menu4_list.php 폼에도 추가되어야 함
$pj_title_en = $_POST['pj_title_en'] ?? []; // menu4_list.php 폼에도 추가되어야 함


$success_count = 0;
$fail_count = 0;
$error_messages = []; // 오류 메시지 저장 (선택 사항)

// 트랜잭션 시작 (선택 사항: 다수 업데이트 시 원자성을 보장하기 위함)
// sql_query("START TRANSACTION");

foreach ($seqs as $seq) {
    $seq = (int)$seq; // 정수형으로 변환
    if ($seq <= 0) {
        $fail_count++;
        $error_messages[] = "유효하지 않은 현장 ID가 포함되어 있습니다.";
        continue; // 유효하지 않은 seq는 건너뜀
    }

    // --- 업데이트할 필드 값 준비 ---
    // 해당 seq에 대한 값이 각 배열에 있는지 확인하고, 없으면 기본값(빈 문자열) 사용
    // trim()으로 앞뒤 공백 제거
    // sql_real_escape_string()으로 SQL Injection 방지

    $update_fields = []; // 업데이트할 필드와 값을 저장할 배열

    // 현장소장(D)
    if (isset($pj_person[$seq])) {
        $update_fields[] = " pj_person = '" . sql_real_escape_string(trim($pj_person[$seq])) . "' ";
    }
    // 건축사(D)
    if (isset($pj_upche[$seq])) {
        $update_fields[] = " pj_upche = '" . sql_real_escape_string(trim($pj_upche[$seq])) . "' ";
    }
    // 주소(D) - DB 컬럼명은 'pj_addr'일 가능성이 높음
    if (isset($pj_addr_d[$seq])) {
        $update_fields[] = " pj_addr = '" . sql_real_escape_string(trim($pj_addr_d[$seq])) . "' "; // DB 컬럼명 확인 필요!
    }
    // 용도
    if (isset($pj_type[$seq])) {
        $update_fields[] = " pj_type = '" . sql_real_escape_string(trim($pj_type[$seq])) . "' ";
    }
    // 사진작가
    if (isset($pj_photo[$seq])) {
        $update_fields[] = " pj_photo = '" . sql_real_escape_string(trim($pj_photo[$seq])) . "' ";
    }
    // 준공연도
    if (isset($pj_year[$seq])) {
        $year_value = trim($pj_year[$seq]);
        // 간단한 유효성 검사 (4자리 숫자 또는 빈 값)
        if (empty($year_value) || preg_match('/^\d{4}$/', $year_value)) {
            $update_fields[] = " pj_year = '" . sql_real_escape_string($year_value) . "' ";
        } else {
            // 유효하지 않은 값 처리 (예: 오류로 간주하고 건너뛰거나, 로그 남기기)
             $fail_count++;
             $error_messages[] = "현장 ID {$seq}: 준공연도 형식이 잘못되었습니다. (값: {$year_value})";
             continue; // 이 현장 업데이트 건너뛰기
            // 또는 $update_fields[] = " pj_year = '' "; // 빈 값으로 저장
        }
    }
    // 현장명(한글) - menu4_list.php에도 해당 input이 있어야 함
    if (isset($pj_title_kr[$seq])) {
         $update_fields[] = " pj_title_kr = '" . sql_real_escape_string(trim($pj_title_kr[$seq])) . "' ";
    }
    // 현장명(영문) - menu4_list.php에도 해당 input이 있어야 함
    if (isset($pj_title_en[$seq])) {
         $update_fields[] = " pj_title_en = '" . sql_real_escape_string(trim($pj_title_en[$seq])) . "' ";
    }

    // 업데이트할 필드가 하나라도 있는 경우에만 쿼리 실행
    if (!empty($update_fields)) {
        // UPDATE 쿼리 생성
        $sql = " UPDATE {$none['worksite']} SET ";
        $sql .= implode(', ', $update_fields); // 필드들을 쉼표로 연결
        // 수정 시간 업데이트 (선택 사항)
        $sql .= ", nw_updatetime = '" . G5_TIME_YMDHIS . "' ";
        $sql .= ", nw_ip = '" . $_SERVER['REMOTE_ADDR'] . "' "; // 수정 IP 기록 (선택 사항)
        $sql .= " WHERE seq = '{$seq}' ";

        //echo $sql . "<br>"; // 디버깅용

        $result = sql_query($sql);

        if ($result) {
            $success_count++;
        } else {
            $fail_count++;
            $sql_error = sql_error(); // 오류 메시지 가져오기
            $error_messages[] = "현장 ID {$seq} 업데이트 실패: " . $sql_error;
            // 오류 로깅 (필요시)
            // error_log("Failed to update worksite seq: {$seq} - " . $sql_error);
        }
    } else {
        // 업데이트할 필드가 없는 경우 (예: 해당 seq에 대한 데이터가 전혀 넘어오지 않음)
        // 필요시 로깅 또는 알림
    }
} // end foreach

// 트랜잭션 종료 (선택 사항)
// if ($fail_count == 0) {
//     sql_query("COMMIT");
// } else {
//     sql_query("ROLLBACK");
// }

// --- 결과 처리 및 리다이렉션 ---

// 이전 페이지 URL 생성 (쿼리 스트링 유지)
$qstr = '';
$redirect_url = './menu4_list.php'; // 기본 리다이렉션 URL

// menu4_list.php에서 넘겨준 파라미터들을 다시 붙여줌
if (isset($_POST['sst'])) $qstr .= '&sst=' . urlencode($_POST['sst']);
if (isset($_POST['sod'])) $qstr .= '&sod=' . urlencode($_POST['sod']);
if (isset($_POST['sfl'])) $qstr .= '&sfl=' . urlencode($_POST['sfl']);
if (isset($_POST['stx'])) $qstr .= '&stx=' . urlencode($_POST['stx']);
if (isset($_POST['page'])) $qstr .= '&page=' . urlencode($_POST['page']);

if (!empty($qstr)) {
    $redirect_url .= '?' . ltrim($qstr, '&'); // 맨 앞의 '&' 제거
}

// 최종 메시지 생성
$message = "총 " . count($seqs) . "건 중 {$success_count}건의 데이터가 성공적으로 수정되었습니다.";
if ($fail_count > 0) {
    $message .= "\\n{$fail_count}건의 데이터 수정 중 오류가 발생했습니다.";
    // 상세 오류 메시지 포함 (선택 사항)
    if (!empty($error_messages)) {
         $message .= "\\n\\n[오류 상세]\\n" . implode("\\n", array_slice($error_messages, 0, 5)); // 최대 5개 오류 표시
         if (count($error_messages) > 5) $message .= "\\n...";
    }
}

// 결과 alert 창을 띄우고 리다이렉션
alert($message, $redirect_url);

?>