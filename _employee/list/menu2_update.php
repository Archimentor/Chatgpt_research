<?php 
include_once('../../_common.php');
define('menu_employee', true);


if($w == 'i') {
	
	
	$order = sql_fetch("select MAX(nb_order) as nb_order from {$none['branch_list']}");
	$next_order = $order['nb_order']+1; //제일마지막에 추가하기 위해 
	
	$insert = "insert  {$none['branch_list']}  set nb_name = '{$_POST['nb_name']}', nb_order = '{$next_order}' ";
	sql_query($insert, true);
	
	
	alert('지사 정보가 추가되었습니다.');


} else if($w == "u") {

	for($i=0; $i<count($_POST['seq']); $i++) {
		
		
		$update = "update  {$none['branch_list']}  set nb_name = '{$_POST['nb_name'][$i]}', nb_order = '{$_POST['nb_order'][$i]}' where seq = '{$_POST['seq'][$i]}'";
		sql_query($update, true);
	}
	
	alert('지사 정보가 업데이트되었습니다.');
	
} else if($w == "d") {
	
	$delete = "delete from  {$none['branch_list']} where seq = '$seq' ";
	sql_query($delete, true);
	
	
	alert('지사 정보가 삭제되었습니다.');
	
}