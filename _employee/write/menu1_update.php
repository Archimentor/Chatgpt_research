<?php
include_once('../../_common.php');
include_once(G5_LIB_PATH.'/register.lib.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if($is_guest) alert('권한이 없습니다.', G5_URL);

if(!isset($_POST['mb_id']) || !trim($_POST['mb_id']))
    alert('회원아이디 값이 없습니다. 올바른 방법으로 이용해 주십시오.');

$mb_id = trim($_POST['mb_id']);
$mb_password    = isset($_POST['mb_password']) ? trim($_POST['mb_password']) : '';
$mb_name        = isset($_POST['mb_name']) ? trim($_POST['mb_name']) : '';
$mb_email       = isset($_POST['mb_email']) ? trim($_POST['mb_email']) : '';
$mb_hp          = isset($_POST['mb_hp']) ? trim($_POST['mb_hp']) : '';
$mb_tel         = isset($_POST['mb_tel']) ? trim($_POST['mb_tel']) : '';
$mb_recommend   = isset($_POST['mb_recommend']) ? trim($_POST['mb_recommend']) : '';

/** 추가한 부분: mb_in_date, mb_birth를 POST에서 받기 **/
$mb_in_date     = isset($_POST['mb_in_date']) ? trim($_POST['mb_in_date']) : '';
$mb_birth       = isset($_POST['mb_birth']) ? trim($_POST['mb_birth']) : '';

/** 기존 다른 mb_필드들 **/
$mb_1           = isset($_POST['mb_1']) ? trim($_POST['mb_1']) : '';
$mb_2           = isset($_POST['mb_2']) ? trim($_POST['mb_2']) : '';
$mb_3           = isset($_POST['mb_3']) ? trim($_POST['mb_3']) : '';
$mb_4           = isset($_POST['mb_4']) ? trim($_POST['mb_4']) : '';
$mb_5           = isset($_POST['mb_5']) ? trim($_POST['mb_5']) : '';
$mb_6           = isset($_POST['mb_6']) ? trim($_POST['mb_6']) : '';
$mb_7           = isset($_POST['mb_7']) ? trim($_POST['mb_7']) : '';
$mb_8           = isset($_POST['mb_8']) ? trim($_POST['mb_8']) : '';
$mb_9           = isset($_POST['mb_9']) ? trim($_POST['mb_9']) : '';
$mb_10          = isset($_POST['mb_10']) ? trim($_POST['mb_10']) : '';

/** 그 외 필요한 변수들 **/
$mb_memo        = isset($_POST['mb_memo']) ? trim($_POST['mb_memo']) : '';
$mb_level2      = isset($_POST['mb_level2']) ? trim($_POST['mb_level2']) : '';

/** 입/퇴사일(기존 코드에 mb_out_date가 있으므로 추가) **/
$mb_out_date    = isset($_POST['mb_out_date']) ? trim($_POST['mb_out_date']) : '';

/** 보안(크로스사이트스크립트 등) 필터링 **/
$mb_name        = clean_xss_tags($mb_name);
$mb_email       = get_email_address($mb_email);
$mb_hp          = clean_xss_tags($mb_hp);
$mb_tel         = clean_xss_tags($mb_tel);
$mb_in_date     = clean_xss_tags($mb_in_date);
$mb_birth       = clean_xss_tags($mb_birth);
$mb_1           = clean_xss_tags($mb_1);
$mb_2           = clean_xss_tags($mb_2);
$mb_3           = clean_xss_tags($mb_3);
$mb_4           = clean_xss_tags($mb_4);
$mb_5           = clean_xss_tags($mb_5);
$mb_6           = clean_xss_tags($mb_6);
$mb_7           = clean_xss_tags($mb_7);
$mb_8           = clean_xss_tags($mb_8);
$mb_9           = clean_xss_tags($mb_9);
$mb_10          = clean_xss_tags($mb_10);
$mb_memo        = clean_xss_tags($mb_memo);
$mb_level2      = clean_xss_tags($mb_level2);
$mb_out_date    = clean_xss_tags($mb_out_date);
$mb_recommend   = clean_xss_tags($mb_recommend);

/** ID 검증(그누보드 기본함수) **/
if ($msg = empty_mb_id($mb_id))         alert($msg, "", true, true);
if ($msg = valid_mb_id($mb_id))         alert($msg, "", true, true);
if ($msg = count_mb_id($mb_id))         alert($msg, "", true, true);

/** 회원 디렉토리 설정 **/
$mb_dir = G5_DATA_PATH.'/member/'.substr($mb_id,0,2);
$mb_dir2 = G5_DATA_PATH.'/member_image/'.substr($mb_id,0,2);

// 디렉토리 생성(없으면)
@mkdir($mb_dir, G5_DIR_PERMISSION);
@chmod($mb_dir, G5_DIR_PERMISSION);

@mkdir($mb_dir2, G5_DIR_PERMISSION);
@chmod($mb_dir2, G5_DIR_PERMISSION);

/**
 * 여기서 mb_bank1_name, mb_account1 등 변수가 만약 필요하다면,
 * $_POST에서 받아와야 합니다. (원본 코드에만 있고, 질문 코드에는 없는 경우가 많으니
 * 실제 사용 환경에 맞춰 추가하세요.)
 * 예: 
 * $mb_bank1_name = isset($_POST['mb_bank1_name']) ? trim($_POST['mb_bank1_name']) : '';
 * ...
 * 
 * 아래 예시는 질문 원본 코드에 이미 존재한다고 가정합니다.
 * (mb_bank1_name, mb_bank2_name, mb_account1, mb_account2 등)
 *
 * 실제 사용환경에 맞춰 필요한 변수만 남기시면 됩니다.
 */

$sql_common = "
    mb_name          = '{$mb_name}',
    mb_email         = '{$mb_email}',
    mb_hp            = '{$mb_hp}',
    mb_tel           = '{$mb_tel}',
    mb_recommend     = '{$mb_recommend}',
    mb_mailling      = '1',
    mb_sms           = '1',
    mb_open          = '0',
    mb_bank1_name    = '{$mb_bank1_name}',
    mb_bank2_name    = '{$mb_bank2_name}',
    mb_account1      = '{$mb_account1}',
    mb_account2      = '{$mb_account2}',
    mb_memo          = '{$mb_memo}',
    mb_level2        = '{$mb_level2}',
    mb_in_date       = '{$mb_in_date}',
    mb_out_date      = '{$mb_out_date}',
    mb_birth         = '{$mb_birth}',
    mb_1             = '{$mb_1}',
    mb_2             = '{$mb_2}',
    mb_3             = '{$mb_3}',
    mb_4             = '{$mb_4}',
    mb_5             = '{$mb_5}',
    mb_6             = '{$mb_6}',
    mb_7             = '{$mb_7}',
    mb_8             = '{$mb_8}',
    mb_9             = '{$mb_9}',
    mb_10            = '{$mb_10}'
";

/** 파일 업로드 처리 (자격증, 사진, 서명) **/
if($_FILES['mb_img1']['tmp_name']) {
    $fileName = $mb_id.'_num.gif';
    $dest_path = $mb_dir.'/'.$fileName;
    move_uploaded_file($_FILES['mb_img1']['tmp_name'], $dest_path);
    chmod($dest_path, G5_FILE_PERMISSION);
}
if($_FILES['mb_img2']['tmp_name']) {
    $fileName = get_mb_icon_name($mb_id).'.gif';
    $dest_path = $mb_dir2.'/'.$fileName;
    move_uploaded_file($_FILES['mb_img2']['tmp_name'], $dest_path);
    chmod($dest_path, G5_FILE_PERMISSION);
}
if($_FILES['mb_img3']['tmp_name']) {
    $fileName = $mb_id.'_sign.gif';
    $dest_path = $mb_dir.'/'.$fileName;
    move_uploaded_file($_FILES['mb_img3']['tmp_name'], $dest_path);
    chmod($dest_path, G5_FILE_PERMISSION);
}

// 자격증사진 삭제
if (isset($_POST['del_mb_img1']) && $_POST['del_mb_img1'])
    @unlink($mb_dir.'/'.$mb_id.'_num.gif');

// 사진 삭제
if (isset($_POST['del_mb_img2']) && $_POST['del_mb_img2'])
    @unlink($mb_dir2.'/'.get_mb_icon_name($mb_id).'.gif');

// 서명 삭제
if (isset($_POST['del_mb_img3']) && $_POST['del_mb_img3'])
    @unlink($mb_dir.'/'.$mb_id.'_sign.gif');

$w = isset($_POST['w']) ? trim($_POST['w']) : '';

if($w == '') {
    // 새 회원 등록
    $sql_common .= " , mb_id = '{$mb_id}' ";
    $sql_common .= " , mb_password = '".get_encrypt_string($mb_password)."' ";
    $sql_common .= " , mb_level = '10' ";
    $sql_common .= " , mb_today_login = '".G5_TIME_YMDHIS."' ";
    $sql_common .= " , mb_login_ip = '{$_SERVER['REMOTE_ADDR']}' ";
    
    $sql = " INSERT INTO {$g5['member_table']}
                SET {$sql_common},
                    mb_datetime = '".G5_TIME_YMDHIS."',
                    mb_ip = '".$_SERVER['REMOTE_ADDR']."'
           ";
    sql_query($sql, true);
    
    alert('직원 정보가 추가되었습니다.', '/_employee/list/menu1_list.php');
    
} else if($w == 'u') {
    // 기존 회원 수정
    if($mb_password) {
        $sql_common .= " , mb_password = '".get_encrypt_string($mb_password)."' ";
    }
    
    $sql = " UPDATE {$g5['member_table']}
                SET {$sql_common}
              WHERE mb_id = '{$mb_id}' ";
    sql_query($sql, true);
    
    alert('직원정보가 수정되었습니다.');
    
} else if($w == 'd') {
    // 삭제 로직 (현재는 테스트기간 삭제 불가)
    alert('테스트 기간 삭제 불가');
}
?>
