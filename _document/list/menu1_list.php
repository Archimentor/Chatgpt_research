<?php
include_once('../../_common.php');
define('menu_document', true);
include_once(NONE_PATH.'/header.php');

// (1) 파라미터 처리
if(!$_GET['date']) {
    $date = date('Y');
} else {
    $date = (int)$_GET['date'];
}

// (2) 기본 SQL 구문
$sql_common = " FROM {$none['worksite']} ";
$sql_search = " WHERE nw_sdate LIKE '$date%' AND nw_code != '210707' ";

if ($stx) {
    $sql_search .= " AND ( ";
    switch ($sfl) {
        case "bo_table":
            $sql_search .= " ($sfl LIKE '$stx%') ";
            break;
        case "a.gr_id":
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default:
            // 공사명(nw_subject)으로 검색
            $sql_search .= " (nw_subject LIKE '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

// (3) 정렬과 페이징
if (!$sst) {
    $sst = "nw_code";
    $sod = "DESC";
}
$sql_order = " ORDER BY $sst $sod ";

$sql = " SELECT COUNT(*) AS cnt
         {$sql_common}
         {$sql_search} ";
$row_count_check = sql_fetch($sql);
$total_count = $row_count_check['cnt'];

$rows = 100;
$total_page  = ceil($total_count / $rows);
if ($page < 1) $page = 1;
$from_record = ($page - 1) * $rows;

$sql = " SELECT *
         {$sql_common}
         {$sql_search}
         {$sql_order}
         LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);

$qstr .= "date=$date";
if ($stx) {
    $qstr .= "&stx=" . urlencode($stx);
}

// (4) 합계(=과거 '소계')는 각 현장의 “최신 차수”만 더하도록,
//     + 공사비증감 전체 합도 함께 구함.
$total_price1 = 0; // 전체 공급가액 합계
$total_price2 = 0; // 전체 현금금액 합계
$total_price3 = 0; // 전체 총액 합계

$total_diff   = 0; // 공사비증감 전체 합 (2차 이상 증감들의 합산)

?>
<div id="main-content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    문서관리
                </h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">문서관리</li>
                    <li class="breadcrumb-item active">도급계약총괄표</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="body">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary"
                                onclick="location.href='?date=<?php echo ($date - 1); ?>&stx=<?php echo urlencode($stx); ?>'"> &lt;
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <?php echo $date; ?>년
                        </button>
                        <button type="button" class="btn btn-secondary"
                                onclick="location.href='?date=<?php echo ($date + 1); ?>&stx=<?php echo urlencode($stx); ?>'"> &gt;
                        </button>
                    </div>

                    <form class="float-right" style="margin-right:5px" method="get" action="">
                         <input type="hidden" name="date" value="<?php echo $date; ?>">
                        <div class="input-group">
                            <input type="text" name="stx" value="<?php echo htmlspecialchars($stx); ?>"
                                   class="form-control" placeholder="공사명 검색" />
                            <div class="input-group-append">
                                 <button type="submit" class="input-group-text" id="search-mail">
                                    <i class="icon-magnifier"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="body project_report">
                    <div class="table-responsive">
                        <table class="table m-b-0 table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">현장번호</th>
                                    <th class="text-center">계약<br>차수</th>
                                    <th class="text-center">발주자</th>
                                    <th class="text-center">공사명</th>
                                    <th class="text-center">계약일</th>
                                    <th class="text-center">공사기간</th>
                                    <th class="text-center">공급가액</th>
                                    <th class="text-center">현금금액</th>
                                    <th class="text-center">총액</th>
                                    <th class="text-center">공사비증감</th>
                                    <th class="text-center">진행상태</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                                // 진행상태
                                if ($row['nw_status']) {
                                    $status = '<span class="badge badge-success">완 료</span>';
                                } else {
                                    $status = '<span class="badge badge-warning">진행중</span>';
                                }

                                // 2차 이상 여부
                                $sql_check_secondary = "
                                  SELECT COUNT(*) AS cnt_secondary
                                    FROM {$none['worksite_add']}
                                   WHERE nw_id = '".sql_real_escape_string($row['seq'])."'
                                ";
                                $row_check_secondary = sql_fetch($sql_check_secondary);
                                $has_secondary_contracts = ($row_check_secondary['cnt_secondary'] > 0);

                                // 테두리 스타일
                                $apply_separator = ($i > 0 && $has_secondary_contracts);
                                $separator_style = $apply_separator ? 'style="border-top:8px solid #ddd"' : '';

                                // (a) 먼저 1차 표시
                                ?>
                                <tr <?php echo $separator_style; ?>>
                                    <td class="text-center">
                                        <a href="/_worksite/write/menu1_write.php?w=u&seq=<?php echo $row['seq']; ?>">
                                            <?php echo $row['nw_code']; ?>
                                        </a>
                                    </td>
                                    <td class="text-center">1차</td>
                                    <td class="text-center"><?php echo get_owner_txt($row['nw_ptype3_1']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($row['nw_subject']); ?></td>
                                    <td class="text-center"><?php echo substr($row['nw_contract_date'], 2, 10); ?></td>
                                    <td class="text-center">
                                        <?php echo substr($row['nw_sdate'], 2, 10); ?>~
                                        <?php echo substr($row['nw_edate'], 2, 10); ?>
                                    </td>
                                    <td class="text-right">
                                        <?php echo number_format($row['nw_price1']); ?>원
                                    </td>
                                    <td class="text-right">
                                        <?php echo number_format($row['nw_price2']); ?>원
                                    </td>
                                    <td class="text-right" style="color:#cf3434">
                                        <?php echo number_format($row['nw_total_price']); ?>원
                                    </td>
                                    <td class="text-right"></td>
                                    <td class="text-center"><?php echo $status; ?></td>
                                </tr>
                                <?php
                                // (b) 최신 차수 계산
                                $finalPrice1 = (int)$row['nw_price1'];
                                $finalPrice2 = (int)$row['nw_price2'];
                                $finalPrice3 = (int)$row['nw_total_price'];

                                // 공사비증감 (전체 2차 이상에서 발생한 diff) → 이 계약만의 누적
                                $contract_diff_sum = 0;

                                $prevTotalPrice = $finalPrice3;

                                // (c) 2차 이상
                                if ($has_secondary_contracts) {
                                    $sql2 = "
                                        SELECT *
                                          FROM {$none['worksite_add']}
                                         WHERE nw_id = '".sql_real_escape_string($row['seq'])."'
                                         ORDER BY nw_num ASC
                                    ";
                                    $result2 = sql_query($sql2);
                                    while($row2 = sql_fetch_array($result2)) {
                                        $chasu = (int)$row2['nw_num'] . '차';

                                        // 공사비증감 = 현재차수 총액 - 이전차수 총액
                                        $nowPrice  = (int)$row2['nw_total_price'];
                                        $diff      = $nowPrice - $prevTotalPrice;
                                        $prevTotalPrice = $nowPrice;

                                        // diff 누적
                                        $contract_diff_sum += $diff;

                                        // 표시용
                                        if ($diff > 0) {
                                            $diff_display = '<span style="color:red">+'.number_format($diff).'원</span>';
                                        } else if ($diff < 0) {
                                            $diff_display = '<span style="color:blue">'.number_format($diff).'원</span>';
                                        } else {
                                            $diff_display = '변동없음';
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <a href="/_worksite/write/menu1_write.php?w=u&seq=<?php echo $row['seq']; ?>">
                                                    <?php echo $row['nw_code']; ?>
                                                </a>
                                            </td>
                                            <td class="text-center"><?php echo $chasu; ?></td>
                                            <td class="text-center">
                                                <?php echo get_owner_txt($row['nw_ptype3_1']); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo htmlspecialchars($row['nw_subject']); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo substr($row2['nw_contract_date'], 2, 10); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo substr($row2['nw_sdate'], 2, 10); ?>~
                                                <?php echo substr($row2['nw_edate'], 2, 10); ?>
                                            </td>
                                            <td class="text-right">
                                                <?php echo number_format($row2['nw_price1']); ?>원
                                            </td>
                                            <td class="text-right">
                                                <?php echo number_format($row2['nw_price2']); ?>원
                                            </td>
                                            <td class="text-right" style="color:#cf3434">
                                                <?php echo number_format($row2['nw_total_price']); ?>원
                                            </td>
                                            <td class="text-right">
                                                <?php echo $diff_display; ?>
                                            </td>
                                            <td class="text-center"><?php echo $status; ?></td>
                                        </tr>
                                        <?php
                                        // 최신 차수 갱신
                                        $finalPrice1 = (int)$row2['nw_price1'];
                                        $finalPrice2 = (int)$row2['nw_price2'];
                                        $finalPrice3 = (int)$row2['nw_total_price'];
                                    }
                                }

                                // (d) 이 계약의 최종(최신) 금액만 합계에 반영
                                $total_price1 += $finalPrice1;
                                $total_price2 += $finalPrice2;
                                $total_price3 += $finalPrice3;

                                // (d-1) “이 계약”의 전체 2차 이상 diff 합계를 전체에 누적
                                $total_diff += $contract_diff_sum;
                            }

                            // 데이터가 없을 때
                            if ($i == 0) { ?>
                                <tr>
                                    <td colspan="11" class="text-center">
                                        검색 된 데이터가 없습니다.
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php
                            // (e) 테이블 하단에 “합계” 표시 + 공사비증감도 합산
                            if ($i > 0) {
                                // total_diff의 부호 + 색상
                                $sign = '';
                                $color= 'black';
                                if($total_diff > 0) {
                                    $sign  = '+';
                                    $color = 'red';
                                } else if($total_diff < 0) {
                                    $sign  = '-';
                                    $color = 'blue';
                                }
                                $abs_diff = abs($total_diff);
                                $diff_final_html = $sign
                                    ? "<span style=\"color:{$color}\">{$sign}".number_format($abs_diff)."원</span>"
                                    : '';
                                ?>
                            <tr style="background:#f2f2f2; border-top: 2px solid #bbb;">
                                <td style="font-weight:bold;">합계</td>
                                <td colspan="4">&nbsp;</td> 
                                <!-- 5개 비움(계약차수, 발주자, 공사명, 계약일, 공사기간) -->
                                <td></td> <!-- 6번째: 사실상 더 비워둠 -->
                                <td style="color:#cf3434; font-weight:bold;" class="text-right">
                                    <?php echo number_format($total_price1); ?>원
                                </td>
                                <td style="color:#cf3434; font-weight:bold;" class="text-right">
                                    <?php echo number_format($total_price2); ?>원
                                </td>
                                <td style="color:#cf3434; font-weight:bold;" class="text-right">
                                    <?php echo number_format($total_price3); ?>원
                                </td>
                                <!-- 공사비증감 합계 -->
                                <td class="text-right">
                                    <?php echo $diff_final_html; ?>
                                </td>
                                <td></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                // (6) 페이징
                echo get_paging_none(
                    G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'],
                    $page,
                    $total_page,
                    $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='
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
    }
}
</script>

<?php include_once(NONE_PATH.'/footer.php'); ?>
