<?php
include_once('../_common.php');

if($is_guest)
	alert('로그인 후 이용바랍니다.');

//압축할 파일들의 경로


$file = sql_fetch("select * from {$g5['board_file_table']} where seq = '$seq' and bf_est_date = '$date'");

$file_path= NONE_PATH."/_data/est/";

//압축할 파일명
$file_names = array();



//다운로드되는 파일명
$file_name = "test.zip";



$zip = new ZipArchive();

if ($zip->open($file_name, ZipArchive::CREATE) !== true){

  exit("cannot open [".$file_name."]");

}

foreach($file_names as $files){

  $zip->addFile($file_path.$files, $files);

}

$zip->close();



header("Content-type: application/zip");

header("Content-Disposition: attachment; filename=".$file_name);

header("Pragma: no-cache");

header("Expires: 0");

readfile($file_name);

unlink($file_name);

?>
