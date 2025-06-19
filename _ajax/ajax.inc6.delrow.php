<?php
// 파일 위치: /www/_ajax/ajax.inc6.delrow.php

// --- 기본 설정 파일 Include ---
// 이 파일 기준 상위 폴더(../)의 _common.php 를 포함
include_once('../_common.php');

// _common.php 로드 및 필수 함수 확인
if (!function_exists('sql_query')) {
    // 간단한 텍스트 오류 메시지 출력 (JavaScript에서 텍스트 응답을 예상)
    echo '삭제 오류: 기본 설정 로드 실패';
    exit;
}

// --- 로그인 및 권한 확인 ---
if ($is_guest) { // $is_guest 변수가 _common.php 등에서 정의되어야 함
    echo '삭제 오류: 로그인이 필요합니다.';
    exit;
}
// 필요한 경우 추가 권한 체크 로직
// 예: if (!check_permission(...)) { echo '삭제 오류: 권한 없음'; exit; }

// --- 전달받은 seq 값 확인 ---
$seq = isset($_POST['seq']) ? intval($_POST['seq']) : 0;

if ($seq <= 0) {
    echo '삭제 오류: 잘못된 요청입니다. (seq 누락 또는 오류)';
    exit;
}

// --- 테이블명 확인 ---
$imprest_table = isset($none['est_imprest']) ? $none['est_imprest'] : null;
if (!$imprest_table) {
     echo '삭제 오류: 테이블 정보를 찾을 수 없습니다.';
     exit;
}

// --- 데이터베이스 삭제 처리 ---
// seq 값은 위에서 intval 로 정수화했으므로 SQL Injection 위험 적음
$sql = "DELETE FROM {$imprest_table} WHERE seq = {$seq}";
$result = sql_query($sql);

if ($result) {
    // 성공 시 'y' 출력 (JavaScript에서 'y'를 확인)
    echo 'y';
} else {
    // 실패 시 오류 메시지 출력
    echo '삭제 실패'; // 간단한 메시지
    // 또는 디버깅 시 상세 오류 출력 (운영 환경에서는 비활성화 권장)
    // echo '삭제 실패: ' . sql_error();
}

exit; // 스크립트 종료
?>