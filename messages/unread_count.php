<?php
/* 로그인 한 사용자의 안읽은 쪽지 개수만 숫자로 출력 */
require_once $_SERVER['DOCUMENT_ROOT'].'/_common.php';
header('Content-Type: text/plain; charset=utf-8');

if ($is_guest) { echo 0; exit; }

$cnt = sql_fetch("SELECT COUNT(*) AS cnt
                    FROM none_member_message_recipient
                   WHERE receiver_id = '{$member['mb_id']}'
                     AND is_read = 0
                     AND is_archived = 0")['cnt'];
echo (int)$cnt;
