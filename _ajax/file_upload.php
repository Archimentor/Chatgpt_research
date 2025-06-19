<?php 
include_once('../_common.php');

if($is_guest)
	alert('로그인 후 이용바랍니다.');


if(!isset($_POST['uid'])) die('no');
if(count($_FILES) <= 0) die('no');
if(!isset($_POST['category'])) die('no');

switch($_POST['category']) {
	case "현장사진" : $dirName = 1; break;
	case "도급계약서" : $dirName = 2;break;
	case "계약내역서" : $dirName = 3;break;
	case "건축허가서" : $dirName = 4;break;
	case "착공계서류" : $dirName = 5;break;
	case "건강연금" : $dirName = 6;break;
	case "고용산재" : $dirName = 7;break;
	case "퇴직공제" : $dirName = 8;break;
	case "근재영업배상" : $dirName = 9;break;
	case "폐기물신고" : $dirName = 10;break;
	case "계약보증서" : $dirName = 11;break;
	case "하자보증서" : $dirName = 12;break;
	case "선급금보증서" : $dirName = 13;break;
	case "기타보증서" : $dirName = 14;break;
	case "기타서류" : $dirName = 15;break;
}

/* 폴더 생성완료
@mkdir(NONE_PATH.'/_data/worksite/'.$dirName, G5_DIR_PERMISSION);
@chmod(NONE_PATH.'/_data/worksite/'.$dirName, G5_DIR_PERMISSION);
*/

//게시판변수 임시지정
$bo_table = "worksite";

//UPLOAD배열로 파일정보 담음
$upload = array();
for ($i=0; $i<count($_FILES['files']['name']); $i++) {

	$upload[$i]['file']     = '';
    $upload[$i]['source']   = '';
    $upload[$i]['filesize'] = 0;
    $upload[$i]['image']    = array();
    $upload[$i]['image'][0] = '';
    $upload[$i]['image'][1] = '';
    $upload[$i]['image'][2] = '';
    $upload[$i]['fileurl'] = '';
    $upload[$i]['thumburl'] = '';
    $upload[$i]['storage'] = '';
	
	$tmp_file  = $_FILES['files']['tmp_name'][$i];
    $filesize  = $_FILES['files']['size'][$i];
    $filename  = $_FILES['files']['name'][$i];
    $filename  = get_safe_filename($filename);

	if (is_uploaded_file($tmp_file)) {
       
	   
        //=================================================================\
        // 090714
        // 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
        // 에러메세지는 출력하지 않는다.
        //-----------------------------------------------------------------
        $timg = @getimagesize($tmp_file);
        // image type
        if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
             preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
            if ($timg['2'] < 1 || $timg['2'] > 16)
                continue;
        }
        //=================================================================

        $upload[$i]['image'] = $timg;

        // 프로그램 원래 파일명
        $upload[$i]['source'] = $filename;
        $upload[$i]['filesize'] = $filesize;

        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

        shuffle($chars_array);
        $shuffle = implode('', $chars_array);

        // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
        $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

        $dest_file = NONE_PATH.'/_data/worksite/'.$dirName.'/'.$upload[$i]['file'];

        // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
        $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['files']['error'][$i]);

        // 올라간 파일의 퍼미션을 변경합니다.
        chmod($dest_file, G5_FILE_PERMISSION);

        // 임시 ID (uid)를 wr_id 대신 전달하여 관련 데이터를 처리합니다.
        $dest_file = run_replace('write_update_upload_file', $dest_file, $board, $_POST['uid'], $w);
        $upload[$i] = run_replace('write_update_upload_array', $upload[$i], $dest_file, $board, $_POST['uid'], $w);
    }
}

for ($i=0; $i<count($upload); $i++)
{
    if (empty($upload[$i]['file'])) {
        continue;
    }
	
    $upload[$i]['source'] = sql_real_escape_string($upload[$i]['source']);
    $bf_content = isset($_POST['bf_content'][$i]) ? sql_real_escape_string($_POST['bf_content'][$i]) : '';
    $bf_width = isset($upload[$i]['image'][0]) ? (int) $upload[$i]['image'][0] : 0;
    $bf_height = isset($upload[$i]['image'][1]) ? (int) $upload[$i]['image'][1] : 0;
    $bf_type = isset($upload[$i]['image'][2]) ? (int) $upload[$i]['image'][2] : 0;
  
    // 파일 정보를 DB에 삽입합니다. 이 때 wr_id는 0으로 설정합니다.
    $sql = " insert into {$g5['board_file_table']}
                set bo_table = '{$bo_table}',
                     wr_id = '0',
                     bf_no = '{$i}',
                     bf_source = '{$upload[$i]['source']}',
                     bf_file = '{$upload[$i]['file']}',
                     bf_content = '{$bf_content}',
                     bf_fileurl = '{$upload[$i]['fileurl']}',
                     bf_thumburl = '{$upload[$i]['thumburl']}',
                     bf_storage = '{$upload[$i]['storage']}',
                     bf_download = 0,
                     bf_filesize = '{$upload[$i]['filesize']}',
                     bf_width = '{$bf_width}',
                     bf_height = '{$bf_height}',
                     bf_type = '{$bf_type}',
                     bf_category = '{$dirName}',
                     bf_change_id = '{$_POST['uid']}',
                     bf_datetime = '".G5_TIME_YMDHIS."' ";
    sql_query($sql);

    $bf_id = sql_insert_id();
    run_event('write_update_file_insert', $bo_table, $_POST['uid'], $bf_id, $upload[$i], $w);
}

?>