<?php 
include_once('../../_common.php');
define('sign_statistics', true);

if($is_guest) alert('권한이 없습니다.', G5_URL);


//문서번호 만들기
$ns_docnum = "N1무-";

switch($ns_team) {
	case "공무부" :
	$ns_docnum .= "CON";
	break;
	case "관리부" :
	case "기획관리부" :
	$ns_docnum .= "MA";
	break;
	case "연구부" :
	$ns_docnum .= "BIM";
	break;
	default :
	$ns_docnum .= $ns_team;
	break;
}

$total = sql_fetch("select count(*) as cnt from {$none['sign_draft4']} where ns_team = '$ns_team' and ns_date = '".G5_TIME_YMD."'");
$num = sprintf('%02d', ($total['cnt']+1));

$ns_docnum .= "-".date('ymd').$num;

$ns_company = @implode('^', $_POST['ns_company']);


$sql_common = "
ns_docnum = '$ns_docnum',
ns_importance = '$ns_importance',
ns_id1 = '$ns_id1',
ns_id2 = '$ns_id2',
ns_id3 = '$ns_id3',
ns_id4 = '$ns_id4',
ns_id5 = '$ns_id5',
ns_cc = '$tag',
ns_team = '$ns_team',
ns_subject = '$ns_subject',
ns_price = '$ns_price',
ns_content = '$ns_content',
ns_company = '$ns_company'
";

if($w == '') {
	$sql = " insert into {$none['sign_draft4']} set {$sql_common}, ns_sign_cnt = '{$sign_cnt}', mb_id = '{$member['mb_id']}', ns_date = '".G5_TIME_YMD."', ns_datetime = '".G5_TIME_YMDHIS."', ns_ip = '".$_SERVER['REMOTE_ADDR']."'";
	sql_query($sql, true);
	
	$wr_id = sql_insert_id();

	//임시로 업로드 된 파일 uid 변경
	for($i=0; $i<count($_POST['file_list']); $i++) {
		sql_query("update {$g5['board_file_table']} set wr_id = '$wr_id', bf_no = '{$i}' where bf_change_id = {$_POST['uid']} and bo_table = 'draft4'");
	}
	
	alert('무상처리가 등록되었습니다.', '../list/menu4_list.php');
	
	
} else if($w == 'u') {
	
	
} else if($w == 'd') {
	
	sql_query("delete from {$none['sign_draft4']} where seq = '$seq'");
	
	alert('무상처리가 삭제되었습니다.', '/_sign/list/menu4_list.php');
	
}
