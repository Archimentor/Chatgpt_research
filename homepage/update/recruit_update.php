<?php 
include_once('../../_common.php');

//디렉토리
$dir = G5_DATA_PATH.'/recruit';
$dir2 = G5_DATA_PATH.'/recruit/'.date('ymd');
//디렉토리 생성
@mkdir($dir, G5_DIR_PERMISSION);
@chmod($dir, G5_DIR_PERMISSION);

@mkdir($dir2, G5_DIR_PERMISSION);
@chmod($dir2, G5_DIR_PERMISSION);


for($i=1; $i<=5; $i++) {
	if($_FILES['wr_file'.$i]['tmp_name']) {

		$filename = $_FILES['wr_file'.$i]['name'];
		$fileinfo = pathinfo($filename);
		$ext = $fileinfo['extension'];
		$fileReName = time().'_'.rand(1000,9999).'.'.$ext;
		$dest_path = $dir2.'/'.$fileReName;
		move_uploaded_file($_FILES['wr_file'.$i]['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
		
		$file_sql .= " , wr_file".$i." = '".date('ymd')."/".$fileReName."'";
		$file_sql .= " , wr_file".$i."_name = '".$filename."'";
	}
}

$wr_name = clean_xss_tags(trim($_POST['wr_name']));
$wr_addr = clean_xss_tags(trim($_POST['wr_addr']));
$wr_tel = hyphen_hp_number(trim($_POST['wr_tel']));
$wr_birth = @implode('-', $_POST['wr_birth']);
$wr_time = @implode('~', $_POST['wr_time']);
$wr_pay = @implode('~', $_POST['wr_time']);


if($is_member)
	$wr_password = $member['mb_password'];
else
	$wr_password = get_encrypt_string($_POST['wr_password']);

$sql_common = "
mb_id = '{$member['mb_id']}',
wr_subject = '{$wr_subject}',
wr_name = '{$wr_name}',
wr_tel = '{$wr_tel}',
wr_birth = '{$wr_birth}',
wr_age = '{$wr_age}',
wr_time = '{$wr_time}',
wr_time_aways = '{$wr_time_aways}',
wr_addr = '{$wr_addr}',
wr_email = '{$wr_email}',
wr_pay = '{$wr_pay}',
wr_pay_option = '{$wr_pay_option}',
wr_area = '{$wr_area}',
wr_state = '접수'
";

if($w == '') {
	
	$sql = "insert into {$none['home_recruit']} set {$sql_common} {$file_sql}, wr_password = '{$wr_password}', wr_datetime = '".G5_TIME_YMDHIS."', wr_ip = '".$_SERVER['REMOTE_ADDR']."'";
	sql_query($sql);
	
	
	$message = $wr_name.'님이 입사를 지원하였습니다.';
	
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
	'tpl_code'    => 'TJ_0875',
	'sender'      => '01093192990'
	);
	
	$mbSql = "select mb_name, mb_hp from g5_member where mb_level = 10 and mb_2 = 5 and mb_level2 != 4";
	$mbRst = sql_query($mbSql);
	for($i=1; $mb = sql_fetch_array($mbRst); $i++) {
		$_variables['receiver_'.$i] = $mb['mb_hp'];
		$_variables['recvname_'.$i] = $mb['mb_name'];
		$_variables['subject_'.$i] = '입사지원알림';
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
	
	
	
	alert('입사지원서가 접수 되었습니다.\\n담당자 확인 후 연락드리겠습니다.\\n감사합니다.');
	
	
	
	
} else if($w == 'u') {
	
	$sql = "update {$none['home_recruit']} set {$sql_common} {$file_sql}, wr_datetime = '".G5_TIME_YMDHIS."', wr_ip = '".$_SERVER['REMOTE_ADDR']."' where seq ='$seq' ";
	sql_query($sql);
	
	
	alert('입사지원서가 수정되었습니다.');
	
} else if($w == 'd') {
	$ss_name = "ss_veiw_".$seq; 
	if(!get_session($ss_name))
		alert('정상적인 접근이 아닙니다.', './recruit.html');
	
	if(!isset($_GET['seq'])) alert('정상적인 접근이 아닙니다.', './recruit.html');
	
	sql_query("delete from {$none['home_recruit']} where seq = '$seq'");
	
	alert('입사지원서가 삭제되었습니다.', '../recruit.html');
}