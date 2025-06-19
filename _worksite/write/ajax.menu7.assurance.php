<?php
header("Content-Type: application/json");
include_once('../../_common.php');
define('menu_worksite', true);

if($is_guest) exit; 

if(empty($_POST['seq'])) exit;

$row = sql_fetch("select nr_num, nr_price, nr_price_contract, nr_sdate, nr_edate, nr_contract_date   from {$none['repair_list2']} where seq = '{$seq}'");
echo json_encode($row);
