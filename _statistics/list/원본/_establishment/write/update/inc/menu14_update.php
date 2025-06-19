<?php 
include_once('../../../../_common.php');


@mkdir(NONE_PATH.'/_data/noim2', G5_DIR_PERMISSION);
@chmod(NONE_PATH.'/_data/noim2', G5_DIR_PERMISSION);

@mkdir(NONE_PATH.'/_data/noim2/'.$nw_code, G5_DIR_PERMISSION);
@chmod(NONE_PATH.'/_data/noim2/'.$nw_code, G5_DIR_PERMISSION);
$file_dir = NONE_PATH.'/_data/noim2/'.$nw_code;

if($mode == '') {
	for($i=0; $i<count($_POST['name']); $i++) {
		
		if(!$_POST['name'][$i]) continue;
		
		if($_FILES['file1']['name'][$i]) {
			
			$filename = $_FILES['file1']['name'][$i];
			$fileinfo = pathinfo($filename);
			$ext = $fileinfo['extension'];
			
			$rename = time().rand(10000,99999)."_".$nw_code."_1.".$ext;
			
			@move_uploaded_file($_FILES['file1']['tmp_name'][$i], $file_dir."/".$rename);
			
			$file_sql1 = " , ne_file1 = '$rename' ";
		} else {
			$file_sql1 = "";
		}
		
		if($_FILES['file2']['name'][$i]) {
			
			$filename = $_FILES['file2']['name'][$i];
			$fileinfo = pathinfo($filename);
			$ext = $fileinfo['extension'];
			
			$rename = time().rand(10000,99999)."_".$nw_code."_2.".$ext;
			
			@move_uploaded_file($_FILES['file2']['tmp_name'][$i], $file_dir."/".$rename);
			
			$file_sql2 = " , ne_file2 = '$rename' ";
		} else {
			$file_sql2 = "";
		}
		
		if($_FILES['file3']['name'][$i]) {
			
			$filename = $_FILES['file3']['name'][$i];
			$fileinfo = pathinfo($filename);
			$ext = $fileinfo['extension'];
			
			$rename = time().rand(10000,99999)."_".$nw_code."_3.".$ext;
			
			@move_uploaded_file($_FILES['file3']['tmp_name'][$i], $file_dir."/".$rename);
			
			$file_sql3 = " , ne_file3 = '$rename' ";
		} else {
			$file_sql3 = "";
		}
		
		if($_FILES['file4']['name'][$i]) {
			
			$filename = $_FILES['file4']['name'][$i];
			$fileinfo = pathinfo($filename);
			$ext = $fileinfo['extension'];
			
			$rename = time().rand(10000,99999)."_".$nw_code."_4.".$ext;
			
			@move_uploaded_file($_FILES['file4']['tmp_name'][$i], $file_dir."/".$rename);
			
			$file_sql4 = " , ne_file4 = '$rename' ";
		} else {
			$file_sql4 = "";
		}
		
		$sql = "insert into {$none['est_noim']} set 
		nw_code = '$nw_code',
		mb_id = '{$member['mb_id']}',
		ne_type = '2',
		ne_date = '$ne_date',
		ne_name = '{$_POST['name'][$i]}',
		ne_gongjong = '{$_POST['gongjong'][$i]}',
		ne_num = '{$_POST['num'][$i]}',
		ne_addr1 = '{$_POST['addr1'][$i]}',
		ne_addr2 = '{$_POST['addr2'][$i]}',
		ne_bank = '{$_POST['bank'][$i]}',
		ne_account = '{$_POST['account'][$i]}',
		ne_holder = '{$_POST['accname'][$i]}',
		ne_datetime = '".$_SERVER['REMOTE_ADDR']."'
		{$file_sql1}
		{$file_sql2}
		";
		
		sql_query($sql);
		
		$seq = sql_insert_id();
		
		if($file_sql3 || $file_sql4) 
			sql_query( "insert into none_est_noim_file set noim_seq = '{$seq}', ne_date ='$ne_date' {$file_sql3} {$file_sql4}");
		
	}
	
	alert('노임-용역회사 정보가 등록 되었습니다.');

} else if($mode == 'u') {
	
	for($i=0; $i<count($_POST['name']); $i++) {
		
		if($_FILES['file1']['name'][$i]) {
			
			$filename = $_FILES['file1']['name'][$i];
			$fileinfo = pathinfo($filename);
			$ext = $fileinfo['extension'];
			
			$rename = time().rand(10000,99999)."_".$nw_code."_1.".$ext;
			
			@move_uploaded_file($_FILES['file1']['tmp_name'][$i], $file_dir."/".$rename);
			
			$file_sql1 = " , ne_file1 = '$rename' ";
		} else {
			$file_sql1 = "";
		}
		
		if($_FILES['file2']['name'][$i]) {
			
			$filename = $_FILES['file2']['name'][$i];
			$fileinfo = pathinfo($filename);
			$ext = $fileinfo['extension'];
			
			$rename = time().rand(10000,99999)."_".$nw_code."_2.".$ext;
			
			@move_uploaded_file($_FILES['file2']['tmp_name'][$i], $file_dir."/".$rename);
			
			$file_sql2 = " , ne_file2 = '$rename' ";
		} else {
			$file_sql2 = "";
		}
		
		if($_FILES['file3']['name'][$i]) {
			
			$filename = $_FILES['file3']['name'][$i];
			$fileinfo = pathinfo($filename);
			$ext = $fileinfo['extension'];
			
			$rename = time().rand(10000,99999)."_".$nw_code."_3.".$ext;
			
			@move_uploaded_file($_FILES['file3']['tmp_name'][$i], $file_dir."/".$rename);
			
			$file_sql3 = " , ne_file3 = '$rename' ";
		} else {
			$file_sql3 = "";
		}
		
		if($_FILES['file4']['name'][$i]) {
			
			$filename = $_FILES['file4']['name'][$i];
			$fileinfo = pathinfo($filename);
			$ext = $fileinfo['extension'];
			
			$rename = time().rand(10000,99999)."_".$nw_code."_4.".$ext;
			
			@move_uploaded_file($_FILES['file4']['tmp_name'][$i], $file_dir."/".$rename);
			
			$file_sql4 = " , ne_file4 = '$rename' ";
		} else {
			$file_sql4 = "";
		}
		
		if(!$_POST['seq'][$i]){
			
			
			$sql = "insert into {$none['est_noim']} set 
			nw_code = '$nw_code',
			mb_id = '{$member['mb_id']}',
			ne_type = '2',
			ne_date = '$ne_date',
			ne_name = '{$_POST['name'][$i]}',
			ne_gongjong = '{$_POST['gongjong'][$i]}',
			ne_num = '{$_POST['num'][$i]}',
			ne_addr1 = '{$_POST['addr1'][$i]}',
			ne_addr2 = '{$_POST['addr2'][$i]}',
			ne_bank = '{$_POST['bank'][$i]}',
			ne_account = '{$_POST['account'][$i]}',
			ne_holder = '{$_POST['accname'][$i]}',
			ne_datetime = '".$_SERVER['REMOTE_ADDR']."'
			{$file_sql1}
			{$file_sql2}
			";
			
			sql_query($sql);
			
			$seq = sql_insert_id();
		
			if($file_sql3 || $file_sql4) 
				sql_query( "insert into none_est_noim_file set noim_seq = '{$seq}', ne_date ='$ne_date' {$file_sql3} {$file_sql4}");
			
		} else {
		
			$sql = "update {$none['est_noim']} set 
			ne_name = '{$_POST['name'][$i]}',
			ne_gongjong = '{$_POST['gongjong'][$i]}',
			ne_num = '{$_POST['num'][$i]}',
			ne_addr1 = '{$_POST['addr1'][$i]}',
			ne_addr2 = '{$_POST['addr2'][$i]}',
			ne_bank = '{$_POST['bank'][$i]}',
			ne_account = '{$_POST['account'][$i]}',
			ne_holder = '{$_POST['accname'][$i]}',
			ne_datetime = '".$_SERVER['REMOTE_ADDR']."'
			{$file_sql1}
			{$file_sql2}
			where seq = '{$_POST['seq'][$i]}'
			";
			
			sql_query($sql);
			
			
		
			if($file_sql3 || $file_sql4) {
				sql_query("delete form none_est_noim_file where noim_seq = '{$_POST['seq'][$i]}' and ne_date = '$ne_date'");
				sql_query( "insert into none_est_noim_file set noim_seq = '{$_POST['seq'][$i]}', ne_date ='$ne_date' {$file_sql3} {$file_sql4}", true);
				
			}
		
		}
		
	}
	
	alert('노임-용역회사 정보가 수정되었습니다.');
}
?>