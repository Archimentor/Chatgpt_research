<?php 
include_once('../../_common.php');
define('menu_worksite', true);

if($is_guest) exit; 

if(empty($_POST['company'])) die('n');

 
$insert = "insert into {$none['repair_company']} set nr_name = '$company'";

if(sql_query($insert))
	die('y');
else
	die('n');