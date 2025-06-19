<?php
include_once('../../_common.php');
define('menu_statistics', true);
include_once(NONE_PATH.'/header.php');

// (1) 모든 현장 가져오기 (정렬: nw_code desc)
$sst = 'nw_code';
$sod = 'desc';

$sql_worksite = "
    SELECT *
      FROM {$none['worksite']}
     ORDER BY {$sst} {$sod}
";
$result_worksite = sql_query($sql_worksite);

// 총 건수
$total_count = sql_num_rows($result_worksite);
?>
<style>
/* 테이블/스타일 */
.text-right { text-align: right; }
.text-center { text-align: center; }
.font-weight-bold { font-weight: bold; }
.badge { display: inline-block; padding: .25em .4em; font-size:75%; font-weight:700; text-align:center; border-radius:.25rem; }
.badge-warning { color:#212529; background-color:#ffc107; }
.badge-success { color:#fff; background-color:#28a745; }
.table { width:100%; margin-bottom:1rem; border-collapse:collapse; }
.table th, .table td { padding:.75rem; vertical-align:top; border-top:1px solid #dee2e6; }
.table thead th { border-bottom:2px solid #dee2e6; background:#f8f9fa; }
.table-hover tbody tr:hover { background-color:rgba(0,0,0,.075); }
.table th.border-right, .table td.border-right { border-right:1px solid #dee2e6; }
.table th.border-left,  .table td.border-left  { border-left:1px solid #dee2e6; }
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
                <li class="breadcrumb-item active">잔금현황</li>
            </ul>
        </div>
    </div>
</div>

<div class="row clearfix">
 <div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="body">
            <!-- 검색/필터 폼 없음 -->
        </div>

        <div class="body project_report">
            <div class="table-responsive">
                <table class="table m-b-0 table-hover">
                    <thead class="thead-light">
                        <tr>
                            <!-- 현장코드 가운데 정렬 + 링크 복원 -->
                            <th class="border-right border-left text-center">현장코드</th>
                            <th class="border-right">현장명</th>
                            <th class="text-center border-right">미수금(도급기성 제외:현금)</th>
                            <th class="text-center border-right">잔금(도급기성(현금) 포함)</th>
                            <th class="text-center border-right">진행현황</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$totalMisu   = 0; 
$totalBlance = 0; 
$list_count  = 0;

if($total_count == 0){
    // 아무 현장도 없음
    echo '<tr><td colspan="5" class="text-center border-left border-right">조회된 현장이 없습니다.</td></tr>';
} else {
    while($work = sql_fetch_array($result_worksite)) {
        $nw_code = $work['nw_code'];
        $seq     = $work['seq'];

        // 1) 최신 차수(계약금 + 현금계약금)
        $psql = "SELECT *
                   FROM {$none['worksite_add']}
                  WHERE nw_id = '{$seq}'
               ORDER BY nw_num DESC
                  LIMIT 1";
        $prow = sql_fetch($psql);
        if($prow){
            $work['nw_contract_price'] = $prow['nw_contract_price'];
            $work['nw_price2']         = $prow['nw_price2'];
        }
        $nw_total_contract_price = (int)$work['nw_contract_price'] + (int)$work['nw_price2'];

        // 2) 전체 기간 세금계산서 합
        $sql_tax = "
          SELECT SUM(ns_total_price) as total
            FROM {$none['sales_list']}
           WHERE nw_code = '".sql_real_escape_string($nw_code)."'
             AND ns_type = '세금계산서'
        ";
        $row_tax = sql_fetch($sql_tax);
        $all_tax_sum = (int)$row_tax['total'];

        // 3) 도급기성(현금 제외) 합 => 미수금 계산용
        $sql_paid_noncash = "
          SELECT SUM(ns_total_price) as total
            FROM {$none['sales_list']}
           WHERE nw_code = '".sql_real_escape_string($nw_code)."'
             AND ns_type = '도급기성'
        ";
        $row_paid_noncash = sql_fetch($sql_paid_noncash);
        $paid_noncash_sum = (int)$row_paid_noncash['total'];

        // 4) 도급기성(현금 포함) 합 => 잔금 계산용
        $sql_paid_all = "
          SELECT SUM(ns_total_price) as total
            FROM {$none['sales_list']}
           WHERE nw_code = '".sql_real_escape_string($nw_code)."'
             AND ns_type IN ('도급기성','도급기성(현금)')
        ";
        $row_paid_all = sql_fetch($sql_paid_all);
        $paid_all_sum = (int)$row_paid_all['total'];

        // 5) 미수금 (세금계산서가 없으면 = 0)
        $siteMisu = 0;
        if($all_tax_sum > 0){
            $siteMisu = $all_tax_sum - $paid_noncash_sum;
        }

        // 6) 잔금
        $siteBlance = $nw_total_contract_price - $paid_all_sum;

        // 진행현황: badge 색상 구분
        if($work['nw_status']){
            $status_text = '<span class="badge badge-success">완료</span>';
        } else {
            $status_text = '<span class="badge badge-warning">진행중</span>';
        }

        // 둘 다 0이면 표시 X
        if($siteMisu == 0 && $siteBlance == 0){
            continue;
        }

        $list_count++;
        ?>
        <tr>
            <td class="border-left text-center">
                <!-- 1) 현장코드 클릭 시 menu3_list.php?status=...&work_id=... -->
                <a href="./menu3_list.php?status=<?php echo $work['nw_status']?>&work_id=<?php echo $nw_code; ?>">
                    <?php echo $nw_code; ?>
                </a>
            </td>
            <td><?php echo htmlspecialchars($work['nw_subject']); ?></td>
            <td class="text-right"><?php echo number_format($siteMisu); ?></td>
            <td class="text-right" style="<?php echo ($siteBlance>0)? 'color:red;':'';?>">
                <?php echo number_format($siteBlance); ?>
            </td>
            <td class="text-center border-right">
                <?php echo $status_text; ?>
            </td>
        </tr>
        <?php
        // 합계
        $totalMisu   += $siteMisu;
        $totalBlance += $siteBlance;
    }

    // 모두 0만 있어서 출력된 행이 없다면
    if($list_count == 0){
        echo '<tr><td colspan="5" class="text-center border-left border-right">잔금/미수금이 남은 현장이 없습니다.</td></tr>';
    }
}
?>
                        <tr style="border-top:2px solid #dee2e6; background:#f8f9fa;">
                            <td colspan="2" class="text-right font-weight-bold border-left">합계</td>
                            <td class="text-right font-weight-bold"><?php echo number_format($totalMisu); ?></td>
                            <td class="text-right font-weight-bold"><?php echo number_format($totalBlance); ?></td>
                            <td class="border-right"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 페이징 없음 -->
    </div>
</div>
</div>
</div>

<script>
function del_(seq){
    if(confirm('정말 매출현황 정보를 삭제하시겠습니까?')){
        location.href = '/_statistics/write/menu2_update.php?w=d&seq='+seq;
    } else {
        return false;
    }
}
</script>

<?php include_once(NONE_PATH.'/footer.php');?>
