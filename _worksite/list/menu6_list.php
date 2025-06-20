<?php 
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php'); 

$sql_common = " from  {$none['home_board']} a LEFT JOIN {$none['worksite']} b ON a.wr_1 = b.nw_code ";
$sql_search = " where  a.bo_table = 'board7' ";

//23.07.14 현장소장 권한일경우 본인 현장 나오도록 
if($member['mb_level2'] == 2) {
        $sql_search .= " and (
            nw_ptype1_1 = '{$member['mb_id']}' or
            nw_ptype1_2 = '{$member['mb_id']}' or
            nw_ptype1_3 = '{$member['mb_id']}' or
            nw_ptype1_4 = '{$member['mb_id']}' or
            nw_ptype1_5 = '{$member['mb_id']}' or
            nw_ptype1_6 = '{$member['mb_id']}' or
            nw_ptype2_1 = '{$member['mb_id']}' or
            nw_ptype2_2 = '{$member['mb_id']}' or
            nw_ptype2_3 = '{$member['mb_id']}' or
            nw_ptype2_4 = '{$member['mb_id']}' or
            nw_ptype2_5 = '{$member['mb_id']}' or
            nw_ptype2_6 = '{$member['mb_id']}'
        ) ";

}

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
    $sst  = "a.seq";
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

$sql = " select a.*, b.nw_subject, b.seq as code {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

?>
<!--시공현장 리스트-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>건축주협의게시판</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">현장관리</li>
				<li class="breadcrumb-item active">건축주협의게시판</li>
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
                                            <th>접수일</th>
                                            <th>현장명</th>
                                            <th>카테고리</th>
                                            <th style="width:40%">제목</th>
                                            <th>작성자</th>
                                            <th class="text-center">답변여부</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i=0; $row=sql_fetch_array($result); $i++) {
											
											
											$info = sql_fetch("select * from  {$none['worksite']} where nw_code = '{$row['wr_1']}'");
											
											
											if($row['wr_answer']) {
												$status = '<span class="badge badge-warning">답변완료</span>';
												
											} else {
												$status = '<span class="badge badge-light">답변대기</span>';
											}
										
										?>
										<tr>
											<td><?php echo date('Y-m-d', strtotime($row['wr_datetime']))?></td>
											<td><a href="/_worksite/write/menu1_write.php?w=u&seq=<?php echo $row['code']?>" target="_blank" ><?php echo $row['nw_code']?> <?php echo $row['nw_subject']?></a></td>
											<td><?php echo $row['ca_name']?></td>
											<td>
											<a href="/_worksite/write/menu6_write.php?w=u&seq=<?php echo $row['seq']?>"><?php echo $row['wr_subject']?></a>
											
											</td>
											<td><?php echo $row['wr_name']?></td>
										
											<td class="text-center"><?php echo $status?></td>
										
											
											
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