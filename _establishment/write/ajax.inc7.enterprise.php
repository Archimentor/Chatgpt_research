<?php 
include_once('../../_common.php');


$row = sql_fetch("select * from {$none['subcontract']} where work_id = '{$nw_code}' and ns_bname = '$id'");



$data['name'] = get_enterprise_txt($row['ns_bname']); 
$data['gongjong'] = $row['ns_gongjong']; 
$data['price'] = $row['ns_price']; 
	
	
echo json_encode($data);