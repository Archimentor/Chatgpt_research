<?php 
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php'); 

$sql_common = " FROM {$none['worksite']} ";
$sql_search = " WHERE (1) ";

// 현장소장 권한일 경우 본인 현장만 나오도록 필터링
if($member['mb_level2'] == 2) {
    $sql_search .= " AND (
        nw_ptype1_1 = '{$member['mb_id']}' OR
        nw_ptype1_2 = '{$member['mb_id']}' OR
        nw_ptype1_3 = '{$member['mb_id']}' OR
        nw_ptype1_4 = '{$member['mb_id']}' OR
        nw_ptype1_5 = '{$member['mb_id']}' OR
        nw_ptype1_6 = '{$member['mb_id']}' OR
        nw_ptype2_1 = '{$member['mb_id']}' OR
        nw_ptype2_2 = '{$member['mb_id']}' OR
        nw_ptype2_3 = '{$member['mb_id']}' OR
        nw_ptype2_4 = '{$member['mb_id']}' OR
        nw_ptype2_5 = '{$member['mb_id']}' OR
        nw_ptype2_6 = '{$member['mb_id']}'
    ) ";
}

if ($stx) {
    $sql_search .= " AND ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl LIKE '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " (nw_subject LIKE '%$stx%' OR nw_code LIKE '%$stx%') ";
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "nw_code";
    $sod = "desc";
}
$sql_order = " ORDER BY $sst $sod ";

$sql = "SELECT COUNT(*) AS cnt {$sql_common} {$sql_search} {$sql_order}";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows);
if ($page < 1) { $page = 1; }
$from_record = ($page - 1) * $rows;

$sql = "SELECT * {$sql_common} {$sql_search} {$sql_order} LIMIT {$from_record}, {$rows}";
$result = sql_query($sql);

// 작업일수 계산 함수 (이미 정의되어 있을 경우 중복 선언 방지)
if (!function_exists('calculate_work_days')) {
    function calculate_work_days($start_date, $end_date) {
        $today = date('Y-m-d');
        if(strtotime($today) <= strtotime($end_date)) {
            // 아직 마감일이 지나지 않음
            $days = (strtotime($today) - strtotime($start_date)) / (60 * 60 * 24);
            return ceil($days);
        } else {
            // 마감일이 지남
            $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
            return ceil($days);
        }
    }
}

// 실제 구현에 맞게 수정된 함수들 (이미 none.functions.php에 정의되어 있을 경우 중복 선언 방지)
if (!function_exists('get_enterprise_txt')) {
    function get_enterprise_txt($ptype) {
        return htmlspecialchars($ptype);
    }
}

if (!function_exists('get_manager_txt')) {
    function get_manager_txt($ptype) {
        return htmlspecialchars($ptype);
    }
}

if (!function_exists('get_owner_txt')) {
    function get_owner_txt($ptype) {
        return htmlspecialchars($ptype);
    }
}
?>

<!-- 시공현장 리스트 -->
<div id="main-content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">                        
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    시공현장
                </h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item">현장관리</li>
                    <li class="breadcrumb-item active">시공현장</li>
                </ul>
            </div>            
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="body">
                    <?php if($member['mb_level2'] != 2) { ?>
                        <a class="btn btn-primary float-right" href="../write/menu1_write.php" role="button">시공현장 등록</a> 
                    <?php } ?>
                    
                    <!-- 검색 폼 -->
                    <form class="float-right" style="margin-right:5px" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="input-group">
                            <input type="text" name="stx" value="<?php echo htmlspecialchars($stx); ?>" class="form-control" placeholder="현장명 또는 현장코드">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit"><i class="icon-magnifier"></i></button>
                            </div>
                        </div>
                    </form>
                    
                    <div style="clear: both;"></div>
                    
                    <!-- 시공현장 목록 표 -->
                    <div class="table-responsive">
                        <table class="table m-b-0 table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>현장코드</th>
                                    <th>현장명</th>
                                    <th>공사기간</th>
                                    <th>공급가액</th>
                                    <th>부가세</th>
                                    <th>계약금액</th>
                                    <th>현금금액</th>
                                    <!--<th>총 공사금액</th>-->
                                    <th>법인명(건축주)</th>
                                    <th>현장소장</th>
                                    <th>건축사</th>
                                    <th>진행상태</th>
                                    <th>메인노출</th>
                                    <th>관리</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                for($i=0; $row=sql_fetch_array($result); $i++) {
                                    
                                    // 상태 표시
                                    if($row['nw_status'])
                                        $status = '<span class="badge badge-success">완료</span>';
                                    else
                                        $status = '<span class="badge badge-warning">진행중</span>';
                                    
                                    // 메인 노출 여부
                                    if($row['nw_main_open'])
                                        $open = '<span class="badge badge-success">노출중</span>';
                                    else
                                        $open = '<span class="badge badge-secondary">노출안함</span>';
                                    
                                    // 관리 버튼
                                    if($member['mb_level2'] == 2) {
                                        $manage_buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="location.href=\'/_worksite/write/menu1_write.php?w=u&seq=' . htmlspecialchars($row['seq']) . '\'">보기</button>';
                                    } else {
                                        $manage_buttons = '<button type="button" class="btn btn-primary btn-sm" onclick="location.href=\'/_worksite/write/menu1_write.php?w=u&seq=' . htmlspecialchars($row['seq']) . '\'">수정</button> ';
                                        $manage_buttons .= '<button type="button" class="btn btn-danger btn-sm" onclick="del_(' . htmlspecialchars($row['seq']) . ')">삭제</button>';
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <a href="/_worksite/write/menu1_write.php?w=u&seq=<?php echo htmlspecialchars($row['seq']); ?>">
                                            <?php echo htmlspecialchars($row['nw_code']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="detail-link" data-site-id="<?php echo urlencode($row['nw_code']); ?>">
                                            <?php echo htmlspecialchars($row['nw_subject']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo substr($row['nw_sdate'], 2, 10); ?>~<?php echo substr($row['nw_edate'], 2, 10); ?></td>
                                    <td style="color:#cf3434"><?php echo number_format($row['nw_price1']); ?>원</td>
                                    <td style="color:#cf3434"><?php echo number_format($row['nw_vat']); ?>원</td>
                                    <td style="color:#cf3434"><?php echo number_format($row['nw_contract_price']); ?>원</td>
                                    <td style="color:#cf3434"><?php echo number_format($row['nw_price2']); ?>원</td>
                                    <!--<td style="color:#cf3434"><?php echo number_format($row['nw_total_price']); ?>원</td>-->
                                    <td>
                                        <a href="javascript:void(0);" class="owner-link" data-owner-id="<?php echo urlencode($row['nw_ptype3_1']); ?>" data-site-id="<?php echo urlencode($row['nw_code']); ?>">
                                            <?php echo get_owner_txt($row['nw_ptype3_1']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo get_manager_txt($row['nw_ptype1_1']); ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="architect-link" data-architect-id="<?php echo urlencode($row['nw_ptype4_1']); ?>" data-site-id="<?php echo urlencode($row['nw_code']); ?>">
                                            <?php echo get_enterprise_txt($row['nw_ptype4_1']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo $status; ?></td>
                                    <td><?php echo $open; ?></td>
                                    <td>
                                        <?php echo $manage_buttons; ?>
                                    </td>
                                </tr>
                                <!-- 상세 정보가 표시될 공간 -->
                                <tr class="detail-row" id="detail-<?php echo htmlspecialchars($row['nw_code']); ?>" style="display: none;">
                                    <td colspan="13">
                                        <div class="detail-content">
                                            <!-- AJAX로 상세 정보가 로드됩니다. -->
                                            로딩 중...
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($i == 0) {?> 
                                <tr>
                                    <td colspan="13" class="align-center">검색 된 데이터가 없습니다.</td> 
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- 페이징 -->
                    <?php echo get_paging_none(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// DOMContentLoaded 이벤트를 사용하여 HTML이 모두 로드된 후 스크립트를 실행
document.addEventListener('DOMContentLoaded', function() {
    // 공통 함수: 상세 정보 로드 및 토글
    function handleDetailClick(event, type, id, siteId) {
        event.preventDefault();

        var detailRow = document.getElementById('detail-' + encodeURIComponent(siteId));
        var detailContent = detailRow.querySelector('.detail-content');

        // 현재 로드된 타입 가져오기
        var loadedType = detailContent.getAttribute('data-loaded-type');

        if (detailRow.style.display === 'table-row' && loadedType === type) {
            // 이미 열려 있고 동일한 타입인 경우 닫기
            detailRow.style.display = 'none';
            detailContent.setAttribute('data-loaded-type', '');
            detailContent.setAttribute('data-loaded', 'false');
        } else {
            // 모든 상세 행 숨기기
            document.querySelectorAll('.detail-row').forEach(function(row) {
                row.style.display = 'none';
                row.querySelector('.detail-content').setAttribute('data-loaded-type', '');
                row.querySelector('.detail-content').setAttribute('data-loaded', 'false');
            });

            // 현재 상세 행 표시
            detailRow.style.display = 'table-row';

            // 로드할 타입 설정
            detailContent.setAttribute('data-loaded-type', type);

            // 로드 여부 확인
            if (detailContent.getAttribute('data-loaded') !== 'true' || loadedType !== type) {
                // 로딩 상태 표시
                detailContent.innerHTML = '로딩 중...';

                // AJAX 요청 URL 설정
                var url = '';
                if (type === 'site') {
                    url = 'menu1_detail.php?site_id=' + encodeURIComponent(id);
                } else if (type === 'owner') {
                    url = 'menu1_bowner.php?owner_id=' + encodeURIComponent(id);
                } else if (type === 'architect') {
                    url = 'menu1_architects.php?architect_id=' + encodeURIComponent(id);
                }

                // AJAX 요청
                var xhr = new XMLHttpRequest();
                xhr.open('GET', url, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            detailContent.innerHTML = xhr.responseText;
                            detailContent.setAttribute('data-loaded', 'true');
                        } else {
                            var errorMsg = '';
                            if (type === 'site') {
                                errorMsg = '상세 정보를 불러오는 데 실패했습니다.';
                            } else if (type === 'owner') {
                                errorMsg = '건축주 정보를 불러오는 데 실패했습니다.';
                            } else if (type === 'architect') {
                                errorMsg = '건축사 정보를 불러오는 데 실패했습니다.';
                            }
                            detailContent.innerHTML = '<div class="alert alert-danger">' + errorMsg + '</div>';
                            detailContent.setAttribute('data-loaded', 'false');
                        }
                    }
                };
                xhr.send();
            }
        }
    }

    // 현장명 클릭 시 상세 정보 로드
    document.querySelectorAll('.detail-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            var siteId = this.getAttribute('data-site-id');
            handleDetailClick(event, 'site', siteId, siteId);
        });
    });

    // 건축주 클릭 시 상세 정보 로드
    document.querySelectorAll('.owner-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            var ownerId = this.getAttribute('data-owner-id');
            var siteId = this.getAttribute('data-site-id');
            handleDetailClick(event, 'owner', ownerId, siteId);
        });
    });

    // 건축사 클릭 시 상세 정보 로드
    document.querySelectorAll('.architect-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            var architectId = this.getAttribute('data-architect-id');
            var siteId = this.getAttribute('data-site-id');
            handleDetailClick(event, 'architect', architectId, siteId);
        });
    });
});

</script>

<style>
/* 상태 선택 버튼 스타일링 */
/* 기존 스타일 유지 */

/* 테이블 스타일 조정 */
.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}

/* 반응형 디자인 */
@media (max-width: 768px) {
    #main-content {
        margin-left: 0;
        padding: 10px;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .table th, .table td {
        padding: 8px 10px;
        font-size: 12px;
    }
    .btn-group .btn {
        padding: 6px 12px;
        font-size: 12px;
    }
}

/* 상세 정보 행 스타일 */
.detail-row {
    background-color: #f9f9f9;
}
.detail-content {
    padding: 10px;
}
</style>

<?php include_once(NONE_PATH.'/footer.php'); ?>
