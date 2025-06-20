<?php
/**
 * 첨부파일 일괄삭제(디렉터리 자동 탐색)
 *
 * 1. 게시판 파일
 * 2. est_% 테이블 파일
 * ‑ 파일명이 어디에 저장돼 있든, 실제 업로드 디렉터리를
 *   _data/*/{nw_code}/ 또는 _data/est/*/ 로 glob 검색해 찾는다.
 *
 *  파일 못 찾으면 log 배열에 남김.
 */
include_once('../../_common.php');
if($is_guest) alert('로그인 후 이용바랍니다.');

$seq  = preg_replace('/[^0-9]/','',$_GET['seq'] ?? '');
$date = preg_replace('/[^0-9-]/','',$_GET['date'] ?? '');
if(!$seq||!$date) alert('잘못된 접근입니다.');

$uid = $seq.str_replace('-','',$date);
$nw_code = sql_fetch("SELECT nw_code FROM {$none['worksite']} WHERE seq='{$seq}'")['nw_code'];

$deleted = 0; $miss = [];

/** 파일 실제 삭제 */
function rm_file($filename,$nw_code,&$deleted,&$miss){
    if(!$filename) return;
    $cands = glob(NONE_PATH."/_data/*/{$nw_code}/{$filename}");
    $cands = array_merge($cands, glob(NONE_PATH."/_data/est/*/{$filename}"));
    $found = false;
    foreach($cands as $f){
        if(file_exists($f) && @unlink($f)) { $deleted++; $found=true; }
    }
    if(!$found) $miss[] = $filename;
}

// ─ 1. board_file
$rs = sql_query("SELECT seq, bf_file, bo_table
   FROM {$g5['board_file_table']}
  WHERE bo_table LIKE 'est_%'
    AND (wr_id='{$uid}' OR bf_change_id='{$uid}')
    AND bf_est_date='{$date}'");
while($r=sql_fetch_array($rs)){
    rm_file($r['bf_file'],$nw_code,$deleted,$miss);
    sql_query("DELETE FROM {$g5['board_file_table']} WHERE seq='{$r['seq']}'");
}

// ─ 2. est_% tables
$tbl_rs = sql_query("SHOW TABLES LIKE 'est_%'");
while($t = sql_fetch_row($tbl_rs)){
    $table = $t[0];
    $col_rs = sql_query("SHOW COLUMNS FROM {$table} LIKE '%file%'");
    $cols=[]; while($c=sql_fetch_row($col_rs)) $cols[]=$c[0];
    if(!$cols) continue;

    $has_nw = sql_fetch("SHOW COLUMNS FROM {$table} LIKE 'nw_code'")?true:false;
    $has_dt = sql_fetch("SHOW COLUMNS FROM {$table} LIKE 'ne_date'")?true:false;
    $cond=[];
    if($has_nw) $cond[]="nw_code='{$nw_code}'";
    if($has_dt) $cond[]="ne_date='{$date}'";
    if(!$cond) continue;
    $where = implode(' AND ',$cond);

    $col_list = implode(',',$cols);
    $drs = sql_query("SELECT {$col_list} FROM {$table} WHERE {$where}");
    while($row=sql_fetch_array($drs)){
        foreach($cols as $c) rm_file($row[$c],$nw_code,$deleted,$miss);
    }
    $sets = implode("='', ",$cols)."=''";
    sql_query("UPDATE {$table} SET {$sets} WHERE {$where}");
}

// ─ 3. 추가 파일 테이블
$rs = sql_query("SELECT ne_file3, ne_file4
   FROM none_est_noim_file nf
   JOIN {$none['est_noim']} n ON n.seq=nf.noim_seq
  WHERE n.nw_code='{$nw_code}' AND n.ne_date='{$date}' AND n.ne_type='2'");
while($r=sql_fetch_array($rs)){
    foreach(['ne_file3','ne_file4'] as $f) rm_file($r[$f],$nw_code,$deleted,$miss);
}
sql_query("DELETE nf FROM none_est_noim_file nf
           JOIN {$none['est_noim']} n ON n.seq=nf.noim_seq
           WHERE n.nw_code='{$nw_code}' AND n.ne_date='{$date}' AND n.ne_type='2'");

$msg = "삭제 완료 : {$deleted}개";
if($miss) $msg .= "\n찾지 못한 파일 : ".implode(', ',$miss);
alert($msg, './menu1_list.php?date='.urlencode($date));
?>
