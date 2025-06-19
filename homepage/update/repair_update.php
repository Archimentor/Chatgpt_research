<?php 
include_once('../../_common.php');

//디렉토리 경로 및 생성
$dir = NONE_PATH.'/_data/repair';
$dir2 = NONE_PATH.'/_data/repair/'.$nw_code;

@mkdir($dir, G5_DIR_PERMISSION);
@chmod($dir, G5_DIR_PERMISSION);

@mkdir($dir2, G5_DIR_PERMISSION);
@chmod($dir2, G5_DIR_PERMISSION);


for($i=1; $i<=6; $i++) {
	if($_FILES['nr_file'.$i]['tmp_name']) {

		$filename = $_FILES['nr_file'.$i]['name'];
		$fileinfo = pathinfo($filename);
		$ext = $fileinfo['extension'];
		$fileReName = time().'_'.rand(1000,9999).'.'.$ext;
		$dest_path = $dir2.'/'.$fileReName;
		move_uploaded_file($_FILES['nr_file'.$i]['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
		
		$file_sql .= " , nr_img".$i." = '".$fileReName."' ";
	}
}

$nr_name = clean_xss_tags(trim($_POST['nr_name']));
$nr_tel = clean_xss_tags(trim($_POST['nr_tel']));
$nr_name2 = clean_xss_tags(trim($_POST['nr_name2']));
$nr_tel2 = clean_xss_tags(trim($_POST['nr_tel2']));

$nr_content = preg_replace("#[\\\]+$#", "", $_POST['nr_content']);


$sql_common = "
mb_id = '{$member['mb_id']}',
nw_code = '{$nw_code}',
nr_name = '{$nr_name}',
nr_tel = '{$nr_tel}',
nr_name2 = '{$nr_name2}',
nr_tel2 = '{$nr_tel2}',
nr_content = '{$nr_content}'
";

if($w == '') {
	
	$info = sql_fetch("select pj_title_kr from  {$none['worksite']} where nw_code = '{$nw_code}'");
	
	$sql = "insert into {$none['repair_list']} set {$sql_common} {$file_sql}, nr_datetime = '".G5_TIME_YMDHIS."', nr_ip = '".$_SERVER['REMOTE_ADDR']."'";
	sql_query($sql);
	
	$message = "[".$nw_code."  ".$info['pj_title_kr']."]의 하자보수가 접수되었습니다.";

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
	'tpl_code'    => 'TF_6384',
	'button_1'    => '{"button":[{"name":"바로가기","linkType":"WL","linkP":"http://none.wavework2.kr/", "linkM": "http://none.wavework2.kr/"}]}',
	'sender'      => '01093192990'
	);
	
	$mbSql = "select mb_name, mb_hp from g5_member where mb_level = 10 and (mb_2 = 2 or mb_2 = 4 or mb_2 = 5)";
	$mbRst = sql_query($mbSql);
	for($i=1; $mb = sql_fetch_array($mbRst); $i++) {
		$_variables['receiver_'.$i] = $mb['mb_hp'];
		$_variables['recvname_'.$i] = $mb['mb_name'];
		$_variables['subject_'.$i] = '하자보수 등록알림';
		$_variables['message_'.$i] = $message;
		$_variables['button_'.$i] = '{"button":[{"name":"바로가기","linkType":"WL","linkP":"http://none.wavework2.kr/", "linkM": "http://none.wavework2.kr/"}]}';
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
	
	
	
	
	alert('하자보수가 접수 되었습니다.');
	
	
	
	
} else if($w == 'u') {
	
} else if($w == 'd') {
	
	sql_query("delete from {$none['home_request']} where seq = '$seq'");
	
	alert('공사의뢰가 삭제되었습니다.', '../request.html');
} else if($w == 'f') {
	//파일삭제
	$row = sql_fetch("select wr_plan_file from {$none['home_request']} where seq = '$seq'");
	
	if(!$row) alert('잘못 된 접근입니다.');
	
	@unlink($dir."/".$row['wr_plan_file']);
	
	//sql_query("update {$none['home_request']} set wr_plan_file = '', wr_plan_file_name = '' where seq = '$seq'");
	
	alert('제되었습니다.');
	
}