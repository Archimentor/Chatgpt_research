<?php
include_once('../../_common.php');
define('menu_statistics', true);
include_once(NONE_PATH.'/header.php');

// =============== (1) 퇴사자 숨기기용 함수 ===============
function get_manager_txt_local($mb_id) {
    if (!$mb_id) return '';
    $mb = get_member($mb_id, 'mb_id, mb_2, mb_name, mb_3');
    if (!$mb || !$mb['mb_id']) return '';
    if ($mb['mb_2'] == 11) return ''; // 퇴사자이면 빈 문자열
    return $mb['mb_name'].' '.get_mposition_txt($mb['mb_3']);
}

function get_admin_txt_local($mb_id) {
    if (!$mb_id) return '';
    $mb = get_member($mb_id, 'mb_id, mb_2, mb_name, mb_3');
    if (!$mb || !$mb['mb_id']) return '';
    if ($mb['mb_2'] == 11) return '';
    return $mb['mb_name'].' '.get_mposition_txt($mb['mb_3']);
}
// ======================================================

// 파라미터
$type = isset($_GET['type']) && $_GET['type'] ? (int)$_GET['type'] : 1;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;

// 기본 쿼리
$sql_common = " from {$none['worksite']} ";
$sql_search = " where 1=1 ";

// 정렬
if ($type == 1) {
    $sst = "nw_code";
    $sod = "desc";
} else {
    $sst = "nw_sdate";
    $sod = "asc";
}
$sql_order = " order by {$sst} {$sod} ";

// 전체 개수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 페이지네이션
$rows = 20; 
$total_page = ceil($total_count / $rows);
if ($page > $total_page && $total_page > 0) {
    $page = $total_page;
}
$from_record = ($page - 1) * $rows;

// 실제 데이터 조회
$sql = "
    select *
    {$sql_common}
    {$sql_search}
    {$sql_order}
    limit {$from_record}, {$rows}
";
$result = sql_query($sql);

// 페이지네이션 HTML
$list_page_rows = G5_IS_MOBILE 
    ? (isset($config['cf_mobile_pages']) ? $config['cf_mobile_pages'] : 5) 
    : (isset($config['cf_write_pages']) ? $config['cf_write_pages'] : 10);

$qstr = 'type='.$type;
$write_pages = get_paging($list_page_rows, $page, $total_page, $_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=');

// '열린','페이지','처음','이전','다음','마지막' 제거
$write_pages = str_replace(array('열린','페이지','처음','이전','다음','마지막'), '', $write_pages);
?>

<style>
/* table-layout: fixed; 제거로 각 셀 폭이 내용에 맞게 유동적으로 변경됨 */
.table {
    width: 100%;
    border-collapse: collapse;
    margin: 0 0 15px 0;
    font-size: 13px;
    /* table-layout: fixed; <- 삭제 */
}
.table th, .table td {
    border: 1px solid #ccc;
    padding: 6px;
    vertical-align: middle;
    text-align: center;
    word-wrap: break-word; /* 필요 시 줄바꿈 허용 */
}
.table-hover tbody tr:hover {
    background: #fafafa;
}
.thead-light th {
    background: #f2f2f2; 
    font-weight: 600;
}
.badge {
    padding: 4px 8px; 
    border-radius: 4px;
}
.badge-success { background-color: #28a745; color: white; }
.badge-warning { background-color: #ffc107; color: #212529; }

/* 페이지네이션 */
.pg_wrap {
    clear: both;
    margin: 20px 0;
    text-align: center;
}
.pg {}
.pg_page, .pg_current {
    display: inline-block;
    padding: 5px 10px;
    margin: 0 2px;
    border: 1px solid #ddd;
    text-decoration: none;
    color: #333;
    background: #fff;
}
.pg a.pg_page:hover {
    background: #f8f8f8;
}
.pg_current {
    background: #444;
    color: #fff;
    border-color: #444;
    font-weight: bold;
}
.pg_start, .pg_prev, .pg_next, .pg_end {
    display: inline-block;
    padding: 5px 8px;
    margin: 0 2px;
    border: 1px solid #ddd;
    background: #fff;
}
</style>

<div id="main-content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">                        
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    통계
                </h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item">통계</li>
                    <li class="breadcrumb-item active">현장소장현황</li>
                </ul>
            </div>
        </div>
    </div><!-- /.block-header -->

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <!-- 현장별 보기/소장별 보기 -->
                <div class="body">
                    <form class="float-right" style="margin-right:5px">
                        <div class="input-group">
                            <select name="type" class="form-control"
                                    onchange="location.href='?type='+this.value">
                                <option value="1" <?php echo get_selected($type, 1); ?>>
                                    현장별 보기
                                </option>
                                <option value="2" <?php echo get_selected($type, 2); ?>>
                                    소장별 보기
                                </option>
                                <option value="3" <?php echo get_selected($type, 3); ?>>
                                    소장별 보기(퇴사)
                                </option>
                            </select>
                        </div>
                    </form>
                </div><!-- /.body -->

                <div class="body project_report">
                    <div class="table-responsive">
<?php if($type == 1) { ?>
<!-- ============================== 현장별 보기 ============================== -->
<table class="table table-hover">
    <thead class="thead-light">
        <tr>
            <th style="text-align:left;">현장코드 및 현장명</th>
            <th>공사기간</th>
            <th>현장소장</th>
            <th>현장소장</th>
            <th>현장소장</th>
            <th>실투소장</th>
            <th>실투소장</th>
            <th>실투소장</th>
            <th>품질관리자</th>
            <th>품질관리자</th>
            <th>품질관리자</th>
            <th>안전관리자</th>
            <th>안전관리자</th>
            <th>안전관리자</th>
            <th>진행상태</th>
        </tr>
    </thead>
    <tbody>
<?php
for($i=0; $row=sql_fetch_array($result); $i++) {
    $status = $row['nw_status'] 
        ? '<span class="badge badge-success">완 료</span>'
        : '<span class="badge badge-warning">진행중</span>';
    
    echo '<tr>';
    echo '<td style="text-align:left; white-space:normal;">['.$row['nw_code'].'] '.$row['nw_subject'].'</td>';
    echo '<td>'.$row['nw_sdate'].' ~ '.$row['nw_edate'].'</td>';

    // 현장소장
    echo '<td>'. get_manager_txt($row['nw_ptype1_1']) .'</td>';
    echo '<td>'. get_manager_txt($row['nw_ptype1_2']) .'</td>';
    echo '<td>'. get_manager_txt($row['nw_ptype1_3']) .'</td>';

    // 실제투입소장
    echo '<td>'. get_manager_txt($row['nw_ptype2_1']) .'</td>';
    echo '<td>'. get_manager_txt($row['nw_ptype2_2']) .'</td>';
    echo '<td>'. get_manager_txt($row['nw_ptype2_3']) .'</td>';

    // 품질관리자
    echo '<td>'. get_admin_txt($row['nw_ptype5_1']) .'</td>';
    echo '<td>'. get_admin_txt($row['nw_ptype5_2']) .'</td>';
    echo '<td>'. get_admin_txt($row['nw_ptype5_3']) .'</td>';

    // 안전관리자
    echo '<td>'. get_admin_txt($row['nw_ptype6_1']) .'</td>';
    echo '<td>'. get_admin_txt($row['nw_ptype6_2']) .'</td>';
    echo '<td>'. get_admin_txt($row['nw_ptype6_3']) .'</td>';

    echo '<td>'.$status.'</td>';
    echo '</tr>';
}
if($i == 0) {
    echo '<tr><td colspan="15" class="text-center">데이터가 없습니다.</td></tr>';
}
?>
    </tbody>
</table>

<!-- 페이지네이션 -->
<div class="pg_wrap">
    <span class="pg">
        <?php echo $write_pages; ?>
    </span>
</div>

<?php } else if($type == 2) { ?>
<!-- ============================== 소장별 보기 ============================== -->
<table class="table table-hover">
    <thead class="thead-light">
        <tr>
            <th class="text-center" style="width:15%;">현장소장명</th>
            <th style="text-align:left;">현장코드 및 현장명</th>
            <th class="text-center" style="width:25%;">공사기간</th>
        </tr>
    </thead>
    <tbody>
<?php
$sql_man = "
    select mb_id, mb_name, mb_3
      from {$g5['member_table']}
     where mb_level >= 2 and mb_level <= 10
       and mb_level2 != 4
       and (mb_leave_date = '' OR mb_leave_date IS NULL OR mb_leave_date > CURDATE())
     order by mb_name asc
";
$rst = sql_query($sql_man);
$manager_data = array();
$found_data   = false;

while($row_manager = sql_fetch_array($rst)) {
    $manager_data[] = $row_manager;
}

foreach($manager_data as $v) {
    $mb_id   = $v['mb_id'];
    $mb_name = $v['mb_name'];

    $sql_worksite = "
      select nw_code, nw_subject, nw_sdate, nw_edate
        from {$none['worksite']}
       where nw_ptype1_1 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype1_2 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype1_3 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype2_1 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype2_2 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype2_3 = '".sql_real_escape_string($mb_id)."'
       order by nw_sdate desc
    ";
    $rst_worksite   = sql_query($sql_worksite);
    $worksite_count = sql_num_rows($rst_worksite);

    if($worksite_count == 0) continue;

    $found_data = true;
    $first_row  = true;

    while($row_work = sql_fetch_array($rst_worksite)) {
        echo '<tr>';
        if ($first_row) {
            echo '<td rowspan="'.$worksite_count.'" class="text-center" style="vertical-align: middle;">'
                 .htmlspecialchars($mb_name).'</td>';
            $first_row = false;
        }
        echo '<td style="text-align:left; white-space:normal;">['.$row_work['nw_code'].'] '.$row_work['nw_subject'].'</td>';
        echo '<td class="text-center">'.$row_work['nw_sdate'].' - '.$row_work['nw_edate'].'</td>';
        echo '</tr>';
    }
}

if(!$found_data) {
    echo '<tr><td colspan="3" class="text-center">데이터가 없습니다.</td></tr>';
}
?>
    </tbody>
</table>
<?php } else if($type == 3) { ?>
<!-- ============================== 소장별 보기(퇴사) ============================== -->
<table class="table table-hover">
    <thead class="thead-light">
        <tr>
            <th class="text-center" style="width:15%;">현장소장명</th>
            <th style="text-align:left;">현장코드 및 현장명</th>
            <th class="text-center" style="width:25%;">공사기간</th>
        </tr>
    </thead>
    <tbody>
<?php
$sql_man = "
    select mb_id, mb_name, mb_3
      from {$g5['member_table']}
     where mb_level >= 2 and mb_level <= 10
       and mb_level2 = 4
     order by mb_name asc
";
$rst = sql_query($sql_man);
$manager_data = array();
$found_data   = false;

while($row_manager = sql_fetch_array($rst)) {
    $manager_data[] = $row_manager;
}

foreach($manager_data as $v) {
    $mb_id   = $v['mb_id'];
    $mb_name = $v['mb_name'];

    $sql_worksite = "
      select nw_code, nw_subject, nw_sdate, nw_edate
        from {$none['worksite']}
       where nw_ptype1_1 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype1_2 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype1_3 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype2_1 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype2_2 = '".sql_real_escape_string($mb_id)."'
          or nw_ptype2_3 = '".sql_real_escape_string($mb_id)."'
       order by nw_sdate desc
    ";
    $rst_worksite   = sql_query($sql_worksite);
    $worksite_count = sql_num_rows($rst_worksite);

    if($worksite_count == 0) continue;

    $found_data = true;
    $first_row  = true;

    while($row_work = sql_fetch_array($rst_worksite)) {
        echo '<tr>';
        if ($first_row) {
            echo '<td rowspan="'.$worksite_count.'" class="text-center" style="vertical-align: middle;">'
                 .htmlspecialchars($mb_name).'</td>';
            $first_row = false;
        }
        echo '<td style="text-align:left; white-space:normal;">['.$row_work['nw_code'].'] '.$row_work['nw_subject'].'</td>';
        echo '<td class="text-center">'.$row_work['nw_sdate'].' - '.$row_work['nw_edate'].'</td>';
        echo '</tr>';
    }
}

if(!$found_data) {
    echo '<tr><td colspan="3" class="text-center">데이터가 없습니다.</td></tr>';
}
?>
    </tbody>
</table>
<?php } ?>
                    </div><!-- /.table-responsive -->
                </div><!-- /.body.project_report -->
            </div><!-- /.card -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /#main-content -->

<script>
function del_(seq) {
    if(confirm('정말 시공현황 정보를 삭제하시겠습니까?\n연동 된 정보가 있다면 모두 해제됩니다.')) {
        location.href = '/_worksite/write/menu1_update.php?w=d&seq=' + seq;
    } else {
        return false;
    }
}
</script>

<?php include_once(NONE_PATH.'/footer.php'); ?>
