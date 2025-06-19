<?php 
include_once('../../_common.php');
define('menu_statistics', true);
include_once(NONE_PATH.'/header.php'); 

// 기본 년도 처리
if(!$_GET['date'])
    $date = date('Y');
else
    $date = $_GET['date'];

// (1) 검색 조건
$sql_common = " from {$none['sales_list']} ";
$sql_search = " where ns_date LIKE '{$date}%' ";

// $stx, $sfl 등으로 검색할 때
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table":
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id":
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default:
            $sql_search .= " (nw_subject like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

// (2) 정렬 설정
if (!$sst) {
    $sst  = "nw_code";
    $sod  = "desc";
}
$sql_order = " group by nw_code order by $sst $sod ";

// (3) 전체 개수 구하기
$sql = " select count(*) as cnt 
         {$sql_common} 
         {$sql_search} 
         {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// (4) 페이징
$rows = 100;
$total_page  = ceil($total_count / $rows);
if ($page < 1) { $page = 1; }
$from_record = ($page - 1) * $rows;

// (5) 실제 목록 (nw_code별 group by)
$sql = " select *, count(ns_date) as cnt
         {$sql_common} 
         {$sql_search} 
         {$sql_order}
         limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$qstr .= "date=$date";
?>
<style>
/* 간단한 Bootstrap-ish 테이블/버튼 스타일 */
.table {
    width:100%;
    border-collapse: collapse;
    margin:0; 
    font-size:13px;
}
.table th, .table td {
    border:1px solid #ccc;
    padding:6px;
    vertical-align: middle;
    text-align:center;
}
.table-hover tbody tr:hover {
    background:#fafafa;
}
.thead-light th {
    background:#f2f2f2;
    font-weight:600;
}
.badge {
    padding: 4px 8px;
    border-radius:4px;
}
.bg-lightgray {
    background:#f2f2f2;
}
.font-weight-bold {
    font-weight:600;
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
                <li class="breadcrumb-item">
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="breadcrumb-item">통계</li>
                <li class="breadcrumb-item active">매출현황</li>
            </ul>
        </div>            
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="body">
                <!-- 년도 이동 버튼 -->
                <div class="btn-group" role="group" aria-label="Year Navigation">
                    <button type="button" class="btn btn-secondary" 
                            onclick="location.href='?date=<?php echo ($date-1)?>'">
                        &lt;
                    </button>
                    <button type="button" class="btn btn-secondary">
                        <?php echo $date?>년
                    </button>
                    <button type="button" class="btn btn-secondary" 
                            onclick="location.href='?date=<?php echo ($date+1)?>'">
                        &gt;
                    </button>
                </div>
                <a class="btn btn-primary float-right" href="../write/menu2_write.php" role="button">
                    매출현황 등록
                </a> 
            </div>  

            <div class="body project_report">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th rowspan="2">공사코드</th>
                                <th rowspan="2">현장명</th>
                                <th colspan="3" class="text-center">세금계산서</th>
                                <th colspan="4" class="text-center">도급기성</th>
                                <th rowspan="2" class="text-center">관리</th>
                            </tr>
                            <tr>
                                <th>발행일자</th>
                                <th>금액</th>
                                <th>발행률</th>
                                <th>입금일자</th>
                                <th>금액</th>
                                <th>입금률</th>
                                <th>잔금</th>
                            </tr>
                        </thead>
                        <tbody>
<?php 
// (1) 이 해에 속하는 모든 데이터 조회( ns_date LIKE '$date%' )해서
$sqlAll = "
  select *
    from {$none['sales_list']}
   where ns_date LIKE '{$date}%'
 order by ns_date asc
";
$rst = sql_query($sqlAll);

$data = array();
for($z = 0; $row2=sql_fetch_array($rst); $z++) {
    // $data[공사코드][] = 행데이터
    $data[$row2['nw_code']][] = $row2;
}

// 공사코드 역정렬
krsort($data);

if($z == 0) {
    // 데이터 없음
    echo '<tr><td colspan="11" class="text-center">검색 된 데이터가 없습니다.</td></tr>';
} else {
    // (2) 상반기/하반기/연간 계산용 변수
    // 이 변수들은 "올해 전체"에 대해 누적
    $firstHalf_total     = 0; // 상반기 세금계산서 합
    $secondHalf_total    = 0; // 하반기 세금계산서 합
    $firstHalf_ptotal    = 0; // 상반기 도급기성(현금포함) 합
    $secondHalf_ptotal   = 0; // 하반기 도급기성(현금포함) 합

    // 실수령액, 잔금, 세금계산서 총계, 도급기성 소계(현금제외) 등
    $totalPriceSum       = 0; 
    $totalBlance         = 0; 
    $totalTax            = 0; 
    $totalPrice          = 0; 

    // (3) 코드별 반복
    foreach ($data as $k => $v) {

        // (3-1) 각 공사코드별 "중간 합계" 변수들 초기화
        $taxSum       = 0;  // 세금계산서 발행 금액 합
        $priceSum     = 0;  // 도급기성 금액 합
        $taxSumPersent    = 0; 
        $priceSumPersent  = 0;
        $misu         = 0;  // 도급기성(현금 제외) 누적
        $misu2        = 0;  
        $priceSum2    = 0;  
        $blance       = 0;  
        $prevTaxPersent   = 0; 
        $prevPricePersent = 0;

        // (3-2) 현장정보 로드
        $work = sql_fetch("
            select * 
              from {$none['worksite']}
             where nw_code = '{$k}'
        ");

        // (3-3) 공사코드 + 현장명 표기
        echo '<tr>';
        // rowspan=(데이터 개수 + 1) => 소계 행까지 합쳐서
        echo '<td rowspan="'.(count($v)+1).'">
                <a href="./menu3_list.php?work_id='.$k.'">'.$k.'</a>
              </td>';
        echo '<td rowspan="'.(count($v)+1).'">'.$work['nw_subject'].'</td>';
        echo '</tr>';

        // (3-4) 이 공사코드에 속하는 매출 데이터 반복
        foreach ($v as $subType) {

            // 계약금액 + 현금금액
            $nw_contract_price  = (int)$work['nw_contract_price'];
            $nw_contract_price2 = (int)$work['nw_contract_price'] + (int)$work['nw_price2'];

            // 이전년도(= 올해 아닌 나머지)의 세금계산서, 도급기성
            // => 미수금 등 계산에 반영
            $prevTax  = sql_fetch("
               select SUM(ns_total_price) as total 
                 from {$none['sales_list']}
                where ns_date NOT LIKE '{$date}%' 
                  and nw_code = '{$k}'
                  and ns_type = '세금계산서'
            ");
            $prevPrice = sql_fetch("
               select SUM(ns_total_price) as total 
                 from {$none['sales_list']}
                where ns_date NOT LIKE '{$date}%' 
                  and nw_code = '{$k}' 
                  and ns_type != '세금계산서'
            ");
            $prevPrice2 = sql_fetch("
               select SUM(ns_total_price) as total 
                 from {$none['sales_list']}
                where ns_date NOT LIKE '{$date}%' 
                  and nw_code = '{$k}'
                  and ns_type = '도급기성'
            ");

            // 테이블 행 시작
            echo '<tr>';

            if($subType['ns_type'] == "세금계산서") {
                
                // 발행률
                $taxPersent = 0;
                if($nw_contract_price > 0) {
                    $taxPersent = $subType['ns_total_price'] / $nw_contract_price * 100;
                }
                // 출력
                echo '<td class="text-center">'.
                       date('m월 d일', strtotime($subType['ns_date'])) .
                     '</td>';
                echo '<td class="text-right">'. number_format($subType['ns_total_price']) .'</td>';
                echo '<td class="text-right" style="border-right:3px solid #ccc">'.
                     round($taxPersent).'%</td>';

                // 세금계산서 칸
                echo '<td class="none"></td>';
                echo '<td class="none"></td>';
                echo '<td class="none"></td>';
                echo '<td class="none"></td>';

                // 누적
                $taxSum       += $subType['ns_total_price'];
                $taxSumPersent += round($taxPersent);

                // 상/하반기 구분
                $m = date('m', strtotime($subType['ns_date']));
                if(in_array($m, array('01','02','03','04','05','06'))) {
                    // 상반기
                    $firstHalf_total += $subType['ns_total_price'];
                } else {
                    // 하반기
                    $secondHalf_total += $subType['ns_total_price'];
                }

            } else if($subType['ns_type'] == "도급기성" || $subType['ns_type'] == "도급기성(현금)") {
                
                // 입금률
                $pricePersent = 0;
                if($nw_contract_price2 > 0) {
                    $pricePersent = $subType['ns_total_price'] / $nw_contract_price2 * 100; 
                }
                $priceSum2  += $subType['ns_total_price'];

                // 잔금
                $blance = $nw_contract_price2 - $priceSum2 - $prevPrice['total'];

                // 세금계산서 칸 비우기
                echo '<td class="none"></td>';
                echo '<td class="none"></td>';
                echo '<td class="none" style="border-right:3px solid #ccc"></td>';

                // 도급기성
                echo '<td class="text-center">'. date('m월 d일', strtotime($subType['ns_date'])) .'</td>';
                echo '<td class="text-right">'. number_format($subType['ns_total_price']) .'</td>';
                echo '<td class="text-right">'. round($pricePersent).'%</td>';
                echo '<td class="text-right">'. number_format($blance) .'</td>';

                // 누적
                $priceSum       += $subType['ns_total_price'];
                $priceSumPersent += round($pricePersent);

                // 상/하반기 구분
                $m = date('m', strtotime($subType['ns_date']));
                if(in_array($m, array('01','02','03','04','05','06'))) {
                    $firstHalf_ptotal  += $subType['ns_total_price'];
                } else {
                    $secondHalf_ptotal += $subType['ns_total_price'];
                }

                // 도급기성 현금 제외 => 미수금?
                if($subType['ns_type'] == "도급기성") {
                    $misu  += $subType['ns_total_price'];
                    $misu2 += $subType['ns_total_price'];
                }
            }

            // 관리 버튼
            echo '<td class="text-center">
                    <button type="button" class="btn btn-primary btn-sm"
                      onclick="location.href=\'../write/menu2_write.php?w=u&seq='.$subType['seq'].'\'">
                      수정
                    </button>
                    <button type="button" class="btn btn-danger btn-sm"
                      onclick="del_('.$subType['seq'].')">
                      삭제
                    </button>
                  </td>';
            echo '</tr>';
        } // end foreach ($v as $subType)

        // (3-5) 소계 (한 공사코드 마무리)
        // 이전년도 합
        $prevTaxPersent   = 0; 
        $prevPricePersent = 0;

        $prevTax  = sql_fetch("
            select SUM(ns_total_price) as total 
              from {$none['sales_list']}
             where ns_date NOT LIKE '{$date}%'
               and nw_code = '{$k}'
               and ns_type = '세금계산서'
        ");
        $prevPrice = sql_fetch("
            select SUM(ns_total_price) as total
              from {$none['sales_list']}
             where ns_date NOT LIKE '{$date}%'
               and nw_code = '{$k}'
               and ns_type != '세금계산서'
        ");
        $prevPrice2 = sql_fetch("
            select SUM(ns_total_price) as total
              from {$none['sales_list']}
             where ns_date NOT LIKE '{$date}%'
               and nw_code = '{$k}'
               and ns_type = '도급기성'
        ");

        // 세금계산서 "합" = 올해 taxSum + 이전년도 prevTax['total']
        $taxAll = $taxSum + $prevTax['total'];

        // 세금계산서 발행률(%) 누적
        $nw_contract_price = (int)$work['nw_contract_price'];
        if($prevTax['total'] && $nw_contract_price > 0) {
            $prevTaxPersent = round($prevTax['total'] / $nw_contract_price * 100);
        }
        $taxSumPersentAll = $taxSumPersent + $prevTaxPersent;

        // 도급기성 "합" = 올해 priceSum + 이전년도 prevPrice['total']
        $priceAll   = $priceSum + $prevPrice['total'];

        // 도급기성 입금률(%) 누적
        $nw_contract_price2 = (int)$work['nw_contract_price'] + (int)$work['nw_price2'];
        if($prevPrice['total'] && $nw_contract_price2 > 0) {
            $prevPricePersent = round($prevPrice['total'] / $nw_contract_price2 * 100);
        }
        $priceSumPersentAll = $priceSumPersent + $prevPricePersent;

        // 잔금(마지막 계산된 $blance)
        // 만약 여러줄 있을 때, $blance는 마지막 도급기성의 값이 들어 있음

        // "소계" 표시
        echo '<tr style="border-bottom:3px solid #ccc; background:#f2f2f2;">
                <td colspan="3" class="text-right font-weight-bold">소계</td>
                <td class="text-right font-weight-bold">'.number_format($taxAll).'</td>
                <td class="text-right font-weight-bold" style="border-right:3px solid #ccc">'
                  .$taxSumPersentAll.'%
                </td>
                <td class="text-right font-weight-bold">'
                  .number_format($taxAll - ($misu2 + $prevPrice2['total'])). // ??? 
                '</td>
                <td class="text-right font-weight-bold">'
                  .number_format($priceAll). 
                '</td>
                <td class="text-right font-weight-bold">'
                  .($priceSumPersentAll).'% 
                </td>
                <td class="text-right font-weight-bold">'
                  .number_format($blance).
                '</td>
                <td></td>
              </tr>
        ';

        // 도급기성 소계(현금 제외) => $misu + $prevPrice2['total']
        // 실수령액 => ?
        // etc. (원본 로직 유지)

        // (3-6) 연간 총계 누적
        // 실수령액 (도급기성 소계 총계)
        $totalPriceSum += $priceSum; 
        // 잔금 ( 잔금총계)
        $totalBlance   += $blance;
        // 세금계산서 총계 
        $totalTax += $taxAll;
        // 도급기성 소계(현금제외)
        $totalPrice += $misu + $prevPrice2['total'];

        // 임시변수 reset
        unset($prevTax, $prevPrice, $prevPrice2);
    } // end foreach($data)

    // 최종: 상반기/하반기/연간 합계
    //  ex) $firstHalf_total(세금) + $firstHalf_ptotal(도급기성)
    echo '<tr>
            <td colspan="3" class="text-right bg-success text-white">
              상반기 합계
            </td>
            <td class="text-right font-weight-bold">'
              .number_format($firstHalf_total).
            '</td>
            <td class="text-right bg-primary text-white">
              상반기 미수금
            </td>
            <td class="text-right font-weight-bold">'
              .number_format($firstHalf_total - $firstHalf_ptotal).
            '</td>
            <td class="text-right bg-danger text-white">
              실수령액
            </td>
            <td class="text-right font-weight-bold">'
              .number_format($totalPriceSum).
            '</td>
            <td class="text-right bg-danger text-white" rowspan="3">
              잔금
            </td>
            <td class="text-right font-weight-bold" rowspan="3">'
              .number_format($totalBlance).
            '</td>
          </tr>
          <tr>
            <td colspan="3" class="text-right bg-success text-white">
              하반기 합계
            </td>
            <td class="text-right font-weight-bold">'
              .number_format($secondHalf_total).
            '</td>
            <td class="text-right bg-primary text-white">
              하반기 미수금
            </td>
            <td class="text-right font-weight-bold">'
              .number_format($secondHalf_total - $secondHalf_ptotal).
            '</td>
            <td rowspan="2" class="text-right bg-danger text-white">
              총 미수금
            </td>
            <td rowspan="2" class="text-right font-weight-bold">'
              .number_format($totalTax - $totalPrice).
            '</td>
          </tr>
          <tr>
            <td colspan="3" class="text-right bg-success text-white">
              연간 합계
            </td>
            <td class="text-right font-weight-bold">'
              .number_format($firstHalf_total + $secondHalf_total).
            '</td>
            <td class="text-right bg-primary text-white">
              연간 미수금
            </td>
            <td class="text-right font-weight-bold">';

    $firstHalf_misu  = $firstHalf_total  - $firstHalf_ptotal;
    $secondHalf_misu = $secondHalf_total - $secondHalf_ptotal;
    $allMisu         = $firstHalf_misu + $secondHalf_misu;
    echo number_format($allMisu);

    echo '</td>
          </tr>';
} // end if($z == 0) else
?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.body project_report -->

            <?php 
            // 하단 페이징
            echo get_paging_none(
                G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], 
                $page, 
                $total_page, 
                $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='
            );
            ?>
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /#main-content -->

<script>
function del_(seq) {
    if(confirm('정말 매출현황 정보를 삭제하시겠습니까?')) {
        location.href = '/_statistics/write/menu2_update.php?w=d&seq=' + seq;
    } else {
        return false;
    }
}
</script>

<?php include_once(NONE_PATH.'/footer.php');?>
