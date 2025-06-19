<?php
include_once('../../_common.php');
define('menu_owner', true);
include_once(NONE_PATH.'/header.php'); // 경로 확인 필요

// --- 검색어 처리 ---
$stx = isset($_GET['stx']) ? trim($_GET['stx']) : '';
$stx_escaped = '';
if ($stx) {
    // GnuBoard $db 객체가 있다고 가정, SQL 인젝션 방지
    if (isset($db) && method_exists($db, 'escape_like')) {
         $stx_escaped = $db->escape_like($stx);
    } else {
         // $db 객체나 escape_like 메소드가 없다면, 기본적인 처리 (주의: 완벽하지 않음)
         $stx_escaped = addslashes(strip_tags($stx));
    }
}


// --- SQL 조건 설정 ---
$sql_common = " FROM {$none['owner_list']} "; // 테이블명 확인 필요
$sql_search = " WHERE 1 "; // 기본 조건

// 검색 조건 추가
if ($stx_escaped) {
    // 필드명 확인 필요 (예: 법인주소 no_baddr, 개인주소 no_addr 등)
    $sql_search .= " AND ( no_company LIKE '%{$stx_escaped}%'
                       OR no_baddr LIKE '%{$stx_escaped}%' /* 법인주소 필드로 가정 */
                       OR no_name LIKE '%{$stx_escaped}%'
                       OR no_tel LIKE '%{$stx_escaped}%'
                       OR no_hp LIKE '%{$stx_escaped}%' ) ";
}

// --- 정렬 조건 설정 ---
if (!$sst) {
    $sst  = "seq";    // 기본 정렬 필드
    $sod = "desc";   // 기본 정렬 순서
}
$sql_order = " ORDER BY {$sst} {$sod} ";

// --- 페이징 처리 ---
$sql_count = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
$row_count = sql_fetch($sql_count);
$total_count = $row_count['cnt'];

// 페이지당 목록 수 (카드 형태 고려, 예: 12)
$rows = $config['cf_page_rows'] ?? 12;
$total_page  = ceil($total_count / $rows);
if ($page < 1) { $page = 1; }
$from_record = ($page - 1) * $rows;

// --- 데이터 조회 ---
$sql = " SELECT seq, no_company, no_bnum, no_baddr, no_bemail, no_name, no_tel, no_hp, no_email
         {$sql_common} {$sql_search} {$sql_order} LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);

$qstr = 'stx=' . urlencode($stx); // 검색어 유지

?>
<head>
    <style>
        /* 카드 스타일 */
        .owner-card {
             margin-bottom: 1.5rem;
             /* 카드 외곽선 추가/강조 */
             border: 1px solid #dee2e6; /* Bootstrap 테이블 테두리 색상 활용 */
             /* 또는 좀 더 진하게: border: 1px solid #adb5bd; */
             /* 또는 단순 회색: border: 1px solid #ccc; */
        }
        .owner-card .card-body { padding: 1.25rem; }
        .owner-card .card-title { margin-bottom: 0.5rem; font-weight: 600; }
        .owner-card .card-subtitle { color: #6c757d; margin-bottom: 1rem; }
        .owner-card .info-group { margin-bottom: 1rem; }
        .owner-card .info-group h6 { font-size: 0.9rem; color: #343a40; margin-bottom: 0.5rem; border-bottom: 1px solid #eee; padding-bottom: 0.3rem;}
        .owner-card .info-item { display: flex; align-items: center; margin-bottom: 0.4rem; font-size: 0.9rem; }
        .owner-card .info-item i { width: 1.5em; text-align: center; color: #6c757d; margin-right: 5px;}
        .owner-card .card-footer { background-color: #f8f9fa; border-top: 1px solid #dee2e6; padding: 0.75rem 1.25rem; text-align: right; }
        .owner-card .card-footer .btn { margin-left: 0.5rem; }

        /* 컨트롤 영역 스타일 */
        .list-controls { display: flex; justify-content: flex-end; align-items: center; }
        .list-controls .form-inline { margin-right: 0.5rem; }

        /* 아이콘 기본 스타일 */
        .info-item .fa { /* FontAwesome 사용 가정 */ }

    </style>
</head>

<div id="main-content">
<div class="block-header">
    <div class="row">
        <div class="col-lg-5 col-md-8 col-sm-12">
            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>건축주</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item">건축주</li>
                <li class="breadcrumb-item active">건축주 리스트</li>
            </ul>
        </div>
    </div>
</div>
 <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">건축주 목록</h3>
                    <div class="list-controls">
                         <form method="get" class="form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control" name="stx" value="<?php echo htmlspecialchars(stripslashes($stx)); ?>" placeholder="통합 검색">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-secondary"><i class="icon-magnifier"></i></button>
                                </div>
                            </div>
                        </form>
                        <a class="btn btn-primary" href="../write/menu1_write.php" role="button"><i class="fa fa-plus"></i> 정보등록</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row owner-card-list">
                        <?php
                        $list_num = $total_count - ($page - 1) * $rows;
                        for($i=0; $row=sql_fetch_array($result); $i++) {
                        ?>
                        <div class="col-md-6 col-lg-4">
                             <div class="card owner-card h-100 d-flex flex-column">
                                <div class="card-body"> <?php if($row['no_company']) { ?>
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['no_company']); ?></h5>
                                    <?php if($row['no_name']) { ?>
                                    <h6 class="card-subtitle mb-2 text-muted">건축주 : <?php echo htmlspecialchars($row['no_name']); ?></h6>
                                    <?php } ?>
                                    <hr class="mt-1 mb-3">
                                    <?php } else if($row['no_name']) { ?>
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['no_name']); ?></h5>
                                    <hr class="mt-1 mb-3">
                                    <?php } ?>


                                    <?php if($row['no_company']) { ?>
                                    <div class="info-group">
                                        <h6><i class="fa fa-building-o"></i> 법인 정보</h6>
                                        <?php if($row['no_bnum']) { ?>
                                        <div class="info-item">
                                           <i class="fa fa-vcard-o"></i> <span><?php echo htmlspecialchars($row['no_bnum']); ?></span>
                                        </div>
                                        <?php } ?>
                                        <?php if($row['no_baddr']) { ?>
                                        <div class="info-item">
                                           <i class="fa fa-map-marker"></i> <span><?php echo htmlspecialchars($row['no_baddr']); ?></span>
                                        </div>
                                         <?php } ?>
                                        <?php if($row['no_bemail']) { ?>
                                        <div class="info-item">
                                            <i class="fa fa-envelope-o"></i> <span><?php echo htmlspecialchars($row['no_bemail']); ?></span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>

                                    <div class="info-group">
                                         <h6><i class="fa fa-user-o"></i> 건축주 정보</h6>
                                        <?php if(!$row['no_company'] && $row['no_name']) { /* 법인명 없을때만 이름 표시 */ ?>
                                        <div class="info-item">
                                           <i class="fa fa-user"></i> <strong><?php echo htmlspecialchars($row['no_name']); ?></strong>
                                        </div>
                                         <?php } ?>
                                         <?php if($row['no_hp']) { ?>
                                        <div class="info-item">
                                            <i class="fa fa-mobile"></i> <span><?php echo htmlspecialchars($row['no_hp']); ?></span>
                                        </div>
                                        <?php } ?>
                                        <?php if($row['no_tel']) { ?>
                                        <div class="info-item">
                                            <i class="fa fa-phone"></i> <span><?php echo htmlspecialchars($row['no_tel']); ?></span>
                                        </div>
                                        <?php } ?>
                                        <?php if($row['no_email']) { ?>
                                        <div class="info-item">
                                            <i class="fa fa-envelope"></i> <span><?php echo htmlspecialchars($row['no_email']); ?></span>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>
                                <div class="card-footer mt-auto">
                                    <a href="/_owner/write/menu1_write.php?w=u&amp;seq=<?php echo $row['seq'] . '&' . $qstr; ?>" class="btn btn-sm btn-outline-primary" title="수정"><i class="fa fa-pencil"></i> 수정</a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="삭제" onclick="del_(<?php echo $row['seq']; ?>)"><i class="fa fa-trash"></i> 삭제</button>
                                </div>
                            </div> </div> <?php
                            $list_num--;
                        } // end for
                        ?>

                        <?php if($i == 0) {?>
                        <div class="col-12">
                            <p class="text-center">등록된 건축주 정보가 없습니다.</p>
                        </div>
                        <?php }?>
                    </div><div class="mt-4">
                        <?php echo get_paging_none(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
                    </div>

                </div> </div> </div> </div> </div><script>
function del_(seq) {
    if(confirm('정말 건축주 정보를 삭제하시겠습니까?\n\n삭제된 정보는 복구할 수 없습니다.')) {
        // 삭제 처리 페이지 URL 확인 필요
        location.href = '/_owner/write/menu1_update.php?w=d&seq='+seq;
    } else {
        return false;
    }
}
</script>

<?php include_once(NONE_PATH.'/footer.php'); // 경로 확인 필요 ?>