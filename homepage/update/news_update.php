<?php
include_once('../../_common.php');

//본사직원일경우 관리자 권한 부여
if($member['mb_level2'] == 1  || $member['mb_level2'] == 3 ) $is_admin = true; 

if(!$is_admin) alert('접근 권한이 없습니다.');


$img_dir = NONE_PATH.'/_data/news';
@mkdir($img_dir, G5_DIR_PERMISSION);
@chmod($img_dir, G5_DIR_PERMISSION);
$img_sql = "";

if($_FILES['wr_img']['name']) {
	
	$filename = $_FILES['wr_img']['name'];
	$fileinfo = pathinfo($filename);
	$ext = $fileinfo['extension'];
	
	$rename = time().rand(100,999)."_news_".".".$ext;
	
	@move_uploaded_file($_FILES['wr_img']['tmp_name'], $img_dir."/".$rename);
	
	$img_sql .= " , wr_img"." = '$rename'";
	$img_sql .= " , wr_img_name"." = '$filename'";
}

if($w == '') {
	
	$sql = "insert into {$none['home_news']} set 
	wr_subject = '$wr_subject',
	wr_content = '$wr_content',
	wr_datetime = '".G5_TIME_YMDHIS."',
	wr_ip = '".$_SERVER['REMOTE_ADDR']."'
	{$img_sql}
	
	";
	
	sql_query($sql);
	
	alert('뉴스가 등록되었습니다.', '../news.html');
	
} else if($w == 'u') {
	
	$sql = "update {$none['home_news']} set 
	wr_subject = '$wr_subject',
	wr_content = '$wr_content',
	wr_datetime = '".G5_TIME_YMDHIS."',
	wr_ip = '".$_SERVER['REMOTE_ADDR']."'
	{$img_sql}
	
	where seq = '$seq'
	";
	
	sql_query($sql);
	
	alert('뉴스가 수정되었습니다.', '../news.html');
	
	
} else if($w == 'd') {
	
	$sql = "delete from {$none['home_news']} where seq = '$seq'";
	sql_query($sql);
	
	alert('뉴스가 삭제되었습니다.', '../news.html');
	
}
?>