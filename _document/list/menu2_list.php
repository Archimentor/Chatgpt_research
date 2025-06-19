<?php 
include_once('../../_common.php');
define('menu_owner', true);
include_once(NONE_PATH.'/header.php'); 

if(!$_GET['date']) {
    $date = date('Y');
}

// ========== 검색 조건 ==========
$sql_common = " FROM {$none['subcontract']} ";
$sql_search = " WHERE (1)";

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
            // 공사명 or 업체명 검색
            $sql_search .= " (work_name LIKE '%$stx%' OR ns_bname_txt LIKE '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
} else {
    if($work) {
        $sql_search .= " AND work_id = '$work' ";
    } else {
        // 예: ns_sdate LIKE '2023%'
        $sql_search .= " AND ns_sdate LIKE '$date%' ";
    }
}

if(!$sst) {
    $sst = "work_id";
    $sod = "desc";
}
$sql_order = " ORDER BY $sst $sod ";

// 전체 개수
$sql = " SELECT COUNT(*) AS cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows       = 600;
$total_page = ceil($total_count / $rows);
if ($page < 1) $page = 1;
$from_record = ($page - 1) * $rows;

// 메인 계약 목록
$sql = " SELECT * {$sql_common} {$sql_search} {$sql_order} LIMIT $from_record, $rows ";
$result = sql_query($sql, true);

$qstr .= "date=$date&amp;stx=$stx&amp;work={$_GET['work']}";
?>

<div id="main-content">
  <div class="block-header">
    <div class="row">
      <div class="col-lg-5 col-md-8 col-sm-12">                        
        <h2>
          <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
            <i class="fa fa-arrow-left"></i>
          </a>문서관리
        </h2>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
          <li class="breadcrumb-item">문서관리</li>
          <li class="breadcrumb-item active">하도급계약총괄표</li>
        </ul>
      </div>            
    </div>
  </div>

  <div class="row clearfix">
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="body">
          <!-- 연도 이동, 등록버튼, 검색창 -->
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary"
                    onclick="location.href='?date=<?php echo ($date-1)?>'">
              <
            </button>
            <button type="button" class="btn btn-secondary">
              <?php echo $date?>년
            </button>
            <button type="button" class="btn btn-secondary"
                    onclick="location.href='?date=<?php echo ($date+1)?>'">
              >
            </button>
          </div>
          <a class="btn btn-primary float-right" href="../write/menu2_write.php" role="button">
            하도급계약 등록
          </a> 
          
          <form class="float-right" style="margin-right:5px">
            <div class="input-group">
              <select name="status" id="inputState" class="form-control"
                      onchange="location.href='?work='+this.value">
                <option value="">현장별 보기 선택</option>
                <optgroup label="진행현장">
                  <?php 
                  $workSql = "
                    SELECT seq, nw_code, nw_subject, pj_title_kr
                      FROM {$none['worksite']} 
                     WHERE nw_status='0' 
                       AND nw_code != '210707' 
                  ORDER BY nw_code DESC";
                  $workRst = sql_query($workSql);
                  while($work = sql_fetch_array($workRst)) {
                      $nw_code = $work['nw_code'].' '.$work['pj_title_kr'];
                  ?>
                  <option value="<?php echo $work['nw_code']?>" 
                          <?php echo get_selected($work['nw_code'], $_GET['work'])?>>
                    <?php echo $nw_code?>
                  </option>
                  <?php 
                  }?>
                </optgroup>
                <optgroup label="완료현장">
                  <?php 
                  $workSql2 = "
                    SELECT seq, nw_code, nw_subject, pj_title_kr
                      FROM {$none['worksite']}
                     WHERE nw_status='1' 
                       AND nw_code != '210707' 
                  ORDER BY nw_code DESC";
                  $workRst2 = sql_query($workSql2);
                  while($work2 = sql_fetch_array($workRst2)) {
                      $nw_code2 = $work2['nw_code'].' '.$work2['pj_title_kr'];
                  ?>
                  <option value="<?php echo $work2['nw_code']?>" 
                          <?php echo get_selected($work2['nw_code'], $_GET['work'])?>>
                    <?php echo $nw_code2?>
                  </option>
                  <?php }?>
                </optgroup>
              </select>
              <input type="text" name="stx" value="<?php echo $stx?>"
                     class="form-control" placeholder="공사명 or 업체명 검색">
              <div class="input-group-append">
                <span class="input-group-text" id="search-mail">
                  <i class="icon-magnifier"></i>
                </span>
              </div>
            </div>
          </form>
        </div>

        <div class="body project_report" style="overflow-x:scroll">
          <div class="table-responsive" style="width:2400px">
            <table class="table m-b-0 table-hover">
              <thead class="thead-light">
                <tr>
                  <th class="text-center">현장번호</th>
                  <th class="text-center">공사명</th>
                  <th class="text-center">차수</th>
                  <th class="text-center">업체명</th>
                  <th class="text-center">공종명</th>
                  <th class="text-center">계약일</th>
                  <th class="text-center">공사기간</th>
                  <th class="text-center">공급가액</th>
                  <th class="text-center">부가세</th>
                  <th class="text-center">총액</th>
                  <th class="text-center">증감</th>
                  <th class="text-center">하수급인관리번호</th>
                  <th class="text-center">대표전화</th>
                  <th class="text-center">현장소장</th>
                  <th class="text-center">전화번호</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // 전체 합계(모든 현장) : 최신 차수 금액 + 전체차수 증감 합
                $grand_supply = 0;
                $grand_vat    = 0;
                $grand_total  = 0;
                $grand_diff   = 0;

                $prev_work_id = "";
                $site_supply  = 0;  // 현장별 소계 (공급가액 합)
                $site_vat     = 0;  // 현장별 소계 (부가세 합)
                $site_total   = 0;  // 현장별 소계 (총액 합)
                $site_diff    = 0;  // 현장별 증감 (전체 차수 sum)

                $rowCount = 0;

                while($row=sql_fetch_array($result)) {
                    $rowCount++;
                    $current_work_id = $row['work_id'];

                    // 이전 현장과 바뀌었으면, 이전현장 소계 출력
                    if($prev_work_id && $prev_work_id != $current_work_id) {
                        // 현장별 소계 행
                        $siteDiffSign  = '';
                        $siteDiffColor = 'black';
                        if($site_diff>0) {
                            $siteDiffSign  = '+';
                            $siteDiffColor = 'red';
                        } else if($site_diff<0) {
                            $siteDiffSign  = '-';
                            $siteDiffColor = 'blue';
                        }
                        $abs_site_diff = abs($site_diff);
                        $siteDiffTxt   = $siteDiffSign
                                         ? '<span style="color:'.$siteDiffColor.'">'
                                           .$siteDiffSign.number_format($abs_site_diff)
                                           .'</span>'
                                         : '';

                        ?>
                        <tr style="background:#e9f6ff">
                          <td><?php echo $prev_work_id?></td>
                          <td colspan="2">소계</td>
                          <td colspan="2"></td>
                          <td colspan="2"></td>
                          <td class="text-right"><?php echo number_format($site_supply)?>원</td>
                          <td class="text-right"><?php echo number_format($site_vat)?>원</td>
                          <td class="text-right" style="color:#cf3434">
                            <?php echo number_format($site_total)?>원
                          </td>
                          <td class="text-right"><?php echo $siteDiffTxt?></td>
                          <td colspan="4"></td>
                        </tr>
                        <?php
                        // 현장별 소계 → 전체 합계 반영
                        $grand_supply += $site_supply;
                        $grand_vat    += $site_vat;
                        $grand_total  += $site_total;
                        $grand_diff   += $site_diff;

                        // 새 현장 시작 → 리셋
                        $site_supply  = 0;
                        $site_vat     = 0;
                        $site_total   = 0;
                        $site_diff    = 0;
                    }

                    // (1) 메인(1차)
                    $main_supply = (int)$row['ns_price'];
                    $main_vat    = (int)$row['ns_vat'];
                    $main_total  = (int)$row['ns_total_price'];
                    $diff_txt    = ''; // 첫 차수라 증감 없음

                    // “최신차수” 금액(초기:1차)
                    $final_supply = $main_supply;
                    $final_vat    = $main_vat;
                    $final_total  = $main_total;

                    // “해당 계약(업체)의 전체 차수 증감 누적”
                    // main row에는 diff=0
                    $contract_diff_sum = 0;

                    ?>
                    <tr>
                      <td class="text-center">
                        <a href="../write/menu2_write.php?w=u&seq=<?php echo $row['seq']?>">
                          <?php echo $row['work_id']?>
                        </a>
                      </td>
                      <td class="text-center"><?php echo get_worksite_name($row['work_id'])?></td>
                      <td class="text-center">1차</td>
                      <td class="text-center"><?php echo get_enterprise_txt($row['ns_bname'])?></td>
                      <td class="text-center"><?php echo $row['ns_gongjong']?></td>
                      <td class="text-center">
                        <?php echo substr($row['ns_contract_date'],2,10)?>
                      </td>
                      <td class="text-center">
                        <?php echo substr($row['ns_sdate'],2,10)?>~
                        <?php echo substr($row['ns_edate'],2,10)?>
                      </td>
                      <td class="text-right"><?php echo number_format($main_supply)?>원</td>
                      <td class="text-right"><?php echo number_format($main_vat)?>원</td>
                      <td class="text-right" style="color:#cf3434">
                        <?php echo number_format($main_total)?>원
                      </td>
                      <td class="text-right"><?php echo $diff_txt?></td>
                      <td class="text-center"><?php echo $row['ns_num']?></td>
                      <td class="text-center"><?php echo $row['ns_btel']?></td>
                      <td class="text-center"><?php echo $row['ns_manager']?></td>
                      <td class="text-center"><?php echo $row['ns_manager_tel']?></td>
                    </tr>
                    <?php 
                    // (2) 추가 차수
                    $prev_sub_total = $main_total;

                    $sql2 = "SELECT * 
                               FROM {$none['subcontract_add']}
                              WHERE sb_id = '{$row['seq']}'
                           ORDER BY ns_num ASC";
                    $rst2 = sql_query($sql2);
                    while($row2=sql_fetch_array($rst2)) {
                        $this_supply = (int)$row2['ns_price'];
                        $this_vat    = (int)$row2['ns_vat'];
                        $this_total  = (int)$row2['ns_total_price'];

                        $diff_val = $this_total - $prev_sub_total; 
                        // ★ 각 차수의 증감을 모두 누적
                        // (ex. 1->2, 2->3, 3->4 전부)
                        $contract_diff_sum += $diff_val;

                        // 화면 표시용
                        if($diff_val>0) {
                            $sign  = '+';
                            $color = 'red';
                        } else if($diff_val<0) {
                            $sign  = '-';
                            $color = 'blue';
                        } else {
                            $sign  = '';
                            $color = 'black';
                        }
                        $abs_diff = abs($diff_val);
                        $diff_txt = $sign
                                    ? '<span style="color:'.$color.'">'
                                      .$sign.number_format($abs_diff)
                                      .'</span>'
                                    : '';

                        // 최신차수 금액 갱신(화면에 출력될 최종 금액)
                        $final_supply = $this_supply;
                        $final_vat    = $this_vat;
                        $final_total  = $this_total;

                        $prev_sub_total = $this_total;
                    ?>
                    <tr>
                      <td class="text-center">
                        <a href="../write/menu2_write.php?w=u&seq=<?php echo $row['seq']?>">
                          <?php echo $row['work_id']?>
                        </a>
                      </td>
                      <td class="text-center"><?php echo get_worksite_name($row['work_id'])?></td>
                      <td class="text-center"><?php echo $row2['ns_num']?>차</td>
                      <td class="text-center"><?php echo get_enterprise_txt($row['ns_bname'])?></td>
                      <td class="text-center"><?php echo $row['ns_gongjong']?></td>
                      <td class="text-center">
                        <?php echo substr($row2['ns_contract_date'],2,10)?>
                      </td>
                      <td class="text-center">
                        <?php echo substr($row2['ns_sdate'],2,10)?>~
                        <?php echo substr($row2['ns_edate'],2,10)?>
                      </td>
                      <td class="text-right">
                        <?php echo number_format($this_supply)?>원
                      </td>
                      <td class="text-right">
                        <?php echo number_format($this_vat)?>원
                      </td>
                      <td class="text-right" style="color:#cf3434">
                        <?php echo number_format($this_total)?>원
                      </td>
                      <td class="text-right"><?php echo $diff_txt?></td>
                      <td class="text-center"></td>
                      <td class="text-center"><?php echo $row['ns_btel']?></td>
                      <td class="text-center"><?php echo $row['ns_manager']?></td>
                      <td class="text-center"><?php echo $row['ns_manager_tel']?></td>
                    </tr>
                    <?php
                    } // while($row2)

                    // 이 계약(업체)의 “최신차수 금액” = $final_xxx
                    // 증감 합계 = $contract_diff_sum
                    // 소계에 반영
                    $site_supply += $final_supply;
                    $site_vat    += $final_vat;
                    $site_total  += $final_total;
                    $site_diff   += $contract_diff_sum; // 전체 차수 누적diff

                    $prev_work_id = $current_work_id;
                } // while($row)

                if($rowCount == 0) {
                ?>
                <tr>
                  <td colspan="15" class="text-center">
                    검색 된 데이터가 없습니다.
                  </td>
                </tr>
                <?php
                } else {
                    // 마지막 현장의 소계 출력
                    $siteDiffSign  = '';
                    $siteDiffColor = 'black';
                    if($site_diff>0) {
                        $siteDiffSign  = '+';
                        $siteDiffColor = 'red';
                    } else if($site_diff<0) {
                        $siteDiffSign  = '-';
                        $siteDiffColor = 'blue';
                    }
                    $abs_site_diff= abs($site_diff);
                    $siteDiffTxt  = $siteDiffSign
                                    ? '<span style="color:'.$siteDiffColor.'">'
                                      .$siteDiffSign.number_format($abs_site_diff)
                                      .'</span>'
                                    : '';
                    ?>
                    <tr style="background:#e9f6ff">
                      <td><?php echo $prev_work_id?></td>
                      <td colspan="2">소계</td>
                      <td colspan="2"></td>
                      <td colspan="2"></td>
                      <td class="text-right"><?php echo number_format($site_supply)?>원</td>
                      <td class="text-right"><?php echo number_format($site_vat)?>원</td>
                      <td class="text-right" style="color:#cf3434">
                        <?php echo number_format($site_total)?>원
                      </td>
                      <td class="text-right"><?php echo $siteDiffTxt?></td>
                      <td colspan="4"></td>
                    </tr>
                    <?php
                    // 전체 합계에 마지막 현장 소계 반영
                    $grand_supply += $site_supply;
                    $grand_vat    += $site_vat;
                    $grand_total  += $site_total;
                    $grand_diff   += $site_diff;
                }

                // 모든 현장 끝난 뒤 “합계(전체)”
                $grandSign  = '';
                $grandColor = 'black';
                if($grand_diff>0) {
                    $grandSign  = '+';
                    $grandColor = 'red';
                } else if($grand_diff<0) {
                    $grandSign  = '-';
                    $grandColor = 'blue';
                }
                $abs_gdiff = abs($grand_diff);
                $grandDiffTxt = $grandSign
                                ? '<span style="color:'.$grandColor.'">'
                                  .$grandSign.number_format($abs_gdiff)
                                  .'</span>'
                                : '';
                ?>
                <tr style="background:#f2f2f2">
                  <td>합계</td>
                  <td colspan="2"></td>
                  <td colspan="2"></td>
                  <td colspan="2"></td>
                  <td class="text-right" style="color:#cf3434">
                    <?php echo number_format($grand_supply)?>원
                  </td>
                  <td class="text-right" style="color:#cf3434">
                    <?php echo number_format($grand_vat)?>원
                  </td>
                  <td class="text-right" style="color:#cf3434">
                    <?php echo number_format($grand_total)?>원
                  </td>
                  <td class="text-right">
                    <?php echo $grandDiffTxt?>
                  </td>
                  <td colspan="4"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <?php 
        // 페이지네이션
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
    if(confirm('정말 삭제하시겠습니까?\n\n연동 된 정보가 있다면 모두 해제 됩니다.')) {
        location.href = '/_worksite/write/menu1_update.php?w=d&seq='+seq;
    }
}
</script>
<?php include_once(NONE_PATH.'/footer.php');?>
