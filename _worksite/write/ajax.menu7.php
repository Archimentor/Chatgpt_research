<?php
header("Content-Type: application/json");
include_once('../../_common.php');
define('menu_worksite', true);

if($is_guest) exit; 

if($mode == "company") {
	$row = sql_fetch("select ns_gongjong, ns_btel, ns_manager, ns_manager_tel from {$none['subcontract']} where seq = '{$seq}'");
	//echo "select ns_gongjong, ns_tel, ns_manager, ns_manager_tel from {$none['subcontract']} where seq = '{$seq}'";
	echo json_encode($row);
} else if($mode == "manager") {
	$row = get_member($mb_id, 'mb_hp');
	echo json_encode($row);
}