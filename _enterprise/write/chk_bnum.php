<?php 
include_once('../../_common.php');

if($is_guest || !$_POST['num']) die('잘못 된 접근입니다.');

$chk = sql_fetch("select count(*) as cnt from {$none['enterprise_list']}  where no_bnum = '$num'");

if($chk['cnt'] > 0) {
	die('y');
}

die('');