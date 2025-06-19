<?php 
include_once('../../_common.php');
define('menu_owner', true);
include_once(NONE_PATH.'/header.php'); 


if($w == 'u') {
	
	$row = sql_fetch("select * from {$none['owner_list']} where seq = '$seq'");
	
	
}

?>
<!--시공현장 작성-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> 건축주</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">건축주</li>
                            <li class="breadcrumb-item active">건축주 정보등록</li>
                        </ul>
                    </div>            
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="frm" action="./menu1_update.php" enctype="multipart/form-data" method="post">
								
								<input type="hidden" name="w" id="w" value="<?php echo $w?>">
								<input type="hidden" name="seq" id="seq" value="<?php echo $seq?>">
								<input type="hidden" name="uid" id="uid" value="<?php echo get_uniqid()?>">
								<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										아이디 연결(최대3개)
									</div>
									<div class="card-body ">
									<div class="form-row">
									
										<div class="form-group col-md-2">
										  <label>연결아아디 1번</label>
										  <input type="text" name="no_id_1" class="form-control" value="<?php echo $row['no_id_1']?>" placeholder="">
										  
										</div>
										<div class="form-group col-md-2">
										  <label>연결아아디 2번</label>
										  <input type="text" name="no_id_2" class="form-control" value="<?php echo $row['no_id_2']?>"  placeholder="">
										  
										</div>
										<div class="form-group col-md-2">
										  <label>연결아아디 3번</label>
										  <input type="text" name="no_id_3" class="form-control" value="<?php echo $row['no_id_3']?>"  placeholder="">
										  
										</div>
									</div>
									</div>
								</div>
								
								
								
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										건축주 기본정보
									</div>
									<div class="card-body ">
									
                                <div class="form-row">
									<div class="form-group col-md-6">
									  <label>법인명</label>
									  <input type="text" name="no_company"  value="<?php echo $row['no_company']?>" class="form-control" placeholder="법인명">
									</div>
									<div class="form-group col-md-6">
										<label>사업자등록번호</label>
									    <input type="text" name="no_bnum"  value="<?php echo $row['no_bnum']?>" class="form-control" placeholder="사업자등록번호">
									</div>
								</div>
                               	
                                <div class="form-row">
									<div class="form-group col-md-6">
									  <label>법인주소</label>
									  <input type="text" name="no_baddr"  value="<?php echo $row['no_baddr']?>" class="form-control" placeholder="법인주소">
									</div>
									<div class="form-group col-md-6">
										<label>법인 이메일</label>
									    <input type="email" name="no_bemail"  value="<?php echo $row['no_bemail']?>" class="form-control" placeholder="sample@naver.com">
									</div>
								</div>
                                <div class="form-row">
									<div class="form-group col-md-6">
									  <label>성명</label>
									  <input type="text" name="no_name"  value="<?php echo $row['no_name']?>" class="form-control" placeholder="성명">
									</div>
									<div class="form-group col-md-6">
										<label>주민번호</label>
									    <input type="text" name="no_jumin"  value="<?php echo $row['no_jumin']?>" class="form-control" placeholder="주민번호">
									</div>
								</div>
                                <div class="form-row">
									<div class="form-group col-md-6">
									  <label>연락처</label>
									  <input type="text" name="no_tel"  value="<?php echo $row['no_tel']?>" class="form-control" placeholder="연락처">
									</div>
									<div class="form-group col-md-6">
										<label>휴대전화</label>
									    <input type="text" name="no_hp"  value="<?php echo $row['no_hp']?>" class="form-control" placeholder="휴대전화">
									</div>
								</div>
                                <div class="form-row">
									<div class="form-group col-md-6">
									  <label>이메일</label>
									  <input type="email" name="no_email"  value="<?php echo $row['no_email']?>" class="form-control" placeholder="이메일">
									</div>
									<div class="form-group col-md-6">
										<label>주소</label>
									    <input type="text" name="no_addr"  value="<?php echo $row['no_addr']?>" class="form-control" placeholder="주소">
									</div>
								</div>
                                <div class="form-row">
									<div class="form-group col-md-12">
									  <label>메모</label>
									   <textarea name="no_memo" class="form-control" rows="3"><?php echo $row['no_memo']?></textarea>
									</div>
									
								</div>
								
								
								</div>
								
								</div>
								<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										도급서류 첨부
									</div>
									<div class="card-body ">
									
								
									  <div class="form-row ">
										<div class="col-auto">
											
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
												<label class="input-group-text" for="inputGroupSelect01">파일 분류</label>
											  </div>
											  <select name="category" id="category" class="custom-select " id="inputGroupSelect01">

												<option value="사업자등록증">사업자등록증</option>
												<option value="건축주정보">건축주정보</option>
											
												</select>
											</div>
										</div>
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
												  <th scope="col">파일분류</th>
												  <th scope="col">파일명</th>
												  <th scope="col">용량</th>
												  <th scope="col">다운</th>
												  <th scope="col">관리</th>
												</tr>
											  </thead>
											  <tbody id="file_list">
												<tr>
												  <td colspan="5">등록 된 첨부파일이 없습니다.</th>
												  
												</tr>
												
											  </tbody>
											</table>
										</div>
										
									</div>
									
									
									
									</div>
								
								<div class="m-t-30 align-right">
										
										<button type="submit" class="btn btn-primary" style="margin-left:20px"><?php if($w == 'u') echo '수정'; else echo '등록';?>(F8)</button>
										<a href="../list/menu1_list.php" class="btn btn-outline-secondary">취소</a>
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
	formData.append("category", $('#category').val()); //파일분류
	
	$('#file_upload_btn').html('업로드 처리중..');
	
	$.ajax({
		type : "POST",
		url : "/_ajax/file_upload9.php",
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


//업로드 파일목록
function file_list() {
	
	<?php if($w == '') {?>
	var id = $('#uid').val();
	<?php } else {?>
	var id = <?php echo $seq?>
	<?php }?>
	
	$.post('/_ajax/file_listup9.php', { id : id, w : '<?php echo $w?>' }, function(data) {
		$('#file_list').html(data);
	});
	
}
$(function() {
	
	//파일첨부시 파일추가 함수 실행.
	$("#fileInput").on('change', addFiles);
	
	
	<?php if($w == 'u') {?>
	//수정모드 일 경우 파일목록 불러옴.
	file_list();
	<?php }?>
	
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
