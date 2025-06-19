<?php 
include_once('../../_common.php');
define('menu_statistics', true);

if($is_guest) alert('권한이 없습니다.', G5_URL);


$row = sql_fetch("select * from {$none['sign_draft']} where seq = '$seq'");

if($row['mb_id'] != $member['mb_id']) {
	if($row['ns_id'.$sort] != $member['mb_id'] )
		alert('결재권한이 없습니다.');
}
$w = urldecode($_GET['w']);


//다음결재자 구하기 
if($sort == $row['ns_sign_cnt']) {
	
	if($w == "결재") {
		$mb = get_member($row['mb_id'], 'mb_hp');
		$tpl = "TF_6394";
		$message = "[".$row['ns_docnum']." ".$row['ns_subject']."]의 결재가 승인되었습니다.";
		$sql_add = " , ns_state = '진행중'";
		$alimtalk = true;
		
	} else if($w == "전결") {
		$mb = get_member($row['mb_id'], 'mb_hp');
		$tpl = "TF_6394";
		$message = "[".$row['ns_docnum']." ".$row['ns_subject']."]의 결재가 승인되었습니다.";
		$sql_add = " , ns_state = '전결'";
		$alimtalk = true;
		
	} else if($w == "반려") {
		
		$mb = get_member($row['mb_id'], 'mb_hp');
		$tpl = "TF_6395";
		$message = "[".$row['ns_docnum']." ".$row['ns_subject']."]의 결재가 반려되었습니다.";
		$sql_add = " , ns_state = '반려'";
	}
	
} else {
	
	if($w == "결재") {
		//다음결재자 알림
		$next = $sort+1;
		$mb = get_member($row['ns_id'.$next], 'mb_hp');
		$tpl = "TF_6393";
		$message = "[".$row['ns_docnum']." ".$row['ns_subject']."]을 검토 후 결재바랍니다.";
		
	} else if($w == "전결") {
		
		$mb = get_member($row['mb_id'], 'mb_hp');
		$tpl = "TF_6394";
		$message = "[".$row['ns_docnum']." ".$row['ns_subject']."]의 결재가 승인되었습니다.";
		$sql_add = " , ns_state = '전결'";
		$alimtalk = true;
		
	} else if($w == "반려") {
		
		$mb = get_member($row['mb_id'], 'mb_hp');
		$tpl = "TF_6395";
		$message = "[".$row['ns_docnum']." ".$row['ns_subject']."]의 결재가 반려되었습니다.";
		$sql_add = " , ns_state = '반려'";
	}
	
	
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

//결재 승인일 경우 공무부, 연구부에 전송 / 220913 연구부제외
if($alimtalk == true) {
	$mbSql = "select mb_name, mb_hp from g5_member where mb_level = 10 and mb_2 = 2 and mb_id != 'admin' and mb_level2 != 4";
	$mbRst = sql_query($mbSql);
	for($i=2; $mb = sql_fetch_array($mbRst); $i++) {
		$_variables['receiver_'.$i] = $mb['mb_hp'];
		$_variables['recvname_'.$i] = $mb['mb_name'];
		$_variables['subject_'.$i] = '대금결제 알림';
		$_variables['message_'.$i] = $message;
	}
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

// 리턴 JSON 문자열 확인
print_r($ret . PHP_EOL);

// JSON 문자열 배열 변환
$retArr = json_decode($ret);




$msg = $w."|".G5_TIME_YMDHIS;

sql_query("update {$none['sign_draft']} set ns_id{$sort}_stat = '$msg' {$sql_add} where seq = '$seq'");

alert($w." 처리되었습니다.");