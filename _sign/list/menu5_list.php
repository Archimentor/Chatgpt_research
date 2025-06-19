<?php 
include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php'); 

	$sql_common = " from  {$none['sign_line']}  ";
	$sql_search = " where (1) ";


if($member['mb_level2'] == 3) $is_admin = true; 

if(!$is_admin) alert('접근 권한이 없습니다.');

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
    $sst  = "seq";
    $sod = "asc";
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2 { width:100% !important }
.select2-container .select2-selection--single {  height:36px }
.select2-container--default .select2-selection--single { border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px }
.price_txt { font-size:13px }
</style>
<!--시공현장 리스트-->
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
					<form action="./menu5_update.php" method="post" onsubmit="return chkfrm(this)">
                    <div class="card">
						<div class="body">
                            <button class="btn btn-primary float-right"  role="button">일괄 변경</button> 
						</div>
						
					
						
                        <div class="body project_report">
							
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>문서종류</th>
                                            <th>결제1</th>
                                            <th>결제2</th>
                                            <th>결제3</th>
                                            <th>결제4</th>
                                            <th>결제5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
									
										<?php for($i=0; $row=sql_fetch_array($result); $i++) {
											
											
										?>
										
										<tr>
										
											<td><?php echo $row['ns_type']?></td>
											<td> 
											<input type="hidden" name="seq[]" value="<?php echo $row['seq']?>">
											<select  name="ns_id1[]" class="form-control select2">
												<option value="">결제1</option>
												<?php echo get_admin_select($row['ns_id1'])?>
											</select>
											
											</td>
											<td>
												<select  name="ns_id2[]" class="form-control select2">
													<option value="">결제2</option>
													<?php echo get_admin_select($row['ns_id2'])?>
												</select>
											
											</td>
											<td>
											<select  name="ns_id3[]" class="form-control select2">
												<option value="">결제3</option>
												<?php echo get_admin_select($row['ns_id3'])?>
											</select>
											</td>
											<td>
											<select  name="ns_id4[]" class="form-control select2">
												<option value="">결제4</option>
											<?php echo get_admin_select($row['ns_id4'])?>
											
											</select>
											</td>
											<td>
											<select  name="ns_id5[]" class="form-control select2">
												<option value="">결제5</option>
											<?php echo get_admin_select($row['ns_id5'])?>
											</select> 
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
                    </div>
					</form>
					
					<div class="table-responsive" style="background:#fff">
					<form action="./menu5_update2.php" method="post" onsubmit="return chkfrm2(this)">
					<table class="table m-b-0">
						
						<tbody>
							<tr>
							<td style="background:#f2f2f2">일괄적용</td>
							<td >
							<select  name="ns_id1" class="form-control select2">
								<option value="">결제1</option>
								<?php echo get_admin_select()?>
							</select>
							</td>
							<td>
							<select  name="ns_id2" class="form-control select2">
								<option value="">결제2</option>
								<?php echo get_admin_select()?>
							</select>
							</td>
							<td>
							<select  name="ns_id3" class="form-control select2">
								<option value="">결제3</option>
								<?php echo get_admin_select()?>
							</select>
							</td>
							<td>
							<select  name="ns_id4" class="form-control select2">
								<option value="">결제4</option>
								<?php echo get_admin_select()?>
							</select>
							</td>
							<td>
							<select  name="ns_id5" class="form-control select2">
								<option value="">결제5</option>
								<?php echo get_admin_select()?>
							</select>
							</td>
							<td>
							 <button class="btn btn-primary float-right"  role="button" style="width:100%">적용</button> 
							</td>
							</tr>
						</tbody>
					</table>
					</form>
					</div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>


<?php include_once(NONE_PATH.'/footer.php');?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function chkfrm(f) {
	if(confirm('결재라인을 변경하시겠습니까?\n변경 후 신규 결재건들 부터 적용됩니다.')) {
		f.submit();
	} else {
		return false;
	}
}

function chkfrm2(f) {
	if(confirm('결재라인을 일괄 변경하시겠습니까?\n변경 후 신규 결재건들 부터 적용됩니다.')) {
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
//검색형 셀렉트박스로 변경

 $('.select2').select2({
	  language: {
		noResults: function (params) {
		  return "검색 결과가 없습니다.";
		}
	  }
 });
</script>