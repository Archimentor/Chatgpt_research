<?php 
include_once('../../_common.php');
define('menu_establishment', true);
include_once(NONE_PATH.'/header.php'); 


if($member['mb_level2'] == 4 || $member['mb_level2'] == 2) {
	alert('접근 권한이 없습니다.', 'http://n1con.com');
}
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
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>기성청구서</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item active">기본공제요율 설정</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						 <div class="table-responsive">
						
                     
                        <div class="body">
							 
							<form name="frm" action="./menu4_update.php" method="post">
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">국민연금</th>
                                            <th class="text-center">건강보험</th>
                                            <th class="text-center">장기요양</th>
                                            <th class="text-center">고용보험</th>
                                            <th class="text-center">소득세</th>
											<th class="text-center">지방소득세</th>
                                            <th class="text-center">국민연령</th>
                                            <th class="text-center">고용연령</th>
                                            <th class="text-center">연금 하한액</th>
                                            <th class="text-center">연금 상한액</th>
                                            <th class="text-center">건강 하한액</th>
                                            <th class="text-center">건강 상한액</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>

									
										<tr>
										
											<td class="text-center"><input type="text" name="cf_1" value="<?php echo $config['cf_1']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_2" value="<?php echo $config['cf_2']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_3" value="<?php echo $config['cf_3']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_4" value="<?php echo $config['cf_4']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_5" value="<?php echo $config['cf_5']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_6" value="<?php echo $config['cf_6']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_7" value="<?php echo $config['cf_7']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_8" value="<?php echo $config['cf_8']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_1_subj" value="<?php echo $config['cf_1_subj']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_2_subj" value="<?php echo $config['cf_2_subj']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_3_subj" value="<?php echo $config['cf_3_subj']?>" class="form-control text-right"></td>
											<td class="text-center"><input type="text" name="cf_4_subj" value="<?php echo $config['cf_4_subj']?>" class="form-control text-right"></td>
											
											
										</tr>
										
										
									</tbody>
									</table>
								</div>
								
								<div class="modal-footer">
									
									<button type="submit" class="btn btn-primary"data-dismiss="modal">업데이트</button>
									
								</div>
								</form>
							</div>
						
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
//검색형 셀렉트박스로 변경

 $('.select2').select2({
	  language: {
		noResults: function (params) {
		  return "검색 결과가 없습니다.";
		}
	  }
 });
</script>