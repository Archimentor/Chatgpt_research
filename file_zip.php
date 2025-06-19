<?php 
include_once('./_common.php');

set_time_limit ( 0 );
ini_set('memory_limit', '-1');


$nw = sql_fetch(" select * from {$none['worksite']} where nw_code = '{$code}'");
$smart = sql_fetch("select * from {$none['smart_list']} where work_id = '{$nw['nw_code']}'");

if(!$smart) {
	alert('작성 된 스마트일보가 없습니다.');
}

$sql = "select seq from {$none['smart_list']} where work_id = '{$nw['nw_code']}'";
$rst = sql_query($sql);
while($row=sql_fetch_array($rst)){
	$smart_seq[] = $row['seq'];
}
$sql_add = implode(',', $smart_seq);

$sql = "select * from g5_board_file where wr_id IN ({$sql_add}) and bo_table = 'smart'";

$rst = sql_query($sql);
for($i=0; $row=sql_fetch_array($rst); $i++) {
	
	$files[] = "./_data/smart/".$row['bf_file'];
	
}
if($i == 0) alert('스마트일보에 첨부된 파일이 없습니다.');



// 생성한 zip 파일을 다운로드하기
/*dpsdnjs4199!

header("Content-type: application/zip");
header("Content-Disposition: attachment; filename=$downZipName"); 
readfile($zipName);
unlink($zipName);*/
// 파일 또는 디렉터리 존재 여부 확인
// 새로운 임시 디렉터리 경로 설정
$newTempDir = $_SERVER['DOCUMENT_ROOT']."/_data/";

// PHP가 사용하는 임시 디렉터리 변경
putenv("TMPDIR=$newTempDir");

$tempDir = sys_get_temp_dir();




$filesExist = false;
foreach ($files as $file) {
	
    if (file_exists($file)) {
		
        $filesExist = true;
        
    }
}

if ($filesExist) {
    
$zip = new ZipArchive();

// 압축 파일명 및 경로 지정
$zipFileName = $code.'.zip';

// Zip 파일 열기 (쓰기 모드)
if ($zip->open($tempDir."/".$zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    
   

    // 파일 또는 디렉터리를 압축에 추가
    foreach ($files as $file) {
        // 파일의 절대 경로를 구하기 위해 realpath 함수 사용
        $realPath = realpath($file);
        echo $realPath;
        // 파일 또는 디렉터리 추가
        if (is_file($realPath)) {
            $zip->addFile($realPath, basename($file));
			var_dump($zip);
        }
    }
    
    // Zip 파일 닫기
    $zip->close();
	
	//
     // 압축 파일 다운로드
   /*header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zipFileName);
    header('Content-Length: ' . filesize($tempDir."/".$zipFileName));
    readfile($zipFileName);
    
    // 파일 삭제
    unlink($tempDir."/".$zipFileName);*/
	header('Content-Type: application/zip');
	header("Content-Disposition: attachment; filename=\"".$zipFileName."\"");
	ob_end_flush();
	@readfile($tempDir."/".$zipFileName);
	
	 unlink($tempDir."/".$zipFileName);
}
} else {
    echo '압축할 파일이나 디렉터리를 찾을 수 없습니다.';
}

