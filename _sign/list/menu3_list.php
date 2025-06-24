<?php 
include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php'); 

if($member['mb_2'] == 10 || $member['mb_level2'] == 2) {
        // 실행부 또는 현장소장일경우
	$sql_common = " from  {$none['sign_draft3']}  ";
	
	$sql1 = sql_query("select nw_code, pj_title_kr  from {$none['worksite']} where (nw_ptype1_1 = '{$member['mb_id']}' or nw_ptype1_2 = '{$member['mb_id']}' or nw_ptype1_3 = '{$member['mb_id']}' or nw_ptype2_1 = '{$member['mb_id']}' or nw_ptype2_1 = '{$member['mb_id']}' or nw_ptype2_1 = '{$member['mb_id']}') ");
	while($work1 = sql_fetch_array($sql1)) {
		$work1_arr[] = "ns_team = '".$work1['nw_code']." ".$work1['pj_title_kr']."'";
	}
	$sql_search = " where ".implode(' or ', $work1_arr);
	
} else {
	$sql_common = " from  {$none['sign_draft3']}  ";
	$sql_search = " where (1) ";
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

if($team) {
	$sql_search .= " AND ns_team = '$team' ";
	
}

if(!$state) $state = "미처리";

if($state && $state != "all") {
	$sql_search .= " AND ns_state = '$state' ";
} 

if (!$sst) {
    $sst  = "seq";
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



$qstr .= "&amp;team=$team&amp;state=$state"
?>
<!--시공현장 리스트-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>전자결재</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">전체문서관리</li>
				<li class="breadcrumb-item active">설계변경</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<div class="body">
                            <a class="btn btn-primary float-right" href="../write/menu3_write.php" role="button">설계변경 등록</a> 
							<form class="float-right" style="margin-right:5px">
								<div class="input-group">
									<select name="status" id="inputState" class="form-control" onchange="location.href='?state=<?php echo $state?>&team='+this.value">
											<option value="">기안부서 및 현장 선택</option>
												<optgroup label="부서">
													<?php echo get_department_select2($team)?>
												</optgroup>
												<optgroup label="진행현장">
													<?php 
													$workSql = "select seq, nw_code, nw_subject, pj_title_kr  from {$none['worksite']} where nw_status  = '0' and nw_code != '210707' order by nw_code desc";
													$workRst = sql_query($workSql);
													while($work = sql_fetch_array($workRst)) {
														
														$nw_code = $work['nw_code'].' '.$work['pj_title_kr'];
													?>
													<option value="<?php echo $nw_code?>" <?php echo get_selected($nw_code, $team)?>><?php echo $nw_code?></option>
													<?php }?>
													
												</optgroup>
												<optgroup label="완료현장">
												<?php 
													$workSql2 = "select seq, nw_code, nw_subject, pj_title_kr  from {$none['worksite']} where nw_status  = '1' and nw_code != '210707' order by nw_code desc";
													$workRst2 = sql_query($workSql2);
													while($work2 = sql_fetch_array($workRst2)) {
														
														$nw_code2 = $work2['nw_code'].' '.$work2['pj_title_kr'];
													?>
													<option value="<?php echo $nw_code2?>" <?php echo get_selected($nw_code2, $team)?>><?php echo $nw_code2?></option>
													<?php }?>
												</optgroup>
										</select>
										
										<select name="status" id="inputState" class="form-control" onchange="location.href='?team=<?php echo $team?>&state='+this.value">
											<option value="all" <?php echo get_selected($state, 'all')?>>전체보기</option>
											<option value="미처리" <?php echo get_selected($state, '미처리')?>>미처리</option>
											<option value="완료" <?php echo get_selected($state, '완료')?>>완료</option>
											<option value="전결" <?php echo get_selected($state, '전결')?>>전결</option>
											<option value="반려" <?php echo get_selected($state, '반려')?>>반려</option>
										
										</select>
									<input type="text" name="stx" value="<?php echo $stx?>" class="form-control" placeholder="문서명 검색"  >
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
                                            <th>번호</th>
                                            <th>기안일자</th>
                                            <th>기안부서 및 현장</th>
                                            <th>문서명</th>
                                            <th>업체명</th>
                                            <th>당초금액</th>
                                            <th>변경금액</th>
                                            <th>증감금액</th>
                                            
                                            <th>중요도</th>
                                            <th>기안자</th>
                                            <th>결재현황</th>
                                            <th>처리상태</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
									
										<?php for($i=0; $row=sql_fetch_array($result); $i++) {
											
											$num = $total_count - ($page - 1) * $rows - $i;
											
											$cmmt = sql_fetch("select count(*) as cnt from {$none['sign_draft_comment']} where ns_type = 3 and ns_id = '{$row['seq']}'");
											
											$mb = get_member($row['mb_id'], 'mb_name, mb_3');
											$state = "미처리";
											
											if(!$row['ns_id1_stat']) {
												
												$nextID = $row['ns_id1'];
												
											} 
											
											if($row['ns_id1_stat']) {
												$nextID = $row['ns_id2'];
											}
											if($row['ns_id2_stat']) {
												$nextID = $row['ns_id3'];
											}
											if($row['ns_id3_stat']) {
												$nextID = $row['ns_id4'];
											}
											if($row['ns_id4_stat']) {
												$nextID = $row['ns_id5'];
											}
											
											
											$next_mb = get_member($nextID, 'mb_name, mb_3');
											
											if(strpos($row['ns_id0_stat'],'전결') !== false){ 
												
												$nextID = $row['mb_id'];
												$data = explode('|', $row['ns_id0_stat']);
												$state = "<strong style=\"color:red\">처리완료</strong><br><small>".$data[1]."</small>";
												$sDate = date('y-m-d', strtotime($data[1]));
											}
											if(strpos($row['ns_id1_stat'],'전결') !== false){ 
												
												$nextID = $row['ns_id1'];
												$data = explode('|', $row['ns_id1_stat']);
												$state = "<strong style=\"color:red\">처리완료</strong><br><small>".$data[1]."</small>";
												$sDate = date('y-m-d', strtotime($data[1]));
											}
											
											if(strpos($row['ns_id2_stat'],'전결') !== false){ 
												$nextID = $row['ns_id2'];
												$data = explode('|', $row['ns_id2_stat']);
												$state = "<strong style=\"color:red\">처리완료</strong><br><small>".$data[1]."</small>";
												$sDate = date('y-m-d', strtotime($data[1]));
											}
											
											if(strpos($row['ns_id3_stat'],'전결') !== false){ 
												$nextID = $row['ns_id3'];
												$data = explode('|', $row['ns_id3_stat']);
												$state = "<strong style=\"color:red\">처리완료</strong><br><small>".$data[1]."</small>";
												$sDate = date('y-m-d', strtotime($data[1]));
											}
											
											if(strpos($row['ns_id4_stat'],'전결') !== false){ 
												$nextID = $row['ns_id4'];
												$data = explode('|', $row['ns_id4_stat']);
												$state = "<strong style=\"color:red\">처리완료</strong><br><small>".$data[1]."</small>";
												$sDate = date('y-m-d', strtotime($data[1]));
											}
											
											if(strpos($row['ns_id5_stat'],'전결') !== false){ 
												$nextID = $row['ns_id5'];
												$data = explode('|', $row['ns_id5_stat']);
												$state = "<strong style=\"color:red\">처리완료</strong><br><small>".$data[1]."</small>";
												$sDate = date('y-m-d', strtotime($data[1]));
											}
											
											$next_mb = get_member($nextID, 'mb_name, mb_3');
											
											
											if(strpos($row['ns_id0_stat'],'반려') !== false){ 
												
												$nextID = $row['mb_id'];
												$data = explode('|', $row['ns_id0_stat']);
												$state = "<strong style=\"color:red\">반려</strong><br><small>".$data[1]."</small>";
											}
											
											if(strpos($row['ns_id1_stat'],'반려') !== false){ 
												
												$nextID = $row['ns_id1'];
												$data = explode('|', $row['ns_id1_stat']);
												$state = "<strong style=\"color:red\">반려</strong><br><small>".$data[1]."</small>";
											}
											
											if(strpos($row['ns_id2_stat'],'반려') !== false){ 
												$nextID = $row['ns_id2'];
												$data = explode('|', $row['ns_id2_stat']);
												$state = "<strong style=\"color:red\">반려</strong><br><small>".$data[1]."</small>";
											}
											
											if(strpos($row['ns_id3_stat'],'반려') !== false){ 
												$nextID = $row['ns_id3'];
												$data = explode('|', $row['ns_id3_stat']);
												$state = "<strong style=\"color:red\">반려</strong><br><small>".$data[1]."</small>";
											}
											
											if(strpos($row['ns_id4_stat'],'반려') !== false){ 
												$nextID = $row['ns_id4'];
												$data = explode('|', $row['ns_id4_stat']);
												$state = "<strong style=\"color:red\">반려</strong><br><small>".$data[1]."</small>";
											}
											
											if(strpos($row['ns_id5_stat'],'반려') !== false){ 
												$nextID = $row['ns_id5'];
												$data = explode('|', $row['ns_id5_stat']);
												$state = "<strong style=\"color:red\">반려</strong><br><small>".$data[1]."</small>";
												
											}
											
											$next_mb = get_member($nextID, 'mb_name, mb_3');
											
											
											if($row['ns_state'] != "미처리") {
												$sDate = date('y-m-d', strtotime($data[1]));
											} else {
												$sDate = "";
											}
											
											$ns_price_info = explode('^', $row['ns_price_info']);
										?>
										<tr>
											<td><?php echo $num;?></td>
											<td><?php echo $row['ns_date']?></td>
											<td><?php echo $row['ns_team']?></td>
											<td style="width:400px"><a href="../view/menu3_view.php?w=u&seq=<?php echo $row['seq']?>"><?php echo $row['ns_subject']?> (<?php echo $cmmt['cnt']?>)</a></td>
											<td><?php echo $row['ns_gongjung']?></td>
											<td class="text-right"><?php echo number_format($ns_price_info[4])?></td>
											<td class="text-right"><?php echo number_format($ns_price_info[5])?></td>
											<td class="text-right"><?php echo number_format($ns_price_info[6])?></td>
											<td><?php echo $row['ns_importance']?></td>
											
											<td class="text-center"><?php echo $mb['mb_name']?> <?php echo get_mposition_txt($mb['mb_3'])?></td>
											<td class="text-center"><?php echo $next_mb['mb_name']?> <?php echo get_mposition_txt($next_mb['mb_3'])?>
											
											<?php if($row['ns_state'] != "미처리") {?>
											<br><strong style="color:red"><?php echo $row['ns_state']?>문서</strong>
											<?php }?>
											
											</td>
											<td class="text-center"><?php echo $state?></td>
										</tr>
										<?php 
										
										
										} ?>
										
										<?php if($i == 0) {?> 
										<tr>
											<td colspan="12" class="align-center">검색 된 데이터가 없습니다.</td> 
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
<script>
function del_(seq) {
	
	if(confirm('정말 시공현황 정보를 삭제하시겠습니까?\n\n연동 된 정보가 있다면 모두 해제 됩니다.')) {
		location.href = '/_worksite/write/menu1_update.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
</script>

<?php include_once(NONE_PATH.'/footer.php');?>