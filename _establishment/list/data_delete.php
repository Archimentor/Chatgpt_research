<?php
include_once('../../_common.php');

if($is_guest) alert('로그인 후 이용바랍니다.');

$seq = isset($_GET['seq']) ? preg_replace('/[^0-9]/', '', $_GET['seq']) : '';
$date = isset($_GET['date']) ? preg_replace('/[^0-9-]/', '', $_GET['date']) : '';

if(!$seq || !$date) {
    alert('잘못된 접근입니다.');
}

$uid = $seq . str_replace('-', '', $date);

$sql = "SELECT * FROM {$g5['board_file_table']} WHERE bo_table LIKE 'est_%' AND (wr_id = '{$uid}' OR bf_change_id = '{$uid}') AND bf_est_date = '{$date}'";
$result = sql_query($sql);
while($row = sql_fetch_array($result)) {
    $filepath = NONE_PATH.'/_data/est/'.$row['bo_table'].'/'.$row['bf_file'];
    if(file_exists($filepath)) @unlink($filepath);
    sql_query("DELETE FROM {$g5['board_file_table']} WHERE seq = '{$row['seq']}'");
}

alert('첨부파일이 모두 삭제되었습니다.', './menu1_list.php?date=' . urlencode($date));
?>
