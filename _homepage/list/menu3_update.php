<?php 
include_once('../../_common.php');
define('menu_homepage', true);


if($is_guest) alert('권한이 없습니다.');

if(!$bo_table) alert('잘못 된 접근입니다.');

sql_query("update  {$none['home_board_cate']} set nb_category = '$nb_category' where bo_table = '$bo_table'");


alert('카테고리가 저장되었습니다.');
?>