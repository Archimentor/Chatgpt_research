<?php 
include_once('../../_common.php');

if(!isset($_POST['seq']) && !isset($_GET['seq'])) alert('잘못 된 접근이거나 글이 존재하지 않습니다.');

if($member['mb_level2'] == 1 || $member['mb_level2'] == 3) $is_admin = true; 

$row = sql_fetch("select seq, mb_id, wr_password from {$none['home_recruit']} where seq = '$seq'");

if(!$row) alert('잘못 된 접근이거나 글이 존재하지 않습니다.');

if($is_admin) {
	//관리자
	$ss_name = "ss1_veiw_".$row['seq']; 
	set_session($ss_name, true);
	goto_url('../recruit_view.html?seq='.$row['seq']);
	
} else if($is_member && ($member['mb_id'] == $row['mb_id'])) {
	//로그인이 되어있고 본인글이면
	$ss_name = "ss1_veiw_".$row['seq']; 
	set_session($ss_name, true);
	goto_url('../recruit_view.html?seq='.$row['seq']);
	
} else {

	//로그인없이 패스워드 입력
	if(check_password( $_POST['wr_password'], $row['wr_password'])) {
		
		$ss_name = "ss1_veiw_".$row['seq']; 
		set_session($ss_name, true);
		goto_url('../recruit_view.html?seq='.$row['seq']);
		
	} else {
		alert('비밀번호가 일치하지 않습니다.');
	}

}