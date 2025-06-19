<?php
include_once('../_common.php');

if($is_guest)
	alert('로그인 후 이용바랍니다.');



$file = sql_fetch("select * from {$g5['board_file_table']} where seq = '$seq'");

if(!$file) alert('삭제할 파일이 존재 하지 않습니다.');

switch($file['bf_category']) {
	case "계약서" : $dirName = 1; break;
	case "내역서" : $dirName = 2;break;
	case "현장대리인계" : $dirName = 3;break;
	case "계약보증서" : $dirName = 4;break;
	case "근로자재해증권" : $dirName = 5;break;
	case "선급금보증서" : $dirName = 6;break;
	case "기타서류" : $dirName = 7;break;
	
}

//파일삭제
$dest_file = NONE_PATH.'/_data/worksite/'.$dirName.'/'.$file['bf_file'];
@unlink($dest_file);

//db삭제
@sql_query("delete from {$g5['board_file_table']} where seq = '$seq'");

alert('첨부파일이 삭제되었습니다.');