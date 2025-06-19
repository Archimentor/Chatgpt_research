<?php 
include_once('../../_common.php');


$row = sql_fetch("select * from {$none['home_project']} where nw_code = '$nw_code'");

if($row) {
	die('이미 등록 된 현장입니다.');
}

?>