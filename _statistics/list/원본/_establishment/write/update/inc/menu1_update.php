<?php 
include_once('../../../../_common.php');

if($mode == '') {
	
	$insert = "insert into {$none['est_report']} set 
	mb_id = '{$member['mb_id']}',
	nw_code = '{$nw_code}',
	ne_date = '{$ne_date}',
	ne_price = '{$ne_price}',
	ne_price2 = '{$ne_price2}',
	ne_price3 = '{$ne_price3}',
	ne_memo = '{$ne_memo}',
	ne_datetime = '".G5_TIME_YMDHIS."'
	
	";
	sql_query($insert, true);
	
	
} else if($mode == 'u') {
	$update = "update {$none['est_report']} set 

	ne_price = '{$ne_price}',
	ne_price2 = '{$ne_price2}',
	ne_price3 = '{$ne_price3}',
	ne_memo = '{$ne_memo}',
	ne_datetime = '".G5_TIME_YMDHIS."'
	
	where seq = '$seq'
	";
	sql_query($update, true);
	
	
	
}

alert('정산보고서가 업데이트 되었습니다.');