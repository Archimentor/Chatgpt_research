<?php
// 공통 부트스트랩 ─ 모든 API의 최상단에서 include
require_once $_SERVER['DOCUMENT_ROOT'].'/core/common.php';  // 기존 DB 접속 설정
require_once $_SERVER['DOCUMENT_ROOT'].'/_common.php';      // $none[] 테이블 상수들
require_once __DIR__.'/utils.php';
require_once __DIR__.'/auth.php';

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();   // 로그인 세션(`ss_mb_id`) 재사용 :contentReference[oaicite:3]{index=3}
}
?>
