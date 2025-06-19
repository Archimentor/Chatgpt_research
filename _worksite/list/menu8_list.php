<?php 
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php'); 

$sql_common = " from  {$none['repair_list2']}  ";
$sql_search = " where (1) ";


if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " (nw_subject like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "nw_code desc, seq";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

?>
<!--시공현장 리스트-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>하자보증서 발급현황</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">현장관리</li>
				<li class="breadcrumb-item active">하자보증서 발급현황</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<div class="body">
                           <a class="btn btn-primary float-right" href="../write/menu8_write.php" role="button">하자보증서 등록</a> 
							<form class="float-right" style="margin-right:5px">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="검색"  >
									<div class="input-group-append">
										<span class="input-group-text" id="search-mail"><i class="icon-magnifier"></i></span>
									</div>
								</div>
							</form>
                        </div>	
						
					
						
                        <div class="body project_report">
							
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>현장명</th>
											<th>업체명</th>
                                            <th>보증기간</th>
                                            <th>보증번호</th>
                                            <th>계약금액</th>
                                            <th>보증금액</th>
                                            <th>공종명</th>
                                            <th>발급기관</th>
                                            <th>다운로드</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i=0; $row=sql_fetch_array($result); $i++) {
											
											if($row['nr_file']) {
												$download = '<a href="../write/menu8_update.php?w=f&seq='.$row['seq'].'"><span class="glyphicon fa fa-download"></span></a>';
											} else {
												$download = "";
											}
										?>
										<tr>
											<td><a href="/_worksite/write/menu8_write.php?w=u&seq=<?php echo $row['seq']?>" ><?php echo $row['nw_code']?> <?php echo $row['nw_code_txt']?></a></td>
											<td><?php echo $row['nr_bname']?></td>
											<td><?php echo substr($row['nr_sdate'], 2,10)?> ~ <?php echo  substr($row['nr_edate'], 2,10)?></td>
											<td><?php echo $row['nr_num']?></td>
											<td class="text-right"><?php echo number_format($row['nr_price_contract'])?></td>
											<td class="text-right"><?php echo number_format($row['nr_price'])?> (<?php echo $row['nr_price_per']?>%)</td>
											<td><?php echo $row['nr_gongjong']?></td>
											<td><?php echo $row['nr_company']?></td>
											
											<td class="text-center"><?php echo $download?></td>
										
											
											
										</tr>
										<?php } ?>
										
										<?php if($i == 0) {?> 
										<tr>
											<td colspan="11" class="align-center">검색 된 데이터가 없습니다.</td> 
										</tr>
										<?php }?>
										
									</tbody>
									</table>
							</div>
                        </div>
						<?php echo get_paging_none(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
                    </div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>


<?php include_once(NONE_PATH.'/footer.php');?>