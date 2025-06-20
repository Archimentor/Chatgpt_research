<?php
include_once('../../_common.php');
// 그누보드 썸네일 라이브러리 포함
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

define('menu_worksite', true);
include_once(NONE_PATH.'/header.php');

// --- 날짜 처리 및 필터 로직 ---
$today_date = date('Y-m-d');
$filter_by_specific_date = false;
$date = $today_date;
$other_filters_applied = (isset($_GET['filter_category']) && $_GET['filter_category'] != '') || (isset($_GET['filter_status']) && (int)$_GET['filter_status'] != 0) || (isset($_GET['filter_worksite']) && $_GET['filter_worksite'] != '');
if (isset($_GET['date'])) {
    if ($_GET['date'] == 'all') { $filter_by_specific_date = false; }
    elseif (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET['date'])) { $date = $_GET['date']; $filter_by_specific_date = true; }
    else { $date = $today_date; $filter_by_specific_date = !$other_filters_applied; }
} else { $date = $today_date; $filter_by_specific_date = !$other_filters_applied; }
if ($other_filters_applied && !$filter_by_specific_date && (!isset($_GET['date']) || $_GET['date'] != 'all')) { $filter_by_specific_date = false; }
$preDate = date('Y-m-d', strtotime($date." -1 day")); $nxtDate = date('Y-m-d', strtotime($date." +1 day")); $view_all_dates = !$filter_by_specific_date;

// --- 필터 변수 ---
$filter_category = isset($_GET['filter_category']) ? trim($_GET['filter_category']) : '';
$filter_status   = isset($_GET['filter_status']) ? (int)$_GET['filter_status'] : 0;
$filter_worksite = isset($_GET['filter_worksite']) ? trim($_GET['filter_worksite']) : '';
$page            = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// --- SQL 생성 ---
$sql_common = " FROM {$g5['board_file_table']} AS f LEFT JOIN {$none['smart_list']} AS s ON f.wr_id = s.seq LEFT JOIN {$none['worksite']} AS w ON s.work_id = w.nw_code ";
$sql_search = " WHERE f.bo_table = 'smart' AND f.bf_content = '' ";
if(isset($member['mb_level2']) && $member['mb_level2'] == 2) {
    $sql_search .= " AND ( w.nw_ptype1_1 = '{$member['mb_id']}' OR w.nw_ptype1_2 = '{$member['mb_id']}' OR w.nw_ptype1_3 = '{$member['mb_id']}' OR w.nw_ptype1_4 = '{$member['mb_id']}' OR w.nw_ptype1_5 = '{$member['mb_id']}' OR w.nw_ptype1_6 = '{$member['mb_id']}' OR w.nw_ptype2_1 = '{$member['mb_id']}' OR w.nw_ptype2_2 = '{$member['mb_id']}' OR w.nw_ptype2_3 = '{$member['mb_id']}' OR w.nw_ptype2_4 = '{$member['mb_id']}' OR w.nw_ptype2_5 = '{$member['mb_id']}' OR w.nw_ptype2_6 = '{$member['mb_id']}' ) ";
}
if ($filter_category) { $sql_search .= " AND f.bf_category = '".sql_real_escape_string($filter_category)."' "; }
if ($filter_status == 0 || $filter_status == 1) { $sql_search .= " AND w.nw_status = '".sql_real_escape_string($filter_status)."' "; }
if ($filter_worksite) { $sql_search .= " AND s.work_id = '".sql_real_escape_string($filter_worksite)."' "; }
if ($filter_by_specific_date) { $sql_search .= " AND s.ns_date = '".sql_real_escape_string($date)."' "; }
$sql_order = " ORDER BY s.work_id DESC, s.ns_date DESC, f.bf_category ASC, f.seq ASC ";
$sql = " SELECT f.seq, f.bf_source, f.bf_file, f.bf_category, s.seq AS smart_seq, s.ns_date, s.work_id, w.nw_subject, w.nw_status {$sql_common} {$sql_search} {$sql_order} ";
$result = sql_query($sql);

// --- PHP 데이터 그룹핑 ---
$grouped_photos = [];
while ($row = sql_fetch_array($result)) {
    $group_key = $row['work_id'] . '||' . ($view_all_dates ? $row['ns_date'] : $date);
    $category = $row['bf_category'] ?: '미분류';
    if (!isset($grouped_photos[$group_key])) { $grouped_photos[$group_key] = [ 'ns_date' => $row['ns_date'], 'work_id' => $row['work_id'], 'nw_subject' => $row['nw_subject'], 'nw_status' => $row['nw_status'], 'categories' => [] ]; }
    if (!isset($grouped_photos[$group_key]['categories'][$category])) { $grouped_photos[$group_key]['categories'][$category] = []; }
    $grouped_photos[$group_key]['categories'][$category][] = $row;
}

// --- 필터용 데이터 조회 ---
$category_sql = "SELECT DISTINCT bf_category FROM {$g5['board_file_table']} WHERE bo_table = 'smart' AND bf_category != '' ORDER BY bf_category ASC";
$category_result = sql_query($category_sql);
$worksite_filter_sql = "SELECT nw_code, nw_subject FROM {$none['worksite']} WHERE 1=1 ";
if(isset($member['mb_level2']) && $member['mb_level2'] == 2) {
    $worksite_filter_sql .= " AND ( nw_ptype1_1 = '{$member['mb_id']}' OR nw_ptype1_2 = '{$member['mb_id']}' OR nw_ptype1_3 = '{$member['mb_id']}' OR nw_ptype1_4 = '{$member['mb_id']}' OR nw_ptype1_5 = '{$member['mb_id']}' OR nw_ptype1_6 = '{$member['mb_id']}' OR w.nw_ptype2_1 = '{$member['mb_id']}' OR w.nw_ptype2_2 = '{$member['mb_id']}' OR w.nw_ptype2_3 = '{$member['mb_id']}' OR w.nw_ptype2_4 = '{$member['mb_id']}' OR w.nw_ptype2_5 = '{$member['mb_id']}' OR w.nw_ptype2_6 = '{$member['mb_id']}' ) ";
}
if ($filter_status == 0 || $filter_status == 1) { $worksite_filter_sql .= " AND nw_status = '".sql_real_escape_string($filter_status)."' "; }
$worksite_filter_sql .= " ORDER BY nw_code DESC ";
$worksite_filter_result = sql_query($worksite_filter_sql);

// --- 쿼리스트링 생성 ---
$qstr_arr = [];
foreach ($_GET as $key => $value) { if ($key != 'page' && $key != 'date') { $qstr_arr[$key] = $value; } }
$qstr = http_build_query($qstr_arr);
$base_link_date = $_SERVER['SCRIPT_NAME'] . '?' . $qstr;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://unpkg.com/smartphoto@1.1.0/css/smartphoto.min.css">
<style>
    /* 컬럼 폭 조정 및 사진 그룹 스타일 */
    .photo-list-table th, .photo-list-table td { vertical-align: middle; text-align: center; padding: 0.5rem; }
    .photo-list-table .thumb { max-width: 80px; max-height: 80px; cursor: pointer; border: 1px solid #ddd; padding: 2px; object-fit: cover; margin: 2px; }
    .photo-list-table .text-left { text-align: left; }
    .filter-section .form-control, .filter-section .btn { height: calc(1.5em + .75rem + 2px); padding: .375rem .75rem; font-size: .9rem; }
    .smartphoto-caption { font-size: 1rem; padding-top: 10px; }
    .filter-controls > * { margin-right: 0.5rem; margin-bottom: 0.5rem; }
    .filter-section { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; }
    .date-controls { display: flex; align-items: center; }
    .filter-controls { display: flex; align-items: center; }
    /* .photo-list-table .col-date { width: 10%; } -- 날짜 컬럼 제거됨 */
    .photo-list-table .col-worksite { width: 25%; }
    .photo-list-table .col-category { width: 15%; font-weight: bold; }
    .photo-list-table .col-photos { width: 60%; text-align: left; }
    .photo-group { display: flex; flex-wrap: wrap; gap: 5px; align-items: center; padding: 5px 0; }
    .group-row > td { border-top: 2px solid #dee2e6; }
    .group-row:first-child > td { border-top: none; }
</style>

<div id="main-content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> 현장 사진 목록</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">현장관리</li>
                    <li class="breadcrumb-item active">사진 목록 (스마트일보)</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="body">
                    <div class="filter-section mb-3">
                        <div class="date-controls">
                            <div class="btn-group" role="group">
                                <a href="<?php echo $base_link_date; ?>&amp;date=<?php echo $preDate; ?>" class="btn btn-secondary">&lt;</a>
                                <button type="button" class="btn btn-secondary" id="datePicker"><?php echo $date; ?></button>
                                <a href="<?php echo $base_link_date; ?>&amp;date=<?php echo $nxtDate; ?>" class="btn btn-secondary">&gt;</a>
                            </div>
                        </div>
                        <form method="get" class="form-inline filter-controls" id="filterForm">
                            <input type="hidden" name="date" value="all">
                             <select name="filter_category" id="filter_category" class="form-control">
                                <option value="">공종분류 전체</option>
                                <?php sql_data_seek($category_result, 0); while ($cat = sql_fetch_array($category_result)) { $cat_name = htmlspecialchars($cat['bf_category']); echo '<option value="'.$cat_name.'" '.get_selected($filter_category, $cat_name).'>'.$cat_name.'</option>'; } ?>
                            </select>
                            <select name="filter_status" id="filter_status" class="form-control" onchange="this.form.submit()">
                                <option value="-1" <?php echo get_selected($filter_status, -1); ?>>현장상태 전체</option>
                                <option value="0" <?php echo get_selected($filter_status, 0); ?>>진행중</option>
                                <option value="1" <?php echo get_selected($filter_status, 1); ?>>완료</option>
                            </select>
                            <select name="filter_worksite" id="filter_worksite" class="form-control">
                                <option value="">현장 전체</option>
                                <?php
                                sql_data_seek($worksite_filter_result, 0);
                                while ($ws = sql_fetch_array($worksite_filter_result)) {
                                    $ws_code = htmlspecialchars($ws['nw_code']);
                                    $ws_subj = htmlspecialchars($ws['nw_subject']);
                                    echo '<option value="'.$ws_code.'" '.get_selected($filter_worksite, $ws_code).'>['.$ws_code.'] '.$ws_subj.'</option>';
                                }
                                ?>
                            </select>
                            <button type="submit" class="btn btn-primary">필터 적용</button>
                            <?php
                            $is_filtered = ($filter_category || $filter_status != 0 || $filter_worksite || $date != $today_date);
                            if ($is_filtered):
                            ?>
                            <a href="<?php echo $_SERVER['SCRIPT_NAME'].'?date='.$today_date.'&filter_status=0'; ?>" class="btn btn-outline-secondary">필터 초기화</a>
                            <?php endif; ?>
                        </form>
                     </div>
                    <div class="table-responsive">
                        <table class="table table-hover photo-list-table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <?php if ($view_all_dates): ?> <th class="col-date">작업일자</th> <?php endif; ?>
                                    <th class="col-worksite">현장명</th>
                                    <th class="col-category">공종분류</th>
                                    <th class="col-photos">사진</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($grouped_photos) > 0) {
                                    $first_group_in_page = true;
                                    foreach ($grouped_photos as $group_key => $group_data) {
                                        $group_class = $first_group_in_page ? '' : 'group-row';
                                        $date_display = htmlspecialchars($group_data['ns_date']);
                                        $status_badge = ($group_data['nw_status']) ? '<span class="badge badge-success">완료</span>' : '<span class="badge badge-warning">진행중</span>';
                                        $first_category_key = array_key_first($group_data['categories']);
                                        $first_photo_in_group = $group_data['categories'][$first_category_key][0] ?? null;
                                        $smart_seq_link = $first_photo_in_group ? $first_photo_in_group['smart_seq'] : '#';
                                        $worksite_display = '<a href="../view/menu3_view.php?seq='.$smart_seq_link.'" target="_blank">['.htmlspecialchars($group_data['work_id']).'] '.htmlspecialchars($group_data['nw_subject']).'</a> '.$status_badge;
                                        $category_count = count($group_data['categories']);
                                        $first_category_in_group = true;

                                        foreach ($group_data['categories'] as $category => $photos_in_category) {
                                            $row_class = $group_class . ($first_category_in_group ? '' : ' category-continue');
                                ?>
                                <tr class="<?php echo $row_class; ?>">
                                    <?php if ($first_category_in_group): ?>
                                        <?php if ($view_all_dates): ?>
                                        <td rowspan="<?php echo $category_count; ?>" class="col-date"><?php echo $date_display; ?></td>
                                        <?php endif; ?>
                                        <td rowspan="<?php echo $category_count; ?>" class="col-worksite text-left"><?php echo $worksite_display; ?></td>
                                    <?php endif; ?>
                                    <td class="col-category"><?php echo htmlspecialchars($category); ?></td>
                                    <td class="col-photos">
                                        <div class="photo-group">
                                        <?php
                                        foreach ($photos_in_category as $photo_row) {
                                            $image_exists = false; $thumb_url = ''; $original_img_url = ''; $debug_msg = '';
                                            if (!empty($photo_row['bf_file']) && defined('NONE_PATH') && defined('NONE_URL')) {
                                                $image_directory_name = 'smart'; $server_base_path = rtrim(NONE_PATH, '/'); $web_base_url = rtrim(NONE_URL, '/');
                                                $server_dir_path = $server_base_path . '/_data/' . $image_directory_name; $server_file_path = $server_dir_path . '/' . $photo_row['bf_file'];
                                                $web_dir_url = $web_base_url . '/_data/' . $image_directory_name; $original_img_url = $web_dir_url . '/' . $photo_row['bf_file'];
                                                if (function_exists('thumbnail')) {
                                                     clearstatcache(true, $server_file_path); if (@file_exists($server_file_path) && @is_file($server_file_path)) {
                                                        $thumb_target_path = $server_dir_path; $thumb_filename = thumbnail($photo_row['bf_file'], $server_dir_path, $thumb_target_path, 80, 80, false, true);
                                                        if ($thumb_filename && file_exists($thumb_target_path.'/'.$thumb_filename)) { $thumb_url = $web_dir_url . '/' . $thumb_filename; $image_exists = true; }
                                                        else { $debug_msg = "Thumb fail."; $thumb_url = $original_img_url; $image_exists = true; } } else { $debug_msg = "No original file."; } }
                                                else { $debug_msg = "No thumb func."; clearstatcache(true, $server_file_path); if (@file_exists($server_file_path) && @is_file($server_file_path)){ $thumb_url = $original_img_url; $image_exists = true; } else { $debug_msg .= " No original file."; } } }
                                            else { $debug_msg = "Constants/filename missing."; }
                                            $smartphoto_attrs = $image_exists ? 'href="'.$original_img_url.'" class="js-smartPhoto" data-caption="['.htmlspecialchars($photo_row['work_id']).'] '.htmlspecialchars($photo_row['nw_subject']).' ('.htmlspecialchars($photo_row['ns_date']).') - '.htmlspecialchars($photo_row['bf_category']).' / '.htmlspecialchars($photo_row['bf_source']).'" data-id="'.$photo_row['seq'].'" data-group="worksite-photos-'.$group_key.'-'.$category.'"' : 'href="#" class="text-muted" onclick="alert(\'이미지 오류: '.htmlspecialchars(str_replace("'", "\\'", $debug_msg), ENT_QUOTES).'\'); return false;"';
                                            if ($image_exists && $thumb_url) { echo '<a '.$smartphoto_attrs.'><img src="'.$thumb_url.'" alt="'.htmlspecialchars($photo_row['bf_source']).'" class="thumb"></a>'; }
                                        }
                                        ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                            $first_category_in_group = false;
                                        } // end foreach category
                                        $first_group_in_page = false;
                                    } // end foreach group
                                } else {
                                ?>
                                <tr>
                                    <td colspan="3">데이터가 없습니다.</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    </div> </div> </div> </div> </div> 
                    
                    
                    
<?php include_once(NONE_PATH.'/footer.php');?>            
      
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ko.min.js"></script>
<script src="https://unpkg.com/smartphoto@1.1.0/js/smartphoto.min.js"></script>



<script>
// jQuery의 $(document).ready() 와 동일한 역할
document.addEventListener('DOMContentLoaded', function() {
    // SmartPhoto 초기화
    if (typeof SmartPhoto !== 'undefined') {
        try {
            new SmartPhoto(".js-smartPhoto", { useOrientationApi: true });
            console.log('SmartPhoto initialized.');
        } catch(e) {
            console.error('SmartPhoto initialization failed:', e);
        }
    } else {
        console.warn('SmartPhoto library not found.');
    }

     // Datepicker 초기화 (jQuery 사용)
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.datepicker !== 'undefined') {
        console.log('Initializing datepicker for #datePicker');

        // menu3_list.php 와 동일하게 버튼에 Datepicker 초기화
        $('#datePicker').datepicker({
            format: "yyyy-mm-dd",
            language : "ko",
            autoclose: true,
            todayHighlight: true
        }).on("changeDate", function(e) {
            if (e.date) {
                console.log('Date changed via datepicker:', e.date);
                var newDate = e.date.getFullYear() + '-' + String(e.date.getMonth() + 1).padStart(2, '0') + '-' + String(e.date.getDate()).padStart(2, '0');
                var currentParams = new URLSearchParams(window.location.search);
                currentParams.delete('page');
                currentParams.set('date', newDate);
                if ($('#filter_category').val()) currentParams.set('filter_category', $('#filter_category').val()); else currentParams.delete('filter_category');
                currentParams.set('filter_status', $('#filter_status').val());
                if ($('#filter_worksite').val()) currentParams.set('filter_worksite', $('#filter_worksite').val()); else currentParams.delete('filter_worksite');
                window.location.href = window.location.pathname + '?' + currentParams.toString();
            }
        });

        // 버튼 클릭 시 달력 표시 (라이브러리 기본 동작에 의존)

    } else {
         if (typeof jQuery === 'undefined') { console.error("jQuery is not loaded. Datepicker initialization needs jQuery."); }
         else { console.error("$.fn.datepicker is not defined. Check bootstrap-datepicker.min.js load order/path."); }
    }
});
</script>

