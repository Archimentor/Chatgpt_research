<?php
require_once __DIR__.'/../common/init.php';

$data = api_input();
$id   = trim($data['id']   ?? '');
$pw   = trim($data['pw']   ?? '');

if (!$id || !$pw) api_json(['error'=>'아이디/비밀번호를 입력하세요'], 400);

$mb = get_member($id);          // common.lib.php 함수

if (!$mb) api_json(['error'=>'존재하지 않는 아이디'], 401);

// 퇴사(4)·차단·탈퇴 상태는 기존 로직 차용
if ($mb['mb_level2'] == 4) api_json(['error'=>'퇴사 처리된 계정'], 403);
if ($mb['mb_intercept_date'])   api_json(['error'=>'차단된 계정'], 403);
if ($mb['mb_leave_date'])       api_json(['error'=>'탈퇴한 계정'], 403);

// 비밀번호 검사 (원본: login_check.php) :contentReference[oaicite:5]{index=5}
if (!check_password($pw, $mb['mb_password'])) {
    api_json(['error'=>'비밀번호 오류'], 401);
}

// 세션 생성 (login_check.php 와 동일) :contentReference[oaicite:6]{index=6}
$_SESSION['ss_mb_id']  = $mb['mb_id'];
$_SESSION['ss_mb_key'] = md5($mb['mb_datetime'] . get_real_client_ip() . $_SERVER['HTTP_USER_AGENT']);

api_json(['result'=>'ok','user'=>$mb]);
