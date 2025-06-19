<?php 
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php'); 

if($member['mb_level2'] == 3) $is_admin = true; 

include_once(G5_EDITOR_LIB);

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
if($w == 'u') {
	
	$row = sql_fetch("select * from {$none['repair_list']} where seq = '$seq'");
	
	if(!$row)
		alert('데이터가 삭제되었거나 이동되었습니다.');
	
	$info = sql_fetch("select * from  {$none['worksite']} where nw_code = '{$row['nw_code']}'");
	$info2 = sql_fetch("select * from {$none['subcontract']} where seq = '{$row['nr_bname']}'");
	$info3 = sql_fetch("select * from {$none['repair_list2']} where seq = '{$row['nr_assurance']}'");
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> 하자보수</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">현장관리</li>
                            <li class="breadcrumb-item active">하자보수</li>
                        </ul>
                    </div>            
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="frm" action="./menu7_update.php" enctype="multipart/form-data" method="post" onsubmit="return chkfrm(this)">
								<input type="hidden" name="uid" id="uid" value="<?php echo get_uniqid()?>">
								<input type="hidden" name="w" value="<?php echo $w?>">
								<input type="hidden" name="seq" value="<?php echo $seq?>">
								
								<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										기본 접수내용
									</div>
									<div class="card-body ">
									<div class="form-row">
										<div class="form-group col-md-6">
										  <label>현장명</label>
										  <?php if($w == 'u') {?>
										  <input type="text" name="nw_code" class="form-control" value="<?php echo $row['nw_code']?> <?php echo $info['nw_subject']?>" placeholder="" readonly>
										  <?php }?>
										</div>
										<div class="form-group col-md-6">
										  <label for="inputPassword4">진행상황</label>
											<select name="nr_status"  class="form-control">
												<option value="0" <?php echo get_selected($row['nr_status'], 0)?>>접수</option>
												<option value="1" <?php echo get_selected($row['nr_status'], 1)?>>진행중</option>
												<option value="2" <?php echo get_selected($row['nr_status'], 2)?>>완료</option>
											</select>
										</div>
										
									</div>
									
									<div class="form-row">
										<div class="form-group col-md-4">
										   <label>건축주  </label>
										   <div class="input-group">
											
											  <input type="text" name="nr_name" value="<?php echo $row['nr_name']?>" class="form-control  " placeholder="" readonly>
											  <input type="text" name="nr_tel" value="<?php echo $row['nr_tel']?>"   class="form-control " placeholder="" readonly>
											</div>
										</div>
										<div class="form-group col-md-4">
										   <label>접수자  </label>
										   <div class="input-group">
											
											  <input type="text" name="nr_name2" value="<?php echo $row['nr_name2']?>" class="form-control  " placeholder="" readonly>
											  <input type="text" name="nr_tel2" value="<?php echo $row['nr_tel2']?>"   class="form-control " placeholder="" readonly>
											  </div>
										</div>
										<?php if($w == 'u') {?>
										<div class="form-group col-md-4">
										   <label>하자접수일시/IP </label>
										   <div class="input-group">
											
											  <input type="text" name="nr_datetime" value="<?php echo $row['nr_datetime']?>" class="form-control  " placeholder="" readonly>
											  <input type="text" name="nr_datetime" value="<?php echo $row['nr_ip']?>" class="form-control  " placeholder="" readonly>
											  </div>
										</div>
										<?php }?>
										
										
									</div>
									</div>
								</div>
								
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										담당소장 설정
									</div>
									<div class="card-body ">
										<div class="form-row ">
											
											
											<div class="form-group col-md-4">
											  <label for="inputPassword4">담당소장</label>
												
												<div class="input-group">
												  <?php 
													$manager1 = get_member($info['nw_ptype1_1'], 'mb_hp, mb_name');
												  ?>
												  <input type="text" value="<?php echo $manager1['mb_name']?>" class="form-control  " placeholder="" readonly>
												  <input type="text"  value="<?php echo $manager1['mb_hp']?>"   class="form-control " placeholder="" readonly>
												
												</div>
											</div>
											
											<div class="form-group col-md-4">
											  <label for="inputPassword4">실제투입소장</label>
												
												<div class="input-group">
												  <?php 
													$manager2 = get_member($info['nw_ptype2_1'], 'mb_hp, mb_name');
												  ?>
												  <input type="text" value="<?php echo $manager2['mb_name']?>" class="form-control  " placeholder="" readonly>
												  <input type="text"  value="<?php echo $manager2['mb_hp']?>"   class="form-control " placeholder="" readonly>
												
												</div>
											</div>
											<div class="form-group col-md-4">
											  <label for="inputPassword4">하자담당소장</label>
												
												<div class="input-group">
												  <?php 
													$manager3 = get_member($row['nr_manager'], 'mb_hp, mb_name');
												  ?>
												 <div class="col" style="padding:0">
												<select  name="nr_manager" id="nr_manager" class="form-control select2">
													<option value="">하자담당소장 선택</option>
													<?php echo get_manager_select($row['nr_manager'])?>
												</select> 
												</div>
												  <input type="text" id="nr_manager_tel" value="<?php echo $manager3['mb_hp']?>"   class="form-control " placeholder="" readonly>
												
												</div>
											</div>
											
										</div>
										
							
									</div>
								</div>
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										시공업체
									</div>
									<div class="card-body ">
										<div class="form-row">
											<div class="form-group col-md-6">
											  <label>시공업체 선택</label>
											  <select name="nr_bname" id="nr_bname"  class="form-control select2" required >
												<option value="">업체를 선택하세요.</option>
												<?php echo get_enterprise_all_select($row['nr_bname'])?>
											   </select>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-4">
											    <label>공종  </label>
												<input type="text" id="ns_gongjong" value="<?php echo $info2['ns_gongjong']?>" class="form-control  " placeholder="" readonly>
											</div>
											<div class="form-group col-md-4">
											   <label>대표전화  </label>
											   
												<input type="text" id="ns_btel" value="<?php echo $info2['ns_btel']?>" class="form-control  " placeholder="" readonly>
											</div>
											<?php if($w == 'u') {?>
											<div class="form-group col-md-4">
											   <label>현장소장/연락처 </label>
											   <div class="input-group">
												
												  <input type="text" id="ns_manager" value="<?php echo $info2['ns_manager']?>" class="form-control  " placeholder="" readonly>
												  <input type="text" id="ns_manager_tel"   value="<?php echo $info2['ns_manager_tel']?>" class="form-control  " placeholder="" readonly>
												  </div>
											</div>
											<?php }?>
											
											
										</div>
									</div>
								</div>
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										하자보증서
									</div>
									<div class="card-body ">
										<div class="form-row">
											<div class="form-group col-md-6">
											  <label>하자보증서 선택</label>
											  <select name="nr_assurance" id="nr_assurance"  class="form-control select2" >
												<option value="">하자보증서를 선택하세요.</option>
												<?php 
												$sql3 = "select * from {$none['repair_list2']} where nw_code = '{$row['nw_code']}'";
												$rst3 = sql_query($sql3);
												while($row3 = sql_fetch_array($rst3)) {
												?>
												<option value="<?php echo $row3['seq']?>" <?php echo get_selected($row['nr_assurance'], $row3['seq'])?>>[<?php echo $row3['nr_company']?> - <?php echo $row3['nr_num']?>] <?php echo $row3['nr_bname']?> / <?php echo $row3['nr_gongjong']?></option>
												<?php }?>
											   </select>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-4">
											    <label>보증서번호  </label>
												<input type="text" id="anr_num" value="<?php echo $info3['nr_num']?>" class="form-control  " placeholder="" readonly>
											</div>
											<div class="form-group col-md-4">
											   <label>보증금액  </label>
											   
												<input type="text" id="anr_price" value="<?php echo number_format($info3['nr_price'])?>" class="form-control  " placeholder="" readonly>
											</div>
											
											<div class="form-group col-md-4">
											   <label>계약금액  </label>
											   
												<input type="text" id="anr_price_contract" value="<?php echo number_format($info3['nr_price_contract'])?>" class="form-control  " placeholder="" readonly>
											</div>
											<div class="form-group col-md-4">
											   <label>계약일  </label>
											   
												<input type="text" id="anr_contract_date" value="<?php echo $info3['nr_contract_date']?>" class="form-control  " placeholder="" readonly>
											</div>
											<div class="form-group col-md-4">
											   <label>보증일  </label>
											   
												<input type="text" id="anr_date" value="<?php echo $info3['nr_sdate']?> ~ <?php echo $info3['nr_edate']?>" class="form-control  " placeholder="" readonly>
											</div>
											
											
											
										</div>
									</div>
								</div>
								
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										접수내용
									</div>
									<div class="card-body ">
									<?php echo get_view_thumbnail($row['nr_content']); ?>
									</div>
								</div>
								
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										검토내용
									</div>
									<div class="card-body ">
									<?php echo editor_html("nr_content2", get_text(html_purifier($row['nr_content2']), 0)); ?>
									</div>
								</div>
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										처리내용
									</div>
									<div class="card-body ">
									<?php echo editor_html("nr_content3", get_text(html_purifier($row['nr_content3']), 0)); ?>
									</div>
								</div>
								
								
								<?php if($w == 'u') {?>
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										하자사진
									</div>
									<div class="card-body ">
										
										<?php 
										for($i=1; $i<=6; $i++) {
										
											if(!$row['nr_img'.$i]) continue;
											
											switch($i) {
												case 1 :
												$caption = "원거리 1";
												break;
												case 2 :
												$caption = "원거리 2";
												break;
												case 3 :
												$caption = "근거리 1";
												break;
												case 4 :
												$caption = "근거리 2";
												break;
												case 5 :
												$caption = "접사 1";
												break;
												case 6 :
												$caption = "접사 2";
												break;
											}
										?>
										<a href="/_data/repair/<?php echo $row['nw_code']?>/<?php echo $row['nr_img'.$i]?>" class="js-smartPhoto" data-group="1" data-caption="<?php echo $caption?>"><img class="img-responsive" src="/_data/repair/<?php echo $row['nw_code']?>/<?php echo $row['nr_img'.$i]?>" alt="<?php echo $caption?>" style="width:50px;height:50px"></a>
										
										<?php }?>
									</div>
								</div>
								<?php }?>
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										조치사진
									</div>
									<div class="card-body ">
									<div class="form-row ">
										<div class="col-auto">
											<div class="form-group ">
												<input id="fileInput" type="file" data-class-button="btn btn-default" data-class-input="form-control" data-button-text="" data-icon-name="fa fa-upload" class="form-control" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" name="files[]" multiple >
											
												<input type="text" id="userfile" class="form-control" name="userfile" disabled="">
											</div>
										
										</div>
										<div class="col-auto">
											<span class="group-span-filestyle input-group-btn" tabindex="0">
												<label for="fileInput" class="btn btn-default">
													<span class="glyphicon fa fa-upload"></span>
													찾기
												</label>
											</span>
											
										</div>
										<div class="col-auto">
										  <button type="button" id="file_upload_btn" onclick="file_upload()" class="btn btn-primary mb-2">업로드</button>
										</div>
									</div>
									<div class="form-row ">
										<table  class="table table-striped" >
										  <thead>
											<tr>
											  
											  <th scope="col">파일명</th>
											  <th scope="col">용량</th>
											  <th scope="col">미리보기</th>
											  <th scope="col">관리</th>
											</tr>
										  </thead>
										  <tbody id="file_list">
											<tr>
											  <td colspan="4">등록 된 첨부파일이 없습니다.</th>
											  
											</tr>
											
										  </tbody>
										</table>
									</div>
									</div>
								</div>
								
								<div class="m-t-30 align-right">
										<label><input type="checkbox" name="kko" value="1" > 알림톡 전송</label>
										<button type="submit" class="btn btn-primary" style="margin-left:20px"><?php if($w == 'u') echo '수정'; else echo '등록';?>(F8)</button>
										<a href="../list/menu7_list.php" class="btn btn-outline-secondary">취소</a>
										
										<?php if($w == 'u' && $is_admin) {?>
										<a href="./menu7_update.php?w=d&seq=<?php echo $seq?>" onclick="del(this.href); return false" class="btn btn-danger" style="margin-left:20px">삭제</a>
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

<?php include_once(NONE_PATH.'/footer.php');?>
	<script src="https://unpkg.com/smartphoto@1.1.0/js/smartphoto.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
window.addEventListener('DOMContentLoaded',function(){
	new SmartPhoto(".js-smartPhoto");
});

document.onkeyup = function(e) {
	if(e.which == 119) {
		
		if(confirm('저장하시겠습니까?')) {
			document.frm.submit();
		} else {
			return false;
		}
	}
}
function chkfrm(f) {

	
	<?php echo get_editor_js("nr_content2"); ?>
	<?php echo get_editor_js("nr_content3"); ?>
	
	return true;
}


//파일배열
var filesTempArr = [];

//파일 업로드 처리
function file_upload() {
	var formData = new FormData();
	
	for(var i=0, filesTempArrLen = filesTempArr.length; i<filesTempArrLen; i++) {
	   formData.append("files[]", filesTempArr[i]);
	}
	
	<?php if($w == 'u') {?>
	formData.append("uid", <?php echo $seq?>); //유니크ID
	<?php } else {?>
	formData.append("uid", $('#uid').val()); //유니크ID
	<?php }?>
	//formData.append("category", $('#category').val()); //파일분류
	
	$('#file_upload_btn').html('업로드 처리중..');
	
	$.ajax({
		type : "POST",
		url : "/_ajax/file_upload11.php",
		data : formData,
		processData: false,
		contentType: false,
		success : function(data) {
			//파일업로드 완료 처리 로직
			if(data == "no") {
				alert('업로드에 실패하였습니다.\n파일이 없거나 업로드가 불가능한 확장자 또는 용량입니다.');
			} else {
				$('#userfile').val('');
				//다시 빈배열로
				filesTempArr = [];
				file_list(); // 업로드 된 파일목록 리스팅
			}

			$('#file_upload_btn').html('업로드');			
		},
		err : function(err) {
			alert(err.status);
		}
	});

	
}

// 파일을 배열에 추가
function addFiles(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var filesArrLen = filesArr.length;
    var filesTempArrLen = filesTempArr.length;
    for( var i=0; i<filesArrLen; i++ ) {
        filesTempArr.push(filesArr[i]);
        //$("#fileList").append("<div>" + filesArr[i].name + "<img src=\"/images/deleteImage.png\" onclick=\"deleteFile(event, " + (filesTempArrLen+i)+ ");\"></div>");
    }
	$('#userfile').val(filesArrLen+'개 파일 첨부됨');
	
    $(this).val('');
}

//파일첨부시 파일추가 함수 실행.
$("#fileInput").on('change', addFiles);
	
//업로드 파일목록
function file_list() {
	
	<?php if($w == '') {?>
	var id = $('#uid').val();
	<?php } else {?>
	var id = <?php echo $seq?>
	<?php }?>
	
	$.post('/_ajax/file_listup11.php', { id : id, w : '<?php echo $w?>' }, function(data) {
		
		$('#file_list').html(data);
		
	});
	
}

file_list();


$(function() {
	
	//보증서 연동
	$('#nr_assurance').bind('change', function() {
		var id = $(this).val();
		$('#anr_num').val('');
		$('#anr_price').val('');
		$('#anr_price_contract').val('');
		$('#anr_contract_date').val('');
		$('#anr_date').val('');
		$.ajax({ 
			type: "POST", 
			url : "./ajax.menu7.assurance.php", 
			data:{ seq: id },
			dataType:"json", 
			success : function(data, status, xhr) { 
				$('#anr_num').val(data.nr_num);
				$('#anr_price').val(number_format(data.nr_price));
				$('#anr_price_contract').val(number_format(data.nr_price_contract));
				$('#anr_contract_date').val(data.nr_contract_date);
				$('#anr_date').val(data.nr_sdate +"~"+ data.nr_edate);
			}, error: function(jqXHR, textStatus, errorThrown) { 
				console.log(jqXHR.responseText); 
			} 
		});
	})
	
	$('#nr_bname').bind('change', function() {
		var id = $(this).val();
		$.ajax({ 
			type: "POST", 
			url : "./ajax.menu7.php", 
			data:{mode:"company", seq: id },
			dataType:"json", 
			success : function(data, status, xhr) { 
				$('#ns_gongjong').val(data.ns_gongjong);
				$('#ns_btel').val(data.ns_btel);
				$('#ns_manager').val(data.ns_manager);
				$('#ns_manager_tel').val(data.ns_manager_tel);
			}, error: function(jqXHR, textStatus, errorThrown) { 
				console.log(jqXHR.responseText); 
			} 
		});
	})
	
	$('#nr_manager').bind('change', function() {
		var id = $(this).val();
		$.ajax({ 
			type: "POST", 
			url : "./ajax.menu7.php", 
			data:{mode:"manager", mb_id: id },
			dataType:"json", 
			success : function(data, status, xhr) { 
				$('#nr_manager_tel').val(data.mb_hp);
				
			}, error: function(jqXHR, textStatus, errorThrown) { 
				console.log(jqXHR.responseText); 
			} 
		});
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
