<?php 
include_once('../../_common.php');

if($is_guest) exit;
if(!isset($_POST['type'])) exit;
if(!isset($_POST['subseq'])) exit;
if(!isset($_POST['work_id'])) exit;

if(in_array($type, array('i_price1', 'i_price2', 'i_price3'))) {
	$data = str_replace(',', '', $_POST['data']);
}

switch($type) {
	case "i_price1" :
	$filed = "ns_price1";
	break;
	case "i_price2" :
	$filed = "ns_price2";
	break;
	case "i_price3" :
	$filed = "ns_price3";
	break;
	case "contract" :
	$filed = "ns_gubun";
	break;
	case "license1" :
	$filed = "ns_license1";
	break;
	case "license2" :
	$filed = "ns_license2";
	break;
}

//데이터가 없을 경우 업데이트하지 않음.
if($data == '') die('n');

$chk = sql_fetch("select * from {$none['statistics4']} where work_id = '$work_id' and subseq = '$subseq' ");

$sql_common = " {$filed} = '$data' ";

if($chk) {
	$sql = "update {$none['statistics4']} set {$sql_common} where work_id = '$work_id' and subseq = '$subseq'";
} else {
	$sql = "insert into {$none['statistics4']} set {$sql_common}, work_id = '$work_id', subseq = '$subseq', mb_id = '{$member['mb_id']}'";
}

if(sql_query($sql, true)) {
	die('y');
} else {
	die('n');
}