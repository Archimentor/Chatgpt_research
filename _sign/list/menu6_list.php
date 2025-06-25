<?php
include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php');

if($member['mb_2'] == 10 || $member['mb_level2'] == 2) {
        // 실행부 또는 현장소장일경우
	$sql_common = " from  {$none['sign_draft6']}  ";

	$sql1 = sql_query("select nw_code, pj_title_kr  from {$none['worksite']} where (nw_ptype1_1 = '{$member['mb_id']}' or nw_ptype1_2 = '{$member['mb_id']}' or nw_ptype1_3 = '{$member['mb_id']}' or nw_ptype2_1 = '{$member['mb_id']}' or nw_ptype2_1 = '{$member['mb_id']}' or nw_ptype2_1 = '{$member['mb_id']}') ");
        while($work1 = sql_fetch_array($sql1)) {
                $work1_arr[] = "ns_team = '".$work1['nw_code']." ".$work1['pj_title_kr']."'";
        }
        $sql_search = " where (".implode(' or ', $work1_arr).")";

} else {
	$sql_common = " from  {$none['sign_draft6']}  ";
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

	if($state == "완료") {
		$sql_search .= " AND ns_state2 = '처리완료' ";
	} else {
		$sql_search .= " AND ns_state = '$state' ";
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
				<li class="breadcrumb-item active">사고경위서</li>
			</ul>
		</div>

	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">

                    <div class="card">
						<div class="body">
                            <a class="btn btn-primary float-right" href="../write/menu6_write.php" role="button">사고경위서 등록</a>
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
                                <!-- PC 버전 테이블: id="desktop-table"로 식별 -->
                                <table class="table m-b-0 table-hover" id="desktop-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>번호</th>
                                            <th>기안일자</th>
                                            <th>기안부서 및 현장</th>
                                            <th>문서명</th>
                                            <th>기안자</th>
                                            <th>결재현황</th>
                                            <th>처리상태</th>
                                            <th>진행상태</th>
                                        </tr>
                                    </thead>
                                    <tbody>


										<?php for($i=0; $row=sql_fetch_array($result); $i++) {

											$num = $total_count - ($page - 1) * $rows - $i;

											$cmmt = sql_fetch("select count(*) as cnt from {$none['sign_draft_comment']} where ns_type = 6 and ns_id = '{$row['seq']}'");

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


											if($row['ns_state'] != "미처리") {
												$sDate = date('y-m-d', strtotime($data[1]));

												if($row['ns_state'] == "완료") {
													$state2 = $row['ns_state2'];
													$state2 .= "<br><small>".$row['ns_state2_date']."</small>";
												} else {
													$state2 = "접수완료";
												}
											} else {
												$sDate = "";
												$state2 = "접수완료";
											}
										?>
										<tr>
											<td><?php echo $num;?></td>
											<td><?php echo $row['ns_date']?></td>
											<td><?php echo $row['ns_team']?></td>
											<td style="width:400px"><a href="../write/menu6_write.php?w=u&seq=<?php echo $row['seq']?>"><?php echo $row['ns_subject']?> (<?php echo $cmmt['cnt']?>)</a></td>
											<td class="text-center"><?php echo $mb['mb_name']?> <?php echo get_mposition_txt($mb['mb_3'])?></td>
											<td class="text-center"><?php echo $next_mb['mb_name']?> <?php echo get_mposition_txt($next_mb['mb_3'])?>

											<?php if($row['ns_state'] != "미처리") {?>
											<br><strong style="color:red"><?php echo $row['ns_state']?>문서</strong>
											<?php }?>

											</td>


											<td class="text-center"><?php echo $state?></td>
											<td class="text-center"><?php echo $state2?></td>
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
<style>
/* Default styles for desktop/larger screens */
/* PC 버전의 표 스타일은 변경하지 않습니다. */
#desktop-table { /* Target the desktop table specifically by its ID */
    table-layout: auto; /* Allow browser to determine column widths based on content */
    width: 100%;
}
#desktop-table th, #desktop-table td {
    vertical-align: middle;
    padding: .6rem .5rem;
}
#desktop-table th {
    text-align: center;
}

/* Explicit alignment for PC table cells based on typical data types */
#desktop-table td { /* General alignment for all cells, will be overridden by specific column rules below */
    text-align: left; /* Default text alignment */
}
#desktop-table td:nth-child(1), /* 번호 (Number) */
#desktop-table td:nth-child(2), /* 기안일자 (Drafting Date) */
#desktop-table td:nth-child(5), /* 기안자 (Drafter) */
#desktop-table td:nth-child(6), /* 결재현황 (Approval Status) */
#desktop-table td:nth-child(7), /* 처리상태 (Processing Status) */
#desktop-table td:nth-child(8) { /* 진행상태 (Progress Status) */
    text-align: center; /* Center align for numbers, dates, and statuses */
}
/* No specific width defined for th, allowing auto sizing as per original behavior. */
/* The inline style 'width:400px' on the 문서명 (Document Title) td will control its width. */


/* Desktop specific table-layout and min-width for subject */
@media (min-width:992px){
    #desktop-table .td-subject { min-width:240px; } /* Min-width for subject on larger screens */
}
@media (max-width:991.98px) and (min-width:769px) { /* Tablet range, still desktop-like table view */
    #desktop-table { table-layout:auto; } /* Auto layout for tablets for better content fitting */
    #desktop-table .td-subject { min-width:160px; } /* Smaller min-width for tablets */
}

/* === Consolidated Mobile Card Styles (< 769px) === */
@media (max-width: 768px) {
    .mobile-card { /* This class is added by JS for mobile view */
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden; /* Ensure no horizontal scrolling */
    }
    .mobile-card thead {
        display: none; /* Hide table header on mobile */
    }
    .mobile-card tbody tr {
        display: flex; /* Make table rows behave as blocks for card layout */
        flex-direction: column; /* Stack items vertically */
        border: 1px solid #dee2e6; /* Card border */
        border-radius: 8px;
        margin-bottom: 1rem;
        padding: 1rem; /* Internal padding for the card */
        box-shadow: 0 2px 4px rgba(0,0,0,.08); /* Subtle shadow */
        overflow: hidden; /* Hide any overflow within the card */
        width: 100%; /* Ensure each card takes full width */
        box-sizing: border-box; /* Include padding/border in width calculation */
    }

    /* Target all direct children of tbody tr (divs and visible tds) for common styling */
    .mobile-card tbody tr > *:not(:last-child) { /* Apply border to all except the very last child */
        border-bottom: 1px solid #f1f1f1;
    }
    .mobile-card tbody tr > * { /* Common padding and font for all card items */
        padding: .5rem .75rem;
        word-break: break-word;
        font-size: 0.82rem;
        line-height: 1.3;
        box-sizing: border-box;
    }

    /* Mobile Card Header for [번호 + 공사명] */
    .mobile-card-header {
        display: block; /* Original block behavior */
        text-align: left;
        font-size: 1rem; /* Larger font size for the header */
        padding-bottom: .5rem; /* Keep this for spacing below header */
        margin-bottom: .5rem; /* Keep this margin below header */
        font-weight: bold;
    }

    /* 문서명 (Document Title) - Specific styling */
    .mobile-card-subject {
        display: block; /* Make it a block element to center text */
        width: 100%;
        text-align: center;
        font-weight: bold;
        color: #007bff;
    }
    .mobile-card-subject::before {
        content: none; /* Hide label for document name */
    }

    /* Styles for original <td> elements now handled by new divs */
    .mobile-card tbody td {
        display: none !important; /* Hide all original td elements */
    }

    /* Common style for new div items (기안일자, 기안자, 결재현황, 처리상태, 진행상태) */
    .mobile-card-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .5rem .75rem;
        word-break: break-word;
        font-size: 0.82rem;
        line-height: 1.3;
        box-sizing: border-box;
    }
    .mobile-card-item::before {
        content: attr(data-label);
        font-weight: bold;
        color: #555;
        flex-shrink: 0;
        margin-right: 1rem;
    }

    /* Ensure 결재현황 and 처리상태 are bold and red, with labels */
    .mobile-card-item[data-label="결재현황"],
    .mobile-card-item[data-label="처리상태"],
    .mobile-card-item[data-label="진행상태"] {
        font-weight: bold;
        color: #dc3545;
    }
}
</style>
<script>
$(function(){
    // This script applies data-label attributes to all td elements on page load, for both desktop and mobile.
    // This is necessary because the mobile card transformation relies on these data-labels.
    $('#desktop-table').each(function(){
        var headers=[];
        $(this).find('thead th').each(function(){headers.push($(this).text().trim());});
        $(this).find('tbody tr').each(function(){
            $(this).find('td').each(function(i){
                $(this).attr('data-label', headers[i]);
            });
        });
    });

    // Function to apply mobile card layout
    function applyMobileCardLayout() {
        var $table = $('#desktop-table');
        // Check if screen is mobile size AND mobile-card class is not already applied
        if (window.innerWidth <= 768 && !$table.hasClass('mobile-card')) {
            $table.addClass('mobile-card'); // Add mobile-card class to trigger mobile styles
            // Perform DOM manipulation for mobile layout
            $table.find('tbody tr').each(function(){
                var $tr = $(this);
                var $tds = $tr.find('td');

                var num = $tds.eq(0).text().trim(); // 번호
                var team = $tds.eq(2).text().trim(); // 기안부서 및 현장 (공사명)
                var subjectHtml = $tds.eq(3).html(); // 문서명 content

                // Construct the header text in the format "[번호] 기안부서 및 현장"
                var headerText = "[" + num + "] " + team;

                // 1. Create and prepend the header
                $('<div class="mobile-card-header"/>').text(headerText).prependTo($tr);

                // 2. Create and append the 문서명 div (최상단)
                $('<div class="mobile-card-item mobile-card-subject" data-label="문서명">' + subjectHtml + '</div>').appendTo($tr);

                // 3. Loop through remaining original <td> elements and append them as new labeled divs
                // Columns to process for menu6_list.php:
                // 기안일자 (idx 1), 기안자 (idx 4), 결재현황 (idx 5), 처리상태 (idx 6), 진행상태 (idx 7)
                var columnsToMove = [1, 4, 5, 6, 7]; // All relevant original td indices

                $.each(columnsToMove, function(index, i) {
                    var $originalTd = $tds.eq(i);
                    var label = $originalTd.attr('data-label');
                    var content = $originalTd.html();

                    if (label && content.trim() !== '') {
                        $('<div class="mobile-card-item" data-label="' + label + '">' + content + '</div>').appendTo($tr);
                    }
                });

                // 4. Hide all original <td> elements after their content has been moved.
                $tds.hide();
            });
        }
    }

    // Function to revert to desktop table layout
    function revertToDesktopLayout() {
        var $table = $('#desktop-table');
        // Check if screen is desktop size AND mobile-card class is currently applied
        if (window.innerWidth > 768 && $table.hasClass('mobile-card')) {
            $table.removeClass('mobile-card'); // Remove mobile-card class
            // Revert DOM manipulation for desktop layout
            $table.find('tbody tr').each(function(){
                $(this).find('.mobile-card-header').remove(); // Remove added header
                $(this).find('.mobile-card-item').remove(); // Remove all added mobile items
                $(this).find('td').show(); // Show all original td elements
            });
        }
    }

    // Initial check on page load
    applyMobileCardLayout();
    revertToDesktopLayout(); // Call both to ensure correct state initially based on current window size

    // Listen for window resize events
    $(window).on('resize', function() {
        applyMobileCardLayout();
        revertToDesktopLayout();
    });
});
</script>
<?php include_once(NONE_PATH.'/footer.php');?>
