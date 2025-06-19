<?php
include_once('../../_common.php');
if($is_guest)
	alert('로그인 후 이용바랍니다.');

// clean the output buffer
ob_end_clean();

$no = isset($_REQUEST['no']) ? (int) $_REQUEST['no'] : 0;


if($is_guest)
	alert('권한이 없습니다.', G5_URL);
	
$sql = " select * from {$none['home_board']} where seq = '$seq' ";
$file = sql_fetch($sql);
if (!$file['wr_file'.$no])
    alert_close('파일 정보가 존재하지 않습니다.');

$bo_table = $file['bo_table'];

$filepath = NONE_PATH.'/_data/board/'.$bo_table.'/'.$file['wr_file'.$no];


$filepath = addslashes($filepath);
$file_exist_check = (!is_file($filepath) || !file_exists($filepath)) ? false : true;

if ( false === run_replace('download_file_exist_check', $file_exist_check, $file) ){
    alert('파일이 존재하지 않습니다.'.$filepath);
}


$g5['title'] = '다운로드 &gt; '.conv_subject($file['wr_subject'], 255);

$original = rawurlencode($file['wr_file'.$no.'_name']);

@include_once($board_skin_path.'/download.tail.skin.php');

run_event('download_file_header', $file, $file_exist_check);

if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: ".filesize($filepath));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
} else if (preg_match("/Firefox/i", $_SERVER['HTTP_USER_AGENT'])){
    header("content-type: file/unknown");
    header("content-length: ".filesize($filepath));
    //header("content-disposition: attachment; filename=\"".basename($file['bf_source'])."\"");
    header("content-disposition: attachment; filename=\"".$original."\"");
    header("content-description: php generated data");
} else {
    header("content-type: file/unknown");
    header("content-length: ".filesize($filepath));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();

$fp = fopen($filepath, 'rb');

// 4.00 대체
// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 방법보다는 이방법이...
//if (!fpassthru($fp)) {
//    fclose($fp);
//}

$download_rate = 10;

while(!feof($fp)) {
    //echo fread($fp, 100*1024);
    /*
    echo fread($fp, 100*1024);
    flush();
    */

    print fread($fp, round($download_rate * 1024));
    flush();
    usleep(1000);
}
fclose ($fp);
flush();