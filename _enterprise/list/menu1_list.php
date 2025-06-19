<?php
include_once('../../_common.php');
define('menu_enterprise', true);
include_once(NONE_PATH.'/header.php');

// --- GET 파라미터 받기 및 기본값 설정 ---
$stx = isset($_GET['stx']) ? trim($_GET['stx']) : ''; // 검색어
$gongjong = isset($_GET['gongjong']) ? trim($_GET['gongjong']) : ''; // 선택된 공종
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // 페이지 번호 (1 이상)
$sst = isset($_GET['sst']) ? trim($_GET['sst']) : 'seq'; // 정렬 필드
$sod = isset($_GET['sod']) ? trim($_GET['sod']) : 'desc'; // 정렬 순서

// --- 검색어 이스케이프 ---
$stx_escaped = '';
if ($stx) {
    if (isset($db) && method_exists($db, 'escape_like')) {
         $stx_escaped = $db->escape_like($stx);
    } else {
         $stx_escaped = addslashes(strip_tags($stx)); // 기본 처리
    }
}

// --- SQL 조건 설정 ---
$sql_common = " FROM {$none['enterprise_list']} "; // 테이블명 확인
$sql_search = " WHERE 1 "; // 기본 조건

// 텍스트 검색 조건
if ($stx_escaped) {
    // 검색 대상 필드 정의 (실제 필드명 확인 필요)
    $search_fields = ['no_category', 'no_company', 'no_baddr', 'no_name', 'no_btel', 'no_bname', 'no_gongjong', 'no_hp', 'no_bemail', 'no_email', 'no_tel']; // no_tel 추가
    $search_conditions = [];
    foreach ($search_fields as $field) {
        $search_conditions[] = "`{$field}` LIKE '%{$stx_escaped}%'";
    }
     $sql_search .= " AND (" . implode(" OR ", $search_conditions) . ")";
}

// 공종 필터 조건
if ($gongjong) {
    $gongjong_escaped = sql_real_escape_string($gongjong);
    $sql_search .= " AND `no_gongjong` = '{$gongjong_escaped}' ";
}

// --- 정렬 조건 ---
$sql_order = " ORDER BY `{$sst}` {$sod} ";

// --- 페이징 처리 ---
$sql_count = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
$row_count = sql_fetch($sql_count);
$total_count = $row_count['cnt'];

$rows = $config['cf_page_rows'] ?? 12;
$total_page = ceil($total_count / $rows);
$from_record = ($page - 1) * $rows;

// --- 데이터 조회 (no_tel 포함 확인) ---
$sql = " SELECT seq, no_category, no_company, no_bname, no_gongjong, no_btel, no_bemail, no_baddr, no_name, no_position, no_hp, no_email, no_tel /* no_tel 추가 */
         {$sql_common} {$sql_search} {$sql_order} LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);

// --- 공종 목록 정의 및 정렬 ---
$gongjong_list = [
    "가설공사", "가시설공사", "토공사", "철근콘크리트공사", "철골공사", "조적공사", "방수공사", "타일공사", "석공사", "목공사", "금속공사", "미장공사", "창호공사", "유리공사", "도장공사", "수장공사", "지붕및홈통공사", "판넬공사", "기타공사", "부대공사", "조경공사", "철거공사", "인테리어공사", "설비공사", "전기공사", "폐기물처리", "엘리베이터", "철근", "레미콘", "단열재", "운반", "장비업체", "용역업체", "건축사사무소", "철자재", "잡자재", "조명", "가구공사", "기술지도"
];
sort($gongjong_list, SORT_STRING | SORT_LOCALE_STRING);


// --- 쿼리스트링 생성 ---
$query_params = [];
if ($stx) $query_params['stx'] = $stx;
if ($gongjong) $query_params['gongjong'] = $gongjong;
if ($sst != 'seq') $query_params['sst'] = $sst;
if ($sod != 'desc') $query_params['sod'] = $sod;

$qstr = http_build_query($query_params);
$qstr_amp = $qstr ? '&amp;' . $qstr : '';

$qstr_for_edit = $qstr_amp;
if ($page > 1) {
    $qstr_for_edit .= '&amp;page=' . $page;
}

?>

<head>
<style>
    /* 카드 스타일 (건축주와 유사하게) */
    .enterprise-card { margin-bottom: 1.5rem; border: 1px solid #dee2e6; }
    .enterprise-card .card-body { padding: 1.25rem; }
    .enterprise-card .card-title { margin-bottom: 0.5rem; font-weight: 600; }
    .enterprise-card .card-subtitle { color: #6c757d; margin-bottom: 1rem; font-size: 0.9rem; }
    .enterprise-card .info-group { margin-bottom: 1rem; }
    .enterprise-card .info-group h6 { font-size: 0.9rem; color: #343a40; margin-bottom: 0.5rem; border-bottom: 1px solid #eee; padding-bottom: 0.3rem;}
    .enterprise-card .info-item { display: flex; align-items: center; margin-bottom: 0.4rem; font-size: 0.9rem; }
    .enterprise-card .info-item i { width: 1.5em; text-align: center; color: #6c757d; margin-right: 5px;}
    .enterprise-card .card-footer { background-color: #f8f9fa; border-top: 1px solid #dee2e6; padding: 0.75rem 1.25rem; text-align: right; }
    .enterprise-card .card-footer .btn { margin-left: 0.5rem; }

    /* 컨트롤 영역 스타일 */
    .list-controls-wrapper { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .list-controls-wrapper .filter-area { width: 250px; }
    .list-controls-wrapper .search-area { display: flex; align-items: center; }
    .list-controls-wrapper .search-area .form-inline { margin-right: 0.5rem; }

    /* 아이콘 기본 스타일 */
    .info-item .fa { /* FontAwesome 사용 가정 */ }
</style>
</head>

<div id="main-content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>업체관리</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">업체관리</li>
                    <li class="breadcrumb-item active">업체 리스트</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                     <h3 class="card-title">업체 목록</h3>
                </div>
                <div class="card-body">
                    <div class="list-controls-wrapper">
                         <div class="filter-area">
                             <form method="get" id="gongjongFilterForm" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
                                 <?php
                                 foreach ($query_params as $key => $value) {
                                     if ($key != 'gongjong') {
                                         echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                                     }
                                 }
                                 ?>
                                 <select name="gongjong" class="form-control" onchange="this.form.submit()">
                                     <option value="">== 전체 공종 ==</option>
                                     <?php foreach ($gongjong_list as $gj) { ?>
                                         <option value="<?php echo htmlspecialchars($gj); ?>" <?php echo get_selected($gongjong, $gj); ?>>
                                             <?php echo htmlspecialchars($gj); ?>
                                         </option>
                                     <?php } ?>
                                 </select>
                             </form>
                         </div>

                         <div class="search-area">
                             <form class="form-inline" method="get" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
                                 <?php
                                  foreach ($query_params as $key => $value) {
                                     if ($key != 'stx') {
                                         echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                                     }
                                 }
                                 ?>
                                 <div class="input-group">
                                     <input type="text" class="form-control" name="stx" value="<?php echo htmlspecialchars($stx); ?>" placeholder="통합 검색">
                                     <div class="input-group-append">
                                         <button type="submit" class="btn btn-outline-secondary"><i class="icon-magnifier"></i></button>
                                     </div>
                                 </div>
                             </form>
                             <a class="btn btn-primary" href="../write/menu1_write.php" role="button"><i class="fa fa-plus"></i> 업체등록</a>
                         </div>
                    </div>
                    <div class="row enterprise-card-list">
                        <?php
                        $list_num = $total_count - ($page - 1) * $rows;
                        for ($i = 0; $row = sql_fetch_array($result); $i++) {
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card enterprise-card h-100 d-flex flex-column">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['no_company'] ?? 'N/A'); ?></h5>
                                    <?php if(!empty($row['no_bname'])) { ?>
                                    <h6 class="card-subtitle mb-3">대표 : <?php echo htmlspecialchars($row['no_bname']); ?></h6>
                                    <?php } else { ?>
                                    <div style="height: 1.1rem; margin-bottom: 1rem;"></div>
                                    <?php } ?>

                                    <div class="info-group">
                                        <h6><i class="fa fa-info-circle"></i> 기본 정보</h6>
                                         <?php if(!empty($row['no_gongjong'])) { ?>
                                        <div class="info-item">
                                           <i class="fa fa-wrench"></i> <span><?php echo htmlspecialchars($row['no_gongjong']); ?></span>
                                        </div>
                                        <?php } ?>
                                        <?php if(!empty($row['no_category'])) { ?>
                                        <div class="info-item">
                                           <i class="fa fa-tags"></i> <span><?php echo htmlspecialchars($row['no_category']); ?></span>
                                        </div>
                                        <?php } ?>
                                        <?php if(!empty($row['no_btel'])) { ?>
                                        <div class="info-item">
                                           <i class="fa fa-phone-square"></i> <span><?php echo htmlspecialchars($row['no_btel']); ?></span>
                                        </div>
                                        <?php } ?>
                                        <?php if(!empty($row['no_bemail'])) { ?>
                                        <div class="info-item">
                                            <i class="fa fa-envelope-o"></i> <span><?php echo htmlspecialchars($row['no_bemail']); ?></span>
                                        </div>
                                        <?php } ?>
                                        <?php if(!empty($row['no_baddr'])) { ?>
                                        <div class="info-item">
                                           <i class="fa fa-map-marker"></i> <span><?php echo htmlspecialchars($row['no_baddr']); ?></span>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <?php // 담당자 이름, 연락처, 휴대폰 중 하나라도 있을 때만 그룹 표시
                                     if(!empty($row['no_name']) || !empty($row['no_tel']) || !empty($row['no_hp'])) { ?>
                                    <div class="info-group">
                                        <h6><i class="fa fa-user"></i> 담당자 정보</h6>
                                         <?php if(!empty($row['no_name'])) { ?>
                                        <div class="info-item">
                                            <i class="fa fa-user-circle-o"></i> <span>
                                                <?php echo htmlspecialchars($row['no_name']); ?>
                                                <?php if(!empty($row['no_position'])) echo ' / ' . htmlspecialchars($row['no_position']); ?>
                                            </span>
                                        </div>
                                         <?php } ?>

                                         <?php if(!empty($row['no_tel'])) { ?>
                                         <div class="info-item">
                                             <i class="fa fa-phone"></i> <span><?php echo htmlspecialchars($row['no_tel']); ?></span>
                                         </div>
                                         <?php } ?>

                                         <?php if(!empty($row['no_hp'])) { ?>
                                        <div class="info-item">
                                            <i class="fa fa-mobile"></i> <span><?php echo htmlspecialchars($row['no_hp']); ?></span>
                                        </div>
                                        <?php } ?>

                                        <?php /* 담당자 개인 이메일 필드가 있다면 (no_email)
                                        if(!empty($row['no_email'])) { ?>
                                        <div class="info-item">
                                            <i class="fa fa-envelope"></i> <span><?php echo htmlspecialchars($row['no_email']); ?></span>
                                        </div>
                                        <?php } */ ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="card-footer mt-auto">
                                    <a href="/_enterprise/write/menu1_write.php?w=u&amp;seq=<?php echo $row['seq']; ?><?php echo $qstr_for_edit; ?>" class="btn btn-sm btn-outline-primary" title="수정"><i class="fa fa-pencil"></i> 수정</a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="삭제" onclick="del_(<?php echo $row['seq']; ?>)"><i class="fa fa-trash"></i> 삭제</button>
                                </div>
                            </div> </div> <?php } // end for ?>

                        <?php if ($i == 0) { ?>
                        <div class="col-12">
                            <p class="text-center mt-4">등록된 업체 정보가 없습니다.</p>
                        </div>
                        <?php } ?>
                    </div><div class="mt-4 d-flex justify-content-center">
                        <?php
                        echo get_paging_none(G5_IS_MOBILE ? ($config['cf_mobile_pages'] ?? 10) : ($config['cf_write_pages'] ?? 10), $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page=');
                        ?>
                    </div>

                </div> </div> </div> </div> </div><script>
    function del_(seq) {
        if (confirm('정말 업체 정보를 삭제하시겠습니까?\n\n삭제된 정보는 복구할 수 없습니다.')) {
            const return_url = encodeURIComponent(location.pathname + location.search);
            location.href = '/_enterprise/write/menu1_update.php?w=d&seq=' + seq + '&return_url=' + return_url;
        } else {
            return false;
        }
    }
</script>

<?php include_once(NONE_PATH . '/footer.php'); ?>