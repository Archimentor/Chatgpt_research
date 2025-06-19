<?php 
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php'); 
include_once(G5_EDITOR_LIB);
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if($member['mb_level2'] == 3) $is_admin = true; 

if($w == 'u') {
	$row = sql_fetch("select * from {$none['repair_list2']} where seq = '$seq'");
	
	if(!$row)
		alert('데이터가 삭제되었거나 이동되었습니다.');
}

?>
<!--시공현장 작성-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/smartphoto@1.1.0/css/smartphoto.min.css">

<style>
.select2 { width:100% !important }
.select2-container .select2-selection--single {  height:36px }
.select2-container--default .select2-selection--single { border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px }
.price_txt { font-size:13px }
.smartphoto-caption { font-size:17px }
</style>
<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> 하자보증서 발급현황</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">현장관리</li>
                            <li class="breadcrumb-item active">하자보증서 등록</li>
                        </ul>
                    </div>            
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="frm" action="./menu8_update.php" enctype="multipart/form-data" method="post" enctype="multipart/form-data" onsubmit="return chkfrm(this)">
								<input type="hidden" name="uid" id="uid" value="<?php echo get_uniqid()?>">
								<input type="hidden" name="w" value="<?php echo $w?>">
								<input type="hidden" name="seq" value="<?php echo $seq?>">
								
								<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										보증서발급 정보입력
									</div>
									<div class="card-body ">
									<div class="form-row">
									
										<div class="form-group col-md-3">
										  <label for="inputPassword4">현장명</label>
											
											<select id="nw_code" class="select2" class="form-control" required >
												<option value="">선택하세요</option>
												<?php 
											
											
												$sql = "select * from  {$none['worksite']} order by nw_code desc";
												
												$rst = sql_query($sql);
												while($work=sql_fetch_array($rst)) {
												
												?>
												<option value="<?php echo $work['nw_code']?>,<?php echo $work['nw_subject']?>,<?php echo $work['nw_total_price']?>,<?php echo $work['nw_contract_date']?>" <?php echo get_selected($row['nw_code'], $work['nw_code'])?> >[<?php echo $work['nw_code']?>] <?php echo $work['nw_subject']?></option>
												<?php }?>
											
											</select>
											<input type="hidden" name="nw_code" id="nw_code_num" value="<?php echo $row['nw_code']?>">
											<input type="hidden" name="nw_code_txt" id="nw_code_txt" value="<?php echo $row['nw_code_txt']?>">
											
										</div>
										
										<div class="form-group col-md-3">
										  <label for="inputPassword4">하도급업체</label>
										   <div class="input-group" >
											<input type="text" name="nr_bname" value="<?php echo $row['nr_bname']?>"  class="form-control"  style="width:50%">
											
										  
											</div>
										</div>
										
										<div class="form-group col-md-3">
										  <label for="inputPassword4">보증서번호</label>
										   <div class="input-group" >
											<input type="text" name="nr_num" value="<?php echo $row['nr_num']?>"  class="form-control" id="nr_num" style="width:50%">
											
										  
											</div>
										</div>
										<div class="form-group col-md-3">
										  <label for="inputPassword4">공종명</label>
										   <div class="input-group" >
											<input type="text" name="nr_gongjong" value="<?php echo $row['nr_gongjong']?>"  class="form-control" id="nr_gongjong" style="width:50%">
											
										  
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-3">
										  <label for="inputPassword4">공사금액</label>
										   <div class="input-group" >
											<input type="text" name="nr_price_contract" value="<?php echo $row['nr_price_contract']?>"  class="form-control num" id="nr_price_contract" style="width:50%">
											<div class="input-group-append">
											<span class="input-group-text"> 원</span>
										   </div>
										  
											</div>
										</div>
										<div class="form-group col-md-3">
										  <label for="inputPassword4">계약일</label>
										   <div class="input-group" >
											<input type="date" name="nr_contract_date" value="<?php echo $row['nr_contract_date']?>"  class="form-control" id="nr_contract_date" style="width:50%">
											
										  
											</div>
										</div>
										<div class="form-group col-md-3">
										   <label>보증금액  </label>
										   <div class="input-group">
											  <input type="text" name="nr_price" value="<?php echo $row['nr_price']?>" id="nr_price" class="form-control num  " placeholder="">
											  <div class="input-group-append">
												<span class="input-group-text"> 원</span>
											  </div>
											 
											</div>
										</div>
										<div class="form-group col-md-3">
										   <label>공사금액의  </label>
										   <div class="input-group">
											  <input type="text" name="nr_price_per" value="<?php echo $row['nr_price_per']?>" id="nr_price_per" class="form-control" placeholder="">
											  <div class="input-group-append">
												<span class="input-group-text"> %</span>
											  </div>
											</div>
										</div>
										
									
									</div>
									
									<div class="form-row">
										<div class="form-group col-md-3">
										   <label>하자담보책임기간  </label>
										   <div class="input-group">
											
											  <input type="date" name="nr_sdate" value="<?php echo $row['nr_sdate']?>" id="sdate" class="form-control datePicker " placeholder="시작일">
											  <input type="date" name="nr_edate" value="<?php echo $row['nr_edate']?>" id="edate"  class="form-control datePicker" placeholder="종료일">
											  </div>
										</div>
										<div class="form-group col-md-3">
										   <label>발급기관 <a href="#largeModal" data-toggle="modal" data-target="#largeModal" class=" btn-primary btn-sm">기관추가</a></label>
											<select name="nr_company" id="nr_company"class="form-control" required >
												<option value="">선택하세요</option>
												<?php 
											
											
												$sql = "select * from {$none['repair_company']}  order by nr_name asc";
												
												$rst = sql_query($sql);
												while($work=sql_fetch_array($rst)) {
												
												?>
												<option value="<?php echo $work['nr_name']?>" <?php echo get_selected($row['nr_company'], $work['nr_name'])?> ><?php echo $work['nr_name']?></option>
												<?php }?>
											
											</select>
											  
										</div>
										<div class="form-group col-md-3">
										   <label>발급수수료  </label>
										   <div class="input-group">
										
											  <input type="text" name="nr_fees" value="<?php echo $row['nr_fees']?>" class="form-control num  " placeholder="">
											  <div class="input-group-append">
												<span class="input-group-text"> 원</span>
											  </div>
											 </div>
										</div>
										<div class="form-group col-md-3">
										   <label>하자보증서 첨부</label>
											<input type="file" name="nr_file" class="form-control">
											  
										</div>
										
									</div>	
									
									<div class="form-row">
										<div class="form-group col-md-9"></div>
										<?php if($w == 'u' && $row['nr_file']) {?>
										<div class="form-group col-md-3" style="float:right">
										    <label style="coor:#007bff"><?php echo $row['nr_file_name']?>
											<a href="../write/menu8_update.php?w=f&seq=<?php echo $seq?>"><span class="glyphicon fa fa-download"></span></a>
											</label><br>
											<input type="checkbox" name="file_del" value="1" > 파일삭제<br>
											
											  
										</div>
										<?php }?>
									
									</div>	
									<div class="form-row">
										<div class="form-group col-md-12">
										   <label>특기사항</label>
											<?php echo editor_html("nr_content", get_text(html_purifier($row['nr_content']), 0)); ?>
											  
										</div>
										
									</div>
									
								</div>
								</div>
								
								
								
								<div class="m-t-30 align-right">
										<button type="submit" class="btn btn-primary" style="margin-left:20px"><?php if($w == 'u') echo '수정'; else echo '등록';?>(F8)</button>
										<a href="../list/menu8_list.php" class="btn btn-outline-secondary">취소</a>
										
										<?php if($w == 'u' && $is_admin) {?>
										<a href="./menu8_update.php?w=d&seq=<?php echo $seq?>" onclick="del(this.href); return false" class="btn btn-danger" style="margin-left:20px">삭제</a>
										<?php }?>
									</div>
								</div>
								
								   
								</div>
							
                         
							
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

</div>


<div class="modal fade" id="largeModal" tabindex="-1"  role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel">발급기관 추가</h5>
            </div>
            <div class="modal-body"> 
			
			
			<div class="input-group">
				<input type="text" id="pop_company" placeholder="발급기관명" class="form-control">
				<div class="input-group-append">
				<button type="button" class="btn btn-dark" onclick="addCompany()">추가</button>
			</div>
			
			</div>
			
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
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
function addCompany() {
	
	var company = $('#pop_company').val();
	
	if(!company) {
		alert('발급기관명을 입력하세요.');
		return false;
	}
	
	$.post('./ajax.menu8.company.php', { company : company }, function(data) {
		
		if(data == "n") {
			alert('처리 중 오류가 발생하였습니다.');
			return false;
		} else if(data == "y"){
			alert('발급기관이 추가되었습니다.');
			$('#nr_company').append('<option value="'+company+'">'+company+'</option>');
			
			
		}
		
	})
	
}
function chkfrm(f) {
	<?php echo get_editor_js("nr_content"); ?>
	
	return true;
}
function comma(str) {
 str = String(str);
 return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}

function uncomma(str) {
 str = String(str);
 return str.replace(/[^\d]+/g, '');
}

function removeComma() {
$('.num').each(function() {
	$(this).val(uncomma($(this).val()));
	
})

}
document.onkeyup = function(e) {
	if(e.which == 119) {
		
		if(confirm('저장하시겠습니까?')) {
			document.frm.submit();
		} else {
			return false;
		}
	}
}

//파일삭제 
function file_del(seq) {
	
	if(confirm('정말 삭제하시겠습니까?\n삭제 된 파일은 복구가 불가능합니다.')) {
		location.href = '/_ajax/file_delete.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}

$(function() {
	
	//공사명 선택시 공사금액 자동입력
	$('#nw_code').bind('change', function() {
		//기입력된 데이터 초기화
		$('#nw_code_num').val('');
		$('#nw_code_txt').val('');
		$('#nr_price_contract').val('');
		$('#nr_contract_date').val('');
		$('#nr_price').val('');
		$('#nr_price_per').val('');
									
		var v = $(this).val();
		var vv = v.split(',');
		
		$('#nw_code_num').val(vv[0]);
		$('#nw_code_txt').val(vv[1]);
		$('#nr_price_contract').val(comma(vv[2]));
		$('#nr_contract_date').val(vv[3]);
		
	})
	
	$('#nr_price').bind('keyup', function() {
		var price = parseInt(uncomma($('#nr_price_contract').val()));
		
		if(!price || price == 0) {
			$(this).val('');
			alert('공사금액을 입력하세요.');
			return false;
		}
		
		if(uncomma($(this).val()) == 0 || !uncomma($(this).val()))
		{
			$('#nr_price_per').val('');
			return false;
		}			
		
		var persent =  parseInt(uncomma($(this).val())) / price * 100;
		
		$('#nr_price_per').val(persent.toFixed(2));
		
		
	})
	
	$('#nr_price_per').bind('keyup', function() {
		var price = parseInt(uncomma($('#nr_price_contract').val()));
		
		if(!price || price == 0) {
			$(this).val('');
			alert('공사금액을 입력하세요.');
			return false;
		}
		
		var persent =  price * parseInt(uncomma($(this).val())) / 100;
		
		$('#nr_price').val(comma(parseInt(persent)));
		
		
	})
	
	$('.num').each(function() {
		
			
		$(this).val(comma($(this).val()));
		
	})
	
	$(document).on('keyup', '.num', function() {
		 
		var v = comma(uncomma($(this).val()));
	
		$(this).val(v);
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
