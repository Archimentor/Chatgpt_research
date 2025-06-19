<?php 
include_once('../../_common.php');
define('menu_statistics', true);
include_once(NONE_PATH.'/header.php'); 

// date 파라미터가 없을 경우 현재 연도를 사용
if(!$_GET['date']) {
    $date = date('Y');
} else {
    $date = $_GET['date'];
}

?>

<style>
/* 공통 스타일 */
.project_report h2 {
    font-size: 25px;
    text-align: center;
    color: #000;
}
.info_txt ul {
    list-style: none;
    padding: 0;
}
.subcontract_price {
    background: #f2f2f2;
}
.subcontract_price td {
    padding: 3px;
}
.num {
    text-align: right;
}
.input_num {
    border: 0;
    width: 80px;
    text-align: right;
}
.table {
    font-size: 13px;
    border-top: 2px solid #000;
}
.table thead th {
    vertical-align: middle;
    text-align: center;
    border-right: 1px solid #ddd;
    padding: 3px;
}
.table tbody td {
    padding: 3px;
    border-top: 0;
}
.table select {
    border: 0;
    width: 100%;
    text-align: center;
}
.default_row td {
    padding: 3px;
}
.tit_row {
    text-align: center;
}
.bg1 { background-color: #FDE9D9; }
.bg2 { background-color: #DAEEF3; }
.bg3 { background-color: #E5DFEC; }
.bg4 { background-color: #EAF1DD; }
.bg5 { background-color: #F2DBDB; }
.bg6 { background-color: #e7dbef; }

/* 짝수행 배경색 */
tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* 스크롤 테이블 관련: th 고정 등을 위한 예시
   (크로스브라우징 고려해야 함. 필요시 수정) */
.table thead th.sticky-left {
    position: sticky;
    left: 0;
    background: #fff;
}
</style>

<!--현장별매출현황-->
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
                    <li class="breadcrumb-item active">현장진행 총괄표</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="body">
                    <!-- 연도 이동 버튼 -->
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='?work_id=<?php echo $work_id?>&date=<?php echo ($date-1)?>'">
                            <
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <?php echo $date?>년
                        </button>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='?work_id=<?php echo $work_id?>&date=<?php echo ($date+1)?>'">
                            >
                        </button>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <div class="body project_report" style="width:2800px;">
                        <h2>현장진행총괄표(<?php echo $date?>년)</h2>
                        <div class="table-responsive">
                            <table class="table m-b-0">
                                <thead>
                                <tr style="background:#f2f2f2">
                                    <!-- sticky-left 클래스로 고정 칼럼 처리 가능 -->
                                    <th rowspan="2" class="sticky-left" style="border-left:1px solid #ddd;">
                                        현장번호
                                    </th>
                                    <th rowspan="2" style="width:350px">현장명</th>
                                    <th>지출</th>
                                    <th>월별</th>
                                    <th rowspan="2">공사금액</th>
                                    <th rowspan="2">부가세</th>
                                    <th rowspan="2">계약금액</th>
                                    <th rowspan="2">현금</th>
                                    <th rowspan="2">추가공사</th>
                                    <th rowspan="2">총액</th>
                                    <th rowspan="2">미지급금</th>
                                    <th rowspan="2">유보</th>
                                    <th rowspan="2">1월</th>
                                    <th rowspan="2">2월</th>
                                    <th rowspan="2">3월</th>
                                    <th rowspan="2">4월</th>
                                    <th rowspan="2">5월</th>
                                    <th rowspan="2">6월</th>
                                    <th rowspan="2">7월</th>
                                    <th rowspan="2">8월</th>
                                    <th rowspan="2">9월</th>
                                    <th rowspan="2">10월</th>
                                    <th rowspan="2">11월</th>
                                    <th rowspan="2">12월</th>
                                    <th rowspan="2">누계</th>
                                    <th>잔액(외주)</th>
                                    <th rowspan="2">미수금</th>
                                    <th rowspan="2">잔금</th>
                                </tr>
                                <tr style="background:#f2f2f2">
                                    <th>수령</th>
                                    <th>누계</th>
                                    <th>잔액(예정)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                // 현장 조회
                                $sql = "
                                    SELECT *
                                    FROM {$none['worksite']}
                                    WHERE nw_sdate LIKE '$date%' 
                                       OR nw_edate LIKE '$date%'
                                    ORDER BY nw_code DESC
                                ";
                                $rst = sql_query($sql);

                                // 총계 변수
                                $last_total1 = $last_total2 = $last_total3 = $last_total4 = 0;
                                $last_total5 = $last_total6 = $last_total7 = $last_total8 = 0;
                                $last_total9 = $last_total10 = $last_total11 = $last_total12 = 0;
                                $last_total13 = $last_total14 = $last_total15 = $last_total16 = 0;
                                $last_total17 = $last_total18 = $last_total19 = $last_total20 = 0;
                                $last_total21 = $last_total22 = $last_total23 = $last_total24 = 0;
                                $last_total25 = $last_total26 = $last_total27 = $last_total28 = 0;
                                $last_total29 = $last_total30 = $last_total31 = $last_total32 = 0;
                                $last_total33 = $last_total34 = $last_total35 = $last_total36 = 0;
                                $last_total37 = $last_total38 = $last_total39 = $last_total40 = 0;
                                $last_total41 = $last_total42 = $last_total43 = $last_total44 = 0;
                                $last_total45 = $last_total46 = $last_total47 = $last_total48 = 0;
                                $last_total49 = $last_total50 = $last_total51 = $last_total52 = 0;
                                $last_total53 = $last_total54 = $last_total55 = $last_total56 = 0;
                                $last_total57 = $last_total58 = $last_total59 = $last_total60 = 0;
                                $last_total61 = 0;

                                for($i=0; $row=sql_fetch_array($rst); $i++) {
                                    // 차수 증감에 따른 금액 더하기
                                    $last = sql_fetch("
                                        SELECT * 
                                        FROM {$none['worksite_add']} 
                                        WHERE nw_id = '{$row['seq']}' 
                                        ORDER BY nw_num DESC LIMIT 1
                                    ");
                                    if($last) {
                                        $row['nw_price1']         = $last['nw_price1'];
                                        $row['nw_vat']            = $last['nw_vat'];
                                        $row['nw_contract_price'] = $last['nw_contract_price'];
                                        $row['nw_price2']         = $last['nw_price2'];
                                    }

                                    // 추가공사, 미지급금, 유보 : 기성집계표에서
                                    $add = sql_fetch("
                                        SELECT 
                                            SUM(ns_price1) AS price1, 
                                            SUM(ns_price2) AS price2,
                                            SUM(ns_price3) AS price3 
                                        FROM {$none['statistics4']} 
                                        WHERE work_id = '{$row['nw_code']}'
                                    ");

                                    // 지출(월별)
                                    $pprice = array();
                                    $psql = "
                                        SELECT *
                                        FROM {$none['est_jungsan_price']} 
                                        WHERE nw_code = '{$row['nw_code']}' 
                                          AND ne_date LIKE '$date%'
                                    ";
                                    $prst = sql_query($psql);
                                    while($prow = sql_fetch_array($prst)) {
                                        $pprice[$prow['ne_date']] += $prow['ne_price11'];
                                    }

                                    // 누계
                                    $total = sql_fetch("
                                        SELECT SUM(ne_price11) AS price 
                                        FROM {$none['est_jungsan_price']} 
                                        WHERE nw_code = '{$row['nw_code']}'
                                    ");

                                    // 도급액 계산(월별)
                                    $top_price = array();
                                    $top_price_sql = "
                                        SELECT 
                                            DATE_FORMAT(ns_date, '%Y-%m') AS ns_date2,
                                            SUM(ns_total_price) AS ns_total_price
                                        FROM {$none['sales_list']}
                                        WHERE nw_code = '{$row['nw_code']}'
                                          AND (
                                             ns_type = '도급기성' 
                                             OR ns_type = '도급기성(현금)'
                                          )
                                          AND DATE_FORMAT(ns_date, '%Y') = '$date'
                                        GROUP BY ns_date2
                                        ORDER BY ns_date2
                                    ";
                                    $top_price_rst = sql_query($top_price_sql);
                                    while($top = sql_fetch_array($top_price_rst)) {
                                        $top_price[$top['ns_date2']] = $top['ns_total_price'];
                                    }

                                    // 미수금, 잔금 계산
                                    $misu_row1 = sql_fetch("
                                        SELECT SUM(ns_total_price) AS price
                                        FROM {$none['sales_list']}
                                        WHERE nw_code = '{$row['nw_code']}'
                                          AND ns_type = '세금계산서'
                                    ");
                                    $misu_row2 = sql_fetch("
                                        SELECT SUM(ns_total_price) AS price
                                        FROM {$none['sales_list']}
                                        WHERE nw_code = '{$row['nw_code']}'
                                          AND ns_type = '도급기성'
                                    ");
                                    $misu_row3 = sql_fetch("
                                        SELECT SUM(ns_total_price) AS price
                                        FROM {$none['sales_list']}
                                        WHERE nw_code = '{$row['nw_code']}'
                                          AND ns_type != '세금계산서'
                                    ");

                                    // 미수금
                                    $misu = $misu_row1['price'] - $misu_row2['price'];

                                    // 잔금
                                    $balance = ($row['nw_contract_price'] + $row['nw_price2']) - $misu_row3['price'];

                                    // 잔액(외주)
                                    $total_1 = sql_fetch("
                                        SELECT SUM(ne_price18) AS price
                                        FROM {$none['est_jungsan']}
                                        WHERE nw_code = '{$row['nw_code']}' 
                                          AND ne_type = 1
                                    ");

                                    // 잔액(예정)
                                    $total_2 = $balance - $total_1['price'];

                                    // 연도별 월합계(지출) 미리 계산
                                    $pprice_total1  = $pprice[$date.'-01'];
                                    $pprice_total2  = $pprice_total1  + $pprice[$date.'-02'];
                                    $pprice_total3  = $pprice_total2  + $pprice[$date.'-03'];
                                    $pprice_total4  = $pprice_total3  + $pprice[$date.'-04'];
                                    $pprice_total5  = $pprice_total4  + $pprice[$date.'-05'];
                                    $pprice_total6  = $pprice_total5  + $pprice[$date.'-06'];
                                    $pprice_total7  = $pprice_total6  + $pprice[$date.'-07'];
                                    $pprice_total8  = $pprice_total7  + $pprice[$date.'-08'];
                                    $pprice_total9  = $pprice_total8  + $pprice[$date.'-09'];
                                    $pprice_total10 = $pprice_total9  + $pprice[$date.'-10'];
                                    $pprice_total11 = $pprice_total10 + $pprice[$date.'-11'];
                                    $pprice_total12 = $pprice_total11 + $pprice[$date.'-12'];

                                    // 수령(도급기성) 누계
                                    $top_price_total1  = $top_price[$date.'-01'];
                                    $top_price_total2  = $top_price_total1  + $top_price[$date.'-02'];
                                    $top_price_total3  = $top_price_total2  + $top_price[$date.'-03'];
                                    $top_price_total4  = $top_price_total3  + $top_price[$date.'-04'];
                                    $top_price_total5  = $top_price_total4  + $top_price[$date.'-05'];
                                    $top_price_total6  = $top_price_total5  + $top_price[$date.'-06'];
                                    $top_price_total7  = $top_price_total6  + $top_price[$date.'-07'];
                                    $top_price_total8  = $top_price_total7  + $top_price[$date.'-08'];
                                    $top_price_total9  = $top_price_total8  + $top_price[$date.'-09'];
                                    $top_price_total10 = $top_price_total9  + $top_price[$date.'-10'];
                                    $top_price_total11 = $top_price_total10 + $top_price[$date.'-11'];
                                    $top_price_total12 = $top_price_total11 + $top_price[$date.'-12'];

                                ?>
                                <tr>
                                    <td rowspan="4" class="text-center"><?php echo $row['nw_code'];?></td>
                                    <td rowspan="4" style="padding-left:10px;"><?php echo $row['nw_subject'];?></td>
                                    <td rowspan="2" class="text-center">지출</td>
                                    <td class="text-center">월별</td>
                                    <td rowspan="4" class="num"><?php echo number_format($row['nw_price1']);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($row['nw_vat']);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($row['nw_contract_price']);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($row['nw_price2']);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($add['price1']);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($row['nw_total_price']);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($add['price2']);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($add['price3']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-01']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-02']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-03']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-04']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-05']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-06']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-07']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-08']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-09']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-10']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-11']);?></td>
                                    <td class="num"><?php echo number_format($pprice[$date.'-12']);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($total['price']);?></td>
                                    <td rowspan="2" class="num"><?php echo number_format($total_1['price']);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($misu);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($balance);?></td>
                                </tr>
                                <tr>
                                    <td class="text-center">누계</td>
                                    <td class="num"><?php echo number_format($pprice_total1);?></td>
                                    <td class="num"><?php echo number_format($pprice_total2);?></td>
                                    <td class="num"><?php echo number_format($pprice_total3);?></td>
                                    <td class="num"><?php echo number_format($pprice_total4);?></td>
                                    <td class="num"><?php echo number_format($pprice_total5);?></td>
                                    <td class="num"><?php echo number_format($pprice_total6);?></td>
                                    <td class="num"><?php echo number_format($pprice_total7);?></td>
                                    <td class="num"><?php echo number_format($pprice_total8);?></td>
                                    <td class="num"><?php echo number_format($pprice_total9);?></td>
                                    <td class="num"><?php echo number_format($pprice_total10);?></td>
                                    <td class="num"><?php echo number_format($pprice_total11);?></td>
                                    <td class="num"><?php echo number_format($pprice_total12);?></td>
                                </tr>
                                <tr>
                                    <td rowspan="2" class="text-center">수령</td>
                                    <td class="text-center">월별</td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-01']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-02']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-03']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-04']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-05']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-06']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-07']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-08']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-09']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-10']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-11']);?></td>
                                    <td class="num"><?php echo number_format($top_price[$date.'-12']);?></td>
                                    <td rowspan="2" class="num"><?php echo number_format($total_2);?></td>
                                </tr>
                                <tr>
                                    <td class="text-center">누계</td>
                                    <td class="num"><?php echo number_format($top_price_total1);?></td>
                                    <td class="num"><?php echo number_format($top_price_total2);?></td>
                                    <td class="num"><?php echo number_format($top_price_total3);?></td>
                                    <td class="num"><?php echo number_format($top_price_total4);?></td>
                                    <td class="num"><?php echo number_format($top_price_total5);?></td>
                                    <td class="num"><?php echo number_format($top_price_total6);?></td>
                                    <td class="num"><?php echo number_format($top_price_total7);?></td>
                                    <td class="num"><?php echo number_format($top_price_total8);?></td>
                                    <td class="num"><?php echo number_format($top_price_total9);?></td>
                                    <td class="num"><?php echo number_format($top_price_total10);?></td>
                                    <td class="num"><?php echo number_format($top_price_total11);?></td>
                                    <td class="num"><?php echo number_format($top_price_total12);?></td>
                                </tr>
                                <tr style="height:2px;">
                                    <td colspan="28" style="border-top:2px solid #000;border-bottom:0;padding:0"></td>
                                </tr>
                                <?php 
                                    // 총계 계산
                                    $last_total1  += $row['nw_price1'];         // 공사금액
                                    $last_total2  += $row['nw_vat'];            // 부가세
                                    $last_total3  += $row['nw_contract_price']; // 계약금액
                                    $last_total4  += $row['nw_price2'];         // 현금
                                    $last_total5  += $add['price1'];            // 추가공사
                                    $last_total6  += $row['nw_total_price'];    // 총액
                                    $last_total7  += $add['price2'];            // 미지급금
                                    $last_total8  += $add['price3'];            // 유보

                                    // 지출 - 월별 총계
                                    $last_total9  += $pprice[$date.'-01'];
                                    $last_total10 += $pprice[$date.'-02'];
                                    $last_total11 += $pprice[$date.'-03'];
                                    $last_total12 += $pprice[$date.'-04'];
                                    $last_total13 += $pprice[$date.'-05'];
                                    $last_total14 += $pprice[$date.'-06'];
                                    $last_total15 += $pprice[$date.'-07'];
                                    $last_total16 += $pprice[$date.'-08'];
                                    $last_total17 += $pprice[$date.'-09'];
                                    $last_total18 += $pprice[$date.'-10'];
                                    $last_total19 += $pprice[$date.'-11'];
                                    $last_total20 += $pprice[$date.'-12'];

                                    // 지출 - 누계 총계
                                    $last_total21 += $pprice_total1;
                                    $last_total22 += $pprice_total2;
                                    $last_total23 += $pprice_total3;
                                    $last_total24 += $pprice_total4;
                                    $last_total25 += $pprice_total5;
                                    $last_total26 += $pprice_total6;
                                    $last_total27 += $pprice_total7;
                                    $last_total28 += $pprice_total8;
                                    $last_total29 += $pprice_total9;
                                    $last_total30 += $pprice_total10;
                                    $last_total31 += $pprice_total11;
                                    $last_total32 += $pprice_total12;

                                    // 수령 - 월별 총계
                                    $last_total33 += $top_price[$date.'-01'];
                                    $last_total34 += $top_price[$date.'-02'];
                                    $last_total35 += $top_price[$date.'-03'];
                                    $last_total36 += $top_price[$date.'-04'];
                                    $last_total37 += $top_price[$date.'-05'];
                                    $last_total38 += $top_price[$date.'-06'];
                                    $last_total39 += $top_price[$date.'-07'];
                                    $last_total40 += $top_price[$date.'-08'];
                                    $last_total41 += $top_price[$date.'-09'];
                                    $last_total42 += $top_price[$date.'-10'];
                                    $last_total43 += $top_price[$date.'-11'];
                                    $last_total44 += $top_price[$date.'-12'];

                                    // 수령 - 누계 총계
                                    $last_total45 += $top_price_total1;
                                    $last_total46 += $top_price_total2;
                                    $last_total47 += $top_price_total3;
                                    $last_total48 += $top_price_total4;
                                    $last_total49 += $top_price_total5;
                                    $last_total50 += $top_price_total6;
                                    $last_total51 += $top_price_total7;
                                    $last_total52 += $top_price_total8;
                                    $last_total53 += $top_price_total9;
                                    $last_total54 += $top_price_total10;
                                    $last_total55 += $top_price_total11;
                                    $last_total56 += $top_price_total12;

                                    $last_total57 += $total['price'];       // 누계
                                    $last_total58 += $total_1['price'];     // 잔액(외주)
                                    $last_total59 += $total_2;              // 잔액(예정)
                                    $last_total60 += $misu;                 // 미수금
                                    $last_total61 += $balance;              // 잔금
                                } // end for
                                ?>

                                <!-- 총계 표시 -->
                                <tr style="background:#C6E0B4;color:#000" class="text-center">
                                    <td colspan="2" rowspan="4" style="font-weight:bold">총계</td>
                                    <td rowspan="2" class="text-center">지출</td>
                                    <td class="text-center">월별</td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total1);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total2);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total3);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total4);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total5);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total6);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total7);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total8);?></td>
                                    <td class="num"><?php echo number_format($last_total9);?></td>
                                    <td class="num"><?php echo number_format($last_total10);?></td>
                                    <td class="num"><?php echo number_format($last_total11);?></td>
                                    <td class="num"><?php echo number_format($last_total12);?></td>
                                    <td class="num"><?php echo number_format($last_total13);?></td>
                                    <td class="num"><?php echo number_format($last_total14);?></td>
                                    <td class="num"><?php echo number_format($last_total15);?></td>
                                    <td class="num"><?php echo number_format($last_total16);?></td>
                                    <td class="num"><?php echo number_format($last_total17);?></td>
                                    <td class="num"><?php echo number_format($last_total18);?></td>
                                    <td class="num"><?php echo number_format($last_total19);?></td>
                                    <td class="num"><?php echo number_format($last_total20);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total57);?></td>
                                    <td rowspan="2" class="num"><?php echo number_format($last_total58);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total60);?></td>
                                    <td rowspan="4" class="num"><?php echo number_format($last_total61);?></td>
                                </tr>
                                <tr style="background:#C6E0B4;color:#000" class="text-center">
                                    <td>누계</td>
                                    <td class="num"><?php echo number_format($last_total21);?></td>
                                    <td class="num"><?php echo number_format($last_total22);?></td>
                                    <td class="num"><?php echo number_format($last_total23);?></td>
                                    <td class="num"><?php echo number_format($last_total24);?></td>
                                    <td class="num"><?php echo number_format($last_total25);?></td>
                                    <td class="num"><?php echo number_format($last_total26);?></td>
                                    <td class="num"><?php echo number_format($last_total27);?></td>
                                    <td class="num"><?php echo number_format($last_total28);?></td>
                                    <td class="num"><?php echo number_format($last_total29);?></td>
                                    <td class="num"><?php echo number_format($last_total30);?></td>
                                    <td class="num"><?php echo number_format($last_total31);?></td>
                                    <td class="num"><?php echo number_format($last_total32);?></td>
                                </tr>
                                <tr style="background:#C6E0B4;color:#000" class="text-center">
                                    <td rowspan="2" class="text-center">수령</td>
                                    <td class="text-center">월별</td>
                                    <td class="num"><?php echo number_format($last_total33);?></td>
                                    <td class="num"><?php echo number_format($last_total34);?></td>
                                    <td class="num"><?php echo number_format($last_total35);?></td>
                                    <td class="num"><?php echo number_format($last_total36);?></td>
                                    <td class="num"><?php echo number_format($last_total37);?></td>
                                    <td class="num"><?php echo number_format($last_total38);?></td>
                                    <td class="num"><?php echo number_format($last_total39);?></td>
                                    <td class="num"><?php echo number_format($last_total40);?></td>
                                    <td class="num"><?php echo number_format($last_total41);?></td>
                                    <td class="num"><?php echo number_format($last_total42);?></td>
                                    <td class="num"><?php echo number_format($last_total43);?></td>
                                    <td class="num"><?php echo number_format($last_total44);?></td>
                                    <td rowspan="2" class="num"><?php echo number_format($last_total59);?></td>
                                </tr>
                                <tr style="background:#C6E0B4;color:#000" class="text-center">
                                    <td>누계</td>
                                    <td class="num"><?php echo number_format($last_total45);?></td>
                                    <td class="num"><?php echo number_format($last_total46);?></td>
                                    <td class="num"><?php echo number_format($last_total47);?></td>
                                    <td class="num"><?php echo number_format($last_total48);?></td>
                                    <td class="num"><?php echo number_format($last_total49);?></td>
                                    <td class="num"><?php echo number_format($last_total50);?></td>
                                    <td class="num"><?php echo number_format($last_total51);?></td>
                                    <td class="num"><?php echo number_format($last_total52);?></td>
                                    <td class="num"><?php echo number_format($last_total53);?></td>
                                    <td class="num"><?php echo number_format($last_total54);?></td>
                                    <td class="num"><?php echo number_format($last_total55);?></td>
                                    <td class="num"><?php echo number_format($last_total56);?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div> <!-- table-responsive 끝 -->
                    </div> <!-- project_report 끝 -->
                </div> <!-- overflow-x 끝 -->
            </div> <!-- card 끝 -->
        </div> <!-- col 끝 -->
    </div> <!-- row 끝 -->
</div> <!-- main-content 끝 -->

<?php include_once(NONE_PATH.'/footer.php');?>

<script>
// 필요하다면 추가 스크립트 작성
</script>
