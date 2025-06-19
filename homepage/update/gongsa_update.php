<?php
include_once('../../_common.php');

//본사직원일경우 관리자 권한 부여
if($member['mb_level2'] == 1  || $member['mb_level2'] == 3 ) $is_admin = true; 

if($is_guest) alert('권한이 없습니다.');


$dir = NONE_PATH.'/_data/gongsa';
@mkdir($dir, G5_DIR_PERMISSION);
@chmod($dir, G5_DIR_PERMISSION);



if($_FILES['main_img']['name']) {
	
	$filename = $_FILES['main_img']['name'];
	$fileinfo = pathinfo($filename);
	$ext = $fileinfo['extension'];
	
	$rename = time().rand(100,999)."_mi_".".".$ext;
	
	@move_uploaded_file($_FILES['main_img']['tmp_name'], $dir."/".$rename);
	
	$img_sql .= " , main_img = '$rename' ";
}

if($_FILES['pdf_file']['name']) {
	
	$filename = $_FILES['pdf_file']['name'];
	$fileinfo = pathinfo($filename);
	$ext = $fileinfo['extension'];
	
	$rename = time().rand(100,999)."_pdf_".".".$ext;
	
	@move_uploaded_file($_FILES['pdf_file']['tmp_name'], $dir."/".$rename);
	
	$img_sql .= " , pdf_file = '$rename', pdf_file_name = '$filename' ";
}

$update = "update {$none['home_gongsa']} set upload_date = '".G5_TIME_YMDHIS."', upload_ip = '".$_SERVER['REMOTE_ADDR']."' {$img_sql} where seq = 1";
sql_query($update, true);

alert('공사지명원이 업데이트 되었습니다.');