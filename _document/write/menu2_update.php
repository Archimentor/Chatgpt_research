<?php 
include_once('../../_common.php');

if($is_guest) {
    echo "ERROR: not authorized";
    exit;
}

// $_POST['w'] 로 동작 분기
$w = $_POST['w'];

// ----------------------------------------------------------------------
// (A) 2차(추가 차수) 즉시 삭제: AJAX
// ----------------------------------------------------------------------
if($w == 'del_sub_add') {
    // AJAX로 넘어온 파라미터: sb_id(메인계약 PK), ns_num(차수번호)
    $sb_id  = $_POST['sb_id'];
    $ns_num = $_POST['ns_num'];
    if(!$sb_id || !$ns_num) {
        echo "ERROR: missing parameter (sb_id or ns_num)";
        exit;
    }
    // DB 삭제
    $sql = "DELETE FROM {$none['subcontract_add']}
             WHERE sb_id = '{$sb_id}'
               AND ns_num = '{$ns_num}' ";
    $result = sql_query($sql);
    if($result) {
        echo "OK";
    } else {
        echo "ERROR: DB delete failed";
    }
    exit; // AJAX 응답 끝

// ----------------------------------------------------------------------
// (B) 신규 등록
// ----------------------------------------------------------------------
} else if($w == '') {
    // 업체명, 공사명 변환
    $work_name    = get_worksite_name($work_id);
    $ns_bname_txt = get_enterprise_txt($ns_bname);

    // 메인 계약 insert
    $sql_common = "
        work_id       = '$work_id',
        work_name     = '$work_name',
        ns_type       = '$ns_type',
        ns_type2      = '$ns_type2',
        ns_gian       = '$ns_gian',
        ns_gongjong   = '$ns_gongjong',
        ns_bname      = '$ns_bname',
        ns_bname_txt  = '$ns_bname_txt',
        ns_btel       = '$ns_btel',
        ns_manager    = '$ns_manager',
        ns_manager_tel= '$ns_manager_tel',
        ns_num        = '$ns_num',
        ns_kiscon     = '$ns_kiscon',

        ns_contract_date = '".$_POST['ns_contract_date'][0]."',
        ns_sdate         = '".$_POST['ns_sdate'][0]."',
        ns_edate         = '".$_POST['ns_edate'][0]."',
        ns_price         = '".$_POST['ns_price'][0]."',
        ns_vat           = '".$_POST['ns_vat'][0]."',
        ns_total_price   = '".$_POST['ns_total_price'][0]."',
        ns_memo          = '$ns_memo'
    ";
    $sql = "INSERT INTO {$none['subcontract']}
               SET {$sql_common},
                   mb_id       = '{$member['mb_id']}',
                   ns_datetime = '".G5_TIME_YMDHIS."',
                   ns_ip       = '".$_SERVER['REMOTE_ADDR']."'
    ";
    sql_query($sql,true);
    // 방금 insert 한 PK
    $wr_id = sql_insert_id();

    // 업로드 파일 uid 변경
    if(isset($_POST['file_list']) && is_array($_POST['file_list'])) {
        for($i=0; $i<count($_POST['file_list']); $i++) {
            sql_query("
                UPDATE {$g5['board_file_table']}
                   SET wr_id = '$wr_id', bf_no='$i'
                 WHERE bf_change_id = '{$_POST['uid']}'
                   AND bo_table='subcontract'
            ");
        }
    }

    // 추가 차수 insert
    if($_POST['ns_price_num']) {
        for($i=0; $i<count($_POST['ns_price_num']); $i++) {
            $z = $i+1; 
            $sql2 = "INSERT INTO {$none['subcontract_add']}
                        SET ns_num = '".$_POST['ns_price_num'][$i]."',
                            mb_id  = '{$member['mb_id']}',
                            sb_id  = '{$wr_id}',   /* 신규 등록 시 sb_id = wr_id */
                            ns_contract_date= '".$_POST['ns_contract_date'][$z]."',
                            ns_sdate       = '".$_POST['ns_sdate'][$z]."',
                            ns_edate       = '".$_POST['ns_edate'][$z]."',
                            ns_price       = '".$_POST['ns_price'][$z]."',
                            ns_vat         = '".$_POST['ns_vat'][$z]."',
                            ns_total_price = '".$_POST['ns_total_price'][$z]."',
                            ns_datetime    = '".G5_TIME_YMDHIS."',
                            ns_ip          = '".$_SERVER['REMOTE_ADDR']."'
            ";
            sql_query($sql2,true);
        }
    }

    alert('하도급계약 데이터가 등록 되었습니다.', '/_document/list/menu2_list.php');

// ----------------------------------------------------------------------
// (C) 수정
// ----------------------------------------------------------------------
} else if($w == 'u') {
    // 업체명, 공사명 변환
    $work_name    = get_worksite_name($work_id);
    $ns_bname_txt = get_enterprise_txt($ns_bname);

    $sql_common = "
        work_id       = '$work_id',
        work_name     = '$work_name',
        ns_type       = '$ns_type',
        ns_type2      = '$ns_type2',
        ns_gian       = '$ns_gian',
        ns_gongjong   = '$ns_gongjong',
        ns_bname      = '$ns_bname',
        ns_bname_txt  = '$ns_bname_txt',
        ns_btel       = '$ns_btel',
        ns_manager    = '$ns_manager',
        ns_manager_tel= '$ns_manager_tel',
        ns_num        = '$ns_num',
        ns_kiscon     = '$ns_kiscon',

        ns_contract_date = '".$_POST['ns_contract_date'][0]."',
        ns_sdate         = '".$_POST['ns_sdate'][0]."',
        ns_edate         = '".$_POST['ns_edate'][0]."',
        ns_price         = '".$_POST['ns_price'][0]."',
        ns_vat           = '".$_POST['ns_vat'][0]."',
        ns_total_price   = '".$_POST['ns_total_price'][0]."',
        ns_memo          = '$ns_memo'
    ";
    // 메인계약 update
    $sql = "UPDATE {$none['subcontract']}
               SET {$sql_common},
                   ns_updatetime = '".G5_TIME_YMDHIS."',
                   ns_ip         = '".$_SERVER['REMOTE_ADDR']."'
             WHERE seq = '$seq'
    ";
    sql_query($sql);

    // 업로드 파일
    if(isset($_POST['file_list']) && is_array($_POST['file_list'])) {
        for($i=0; $i<count($_POST['file_list']); $i++) {
            sql_query("
                UPDATE {$g5['board_file_table']}
                   SET wr_id = '$seq'
                 WHERE bf_change_id = '$seq'
                   AND bo_table='subcontract'
            ");
        }
    }

    // 추가 차수 전체 삭제 후 재등록
    if($_POST['ns_price_num']) {
        sql_query("DELETE FROM {$none['subcontract_add']} WHERE sb_id='$seq'");
        for($i=0; $i<count($_POST['ns_price_num']); $i++){
            $z = $i+1;
            $sql2 = "INSERT INTO {$none['subcontract_add']}
                        SET ns_num = '".$_POST['ns_price_num'][$i]."',
                            mb_id  = '{$member['mb_id']}',
                            sb_id  = '$seq',
                            ns_contract_date= '".$_POST['ns_contract_date'][$z]."',
                            ns_sdate       = '".$_POST['ns_sdate'][$z]."',
                            ns_edate       = '".$_POST['ns_edate'][$z]."',
                            ns_price       = '".$_POST['ns_price'][$z]."',
                            ns_vat         = '".$_POST['ns_vat'][$z]."',
                            ns_total_price = '".$_POST['ns_total_price'][$z]."',
                            ns_datetime    = '".G5_TIME_YMDHIS."',
                            ns_ip          = '".$_SERVER['REMOTE_ADDR']."'
            ";
            sql_query($sql2,true);
        }
    }

    alert('하도급계약 데이터가 수정 되었습니다.');

// ----------------------------------------------------------------------
// (D) 메인 계약 삭제
// ----------------------------------------------------------------------
} else if($w == 'd') {
    // 메인 계약 삭제
    sql_query("DELETE FROM {$none['subcontract']} WHERE seq='$seq'");
    // 추가 차수도 삭제
    sql_query("DELETE FROM {$none['subcontract_add']} WHERE sb_id='$seq'");
    
    alert('해당 하도급계약이 삭제되었습니다.', '/_document/list/menu2_list.php');

// ----------------------------------------------------------------------
// (E) 기타
// ----------------------------------------------------------------------
} else {
    alert('잘못된 접근입니다.');
}
?>
