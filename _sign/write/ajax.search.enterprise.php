<?php 
include_once('../../_common.php');

if($type == "search") {
	
	$sql = "select * from {$none['enterprise_list']} where no_company LIKE '%$value%'  order by seq desc ";
	$rst = sql_query($sql);
	
	for($i=0;$row=sql_fetch_array($rst); $i++) {
		$data[$i]['name'] = $row['no_company']; 
		$data[$i]['tel'] = $row['no_btel']; 
		$data[$i]['bname'] = $row['no_bname']; 
		$data[$i]['person_name'] = $row['no_name']; 
		if($row['no_bank']) {
			$data[$i]['account1'] = $row['no_bank']; 
			$data[$i]['account2'] = $row['no_account'];
			$data[$i]['account3'] = $row['no_acc_holder']; 
		} else {
			$data[$i]['account1'] = "";
			$data[$i]['account2'] = "";
			$data[$i]['account3'] = "";
		}
		
	}
	echo json_encode($data);
	
	
} else if($type == "select") {
	
}