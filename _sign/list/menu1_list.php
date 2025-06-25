<?php
include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php');


if($member['mb_2'] == 10 || $member['mb_level2'] == 2) {
        // 실행부 또는 현장소장일 경우
	$sql_common = " from  {$none['sign_draft']}  ";

        $sql1 = sql_query("select nw_code, pj_title_kr  from {$none['worksite']} where (nw_ptype1_1 = '{$member['mb_id']}' or nw_ptype1_2 = '{$member['mb_id']}' or nw_ptype1_3 = '{$member['mb_id']}' or nw_ptype2_1 = '{$member['mb_id']}' or nw_ptype2_1 = '{$member['mb_id']}' or nw_ptype2_1 = '{$member['mb_id']}') ");
        while($work1 = sql_fetch_array($sql1)) {
                $work1_arr[] = "ns_team = '".$work1['nw_code']." ".$work1['pj_title_kr']."'";
        }
        $sql_search = " where (".implode(' or ', $work1_arr).")";

} else {
	$sql_common = " from  {$none['sign_draft']}  ";
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

			//기안자도 검색
			$mb_check = sql_fetch("select mb_id from g5_member where mb_name LIKE '%$stx%'");

			if($mb_check)
				$sql_search .= " (ns_subject like '%$stx%' or ns_team like '%$stx%' or mb_id = '{$mb_check['mb_id']}') ";
			else
				$sql_search .= " (ns_subject like '%$stx%' or ns_team like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if($team && !$stx) {
	$sql_search .= " AND ns_team LIKE '$team%' ";

}

if(!$state && !$stx) {
	$sql_search .= " AND ( ns_state != '처리완료' and ns_state != '완료'  and ns_state != '반려'   )   ";
	//$sql_search .= " ";
} else if($state && $state != "all") {

	if($state == "완료" || $state == "전결") {
		$sql_search .= " AND ns_state = '$state' and ns_payment_date = '0000-00-00 00:00:00' ";
	} else if($state == "처리완료") {
		$sql_search .= " AND ns_payment_date != '0000-00-00 00:00:00' ";
	} else {
		$sql_search .= " AND ns_state = '$state'";
	}
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
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>전자결재</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
				<li class="breadcrumb-item">전체문서관리</li>
				<li class="breadcrumb-item active">기안서</li>
			</ul>
		</div>

	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">

                    <div class="card">
						<div class="body">
                            <a class="btn btn-primary float-right" href="../write/menu1_write.php" role="button">기안서 등록</a>
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
													<option value="<?php echo $work['nw_code']?>" <?php echo get_selected($work['nw_code'], $team)?>><?php echo $nw_code?></option>
													<?php }?>

												</optgroup>
												<optgroup label="완료현장">
												<?php
													$workSql2 = "select seq, nw_code, nw_subject, pj_title_kr  from {$none['worksite']} where nw_status  = '1' and nw_code != '210707' order by nw_code desc";
													$workRst2 = sql_query($workSql2);
													while($work2 = sql_fetch_array($workRst2)) {

														$nw_code2 = $work2['nw_code'].' '.$work2['pj_title_kr'];
													?>
													<option value="<?php echo $work2['nw_code']?>" <?php echo get_selected($work2['nw_code'], $team)?>><?php echo $nw_code2?></option>
													<?php }?>
												</optgroup>
										</select>

										<select name="status" id="inputState" class="form-control" onchange="location.href='?team=<?php echo $team?>&stx=<?php echo $stx?>&state='+this.value">
											<option value="">진행중 문서</option>
											<option value="all" <?php echo get_selected($state, 'all')?>>전체보기</option>
											<option value="미처리" <?php echo get_selected($state, '미처리')?>>미처리</option>
											<option value="완료" <?php echo get_selected($state, '완료')?>>결재완료</option>
											<option value="전결" <?php echo get_selected($state, '전결')?>>전결</option>
											<option value="처리완료" <?php echo get_selected($state, '처리완료')?>>처리완료</option>
											<option value="반려" <?php echo get_selected($state, '반려')?>>반려</option>

										</select>
									<input type="text" name="stx" value="<?php echo $stx?>" class="form-control" placeholder="전체검색"  >
									<div class="input-group-append">
										<span class="input-group-text" id="search-mail"><i class="icon-magnifier"></i></span>
									</div>
								</div>
							</form>
                        </div>

                        <div class="body project_report">

                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover mobile-card">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>번호</th>
                                            <th>기안일자</th>
                                            <th>기안부서 및 현장</th>
                                            <th>문서명</th>
                                            <th>공종</th>
                                            <th>도급금액</th>
                                            <th>외주비</th>
                                            <th>자재비</th>
                                            <th>중요도</th>
                                            <th>기안자</th>
                                            <th>완료일</th>
                                            <th>결재현황</th>
                                            <th>처리상태</th>
                                        </tr>
                                    </thead>
                                    <tbody>


										<?php for($i=0; $row=sql_fetch_array($result); $i++) {

											$num = $total_count - ($page - 1) * $rows - $i;

											$cmmt = sql_fetch("select count(*) as cnt from {$none['sign_draft_comment']} where ns_type = 1 and ns_id = '{$row['seq']}'");

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

											if($row['ns_state'] == "진행중" || $row['ns_state'] == "전결") {
												$state = "진행중";
												$data = explode('|', $row['ns_id'.$row['ns_sign_cnt'].'_stat']);

												$sDate = date('y-m-d', strtotime($data[1]));

												//공무부, 연구부일경우 처리완료 처리 가능
												if($member['mb_2'] == 2 || $member['mb_2'] == 4) {

													$state = "<strong style=\"color:red;cursor:pointer\" onclick=\"payment(".$row['seq'].")\">진행중</strong><br><small>".$data[1]."</small>";
												} else {
													$state = "<strong style=\"color:red\">진행중</strong><br><small>".$data[1]."</small>";
												}
												$nextID = $row['ns_id'.$row['ns_sign_cnt']];

											}

											if($row['ns_state'] == "완료" && $row['ns_payment_date'] != '0000-00-00 00:00:00') {

												$state = "처리완료";
												$state = "<strong style=\"color:red\">처리완료</strong><br><small>".$row['ns_payment_date']."</small>";
												$nextID = $row['ns_id'.$row['ns_sign_cnt']];
											}


										?>
										<tr>
											<td  class="text-center"><?php echo $num;?>

											</td>
											<td><?php echo $row['ns_date']?></td>
											<td><?php echo $row['ns_team']?></td>
											<td style="width:400px"><a href="../view/menu1_view.php?w=u&seq=<?php echo $row['seq']?>"><?php echo $row['ns_subject']?> (<?php echo $cmmt['cnt']?>)</a></td>
											<td><?php echo $row['ns_gongjung']?></td>
											<td class="text-right"><?php echo number_format($row['ns_price'])?></td>
											<td class="text-right"><?php echo number_format($row['ns_price2'])?></td>
											<td class="text-right"><?php echo number_format($row['ns_price3'])?></td>
											<td class="text-center"><?php echo $row['ns_importance']?></td>
											<td class="text-center"><?php echo $mb['mb_name']?> <?php echo get_mposition_txt($mb['mb_3'])?></td>
											<td class="text-center"><?php echo $sDate?></td>
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
function payment(seq) {

	if(confirm('처리완료 하시겠습니까?')) {
		location.href = '../write/state1_list_update.php?seq='+seq;
	} else {
		return false;
	}

}


</script>
<script>
$(function(){
    $('.mobile-card').each(function(){
        var headers=[];
        $(this).find('thead th').each(function(){headers.push($(this).text().trim());});
        $(this).find('tbody tr').each(function(){
            $(this).find('td').each(function(i){
                $(this).attr('data-label', headers[i]);
            });
        });
    });

    if (window.innerWidth <= 768) {
        $('.mobile-card tbody tr').each(function(){
            var $tds = $(this).find('td');
            var num  = $tds.eq(0).text().trim();
            var team = $tds.eq(2).text().trim();
            var header = $('<div class="mobile-card-header d-flex justify-content-between mb-2 font-weight-bold"></div>');
            header.append($('<span class="mc-num"></span>').text(num));
            header.append($('<span class="mc-team text-right"></span>').text(team));
            $(this).prepend(header);
            $tds.eq(0).hide();
            $tds.eq(2).hide();
        });
    }
});
</script>
<style>
@media (max-width: 768px) {
    .mobile-card thead {
        display: none;
    }
    .mobile-card tbody tr {
        display: block;
        border: 1px solid #ddd;
        border-radius: 8px; /* Slightly more rounded corners */
        margin-bottom: 1rem;
        padding: 1rem; /* More padding for better spacing */
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Subtle shadow for depth */
    }
    .mobile-card tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center; /* Vertically align items */
        padding: 0.5rem 0; /* Increased vertical padding */
        border-bottom: 1px solid #eee; /* Light separator between fields */
    }
    .mobile-card tbody td:last-child {
        border-bottom: none; /* No border for the last item */
    }
    .mobile-card tbody td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #555; /* Slightly darker label color */
        flex-shrink: 0; /* Prevent label from shrinking */
        margin-right: 1rem; /* Space between label and value */
    }
    .mobile-card-header {
        display:flex;
        justify-content: space-between;
        font-size: 1rem;
        padding-bottom: .5rem;
        border-bottom: 1px solid #eee;
        margin-bottom: .5rem;
    }
    /* Specific styling for important fields */
    .mobile-card tbody td:nth-child(4) { /* 문서명 (Document Title) */
        font-size: 1.1em;
        font-weight: bold;
        color: #007bff; /* Highlight document title */
    }
    .mobile-card tbody td:nth-child(12), /* 결재현황 (Approval Status) */
    .mobile-card tbody td:nth-child(13) { /* 처리상태 (Processing Status) */
        font-weight: bold;
        color: #dc3545; /* Red for status indicators */
    }
}
</style>

<?php include_once(NONE_PATH.'/footer.php');?>