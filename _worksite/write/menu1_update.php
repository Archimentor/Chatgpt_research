<?php
include_once('../../_common.php');

if($is_guest) alert('권한이 없습니다.', G5_URL);


// 기본 현장 정보 및 1차수 정보를 위한 SQL 공통 부분 (0번 인덱스 사용)
$sql_common = "
nw_code = '".sql_real_escape_string($_POST['nw_code'])."',
nw_subject = '".sql_real_escape_string($_POST['nw_subject'])."',
nw_addr = '".sql_real_escape_string($_POST['nw_addr'])."',
nw_type = '".sql_real_escape_string($_POST['nw_type'])."',
nw_structure = '".sql_real_escape_string($_POST['nw_structure'])."',
nw_floor1 = '".sql_real_escape_string($_POST['nw_floor1'])."',
nw_floor2 = '".sql_real_escape_string($_POST['nw_floor2'])."',
nw_area1 = '".sql_real_escape_string($_POST['nw_area1'])."',
nw_area2 = '".sql_real_escape_string($_POST['nw_area2'])."',
nw_area3 = '".sql_real_escape_string($_POST['nw_area3'])."',
nw_contract_date = '".sql_real_escape_string($_POST['nw_contract_date'][0])."',
nw_sdate = '".sql_real_escape_string($_POST['nw_sdate'][0])."',
nw_edate = '".sql_real_escape_string($_POST['nw_edate'][0])."',
nw_price1 = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_price1'][0]))."', /* 콤마 제거 */
nw_price2 = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_price2'][0]))."', /* 콤마 제거 */
nw_vat = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_vat'][0]))."',       /* 콤마 제거 */
nw_contract_price = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_contract_price'][0]))."', /* 콤마 제거 */
nw_total_price = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_total_price'][0]))."', /* 콤마 제거 */
nw_ptype1_1 = '".sql_real_escape_string($_POST['nw_ptype1_1'])."',
nw_ptype1_2 = '".sql_real_escape_string($_POST['nw_ptype1_2'])."',
nw_ptype1_3 = '".sql_real_escape_string($_POST['nw_ptype1_3'])."',
nw_ptype1_4 = '".sql_real_escape_string($_POST['nw_ptype1_4'])."', /* 오타 수정: nw_ptype1_3 -> nw_ptype1_4 */
nw_ptype1_5 = '".sql_real_escape_string($_POST['nw_ptype1_5'])."', /* 오타 수정: nw_ptype1_3 -> nw_ptype1_5 */
nw_ptype1_6 = '".sql_real_escape_string($_POST['nw_ptype1_6'])."', /* 오타 수정: nw_ptype1_3 -> nw_ptype1_6 */
nw_ptype2_1 = '".sql_real_escape_string($_POST['nw_ptype2_1'])."',
nw_ptype2_2 = '".sql_real_escape_string($_POST['nw_ptype2_2'])."',
nw_ptype2_3 = '".sql_real_escape_string($_POST['nw_ptype2_3'])."',
nw_ptype2_4 = '".sql_real_escape_string($_POST['nw_ptype2_4'])."', /* 오타 수정: nw_ptype2_3 -> nw_ptype2_4 */
nw_ptype2_5 = '".sql_real_escape_string($_POST['nw_ptype2_5'])."', /* 오타 수정: nw_ptype2_3 -> nw_ptype2_5 */
nw_ptype2_6 = '".sql_real_escape_string($_POST['nw_ptype2_6'])."', /* 오타 수정: nw_ptype2_3 -> nw_ptype2_6 */
nw_ptype3_1 = '".sql_real_escape_string($_POST['nw_ptype3_1'])."',
nw_ptype3_2 = '".sql_real_escape_string($_POST['nw_ptype3_2'])."',
nw_ptype3_3 = '".sql_real_escape_string($_POST['nw_ptype3_3'])."',
nw_ptype4_1 = '".sql_real_escape_string($_POST['nw_ptype4_1'])."',
nw_ptype4_2 = '".sql_real_escape_string($_POST['nw_ptype4_2'])."',
nw_ptype4_3 = '".sql_real_escape_string($_POST['nw_ptype4_3'])."',
nw_ptype5_1 = '".sql_real_escape_string($_POST['nw_ptype5_1'])."',
nw_ptype5_2 = '".sql_real_escape_string($_POST['nw_ptype5_2'])."',
nw_ptype5_3 = '".sql_real_escape_string($_POST['nw_ptype5_3'])."',
nw_ptype6_1 = '".sql_real_escape_string($_POST['nw_ptype6_1'])."',
nw_ptype6_2 = '".sql_real_escape_string($_POST['nw_ptype6_2'])."',
nw_ptype6_3 = '".sql_real_escape_string($_POST['nw_ptype6_3'])."',
nw_memo = '".sql_real_escape_string($_POST['nw_memo'])."',
nw_status = '".sql_real_escape_string($_POST['nw_status'])."',
nw_insurance_num1 = '".sql_real_escape_string($_POST['nw_insurance_num1'])."',
nw_insurance_num2 = '".sql_real_escape_string($_POST['nw_insurance_num2'])."',
nw_insurance_id = '".sql_real_escape_string($_POST['nw_insurance_id'])."',
nw_insurance_sdate = '".sql_real_escape_string($_POST['nw_insurance_sdate'])."',
nw_insurance_edate = '".sql_real_escape_string($_POST['nw_insurance_edate'])."',
nw_insurance_etc = '".sql_real_escape_string($_POST['nw_insurance_etc'])."',
nw_use_date = '".sql_real_escape_string($_POST['nw_use_date'])."',
nw_kiscon = '".sql_real_escape_string($_POST['nw_kiscon'] ?? '0')."', /* 체크박스 미체크시 값 없음 처리 */
pj_title_kr = '".sql_real_escape_string($_POST['pj_title_kr'])."',
pj_title_en = '".sql_real_escape_string($_POST['pj_title_en'])."',
pj_year = '".sql_real_escape_string($_POST['pj_year'])."',
pj_upche = '".sql_real_escape_string($_POST['pj_upche'])."',
pj_addr = '".sql_real_escape_string($_POST['pj_addr'])."',
pj_person = '".sql_real_escape_string($_POST['pj_person'])."',
pj_type = '".sql_real_escape_string($_POST['pj_type'])."',
pj_photo = '".sql_real_escape_string($_POST['pj_photo'])."',
nw_main_open = '".sql_real_escape_string($_POST['nw_main_open'] ?? '0')."' /* 체크박스 미체크시 값 없음 처리 */
";

if($w == '') { // 등록 처리

	$sql = " insert into {$none['worksite']} set {$sql_common}, mb_id = '{$member['mb_id']}', nw_datetime = '".G5_TIME_YMDHIS."', nw_ip = '".$_SERVER['REMOTE_ADDR']."'";
	sql_query($sql);

	$wr_id = sql_insert_id();

	//임시로 업로드 된 파일 uid 변경
	if (isset($_POST['uid'])) { 
		sql_query("update {$g5['board_file_table']} set wr_id = '$wr_id' where bf_change_id = '{$_POST['uid']}' and bo_table = 'worksite' and wr_id = 0");
        
	}


	//차수추가 건이 있을경우 (등록 시에는 1번 인덱스부터가 추가 차수)
	if(isset($_POST['nw_price_num']) && count($_POST['nw_price_num']) > 1) { // 기본 1차수 외에 추가 차수가 있는지 확인

        // 데이터 배열 (예: nw_contract_date) 개수 확인
        $num_total_chasu = isset($_POST['nw_contract_date']) ? count($_POST['nw_contract_date']) : 0;

		// 1번 인덱스부터 루프 (추가 차수만)
		for($i = 1; $i < $num_total_chasu; $i++) {
			// $z = $i+1; // 기존의 잘못된 인덱스 계산 삭제

            // 해당 인덱스($i)에 대한 차수 번호 가져오기 (순서 일치 가정)
            // nw_price_num 배열의 $i번째 값이 현재 차수의 번호라고 가정
            $current_chasu_num = isset($_POST['nw_price_num'][$i]) ? $_POST['nw_price_num'][$i] : ($i + 1); // 안전장치: 없으면 i+1 사용

            // 필수 데이터 누락 방지
            if (!isset($_POST['nw_contract_date'][$i])) continue;

			$sql2 = "insert into {$none['worksite_add']} set
			nw_num = '".sql_real_escape_string($current_chasu_num)."',
			mb_id = '{$member['mb_id']}',
			nw_id = '$wr_id',
			nw_contract_date = '".sql_real_escape_string($_POST['nw_contract_date'][$i])."',
			nw_sdate = '".sql_real_escape_string($_POST['nw_sdate'][$i])."',
			nw_edate = '".sql_real_escape_string($_POST['nw_edate'][$i])."',
			nw_price1 = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_price1'][$i]))."',
			nw_price2 = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_price2'][$i]))."',
			nw_contract_price = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_contract_price'][$i]))."',
			nw_vat = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_vat'][$i]))."',
			nw_total_price = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_total_price'][$i]))."',
			nw_datetime = '".G5_TIME_YMDHIS."',
			nw_ip = '".$_SERVER['REMOTE_ADDR']."'
			";

			sql_query($sql2, true);
		}

	}


	alert('시공현장 데이터가 등록 되었습니다.', '/_worksite/list/menu1_list.php');

} else if($w == 'u') { // 수정 처리

    if (!isset($seq) || $seq == '') {
        alert('수정할 데이터의 고유번호(seq)가 없습니다.');
    }

	// 기본 1차수 정보 업데이트
	$sql = " update {$none['worksite']} set {$sql_common}, nw_updatetime = '".G5_TIME_YMDHIS."', nw_ip = '".$_SERVER['REMOTE_ADDR']."' where seq = '$seq'";
	sql_query($sql);


	// ========================[ 파일 처리 로직 변경 ]========================
	// 수정 시, 새로 첨부된 파일과 과거에 잘못 연결된 파일 모두를 대상으로 wr_id를 업데이트합니다.
	if (isset($_POST['uid']) && $_POST['uid']) {
		$uid = sql_real_escape_string($_POST['uid']); // 수정 모드에서 uid는 게시물의 seq와 같습니다.

		// bf_change_id가 현재 게시물 seq와 일치하는 모든 파일(wr_id가 0이거나 타임스탬프인 경우 모두)을 찾아
		// wr_id를 현재 게시물의 seq로 강제 업데이트합니다.
		$sql_file_update = "UPDATE {$g5['board_file_table']}
							SET wr_id = '{$seq}'
							WHERE bf_change_id = '{$uid}' AND bo_table = 'worksite'";
		sql_query($sql_file_update);
	}
	// ====================================================================


	// --- 추가 공사차수 처리 ---
	@sql_query("delete from {$none['worksite_add']} where nw_id = '$seq'");

	if(isset($_POST['nw_contract_date']) && is_array($_POST['nw_contract_date'])) {
		$num_total_chasu = count($_POST['nw_contract_date']);
		if ($num_total_chasu > 1) {
			for ($i = 1; $i < $num_total_chasu; $i++) {
				$current_chasu_num = isset($_POST['nw_price_num'][$i]) ? $_POST['nw_price_num'][$i] : ($i + 1);
                if (!isset($_POST['nw_contract_date'][$i])) continue;

				$sql2 = "insert into {$none['worksite_add']} set
				nw_num = '".sql_real_escape_string($current_chasu_num)."',
				mb_id = '{$member['mb_id']}',
				nw_id = '$seq',
				nw_contract_date = '".sql_real_escape_string($_POST['nw_contract_date'][$i])."',
				nw_sdate = '".sql_real_escape_string($_POST['nw_sdate'][$i])."',
				nw_edate = '".sql_real_escape_string($_POST['nw_edate'][$i])."',
				nw_price1 = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_price1'][$i]))."',
				nw_price2 = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_price2'][$i]))."',
				nw_contract_price = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_contract_price'][$i]))."',
				nw_vat = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_vat'][$i]))."',
				nw_total_price = '".sql_real_escape_string(str_replace(',', '', $_POST['nw_total_price'][$i]))."',
				nw_datetime = '".G5_TIME_YMDHIS."',
				nw_ip = '".$_SERVER['REMOTE_ADDR']."'
				";
				sql_query($sql2, true);
			}
		}
	}


	alert('시공현장 데이터가 수정 되었습니다.');

} else if($w == 'd') { // 삭제 처리

    // 삭제 권한 등 확인 필요
    if (!isset($seq) || $seq == '') {
        alert('삭제할 데이터의 고유번호(seq)가 없습니다.');
    }

	alert('테스트기간, 삭제불가'); // 기존 로직 유지

    // 실제 삭제 로직 예시 (주석 처리)
    /*
    // 관련 데이터 삭제 (파일, 추가 차수 등)
    @sql_query("delete from {$g5['board_file_table']} where bo_table = 'worksite' and wr_id = '$seq'");
    @sql_query("delete from {$none['worksite_add']} where nw_id = '$seq'");

    // 기본 현장 정보 삭제
    $sql = "delete from {$none['worksite']} where seq = '$seq'";
    sql_query($sql);

    alert('시공현장 데이터가 삭제되었습니다.', '/_worksite/list/menu1_list.php');
    */
}

?>