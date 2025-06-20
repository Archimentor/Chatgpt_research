<?php
/**
 * 일괄 첨부파일 삭제 (_establishment/write/data_delete.php)
 * GET : seq, date(yyyy-mm-dd)
 *
 * 1) 게시판 첨부파일 삭제
 * 2) est_% 테이블 모든 'file' 포함 컬럼 첨부파일 삭제
 * 3) none_est_noim_file 등 별도 테이블 처리
 */

include_once('../../_common.php');
if($is_guest) alert('로그인 후 이용바랍니다.');

// ───── 파라미터 ─────
$seq  = isset($_GET['seq'])  ? preg_replace('/[^0-9]/','',$_GET['seq'])  : '';
$date = isset($_GET['date']) ? preg_replace('/[^0-9-]/','',$_GET['date']) : '';
if(!$seq || !$date) alert('잘못된 접근입니다.');

$uid = $seq . str_replace('-','',$date);
$work = sql_fetch("SELECT nw_code FROM {$none['worksite']} WHERE seq='{$seq}'");
$nw_code = $work['nw_code'];

// 삭제 개수 카운트
$deleted = 0;

// ───── 1. 게시판 첨부 ─────
$sql = "SELECT seq, bo_table, bf_file
          FROM {$g5['board_file_table']}
         WHERE bo_table LIKE 'est_%'
           AND (wr_id='{$uid}' OR bf_change_id='{$uid}')
           AND bf_est_date='{$date}'";

$rs = sql_query($sql);
while($row = sql_fetch_array($rs)){
    $path = NONE_PATH."/_data/est/{$row['bo_table']}/{$row['bf_file']}";
    if(file_exists($path) && @unlink($path)) $deleted++;
    sql_query("DELETE FROM {$g5['board_file_table']} WHERE seq='{$row['seq']}'");
}

// ───── 2. est_% 테이블 자동 탐색 ─────
$tbl_rs = sql_query("SHOW TABLES LIKE '".NONE_TABLE_PREFIX."est_%'");
while($tbl = sql_fetch_row($tbl_rs)){
    $table = $tbl[0];

    // file 컬럼 찾기
    $col_rs = sql_query("SHOW COLUMNS FROM {$table} LIKE '%file%'");
    $file_cols = [];
    while($col = sql_fetch_row($col_rs)){
        $file_cols[] = $col[0];
    }
    if(!count($file_cols)) continue;

    // 데이터 조회
    $col_list = implode(',', $file_cols);
    // 컬럼 ne_date 존재 여부 확인
    $has_date = sql_fetch("SHOW COLUMNS FROM {$table} LIKE 'ne_date'") ? true : false;
    $has_nw   = sql_fetch("SHOW COLUMNS FROM {$table} LIKE 'nw_code'") ? true : false;
    $where = [];
    if($has_nw)   $where[] = "nw_code='{$nw_code}'";
    if($has_date) $where[] = "ne_date='{$date}'";
    if(!count($where)) continue;

    $w_sql = implode(' AND ', $where);

    // 업로드 폴더 기본 이름 (none_est_noim -> noim)
    $dir_base = preg_replace('/^'.preg_quote(NONE_TABLE_PREFIX, '/').'est_/', '', $table);

    // ne_type 컬럼 존재 여부
    $has_type = sql_fetch("SHOW COLUMNS FROM {$table} LIKE 'ne_type'") ? true : false;

    $select_cols = $col_list;
    if($has_type) $select_cols .= ',ne_type';
    $data_rs = sql_query("SELECT {$select_cols} FROM {$table} WHERE {$w_sql}");

    while($row = sql_fetch_array($data_rs)){
        $dir = ($table == $none['est_noim'] && $has_type && $row['ne_type']=='2') ? 'noim2' : $dir_base;
        foreach($file_cols as $c){
            if(empty($row[$c])) continue;
            $fp = NONE_PATH."/_data/{$dir}/{$nw_code}/".$row[$c];
            if(file_exists($fp) && @unlink($fp)) $deleted++;
        }
    }
    // DB 초기화
    $sets = implode("='', ", $file_cols)."=''";
    sql_query("UPDATE {$table} SET {$sets} WHERE {$w_sql}");
}

// ───── 3. 용역회사 보조파일 ─────
$sql = "SELECT seq FROM {$none['est_noim']}
        WHERE nw_code='{$nw_code}' AND ne_date='{$date}' AND ne_type='2'";
$rs2 = sql_query($sql);
while($row = sql_fetch_array($rs2)){
    $files = sql_fetch("
        SELECT ne_file3, ne_file4 FROM none_est_noim_file
         WHERE noim_seq='{$row['seq']}' AND ne_date='{$date}'");
    if(!$files) continue;

    foreach(['ne_file3','ne_file4'] as $f){
        if(!$files[$f]) continue;
        $p = NONE_PATH."/_data/noim2/{$nw_code}/".$files[$f];
        if(file_exists($p) && @unlink($p)) $deleted++;
    }
    sql_query("DELETE FROM none_est_noim_file
               WHERE noim_seq='{$row['seq']}' AND ne_date='{$date}'");
}

// ───── 결과 ─────
alert("총 {$deleted}개 파일을 삭제했습니다.", './menu1_list.php?date='.urlencode($date));
?>
