<?php 
include_once('../../_common.php');
define('menu_employee', true);


if($w == 'i') {
	
	
	$order = sql_fetch("select MAX(nd_order) as nd_order from {$none['department_list']}");
	$next_order = $order['nd_order']+1; //제일마지막에 추가하기 위해 
	
	$insert = "insert  {$none['department_list']}  set nd_name = '{$_POST['nd_name']}', nd_order = '{$next_order}', nd_code = '{$nd_code}' ";
	sql_query($insert, true);
	
	
	alert('부서 정보가 추가되었습니다.');


} else if($w == "u") {

	for($i=0; $i<count($_POST['seq']); $i++) {
		
		
		$update = "update  {$none['department_list']}  set nd_name = '{$_POST['nd_name'][$i]}', nd_order = '{$_POST['nd_order'][$i]}'where seq = '{$_POST['seq'][$i]}'";
		sql_query($update, true);
	}
	
	alert('부서 정보가 업데이트되었습니다.');
	
} else if($w == "d") {
	
	$delete = "delete from  {$none['department_list']} where seq = '$seq' ";
	sql_query($delete, true);
	
	
	alert('부서 정보가 삭제되었습니다.');
	
}