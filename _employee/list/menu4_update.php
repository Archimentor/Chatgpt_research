<?php 
include_once('../../_common.php');
define('menu_employee', true);


if($w == 'i') {
	
	
	$order = sql_fetch("select MAX(nm_order) as nm_order from {$none['member_position_list']}");
	$next_order = $order['nm_order']+1; //제일마지막에 추가하기 위해 
	
	$insert = "insert  {$none['member_position_list']}  set nm_name = '{$_POST['nm_name']}', nm_order = '{$next_order}' ";
	sql_query($insert, true);
	
	
	alert('직급 정보가 추가되었습니다.');


} else if($w == "u") {

	for($i=0; $i<count($_POST['seq']); $i++) {
		
		
		$update = "update  {$none['member_position_list']}  set nm_name = '{$_POST['nm_name'][$i]}', nm_order = '{$_POST['nm_order'][$i]}' where seq = '{$_POST['seq'][$i]}'";
		sql_query($update, true);
	}
	
	alert('직급 정보가 업데이트되었습니다.');
	
} else if($w == "d") {
	
	$delete = "delete from  {$none['member_position_list']} where seq = '$seq' ";
	sql_query($delete, true);
	
	
	alert('직급 정보가 삭제되었습니다.');
	
}