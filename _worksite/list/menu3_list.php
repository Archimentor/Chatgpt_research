<head>
<style>
.pagination {
	text-align: center;
	margin-top: 20px;
  }
  .pagination a {
	display: inline-block;
	padding: 6px 12px;
	margin-right: 5px;
	background-color: #f5f5f5;
	border: 1px solid #ddd;
	border-radius: 4px;
	color: #333;
	text-decoration: none;
  }
  .pagination a:hover {
	background-color: #ddd;
	border-color: #ddd;
	color: #333;
  }
  .pagination .prev {
	float: left;
  }
  .pagination .next {
	float: right;
  }
</style>  
</head>

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



echo $sql;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                <table class="table m-b-0 table-hover">
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
                                        <tr>
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
                                        </tr>
                                        
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
    
</div>


<?php include_once(NONE_PATH.'/footer.php');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ko.min.js" integrity="sha512-L4qpL1ZotXZLLe8Oo0ZyHrj/SweV7CieswUODAAPN/tnqN3PA1P+4qPu5vIryNor6HQ5o22NujIcAZIfyVXwbQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$('#datePicker').datepicker({
		format: "yyyy-mm-dd",	//데이터 포맷 형식(yyyy : 년 mm : 월 dd : 일 )
		
       language : "ko"	//달력의 언어 선택, 그에 맞는 js로 교체해줘야한다.
		    
		}).on("changeDate", function(e) {
               
                
				  var dates_arr = [];
				   for(i=0; i<e.dates.length; i++){
					  dates_arr.push(e.dates[i].getFullYear() +'-'+ (String(e.dates[i].getMonth() + 1).padStart(2, '0')) + '-' + String(e.dates[i].getDate()).padStart(2, '0') );
				   }
				   
				   location.href = '?date='+dates_arr.join();
				  // console.log();
				 
            })
</script>
<script>
function del_(seq) {
	
	if(confirm('정말 스마트일보를 삭제하시겠습니까?')) {
		location.href = '/_worksite/write/menu3_update.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
</script>