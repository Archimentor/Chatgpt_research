<?php
include_once('../../_common.php');

//본사직원일경우 관리자 권한 부여
if($member['mb_level2'] == 1  || $member['mb_level2'] == 3 ) $is_admin = true; 

if($is_guest) alert('권한이 없습니다.');


$dir = NONE_PATH.'/_data/board';
@mkdir($dir, G5_DIR_PERMISSION);
@chmod($dir, G5_DIR_PERMISSION);

$dir2 = NONE_PATH.'/_data/board/'.$bo_table;
@mkdir($dir2, G5_DIR_PERMISSION);
@chmod($dir2, G5_DIR_PERMISSION);


if($_FILES['wr_file1']['name']) {
	
	$filename = $_FILES['wr_file1']['name'];
	$fileinfo = pathinfo($filename);
	$ext = $fileinfo['extension'];
	
	$rename = time().rand(100,999)."_board_".".".$ext;
	
	@move_uploaded_file($_FILES['wr_file1']['tmp_name'], $dir2."/".$rename);
	
	$img_sql .= " , wr_file1 = '$rename', wr_file1_name = '$filename' ";
}

if($_FILES['wr_file2']['name']) {
	
	$filename = $_FILES['wr_file2']['name'];
	$fileinfo = pathinfo($filename);
	$ext = $fileinfo['extension'];
	
	$rename = time().rand(100,999)."_board2_".".".$ext;
	
	@move_uploaded_file($_FILES['wr_file2']['tmp_name'], $dir2."/".$rename);
	
	$img_sql .= " , wr_file2 = '$rename', wr_file2_name = '$filename' ";
}

if($member['mb_level'] == 10)
	$member['mb_name'] = "엔원종합건설";

if($w == '') {
	
	$sql = "insert into {$none['home_board']} set 
	bo_table = '$bo_table',
	mb_id = '{$member['mb_id']}',
	ca_name = '{$ca_name}',
	wr_name = '{$member['mb_name']}',
	wr_secret = '{$wr_secret}',
	wr_subject = '{$wr_subject}',
	wr_content = '{$wr_content}',
	wr_view = 0,
	wr_1 = '{$wr_1}',
	wr_2 = '{$wr_2}',
	wr_3 = '{$wr_3}',
	wr_4 = '{$wr_4}',
	wr_5 = '{$wr_5}',
	wr_datetime = '".G5_TIME_YMDHIS."',
	wr_ip = '".$_SERVER['REMOTE_ADDR']."'
	{$img_sql}
	
	";
	
	sql_query($sql, true);
	
	if($bo_table == "board7")
		alert('게시글이 등록되었습니다.', '../board2.html?bo_table='.$bo_table.'&code='.$wr_1);
	else
		alert('게시글이 등록되었습니다.', '../board.html?bo_table='.$bo_table.'&code='.$wr_1);

} else if($w == 'u') {
	
	
	if($_POST['wr_file1_del'] == 1) {
		$img_sql .= " , wr_file1 = '', wr_file1_name = '' ";
	}
	
	if($_POST['wr_file2_del'] == 1) {
		$img_sql .= " , wr_file2 = '', wr_file2_name = '' ";
	}
	
	$sql = "update {$none['home_board']} set 
	wr_secret = '{$wr_secret}',
	ca_name = '{$ca_name}',
	wr_subject = '{$wr_subject}',
	wr_content = '{$wr_content}',
	wr_1 = '{$wr_1}',
	wr_2 = '{$wr_2}',
	wr_3 = '{$wr_3}',
	wr_4 = '{$wr_4}',
	wr_5 = '{$wr_5}',
	wr_datetime = '".G5_TIME_YMDHIS."',
	wr_ip = '".$_SERVER['REMOTE_ADDR']."'
	{$img_sql}
	
	where seq = '$seq'
	";
	
	sql_query($sql);
	
	if($bo_table == "board7")
		alert('게시글이 수정되었습니다.', '../board2.html?bo_table='.$bo_table.'&code='.$wr_1);
	else
		alert('게시글이 수정되었습니다.', '../board.html?bo_table='.$bo_table.'&code='.$wr_1);
	
	
} else if($w == 'd') {
	
	$sql = "delete from {$none['home_board']} where seq = '$seq'";
	sql_query($sql);
	
	if($bo_table == "board7")
		alert('게시글이 삭제되었습니다.', '../board2.html?bo_table='.$bo_table.'&code='.$code);
	else
		alert('게시글이 삭제되었습니다.', '../board.html?bo_table='.$bo_table.'&code='.$code);
	
}