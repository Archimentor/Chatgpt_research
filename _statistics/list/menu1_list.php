<?php
include_once('../../_common.php');
define('menu_statistics', true);
include_once(NONE_PATH.'/header.php'); 

// 현재 선택된 년도가 없으면 올해 연도로 설정
if(!$_GET['date']) {
    $date = date('Y');
} else {
    $date = $_GET['date'];
}

// --------------------
// 2017년부터 현재 선택된 년도까지의 합계 구해 차트용 데이터 불러오기
// --------------------
$sql_chart = "
    SELECT 
        LEFT(nw_sdate, 4) AS y, 
        SUM(nw_total_price + nw_vat) AS total 
    FROM {$none['worksite']}
    WHERE LEFT(nw_sdate,4) BETWEEN '2017' AND '{$date}'
    GROUP BY LEFT(nw_sdate,4)
    ORDER BY y ASC
";
$res_chart = sql_query($sql_chart);

$chart_data = array();
while($row_chart = sql_fetch_array($res_chart)) {
    $chart_data[] = $row_chart;
}

// 공통 쿼리 구문
$sql_common = " FROM {$none['worksite']} ";
// 특정 년도 데이터만 조회
$sql_search = " WHERE nw_sdate LIKE '{$date}%' ";

// 정렬 관련
if (!$sst) {
    $sst  = "nw_code";
    $sod = "desc";
}
$sql_order = " ORDER BY $sst $sod ";

// 전체 개수 구하기
$sql = " SELECT COUNT(*) AS cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 페이징 관련
$rows = 300;
$total_page  = ceil($total_count / $rows);
if ($page < 1) { 
    $page = 1; 
}
$from_record = ($page - 1) * $rows;

// 실제 리스트 불러오기
$sql = " SELECT * {$sql_common} {$sql_search} {$sql_order} LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);

// 합계 계산용 변수
$total_price = 0;
?>

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
                    <li class="breadcrumb-item">
                        <a href="/"><i class="icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">통계</li>
                    <li class="breadcrumb-item active">수주현황</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 차트 및 년도 선택 버튼 영역 -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="body">

                    <!-- 년도 이동 버튼 -->
                    <div class="btn-group" role="group" aria-label="Basic example" style="margin-bottom:10px;">
                        <button type="button" class="btn btn-secondary" onclick="location.href='?date=<?php echo ($date-1)?>'">
                            <
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <?php echo $date?>년
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="location.href='?date=<?php echo ($date+1)?>'">
                            >
                        </button>
                    </div>

                    <!-- 차트 영역 -->
                    <div style="width:100%; max-width:1500px; margin:0 auto;">
                        <canvas id="myChart" style="width:100%; height:400px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart.js 스크립트 -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
(function() {
    var ctx = document.getElementById('myChart').getContext('2d');
    
    // PHP에서 가져온 데이터 JS로 변환
    var chartLabels = [
        <?php 
        foreach($chart_data as $cd) {
            echo "'".$cd['y']."',";
        }
        ?>
    ];
    var chartValues = [
        <?php 
        foreach($chart_data as $cd) {
            echo $cd['total'].",";
        }
        ?>
    ];

    var myChart = new Chart(ctx, {
        type: 'line', 
        data: {
            labels: chartLabels,
            datasets: [{
                label: '년도별 총 공사금액(2017 - <?php echo $date; ?>)',
                data: chartValues,
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, ticks) {
                            if (value === 0) {
                                return 0;
                            }
                            // 백만 단위
                            var million = 100000000;
                            var inMillions = (value / million).toFixed(0);
                            return inMillions + ' 만';
                        }
                    }
                }
            }
        }
    });
})();
</script>

            <!-- (현장명 검색 폼 제거된 상태) -->

            <!-- 시공현장 리스트 -->
            <div class="card">
                <div class="body project_report">
                    <div class="table-responsive">
                        <table class="table m-b-0 table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>현장코드</th>
                                    <th>현장명</th>
                                    <th>공사기간</th>
                                    <th>사용승인일</th>
                                    <th>발주처</th>
                                    <th>총 공사금액(VAT 포함)</th>
                                    <th>진행상태</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            for($i=0; $row=sql_fetch_array($result); $i++) {

                                // 진행상태
                                if($row['nw_status']) {
                                    $status = '<span class="badge badge-success">완 료</span>';
                                } else {
                                    $status = '<span class="badge badge-warning">진행중</span>';
                                }

                                // 추가정보 테이블에서 최근 값 불러오기
                                $add = sql_fetch("SELECT * FROM {$none['worksite_add']} WHERE nw_id = '{$row['seq']}' ORDER BY seq DESC");
                                
                                if($add) {
                                    $nw_total_price = $add['nw_total_price'] + $add['nw_vat'];
                                } else {
                                    $nw_total_price = $row['nw_total_price'] + $row['nw_vat'];
                                }

                                // 총액 누적
                                $total_price += $nw_total_price;
                            ?>
                                <tr>
                                    <td>
                                        <a href="/_worksite/write/menu1_write.php?w=u&seq=<?php echo $row['seq']?>">
                                            <?php echo $row['nw_code']?>
                                        </a>
                                    </td>
                                    <td><?php echo $row['nw_subject']?></td>
                                    <!-- ~ 대신 - 로 변경 -->
                                    <td>
                                        <?php echo substr($row['nw_sdate'], 2, 10)?> - 
                                        <?php echo substr($row['nw_edate'], 2, 10)?>
                                    </td>
                                    <td><?php echo $row['nw_use_date']?></td>
                                    <td><?php echo get_owner_txt($row['nw_ptype3_1'])?></td>
                                    <td style="color:#cf3434" class="text-right">
                                        <?php echo number_format($nw_total_price)?> 원
                                    </td>
                                    <td class="text-center"><?php echo $status?></td>
                                </tr>
                            <?php 
                            } 
                            
                            // 검색결과 없을 때
                            if($i == 0) {
                            ?>
                                <tr>
                                    <td colspan="7" class="align-center">
                                        검색 된 데이터가 없습니다.
                                    </td>
                                </tr>
                            <?php } ?>

                            <!-- 합계 표시 -->
                            <tr style="background:#f2f2f2">
                                <td colspan="5" class="text-right font-weight-bold">합계</td>
                                <td style="color:#cf3434" class="text-right font-weight-bold">
                                    <?php echo number_format($total_price)?> 원
                                </td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php 
                // 페이지 링크 (환경에 따라 $qstr 필요 시 세팅)
                // 예: $qstr = 'date='.$date;
                echo get_paging_none(
                    G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'],
                    $page, 
                    $total_page, 
                    $_SERVER['SCRIPT_NAME'].'?date='.$date.'&amp;page='
                ); 
                ?>
            </div>
        </div>
    </div>
</div>

<script>
function del_(seq) {
    if(confirm('정말 시공현황 정보를 삭제하시겠습니까?\n\n연동 된 정보가 있다면 모두 해제 됩니다.')) {
        location.href = '/_worksite/write/menu1_update.php?w=d&seq=' + seq;
    } else {
        return false;
    }
}
</script>

<?php include_once(NONE_PATH.'/footer.php');?>
