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

// 노임 인부정보 첨부파일 삭제
$sql = "select ne_file1, ne_file2, ne_file3 from {$none['est_noim']} where nw_code = '{$nw_code}' and ne_date = '{$date}' and ne_type = '1'";
$rst = sql_query($sql);
while($row = sql_fetch_array($rst)) {
    foreach(array('ne_file1','ne_file2','ne_file3') as $f) {
        if($row[$f]) {
            $fp = NONE_PATH."/_data/noim/{$nw_code}/".$row[$f];
            if(file_exists($fp)) @unlink($fp);
        }
    }
}
sql_query("update {$none['est_noim']} set ne_file1='', ne_file2='', ne_file3='' where nw_code = '{$nw_code}' and ne_date = '{$date}' and ne_type='1'");

// 노임 용역회사 첨부파일 삭제
$sql = "select seq, ne_file1, ne_file2 from {$none['est_noim']} where nw_code = '{$nw_code}' and ne_date = '{$date}' and ne_type = '2'";
$rst = sql_query($sql);
while($row = sql_fetch_array($rst)) {
    foreach(array('ne_file1','ne_file2') as $f) {
        if($row[$f]) {
            $fp = NONE_PATH."/_data/noim2/{$nw_code}/".$row[$f];
            if(file_exists($fp)) @unlink($fp);
        }
    }
    $file = sql_fetch("select ne_file3, ne_file4 from none_est_noim_file where noim_seq = '{$row['seq']}' and ne_date = '{$date}'");
    if($file) {
        foreach(array('ne_file3','ne_file4') as $f) {
            if($file[$f]) {
                $fp = NONE_PATH."/_data/noim2/{$nw_code}/".$file[$f];
                if(file_exists($fp)) @unlink($fp);
            }
        }
        sql_query("delete from none_est_noim_file where noim_seq = '{$row['seq']}' and ne_date = '{$date}'");
    }
}
sql_query("update {$none['est_noim']} set ne_file1='', ne_file2='' where nw_code = '{$nw_code}' and ne_date = '{$date}' and ne_type='2'");

// 집행내역서 첨부파일 삭제 및 필드 초기화
$table_dirs = array(
    $none['est_material']  => 'material',
    $none['est_equipment'] => 'equipment',
    $none['est_etc']       => 'etc'
);
foreach($table_dirs as $tbl => $dir) {
    $sql = "select ne_file1, ne_file2, ne_file3 from {$tbl} where nw_code = '{$nw_code}' and ne_date = '{$date}'";
    $rst = sql_query($sql);
    while($row = sql_fetch_array($rst)) {
        foreach(array('ne_file1','ne_file2','ne_file3') as $f) {
            if($row[$f]) {
                $fp = NONE_PATH."/_data/{$dir}/{$nw_code}/".$row[$f];
                if(file_exists($fp)) @unlink($fp);
            }
        }
    }
    sql_query("update {$tbl} set ne_file1='', ne_file2='', ne_file3='' where nw_code = '{$nw_code}' and ne_date = '{$date}'");
}
alert('첨부파일이 모두 삭제되었습니다.', './menu1_list.php?date=' . urlencode($date));
?>
