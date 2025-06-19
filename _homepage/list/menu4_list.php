<?php 
include_once('../../_common.php');
define('menu_homepage', true);
include_once(NONE_PATH.'/header.php'); 

$sql_common = " from  {$none['home_recruit']}  ";
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
            $sql_search .= " (wr_subject like '%$stx%' or wr_name like '%$stx%' or wr_tel like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
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

?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2 { width:100% !important }
.select2-container .select2-selection--single {  height:36px }
.select2-container--default .select2-selection--single { border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px }
.price_txt { font-size:13px }
.badge { font-size:13px }
</style>
<!--시공현장 리스트-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>홈페이지관리</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">홈페이지관리</li>
				<li class="breadcrumb-item active">입사지원서 관리</li>
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
									<input type="text" name="stx" class="form-control" placeholder="이름, 연락처로 검색" value="<?php echo urldecode($stx)?>" >
									<div class="input-group-append">
										<button class="input-group-text" id="search-mail"><i class="icon-magnifier"></i></button>
									</div>
								</div>
							</form>
                        </div>	
					
						
                        <div class="body project_report">
							
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">번호</th>
                                            <th>제목</th>
                                            <th class="text-center">접수자</th>
                                            <th class="text-center">연락처</th>
                                            <th class="text-center">접수일</th>
                                            <th class="text-center">합격여부</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
									
										<?php for($i=0; $row=sql_fetch_array($result); $i++) {
											$num = $total_count - ($page - 1) * $rows - $i;
										
											switch($row['wr_state']) {
												case '접수' :
												$wr_state = '<span class="badge badge-secondary">접수</span>';
												break;
												case '합격' :
												$wr_state = '<span class="badge badge-success">합격</span>';
												break;
												case '불합격' :
												$wr_state = '<span class="badge badge-danger">불합격</span>';
												break;
												case '보류' :
												$wr_state = '<span class="badge badge-light">보류</span>';
												break;
											}
										?>
										
										<tr>
											<td class="text-center"><?php echo $num?></td>
											<td><a href="#largeModal3" data-toggle="modal" data-target="#largeModal3" data="<?php echo $row['seq']?>" class="open_recruit"><?php echo $row['wr_subject']?></a></td>
											<td class="text-center"><?php echo $row['wr_name']?></td>
											<td class="text-center"><?php echo $row['wr_tel']?></td>
											<td class="text-center"><?php echo $row['wr_datetime']?></td>
											<td class="text-center"><?php echo $wr_state?></td>
										</tr>
										<?php 
										
										}
										if($i == 0) {?> 
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
<div class="modal fade" id="largeModal3" tabindex="-1"  role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel">입사지원서</h5>
            </div>
			<input type="hidden" name="seq" id="seq" value="">
            <div class="modal-body" id="recruit_form"> 
		
				
			
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btns" data="합격">합격</button>
                <button type="button" class="btn btn-danger btns" data="불합격">불합격</button>
                <button type="button" class="btn btn-light btns" data="보류">보류</button>
                <button type="button" class="btn btn-secondary del_btn">삭제</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">닫기</button>
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
//검색형 셀렉트박스로 변경
$(function() {
	 $('.select2').select2({
		  language: {
			noResults: function (params) {
			  return "검색 결과가 없습니다.";
			}
		  }
	 });
	 
	 $('.open_recruit').bind('click', function() {
		var seq = $(this).attr('data');
		$('#recruit_form').html(''); //초기화
		$('#seq').val(''); //초기화
		$('#seq').val(seq); //초기화
		
		$.post('./menu4_list_view.php', { seq : seq }, function(data) {
			$('#recruit_form').html(data);
		})
	 })
	 
	 $('.btns').bind('click' ,function() {
		var state = $(this).attr('data');
		var seq = $('#seq').val();
		
		if(confirm('정말 '+state+'처리 하시겠습니까?')) {
			location.href = './menu4_list_update.php?w=u&seq='+seq+'&state='+state;

		} else {
			return false;
		}
	 })
	 
	 $('.del_btn').bind('click' ,function() {
		var seq = $('#seq').val();
		
		if(confirm('정말 삭제 하시겠습니까?')) {
			location.href = './menu4_list_update.php?w=d&seq='+seq;

		} else {
			return false;
		}
	 })
 });
</script>