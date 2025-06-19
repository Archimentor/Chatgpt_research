<?php 
include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php'); 


//전산관리자 권한부여
if($member['mb_level2'] == 3) $is_admin = true; 

include_once(G5_EDITOR_LIB);

if($w == '') {
	
	$mb['mb_name'] = $member['mb_name'];
	
	$signline = sql_fetch("select * from {$none['sign_line']} where seq = 2");
	$date = date('Y-m-d');
	$ns_docnum = '<span style="color:#ccc">작성 후 자동생성</span>';
} else if($w == 'u') {
	
	$row = sql_fetch("select * from {$none['sign_draft2']} where seq = '$seq'");
	$mb = get_member($row['mb_id']);
	$date = date('Y-m-d', strtotime($row['ns_date']));
	$ns_docnum = $row['ns_docnum'];
}

?>
<script src="/core/js/jquery-1.8.3.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
.add_box { margin-bottom:10px }
.add_box span { display:inline-block;cursor:pointer; margin-left:10px }
.add_box span.name { margin-right:85px }
.add_box span.up { color:red }
.add_box span.down { color:blue }
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
				<li class="breadcrumb-item active">지출결의서</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<?php if($w=='u') {?>
						<h1 class="text-center" style="margin-top:25px">지&nbsp;&nbsp;출&nbsp;&nbsp; 결&nbsp;&nbsp;의&nbsp;&nbsp;서</h1>
						<?php }?>
					
						<form name="frm" action="./menu2_update.php" enctype="multipart/form-data" method="post" onsubmit="return chkfrm(this)">
							<input type="hidden" name="uid" id="uid" value="<?php echo get_uniqid()?>">
							<input type="hidden" name="w" value="<?php echo $w?>">
							<input type="hidden" name="seq" value="<?php echo $seq?>">
							<input hidden="hidden" />
                        <div class="body project_report">
							<?php if($w == '') {?>
							<div style="text-align:right;margin-bottom:10px">
								<a href="#largeModal" data-toggle="modal" data-target="#largeModal" class=" btn-primary btn-sm">결재선 지정</a>
                            </div>
							
							<div class="modal fade" id="largeModal" tabindex="-1"  role="dialog">
							<div class="modal-dialog modal-lg" role="document" style="max-width:500px">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="title" id="largeModalLabel">결재선 지정</h5>
									</div>
									<form name="signline_frm">
									<div class="modal-body"> 
									
									<select id="department_select" class="form-control">
										<option value="">부서선택</option>
										<?php echo get_department_select($row['mb_2'])?>
									</select>
									
										<div style="float:left;width:49.5%;margin-right:1%">
											
											<select <?php if(!is_mobile()){?>multiple<?php }?> class="multi_box form-control" id="step1" style="height:200px;margin-top:10px">
											<option value="">부서를 선택하세요</option>
											</select>
										</div>
										<div style="float:right;width:49.5%;">
											
											<div class="multi_box form-control" id="step2" style="height:200px;margin-top:10px">
												
											</div>
										</div>
										<div style="clear:both"></div>
									</div>
											
									
									
									<div class="modal-footer">
										<button type="button" class="btn btn-primary" onclick="signSubmit()">확인</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
									</div>
									</form>
									<script>
									var add_count = 0;
									$(function() {
										$('#department_select').bind('change', function() {
											
											var v = $(this).val();
											$.post('./ajax.department.php', { department : v }, function(data) {
												$('#step1').html(data);
											})
											
										})
										<?php if(is_mobile()){?>
										$(document).on('change', '#step1', function() {
											
											if(add_count == 5) {
												alert('최대 5명까지 추가가능합니다.');
												return false;
											}
											var overlap = false; 
											var id = $('#step1 option:selected').val();
											var name = $('#step1 option:selected').text();
											var chk_val = id+"|"+name;
											
											//중복추가 확인
											$('.add_sign_line').each(function() {
												
												if($(this).val() == chk_val) {
													overlap = true;
													return false;
												}
												
												
											})
											
											if(overlap == true) {
												alert('이미 추가 된 직원입니다.');
												return false;
											}
											
											var html = "";
											html += '<div class="add_box">';
											html += '<input type="hidden" name="add_sign_line[]" class="add_sign_line" value="'+id+'|'+name+'">';
											html += '<span class="name">'+name+'</span>';
											html += '<span class="up"><i class="fa fa-arrow-up" aria-hidden="true"></i></span>';
											html += '<span class="down"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>';
											html += '<span class="delete"><i class="fa fa-trash-o" aria-hidden="true"></i></span>';
											html += '</div>';
											$('#step2').append(html);
											add_count++;
											
										})	
											
											
										<?php } else {?>
										$(document).on('dblclick', '#step1 option', function() {
											
											if(add_count == 5) {
												alert('최대 5명까지 추가가능합니다.');
												return false;
											}
											var overlap = false; 
											var id = $(this).val();
											var name = $(this).text();
											var chk_val = id+"|"+name;
											
											//중복추가 확인
											$('.add_sign_line').each(function() {
												
												if($(this).val() == chk_val) {
													overlap = true;
													return false;
												}
												
												
											})
											
											if(overlap == true) {
												alert('이미 추가 된 직원입니다.');
												return false;
											}
											
											var html = "";
											html += '<div class="add_box">';
											html += '<input type="hidden" name="add_sign_line[]" class="add_sign_line" value="'+id+'|'+name+'">';
											html += '<span class="name">'+name+'</span>';
											html += '<span class="up"><i class="fa fa-arrow-up" aria-hidden="true"></i></span>';
											html += '<span class="down"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>';
											html += '<span class="delete"><i class="fa fa-trash-o" aria-hidden="true"></i></span>';
											html += '</div>';
											$('#step2').append(html);
											add_count++;
											
										})
										<?php }?>
										
										//위로 이동
										$(document).on('click', '.add_box > .up', function() {
											
											var el = $(this).closest('div');
											
											el.after(el.prev());
										})
										//위로 이동
										$(document).on('click', '.add_box > .down', function() {
											
											var el = $(this).closest('div');
											
											el.before(el.next());
											el.animate({'background':'red'}, 300);
										})
										//삭제
										$(document).on('click', '.add_box > .delete', function() {
											
											$(this).closest('div').remove();
											add_count--;
										})
									})
									</script>
								</div>
							</div>
						</div>
							<?php }?>
							
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
														<td><input type="hidden" name="ns_id<?php echo $i?>" value="<?php echo $signline['ns_id'.$i]?>"> 
														
														</td>
														<?php 
															
														}?>
													</tr>
												</tbody>
											</table>
											<input type="hidden" name="sign_cnt" id="sign_cnt" value="<?php echo $sign_cnt?>">
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
														
																
																if($row['ns_state'] == '미처리') {
																	echo '<a href="#none" onclick="proc_(\'결재\', '.$i.')" class=" btn-primary btn-sm">결재</a> ';
																	echo '<a href="#none" onclick="proc_(\'전결\', '.$i.')"  class=" btn-primary btn-sm">전결</a> ';
																	echo '<a href="#none"  onclick="proc_(\'반려\', '.$i.')" class=" btn-danger btn-sm">반려</a>';
																}
																
																
															}
															echo end($i);
															
														
														} else if($row['ns_id'.$i.'_stat']) {
															$mb_dir = substr($row['ns_id'.$i],0,2);
															$sign_file = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$row['ns_id'.$i].'_sign.gif';
															
															
															$state = explode('|', $row['ns_id'.$i.'_stat']);
															
															echo '<img src="'.G5_DATA_URL.'/member/'.$mb_dir.'/'.$row['ns_id'.$i].'_sign.gif" style="width:60px;height:60px">';
															
															echo '<br>'.$state[0].'<br>'.date('y-m-d H:i', strtotime($state[1]));
															
															}?>
														</td>
														<?php 
														
														}?>
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
											<select name="ns_importance"  class="form-control">
												<option value="보통" <?php echo get_selected($row['ns_importance'], '보통')?>>보통</option>
												<option value="중요" <?php echo get_selected($row['ns_importance'], '중요')?>>중요</option>
												<option value="가장중요" <?php echo get_selected($row['ns_importance'], '가장중요')?>>가장중요</option>
											</select>
											</td>
                                        </tr>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">참조자</td>
                                            <td style="border-top:1px solid #ccc">
											<select  id="tag"class="form-control select2">
												<option value="">참조자 선택</option>
												<?php echo get_admin_select('')?>
											</select>
											
											</td>
                                           
                                            <td style="border-top:1px solid #ccc" colspan="2">
												<input type="hidden" value="" name="tag" id="rdTag" />
												<ul id="tag-list">
												<?php if($w == 'u' && $row['ns_cc']) {
													
													
													
												?>
												
												<?php }?>
												
												</ul>
											
											</td>
                                        </tr>
										
										
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">기안부서 및 현장</td>
                                            <td style="border-top:1px solid #ccc" colspan="3">
											
											<?php if($w == '') {?>
											<select  name="ns_team" class="form-control select2 "   >
												<option value="">기안부서 및 현장 선택</option>
												<optgroup label="부서">
													<?php echo get_department_select2($row['ns_team'])?>
												</optgroup>
												<optgroup label="진행현장">
													<?php 
													$workSql = "select seq, nw_code, nw_subject, pj_title_kr  from {$none['worksite']} where nw_status  = '0' and nw_code != '210707' order by nw_code desc";
													$workRst = sql_query($workSql);
													while($work = sql_fetch_array($workRst)) {
														
														$nw_code = $work['nw_code'].' '.$work['pj_title_kr'];
													?>
													<option value="<?php echo $nw_code?>" <?php echo get_selected($nw_code, $work['pj_title_kr'])?>><?php echo $nw_code?></option>
													<?php }?>
													
												</optgroup>
												<optgroup label="완료현장">
												<?php 
													$workSql2 = "select seq, nw_code, nw_subject, pj_title_kr  from {$none['worksite']} where nw_status  = '1' and nw_code != '210707' order by nw_code desc";
													$workRst2 = sql_query($workSql2);
													while($work2 = sql_fetch_array($workRst2)) {
														
														$nw_code2 = $work2['nw_code'].' '.$work2['pj_title_kr'];
													?>
													<option value="<?php echo $nw_code2?>" <?php echo get_selected($nw_code2, $work2['pj_title_kr'])?>><?php echo $nw_code2?></option>
													<?php }?>
												</optgroup>
											</select>
												<?php } else if($w == 'u') {?>
												<?php echo $row['ns_team']?> <small style="color:red">[수정불가]</small>
												<?php }?>
											</td>
                                           
                                        </tr>
									
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">제목</td>
                                            <td style="border-top:1px solid #ccc" colspan="3">
												<input type="text" name="ns_subject" class="form-control" value="<?php echo $row['ns_subject']?>" >
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">공정선택</td>
                                            <td style="border-top:1px solid #ccc" colspan="3">
												<select name="ns_gongjung"  class="form-control select2">
												<option value="">선택하세요</option>
												<option value="본사관리" <?php echo get_selected($row['ns_gongjung'], '본사관리')?>>본사관리</option>
												<option value="가설공사" <?php echo get_selected($row['ns_gongjung'], '가설공사')?>>가설공사</option>
												<option value="가시설공사" <?php echo get_selected($row['ns_gongjung'], '가시설공사')?>>가시설공사</option>
												<option value="토공사" <?php echo get_selected($row['ns_gongjung'], '토공사')?>>토공사</option>
												<option value="철근콘크리트공사" <?php echo get_selected($row['ns_gongjung'], '철근콘크리트공사')?>>철근콘크리트공사</option>
												<option value="철골공사" <?php echo get_selected($row['ns_gongjung'], '철골공사')?>>철골공사</option>
												<option value="조적공사" <?php echo get_selected($row['ns_gongjung'], '조적공사')?>>조적공사</option>
												<option value="방수공사" <?php echo get_selected($row['ns_gongjung'], '방수공사')?>>방수공사</option>
												<option value="타일공사" <?php echo get_selected($row['ns_gongjung'], '타일공사')?>>타일공사</option>
												<option value="석공사" <?php echo get_selected($row['ns_gongjung'], '석공사')?>>석공사</option>
												<option value="목공사" <?php echo get_selected($row['ns_gongjung'], '목공사')?>>목공사</option>
												<option value="금속공사" <?php echo get_selected($row['ns_gongjung'], '금속공사')?>>금속공사</option>
												<option value="미장공사" <?php echo get_selected($row['ns_gongjung'], '미장공사')?>>미장공사</option>
												<option value="창호공사" <?php echo get_selected($row['ns_gongjung'], '창호공사')?>>창호공사</option>
												<option value="유리공사" <?php echo get_selected($row['ns_gongjung'], '유리공사')?>>유리공사</option>
												<option value="도장공사" <?php echo get_selected($row['ns_gongjung'], '도장공사')?>>도장공사</option>
												<option value="수장공사" <?php echo get_selected($row['ns_gongjung'], '수장공사')?>>수장공사</option>
												<option value="지붕및홈통공사" <?php echo get_selected($row['ns_gongjung'], '지붕및홈통공사')?>>지붕및홈통공사</option>
												<option value="판넬공사" <?php echo get_selected($row['ns_gongjung'], '판넬공사')?>>판넬공사</option>
												<option value="기타공사" <?php echo get_selected($row['ns_gongjung'], '기타공사')?>>기타공사</option>
												<option value="부대공사" <?php echo get_selected($row['ns_gongjung'], '부대공사')?>>부대공사</option>
												<option value="조경공사" <?php echo get_selected($row['ns_gongjung'], '조경공사')?>>조경공사</option>
												<option value="철거공사" <?php echo get_selected($row['ns_gongjung'], '철거공사')?>>철거공사</option>
												<option value="인테리어공사" <?php echo get_selected($row['ns_gongjung'], '인테리어공사')?>>인테리어공사</option>
												<option value="설비공사" <?php echo get_selected($row['ns_gongjung'], '설비공사')?>>설비공사</option>
												<option value="전기공사" <?php echo get_selected($row['ns_gongjung'], '전기공사')?>>전기공사</option>
												<option value="폐기물처리" <?php echo get_selected($row['ns_gongjung'], '폐기물처리')?>>폐기물처리</option>
												<option value="엘리베이터" <?php echo get_selected($row['ns_gongjung'], '엘리베이터')?>>엘리베이터</option>
												<option value="철근" <?php echo get_selected($row['ns_gongjung'], '철근')?>>철근</option>
												<option value="레미콘" <?php echo get_selected($row['ns_gongjung'], '레미콘')?>>레미콘</option>
												<option value="단열재" <?php echo get_selected($row['ns_gongjung'], '단열재')?>>단열재</option>
												<option value="운반" <?php echo get_selected($row['ns_gongjung'], '운반')?>>운반</option>
												<option value="장비업체" <?php echo get_selected($row['ns_gongjung'], '장비업체')?>>장비업체</option>
												<option value="용역업체" <?php echo get_selected($row['ns_gongjung'], '용역업체')?>>용역업체</option>
												<option value="건축사사무소" <?php echo get_selected($row['ns_gongjung'], '건축사사무소')?>>건축사사무소</option>
												<option value="철자재" <?php echo get_selected($row['ns_gongjung'], '철자재')?>>철자재</option>
												<option value="잡자재" <?php echo get_selected($row['ns_gongjung'], '잡자재')?>>잡자재</option>
												<option value="조명" <?php echo get_selected($row['ns_gongjung'], '조명')?>>조명</option>
												<option value="가구공사" <?php echo get_selected($row['ns_gongjung'], '가구공사')?>>가구공사</option>
												<option value="기술지도" <?php echo get_selected($row['ns_gongjung'], '기술지도')?>>기술지도</option>
											</select>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">도급금액</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											<div class="input-group" style="width:300px !important">
												<input type="text"  name="ns_price" value="<?php echo $row['ns_price']?>" class="pi4 form-control" id="price" >
												<div class="input-group-append">
													<span class="input-group-text">원</span>
												</div>
												</div>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">견적업체정보</td>
                                            <td style="border-top:1px solid #ccc;vertical-align:top" colspan="3" >
												
												<table class="add_table">
													<thead style="background:#f2f2f2;">
														<tr>
															<td rowspan="2">업체명</td>
															<td rowspan="2">견적금액</td>
															<td rowspan="2">세액</td>
															<td rowspan="2">총액</td>
															<td >계좌정보</td>
															<td rowspan="2">대표전화</td>
															<td rowspan="2">담당자</td>
															<td rowspan="2">비고</td>
															<td rowspan="2">관리</td>
														</tr>
														<tr>
															<td >은행명/계좌번호/예금주</td>
														
														</tr>
													</thead>
													<tbody id="add_partner">
														<tr style="border-bottom:2px solid #ccc">
															<td><input type="text" name="add1" id="add1" class="form-control add_input"></td>
															<td style="position:relative"><input type="text" name="add2" id="add2" class="form-control add_input">
															<div id="price1_comma" style="position:absolute;right:14px"></div>
															</td>
															<td  style="position:relative"><input type="text" name="add3" id="add3" class="form-control add_input">
															<div id="price2_comma" style="position:absolute;right:14px"></div>
															</td>
															<td  style="position:relative"><input type="text" name="add4" id="add4" class="form-control add_input" readonly >
															<div id="price3_comma" style="position:absolute;right:14px"></div>
															</td>
															<td><input type="text" name="add5" id="add5" class="form-control add_input" placeholder="은행명">
															<input type="text" name="add5_2" id="add5_2" class="form-control add_input" placeholder="계좌번호">
															<input type="text" name="add5_3" id="add5_3" class="form-control add_input" placeholder="예금주"></td>
															<td><input type="text" name="add6" id="add6" class="form-control add_input"></td>
															<td><input type="text" name="add7" id="add7" class="form-control add_input"></td>
															<td><input type="text" name="add8" id="add8" class="form-control add_input"></td>
															<td><button type="button" class="btn btn-primary btn-sm" id="add_btn">추가</button></td>
														</tr>
														<?php if($w == 'u') {
															
															$ns_company = explode('||', $row['ns_company']);
															
															for($i=0; $i<count($ns_company); $i++) {
																
																$ns_company_arr = explode('^', $ns_company[$i]);
														?>
															<tr id="nc_line_<?php echo $i?>">
																<td><input type="text" name="partner1[]" value="<?php echo $ns_company_arr[0]?>" class="form-control"></td>
																<td><input type="text" name="partner2[]"  data="<?php echo $i?>" value="<?php echo $ns_company_arr[1]?>" id="p1_<?php echo $i?>" class="form-control add_p1"></td>
																<td><input type="text" name="partner3[]"  data="<?php echo $i?>" value="<?php echo $ns_company_arr[2]?>" id="p2_<?php echo $i?>" class="form-control add_p2"></td>
																<td><input type="text" name="partner4[]"  data="<?php echo $i?>" value="<?php echo $ns_company_arr[3]?>" id="p3_<?php echo $i?>" class="form-control add_p3 readonly" readonly></td>
																<td>
																<input type="text" name="partner5[]" value="<?php echo $ns_company_arr[4]?>" id="" class="form-control">
																<input type="text" name="partner5_2[]" value="<?php echo $ns_company_arr[5]?>" id="" class="form-control">
																<input type="text" name="partner5_3[]" value="<?php echo $ns_company_arr[6]?>" id="" class="form-control">
																
																</td>
																<td><input type="text" name="partner6[]" value="<?php echo $ns_company_arr[7]?>" id="" class="form-control"></td>
																<td><input type="text" name="partner7[]" value="<?php echo $ns_company_arr[8]?>" id="" class="form-control"></td>
																<td><input type="text" name="partner8[]" value="<?php echo $ns_company_arr[9]?>" id="" class="form-control"></td>
																
																<td><button type="button" class="btn btn-danger btn-sm del_btn" data="<?php echo $i?>">삭제</button></td>
															</tr>
														
														
														<?php 
															}
														}?>
														
													</tbody>
													<tfoot>
													<tr>
														<td>소계</td>
														<td id="stotal1" class="text-right"><?php echo number_format($row['ns_total_price1'])?>
														</td>
														<td id="stotal2" class="text-right"><?php echo number_format($row['ns_total_price2'])?></td>
														<td id="stotal3" class="text-right"><?php echo number_format($row['ns_total_price3'])?></td>
														<td colspan="5">
														<input type="hidden" name="stotal1_input" id="stotal1_input" value="<?php echo $row['ns_total_price1']?>">
														<input type="hidden" name="stotal2_input" id="stotal2_input" value="<?php echo $row['ns_total_price2']?>">
														<input type="hidden" name="stotal3_input" id="stotal3_input" value="<?php echo $row['ns_total_price3']?>"></td>
													</tr>
													</tfoot>
												</table>
												
											</td>
										</tr>
										
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">외주비</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											<div class="input-group" style="width:300px !important">
												<input type="text"  name="ns_price2" value="<?php echo $row['ns_price2']?>" class="pi4 form-control" id="price2" >
												<div class="input-group-append">
													<span class="input-group-text">원</span>
												</div>
												</div>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">자재비</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											<div class="input-group" style="width:300px !important">
												<input type="text"  name="ns_price3" value="<?php echo $row['ns_price3']?>"class="pi4 form-control" id="price3" >
												<div class="input-group-append">
													<span class="input-group-text">원</span>
												</div>
												</div>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">기타내용</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											
												<?php echo editor_html("ns_content", get_text(html_purifier($row['ns_content']), 0)); ?>
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
													$cmmtSql = "select * from {$none['sign_draft_comment']} where ns_type = 2 and ns_id = '{$row['seq']}' order by seq desc";
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
								<a href="../list/menu2_list.php" class="btn btn-outline-secondary">취소</a>
								<?php } else if($w == 'u') {?>
								
								<?php if( $member['mb_id'] == $row['mb_id'] && !$row['ns_id'.$row['ns_sign_cnt'].'_stat']  || $is_admin) {?>
								<button type="submit" class="btn btn-primary">수정</button>
								<?php }?>
								
								<button type="button" class="btn btn-primary" onclick="window.print()">인쇄</button>
								
								<?php if( $member['mb_id'] == $row['mb_id'] && !$row['ns_id'.$row['ns_sign_cnt'].'_stat'] ) {?>
								<button type="button" class="btn btn-danger" onclick="del_(<?php echo $row['seq']?>)">삭제</button>
								<?php }?>
								
								<a href="../list/menu2_list.php" class="btn btn-outline-secondary">목록</a>
								<?php }?>
								</div>
							</div>
							</form>
                    </div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>


<?php include_once(NONE_PATH.'/footer.php');?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
function signSubmit() {
	
	var index_data=$("input[name='add_sign_line[]']").length;
	var i = 0;
	if(index_data == 0) {
		alert('최소 1명이상 결제선을 지정하셔야 합니다.');
		return false;
	}
	var thead = "";
	var tbody = "";
	
	//담당자는 바로 세팅
	thead += '<td>담당자</td>';
	tbody += '<td><?php echo $mb['mb_name']?></td>';
	$( $("input[name='add_sign_line[]']").get().reverse() ).each(function(){
		
		var v = $(this).val();
		var data = v.split('|');

		i++;
		thead += '<td>'+data[1]+'</td>';
		tbody += '<td><input type="hidden" name="ns_id'+i+'" value="'+data[0]+'"></td>';
		
		$('.sign_table thead').html(thead);
		$('.sign_table tbody').html(tbody);

	})
	
	$('#sign_cnt').val(index_data);
	$('#largeModal').modal('hide');
	
	
}

 $( "#add1" ).autocomplete({
        source : function( request, response ) {
             $.ajax({
                    type: 'post',
                    url: "./ajax.search.enterprise.php",
                    dataType: "json",
                    data: { value : request.term, type : 'search' },
                    success: function(data) {
                        response(
                            $.map(data, function(item) {
                                return {
                                    label: item.name+"("+item.bname+")",
                                    value: item.name,
									tel: item.tel,
									name: item.person_name,
									account1 : item.account1,
									account2 : item.account2,
									account3 : item.account3
                                }
                            })
                        );
                    }
               });
            },
        //조회를 위한 최소글자수
        minLength: 2,
        select: function( event, ui ) {
			$('#add5').val(ui.item.account1);
			$('#add5_2').val(ui.item.account2);
			$('#add5_3').val(ui.item.account3);
			$('#add6').val(ui.item.tel);
			$('#add7').val(ui.item.name);
        }
    });

document.onkeyup = function(e) {
	if(e.which == 119) {
		
		if(confirm('저장하시겠습니까?')) {
			chkfrm(document.frm);
		} else {
			return false;
		}
	}
}

document.addEventListener('keydown', function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
  };
}, true);

function del_(seq) {
	
	if(confirm('정말 삭제하시겠습니까?')) {
		location.href = '/_sign/write/menu2_update.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
<?php if($w == 'u') {?>
function addReply() {
	
	var comment = $('#comment_txt').val();
	var seq = <?php echo $seq?>;
	var type = 2; //1:기안서 2: 지출결의서 3: 설계변경 4:무상처리 6:사고경위서
	
	$('.btn-dark').attr('disabled', true);
	$('.btn-dark').html('댓글 등록 중..');
	$.post('./comment_update.php', { comment : comment, ns_id : seq, type : type }, function(data) {
		
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
		location.href = './state2_update.php?w='+type+'&seq='+seq+'&sort='+sort;
	} else {
		return false;
	}
	
}

<?php }?>

function chkfrm(f) {
	
	<?php echo get_editor_js("ns_content"); ?>
	
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
	 
	var pcnt = $('#add_partner').find('tr').length;
	if(pcnt <= 1) {
		
		alert('견적업체 정보를 1건이상 입력하세요.');
		
		return false;
	}
	
	
	return true;
}




$(function() {
		

	var stotal_price1 = 0; //견적금액
	var stotal_price2 = 0; //세액
	var stotal_price3 = 0; //총액
	
	$(document).on('click', '.del_btn', function() {
		
		var id = $(this).attr('data');
		$('#nc_line_'+id).remove();
		cal();
	})
	$('#add2').bind('keyup', function() {
		
		var vat = 0 ;
		var p1 = parseInt($(this).val());
		var total = 0;
		
		
		vat   = (p1*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p1+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$('#price1_comma').html(number_format(p1));
		$('#price2_comma').html(number_format(vat));
		$('#price3_comma').html(number_format(total));
		$('#add3').val(vat);
		$('#add4').val(total);
	})
	
	$('#add3').bind('keyup', function() {
		
		var p1 = parseInt($('#add2').val());
		var vat = parseInt($(this).val());
		vat = vat ? vat : 0;
		var total = p1 + vat;
		
		
		$('#price2_comma').html(number_format(vat));
		$('#price3_comma').html(number_format(total));
		$('#add4').val(total);
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
		html += '		<td><input type="text" name="partner2[]" data="'+cnt+'" value="'+$('#add2').val()+'" id="p1_'+cnt+'" class="form-control add_p1"></td>';
		html += '		<td><input type="text" name="partner3[]" data="'+cnt+'" value="'+$('#add3').val()+'" id="p2_'+cnt+'" class="form-control add_p2"></td>';
		html += '		<td><input type="text" name="partner4[]" data="'+cnt+'" value="'+$('#add4').val()+'" id="p3_'+cnt+'" class="form-control readonly add_p3" readonly></td>';
		html += '		<td><input type="text" name="partner5[]" value="'+$('#add5').val()+'" id="" class="form-control">';
		html += '		<input type="text" name="partner5_2[]" value="'+$('#add5_2').val()+'" id="" class="form-control">';
		html += '		<input type="text" name="partner5_3[]" value="'+$('#add5_3').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner6[]" value="'+$('#add6').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner7[]" value="'+$('#add7').val()+'" id="" class="form-control"></td>';
		html += '		<td><input type="text" name="partner8[]" value="'+$('#add8').val()+'" id="" class="form-control"></td>';
		html += '		<td><button type="button" class="btn btn-danger btn-sm del_btn" data="'+cnt+'">삭제</button></td>';
		html += '	</tr>';
		
		
		
		$('#add_partner').append(html);
		
		cal();
		
		//input 초기화
		$('#price1_comma, #price2_comma, #price3_comma').html('');
		$('.add_input').val('');
		
	})
	
	function cal() {
		
		//초기화
		stotal_price1 = 0;
		stotal_price2 = 0;
		stotal_price3 = 0;
		
		$('.add_p1').each(function() {
			stotal_price1 += parseInt($(this).val());
		})
		
		$('.add_p2').each(function() {
			stotal_price2 += parseInt($(this).val());
		})
		
		$('.add_p3').each(function() {
			stotal_price3 += parseInt($(this).val());
		})
		
		
		
		$('#stotal1').html(number_format(stotal_price1));
		$('#stotal1_input').val(stotal_price1);
		$('#stotal2').html(number_format(stotal_price2));
		$('#stotal2_input').val(stotal_price2);
		$('#stotal3').html(number_format(stotal_price3));
		$('#stotal3_input').val(stotal_price3);
		
	}
	
	$(document).on('keyup', '.add_p1', function() {
		
		var sort = $(this).attr('data');
		var vat = 0 ;
		var p1 = parseInt($(this).val());
		var total = 0;
		
		
		vat   = (p1*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p1+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		$('#p2_'+sort).val(vat);
		$('#p3_'+sort).val(total);
		
		cal();
	})
	
	$(document).on('keyup', '.add_p2', function() {
		
		var sort = $(this).attr('data');
		
		var p1 = parseInt($('#p1_'+sort).val());
		var vat = parseInt($(this).val());
		vat = vat ? vat : 0;
		var total = p1 + vat;
		
		$('#p3_'+sort).val(total);
		
		cal();
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
		url : "/_ajax/file_upload5.php",
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
	
	$.post('/_ajax/file_listup5.php', { id : id, w : '<?php echo $w?>' }, function(data) {
		$('#file_list').html(data);
	});
	
}


<?php if($w == 'u') {?>
//수정모드 일 경우 파일목록 불러옴.
file_list();
<?php }?>
</script>
