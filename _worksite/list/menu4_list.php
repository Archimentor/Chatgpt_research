<?php
// 파일 경로 및 공통 파일 포함 (실제 환경에 맞게 조정 필요)
include_once('../../_common.php');

// --- _safe_value 함수 (menu1_write.php 참고) ---
if (!function_exists('_safe_value')) {
    function _safe_value($array, $key, $default = '') {
        if (!is_array($array)) {
            return htmlspecialchars((string)$default, ENT_QUOTES, 'UTF-8');
        }
        return isset($array[$key]) ? htmlspecialchars((string)$array[$key], ENT_QUOTES, 'UTF-8') : htmlspecialchars((string)$default, ENT_QUOTES, 'UTF-8');
    }
}

// --- 텍스트 변환 함수 (menu1_list.php 참고 - 실제 함수 구현 필요) ---
if (!function_exists('get_manager_txt')) {
    function get_manager_txt($manager_id) {
        return htmlspecialchars($manager_id); // 임시: ID 반환
    }
}
if (!function_exists('get_enterprise_txt')) {
    function get_enterprise_txt($enterprise_id) {
        return htmlspecialchars($enterprise_id); // 임시: ID 반환
    }
}

// --- 메뉴 정의 및 헤더 ---
define('menu_worksite', true); // 또는 define('menu_project_info', true);
include_once(NONE_PATH.'/header.php'); // 실제 헤더 파일 경로

// --- SQL 쿼리 설정 ---
$sql_common = " FROM {$none['worksite']} "; // 사용할 테이블
$sql_search = " WHERE (1) "; // 기본 WHERE 절 (검색 제거됨)

// 현장소장 권한 필터링 (필요시 유지)
if(isset($member['mb_level2']) && $member['mb_level2'] == 2) {
    $sql_search .= " AND ( nw_ptype1_1 = '{$member['mb_id']}' OR nw_ptype1_2 = '{$member['mb_id']}' OR nw_ptype1_3 = '{$member['mb_id']}' OR nw_ptype2_1 = '{$member['mb_id']}' OR nw_ptype2_2 = '{$member['mb_id']}' OR nw_ptype2_3 = '{$member['mb_id']}' ) ";
}

// 정렬 설정
$sst = isset($_GET['sst']) ? trim($_GET['sst']) : 'nw_code';
$sod = isset($_GET['sod']) ? trim($_GET['sod']) : 'desc';
$allowed_sort_fields = ['nw_code', 'nw_subject', 'pj_year', 'pj_title_kr'];
if (!in_array($sst, $allowed_sort_fields)) $sst = 'nw_code';
if (!in_array(strtolower($sod), ['asc', 'desc'])) $sod = 'desc';
$sql_order = " ORDER BY {$sst} {$sod} ";

// 전체 레코드 수 계산
$sql_count = "SELECT COUNT(*) AS cnt {$sql_common} {$sql_search}";
$row_cnt = sql_fetch($sql_count);
$total_count = $row_cnt['cnt'] ?? 0;

// 페이징 설정
$rows = $config['cf_page_rows'] ?? 15;
$total_page = ceil($total_count / $rows);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$from_record = ($page - 1) * $rows;

// 데이터 조회 쿼리 (pj_upche 필드 제외)
$sql_select = "SELECT seq, nw_code, nw_subject, nw_addr, nw_ptype1_1, nw_ptype4_1, pj_title_kr, pj_title_en, pj_person, pj_addr AS pj_addr_d, pj_type, pj_photo, pj_year
        {$sql_common} {$sql_search} {$sql_order} LIMIT {$from_record}, {$rows}";

$result = sql_query($sql_select);
$list_num = $total_count - ($page - 1) * $rows;

// qstr 생성 (페이징, 정렬 유지용)
$qstr_arr = [];
if (isset($_GET['sst'])) $qstr_arr['sst'] = $_GET['sst'];
if (isset($_GET['sod'])) $qstr_arr['sod'] = $_GET['sod'];
$qstr = http_build_query($qstr_arr);

?>

<div id="main-content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                    프로젝트 정보 일괄수정
                </h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">현장관리</li>
                    <li class="breadcrumb-item active">프로젝트 정보 일괄수정</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="body">
                    <form name="fprojectlist" id="fprojectlist" method="post" action="./menu4_update.php" onsubmit="return fprojectlist_submit(this);">
                    <input type="hidden" name="sst" value="<?php echo htmlspecialchars($sst); ?>">
                    <input type="hidden" name="sod" value="<?php echo htmlspecialchars($sod); ?>">
                    <input type="hidden" name="page" value="<?php echo htmlspecialchars($page); ?>">

                    <div class="table-responsive mt-3">
                        <table class="table m-b-0 table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th rowspan="2" class="align-middle">순서</th>
                                    <th rowspan="2" class="align-middle"><a href="<?php echo $_SERVER['PHP_SELF'] . '?sst=nw_code&amp;sod=' . ($sst == 'nw_code' && $sod == 'asc' ? 'desc' : 'asc') . '&amp;' . $qstr; ?>">현장코드</a></th>
                                    <th rowspan="2" class="align-middle"><a href="<?php echo $_SERVER['PHP_SELF'] . '?sst=nw_subject&amp;sod=' . ($sst == 'nw_subject' && $sod == 'asc' ? 'desc' : 'asc') . '&amp;' . $qstr; ?>">현장명(기본)</a></th>
                                    <th rowspan="2" class="align-middle">주소(C)</th>
                                    <th rowspan="2" class="align-middle">현장소장1</th>
                                    <th rowspan="2" class="align-middle">건축사1</th>
                                    <th colspan="7" class="text-center">프로젝트 정보 (수정 가능)</th>
                                    <th rowspan="2" class="align-middle">관리</th>
                                </tr>
                                <tr>
                                    <th style="min-width: 180px;"><a href="<?php echo $_SERVER['PHP_SELF'] . '?sst=pj_title_kr&amp;sod=' . ($sst == 'pj_title_kr' && $sod == 'asc' ? 'desc' : 'asc') . '&amp;' . $qstr; ?>">현장명(한글)</a></th>
                                    <th style="min-width: 180px;">현장명(영문)</th>
                                    <th style="min-width: 150px;">현장소장(D)</th>
                                    <th style="min-width: 200px;">주소(D)</th>
                                    <th style="min-width: 120px;">용도</th>
                                    <th style="min-width: 120px;">사진작가</th>
                                    <th style="min-width: 100px;"><a href="<?php echo $_SERVER['PHP_SELF'] . '?sst=pj_year&amp;sod=' . ($sst == 'pj_year' && $sod == 'asc' ? 'desc' : 'asc') . '&amp;' . $qstr; ?>">준공연도</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $rows_data = []; // 테이블 데이터를 저장할 배열 (JS에서 사용)
                                if ($result && sql_num_rows($result) > 0) {
                                    while ($row = sql_fetch_array($result)) {
                                        $rows_data[] = $row; // 행 데이터 저장
                                        $seq = _safe_value($row, 'seq');
                                        $edit_url = '../write/menu1_write.php?w=u&amp;seq=' . $seq;
                                        if (!empty($qstr)) $edit_url .= '&amp;' . $qstr;

                                        $manage_buttons = '';
                                        if(isset($member['mb_level']) && $member['mb_level'] >= 10) {
                                            $manage_buttons = '<a href="' . $edit_url . '" class="btn btn-primary btn-sm">개별수정</a> ';
                                        } else if (isset($member['mb_level2']) && $member['mb_level2'] == 2) {
                                            $manage_buttons = '<a href="' . $edit_url . '" class="btn btn-info btn-sm">보기</a>';
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $list_num--; ?></td>
                                        <td>
                                            <a href="<?php echo $edit_url; ?>"><?php echo _safe_value($row, 'nw_code'); ?></a>
                                            <input type="hidden" name="seqs[]" value="<?php echo $seq; ?>">
                                        </td>
                                        <td><?php echo _safe_value($row, 'nw_subject'); ?></td>
                                        <td><?php echo _safe_value($row, 'nw_addr'); ?></td>
                                        <td><?php echo get_manager_txt(_safe_value($row, 'nw_ptype1_1')); ?></td>
                                        <td><?php echo get_enterprise_txt(_safe_value($row, 'nw_ptype4_1')); ?></td>
                                        <td><input type="text" name="pj_title_kr[<?php echo $seq; ?>]" value="<?php echo _safe_value($row, 'pj_title_kr'); ?>" class="form-control form-control-sm editable-input"></td>
                                        <td><input type="text" name="pj_title_en[<?php echo $seq; ?>]" value="<?php echo _safe_value($row, 'pj_title_en'); ?>" class="form-control form-control-sm editable-input"></td>
                                        <td><input type="text" name="pj_person[<?php echo $seq; ?>]" value="<?php echo _safe_value($row, 'pj_person'); ?>" class="form-control form-control-sm editable-input"></td>
                                        <td><input type="text" name="pj_addr_d[<?php echo $seq; ?>]" value="<?php echo _safe_value($row, 'pj_addr_d'); ?>" class="form-control form-control-sm editable-input"></td>
                                        <td><input type="text" name="pj_type[<?php echo $seq; ?>]" value="<?php echo _safe_value($row, 'pj_type'); ?>" class="form-control form-control-sm editable-input"></td>
                                        <td><input type="text" name="pj_photo[<?php echo $seq; ?>]" value="<?php echo _safe_value($row, 'pj_photo'); ?>" class="form-control form-control-sm editable-input"></td>
                                        <td><input type="text" name="pj_year[<?php echo $seq; ?>]" value="<?php echo _safe_value($row, 'pj_year'); ?>" class="form-control form-control-sm editable-input" maxlength="4"></td>
                                        <td><?php echo $manage_buttons; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                    } // end while
                                } // end if $result

                                if ($i == 0) { ?>
                                <tr>
                                    <td colspan="13" class="text-center">데이터가 없습니다.</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($i > 0): ?>
                    <div class="mt-3 text-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> 일괄 수정 저장</button>
                    </div>
                    <?php endif; ?>

                    </form> <div class="mt-3">
                    <?php
                    $paging_url = $_SERVER['SCRIPT_NAME'] . (empty($qstr) ? '?' : '?' . $qstr . '&amp;') . 'page=';
                    if (function_exists('get_paging_none')) {
                        echo get_paging_none(G5_IS_MOBILE ? ($config['cf_mobile_pages'] ?? 10) : ($config['cf_write_pages'] ?? 10), $page, $total_page, $paging_url);
                    } else if (function_exists('get_paging')) {
                         echo get_paging(G5_IS_MOBILE ? ($config['cf_mobile_pages'] ?? 10) : ($config['cf_write_pages'] ?? 10), $page, $total_page, $paging_url);
                    } else {
                        echo '<div class="text-center">페이징 함수를 찾을 수 없습니다.</div>';
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fprojectlist_submit(f) {
    // ... (제출 확인 로직 동일) ...
    if (confirm("수정된 내용을 일괄 저장하시겠습니까?")) {
        try {
            var submitButton = f.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> 저장 중...';
            }
        } catch (e) { console.error("Submit button handling error:", e); }
        return true;
    } else {
        return false;
    }
}

// --- 키보드 방향키 이동 기능 ---
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#fprojectlist tbody');

    if (tableBody) {
        // 이벤트 위임: tbody에 이벤트 리스너 추가
        tableBody.addEventListener('keydown', function(event) {
            const target = event.target;

            // 이벤트가 'editable-input' 클래스를 가진 INPUT 요소에서 발생했고,
            // 방향키(37:Left, 38:Up, 39:Right, 40:Down)가 눌렸는지 확인
            if (target.classList.contains('editable-input') && [37, 38, 39, 40].includes(event.keyCode)) {

                // 기본 동작(예: 페이지 스크롤, 커서 이동) 방지
                event.preventDefault();

                const currentCell = target.closest('td');
                const currentRow = target.closest('tr');
                // tbody 내의 모든 실제 데이터 행(tr)을 배열로 가져옴
                const rows = Array.from(tableBody.querySelectorAll('tr')).filter(tr => tr.querySelector('td')); // 빈 tr 제외
                // 현재 행의 인덱스 (tbody 기준)
                const currentRowIndex = rows.indexOf(currentRow);
                // 현재 셀의 인덱스 (tr 기준)
                const currentCellIndex = currentCell.cellIndex;

                let nextRowIndex = currentRowIndex;
                let nextCellIndex = currentCellIndex;
                let targetInput = null; // 포커스를 이동시킬 input 요소

                switch (event.keyCode) {
                    case 38: // 위 화살표
                        if (currentRowIndex > 0) {
                            nextRowIndex = currentRowIndex - 1;
                            // 같은 열(cellIndex)의 위 행(nextRowIndex)에서 input 찾기
                            const prevRow = rows[nextRowIndex];
                            if (prevRow && prevRow.cells[currentCellIndex]) {
                                targetInput = prevRow.cells[currentCellIndex].querySelector('.editable-input');
                            }
                        }
                        break;
                    case 40: // 아래 화살표
                        if (currentRowIndex < rows.length - 1) {
                            nextRowIndex = currentRowIndex + 1;
                             // 같은 열(cellIndex)의 아래 행(nextRowIndex)에서 input 찾기
                            const nextRow = rows[nextRowIndex];
                            if (nextRow && nextRow.cells[currentCellIndex]) {
                                targetInput = nextRow.cells[currentCellIndex].querySelector('.editable-input');
                            }
                        }
                        break;
                    case 37: // 왼쪽 화살표
                        // 현재 셀부터 왼쪽으로 이동하며 input 찾기
                        for (let i = currentCellIndex - 1; i >= 0; i--) {
                            const prevCell = currentRow.cells[i];
                            if (prevCell) {
                                targetInput = prevCell.querySelector('.editable-input');
                                if (targetInput) break; // 찾으면 루프 종료
                            }
                        }
                        break;
                    case 39: // 오른쪽 화살표
                         // 현재 셀부터 오른쪽으로 이동하며 input 찾기
                        for (let i = currentCellIndex + 1; i < currentRow.cells.length; i++) {
                             const nextCell = currentRow.cells[i];
                             if (nextCell) {
                                targetInput = nextCell.querySelector('.editable-input');
                                if (targetInput) break; // 찾으면 루프 종료
                             }
                        }
                        break;
                }

                // 이동할 유효한 input을 찾았다면 포커스 이동
                if (targetInput) {
                    targetInput.focus();
                    // 추가: 포커스된 input의 텍스트를 전체 선택하여 바로 수정하기 쉽게 함
                    targetInput.select();
                }
            }
        });
    }
});
</script>

<style>
#fprojectlist .table thead th { vertical-align: middle; text-align: center; }
#fprojectlist .table input[type="text"].editable-input { /* 클래스명 명시 */
    padding: 0.25rem 0.5rem; font-size: 0.875rem; width: 100%; /* 너비 100% */ box-sizing: border-box; /* 패딩 포함 너비 계산 */
}
</style>

<?php
include_once(NONE_PATH.'/footer.php');
?>