<?php 
include_once('../../_common.php');
define('menu_establishment', true);
include_once(NONE_PATH.'/header.php'); 

if(!$_GET['date']) {
	$date = date('Y-m');
}
$preDate = date('Y-m', strtotime($date." -1 Month"));
$nxtDate = date('Y-m', strtotime($date." +1 Month"));

$searchDate = date('Y-m-t', strtotime($date));

$sql_common = " from  {$none['worksite']}  ";
//22.03.10 진행중, 완료로만 표시하도록 변경 수정  nw_sdate >= '".$date."-01'
$sql_search = " where (1) "; 

//22.08.31 실행부 소속일 경우 본인이 소장으로 있는 현장만 출력
if($member['mb_2'] == 10) {
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

if(!$status) $status = 1;

if($status == 1) {
	$sql_search .= " and  nw_status = 0 "; 
} else if($status == 2) {
	$sql_search .= " and  nw_status = 1 "; 
} else if($status == 3) {
	$sql_search .= " "; 
} else {
	$sql_search .= " and  nw_status = 0 "; 
}

if($stx) {
	$sql_search .= " and  (nw_subject LIKE '%$stx%' OR nw_code LIKE '%$stx%') "; 
}

if (!$sst) {
	$sst  = "nw_code";
	$sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 50;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$qstr .= "&status=$status&date=$date";
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2 { width:100% !important }
.select2-container .select2-selection--single {  height:36px }
.select2-container--default .select2-selection--single { border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px }
.price_txt { font-size:13px }
.noim_class1 { color:#666 }
.noim_class2 { color:#0080ff }
.noim_class3 { color:#008c00 }
.billing_class1 { color:#666 }
.billing_class2 { color:#ff8800 }
.billing_class3 { color:#008c00 }
</style>
<!--시공현장 리스트-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>기성청구서</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item active">기성청구서</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<div class="table-responsive">
						
                        <div class="body">
							<div class="btn-group" role="group" aria-label="Basic example">
							  <button type="button" class="btn btn-secondary" onclick="location.href='?date=<?php echo $preDate?>'"><</button>
							  <button type="button" class="btn btn-secondary" id="datePicker"><?php echo $date?></button>
							  <button type="button" class="btn btn-secondary"  onclick="location.href='?date=<?php echo $nxtDate?>'">></button>
							</div>
							<form class="float-right" style="margin-right:5px">
						
							
							<div class="input-group">
									
									<select name="status" id="inputState" class="form-control" onchange="location.href='?date=<?php echo $date?>&status='+this.value" >
										<option value="1" <?php echo get_selected($_GET['status'], 1)?>>진행중</option>
										<option value="2" <?php echo get_selected($_GET['status'], 2)?>>완료</option>
										<option value="3" <?php echo get_selected($_GET['status'], 3)?>>모두</option>
									</select>
									
									<input type="text" name="stx" value="" class="form-control" placeholder="현장명or현장코드">
									<div class="input-group-append">
										<button type="submit" class="btn btn-outline-secondary"><i class="icon-magnifier"></i></button>
									</div>
								
							</div>
							</form>
						</div>
                        <div class="body">
							 
							
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>해당월</th>
                                            <th>현장코드</th>
                                            <th>현장명</th>
                                            <th>기성청구서</th>
											<th>파일로 출력</th>
                                            <th>백데이터 일괄다운로드</th>
                                            <th>기성청구서 작성 상태</th>
                                            <th>노임대장 작성 상태</th>
                                            <th>진행상태</th>
                                            <th>백데이터 일괄삭제</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
									
										<?php for($i=0; $row=sql_fetch_array($result); $i++) {
											
											if($row['nw_status'])
												$status = '<span class="badge badge-success">완 료</span>';
											else
												$status = '<span class="badge badge-warning">진행중</span>';
											
											
											$nomu = sql_fetch("select * from {$none['est_nomu_confirm']} where nw_code = '{$row['nw_code']}' and nw_date = '{$date}' ");
											
											$noim1 = "";
											$noim2 = "";
											$billing1 = "";
											$billing2 = "";
											
											// 기존 노임대장 상태
											switch($nomu['confirm1']) {
												case 0 :
													$noim1 = "<span class=\"noim_class1\">미작성</span>";
													break;
												case 1 :
													$noim1 = "<span class=\"noim_class2\">작성(N)</span>";
													break;
												case 2 :
													$noim1 = "<span class=\"noim_class3\">작성</span>";
													break;
											}
											
											switch($nomu['confirm2']) {
												case 0 :
													$noim2 = "<span class=\"noim_class1\">미확인</span>";
													break;
												case 1 :
													$noim2 = "<span class=\"noim_class3\">확인</span>";
													break;
											}
											
											// 새로운 기성청구서 작성 상태 (confirm3)
											switch($nomu['confirm3']) {
												case 0:
													$billing1 = "<span class=\"billing_class1\">미작성</span>";
													break;
												case 1:
													$billing1 = "<span class=\"billing_class2\">작성(N)</span>";
													break;
												case 2:
													$billing1 = "<span class=\"billing_class3\">작성완료</span>";
													break;
												default:
													$billing1 = "<span class=\"billing_class1\">미작성</span>";
											}
											
											// 새로운 기성청구서 확인 상태 (confirm4)
											switch($nomu['confirm4']) {
												case 0:
													$billing2 = "<span class=\"billing_class1\">미확인</span>";
													break;
												case 1:
													$billing2 = "<span class=\"billing_class3\">확인</span>";
													break;
												default:
													$billing2 = "<span class=\"billing_class1\">미확인</span>";
											}
											
										?>
										<tr>
											<td class="text-center"><?php echo date('m', strtotime($date))?>월</td>
											<td class="text-center">
												<a href="/_worksite/write/menu1_write.php?w=u&seq=<?php echo $row['seq']?>" target="_blank">
													<?php echo $row['nw_code']?>
												</a>
											</td>
											<td><?php echo $row['nw_subject']?></td>
											<td class="text-center"><a href="../write/menu1_write.php?w=<?php echo $w?>&seq=<?php echo $row['seq']?>&date=<?php echo $date?>&index=1">작성하기</a></td>
                                        <td class="text-center">
                                                <a href="./download.php?type=excel&seq=<?php echo $row['seq']?>&date=<?php echo $date?>" title="엑셀 저장" style="color:#444">
                                                        <span class="glyphicon fa fa-file-excel-o"></span> 엑셀 저장
                                                </a>
                                        </td>
											<td class="text-center">
												<a href="./data_download.php?type=all&seq=<?php echo $row['seq']?>&date=<?php echo $date?>" title="일괄 다운로드" style="color:#444"><span class="glyphicon fa fa-download"></span></a>
											</td>
											<td class="text-center">
												<?php echo $billing1 ?> | <?php echo $billing2 ?>
											</td>
											<td class="text-center">
												<?php echo $noim1?> | <?php echo $noim2?>
											</td>
											<td class="text-center">
												<?php echo $status?>
											</td>
											<td class="text-center">
        <a href="javascript:data_delete(<?php echo $row['seq']?>)" title="일괄삭제"  style="color:red"><span class="glyphicon fa fa-trash-o">🗑️</span></a>
											</td>
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function chkfrm(f) {
	if(confirm('카테고리를 변경하시겠습니까?')) {
		f.submit();
	} else {
		return false;
	}
}

function del_(seq) {
        if(confirm('정말 시공현황 정보를 삭제하시겠습니까?\n\n연동 된 정보가 있다면 모두 해제 됩니다.')) {
                location.href = '/_worksite/write/menu1_update.php?w=d&seq='+seq;
        } else {
                return false;
        }
}

function data_delete(seq) {
        if(confirm('정말 업로드된 데이터를 모두 삭제하시겠습니까?\n삭제된 파일은 복구할 수 없습니다.')) {
                location.href = './data_delete.php?seq=' + seq + '&date=<?php echo $date?>';
        } else {
                return false;
        }
}

//검색형 셀렉트박스로 변경
$('.select2').select2({
  language: {
	noResults: function (params) {
	  return "검색 결과가 없습니다.";
	}
  }
});
</script>
