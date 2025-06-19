<?php 
include_once('../../_common.php');

//디렉토리
$dir = G5_DATA_PATH.'/request';
$dir2 = G5_DATA_PATH.'/request/'.date('ymd');
//디렉토리 생성
@mkdir($dir, G5_DIR_PERMISSION);
@chmod($dir, G5_DIR_PERMISSION);

@mkdir($dir2, G5_DIR_PERMISSION);
@chmod($dir2, G5_DIR_PERMISSION);


if($_FILES['wr_plan_file']['tmp_name']) {

	$filename = $_FILES['wr_plan_file']['name'];
	$fileinfo = pathinfo($filename);
	$ext = $fileinfo['extension'];
	$fileReName = time().'_'.rand(1000,9999).'.'.$ext;
	$dest_path = $dir2.'/'.$fileReName;
	move_uploaded_file($_FILES['wr_plan_file']['tmp_name'], $dest_path);
	chmod($dest_path, G5_FILE_PERMISSION);
	
	$file_sql = " , wr_plan_file = '".date('ymd')."/".$fileReName."'";
	$file_sql .= " , wr_plan_file_name = '".$filename."'";
}


$wr_name = clean_xss_tags(trim($_POST['wr_name']));
$wr_addr = clean_xss_tags(trim($_POST['wr_addr']));
$wr_tel = hyphen_hp_number(trim($_POST['wr_tel']));
$wr_content = preg_replace("#[\\\]+$#", "", $_POST['wr_content']);

if($is_member)
	$wr_password = $member['mb_password'];
else
	$wr_password = get_encrypt_string($_POST['wr_password']);

$sql_common = "
mb_id = '{$member['mb_id']}',
wr_name = '{$wr_name}',
wr_tel = '{$wr_tel}',
wr_addr = '{$wr_addr}',
wr_state = '{$wr_state}',
wr_plan_yn = '{$wr_plan_yn}',
wr_area1 = '{$wr_area1}',
wr_area2 = '{$wr_area2}',
wr_area3 = '{$wr_area3}',
wr_area4 = '{$wr_area4}',
wr_area5 = '{$wr_area5}',
wr_area6 = '{$wr_area6}',
wr_floor1 = '{$wr_floor1}',
wr_floor2 = '{$wr_floor2}',
wr_use = '{$wr_use}',
wr_content = '{$wr_content}',
wr_password = '{$wr_password}'
";

if($w == '') {
	
	$sql = "insert into {$none['home_request']} set {$sql_common} {$file_sql}, wr_datetime = '".G5_TIME_YMDHIS."', wr_ip = '".$_SERVER['REMOTE_ADDR']."'";
	sql_query($sql);
	
	$message = $wr_name.'님께서 공사의뢰를 접수하였습니다.';
	
	//알림톡 토큰생성
	$_apiURL	  =	'https://kakaoapi.aligo.in/akv10/token/create/5/s/';
	$_hostInfo	=	parse_url($_apiURL);
	$_port		  =	(strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;
	$_variables	=	array(
	'apikey' => 'bkxch91lqi6eefs2jhhfkioxeekxjkkk',
	'userid' => 'n1none'
	);

	$oCurl = curl_init();
	curl_setopt($oCurl, CURLOPT_PORT, $_port);
	curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
	curl_setopt($oCurl, CURLOPT_POST, 1);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
	curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

	$ret = curl_exec($oCurl);
	$error_msg = curl_error($oCurl);
	curl_close($oCurl);

	// 리턴 JSON 문자열 확인
	//print_r($ret . PHP_EOL);

	// JSON 문자열 배열 변환
	$retArr = json_decode($ret);


	//알림톡발송
	$_apiURL    =	'https://kakaoapi.aligo.in/akv10/alimtalk/send/';
	$_hostInfo  =	parse_url($_apiURL);
	$_port      =	(strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;
	$_variables =	array(
	'apikey'      => 'bkxch91lqi6eefs2jhhfkioxeekxjkkk', 
	'userid'      => 'n1none', 
	'token'       =>  $retArr->token, 
	'senderkey'   => '02938cb35882cef31424b2fbf65189c9292e6cfa', 
	'tpl_code'    => 'TF_9485',
	'sender'      => '01093192990'
	);
	
	$mbSql = "select mb_name, mb_hp from g5_member where mb_level = 10 and (mb_2 = 2 or mb_2 = 4 or mb_2 = 5)";
	$mbRst = sql_query($mbSql);
	for($i=1; $mb = sql_fetch_array($mbRst); $i++) {
		$_variables['receiver_'.$i] = $mb['mb_hp'];
		$_variables['recvname_'.$i] = $mb['mb_name'];
		$_variables['subject_'.$i] = '공사의뢰 접수알림';
		$_variables['message_'.$i] = $message;
	}
	
	$oCurl = curl_init();
	curl_setopt($oCurl, CURLOPT_PORT, $_port);
	curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
	curl_setopt($oCurl, CURLOPT_POST, 1);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
	curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

	$ret = curl_exec($oCurl);
	$error_msg = curl_error($oCurl);
	curl_close($oCurl);
	
	
	
	
	alert('공사의뢰가 접수 되었습니다.');
	
	
	
	
} else if($w == 'u') {
	
} else if($w == 'd') {
	$ss_name = "ss_veiw_".$seq; 
	if(!get_session($ss_name))
		alert('정상적인 접근이 아닙니다.', './request.html');
	
	if(!isset($_GET['seq'])) alert('정상적인 접근이 아닙니다.', './request.html');
	
	sql_query("delete from {$none['home_request']} where seq = '$seq'");
	
	alert('공사의뢰가 삭제되었습니다.', '../request.html');
} else if($w == 'f') {
	//파일삭제
	$row = sql_fetch("select wr_plan_file from {$none['home_request']} where seq = '$seq'");
	
	if(!$row) alert('잘못 된 접근입니다.');
	
	@unlink($dir."/".$row['wr_plan_file']);
	
	sql_query("update {$none['home_request']} set wr_plan_file = '', wr_plan_file_name = '' where seq = '$seq'");
	
	alert('설계도서 파일이 삭제되었습니다.');
	
}