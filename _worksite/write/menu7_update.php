<?php 
include_once('../../_common.php');

if($is_guest) alert('권한이 없습니다.', G5_URL);


$sql_common = "
nr_name = '$nr_name',
nr_name2 = '$nr_name2',
nr_tel = '$nr_tel',
nr_tel2 = '$nr_tel2',
nr_bname = '$nr_bname',
nr_bname_r = '$nr_bname_r',
nr_content2 = '$nr_content2',
nr_content3 = '$nr_content3',
nr_manager = '$nr_manager',
nr_assurance = '$nr_assurance',
nr_status = '$nr_status'


";

if($w == '') {

	
			
} else if($w == 'u') {
	
	$sql = " update {$none['repair_list']} set {$sql_common} where seq = '$seq'";
	sql_query($sql);
	
	
	//알림톡 발송
	if($_POST['kko'] == 1) {
		
		if($nr_status == "1" ) {
			$tpl = "TF_6386";
			$message = "[{$nw_code}]의 하자담당소장으로 지정되었습니다.";
			$mb = get_member($nr_manager);
			
		} else if($nr_status == "2") {
			$tpl = "TF_6387";
			$message = "[{$nw_code}]의 하자보수가 처리 완료되었습니다.";
			$mb['mb_hp'] = $nr_tel2;
		}
	
	
	
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
	'tpl_code'    => $tpl,
	'sender'      => '01093192990',
	// 'senddate'    => date("YmdHis", strtotime("+10 minutes")),
	'receiver_1'  => str_replace('-', '', $mb['mb_hp']),
	// 'recvname_1'  => '이기현',
	'subject_1'   => '전자결재 결재알림',
	'message_1'   => $message
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
	
	}
	
	

		
	alert('하자보수가 수정 되었습니다.');

	
} else if($w == 'd') {
	if(!$is_admin) alert('권한이 없습니다.');
	
	$sql = " delete from {$none['repair_list']} where seq = '$seq'";
	sql_query($sql);
	
	alert('하자보수가 삭제 되었습니다.', '/_worksite/list/menu7_list.php');
}



?>