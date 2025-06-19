<?php 
include_once('../../_common.php');

if($type == "search") {
	
	$sql = "select * from {$none['subcontract']} a LEFT JOIN {$none['enterprise_list']} b ON (a.ns_bname = b.seq) where a.work_id = '{$code}' and b.no_company LIKE '%$value%'  order by a.seq desc ";
	$rst = sql_query($sql);
	for($i=0;$row=sql_fetch_array($rst); $i++) {
		
		$data[$i]['name'] = $row['no_company']; 
		$data[$i]['bname'] = $row['no_bname']; 
		$data[$i]['tel'] = $row['no_btel']; 
		$data[$i]['person_name'] = $row['no_name'];
		$data[$i]['gongjong'] = $row['ns_gongjong'];
		$data[$i]['sdate'] = date('m/d', strtotime($row['ns_sdate']));
		$data[$i]['edate'] = date('m/d', strtotime($row['ns_edate']));
		$data[$i]['price'] = $row['ns_price'];
		$data[$i]['vat'] = $row['ns_vat'];
		$data[$i]['total_price'] = $row['ns_total_price'];
		$data[$i]['bank'] = $row['no_bank'];
		$data[$i]['account'] = $row['no_account'];
		$data[$i]['account'] = $row['no_account'];
		$data[$i]['accname'] = $row['no_acc_holder'];
		$data[$i]['ceo'] = $row['no_acc_holder']."(".$row['no_bname'].")";
		

		if(!$row['no_tel']) {
			$data[$i]['person_tel'] = $row['no_hp']; 
		} else {
			$data[$i]['person_tel'] = $row['no_tel']; 
		}
		
	
		
	}
	echo json_encode($data);
	
	
} else if($type == "select") {
	
}