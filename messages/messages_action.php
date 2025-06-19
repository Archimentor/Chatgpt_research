<?php
// ─── 1) 개발용 에러 출력 켜기 ───────────────────────────────────
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ─── 2) 공통 설정 로드 ───────────────────────────────────────
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/common.php';

// ─── 3) 로그인 확인 ───────────────────────────────────────────
if ($is_guest) {
    goto_url('/member/login.php');
}

// ─── 4) 파라미터 검사 ─────────────────────────────────────────
$action = isset($_POST['action']) ? $_POST['action'] : '';
$msg_id = isset($_POST['msg_id']) ? (int)$_POST['msg_id'] : 0;
$user   = $member['mb_id'];

if ($msg_id <= 0 || ! in_array($action, ['archive','delete'])) {
    alert('잘못된 요청입니다.', '/messages/list.php');
}

// ─── 5) 액션 처리 ─────────────────────────────────────────────
if ($action === 'archive') {
    // 보관함으로 이동 (is_archived = 1)
    sql_query("
      UPDATE none_member_message_recipients
         SET is_archived = 1
       WHERE msg_id       = '{$msg_id}'
         AND receiver_id  = '{$user}'
    ");
    alert('쪽지를 보관함으로 이동했습니다.', '/messages/list.php');
}
else {
    // 완전 삭제
    sql_query("
      DELETE FROM none_member_message_recipients
       WHERE msg_id       = '{$msg_id}'
         AND receiver_id  = '{$user}'
    ");
    alert('쪽지를 삭제했습니다.', '/messages/list.php');
}
