<?php
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php');

if(!$_GET['date'])
	$date = date('Y-m-d');
else if($_GET['date'] == 'all')
    $date = '2021-07-07';		// 홈페이지 제작일부터 현재까지 계산
else
	$date = $_GET['date'];



$preDate = date('Y-m-d', strtotime($date." -1 Day"));
$nxtDate = date('Y-m-d', strtotime($date." +1 Day"));


$sql_common = " from  {$none['smart_list']} a left join {$none['worksite']} b ON a.work_id = b.nw_code  ";


if($date == '2021-07-07') {
    $start_date = $date;
    $end_date = date('Y-m-d');
}
else {
    $start_date = $date;
    $end_date = $date;
}

$sql_search = " where (1) and ns_date >= '$start_date' and ns_date <= '$end_date'";

if($date == '2021-07-07') {
    $sst = 'ns_date';
    $sod = 'desc';
}


if($work_id) {
	$sql_search .= " AND work_id = '$work_id' ";
}


//23.07.14 현장소장 권한일경우 본인 현장 나오도록
if($member['mb_level2'] == 2) {
        $sql_search .= "and (
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
    $sst  = "work_id";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.* {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);




?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" xintegrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.list-group-item { padding: 0.3rem 1.25rem }
.input-group-addon,.input-group-text {
    border-left: 0 none;
    padding: 4px 9px 4px 9px;
}

.input-group-addon .glyphicon-calendar:before, .input-group-text .datePicker-calendar:before{
    content: " ";
    background: url(/assets/images/buttons/btn_calendar.png) center center no-repeat;
    width: 18px;
    height: 18px;
    display: block;
    overflow: hidden;
}
.table tbody tr td, .table tbody th td { border-bottom:1px solid #ccc }

.bg1 { background:#f2f2f2 }

/* PC 버전 표 스타일 (변경 없음) */
#desktop-table {
    table-layout: auto;
    width: 100%;
}
#desktop-table th, #desktop-table td {
    vertical-align: middle;
    padding: .6rem .5rem;
}
#desktop-table th {
    text-align: center;
}
#desktop-table td {
    text-align: left;
}
#desktop-table td:nth-child(1), /* 작업일자 */
#desktop-table td:nth-child(4), /* 작성일 */
#desktop-table td:nth-child(5) { /* 관리 */
    text-align: center;
}
</style>
<!--시공현장 리스트-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>스마트일보</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
				<li class="breadcrumb-item">현장관리</li>
				<li class="breadcrumb-item active">스마트일보</li>
			</ul>
		</div>

	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">

                    <div class="card">
						<div class="body">
                            <div class="btn-group" role="group" aria-label="Basic example">
							  <button type="button" class="btn btn-secondary" onclick="location.href='?date=<?php echo $preDate?>'"><</button>
							  <button type="button" class="btn btn-secondary" id="datePicker"><?php echo $date?></button>
							  <button type="button" class="btn btn-secondary"  onclick="location.href='?date=<?php echo $nxtDate?>'">></button>
							</div>
							<?php if($work_id) {?>
							<a class="btn btn-primary float-right" href="../write/menu3_write.php?work_id=<?php echo $work_id?>&date=<?php echo $date?>" role="button">스마트일보 등록</a>
							<?php }?>
							<form class="float-right" style="margin-right:5px">
								<div class="input-group">

										<select name="status" id="inputState" class="form-control" onchange="location.href='?date=<?php echo $date?>&status='+this.value">
											<option value="0" <?php echo get_selected($_GET['status'], 0)?>>진행중</option>
											<option value="1" <?php echo get_selected($_GET['status'], 1)?>>완료</option>

										</select>
										<select name="work_id" id="inputState" class="form-control" onchange="location.href='?date=<?php echo $date?>&status=<?php echo $status?>&work_id='+this.value">
											<option value="">선택하세요</option>
											<?php
											if($_GET['status'] == 0)
												$status = 0;
											else
												$status = 1;

											$workSql = "select seq, nw_code, nw_subject  from {$none['worksite']} where nw_status  = '$status' and nw_code != '210707' ";

											//23.07.14 현장소장 권한일경우 본인 현장 나오도록
if($member['mb_level2'] == 2) {
                                                                               $workSql .= "and (
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
											$workSql .= "order by nw_code desc";
											$workRst = sql_query($workSql);
											while($work = sql_fetch_array($workRst)) {

											?>
											<option value="<?php echo $work['nw_code']?>" <?php echo get_selected($work['nw_code'], $work_id)?>>[<?php echo $work['nw_code']?>] <?php echo $work['nw_subject']?></option>
											<?php }?>
										</select>

										<select class="form-select" aria-label="Date select" onchange="location.href = '?date=' + this.value +'&status=<?php echo $status?>&work_id=<?php echo $work_id?>'">
											<option value="">일보전체보기</option>
											<option value="">오늘</option>
											<option value="all">전체</option>
										</select>
								</div>


							</form>
                        </div>

                        <div class="body project_report">

                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover mobile-card" id="desktop-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>작업일자</th>
                                            <th>현장명</th>
                                            <th>날씨</th>
                                            <th>금일 작업내용</th>
                                            <th>작성일</th>
                                            <th>관리</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i=0; $row=sql_fetch_array($result); $i++) {

										$work = sql_fetch("select nw_subject from {$none['worksite']} where nw_code = '{$row['work_id']}'");

											 $bg = 'bg'.($i%2);

										?>
										<tr class="<?php echo $bg; ?>">
											<td><?php echo $row['ns_date']?>
											<td><a href="/_worksite/view/menu3_view.php?seq=<?php echo $row['seq']?>">[<?php echo $row['work_id']?>] <?php echo $work['nw_subject']?></a></td>
											<td><?php echo $row['ns_wather']?></td>
											<td>
											<ul class="list-group">
											  <li class="list-group-item list-group-item-dark">작업내역</li>
											  <li class="list-group-item"><?php echo nl2br($row['ns_today_his'])?></li>
											</ul>

											<ul class="list-group" style="margin-top:10px">
											  <li class="list-group-item list-group-item-dark">인원 투입현황</li>
											  <?php
												$gongjongSql =  "select * from {$none['smart_gongjong']} where ns_id = '{$row['seq']}' and ns_tcnt != 0";
												$gongjongRst =  sql_query($gongjongSql);
												for($a=0; $gongjong = sql_fetch_array($gongjongRst); $a++) {
											  ?>
											  <li class="list-group-item d-flex justify-content-between align-items-center">
												<?php echo $gongjong['ns_name']?>
												<span class="badge badge-danger "><?php echo $gongjong['ns_tcnt']?></span>
											  </li>
											  <?php } ?>
											   <li class="list-group-item list-group-item-dark">자재반입현황</li>
												<?php
												$jajaeSql =  "select * from {$none['smart_jajae']} where ns_id = '{$row['seq']}'  and ns_tcnt != 0";
												$jajaeRst =  sql_query($jajaeSql);
												for($b=0; $jajae = sql_fetch_array($jajaeRst); $b++) {


											  ?>
											  <li class="list-group-item d-flex justify-content-between align-items-center">
												<?php echo $jajae['ns_name']?> <?php echo $jajae['ns_option']?>
												<span class="badge badge-danger "><?php echo $jajae['ns_tcnt']?> <?php echo $jajae['ns_dan']?> </span>
											  </li>
											   <?php } ?>
											   <li class="list-group-item list-group-item-dark">장비반입현황</li>
												<?php
												$machineSql =  "select * from {$none['smart_machine']} where ns_id = '{$row['seq']}'  and ns_tcnt != 0";
												$machineRst =  sql_query($machineSql);
												for($b=0; $machine = sql_fetch_array($machineRst); $b++) {
											  ?>
											  <li class="list-group-item d-flex justify-content-between align-items-center">
												<?php echo $machine['ns_name']?> <?php echo $machine['ns_option']?>
												<span class="badge badge-danger "><?php echo $machine['ns_tcnt']?> <?php echo $machine['ns_dan']?> </span>
											  </li>
											  <?php } ?>
											</ul>




											</td>
											<td><?php echo $row['ns_datetime']?></td>
											<td>
											<button type="button" class="btn btn-success btn-sm" onclick="location.href='/_worksite/view/menu3_view.php?seq=<?php echo $row['seq']?>'">보기</button>
											<button type="button" class="btn btn-primary btn-sm" onclick="location.href='/_worksite/write/menu3_write.php?w=u&seq=<?php echo $row['seq']?>'">수정</button>
											<button type="button" class="btn btn-danger btn-sm" onclick="del_(<?php echo $row['seq']?>)">삭제</button></td>
										</tr>
										<?php } ?>

										<?php if($i == 0) {?>
										<tr>
											<td colspan="6" class="align-center">검색 된 데이터가 없습니다.</td>
										</tr>
										<?php }?>
                                    </tbody>
									</table>
 						 </div>
						  	<div class="pagination">
							<a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?date=$date&status=$status&work_id=$work_id&page=" . ($page - 1); ?>" class="prev">이전페이지</a>
							<a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?date=$date&status=$status&work_id=$work_id&page=" . ($page + 1); ?>" class="next">다음페이지</a>
							</div>

                        </div>
                    </div>
                </div>
            </div>


    </div>


<?php include_once(NONE_PATH.'/footer.php');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" xintegrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ko.min.js" xintegrity="sha512-L4qpL1ZotXZLLe8Oo0ZyHrj/SweV7CieswUODAAPN/tnqN3PA1P+4qPu5vIryNor6HQ5o22NujIcAZIfyVXwbQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
// 모바일 카드 뷰를 위한 JavaScript
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
        if (window.innerWidth <= 768 && !$table.hasClass('mobile-card-active')) { // Use a unique class for activation
            $table.addClass('mobile-card-active'); // Add activation class
            // Perform DOM manipulation for mobile layout
            $table.find('tbody tr').each(function(){
                var $tr = $(this);
                var $tds = $tr.find('td');

                // Clear existing dynamically added elements if any, before re-adding
                $tr.find('.mobile-card-header, .mobile-card-item').remove();

                // 1. 현장명 (from original td[1]) - Mobile Card Header
                var siteNameLink = $tds.eq(1).find('a').clone();
                var siteNameOnly = siteNameLink.text().replace(/\[.*?\]\s*/, '').trim();
                $('<div class="mobile-card-header"/>').text(siteNameOnly).prependTo($tr);

                // 2. 작업일자 (from original td[0])
                var workDate = $tds.eq(0).html();
                if (workDate) {
                    $('<div class="mobile-card-item" data-label="작업일자">' + workDate + '</div>').appendTo($tr);
                }

                // 3. 날씨 (from original td[2])
                var weather = $tds.eq(2).html();
                if (weather) {
                    $('<div class="mobile-card-item" data-label="날씨">' + weather + '</div>').appendTo($tr);
                }

                // --- Process the "금일 작업내용" TD (original td[3]) ---
                var td_work_content = $('<div>').html($tds.eq(3).html()); // Get the content of the 4th TD

                // Get the first UL (작업내역)
                var workDetailsUl = td_work_content.children('ul').first();
                if (workDetailsUl.length) {
                    // Extract content including the dark li, then re-wrap
                    var workDetailsLabel = workDetailsUl.find('.list-group-item-dark').text().trim();
                    var workDetailsHtml = workDetailsUl.html();
                    $('<div class="mobile-card-item" data-label="' + workDetailsLabel + '"><ul class="list-group">' + workDetailsHtml + '</ul></div>').appendTo($tr);
                }

                // Get the second UL (containing 인원, 자재, 장비 sections)
                var secondUl = td_work_content.children('ul').eq(1);
                if (secondUl.length) {
                    var currentSectionHtml = {
                        '인원 투입현황': '',
                        '자재반입현황': '',
                        '장비반입현황': ''
                    };
                    var currentLabel = '';

                    secondUl.children().each(function() {
                        var $li = $(this);
                        if ($li.hasClass('list-group-item-dark')) {
                            currentLabel = $li.text().trim();
                            if (currentSectionHtml.hasOwnProperty(currentLabel)) {
                                currentSectionHtml[currentLabel] += $li[0].outerHTML; // Include the header LI
                            }
                        } else {
                            if (currentSectionHtml.hasOwnProperty(currentLabel)) {
                                currentSectionHtml[currentLabel] += $li[0].outerHTML; // Include content LI
                            }
                        }
                    });

                    // Append each of the 3 sections as separate mobile-card-items
                    if (currentSectionHtml['인원 투입현황']) {
                        $('<div class="mobile-card-item" data-label="인원투입"><ul class="list-group">' + currentSectionHtml['인원 투입현황'] + '</ul></div>').appendTo($tr);
                    }
                    if (currentSectionHtml['자재반입현황']) {
                        $('<div class="mobile-card-item" data-label="자재반입"><ul class="list-group">' + currentSectionHtml['자재반입현황'] + '</ul></div>').appendTo($tr);
                    }
                    if (currentSectionHtml['장비반입현황']) {
                        $('<div class="mobile-card-item" data-label="장비반입"><ul class="list-group">' + currentSectionHtml['장비반입현황'] + '</ul></div>').appendTo($tr);
                    }
                }
                // --- End processing "금일 작업내용" TD ---


                // 4. 작성일 (from original td[4])
                var writeDate = $tds.eq(4).html();
                if (writeDate) {
                    $('<div class="mobile-card-item" data-label="작성일">' + writeDate + '</div>').appendTo($tr);
                }

                // 5. 관리 (from original td[5])
                var managementButtonsHtml = $tds.eq(5).html();
                if (managementButtonsHtml) {
                    $('<div class="mobile-card-item" data-label="관리">' + managementButtonsHtml + '</div>').appendTo($tr);
                }

                // Finally, hide all original <td> elements
                $tds.hide();
            });
        }
    }

    // Function to revert to desktop table layout
    function revertToDesktopLayout() {
        var $table = $('#desktop-table');
        // Check if screen is desktop size AND mobile-card class is currently applied
        if (window.innerWidth > 768 && $table.hasClass('mobile-card-active')) {
            $table.removeClass('mobile-card-active'); // Remove activation class
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
<style>
/* 모바일 카드형 전용 CSS */
@media (max-width: 768px) {
    .mobile-card-active { /* JavaScript에서 추가할 클래스 */
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden; /* 가로 스크롤 방지 */
    }
    .mobile-card-active thead {
        display: none; /* 모바일에서 테이블 헤더 숨김 */
    }
    .mobile-card-active tbody tr {
        display: flex; /* 테이블 행을 카드 레이아웃을 위한 블록처럼 동작하도록 설정 */
        flex-direction: column; /* 아이템을 세로로 쌓음 */
        border: 1px solid #dee2e6; /* 카드 테두리 */
        border-radius: 8px;
        margin-bottom: 1rem;
        padding: 1rem; /* 카드 내부 패딩 */
        box-shadow: 0 2px 4px rgba(0,0,0,.08); /* 그림자 효과 */
        overflow: hidden; /* 카드 내부 오버플로우 숨김 */
        width: 100%; /* 각 카드가 전체 너비를 차지하도록 */
        box-sizing: border-box; /* 패딩/테두리를 너비 계산에 포함 */
    }

    /* tbody tr의 모든 직계 자손(div 및 가시적인 td)에 대한 공통 스타일 */
    .mobile-card-active tbody tr > *:not(:last-child) { /* 마지막 자식 요소를 제외한 모든 요소에 하단 테두리 적용 */
        border-bottom: 1px solid #f1f1f1;
    }
    .mobile-card-active tbody tr > * { /* 모든 카드 아이템에 공통 패딩 및 글꼴 설정 */
        padding: .5rem .75rem;
        word-break: break-word;
        font-size: 0.82rem;
        line-height: 1.3;
        box-sizing: border-box;
    }

    /* 모바일 카드 헤더 (현장명) */
    .mobile-card-header {
        display: block;
        text-align: left;
        font-size: 1rem; /* 헤더 글꼴 크기 크게 */
        padding-bottom: .5rem; /* 헤더 아래 간격 */
        margin-bottom: .5rem; /* 헤더 아래 여백 */
        font-weight: bold;
    }

    /* 새로운 div 아이템 (작업일자, 날씨, 작업내역 등)의 공통 스타일 */
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

    /* 원래의 <td> 요소들은 숨김 */
    .mobile-card-active tbody td {
        display: none !important;
    }

    /* 리스트 그룹 내부 스타일 조정 (모바일 카드에 맞춰) */
    .mobile-card-item .list-group {
        width: 100%; /* 리스트 그룹이 카드 아이템 내에서 전체 너비 차지 */
    }
    .mobile-card-item .list-group-item {
        border: none; /* 리스트 아이템의 테두리 제거 */
        padding: 0.2rem 0; /* 리스트 아이템의 패딩 조정 */
        background-color: transparent; /* 배경색 투명 */
        font-size: 0.82rem; /* 글꼴 크기 */
        display: flex;
        justify-content: space-between; /* 내용과 뱃지 정렬 */
        align-items: center;
    }
    .mobile-card-item .list-group-item-dark {
        font-weight: bold;
        color: #333; /* 다크 모드 텍스트 색상 조정 */
        background-color: #f8f9fa; /* 다크 모드 배경색 */
        border-radius: 4px;
        margin-bottom: 5px;
        padding: 0.5rem;
        width: 100%;
        text-align: left;
    }
    .mobile-card-item .badge {
        font-size: 0.75rem;
    }

    /* 관리 버튼 컨테이너에 대한 추가 스타일 (필요시) */
    .mobile-card-item[data-label="관리"] {
        justify-content: space-around; /* 버튼들을 가로로 균등하게 정렬 */
        flex-wrap: wrap; /* 버튼이 많을 경우 줄바꿈 */
    }
    .mobile-card-item[data-label="관리"] button {
        margin: 5px; /* 버튼 사이 간격 */
        flex-grow: 1; /* 버튼이 공간을 채우도록 늘어남 */
        min-width: 80px; /* 최소 너비 */
    }
}
</style>
