<?php 
include_once('../../_common.php');
define('menu_homepage', true);
include_once(NONE_PATH.'/header.php'); 

if($member['mb_level2'] == 3) $is_admin = true; 

include_once(G5_EDITOR_LIB);

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
if($w == 'u') {
	
	$row = sql_fetch("select * from {$g5['member_table']} where mb_id = '$mb_id'");
	
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> 회원관리</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">홈페이지관리</li>
                            <li class="breadcrumb-item active">회원관리</li>
                        </ul>
                    </div>            
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="frm" action="./menu1_update.php" enctype="multipart/form-data" method="post" onsubmit="return chkfrm(this)">
								<input type="hidden" name="uid" id="uid" value="<?php echo get_uniqid()?>">
								<input type="hidden" name="w" value="<?php echo $w?>">
								<input type="hidden" name="seq" value="<?php echo $seq?>">
								
								<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										기본 회원정보
									</div>
									<div class="card-body ">
									<div class="form-row">
										<div class="form-group col-md-6">
										  <label>아이디</label>
										 
										  <input type="text" name="mb_id" class="form-control" value="<?php echo $row['mb_id']?>" placeholder=""  <?php if($w == 'u') {?>readonly<?php }?>>
										  
										</div>
										<div class="form-group col-md-6">
											<label for="inputPassword4">비밀번호</label>
											<input type="password" name="mb_password" value="" class="form-control  " placeholder="" >
										</div>
										
									</div>
									
									<div class="form-row">
										<div class="form-group col-md-4">
										   <label>이름  </label>
										   <div class="input-group">
											  <input type="text" name="mb_name" value="<?php echo $row['mb_name']?>"   class="form-control " placeholder="" >
											</div>
										</div>
										<div class="form-group col-md-4">
										   <label>연락처  </label>
										   <div class="input-group">
											
											  <input type="text" name="mb_hp" value="<?php echo $row['mb_hp']?>" class="form-control  " placeholder="" >
											  </div>
										</div>
										
										<div class="form-group col-md-4">
										   <label>이메일  </label>
										   <div class="input-group">
											
											  <input type="email" name="mb_email" value="<?php echo $row['mb_email']?>" class="form-control  " placeholder="" >
											  </div>
										</div>
										
										
									</div>
									</div>
								</div>
								
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										기타
									</div>
									<div class="card-body ">
										<div class="form-row ">
											<div class="form-group col-md-3">
											   <label>가입일시  </label>
											   <div class="input-group">
												
												  <input type="text" value="<?php echo $row['mb_datetime']?>" class="form-control  " placeholder="" readonly>
												  </div>
											</div>
											
											<div class="form-group col-md-3">
											   <label>가입IP  </label>
											   <div class="input-group">
												
												  <input type="text" value="<?php echo $row['mb_ip']?>" class="form-control  " placeholder="" readonly>
												  </div>
											</div>
											<div class="form-group col-md-3">
											   <label>마지막 로그인  </label>
											   <div class="input-group">
												
												  <input type="text" value="<?php echo $row['mb_today_login']?>" class="form-control  " placeholder="" readonly>
												  </div>
											</div>
											<div class="form-group col-md-3">
											   <label>탈퇴일자  </label>
											   <div class="input-group">
												
												  <input type="text" name="mb_leave_date" value="<?php echo $row['mb_leave_date']?>" class="form-control  " placeholder="YYYYMMDD">
												  </div>
											</div>
											
											
										</div>
										
							
									</div>
								</div>
								<div class="m-t-30 align-right">
									<button type="submit" class="btn btn-primary" style="margin-left:20px"><?php if($w == 'u') echo '수정(F8)'; else echo '등록(F8)';?></button>
									<a href="../list/menu1_list.php" class="btn btn-outline-secondary">목록</a>
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
