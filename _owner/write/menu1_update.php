<?php 
include_once('../../_common.php');

if($is_guest) alert('권한이 없습니다.', G5_URL);

// 디렉토리
$dir = NONE_PATH.'/_data/owner';
//디렉토리 생성
@mkdir($dir, G5_DIR_PERMISSION);
@chmod($dir, G5_DIR_PERMISSION);


$sql_common ="
no_id_1 = '$no_id_1',
no_id_2 = '$no_id_2',
no_id_3 = '$no_id_3',
no_company = '$no_company',
no_bnum = '$no_bnum',
no_baddr = '$no_baddr',
no_bemail = '$no_bemail',
no_name = '$no_name',
no_jumin = '$no_jumin',
no_tel = '$no_tel',
no_hp = '$no_hp',
no_email = '$no_email',
no_addr = '$no_addr',
no_memo = '$no_memo'


";

if($_FILES['no_file1']['name']) {
	
	$filename = $_FILES['no_file1']['name'];
	$fileinfo = pathinfo($filename);
	$ext = $fileinfo['extension'];
	
	
	$rename = time().rand(1000,9999)."_owner1_".$i.".".$ext;
	
	@move_uploaded_file($_FILES['no_file1']['tmp_name'], $dir."/".$rename);
	
	$sql_common .= " , no_file1 = '{$rename}' ,no_file1_name = '{$filename}'";
}

if($_FILES['no_file2']['name']) {
	
	$filename = $_FILES['no_file2']['name'];
	$fileinfo = pathinfo($filename);
	$ext = $fileinfo['extension'];
	
	
	$rename = time().rand(1000,9999)."_owner2_".$i.".".$ext;
	
	@move_uploaded_file($_FILES['no_file2']['tmp_name'], $dir."/".$rename);
	
	$sql_common .= " , no_file2 = '{$rename}' ,no_file2_name = '{$filename}'";
}


if($w == '') {
	
	$sql = "insert into {$none['owner_list']} set {$sql_common}, no_datetime = '".G5_TIME_YMDHIS."', no_ip = '".$_SERVER['REMOTE_ADDR']."'";
	
	sql_query($sql);
	
	alert('건축주 정보가 추가되었습니다.', '/_owner/list/menu1_list.php');
	
} else if($w == 'u') {
	
	if($_POST['no_file1_del'] == 1) {
		$sql_common .= " , no_file1 = '{$rename}' ,no_file1_name = '{$filename}'";
	}
	if($_POST['no_file2_del'] == 1) {
		$sql_common .= " , no_file2 = '{$rename}' ,no_file2_name = '{$filename}'";
	}
	
	
	$sql = "update {$none['owner_list']} set {$sql_common} where seq = '$seq'";
	
	sql_query($sql);
	
	alert('건축주 정보가 수정되었습니다.');
	
} else if($w == 'd') {
	$sql = "delete from {$none['owner_list']} where seq = '$seq'";
	
	sql_query($sql);
	
	alert('건축주 정보가 삭제되었습니다.');
}

?>