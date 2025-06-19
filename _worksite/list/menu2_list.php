<?php 
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php'); 

$sql_common = " from  {$none['worksite']}  ";
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
    $sst  = "nw_code";
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
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>시공현장 관리(관리부)</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">현장관리</li>
				<li class="breadcrumb-item active">시공현장 관리(관리부)</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<div class="body">
                           
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
                                            <th>공사번호</th>
                                            <th>발주자명</th>
                                            <th>공사명</th>
                                            <th>공사기간</th>
                                            <th>계약금액(VAT별도)</th>
                                            <th>고용산재 사업개시번호</th>
                                            <th>건강연금 사업장관리번호</th>
                                            <th>건강보험 아이디</th>
                                            <th>건강연금 공사기간</th>
                                            <th>비고</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i=0; $row=sql_fetch_array($result); $i++) {
											
											if($row['nw_status'])
												$status = '<span class="badge badge-success">완 료</span>';
											else
												$status = '<span class="badge badge-warning">진행중</span>';
											
											if($row['nw_main_open'])
												$open = '<span class="badge badge-success">노출 중</span>';
											else
												$open = '';
										?>
										<tr>
											<td><a href="/_worksite/write/menu1_write.php?w=u&seq=<?php echo $row['seq']?>"><?php echo $row['nw_code']?></a></td>
											<td><?php echo get_owner_txt($row['nw_ptype3_1'])?></td>
											<td><?php echo $row['nw_subject']?></td>
											<td><?php echo substr($row['nw_sdate'], 2, 10)?>~<?php echo substr($row['nw_edate'], 2, 10)?></td>
											<td style="color:#cf3434"><?php echo number_format($row['nw_price1'])?>원</td>
											<td><?php echo $row['nw_insurance_num1']?></td>
											<td><?php echo $row['nw_insurance_num2']?></td>
											<td><?php echo $row['nw_insurance_id']?></td>
											<td><?php echo substr($row['nw_insurance_sdate'], 2, 10)?>~<?php echo substr($row['nw_insurance_edate'], 2, 10)?></td>
											<td><?php echo $row['nw_insurance_etc']?></td>
											
											
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