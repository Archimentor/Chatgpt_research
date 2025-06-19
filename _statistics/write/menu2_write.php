<?php 
include_once('../../_common.php');
define('menu_statistics', true);
include_once(NONE_PATH.'/header.php'); 

if($w == 'u') {
	
	$row = sql_fetch("select * from {$none['sales_list']} where seq = '$seq'");
	
	if(!$row)
		alert('데이터가 삭제되었거나 이동되었습니다.');
}

?>
<!--시공현장 작성-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2 { width:100% !important }
.select2-container .select2-selection--single {  height:36px }
.select2-container--default .select2-selection--single { border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px }
.price_txt { font-size:13px }
</style>
<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> 통계</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">통계</li>
                            <li class="breadcrumb-item active">매출현황 등록</li>
                        </ul>
                    </div>            
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="frm" action="./menu2_update.php" enctype="multipart/form-data" method="post">
								<input type="hidden" name="uid" id="uid" value="<?php echo get_uniqid()?>">
								<input type="hidden" name="w" value="<?php echo $w?>">
								<input type="hidden" name="seq" value="<?php echo $seq?>">
								
								<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										매출현황등록
									</div>
									<div class="card-body ">
									<div class="form-row">
									
										<div class="form-group col-md-6">
										  <label>현장명</label>
										  <select name="nw_code" id="inputState" class="form-control select2">
											<optgroup label="진행현장">
												<?php 
												$workSql = "select seq, nw_code, nw_subject  from {$none['worksite']} where nw_status  = '0' and nw_code != '210707' order by nw_code desc";
												$workRst = sql_query($workSql);
												while($work = sql_fetch_array($workRst)) {
												?>
												<option value="<?php echo $work['nw_code']?>" <?php echo get_selected($work['nw_code'], $row['nw_code'])?>>[진행중] [<?php echo $work['nw_code']?>] <?php echo $work['nw_subject']?></option>
												<?php } ?>
											</optgroup>
											<optgroup label="완료현장">
												<?php 
												$workSql = "select seq, nw_code, nw_subject  from {$none['worksite']} where nw_status  = '1' and nw_code != '210707' order by nw_code desc";
												$workRst = sql_query($workSql);
												while($work = sql_fetch_array($workRst)) {
												?>
												<option value="<?php echo $work['nw_code']?>" <?php echo get_selected($work['nw_code'], $row['nw_code'])?>>[완료] [<?php echo $work['nw_code']?>] <?php echo $work['nw_subject']?></option>
												<?php } ?>
											</optgroup>
										  </select>
										</div>
										<div class="form-group col-md-6">
										  <label>구분</label>
										  <select name="ns_type" id="ns_type" class="form-control">
											<option value="세금계산서" <?php echo get_selected($row['ns_type'], '세금계산서')?>>세금계산서</option>
											<option value="도급기성" <?php echo get_selected($row['ns_type'], '도급기성')?>>도급기성</option>
											<option value="도급기성(현금)" <?php echo get_selected($row['ns_type'], '도급기성(현금)')?>>도급기성(현금)</option>
										  </select>
										</div>
									</div>
									
									<div class="form-row">
									
										<div class="form-group col-md-6">
										   <label>발행일/입금일  </label>
										
											
											  <input type="date" name="ns_date" value="<?php echo $row['ns_date']?>" class="form-control datePicker" placeholder="발행일/입금일">
										</div>
										
									</div>
									
									<div class="form-row">
									
										<div class="form-group col-md-4">
										    <label>공급가액  </label>
											<div class="input-group" >
												<input type="text" name="ns_price" value="<?php echo $row['ns_price']?>" class="pi1 form-control" id="price" style="width:50%">
												<div class="input-group-append">
												<span class="input-group-text"> 원</span>
												</div>
											
											</div>
										</div>
										<div class="form-group col-md-4">
										    <label>부가세  </label>
											<div class="input-group" >
												<input type="text" name="ns_vat" value="<?php echo $row['ns_vat']?>"  class="pi1 form-control" id="vat" style="width:50%">
												<div class="input-group-append">
												<span class="input-group-text"> 원</span>
												</div>
											
											</div>
										</div>
										<div class="form-group col-md-4">
										    <label>합계  </label>
											<div class="input-group" >
												<input type="text" name="ns_total_price" value="<?php echo $row['ns_total_price']?>" onkeyup="conv_price(1)" readonly class="readonly pi1 form-control" id="total_price" style="width:50%">
												<div class="input-group-append">
												<span class="input-group-text"> 원</span>
											</div>
											</div>
											
										</div>
										
									</div>
									
									<div class="form-row">
									
										<div class="form-group col-md-6">
										   <label>입금통장  </label>
										
											
											  <input type="text" name="ns_account" value="<?php echo $row['ns_account']?>" class="form-control datePicker" placeholder="입금통장">
										</div>
										<div class="form-group col-md-6">
										   <label>메모  </label>
										
											
											  <input type="text" name="ns_memo" value="<?php echo $row['ns_memo']?>" class="form-control datePicker" placeholder="메모">
										</div>
										
									</div>
									<div class="m-t-30 align-right">
											<button type="submit" class="btn btn-primary" style="margin-left:20px"><?php if($w == 'u') echo '수정'; else echo '등록';?>(F8)</button>
											<a href="../list/menu2_list.php" class="btn btn-outline-secondary">취소</a>
										</div>
									</div>
								
									</div>
									
								</div>
								
								
                        </div>
                    </div>
                </div>
            </div>
        </div>


</div>

<?php include_once(NONE_PATH.'/footer.php');?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.onkeyup = function(e) {
	if(e.which == 119) {
		
		if(confirm('저장하시겠습니까?')) {
			document.frm.submit();
		} else {
			return false;
		}
	}
}
$(function() {
	
	//공급가액 + 부가세 = 합계 ( 도급기성현금은 부가세 포함안함)
	$('#price').bind('keyup', function() {
		var p1 = parseInt($('#price').val())?parseInt($('#price').val()):0;
		var type = $('#ns_type').val();
		
		var vat = 0;
		var tottal
		
		
		//$('#total_price_conv').html(priceConvertKorean(String(total)));
		
		if(type == "세금계산서" || type == "도급기성") {
			vat   = (p1*0.1);    // 부가세(VAT)
			vat   = Math.round(vat);    // 부가세(반올림)
		}
		
		$('#vat').val(vat);
		$('#total_price').val(p1+vat);
		
	})
	
	$('#vat').bind('keyup', function() {
		var p1 = parseInt($('#price').val())?parseInt($('#price').val()):0;
		var vat = parseInt($(this).val())?parseInt($(this).val()):0;
	
		$('#total_price').val(p1+vat);
		
	})
	
	$('#ns_type').bind('change', function() {
		
		if($(this).val() == "도급기성(현금)") {
			
			$('#vat').val(0);
			$('#total_price').val($('#price').val());
			
		} else {
			
			var p1 = parseInt($('#price').val())?parseInt($('#price').val()):0;
			var vat = 0;
			vat   = (p1*0.1);    // 부가세(VAT)
			vat   = Math.round(vat);    // 부가세(반올림)
			
			$('#vat').val(vat);
			$('#total_price').val(p1+vat);
		}
		
	})
	


	
	//검색형 셀렉트박스로 변경
   
	 $('.select2').select2({
		  language: {
			noResults: function (params) {
			  return "검색 결과가 없습니다.";
			}
		  }
	 });

})

</script>
