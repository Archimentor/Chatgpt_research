<?php 
include_once('../../_common.php');

if($member['mb_level2'] == 3) $is_admin = true; 

//if(!$is_admin) alert('권한이 없습니다.', G5_URL);

if($is_guest) alert('권한이 없습니다.', G5_URL);
@mkdir(NONE_PATH.'/_data/repair2', G5_DIR_PERMISSION);
@chmod(NONE_PATH.'/_data/repair2', G5_DIR_PERMISSION);


$nr_price = @str_replace(',', '', $_POST['nr_price']);
$nr_price_contract = @str_replace(',', '', $_POST['nr_price_contract']);
$nr_fees = @str_replace(',', '', $_POST['nr_fees']);

$sql_common = "
nw_code = '$nw_code',
nw_code_txt = '$nw_code_txt',
nr_num = '$nr_num',
nr_bname = '$nr_bname',
nr_gongjong = '$nr_gongjong',
nr_price = '$nr_price',
nr_price_per = '$nr_price_per',
nr_price_contract = '$nr_price_contract',
nr_fees = '$nr_fees',
nr_sdate = '$nr_sdate',
nr_edate = '$nr_edate',
nr_contract_date = '$nr_contract_date',
nr_company = '$nr_company',
nr_content = '$nr_content'
";

if($_FILES['nr_file']['tmp_name']) {
	$fileName = $_FILES['nr_file']['name'];
	$fileinfo = pathinfo($fileName);
	$ext = $fileinfo['extension'];
	$rename = time().rand(1000,9999).'_repair2.'.$ext;
	$dest_path = NONE_PATH.'/_data/repair2/'.$rename;
	move_uploaded_file($_FILES['nr_file']['tmp_name'], $dest_path);
	@chmod($dest_path, G5_FILE_PERMISSION);
	$file_sql = ", nr_file = '$rename', nr_file_name = '$fileName'";
}



if($w == '') {
	$sql = " insert into {$none['repair_list2']} set {$sql_common} {$file_sql}, mb_id = '{$member['mb_id']}', nr_datetime = '".G5_TIME_YMDHIS."', nr_ip = '".$_SERVER['REMOTE_ADDR']."' ";
	sql_query($sql, true);

	alert('하자보증서가 등록 되었습니다.', '/_worksite/list/menu8_list.php');
	
} else if($w == 'u') {
	
	//파일삭제
	if($_POST['file_del'] == 1) {
		//파일삭제
		$file = sql_fetch("select nr_file, nr_file_name from {$none['repair_list2']} where seq = '$seq'");
		$filepath = NONE_PATH.'/_data/repair2/'.$file['nr_file'];
		@chmod($filepath, 0777);
		@unlink($filepath);
		
		$file_sql = ", nr_file = '', nr_file_name = ''";
	}
	
	
	$sql = " update {$none['repair_list2']} set {$sql_common} {$file_sql} where seq = '$seq'";
	sql_query($sql);

	alert('하자보증서가 수정 되었습니다.');

	
} else if($w == 'd') {
	if(!$is_admin) alert('권한이 없습니다.');
	
	$sql = " delete from {$none['repair_list2']} where seq = '$seq'";
	sql_query($sql);
	
	//파일삭제
	$file = sql_fetch("select nr_file, nr_file_name from {$none['repair_list2']} where seq = '$seq'");
	$filepath = NONE_PATH.'/_data/repair2/'.$file['nr_file'];
	@chmod($filepath, 0777);
	@unlink($filepath);
	
	alert('하자보증서가 삭제 되었습니다.', '/_worksite/list/menu8_list.php');
} else if($w == 'f') {
	//파일다운로드
	
	// clean the output buffer
	ob_end_clean();
	$file = sql_fetch("select nr_file, nr_file_name from {$none['repair_list2']} where seq = '$seq'");
	if (!$file['nr_file'])
		alert_close('파일 정보가 존재하지 않습니다.');

	$filepath = NONE_PATH.'/_data/repair2/'.$file['nr_file'];


	$filepath = addslashes($filepath);
	$file_exist_check = (!is_file($filepath) || !file_exists($filepath)) ? false : true;

	if ( false === run_replace('download_file_exist_check', $file_exist_check, $file) ){
		alert('파일이 존재하지 않습니다.');
	}

	$original = rawurlencode($file['nr_file_name']);

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
	
}