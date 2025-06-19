<?php 
include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php'); 

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if($member['mb_level2'] == 3) $is_admin = true; 

include_once(G5_EDITOR_LIB);
if($w == '') {
	
	$mb['mb_name'] = $member['mb_name'];
	
	$signline = sql_fetch("select * from {$none['sign_line']} where seq = 1");
	$date = date('Y-m-d');
	$ns_docnum = '<span style="color:#ccc">작성 후 자동생성</span>';
} else if($w == 'u') {
	
	$row = sql_fetch("select * from {$none['sign_draft']} where seq = '$seq'");
	$mb = get_member($row['mb_id']);
	$date = date('Y-m-d', strtotime($row['ns_date']));
	$ns_docnum = $row['ns_docnum'];
}
?>
<script src="/core/js/jquery-1.8.3.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2 { width:100% !important }
.select2-container .select2-selection--single {  height:36px }
.select2-container--default .select2-selection--single { border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px }
.price_txt { font-size:13px }
.w100 { width:100px }
.sign_table { width:100% }
.sign_table th, td { border-left:0;  }
.sign_table thead td { background:#f2f2f2; width:100px;text-align:center; border-left:0 !important}
.sign_table tbody td { height:155px; border-bottom:0 !important;text-align:center; border-left:0 !important;}
.add_table {width:100%}
#tag-list { list-style:none; margin:0; padding:0}
#tag-list li {float:left; margin-right:10px; border:1px solid #ccc; background:#f2f2f2; padding:7px 10px;margin-top:3px }
#tag-list .del-btn { padding-left:10px; font-size:15px; font-weight:600; cursor:pointer }
</style>
<!--현장별매출현황-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>전자결재</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">전자결재</li>
				<li class="breadcrumb-item active">기안서</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<?php if($w=='u') {?>
						<h1 class="text-center" style="margin-top:25px">기&nbsp;&nbsp;안&nbsp;&nbsp; 서</h1>
						<?php }?>
					
						<form name="frm" action="./menu1_update.php" enctype="multipart/form-data" method="post" onsubmit="return chkfrm(this)">
							<input type="hidden" name="uid" id="uid" value="<?php echo get_uniqid()?>">
							<input type="hidden" name="w" value="<?php echo $w?>">
							<input type="hidden" name="seq" value="<?php echo $seq?>">
                        <div class="body project_report">
						
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
									<tbody>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="w100 font-weight-bold">문서번호</td>
                                            <td style="border-top:1px solid #ccc;width:400px;"><?php echo $ns_docnum?></td>
                                            <td rowspan="4" style="background:#f2f2f2;border-top:1px solid #ccc" class="w100 font-weight-bold text-center">결재</td>
                                            <td rowspan="4" style="border-top:1px solid #ccc;padding:0;vertical-align:top">
											
											<?php if($w == '') {?>
											<table class="sign_table">
												<thead>
													<tr>
														<td>담당자</td>
														<?php 
														for($i=1; $i<=5; $i++) {
															
															if(!$signline['ns_id'.$i]) continue;
															$ns_member_info = get_member($signline['ns_id'.$i], 'mb_name, mb_3');
														
														?>
														<td><?php echo $ns_member_info['mb_name']?> <?php echo get_mposition_txt($ns_member_info['mb_3'])?></td>
														<?php }?>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><?php echo $mb['mb_name']?></td>
														<?php 
														$sign_cnt = 0;
														for($i=1; $i<=5; $i++) {
															
															if(!$signline['ns_id'.$i]) continue;
															$sign_cnt++;
														
														?>
														<td><input type="hidden" name="ns_id<?php echo $i?>" value="<?php echo $signline['ns_id'.$i]?>"> </td>
														<?php }?>
													</tr>
												</tbody>
											</table>
											<input type="hidden" name="sign_cnt" value="<?php echo $sign_cnt?>">
											<?php } else if($w == 'u'){?>
											<table class="sign_table">
												<thead>
													<tr>
														<td>담당자</td>
														<?php 
														for($i=1; $i<=5; $i++) {
															
															if(!$row['ns_id'.$i]) continue;
															$ns_member_info = get_member($row['ns_id'.$i], 'mb_name, mb_3');
														
														?>
														<td><?php echo $ns_member_info['mb_name']?> <?php echo get_mposition_txt($ns_member_info['mb_3'])?></td>
														<?php }?>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
														<?php 
														if(!$row['ns_id0_stat']) {
															
															echo '<a href="#none" onclick="proc_(\'결재\', 0)" class=" btn-primary btn-sm">결재</a> ';
															echo '<a href="#none" onclick="proc_(\'전결\', 0)"  class=" btn-primary btn-sm">전결</a> ';
															echo '<a href="#none"  onclick="proc_(\'반려\', 0)" class=" btn-danger btn-sm">반려</a>';
														} else if($row['ns_id0_stat']){
															$mb_dir = substr($row['mb_id'],0,2);
															$sign_file = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$row['mb_id'].'_sign.gif';
															
															
															$state = explode('|', $row['ns_id0_stat']);
															
															echo '<img src="'.G5_DATA_URL.'/member/'.$mb_dir.'/'.$row['mb_id'].'_sign.gif" style="width:60px;height:60px">';
															
															echo '<br>'.$state[0].'<br>'.date('y-m-d H:i', strtotime($state[1]));
															
															
														}
														?>
														
														
														</td>
														<?php 
														for($i=1; $i<=5; $i++) {
															
															if(!$row['ns_id'.$i]) continue;
														
														
														?>
														<td><input type="hidden" name="ns_id<?php echo $i?>" value="<?php echo $row['ns_id'.$i]?>"> 
														
														<?php if(!$row['ns_id'.$i.'_stat']) {
															
															if($member['mb_id'] == $row['ns_id'.$i]) {
														
																echo '<a href="#none" onclick="proc_(\'결재\', '.$i.')" class=" btn-primary btn-sm">결재</a> ';
																echo '<a href="#none" onclick="proc_(\'전결\', '.$i.')"  class=" btn-primary btn-sm">전결</a> ';
																echo '<a href="#none"  onclick="proc_(\'반려\', '.$i.')" class=" btn-danger btn-sm">반려</a>';
														
															}
														
														} else if($row['ns_id'.$i.'_stat']) {
															$mb_dir = substr($row['ns_id'.$i],0,2);
															$sign_file = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$row['ns_id'.$i].'_sign.gif';
															
															
															$state = explode('|', $row['ns_id'.$i.'_stat']);
															
															echo '<img src="'.G5_DATA_URL.'/member/'.$mb_dir.'/'.$row['ns_id'.$i].'_sign.gif" style="width:60px;height:60px">';
															
															echo '<br>'.$state[0].'<br>'.date('y-m-d H:i', strtotime($state[1]));
															
															}?>
														</td>
														<?php }?>
													</tr>
												</tbody>
											</table>
											<?php }?>
											</td>
                                        </tr>
                                        <tr >
                                           <td style="background:#f2f2f2;border-top:1px solid #ccc" class="w100 font-weight-bold">기안자</td>
                                            <td style="border-top:1px solid #ccc;width:400px;"><?php echo $mb['mb_name']?></td>
                                        </tr>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">기안일</td>
                                            <td style="border-top:1px solid #ccc"><?php echo $date?></td>
                                        </tr>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">보존기간</td>
                                            <td style="border-top:1px solid #ccc">5년</td>
                                        </tr>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">중요도</td>
                                            <td style="border-top:1px solid #ccc">
											<?php echo $row['ns_importance']?>
											</td>
                                        </tr>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">참조자</td>
                                            <td style="border-top:1px solid #ccc" colspan="3">
											<?php echo get_mb_name($row['ns_cc'])?>
											</td>
                                           
                                        </tr>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">기안부서 및 현장</td>
                                            <td style="border-top:1px solid #ccc" colspan="3">
												<?php echo $row['ns_team']?>
											</td>
                                           
                                        </tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">제목</td>
                                            <td style="border-top:1px solid #ccc" colspan="3">
												<?php echo $row['ns_subject']?>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">공정선택</td>
                                            <td style="border-top:1px solid #ccc" colspan="3">
												<?php echo $row['ns_gongjung']?>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">도급금액</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											<div class="input-group" style="width:300px !important">
											<?php echo number_format($row['ns_price'])?>원
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">견적업체정보</td>
                                            <td style="border-top:1px solid #ccc;vertical-align:top" colspan="3" >
												
												<table class="add_table">
													<thead style="background:#f2f2f2;">
														<tr>
															<td>업체명</td>
															<td>견적금액</td>
															<td>확정금액</td>
															<td >현설일자</td>
															<td >공사투입일</td>
															<td>대표전화</td>
															<td>담당자</td>
															<td>핸드폰</td>
															<td>비고</td>
														</tr>
													</thead>
													<tbody id="add_partner">
													
														<?php if($w == 'u') {
															
															$ns_company = explode('||', $row['ns_company']);
															
															for($i=0; $i<count($ns_company); $i++) {
																
																$ns_company_arr = explode('^', $ns_company[$i]);
														?>
															<tr>
																<td><?php echo $ns_company_arr[0]?></td>
																<td class="text-right"><?php echo number_format($ns_company_arr[1])?></td>
																<td class="text-right"><?php echo number_format($ns_company_arr[2])?></td>
																<td><?php echo $ns_company_arr[3]?></td>
																<td><?php echo $ns_company_arr[4]?></td>
																<td><?php echo $ns_company_arr[5]?></td>
																<td><?php echo $ns_company_arr[6]?></td>
																<td><?php echo $ns_company_arr[7]?></td>
																<td><?php echo $ns_company_arr[8]?></td>
																
															</tr>
														
														
														<?php 
															}
														}?>
													</tbody>
												</table>
												
											</td>
										</tr>
										
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">외주비</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											<div class="input-group" style="width:300px !important">
												<?php echo number_format($row['ns_price2'])?>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">자재비</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											<?php echo number_format($row['ns_price3'])?>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">기타내용</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											
												<?php echo get_view_thumbnail($row['ns_content']); ?>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">첨부파일</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											
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
													  <th scope="col">다운</th>
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
											</td>
										</tr>
										<?php if($w == 'u') {?>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">댓글</td>
                                            <td style="border-top:1px solid #ccc;white-space:normal" colspan="3" >
											
											
												<textarea name="comment_txt" class="form-control" id="comment_txt" rows="3"></textarea>
												<button type="button" class="btn btn-dark mt-3" onClick="addReply();">댓글 등록</button>
											
												<ul class="list-group" style="margin-top:20px">
													<?php 
													$cmmtSql = "select * from {$none['sign_draft_comment']} where ns_type = 1 and ns_id = '{$row['seq']}' order by seq desc";
													$cmmtRst = sql_query($cmmtSql);
													for($i=0; $cmmt = sql_fetch_array($cmmtRst); $i++) {
													?>
												
													<li class="list-group-item">
													<span class="badge badge-dark" style="font-size:85%"><?php echo $cmmt['mb_name']?></span> 
													<small style="color:gray;margin-right:15px"><?php echo date('y-m-d H:i', strtotime($cmmt['ns_datetime']))?></small> 
													<div style="margin:5px ">
													<?php echo nl2br($cmmt['ns_comment'])?> 
													</div>
													</li>
													<?php }?>
												</ul>
												
											</td>
										</tr>
										
										<?php }?>
									</tbody>
									</table>
								</div>
								<div class="m-t-30 align-right">
								<?php if($w == '') {?>
								<button type="submit" class="btn btn-primary" style="margin-left:20px">결재상신</button>
								<a href="../list/menu1_list.php" class="btn btn-outline-secondary">취소</a>
								<?php } else if($w == 'u') {?>
								
								<?php if( ( $member['mb_id'] == $row['mb_id'] && !$row['ns_id0_stat'])  || $is_admin ) {?>
								
								<a href="../write/menu1_write.php?w=u&seq=<?php echo $row['seq']?>" class="btn btn-primary">수정</a>
								<?php }?>
								
								<button type="button" class="btn btn-primary" onclick="location.href='./menu1_print.php?w=u&seq=<?php echo $row['seq']?>'">인쇄</button>
								
									
								<?php if( ( $member['mb_id'] == $row['mb_id'] && !$row['ns_id0_stat'])  || $is_admin ) {?>
								<button type="button" class="btn btn-danger" onclick="del_(<?php echo $row['seq']?>)">삭제</button>
								<?php }?>
								
								<a href="../list/menu1_list.php" class="btn btn-outline-secondary">목록</a>
								<?php }?>
								</div>
							</div>
							</form>
                    </div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>
<div class="modal fade" id="largeModal3" tabindex="-1"  role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel">결재</h5>
            </div>
            <div class="modal-body"> 
		
			<form name="machine_frm">
				<input type="hidden" name="sign_id" value="<?php echo $member['mb_id']?>">
				<table  class="table table-striped" >
				  <tbody >
					<tr>
					  <th>결재</th>
					  <td>
					  <select name="sign_stat" class="form-control">
						<option value="결재">결재</option>
						<option value="전결">전결</option>
						<option value="반려">반려</option>
					  </select>
					  </td>
					</tr>
					<tr>
					  <th style="border-bottom:1px solid #ccc">댓글</th>
					  <td><textarea name="sign_comment" id="machine_option" class="form-control"></textarea></td>
					</tr>
					
				  </tbody>
				</table>
			</form>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="signSubmit()">확인</button>
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

function del_(seq) {
	
	if(confirm('정말 삭제하시겠습니까?')) {
		location.href = '/_sign/write/menu1_update.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
<?php if($w == 'u') {?>
function addReply() {
	
	var comment = $('#comment_txt').val();
	var seq = <?php echo $seq?>;
	var type = 1; //1:기안서 2: 지출결의서 3: 설계변경 4:무상처리 6:사고경위서
	
	$('.btn-dark').attr('disabled', true);
	$('.btn-dark').html('댓글 등록 중..');
	$.post('../write/comment_update.php', { comment : comment, ns_id : seq, type : type }, function(data) {
		
		if(data == "y") {
			alert('댓글이 작성되었습니다.');
			location.reload();
		} else {
			alert('작성 중 오류가 발생하였습니다.');
			return false;
		}
		
	})
	
}

function proc_(type, sort) {
	var seq = <?php echo $seq?>;
	
	if(confirm(type+' 하시겠습니까?')) {
		location.href = '../write/state1_update.php?w='+type+'&seq='+seq+'&sort='+sort;
	} else {
		return false;
	}
	
}

<?php }?>
function chkfrm(f) {
	<?php if($w == '') {?>
	if(f.ns_team.value == "") {
		alert('기안부서 및 현장을 선택하세요.');
		return false;
	}
	<?php }?>
	
	
	if(f.ns_subject.value == "") {
		alert('제목을 입력하세요.');
		return false;
	}
	 
	 
	<?php echo get_editor_js("ns_content"); ?>
	
	return true;
}
$(function() {
	$(document).on('click', '.del_btn', function() {
		
		var id = $(this).attr('data');
		$('#nc_line_'+id).remove();
	
	})
	
	$('#add_btn').bind('click', function() {
		
		var html = "";
		
		if(!$('#add1').val()) {
			alert('업체명은 필수입니다.');
			return false;
		}
		
		var cnt = ($('#add_partner').find('tr').length)+1;
		
		html += '<tr id="nc_line_'+cnt+'">';
		html += '<td><input type="text" name="partner1[]" value="'+$('#add1').val()+'" class="form-control"></td>';
		html += '		<td><input type="text" name="partner2[]" value="'+$('#add2').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner3[]" value="'+$('#add3').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner4[]" value="'+$('#add4').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner5[]" value="'+$('#add5').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner6[]" value="'+$('#add6').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner7[]" value="'+$('#add7').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner8[]" value="'+$('#add8').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner9[]" value="'+$('#add9').val()+'" id="" class="form-control"></td>';
		html += '		<td><button type="button" class="btn btn-danger btn-sm del_btn" data="'+cnt+'">삭제</button></td>';
		html += '	</tr>';
		
		
		$('#add_partner').append(html);
		
		
		//input 초기화
		$('.add_input').val('');
		
	})
	
	//검색형 셀렉트박스로 변경
   
	 $('.select2').select2({
		  language: {
			noResults: function (params) {
			  return "검색 결과가 없습니다.";
			}
		  }
	 });
	 
	    var tag = {};
        var counter = 0;

        // 입력한 값을 태그로 생성한다.
        function addTag (value) {
            tag[counter] = value;
            counter++; // del-btn 의 고유 id 가 된다.
        }

        // tag 안에 있는 값을 array type 으로 만들어서 넘긴다.
        function marginTag () {
            return Object.values(tag).filter(function (word) {
                return word !== "";
            });
        }
    
          


        $("#tag").on("change", function (e) {
            var self = $(this);

            //엔터나 스페이스바 눌렀을때 실행

                var tagValue = self.val(); // 값 가져오기
                var tagTxt = self.find(':selected').text(); // 값 가져오기
				
                // 해시태그 값 없으면 실행X
                if (tagValue !== "") {

                    // 같은 태그가 있는지 검사한다. 있다면 해당값이 array 로 return 된다.
                    var result = Object.values(tag).filter(function (word) {
                        return word === tagValue;
                    })
                
                    // 해시태그가 중복되었는지 확인
                    if (result.length == 0) { 
                        $("#tag-list").append("<li class='tag-item'>"+tagTxt+"<span class='del-btn' idx='"+counter+"'>x</span></li>");
                        addTag(tagValue);
                        self.val("");
						var value = marginTag(); // return array
						$("#rdTag").val(value); 

                    } else {
                        alert("이미 추가 된 참조자입니다.");
                    }
                }
                e.preventDefault(); // SpaceBar 시 빈공간이 생기지 않도록 방지
           
        });

        // 삭제 버튼 
        // 인덱스 검사 후 삭제
        $(document).on("click", ".del-btn", function (e) {
            var index = $(this).attr("idx");
            tag[index] = "";
			var value = marginTag(); // return array
						$("#rdTag").val(value); 
            $(this).parent().remove();
        });
})


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
		url : "/_ajax/file_upload4.php",
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
	
	$.post('/_ajax/file_listup4.php', { id : id, w : '<?php echo $w?>' }, function(data) {
		$('#file_list').html(data);
	});
	
}


<?php if($w == 'u') {?>
//수정모드 일 경우 파일목록 불러옴.
file_list();
<?php }?>
</script>
