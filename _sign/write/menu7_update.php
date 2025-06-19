<?php
/***************************************************
 * menu7_update.php
 *  - 근태사유서 INSERT/UPDATE/DELETE 처리
 ***************************************************/
include_once('../../_common.php');
define('sign_statistics', true);

if($is_guest) alert('권한이 없습니다.', G5_URL);

// 넘어오는 파라미터 (menu7_write.php에서 POST)
$w                = $_POST['w'];
$seq              = $_POST['seq'];
$ns_importance    = $_POST['ns_importance'];
$tag              = $_POST['tag'];             // 참조자
$ns_subject       = $_POST['ns_subject'];
$ns_reason        = $_POST['ns_reason'];
$ns_startdate_date= $_POST['ns_startdate_date'];
$ns_startdate_time= $_POST['ns_startdate_time'];
$ns_enddate_date  = $_POST['ns_enddate_date'];
$ns_enddate_time  = $_POST['ns_enddate_time'];
$ns_hours         = $_POST['ns_hours'];
$ns_days          = $_POST['ns_days'];
$ns_content       = $_POST['ns_content'];      // 상세사유
$ns_id1           = $_POST['ns_id1'];
$ns_id2           = $_POST['ns_id2'];
$ns_id3           = $_POST['ns_id3'];
$ns_id4           = $_POST['ns_id4'];
$ns_id5           = $_POST['ns_id5'];
$sign_cnt         = $_POST['sign_cnt'];        // 결재자 수 (최대 5명)
$file_list        = $_POST['file_list'];       // 첨부파일 목록(임시)

// 날짜 + 시간 합치기
$ns_startdate     = trim($ns_startdate_date).' '.trim($ns_startdate_time);
$ns_enddate       = trim($ns_enddate_date).' '.trim($ns_enddate_time);

// 문서번호 생성 로직 (N1휴-기안자-날짜 + 카운트)
function make_docnum7()
{
    global $member, $none;
    // ex) N1휴-홍길동-23083101
    $docnum = 'N1휴-'.$member['mb_name'].'-';

    // 오늘 날짜 기준 count
    $today = G5_TIME_YMD; // ex) 2023-08-31
    $sql = " SELECT COUNT(*) as cnt 
             FROM {$none['sign_draft7']} 
             WHERE ns_date = '$today' ";
    $row = sql_fetch($sql);
    $count = $row['cnt'] + 1;  // 오늘 문서 중 +1

    // 예: 230831 + 2자리 시리얼 -> 23083101
    $num_str = date('ymd').sprintf('%02d', $count);
    $docnum .= $num_str;

    return $docnum;
}

// 공통 SQL
$sql_common = "
    ns_importance    = '$ns_importance',
    ns_cc            = '$tag',
    ns_subject       = '$ns_subject',
    ns_reason        = '$ns_reason',
    ns_startdate     = '$ns_startdate',
    ns_enddate       = '$ns_enddate',
    ns_hours         = '$ns_hours',
    ns_days          = '$ns_days',
    ns_content       = '$ns_content',
    ns_id1           = '$ns_id1',
    ns_id2           = '$ns_id2',
    ns_id3           = '$ns_id3',
    ns_id4           = '$ns_id4',
    ns_id5           = '$ns_id5'
";

// 테이블명
$table7 = $none['sign_draft7'];

if($w == '') {
    // INSERT (새 문서)
    // 문서번호 생성
    $ns_docnum = make_docnum7();

    // DB Insert
    $sql = "
        INSERT INTO $table7
        SET ns_docnum     = '$ns_docnum',
            mb_id         = '{$member['mb_id']}',
            ns_sign_cnt   = '$sign_cnt',
            ns_state      = '미처리',  /* 기본값 */
            ns_date       = '".G5_TIME_YMD."',
            ns_datetime   = '".G5_TIME_YMDHIS."',
            ns_ip         = '".$_SERVER['REMOTE_ADDR']."',
            $sql_common
    ";
    sql_query($sql);
    $wr_id = sql_insert_id();

    // 첨부파일 uid -> wr_id 갱신 (menu2 로직과 동일)
    if(isset($file_list) && is_array($file_list)) {
        for($i=0; $i<count($file_list); $i++){
            sql_query("UPDATE {$g5['board_file_table']}
                       SET wr_id = '$wr_id', bf_no='{$i}'
                       WHERE bf_change_id = '{$_POST['uid']}' 
                         AND bo_table='draft7' "); 
            // draft7(가정): menu7용 테이블(실제 bo_table 명칭은 환경에 맞게)
        }
    }

    alert('근태사유서가 등록되었습니다.', "../view/menu7_view.php?w=u&seq=$wr_id");

} else if($w == 'u') {
    // UPDATE (수정)
    // 날짜/시간 다시 기록
    $sql_up = "
        UPDATE $table7
        SET ns_date     = '".G5_TIME_YMD."',
            ns_datetime = '".G5_TIME_YMDHIS."',
            ns_ip       = '".$_SERVER['REMOTE_ADDR']."',
            $sql_common
        WHERE seq = '$seq'
    ";
    sql_query($sql_up);

    // 첨부파일 처리
    if(isset($file_list) && is_array($file_list)) {
        for($i=0; $i<count($file_list); $i++){
            sql_query("UPDATE {$g5['board_file_table']}
                       SET wr_id='$seq'
                       WHERE bf_change_id = '$seq'
                         AND bo_table='draft7' ");
        }
    }

    alert('근태사유서가 수정되었습니다.', "../view/menu7_view.php?w=u&seq=$seq");

} else if($w == 'd') {
    // DELETE
    // 문서 삭제
    sql_query("DELETE FROM $table7 WHERE seq='$seq'");

    // 첨부파일도 필요하면 삭제
    // sql_query("DELETE FROM {$g5['board_file_table']} WHERE wr_id='$seq' AND bo_table='draft7' ");

    alert('근태사유서가 삭제되었습니다.', "../list/menu7_list.php");
}
?>
