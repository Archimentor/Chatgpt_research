<?php
include_once('../../_common.php');

if($is_guest) alert('로그인 후 이용바랍니다.');

$seq = isset($_GET['seq']) ? preg_replace('/[^0-9]/', '', $_GET['seq']) : '';
$date = isset($_GET['date']) ? preg_replace('/[^0-9-]/', '', $_GET['date']) : '';

if(!$seq || !$date) {
    alert('잘못된 접근입니다.');
}

$uid = $seq . str_replace('-', '', $date);

// 현장 코드 조회
$work = sql_fetch("select nw_code from {$none['worksite']} where seq = '{$seq}'");
$nw_code = $work['nw_code'];

$sql = "SELECT * FROM {$g5['board_file_table']} WHERE bo_table LIKE 'est_%' AND (wr_id = '{$uid}' OR bf_change_id = '{$uid}') AND bf_est_date = '{$date}'";
$result = sql_query($sql);
while($row = sql_fetch_array($result)) {
    $filepath = NONE_PATH.'/_data/est/'.$row['bo_table'].'/'.$row['bf_file'];
    if(file_exists($filepath)) @unlink($filepath);
    sql_query("DELETE FROM {$g5['board_file_table']} WHERE seq = '{$row['seq']}'");
}

// 첨부파일이 있는 하위 테이블 정의
$tables = [
    [
        'table' => $none['est_noim'],
        'cols'  => ['ne_file1','ne_file2','ne_file3'],
        'dir'   => 'noim',
        'where' => "nw_code='{$nw_code}' and ne_date='{$date}' and ne_type='1'"
    ],
    [
        'table' => $none['est_noim'],
        'cols'  => ['ne_file1','ne_file2'],
        'dir'   => 'noim2',
        'where' => "nw_code='{$nw_code}' and ne_date='{$date}' and ne_type='2'"
    ],
    [
        'table' => $none['est_material'],
        'cols'  => ['ne_file1','ne_file2','ne_file3'],
        'dir'   => 'material',
        'where' => "nw_code='{$nw_code}' and ne_date='{$date}'"
    ],
    [
        'table' => $none['est_equipment'],
        'cols'  => ['ne_file1','ne_file2','ne_file3'],
        'dir'   => 'equipment',
        'where' => "nw_code='{$nw_code}' and ne_date='{$date}'"
    ],
    [
        'table' => $none['est_etc'],
        'cols'  => ['ne_file1','ne_file2','ne_file3'],
        'dir'   => 'etc',
        'where' => "nw_code='{$nw_code}' and ne_date='{$date}'"
    ],
];

foreach($tables as $info) {
    $col_list = implode(',', $info['cols']);
    $sql  = "select {$col_list} from {$info['table']} where {$info['where']}";
    $rst  = sql_query($sql);
    while($row = sql_fetch_array($rst)) {
        foreach($info['cols'] as $c) {
            if(empty($row[$c])) continue;
            $fp = NONE_PATH."/_data/{$info['dir']}/{$nw_code}/".$row[$c];
            if(file_exists($fp)) @unlink($fp);
        }
    }
    $set = implode("='', ", $info['cols'])."=''";
    sql_query("update {$info['table']} set {$set} where {$info['where']}");
}

// 노임 용역회사 추가 파일 삭제 처리
$sql = "select seq from {$none['est_noim']} where nw_code = '{$nw_code}' and ne_date = '{$date}' and ne_type='2'";
$rst = sql_query($sql);
while($row = sql_fetch_array($rst)) {
    $file = sql_fetch("select ne_file3, ne_file4 from none_est_noim_file where noim_seq = '{$row['seq']}' and ne_date = '{$date}'");
    if(!$file) continue;
    foreach(['ne_file3','ne_file4'] as $f) {
        if($file[$f]) {
            $fp = NONE_PATH."/_data/noim2/{$nw_code}/".$file[$f];
            if(file_exists($fp)) @unlink($fp);
        }
    }
    sql_query("delete from none_est_noim_file where noim_seq = '{$row['seq']}' and ne_date = '{$date}'");
}

alert('첨부파일이 모두 삭제되었습니다.', './menu1_list.php?date=' . urlencode($date));
?>
