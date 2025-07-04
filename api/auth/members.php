<?php
require_once __DIR__.'/../common/init.php';
api_require_login();

$method = $_SERVER['REQUEST_METHOD'];
$g5_table = $g5['member_table'];      // 기존 그누보드 회원 테이블

switch ($method) {

/* ───────────── 직원 목록 조회 ───────────── */
case 'GET':
    $team  = $_GET['team']  ?? 'all';
    $stx   = $_GET['search'] ?? '';

    // menu1_list.php 의 기본 WHERE 조건 차용 :contentReference[oaicite:7]{index=7}
    $sql = "SELECT mb_id, mb_name, mb_hp, mb_email, mb_level2, mb_2 AS dept
              FROM {$g5_table}
             WHERE mb_level = 10
               AND mb_id <> 'admin'
               AND mb_level2 != 4";

    if ($team !== 'all') $sql .= " AND mb_2 = '".sql_escape_string($team)."'";

    if ($stx)
        $sql .= " AND ( mb_name LIKE '%{$stx}%' OR mb_id LIKE '%{$stx}%' OR mb_hp LIKE '%{$stx}%' )";

    $sql .= " ORDER BY mb_name";

    $result = sql_query($sql);
    $rows = [];
    while ($row = sql_fetch_array($result)) $rows[] = $row;

    api_json(['members'=>$rows]);
    break;

/* ───────────── 신규 직원 등록 ───────────── */
case 'POST':
    $in = api_input();
    if (empty($in['mb_id']) || empty($in['mb_password']) || empty($in['mb_name']))
        api_json(['error'=>'필수값 누락'], 400);

    // menu1_update.php 신규 INSERT 로직 차용 :contentReference[oaicite:8]{index=8}
    $sql_common = "
        mb_id       = '".sql_escape_string($in['mb_id'])."',
        mb_password = '".get_encrypt_string($in['mb_password'])."',
        mb_name     = '".sql_escape_string($in['mb_name'])."',
        mb_level    = 10,
        mb_level2   = '".(int)($in['mb_level2'] ?? 3)."',
        mb_hp       = '".sql_escape_string($in['mb_hp'] ?? '')."',
        mb_email    = '".sql_escape_string($in['mb_email'] ?? '')."',
        mb_2        = '".sql_escape_string($in['dept'] ?? '')."',
        mb_in_date  = '".sql_escape_string($in['mb_in_date'] ?? '')."',
        mb_birth    = '".sql_escape_string($in['mb_birth'] ?? '')."',
        mb_datetime = '".G5_TIME_YMDHIS."',
        mb_ip       = '".$_SERVER['REMOTE_ADDR']."'";

    sql_query("INSERT INTO {$g5_table} SET {$sql_common}", true);

    api_json(['result'=>'created']);
    break;

/* ───────────── 직원 정보 수정 ───────────── */
case 'PUT':
    $in = api_input();
    if (empty($in['mb_id'])) api_json(['error'=>'mb_id 필요'], 400);

    $set = [];
    foreach (['mb_name','mb_hp','mb_email','dept'=>'mb_2','mb_level2','mb_in_date','mb_out_date','mb_birth'] as $k=>$col) {
        $key = is_int($k) ? $col : $k;
        if (isset($in[$key]))
            $set[] = $col." = '".sql_escape_string($in[$key])."'";
    }
    if (isset($in['mb_password']) && $in['mb_password'])
        $set[] = "mb_password = '".get_encrypt_string($in['mb_password'])."'";

    if (!$set) api_json(['error'=>'수정할 필드 없음'], 400);

    sql_query("UPDATE {$g5_table} SET ".implode(',', $set)." WHERE mb_id = '".sql_escape_string($in['mb_id'])."'", true);

    api_json(['result'=>'updated']);
    break;

/* ───────────── 직원 삭제 ───────────── */
case 'DELETE':
    parse_str(file_get_contents('php://input'), $del);
    if (empty($del['mb_id'])) api_json(['error'=>'mb_id 필요'], 400);

    // 실제 운영에서는 물리삭제 대신 mb_level2=4(퇴사) 처리 권장
    api_json(['error'=>'삭제는 정책상 금지']);   // 필요 시 로직 추가
    break;

default:
    api_json(['error'=>'지원하지 않는 메서드'], 405);
}
