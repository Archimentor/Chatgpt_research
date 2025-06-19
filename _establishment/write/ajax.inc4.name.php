<?php 
include_once('../../_common.php');

if($type == "search") {
	
	$sql = "select * from {$none['est_noim']} where ne_date <= '{$date}'  and nw_code = '{$code}' and ne_name LIKE '%$value%' and ne_type=1 order by ne_name asc";
	
	$rst = sql_query($sql);
	for($i=0;$row=sql_fetch_array($rst); $i++) {
		
		
		$data[$i]['name'] = $row['ne_name']."(".$row['ne_num'].")"; 
		
		
		$data[$i]['rname'] = $row['ne_name']; 
		$data[$i]['num'] = $row['ne_num']; 
		$data[$i]['addr1'] = $row['ne_addr1'];
		$data[$i]['gongjong'] = $row['ne_gongjong'];
		$data[$i]['addr2'] = $row['ne_addr2'];
		$data[$i]['hp'] = $row['ne_hp'];
		$data[$i]['bank'] = $row['ne_bank'];
		$data[$i]['account'] = $row['ne_account'];
		$data[$i]['accname'] = $row['ne_holder'];
		
	
		
	}
	echo json_encode($data);
	
	
} else if($type == "company") {
	
	$row = sql_fetch("select * from {$none['est_noim']} where seq = '$seq' and ne_type=2 ");

		
	$data['rname'] = $row['ne_name']; 
	$data['num'] = $row['ne_num']; 
	$data['addr1'] = $row['ne_addr1'];
	$data['gongjong'] = $row['ne_gongjong'];
	$data['addr2'] = $row['ne_addr2'];
	$data['hp'] = $row['ne_hp'];
	$data['bank'] = $row['ne_bank'];
	$data['account'] = $row['ne_account'];
	$data['accname'] = $row['ne_holder'];
		
	
		
	echo json_encode($data);
}