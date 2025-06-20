<?php
include_once('../../_common.php');

if(isset($is_guest) && $is_guest) alert('로그인 후 이용바랍니다.');

/* ---------- 파라미터 ---------- */
$seq = isset($_GET['seq']) ? preg_replace('/[^0-9]/', '', $_GET['seq']) : '';
if(!$seq) alert('잘못된 접근입니다.');

/* ---------- 현장 코드 ---------- */
$work    = sql_fetch("SELECT nw_code FROM {$none['worksite']} WHERE seq = '{$seq}'");
$nw_code = isset($work['nw_code']) ? $work['nw_code'] : '';

/* ---------- 게시판 첨부 삭제 (est_*) ---------- */
$sql = "
  SELECT seq, bo_table, bf_file
    FROM {$g5['board_file_table']}
   WHERE bo_table LIKE 'est_%'
     AND (wr_id LIKE '{$seq}%' OR bf_change_id LIKE '{$seq}%')";
$rs = sql_query($sql);

while($row = sql_fetch_array($rs)) {
    $path = NONE_PATH.'/_data/est/'.$row['bo_table'].'/'.$row['bf_file'];
    if(is_file($path)) @unlink($path);
    sql_query("DELETE FROM {$g5['board_file_table']} WHERE seq = '{$row['seq']}'");
}

/* ---------- 노임 인부정보 ---------- */
$sql = "
  SELECT ne_file1, ne_file2, ne_file3
    FROM {$none['est_noim']}
   WHERE nw_code = '{$nw_code}' AND ne_type = '1'";
$r = sql_query($sql);

while($row = sql_fetch_array($r)){
    foreach(array('ne_file1','ne_file2','ne_file3') as $f){
        if($row[$f]){
            $p = NONE_PATH."/_data/noim/{$nw_code}/".$row[$f];
            if(is_file($p)) @unlink($p);
        }
    }
}
sql_query("
  UPDATE {$none['est_noim']}
     SET ne_file1='', ne_file2='', ne_file3=''
   WHERE nw_code = '{$nw_code}' AND ne_type='1'");

/* ---------- 노임 용역회사 ---------- */
$sql = "
  SELECT seq, ne_file1, ne_file2
    FROM {$none['est_noim']}
   WHERE nw_code = '{$nw_code}' AND ne_type = '2'";
$r = sql_query($sql);

while($row = sql_fetch_array($r)){
    foreach(array('ne_file1','ne_file2') as $f){
        if($row[$f]){
            $p = NONE_PATH."/_data/noim2/{$nw_code}/".$row[$f];
            if(is_file($p)) @unlink($p);
        }
    }

    $file = sql_fetch("
      SELECT ne_file3, ne_file4
        FROM none_est_noim_file
       WHERE noim_seq = '{$row['seq']}'");
    if($file){
        foreach(array('ne_file3','ne_file4') as $f){
            if($file[$f]){
                $p = NONE_PATH."/_data/noim2/{$nw_code}/".$file[$f];
                if(is_file($p)) @unlink($p);
            }
        }
        sql_query("DELETE FROM none_est_noim_file WHERE noim_seq = '{$row['seq']}'");
    }
}
sql_query("
  UPDATE {$none['est_noim']}
     SET ne_file1='', ne_file2=''
   WHERE nw_code = '{$nw_code}' AND ne_type='2'");

alert('모든 날짜의 첨부파일이 삭제되었습니다.','./menu1_list.php');
?>
