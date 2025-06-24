<?php
/********************************************************************
 *  지출결의서 목록
 *  요구사항 반영 (2025‑04‑18)
 *   1.  문서명 글꼴 크기 원복
 *   2.  “계좌정보”, “중요도” 열 제거
 *   3.  헤더(번호~처리상태) 중앙정렬
 *   4.  번호·기안일자·업체명 데이터 중앙정렬
 ********************************************************************/

include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php');

/* ------------------------------------------------------------------
   0) 공통 함수 : 다음 결재자 ID
   ----------------------------------------------------------------- */
if (!function_exists('get_next_approver_id')) {
    function get_next_approver_id(array $row): string
    {
        for ($i = 1; $i <= 5; $i++) {
            $id   = $row["ns_id{$i}"]      ?? '';
            $stat = $row["ns_id{$i}_stat"] ?? '';

            if ($id === '')                      continue; // 결재자 X
            if ($stat === '')                    return $id; // 미결재
            if (strpos($stat, '전결') !== false) continue; // 전결 건너뜀
            if (strpos($stat, '반려') !== false) return ''; // 반려 → 이후 없음
        }
        return '';
    }
}

/* ------------------------------------------------------------------
   1) 검색 조건
   ----------------------------------------------------------------- */
$sql_search = ''; $work1_arr = [];

if (($member['mb_2'] ?? '') == 10 || ($member['mb_level2'] ?? '') == 2) { // 실행부 또는 현장소장
    $sql_common = " FROM {$none['sign_draft2']} ";
    $sql1 = sql_query("
        SELECT nw_code, pj_title_kr
          FROM {$none['worksite']}
         WHERE '{$member['mb_id']}' IN (
               nw_ptype1_1,nw_ptype1_2,nw_ptype1_3,
               nw_ptype2_1,nw_ptype2_2,nw_ptype2_3
         )
    ");
    while ($w = sql_fetch_array($sql1)) {
        $work1_arr[] = "ns_team='".sql_real_escape_string($w['nw_code'].' '.$w['pj_title_kr'])."'";
    }
    $sql_search = $work1_arr ? ' WHERE (' . implode(' OR ', $work1_arr) . ')' : ' WHERE 1=0';
} else {                                                   // 그 외
    $sql_common = " FROM {$none['sign_draft2']} ";
    $sql_search = ' WHERE 1';
}

/* ------------------------------------------------------------------
   2) 검색어 (통합)
   ----------------------------------------------------------------- */
$sfl = trim($_GET['sfl'] ?? '');
$stx = trim($_GET['stx'] ?? '');

if ($stx !== '') {
    $s = sql_real_escape_string($stx);
    $sql_search .= ' AND (';

    // 기안자 이름 → mb_id 목록
    $mb_ids = [];
    $r = sql_query("SELECT mb_id FROM {$g5['member_table']} WHERE mb_name LIKE '%{$s}%'");
    while ($m = sql_fetch_array($r)) $mb_ids[] = "'".sql_real_escape_string($m['mb_id'])."'";

    $conds = ["ns_subject LIKE '%{$s}%'", "ns_team LIKE '%{$s}%'"];
    if ($mb_ids) $conds[] = 'mb_id IN ('.implode(',',$mb_ids).')';

    $sql_search .= implode(' OR ', $conds).')';
}

/* ------------------------------------------------------------------
   3) 부서/현장, 상태
   ----------------------------------------------------------------- */
$team  = trim($_GET['team']  ?? '');
$state = trim($_GET['state'] ?? '');

if ($team)  $sql_search .= " AND ns_team='".sql_real_escape_string($team)."'";

if (!$state && !$stx && !$team) {
    $sql_search .= " AND ns_state IN ('미처리','미결제','전결')
                     AND (ns_payment_date='0000-00-00 00:00:00' OR ns_payment_date IS NULL)";
} elseif ($state && $state !== 'all') {
    $sql_search .= " AND ns_state='".sql_real_escape_string($state)."'";
}

/* ------------------------------------------------------------------
   4) 정렬 & 페이징
   ----------------------------------------------------------------- */
$sst = in_array($_GET['sst'] ?? '', ['seq','ns_date','ns_subject','ns_team','mb_id','ns_state'])
      ? $_GET['sst'] : 'seq';
$sod = (strtolower($_GET['sod'] ?? '') === 'asc') ? 'asc' : 'desc';
$sql_order = " ORDER BY {$sst} {$sod} ";

$row_total   = sql_fetch("SELECT COUNT(*) AS cnt {$sql_common} {$sql_search}");
$total_count = (int)($row_total['cnt'] ?? 0);

$rows        = $config['cf_page_rows'] ?? 15;
$page        = max(1, intval($_GET['page'] ?? 1));
$from_record = ($page - 1) * $rows;
$total_page  = ceil($total_count / $rows);
/* ------------------------------------------------------------------
   5) 목록 데이터
   ----------------------------------------------------------------- */
$sql    = "SELECT * {$sql_common} {$sql_search} {$sql_order} LIMIT {$from_record},{$rows}";
$result = sql_query($sql);

/* ------------------------------------------------------------------
   6) 공통 쿼리스트링
   ----------------------------------------------------------------- */
$qstr = '';
foreach (['sfl','stx','sst','sod','team','state'] as $p)
    if (isset($_GET[$p]) && $_GET[$p] !== '') $qstr .= "&amp;{$p}=".urlencode($_GET[$p]);

/* ------------------------------------------------------------------
   7) CSS
   ----------------------------------------------------------------- */
?>
<style>
.project_report .table          { table-layout:fixed;width:100%; }
.project_report th,td           { vertical-align:middle;padding:.6rem .5rem; }

.project_report th              { text-align:center; }   /* 헤더 중앙정렬 */

.th-num   { width:60px }
.th-date  { width:100px }
.th-team  { width:250px }
.th-amount,
.th-appr,
.th-state   { width:130px }            /* 결제금액·결재현황·처리상태 동일폭 */
.th-company{width:180px}

.td-num,
.td-date,
.td-company                     { text-align:center; }   /* 번호·일자·업체명 중앙 */

.td-team    { max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis }
.td-subject a{
    font-size:inherit;
    display:-webkit-box;
    -webkit-box-orient:vertical;
    -webkit-line-clamp:3;              /* 문서명 2줄 → 3줄 */
    overflow:hidden;word-break:break-all;
}
.td-amount{ text-align:right }


/* ───────── 데스크톱(≥992 px) ─────────
   ① table‑layout:fixed  (열 폭 확정)
   ② 문서명 열은 **폭 지정하지 않음** → 남는 공간 전부 사용
   ③ 최소 읽기 폭 보장 : min-width:240px   */
   @media (min-width:992px){
    .project_report .table{ table-layout:fixed; }
    .th-subject, .td-subject{ min-width:240px; }     /* ← 폭은 ‘auto’ */
}

/* ───────── 태블릿·모바일(<992 px) ─────────
   ① table‑layout:auto  → 각 셀이 내용 기반으로 자연 배분
   ② 문서명은 최소 160px  (0 px 로 눌리지 않음) */
@media (max-width:991.98px){
    .project_report .table{ table-layout:auto; }
    .th-subject, .td-subject{ min-width:160px; }
}
</style>

<div id="main-content">
<!-- ───────────────────────────────────────── 헤더/검색 UI (생략 없이 유지) -->
<div class="block-header">
    <div class="row">
        <div class="col-lg-5 col-md-8 col-sm-12">
            <h2>
                <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i>
                </a>
                전자결재
            </h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item">전체문서관리</li>
                <li class="breadcrumb-item active">지출결의서</li>
            </ul>
        </div>
    </div>
</div>

<div class="row clearfix">
<div class="col-lg-12 col-md-12">
<div class="card">

    <!-- 검색 + 등록 버튼 -->
    <div class="body">
                    <a class="btn btn-primary float-right" href="../write/menu2_write.php" role="button">
                        지출결의서 등록
                    </a> 
                    <form class="float-right" style="margin-right:5px">
                        <div class="input-group">
                            <!-- 기안부서 및 현장 -->
                            <select name="status" id="inputState" class="form-control"
                                onchange="location.href='?state=<?php echo $state?>&team='+this.value">
                                <option value="">기안부서 및 현장 선택</option>
                                <optgroup label="부서">
                                    <?php echo get_department_select2($team)?>
                                </optgroup>
                                <optgroup label="진행현장">
                                <?php 
                                $workSql = "
                                    select seq, nw_code, nw_subject, pj_title_kr 
                                      from {$none['worksite']}
                                     where nw_status  = '0' 
                                       and nw_code != '210707' 
                                     order by nw_code desc
                                ";
                                $workRst = sql_query($workSql);
                                while($work = sql_fetch_array($workRst)) {
                                    $nw_code = $work['nw_code'].' '.$work['pj_title_kr'];
                                ?>
                                    <option value="<?php echo $nw_code?>"
                                        <?php echo get_selected($nw_code, $team)?>>
                                        <?php echo $nw_code?>
                                    </option>
                                <?php } ?>
                                </optgroup>
                                <optgroup label="완료현장">
                                <?php 
                                $workSql2 = "
                                    select seq, nw_code, nw_subject, pj_title_kr 
                                      from {$none['worksite']}
                                     where nw_status = '1'
                                       and nw_code != '210707'
                                     order by nw_code desc
                                ";
                                $workRst2 = sql_query($workSql2);
                                while($work2 = sql_fetch_array($workRst2)) {
                                    $nw_code2 = $work2['nw_code'].' '.$work2['pj_title_kr'];
                                ?>
                                    <option value="<?php echo $nw_code2?>"
                                        <?php echo get_selected($nw_code2, $team)?>>
                                        <?php echo $nw_code2?>
                                    </option>
                                <?php } ?>
                                </optgroup>
                            </select>
                            
                            <!-- 문서상태 -->
                            <select name="status" id="inputState" class="form-control"
                                onchange="location.href='?team=<?php echo $team?>&state='+this.value">
                                <option value="">진행중 문서</option>
                                <option value="all" <?php echo get_selected($state, 'all')?>>전체보기</option>
                                <option value="미처리" <?php echo get_selected($state, '미처리')?>>
                                    미처리/미결제
                                </option>
                                <option value="결제완료" <?php echo get_selected($state, '결제완료')?>>
                                    결제완료
                                </option>
                                <option value="전결" <?php echo get_selected($state, '전결')?>>
                                    전결
                                </option>
                                <option value="반려" <?php echo get_selected($state, '반려')?>>
                                    반려
                                </option>
                            </select>

                            <!-- 검색어 입력 -->
                            <input type="text" name="stx" value="<?php echo $stx?>"
                                class="form-control" placeholder="전체검색"  >
                            <div class="input-group-append">
                                <span class="input-group-text" id="search-mail">
                                    <i class="icon-magnifier"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>  

    <!-- ──────────────── 목록 테이블 ──────────────── -->
    <div class="body project_report">
        <div class="table-responsive">
            <table class="table m-b-0 table-hover">
                <thead class="thead-light">
                    <tr>
                        <th class="th-num">번호</th>
                        <th class="th-date">기안일자</th>
                        <th class="th-team">기안부서/현장</th>
                        <th class="th-subject">문서명</th>
                        <th class="th-company">업체명</th>
                        <th class="th-amount">결제금액</th>
                        <th class="th-appr">결재현황</th>
                        <th class="th-state">처리상태</th> 
                    </tr>
                </thead>
                <tbody>
<?php
for ($i = 0; $row = sql_fetch_array($result); $i++):
    $num = $total_count - ($page - 1) * $rows - $i;

    /* 댓글 수 */
    $cm_q   = sql_fetch("
        SELECT COUNT(*) AS cnt
          FROM {$none['sign_draft_comment']}
         WHERE ns_type = 2 AND ns_id = '{$row['seq']}'");
$cm_cnt = (int)($cm_q['cnt'] ?? 0);

    /* 기안자 정보 */
    $mb = get_member($row['mb_id'], 'mb_name, mb_3');
    $drafter = trim(($mb['mb_name'] ?? '') .' '. get_mposition_txt($mb['mb_3'] ?? ''));

    /* ---------------- 처리상태 & 결재현황 ---------------- */
    $doc_state     = $row['ns_state'] ?? '미처리';
    $state_display = '미처리';
    $rel_id        = '';
    $rel_tag       = '';

    if ($doc_state === '결제완료') {
        $paid = $row['ns_payment_date'] !== '0000-00-00 00:00:00'
              ? date('Y-m-d H:i', strtotime($row['ns_payment_date'])) : '';
        $state_display = "<strong style='color:green'>결제완료</strong>"
                       . ($paid ? "<br><small>{$paid}</small>" : '');
        $last_idx = $row['ns_sign_cnt'] ?? 0;
        $rel_id   = $row['ns_id'.$last_idx] ?? '';
        $rel_tag  = '<br><strong style="color:red">결제완료문서</strong>';
    } else {
        /* 반려 · 전결 검사 */
        $final_found = false;
        for ($n=0;$n<=5;$n++) {
            $stat = $row["ns_id{$n}_stat"] ?? '';
            $id   = $n==0 ? ($row['mb_id'] ?? '') : ($row["ns_id{$n}"] ?? '');
            if (!$id) continue;

            if (strpos($stat,'반려') !== false) {
                $d = explode('|', $stat);
                $time = !empty($d[1]) && $d[1] !== '0000-00-00 00:00:00'
                      ? date('Y-m-d H:i', strtotime($d[1])) : '';
                $state_display = "<strong style='color:red'>반려</strong>"
                               . ($time ? "<br><small>{$time}</small>" : '');
                $rel_id  = $id;
                $rel_tag = '<br><strong style="color:red">반려문서</strong>';
                $final_found = true; break;
            }

            if (strpos($stat,'전결') !== false) {
                $d = explode('|', $stat);
                $time = !empty($d[1]) && $d[1] !== '0000-00-00 00:00:00'
                      ? date('Y-m-d H:i', strtotime($d[1])) : '';
                $btn = ($member['mb_2'] ?? '') == 3
                     ? "<strong style='color:red;cursor:pointer' onclick='payment({$row['seq']})'>미결제</strong>"
                     : "<strong style='color:red'>미결제</strong>";
                $state_display = "{$btn}".($time ? "<br><small>{$time}</small>" : '');
                $rel_id  = $id;
                $rel_tag = '<br><strong style="color:red">전결문서</strong>';
                $final_found = true; break;
            }
        }

        /* 미결제 */
        if (!$final_found && $doc_state === '미결제') {
            $idx = $row['ns_sign_cnt'] ?? 0;
            $stat = $row["ns_id{$idx}_stat"] ?? '';
            $time = '';
            if ($stat) {
                $x = explode('|', $stat);
                if (!empty($x[1]) && $x[1] !== '0000-00-00 00:00:00')
                    $time = date('Y-m-d H:i', strtotime($x[1]));
            }
            $btn = ($member['mb_2'] ?? '') == 3
                 ? "<strong style='color:red;cursor:pointer' onclick='payment({$row['seq']})'>미결제</strong>"
                 : "<strong style='color:red'>미결제</strong>";
            $state_display = "{$btn}".($time ? "<br><small>{$time}</small>" : '');
            $rel_id = $row['ns_id'.$idx] ?? '';
        }

        /* 미처리 */
        if (!$final_found && $doc_state === '미처리') {
            $rel_id = get_next_approver_id($row);
            if (!$rel_id) $rel_id = $row['ns_id1'] ?? '';
        }
    }

    /* 결재현황 이름 */
    $rel_display = '정보 없음';
    if ($rel_id) {
        $rel_mb = get_member($rel_id, 'mb_name, mb_3');
        $rel_display = trim(($rel_mb['mb_name'] ?? '') .' '. get_mposition_txt($rel_mb['mb_3'] ?? ''));
        if (!$rel_display) $rel_display = $rel_id;
    }

    /* 업체/계좌(계좌열은 제거 됐지만 업체 표시용) */
    $ent   = explode('||', $row['ns_company'] ?? '');
    $e1    = explode('^', $ent[0] ?? '');
    $enter = $e1[0] ?? '';
    if (count($ent) >= 2) $enter = $e1[0].' 외 '.(count($ent)-1).'건';
?>
                    <tr>
                        <td class="td-num"><?php echo $num;?></td>
                        <td class="td-date"><?php echo substr($row['ns_date'],0,10);?></td>
                        <td class="td-team" title="<?php echo htmlspecialchars($row['ns_team']);?>">
                            <?php echo htmlspecialchars($row['ns_team']);?>
                        </td>
                        <td class="td-subject">
                            <a href="../view/menu2_view.php?w=u&seq=<?php echo $row['seq'];?>">
                                <?php echo htmlspecialchars($row['ns_subject']);?>
                                <?php if ($cm_cnt):?><span class="text-muted">(<?php echo $cm_cnt;?>)</span><?php endif;?>
                            </a>
                        </td>
                        <td class="td-company"><?php echo htmlspecialchars($enter);?></td>
                        <td class="td-amount"><?php echo number_format($row['ns_total_price3']);?></td>
                        <td class="text-center"><?php echo $rel_display.$rel_tag;?></td>
                        <td class="text-center"><?php echo $state_display;?></td>
                    </tr>
<?php
endfor;
if ($total_count == 0):?>
                    <tr><td colspan="8" class="text-center py-5">데이터가 없습니다.</td></tr>
<?php endif;?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 페이징 -->
    <?php
    echo get_paging_none(
        G5_IS_MOBILE ? ($config['cf_mobile_pages'] ?? 5) : ($config['cf_write_pages'] ?? 10),
        $page, $total_page,
        $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='
    );
    ?>
</div>
</div>
</div>
</div><!-- /#main-content -->

<script>
function payment(seq){
    if (confirm('대금지급을 완료하시겠습니까?')){
        location.href='../write/state2_list_update.php?seq='+seq;
    }
}
</script>

<?php include_once(NONE_PATH.'/footer.php'); ?>
