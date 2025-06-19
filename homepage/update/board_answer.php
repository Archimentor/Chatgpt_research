<?php
include_once('../../_common.php');

//본사직원일경우 관리자 권한 부여
if($member['mb_level2'] == 1  || $member['mb_level2'] == 3 ) $is_admin = true; 

if(!$is_admin) alert('권한이 없습니다.');


sql_query("update {$none['home_board']} set wr_answer = '$wr_answer' where bo_table = '$bo_table' and seq = '$seq' ");


alert('답변이 작성되었습니다.');