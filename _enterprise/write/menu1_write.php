<?php 
include_once('../../_common.php');
define('menu_enterprise', true);
include_once(NONE_PATH.'/header.php'); 


if($w == 'u') {
	$row = sql_fetch("select * from {$none['enterprise_list']} where seq = '$seq'");
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
</style>

<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> 업체관리</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">업체관리</li>
                            <li class="breadcrumb-item active">업체 정보등록</li>
                        </ul>
                    </div>            
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="frm" action="./menu1_update.php" enctype="multipart/form-data" method="post" onsubmit="return chk_frm(this)">
								
								<input type="hidden" name="bnum_chk" id="bnum_chk" value="0">
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
										업체 기본정보
									</div>
									<div class="card-body ">
									
									<div class="form-row">
										<div class="form-group col-md-6">
										  <label>업체명 <span class="bname_chk_txt badge badge-danger" style="font-size:13px"></span></label>
										  <input type="text" name="no_company"  value="<?php echo $row['no_company']?>" class="form-control" placeholder="업체명" onblur="chk_bname(this.value)">
										</div>
										<div class="form-group col-md-6">
											<label>사업자번호 <span class="bnum_chk_txt badge badge-danger" style="font-size:13px"></span></label>
											<input type="text" name="no_bnum" id="no_bnum" value="<?php echo $row['no_bnum']?>" class="form-control" placeholder="사업자번호" onblur="chk_bnum(this.value)">
										</div>
									</div>
                               	
									<div class="form-row">
										<div class="form-group col-md-6">
										  <label>구분</label>
										  <select name="no_category" class="form-control">
											<option value="시공사" <?php echo get_selected($row['no_category'], '시공사')?>>시공사</option>
											<option value="자재사" <?php echo get_selected($row['no_category'], '자재사')?>>자재사</option>
											<option value="건축사사무소" <?php echo get_selected($row['no_category'], '건축사사무소')?>>건축사사무소</option>
											<option value="장비업체" <?php echo get_selected($row['no_category'], '장비업체')?>>장비업체</option>
											<option value="기타" <?php echo get_selected($row['no_category'], '기타')?>>기타</option>
											
										  </select>
										</div>
										<div class="form-group col-md-6">
											<label>공종</label>
											<select name="no_gongjong"  class="form-control select2">
												<option value="">선택하세요</option>
												<option value="가설공사" <?php echo get_selected($row['no_gongjong'], '가설공사')?>>가설공사</option>
												<option value="가시설공사" <?php echo get_selected($row['no_gongjong'], '가시설공사')?>>가시설공사</option>
												<option value="토공사" <?php echo get_selected($row['no_gongjong'], '토공사')?>>토공사</option>
												<option value="철근콘크리트공사" <?php echo get_selected($row['no_gongjong'], '철근콘크리트공사')?>>철근콘크리트공사</option>
												<option value="철골공사" <?php echo get_selected($row['no_gongjong'], '철골공사')?>>철골공사</option>
												<option value="조적공사" <?php echo get_selected($row['no_gongjong'], '조적공사')?>>조적공사</option>
												<option value="방수공사" <?php echo get_selected($row['no_gongjong'], '방수공사')?>>방수공사</option>
												<option value="타일공사" <?php echo get_selected($row['no_gongjong'], '타일공사')?>>타일공사</option>
												<option value="석공사" <?php echo get_selected($row['no_gongjong'], '석공사')?>>석공사</option>
												<option value="목공사" <?php echo get_selected($row['no_gongjong'], '목공사')?>>목공사</option>
												<option value="금속공사" <?php echo get_selected($row['no_gongjong'], '금속공사')?>>금속공사</option>
												<option value="미장공사" <?php echo get_selected($row['no_gongjong'], '미장공사')?>>미장공사</option>
												<option value="창호공사" <?php echo get_selected($row['no_gongjong'], '창호공사')?>>창호공사</option>
												<option value="유리공사" <?php echo get_selected($row['no_gongjong'], '유리공사')?>>유리공사</option>
												<option value="도장공사" <?php echo get_selected($row['no_gongjong'], '도장공사')?>>도장공사</option>
												<option value="수장공사" <?php echo get_selected($row['no_gongjong'], '수장공사')?>>수장공사</option>
												<option value="지붕및홈통공사" <?php echo get_selected($row['no_gongjong'], '지붕및홈통공사')?>>지붕및홈통공사</option>
												<option value="판넬공사" <?php echo get_selected($row['no_gongjong'], '판넬공사')?>>판넬공사</option>
												<option value="기타공사" <?php echo get_selected($row['no_gongjong'], '기타공사')?>>기타공사</option>
												<option value="부대공사" <?php echo get_selected($row['no_gongjong'], '부대공사')?>>부대공사</option>
												<option value="조경공사" <?php echo get_selected($row['no_gongjong'], '조경공사')?>>조경공사</option>
												<option value="철거공사" <?php echo get_selected($row['no_gongjong'], '철거공사')?>>철거공사</option>
												<option value="인테리어공사" <?php echo get_selected($row['no_gongjong'], '인테리어공사')?>>인테리어공사</option>
												<option value="설비공사" <?php echo get_selected($row['no_gongjong'], '설비공사')?>>설비공사</option>
												<option value="전기공사" <?php echo get_selected($row['no_gongjong'], '전기공사')?>>전기공사</option>
												<option value="폐기물처리" <?php echo get_selected($row['no_gongjong'], '폐기물처리')?>>폐기물처리</option>
												<option value="엘리베이터" <?php echo get_selected($row['no_gongjong'], '엘리베이터')?>>엘리베이터</option>
												<option value="철근" <?php echo get_selected($row['no_gongjong'], '철근')?>>철근</option>
												<option value="레미콘" <?php echo get_selected($row['no_gongjong'], '레미콘')?>>레미콘</option>
												<option value="단열재" <?php echo get_selected($row['no_gongjong'], '단열재')?>>단열재</option>
												<option value="운반" <?php echo get_selected($row['no_gongjong'], '운반')?>>운반</option>
												<option value="장비업체" <?php echo get_selected($row['no_gongjong'], '장비업체')?>>장비업체</option>
												<option value="용역업체" <?php echo get_selected($row['no_gongjong'], '용역업체')?>>용역업체</option>
												<option value="건축사사무소" <?php echo get_selected($row['no_gongjong'], '건축사사무소')?>>건축사사무소</option>
												<option value="철자재" <?php echo get_selected($row['no_gongjong'], '철자재')?>>철자재</option>
												<option value="잡자재" <?php echo get_selected($row['no_gongjong'], '잡자재')?>>잡자재</option>
												<option value="조명" <?php echo get_selected($row['no_gongjong'], '조명')?>>조명</option>
												<option value="가구공사" <?php echo get_selected($row['no_gongjong'], '가구공사')?>>가구공사</option>
												<option value="기술지도" <?php echo get_selected($row['no_gongjong'], '기술지도')?>>기술지도</option>
											</select>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label>대표자</label>
											<input type="text" name="no_bname"  value="<?php echo $row['no_bname']?>" class="form-control" placeholder="대표자">
										</div>
										<div class="form-group col-md-6">
										  <label>대표번호</label>
										  <input type="text" name="no_btel"  value="<?php echo $row['no_btel']?>" class="form-control" placeholder="대표번호">
										</div>
										
									</div>
									
									<div class="form-row">
										<div class="form-group col-md-6">
											<label>팩스번호</label>
											<input type="text" name="no_bfax"  value="<?php echo $row['no_bfax']?>" class="form-control" placeholder="팩스번호">
										</div>
										<div class="form-group col-md-6">
										  <label>이메일</label>
										  <input type="email" name="no_bemail"  value="<?php echo $row['no_bemail']?>" class="form-control" placeholder="sample@naver.com">
										</div>
										
									</div>
									
									<div class="form-row">
										<div class="form-group col-md-6">
										  <label>주소</label>
										  <input type="text" name="no_baddr"  value="<?php echo $row['no_baddr']?>" class="form-control" placeholder="주소">
										</div>
										<div class="form-group col-md-6">
											<label>홈페이지</label>
											<input type="text" name="no_homepage"  value="<?php echo $row['no_homepage']?>" class="form-control" placeholder="홈페이지 주소">
										</div>
										
									</div>
									
									
								
								
								</div>
								</div>
								
								
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										계좌 정보
									</div>
									<div class="card-body ">
										<div class="form-row">
											<div class="form-group col-md-3">
											  <label>은행명</label>
											  <select name="no_bank" class="form-control select2" >
													<option value="">은행명을 선택하세요</option>
													<option value="경남은행" <?php echo get_selected($row['no_bank'], '경남은행')?>>경남은행</option>
													<option value="광주은행" <?php echo get_selected($row['no_bank'], '광주은행')?>>광주은행</option>
													<option value="국민은행" <?php echo get_selected($row['no_bank'], '국민은행')?>>국민은행</option>
													<option value="기업은행" <?php echo get_selected($row['no_bank'], '기업은행')?>>기업은행</option>
													<option value="농협중앙회" <?php echo get_selected($row['no_bank'], '농협중앙회')?>>농협중앙회</option>
													<option value="농협회원조합" <?php echo get_selected($row['no_bank'], '농협회원조합')?>>농협회원조합</option>
													<option value="대구은행" <?php echo get_selected($row['no_bank'], '대구은행')?>>대구은행</option>
													<option value="도이치은행" <?php echo get_selected($row['no_bank'], '도이치은행')?>>도이치은행</option>
													<option value="부산은행" <?php echo get_selected($row['no_bank'], '부산은행')?>>부산은행</option>
													<option value="산업은행" <?php echo get_selected($row['no_bank'], '산업은행')?>>산업은행</option>
													<option value="상호저축은행" <?php echo get_selected($row['no_bank'], '상호저축은행')?>>상호저축은행</option>
													<option value="새마을금고" <?php echo get_selected($row['no_bank'], '새마을금고')?>>새마을금고</option>
													<option value="수협중앙회" <?php echo get_selected($row['no_bank'], '수협중앙회')?>>수협중앙회</option>
													<option value="신한금융투자" <?php echo get_selected($row['no_bank'], '신한금융투자')?>>신한금융투자</option>
													<option value="신한은행" <?php echo get_selected($row['no_bank'], '신한은행')?>>신한은행</option>
													<option value="신협중앙회" <?php echo get_selected($row['no_bank'], '신협중앙회')?>>신협중앙회</option>
													<option value="외환은행" <?php echo get_selected($row['no_bank'], '외환은행')?>>외환은행</option>
													<option value="우리은행" <?php echo get_selected($row['no_bank'], '우리은행')?>>우리은행</option>
													<option value="우체국" <?php echo get_selected($row['no_bank'], '우체국')?>>우체국</option>
													<option value="전북은행" <?php echo get_selected($row['no_bank'], '전북은행')?>>전북은행</option>
													<option value="제주은행" <?php echo get_selected($row['no_bank'], '제주은행')?>>제주은행</option>
													<option value="카카오뱅크" <?php echo get_selected($row['no_bank'], '카카오뱅크')?>>카카오뱅크</option>
													<option value="케이뱅크" <?php echo get_selected($row['no_bank'], '케이뱅크')?>>케이뱅크</option>
													<option value="하나은행" <?php echo get_selected($row['no_bank'], '하나은행')?>>하나은행</option>
													<option value="한국씨티은행" <?php echo get_selected($row['no_bank'], '한국씨티은행')?>>한국씨티은행</option>
													<option value="HSBC은행" <?php echo get_selected($row['no_bank'], 'HSBC은행')?>>HSBC은행</option>
													<option value="SC제일은행" <?php echo get_selected($row['no_bank'], 'SC제일은행')?>>SC제일은행</option>
										  </select>
											</div>
											<div class="form-group col-md-3">
											  <label>예금주</label>
											  <input type="text" name="no_acc_holder"  value="<?php echo $row['no_acc_holder']?>" class="form-control" placeholder="예금주">
											</div>
											<div class="form-group col-md-6">
											  <label>계좌번호</label>
											  <input type="text" name="no_account"  value="<?php echo $row['no_account']?>" class="form-control" placeholder="계좌번호">
											</div>
										</div>
										
								
								</div>
								</div>
								
								<div class="card border mb-3">
									<div class="card-header " style="font-weight:500">
										담당자 정보
									</div>
									<div class="card-body ">
										<div class="form-row">
											<div class="form-group col-md-6">
											  <label>성명</label>
											  <input type="text" name="no_name"  value="<?php echo $row['no_name']?>" class="form-control" placeholder="성명">
											</div>
											<div class="form-group col-md-6">
											  <label>이메일</label>
											  <input type="email" name="no_email"  value="<?php echo $row['no_email']?>" class="form-control" placeholder="이메일">
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
											  <label>직급</label>
											  <input type="text" name="no_position"  value="<?php echo $row['no_position']?>" class="form-control" placeholder="직급">
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
										서류 첨부
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
												<option value="통장사본">통장사본</option>
												<option value="면허수첩">면허수첩</option>
												<option value="건설업면허증">건설업면허증</option>
												<option value="국세">국세</option>
												<option value="지방세">지방세</option>
												<option value="법인인감증명서">법인인감증명서</option>
												<option value="사용인감계">사용인감계</option>
												<option value="등기부등본">등기부등본</option>
												<option value="기타서류">기타서류</option>
												
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
	 $('.select2').select2({
		  language: {
			noResults: function (params) {
			  return "검색 결과가 없습니다.";
			}
		  }
	 });
})
function chk_bnum (v) {
	
	if(v) {
		
		$.post('./chk_bnum.php', {num : v }, function(data) {
			
			if(data == 'y') {
				$('.bnum_chk_txt').html('중복 된 사업자 번호').removeClass('badge-success').addClass('badge-danger');
				$('#bnum_chk').val('1');
				
				return false;
			} else {
				$('.bnum_chk_txt').html('등록가능').removeClass('badge-danger').addClass('badge-success');
				$('#bnum_chk').val('0');
				
				return false;
			}
			
		})
		
	}
	return false;
	
}
function chk_bname (v) {
	
	if(v) {
		
		$.post('./chk_bname.php', { name : v }, function(data) {
			
			if(data == 'y') {
				
				$('.bname_chk_txt').html('중복 된 업체명').removeClass('badge-success').addClass('badge-danger');
			
				
				return false;
			} else {
				$('.bname_chk_txt').html('신규등록').removeClass('badge-danger').addClass('badge-success');
				
				return false;
			}
			
		})
		
	}
	return false;
	
}

function chk_frm(f) {
	
	if(f.bnum_chk.value == 1) {
		
		alert('사업자등록번호가 중복되어 등록할 수 없습니다.');
		return false;
	}
	
	
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
	formData.append("category", $('#category').val()); //파일분류
	
	$('#file_upload_btn').html('업로드 처리중..');
	
	$.ajax({
		type : "POST",
		url : "/_ajax/file_upload10.php",
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
	
	$.post('/_ajax/file_listup10.php', { id : id, w : '<?php echo $w?>' }, function(data) {
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
