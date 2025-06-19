<?php
include_once('../../_common.php');
define('menu_employee', true);
include_once(NONE_PATH.'/header.php');

// --- 표시할 부서 코드 및 순서 정의 ---
// 퇴사(11)는 제외
$target_dept_keys = [5, 3, 2, 4, 1, 10]; // 기획관리부, 관리부, 공무부, 연구부, 공사부, 실행부
$target_dept_keys_sql_in = implode(',', $target_dept_keys); // 예: 5,3,2,1,10

// 부서명 배열 (표시할 부서만 포함)
$departments = array(
    '5'  => '기획관리부',
    '3'  => '관리부',
    '2'  => '공무부',
    '4'  => '연구부',
    '1'  => '공사부',
    '10' => '계약직',
);

// --- GET 파라미터 받기 ---
$team = isset($_GET['team']) ? trim($_GET['team']) : 'all';
$stx  = isset($_GET['stx']) ? trim($_GET['stx']) : '';

// --- 기본 검색 조건 ---
// 관리자 제외, 직원(mb_level=10), mb_level2 != 4(퇴사 제외), 대상 부서(11 제외)
$sql_common = " FROM {$g5['member_table']} ";
$sql_where_base = "
    WHERE mb_level = 10
      AND mb_id != 'admin'
      AND mb_level2 != 4
      AND mb_2 IN ({$target_dept_keys_sql_in})
";
$sql_search = $sql_where_base; // 기본 검색 조건으로 시작

// 부서 필터 조건 : 특정 부서 선택시 해당 부서만 검색
if ($team !== '' && $team !== 'all' && in_array((int)$team, $target_dept_keys, true)) {
    $sql_search = "
        WHERE mb_level = 10
          AND mb_id != 'admin'
          AND mb_level2 != 4
          AND mb_2 = '" . (int)$team . "'
    ";
} else {
    $team = 'all'; // 특정 부서가 아니면 'all'로 간주, $sql_search는 기본값 유지
}

// 텍스트 검색 조건
if ($stx) {
    $stx_escaped = $db->escape_like($stx);
    $sql_search .= "
      AND (
           mb_name LIKE '%{$stx_escaped}%'
        OR mb_id LIKE '%{$stx_escaped}%'
        OR mb_hp LIKE '%{$stx_escaped}%'
        OR mb_email LIKE '%{$stx_escaped}%'
      )
    ";
}

// --- 정렬 조건 설정 (부서 내 이름 순) ---
$sql_order = " ORDER BY mb_name ASC ";

// --- 총원 계산 (대상 부서, 퇴사 제외) ---
$sql_total_count = " SELECT COUNT(*) as cnt {$sql_common} {$sql_where_base} ";
$total_row = sql_fetch($sql_total_count);
$total_members = $total_row['cnt'];

// --- 직원 데이터 조회 ---
$sql = " SELECT * {$sql_common} {$sql_search} {$sql_order} ";
$result = sql_query($sql);

// --- 부서별로 데이터 그룹화 ---
$grouped_employees = [];
foreach ($target_dept_keys as $key) {
    $grouped_employees[$key] = [];
}
while ($row = sql_fetch_array($result)) {
    $dept_key_int = (int)$row['mb_2'];
    if (isset($grouped_employees[$dept_key_int])) {
        $grouped_employees[$dept_key_int][] = $row;
    }
}

// (필요시) sql_free_result($result);

// 부서 코드 -> 이름 변환 함수
function get_department_name($dept_code, $depts_array) {
    return isset($depts_array[(string)$dept_code]) ? $depts_array[(string)$dept_code] : '미지정';
}

$qstr = "&amp;stx=" . urlencode($stx) . "&amp;team=" . urlencode($team);
?>
<head>
    <style>
        /* 테이블 상하 간격 */
        .department-section + .department-section { margin-top: 30px; }
        /* 부서 제목 스타일 */
        .department-header { margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #eee; }
        /* 프로필 이미지 */
        .profile-img-sm { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        /* 관리 버튼 */
        .action-buttons .btn { margin-right: 5px; }
        /* 테이블 셀 정렬 */
        .table th, .table td { vertical-align: middle; }
        .table thead th { text-align: center; } /* 헤더는 기본 중앙 정렬 */
        .text-center { text-align: center; } /* 중앙 정렬 클래스 */
        .text-right { text-align: right; }

        /* 컨트롤 영역 스타일 (카드 본문 상단) */
        .list-controls {
            display: flex; /* Flexbox 사용 */
            justify-content: flex-end; /* 내부 요소들을 오른쪽으로 정렬 */
            align-items: center; /* 수직 중앙 정렬 */
            margin-bottom: 25px; /* 아래쪽 여백 */
        }
        .list-controls .form-inline .form-group {
             margin-bottom: 0; /* form-group 기본 마진 제거 */
             margin-right: 0.5rem; /* select 오른쪽 여백 */
        }
        .list-controls .btn-primary {
             margin-left: 0.5rem; /* 직원등록 버튼 왼쪽 여백 */
        }
    </style>
</head>

<div id="main-content">
<div class="block-header">
    <div class="row">
        <div class="col-lg-5 col-md-8 col-sm-12">
            <h2>
                <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i>
                </a>
                회사관리
            </h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item">회사관리</li>
                <li class="breadcrumb-item active">직원관리 리스트</li>
            </ul>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    직원 목록 <small class="text-muted">(총원: <?php echo number_format($total_members); ?> 명)</small>
                </h3>
            </div>
            <div class="card-body">
                <div class="list-controls">
                    <form method="get" class="form-inline">
                        <div class="form-group">
                            <select name="team" id="teamFilter" class="form-control" onchange="this.form.submit()">
                                <option value="all" <?php echo get_selected($team, 'all'); ?>>부서전체</option>
                                <?php
                                // 부서 선택 옵션 출력
                                foreach ($target_dept_keys as $key) {
                                    if (isset($departments[(string)$key])) {
                                        echo '<option value="' . $key . '" ' . get_selected($team, (string)$key) . '>'
                                             . $departments[(string)$key] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="text" name="stx" class="form-control"
                                   placeholder="이름, ID, 연락처 검색"
                                   value="<?php echo htmlspecialchars(stripslashes($stx)); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="icon-magnifier"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <a class="btn btn-primary" href="../write/menu1_write.php" role="button">
                        <i class="fa fa-user-plus"></i> 직원등록
                    </a>
                </div>

                <?php
                // 부서 목록을 돌면서 항상 출력 (0명이어도 표시)
                foreach ($target_dept_keys as $dept_key) {
                    $dept_emps = $grouped_employees[$dept_key];
                    $dept_count = count($dept_emps);
                    $dept_name = get_department_name($dept_key, $departments);
                    
                    echo '<div class="department-section">';
                    echo '    <h4 class="department-header">';
                    echo          $dept_name . ' <span class="badge badge-secondary">' . $dept_count . '명</span>';
                    echo '    </h4>';
                    echo '    <div class="table-responsive">';
                    echo '        <table class="table table-hover table-striped m-b-0">';
                    echo '            <thead class="thead-light">';
                    echo '                <tr>';
                    echo '                    <th class="text-center" style="width: 60px;">사진</th>';
                    echo '                    <th style="width: 10%;">이름</th>';
                    echo '                    <th style="width: 10%;">아이디</th>';
                    echo '                    <th style="width: 10%;">직급</th>';
                    echo '                    <th style="width: 15%;">연락처</th>';
                    echo '                    <th style="width: 20%;">이메일</th>';
                    echo '                    <th style="width: 10%;">기술등급</th>';
                    echo '                    <th class="text-center" style="width: 100px;">관리</th>';
                    echo '                </tr>';
                    echo '            </thead>';
                    echo '            <tbody>';

                    if ($dept_count > 0) {
                        // 실제 직원 목록 출력
                        foreach ($dept_emps as $row) {
                            $profile_img = get_member_profile_img($row['mb_id']);
                            $profile_img_html = str_replace('<img', '<img class="profile-img-sm"', $profile_img);

                            echo '            <tr>';
                            echo '                <td class="text-center">' . $profile_img_html . '</td>';
                            echo '                <td class="text-center">' . $row['mb_name'] . '</td>';
                            echo '                <td class="text-center">' . $row['mb_id'] . '</td>';
                            echo '                <td class="text-center">' . get_mposition_txt($row['mb_3']) . '</td>';
                            echo '                <td class="text-center">' . $row['mb_hp'] . '</td>';
                            echo '                <td class="text-center">' . $row['mb_email'] . '</td>';
                            echo '                <td class="text-center">' . $row['mb_7'] . '</td>';
                            echo '                <td class="text-center action-buttons">';
                            echo '                    <a href="/_employee/write/menu1_write.php?w=u&amp;mb_id=' . $row['mb_id'] . $qstr . '"';
                            echo '                       class="btn btn-sm btn-outline-primary" title="수정">';
                            echo '                       <i class="fa fa-pencil"></i></a> ';
                            echo '                    <button type="button" class="btn btn-sm btn-outline-danger"';
                            echo '                       title="삭제" onclick="del_(\'' . $row['mb_id'] . '\')">';
                            echo '                       <i class="fa fa-trash"></i></button>';
                            echo '                </td>';
                            echo '            </tr>';
                        }
                    } else {
                        // 직원이 0명이면 안내 메시지
                        echo '            <tr>';
                        echo '                <td colspan="8" class="text-center">표시할 직원이 없습니다.</td>';
                        echo '            </tr>';
                    }

                    echo '            </tbody>';
                    echo '        </table>';
                    echo '    </div>'; // table-responsive
                    echo '</div>';     // department-section
                }
                ?>
            </div> <!-- .card-body -->
        </div> <!-- .card -->
    </div> <!-- .col-lg-12 -->
</div> <!-- .row -->
</div> <!-- #main-content -->

<script>
function del_(mb_id) {
    if(confirm('정말 직원 정보를 삭제하시겠습니까?\n\n관련된 모든 정보가 삭제될 수 있습니다.')) {
        // 삭제 처리 페이지 URL 확인 필요
        location.href = '/_employee/write/menu1_update.php?w=d&mb_id=' + encodeURIComponent(mb_id);
    } else {
        return false;
    }
}
</script>

<?php include_once(NONE_PATH.'/footer.php'); ?>
