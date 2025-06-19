<?php
// ajax.inc6.delrow.php
// 예: /_establishment/write/ajax.inc6.delrow.php
include_once('../../_common.php'); // 경로를 실제 위치에 맞게 수정

// 로그인 체크, 권한 체크
// if ($is_guest) { echo ""; exit; }

$seq = isset($_POST['seq']) ? intval($_POST['seq']) : 0;
if ($seq <= 0) {
    // 잘못된 seq
    echo "seq 오류";
    exit;
}

// 권한 로직 (예: 작성자 또는 관리자만 가능) 생략 or 추가

// 삭제 쿼리
$sql = "DELETE FROM {$none['est_imprest']} WHERE seq = '$seq'";
$res = sql_query($sql);
if ($res) {
    // 성공 시 'y'
    echo 'y';
} else {
    // 실패 시 오류 메시지
    echo '삭제 실패';
}
