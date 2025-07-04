<?php
require_once __DIR__.'/../common/init.php';
api_require_login();

$method = $_SERVER['REQUEST_METHOD'];
$table  = $none['owner_list']; // 건축주 테이블

switch ($method) {

/* ───────────── 건축주 목록 조회 ───────────── */
case 'GET':
    $stx = trim($_GET['search'] ?? '');

    $sql = "SELECT * FROM {$table} WHERE 1";
    if ($stx) {
        $esc = sql_escape_string($stx);
        $sql .= " AND ( no_company LIKE '%{$esc}%'".
                " OR no_name LIKE '%{$esc}%'".
                " OR no_tel LIKE '%{$esc}%'".
                " OR no_hp LIKE '%{$esc}%'".
                " OR no_baddr LIKE '%{$esc}%')";
    }
    $sql .= " ORDER BY seq DESC";

    $res = sql_query($sql);
    $rows = [];
    while ($row = sql_fetch_array($res)) $rows[] = $row;

    api_json(['owners' => $rows]);
    break;

/* ───────────── 신규 건축주 등록 ───────────── */
case 'POST':
    $in = api_input();
    if (empty($in['no_name']) && empty($in['no_company']))
        api_json(['error'=>'필수값 누락'], 400);

    $fields = [
        'no_id_1','no_id_2','no_id_3','no_company','no_bnum','no_baddr',
        'no_bemail','no_name','no_jumin','no_tel','no_hp','no_email',
        'no_addr','no_memo'
    ];
    $set = [];
    foreach ($fields as $f) {
        if (isset($in[$f]))
            $set[] = "$f = '".sql_escape_string($in[$f])."'";
    }
    $set[] = "no_datetime = '".G5_TIME_YMDHIS."'";
    $set[] = "no_ip = '".$_SERVER['REMOTE_ADDR']."'";

    sql_query("INSERT INTO {$table} SET ".implode(',', $set), true);
    api_json(['result'=>'created']);
    break;

/* ───────────── 건축주 정보 수정 ───────────── */
case 'PUT':
    $in = api_input();
    if (empty($in['seq'])) api_json(['error'=>'seq 필요'], 400);

    $fields = [
        'no_id_1','no_id_2','no_id_3','no_company','no_bnum','no_baddr',
        'no_bemail','no_name','no_jumin','no_tel','no_hp','no_email',
        'no_addr','no_memo'
    ];
    $set = [];
    foreach ($fields as $f) {
        if (isset($in[$f]))
            $set[] = "$f = '".sql_escape_string($in[$f])."'";
    }
    if (!$set) api_json(['error'=>'수정할 필드 없음'], 400);
    sql_query("UPDATE {$table} SET ".implode(',', $set)." WHERE seq = '".sql_escape_string($in['seq'])."'", true);
    api_json(['result'=>'updated']);
    break;

/* ───────────── 건축주 삭제 ───────────── */
case 'DELETE':
    parse_str(file_get_contents('php://input'), $del);
    if (empty($del['seq'])) api_json(['error'=>'seq 필요'], 400);

    sql_query("DELETE FROM {$table} WHERE seq = '".sql_escape_string($del['seq'])."'", true);
    api_json(['result'=>'deleted']);
    break;

default:
    api_json(['error'=>'지원하지 않는 메서드'], 405);
}
?>
