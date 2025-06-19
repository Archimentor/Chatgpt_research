<?php 
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php'); 

if($w == 'u') {
	
	$row = sql_fetch("select * from {$none['smart_list']} where seq = '$seq'");
	
	if(!$row)
		alert('데이터가 삭제되었거나 이동되었습니다.');
		
	$work_id = $row['work_id'];
	$date = $row['ns_date'];
}

$work = sql_fetch("select * from {$none['worksite']} where nw_code = '$work_id'");
$addr = explode(' ', $work['nw_addr']);


if($w == '') {
	
	$chk =sql_fetch("select * from {$none['smart_list']} where work_id = '$work_id' and ns_date = '$date'");
	
	if($chk) {
		alert('해당 일자에 이미 작성 된 일보가 있습니다.', '/_worksite/write/menu3_write.php?w=u&seq='.$chk['seq']);
	}
	
	$prev = sql_fetch("select * from {$none['smart_list']} where work_id = '$work_id' order by seq desc");
	
	$seq = $prev['seq'];
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
.textarea { width:100%;height:100%;border:0px;min-height:100px}
.num { width:50px;border:0px;text-align:right;padding-right:5px;background:transparent}
.num2 { width:50px;border:0px;text-align:center; background:transparent}
.input { width:100%;border:0px;text-align:center; background:transparent}
.input2 { width:100%;border:0px;text-align:left; background:transparent}
.multi_box { float:left;width:44%;  height:500px;padding:10px }
.center_btn { float:left;width:10%; margin-right:1%; margin-left:1%; height:500px;padding:10px;text-align:center }
</style>
<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> 스마트일보</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">현장관리</li>
                            <li class="breadcrumb-item active">스마트일보 등록</li>
                        </ul>
                    </div>            
                </div>
            </div>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
  기상청 단기예보 API에 문제가 있어 사용이 불가합니다. 날씨를 직접 선택해주세요.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="frm" action="./menu3_update.php" enctype="multipart/form-data" method="post">
								<input type="hidden" name="uid" id="uid" value="<?php echo get_uniqid()?>">
								<input type="hidden" name="w" value="<?php echo $w?>">
								<input type="hidden" name="seq" value="<?php echo $row['seq']?>">
								<input type="hidden" name="work_id" value="<?php echo $work_id?>">
								
								<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										공사일보 기본정보
									</div>
									<div class="card-body ">
										<div class="form-row">
											<div class="form-group col-md-4">
											  <label>현장명</label>
											  <input type="text" name="nw_code" class="form-control readonly" value="<?php echo $work['nw_subject']?>" placeholder="현장명" readonly>
											</div>
											<div class="form-group col-md-4">
											  <label>일자</label>
											  <input type="text" class="form-control readonly" value="<?php echo date('Y년 m월 d일', strtotime($date))?> <?php echo get_yoil($date)?>요일" placeholder="일자" readonly>
											  <input type="hidden" name="ns_date" value="<?php echo $date?>">
											</div>
											<div class="form-group col-md-4">
											  <label>날씨</label>
											  <select name="ns_wather"  class="form-control">
												<option value="">선택하세요</option>
												<option value="맑음" <?php echo get_selected($row['ns_wather'], '맑음')?>>맑음</option>
												<option value="흐림" <?php echo get_selected($row['ns_wather'], '흐림')?>>흐림</option>
												<option value="비" <?php echo get_selected($row['ns_wather'], '비')?>>비</option>
												<option value="눈" <?php echo get_selected($row['ns_wather'], '눈')?>>눈</option>
											</select>
											  
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-4">
											  <label>공정률</label>
											  <div class="input-group" >
											  <input type="text" name="ns_persent" class="form-control " value="<?php echo $row['ns_persent']?>" placeholder="공정률" style="text-align:right;padding-right:10px" >
											  <div class="input-group-append">
											   <span class="input-group-text">%</span>
											   </div>
											   </div>
											</div>
											<div class="form-group col-md-4">
											  <label>작성자</label>
											  <input type="text" name="nw_code" class="form-control readonly" value="<?php echo get_manager_txt($work['nw_ptype1_1'])?>" placeholder="" readonly>
											
											</div>
											
											  
											</div>
										</div>
									</div>
									
									<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										작업현황
									</div>
									<div class="card-body ">
										<div class="form-row">
											<div class="form-group col-md-12">
											  <label>금일 실시현황</label>
											  <textarea name="ns_today_his" class="form-control" style="height:120px" placeholder="엔터로 구분하여 입력하세요"><?php echo $row['ns_today_his']?></textarea>
											</div>
											<div class="form-group col-md-12">
											  <label>명일 주요작업</label>
											  <textarea name="ns_tomorrow_his" class="form-control" style="height:120px" placeholder="엔터로 구분하여 입력하세요"><?php echo $row['ns_tomorrow_his']?></textarea>
											</div>
											
										</div>
									
										</div>
									</div>
									
									<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										인원투입현황 <a href="#largeModal" data-toggle="modal" data-target="#largeModal" class=" btn-primary btn-sm">공종추가</a>
									</div>
									<div class="card-body ">
										<div class="form-row">
											
											<table  class="table" style="max-width:500px">
											  <thead class="thead-light">
												<tr>
												  <th scope="col">공종</th>
												  <th scope="col">전일</th>
												  <th scope="col">금일</th>
												  <th scope="col">누계</th>
												</tr>
											  </thead>
											  <tbody id="gongjong_list">
												<tr>
													<?php
														
														$gongjongSql =  "select * from {$none['smart_gongjong']} where ns_id = '{$seq}'";
														$gongjongRst =  sql_query($gongjongSql);
														for($a=0; $gongjong = sql_fetch_array($gongjongRst); $a++) {
															
															if($w == '') {
																$gycnt = $gongjong['ns_stotal'];
																$gtcnt = 0;
																$gstotal = $gongjong['ns_stotal'];
															} else if($w == 'u') {
																$gycnt = $gongjong['ns_ycnt'];
																$gtcnt = $gongjong['ns_tcnt'];
																$gstotal = $gongjong['ns_stotal'];
															}

													?>
														<tr><td ><input type="text" name="gongjong[]" class="input" value="<?php echo $gongjong['ns_name']?>" readonly /></td>
														<td ><input type="number" name="gongjong_ycnt[]" class="yday num2" value="<?php echo $gycnt?>" /></td>
														<td ><input type="number" name="gongjong_tcnt[]" class="tday num2" value="<?php echo $gtcnt?>" /> </td>
														<td ><input type="number" name="gongjong_stotal[]" class="stotal num2 readonly" value="<?php echo $gstotal?>" readonly></td>
														</tr>
													
													<?php }?>
												</tr>
												
											  </tbody>
											</table>
										</div>
									
										</div>
									</div>
									
									<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										자재 반입 현황 <a href="#largeModal2" data-toggle="modal" data-target="#largeModal2" class=" btn-primary btn-sm">자재추가</a>
									</div>
									<div class="card-body ">
										<div class="form-row">
											
											<table  class="table " style="clear:both;max-width:1000px">
											  <thead class="thead-light">
												<tr>
												  <th scope="col">품명</th>
												  <th scope="col">규격</th>
												  <th scope="col">단위</th>
												  <th scope="col">전일</th>
												  <th scope="col">금일</th>
												  <th scope="col">누계</th>
												  <th scope="col">비고</th>
												  <th scope="col">관리</th>
												</tr>
											  </thead>
											  <tbody id="jajae_list">
												<?php 
												$jajaeSql =  "select * from {$none['smart_jajae']} where ns_id = '{$seq}' order by seq ";
												$jajaeRst =  sql_query($jajaeSql);
												for($b=0; $jajae = sql_fetch_array($jajaeRst); $b++) {
													$arr[$jajae['ns_name']][] = $jajae;
												}
												$kk = 0;
												$aa = 0;
												
												foreach ($arr as $k => $v) {
													
													echo '<tr class="add_jajae_list'.$kk.'">';
													
													if(count($v) == 1)
														echo '<td>';
													else 
														echo '<td rowspan="'.(count($v)+1).'">';
														
													echo '<input type="hidden" name="k[]" value="'.$kk.'"><input type="hidden" name="rowspan['.$kk.']" value="'.count($v).'"><input type="text" name="jajae_name['.$kk.']" value="'.$k.'" class="input2"></td>';
													
													
													
													foreach ($v as $subType) {
														$aa++;
														if($w == '') {
															$jycnt = $subType['ns_stotal'];
															$jtcnt = 0;
															$jstotal = $subType['ns_stotal'];
														} else if($w == 'u') {
															$jycnt = $subType['ns_ycnt'];
															$jtcnt = $subType['ns_tcnt'];
															$jstotal = $subType['ns_stotal'];
														}
														if(count($v) == 1) {
															
															echo '<td><input type="text" name="jajae_option['.$kk.']" value="'.$subType['ns_option'].'" class="input2"></td>'.PHP_EOL;
															echo '<td><input type="text" name="jajae_dan['.$kk.']" value="'.$subType['ns_dan'].'" class="input2"></td>'.PHP_EOL;
															echo '<td><input type="text" name="jajae_ycnt['.$kk.']" value="'.$jycnt.'" class="jajae_ycnt num" ></td>'.PHP_EOL;
															echo '<td><input type="text" name="jajae_tcnt['.$kk.']" value="'.$jtcnt.'" class="jajae_tcnt num" ></td>'.PHP_EOL;
															echo '<td><input type="text" name="jajae_stotal['.$kk.']" value="'.$jstotal.'" class="readonly jajae_stotal num" readonly></td>'.PHP_EOL;
															echo '<td><input type="text" name="jajae_etc['.$kk.']" value="'.$subType['ns_etc'].'" class="input2"></td>'.PHP_EOL;
															echo '<td><button type="button" class="btn btn-danger btn-sm">삭제</button></td>'.PHP_EOL;
															
														} else {
															
																echo '<tr class="add_jajae_list'.$kk.'"><td><input type="text" name="jajae_option['.$kk.'][]" value="'.$subType['ns_option'].'" class="input2"></td>'.PHP_EOL;
																echo '<td ><input type="text" name="jajae_dan['.$kk.']" value="'.$subType['ns_dan'].'" class="input2"></td>'.PHP_EOL;
																echo '<td><input type="text" name="jajae_ycnt['.$kk.'][]" value="'.$jycnt.'" class="jajae_ycnt num" ></td>'.PHP_EOL;
																echo '<td><input type="text" name="jajae_tcnt['.$kk.'][]" value="'.$jtcnt.'" class="jajae_tcnt num"></td>'.PHP_EOL;
																echo '<td><input type="text" name="jajae_stotal['.$kk.'][]" value="'.$jstotal.'" class="readonly jajae_stotal num" readonly></td>'.PHP_EOL;
																echo '<td><input type="text" name="jajae_etc['.$kk.'][]" value="'.$subType['ns_etc'].'" class="input2"></td>'.PHP_EOL;
																echo '<td><button type="button" class="btn btn-danger btn-sm">삭제</button></td>'.PHP_EOL;
				
																echo '</tr>'.PHP_EOL;
															
														}
														
														$aa = 0;
													
													}
													
													echo '</tr>';
													$kk++;
												}

												
												//print_r2($jj);
												?>
		
											  </tbody>
											</table>
											
										</div>
									
										</div>
									</div>
									
									<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										장비 반입 현황 <a href="#largeModal3" data-toggle="modal" data-target="#largeModal3" class=" btn-primary btn-sm">장비반입 추가</a>
									</div>
									<div class="card-body ">
										<div class="form-row">
											<table  class="table " style="max-width:1000px">
											  <thead class="thead-light">
												<tr>
												  <th scope="col">품명</th>
												  <th scope="col">규격</th>
												  <th scope="col">전일</th>
												  <th scope="col">금일</th>
												  <th scope="col">누계</th>
												  <th scope="col">관리</th>
												</tr>
											  </thead>
											  <tbody id="machine_list">
											  <?php 
											 
												$machineSql =  "select * from {$none['smart_machine']} where ns_id = '{$seq}'";
												$machineRst =  sql_query($machineSql);
												for($b=0; $machine = sql_fetch_array($machineRst); $b++) {
													
													if($w == '') {
														$mycnt = $machine['ns_stotal'];
														$mtcnt = 0;
														$mstotal = $machine['ns_stotal'];
													} else if($w == 'u') {
														$mycnt = $machine['ns_ycnt'];
														$mtcnt = $machine['ns_tcnt'];
														$mstotal = $machine['ns_stotal'];
													}
											  ?>
												<tr>
												<td><input type="text" name="machine_name[]" value="<?php echo $machine['ns_name']?>" class="input2"></td>
												<td><input type="text" name="machine_option[]" value="<?php echo $machine['ns_option']?>" class="input2"></td>
												<td><input type="text" name="machine_ycnt[]" value="<?php echo $mycnt?>" class="machine_ycnt num" ></td>
												<td><input type="text" name="machine_tcnt[]" value="<?php echo $mtcnt?>" class="machine_tcnt num"></td>
												<td><input type="text" name="machine_stotal[]" value="<?php echo $mstotal?>" class="machine_stotal num" readonly></td>
												<td><button type="button" class="btn btn-danger btn-sm">삭제</button></td>
												</tr>
												<?php }?>
											  </tbody>
											</table>
											
										</div>
									
										</div>
									</div>
									
									<div class="card border mb-3">
									<div class="card-header" style="font-weight:500"> 
										특이사항
									</div>
									<div class="card-body ">  
										<div class="form-row">
											<div class="form-group col-md-12">
											  <textarea name="ns_etc" class="form-control" style="height:120px"><?php echo $row['ns_etc']?></textarea>
											</div>
										</div>
										</div>
									</div>
									
									<div class="card border mb-3">
									<div class="card-header" style="font-weight:500">
										사진등록
									</div>
									<div class="card-body ">
										<div class="form-row ">
										<div class="col-auto">
											
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
												<label class="input-group-text" for="inputGroupSelect01">공종 분류</label>
											  </div>
											  <select  name="category" id="category" class="custom-select " id="inputGroupSelect01" >
													<option value="" >선택하세요</option>
													<option value="가설공사">가설공사</option>
													<option value="가시설공사">가시설공사</option>
													<option value="토공사">토공사</option>
													<option value="철근콘크리트공사">철근콘크리트공사</option>
													<option value="철골공사">철골공사</option>
													<option value="조적공사">조적공사</option>
													<option value="방수공사">방수공사</option>
													<option value="타일공사">타일공사</option>
													<option value="석공사">석공사</option>
													<option value="목공사">목공사</option>
													<option value="금속공사">금속공사</option>
													<option value="미장공사">미장공사</option>
													<option value="창호공사">창호공사</option>
													<option value="유리공사">유리공사</option>
													<option value="도장공사">도장공사</option>
													<option value="수장공사">수장공사</option>
													<option value="지붕및홈통공사">지붕및홈통공사</option>
													<option value="판넬공사">판넬공사</option>
													<option value="기타공사">기타공사</option>
													<option value="부대공사">부대공사</option>
													<option value="조경공사">조경공사</option>
													<option value="철거공사">철거공사</option>
													<option value="인테리어공사">인테리어공사</option>
													<option value="설비공사">설비공사</option>
													<option value="전기공사">전기공사</option>
													<option value="폐기물처리">폐기물처리</option>
													<option value="엘리베이터">엘리베이터</option>
													<option value="철근">철근</option>
													<option value="레미콘">레미콘</option>
													<option value="단열재">단열재</option>
													<option value="운반">운반</option>
													<option value="장비업체">장비업체</option>
													<option value="용역업체">용역업체</option>
													<option value="건축사사무소">건축사사무소</option>
													<option value="철자재">철자재</option>
													<option value="잡자재">잡자재</option>
													<option value="조명">조명</option>
													<option value="가구공사">가구공사</option>
													<option value="기술지도">기술지도</option>
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
											<span class="group-span-filestyle input-group-btn file_btn" tabindex="0">
												<label for="fileInput" class="btn btn-default">
													<span class="glyphicon fa fa-upload"></span>
													찾기
												</label>
											</span>
											
										</div>
										<!--<div class="col-auto">
										  <button type="button" id="file_upload_btn" onclick="file_upload()" class="btn btn-primary mb-2">업로드</button>
										</div>-->
										
									
									
										</div>
										 <div class="form-row ">
											<table  class="table table-striped" >
											  <thead>
												<tr>
												  <th scope="col">공종명</th>
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
									<button type="submit" class="btn btn-primary" style="margin-left:20px"><?php if($w == 'u') echo '수정(F8)'; else echo '등록(F8)';?></button>
									<a href="../list/menu3_list.php" class="btn btn-outline-secondary">취소</a>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel">공종추가</h5>
            </div>
            <div class="modal-body"> 
			<div class="alert alert-info" role="alert">
			  여러개 선택시 Ctrl키 또는 Shift키를 눌러 클릭하시면 됩니다.
			</div>
			<form name="gongjong_frm">
			<select multiple name="sel1" class="multi_box" id="step1">
			
					<option value="직원">직원</option>
					<option value="반장">반장</option>
					<option value="보통인부(직영)">보통인부(직영)</option>
					<option value="특별인부(직영)">특별인부(직영)</option>
				
					<option value="가설공">가설공</option>
				
					<option value="토공">토공</option>
				
					<option value="석면해체공">석면해체공</option>
					<option value="해체공">해체공</option>
			
					<option value="형틀목공">형틀목공</option>
					<option value="타설공">타설공</option>
					<option value="철근공">철근공</option>
					<option value="비계공">비계공</option>
					<option value="거푸집해체공">거푸집해체공</option>
				
					<option value="철골공">철골공</option>
					<option value="용접공">용접공</option>
					<option value="철판공">철판공</option>
					<option value="철공">철공</option>
				
					<option value="조적공">조적공</option>
				
					<option value="석공">석공</option>
				
					<option value="타일공">타일공</option>
				
					<option value="건축목공">건축목공</option>
				
					<option value="방수공">방수공</option>
					<option value="코킹공">코킹공</option>
				
					<option value="잡철공">잡철공</option>
					<option value="할석공">할석공</option>
					<option value="판넬조립공">판넬조립공</option>
					<option value="지붕잇기공">지붕잇기공</option>
				
					<option value="견출공">견출공</option>
					<option value="미장공">미장공</option>
				
					<option value="창호공">창호공</option>
					<option value="유리공">유리공</option>
				
					<option value="도장공">도장공</option>
				
					<option value="수장공">수장공</option>
					<option value="내장공">내장공</option>
					<option value="도배공">도배공</option>
				
					<option value="기타">기타</option>
				
					<option value="조경공">조경공</option>
			
					<option value="보일공">보일공</option>
					<option value="착암공">착암공</option>
					<option value="포설공">포설공</option>
					<option value="포장공">포장공</option>
				
					<option value="배관공">배관공</option>
					<option value="보일러공">보일러공</option>
					<option value="위생공">위생공</option>
					<option value="덕트공">덕트공</option>
					<option value="보온공">보온공</option>
				
					<option value="내선전공">내선전공</option>
					<option value="송전전공">송전전공</option>
					<option value="배전전공">배전전공</option>
					<option value="전기배관공">전기배관공</option>
					<option value="통신공">통신공</option>
				
			</select>
			<div class="center_btn">
			<input type="button" value=" ▶ " onclick="addItem()" class="btn btn-secondary"><br><br><input type="button" value=" ◀ " onclick="removeItem()" class="btn btn-secondary">
			</div>
			<select multiple name="sel2" class="multi_box"  id="step2">
			
			</select>
			
			<div class="input-group" style="width:44%;float:right;margin-top:15px;text-align:right;">
				<button type="button" class="btn btn-dark btn-sm" onclick="selectUp()" style="margin-right:10px">↑</button> 
				<button type="button" class="btn btn-dark btn-sm" onclick="selectDown()">↓</button>
			</div>
			
			
			<div class="input-group" style="width:44%;float:left;margin-top:15px">
				<input type="text" name="txtGongjong" placeholder="공종명" class="form-control">
				<div class="input-group-append">
				<button type="button" class="btn btn-dark" onclick="addTxtItem()">추가</button>
			</div>
			
			</div>
			</form>
			
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitItem()" data-dismiss="modal">저장</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="largeModal2" tabindex="-1"  role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel">자재 추가</h5>
            </div>
            <div class="modal-body"> 
		
			<form name="jajae_frm">
				<table  class="table table-striped" >
				  <tbody >
					<tr>
					  <th>품명</th>
					  <td><input type="text" name="jajae_name" id="jajae_name" class="form-control"></td>
					  
					</tr>
					<tr>
					  <th style="border-bottom:1px solid #dee2e6">규격</th>
					  <td><textarea name="jajae_option" id="jajae_option" placeholder="규격별 엔터로 구분하여 입력" class="form-control"></textarea></td>
					  
					</tr>
					<tr>
					  <th style="border-bottom:1px solid #dee2e6">단위</th>
					  <td><input type="text" name="jajae_dan" id="jajae_dan" class="form-control"></td>
					  
					</tr>
					
				  </tbody>
				</table>
			</form>
			<div class="alert alert-info" role="alert">
			추가가 끝났다면 닫기 버튼을 눌러 창을 닫으신 뒤 데이터를 입력해주세요.
			</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addJajae()">추가</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="largeModal3" tabindex="-1"  role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel">장비 추가</h5>
            </div>
            <div class="modal-body"> 
		
			<form name="machine_frm">
				<table  class="table table-striped" >
				  <tbody >
					<tr>
					  <th>장비명</th>
					  <td><input type="text" name="machine_name" id="machine_name" class="form-control"></td>
					</tr>
					<tr>
					  <th>규격</th>
					  <td><input type="text" name="machine_option" id="machine_option" class="form-control"></td>
					</tr>
					
				  </tbody>
				</table>
			</form>
			<div class="alert alert-info" role="alert">
			추가가 끝났다면 닫기 버튼을 눌러 창을 닫으신 뒤 데이터를 입력해주세요.
			</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addMachine()">추가</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">공종추가</h4>
            </div>
            <div class="modal-body">
					<div class="input-group">
						<select name="gongjong" id="gongjong" class="form-control">
							<optgroup label="현장관리">
								<option value="직원">직원</option>
								<option value="반장">반장</option>
								<option value="보통인부(직영)">보통인부(직영)</option>
								<option value="특별인부(직영)">특별인부(직영)</option>
							</optgroup>
							<optgroup label="가설">
								<option value="가설공">가설공</option>
							</optgroup>
							<optgroup label="철거">
								<option value="석면해체공">석면해체공</option>
								<option value="해체공">해체공</option>
							</optgroup>
							<optgroup label="철근콘크리트">
								<option value="형틀목공">형틀목공</option>
								<option value="타설공">타설공</option>
								<option value="철근공">철근공</option>
								<option value="비계공">비계공</option>
								<option value="거푸집해체공">거푸집해체공</option>
							</optgroup>
							<optgroup label="철골">
								<option value="철골공">철골공</option>
								<option value="용접공">용접공</option>
								<option value="철판공">철판공</option>
								<option value="철공">철공</option>
							</optgroup>
							<optgroup label="조적">
								<option value="조적공">조적공</option>
							</optgroup>
							<optgroup label="석공사">
								<option value="석공">석공</option>
							</optgroup>
							<optgroup label="타일">
								<option value="타일공">타일공</option>
							</optgroup>
							<optgroup label="목공사">
								<option value="건축목공">건축목공</option>
							</optgroup>
							<optgroup label="방수">
								<option value="방수공">방수공</option>
								<option value="코킹공">코킹공</option>
							</optgroup>
							<optgroup label="금속">
								<option value="잡철공">잡철공</option>
								<option value="할석공">할석공</option>
								<option value="판넬조립공">판넬조립공</option>
								<option value="지붕잇기공">지붕잇기공</option>
							</optgroup>
							<optgroup label="미장">
								<option value="견출공">견출공</option>
								<option value="미장공">미장공</option>
							</optgroup>
							<optgroup label="창호">
								<option value="창호공">창호공</option>
								<option value="유리공">유리공</option>
							</optgroup>
							<optgroup label="도장">
								<option value="도장공">도장공</option>
							</optgroup>
							<optgroup label="수장">
								<option value="수장공">수장공</option>
								<option value="내장공">내장공</option>
								<option value="도배공">도배공</option>
							</optgroup>
							<optgroup label="기타공사">
								<option value="기타">기타</option>
							</optgroup>
							<optgroup label="부대토목">
								<option value="보일공">보일공</option>
								<option value="착암공">착암공</option>
								<option value="포설공">포설공</option>
								<option value="포장공">포장공</option>
							</optgroup>
							<optgroup label="설비">
								<option value="배관공">배관공</option>
								<option value="보일러공">보일러공</option>
								<option value="위생공">위생공</option>
								<option value="덕트공">덕트공</option>
								<option value="보온공">보온공</option>
							</optgroup>
							<optgroup label="전기">
								<option value="내선전공">내선전공</option>
								<option value="송전전공">송전전공</option>
								<option value="배전전공">배전전공</option>
								<option value="전기배관공">전기배관공</option>
								<option value="통신공">통신공</option>
							</optgroup>
							
						</select>
						<input type="number" id="yday" class="form-control" placeholder="전일">
						<input type="number" id="tday" class="form-control"  placeholder="금일">
					</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="add_gongjong()" data-dismiss="modal">추가</button>
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
$(function() {
	var td_box_size = $('.today_box').height();
	
	$('.textarea').css('height', td_box_size+'px');
	
	$('.file_btn').bind('click', function() {
		if(!$('#category').val()) {
			alert('먼저 파일분류를 선택하세요.');
			return false;
		}
	})
})
//자재 추가 관련 
function addJajae() {
	
	var frm = document.jajae_frm;
	var name = frm.jajae_name.value; //품명
	var option = frm.jajae_option.value; //규격
	var dan = frm.jajae_dan.value; //단위
	var opt_arr = option.split("\n"); //구분자 나눔
	var html = ""; //html 
	var rowspan=0; 
	
	var z = $('input[name="k[]"').length;
	
	if(!name) {
		alert('품명을 입력하세요.');
		return false;
	}
	if(!option) {
		alert('규격을 입력하세요.');
		return false;
	}
	
	rowspan = opt_arr.length;
	
	html += '<tr class="add_jajae_list'+z+'">';
	
	if(rowspan == 1) {
		html += '<td>';
	} else {
		html += '<td rowspan="'+(rowspan+1)+'">';
	}
	
	html += '<input type="hidden" name="k[]" value="'+z+'">';
	html += '<input type="hidden" name="rowspan['+z+']" value="'+rowspan+'"><input type="text" name="jajae_name['+z+']" value="'+name+'" class="input2"></td>';
	
	if(rowspan == 1) {
		html += '<td><input type="text" name="jajae_option['+z+']" value="'+opt_arr[0]+'" class="input2"></td>';
		html += '<td><input type="text" name="jajae_dan['+z+']" value="'+dan+'" class="input2"></td>';
		html += '<td><input type="text" name="jajae_ycnt['+z+']" value="0" class="jajae_ycnt num" ></td>';
		html += '<td><input type="text" name="jajae_tcnt['+z+']" value="0" class="jajae_tcnt num" ></td>';
		html += '<td><input type="text" name="jajae_stotal['+z+']" value="0" class="readonly jajae_stotal num" readonly></td>';
		html += '<td><input type="text" name="jajae_etc['+z+']" value="" class="input2"></td>';
		html += '<td><buttun type="button" class="btn btn-danger btn-sm">삭제</button></td>';
	} else {
		
		for (var i = 0; i < opt_arr.length; i++) {
			html += '<tr class="add_jajae_list'+z+'"><td><input type="text" name="jajae_option['+z+'][]" value="'+opt_arr[i]+'" class="input2"></td>';
			
			//if(i == 0) {
			//html += '<td rowspan="'+rowspan+'"><input type="text" name="jajae_dan['+z+']" value="'+dan+'" class="input2"></td>';
			//}
			html += '<td><input type="text" name="jajae_dan['+z+']" value="'+dan+'" class="input2"></td>';
			html += '<td><input type="text" name="jajae_ycnt['+z+'][]" value="0" class="jajae_ycnt num"></td>';
			html += '<td><input type="text" name="jajae_tcnt['+z+'][]" value="0" class="jajae_tcnt num"></td>';
			html += '<td><input type="text" name="jajae_stotal['+z+'][]" value="0" class="readonly jajae_stotal num" readonly></td>';
			html += '<td><input type="text" name="jajae_etc['+z+'][]" value="" class="input2"></td>';
			html += '<td><buttun type="button" class="btn btn-danger btn-sm">삭제</button></td>';
			
			html += '</tr>';
		}
		
		
	}
	

		
	html += '</tr>';
	
	
	
	//초기화하고 다시 포커스 
	frm.jajae_name.value = "";
	frm.jajae_option.value = "";
	frm.jajae_dan.value = "";
	frm.jajae_name.focus();
	
	//부모창 insert
	$('#jajae_list').append(html);
	
}


//장비반입 관련 
function addMachine() {
	
	var frm = document.machine_frm;
	var name = frm.machine_name.value; //품명
	var option = frm.machine_option.value; //규격
	var html = ""; //html 
	
	
	
	if(!name) {
		alert('품명을 입력하세요.');
		return false;
	}
	if(!option) {
		alert('규격을 입력하세요.');
		return false;
	}
	
	
	html += '<tr>';
	
	
	html += '<td><input type="text" name="machine_name[]" value="'+name+'" class="input2"></td>';
	html += '<td><input type="text" name="machine_option[]" value="'+option+'" class="input2"></td>';
	html += '<td><input type="text" name="machine_ycnt[]" value="0" class="machine_ycnt num"></td>';
	html += '<td><input type="text" name="machine_tcnt[]" value="0" class="machine_tcnt num"></td>';
	html += '<td><input type="text" name="machine_stotal[]" value="0" class="machine_stotal num" readonly></td>';
	html += '<td><buttun type="button" class="btn btn-danger btn-sm">삭제</button></td>';
	html += '</tr>';
	
	
	
	//초기화하고 다시 포커스 
	frm.machine_name.value = "";
	frm.machine_option.value = "";
	frm.machine_name.focus();
	
	//부모창 insert
	$('#machine_list').append(html);
	
}

//공종추가 관련 
function addTxtItem() {
	var frm = document.gongjong_frm;
	var cnt = frm.sel2.options.length;
	for (var i=0 ; i < cnt ; i++){
	
		if(frm.txtGongjong.value == frm.sel2.options[i].value) {
			alert('이미 추가된 공종입니다.');
			return false;
		}
		
	}
	
	frm.sel2.options.add(new Option(frm.txtGongjong.value, frm.txtGongjong.value));
	
	
}
function addItem(){
	var frm = document.gongjong_frm;
	var cnt = frm.sel1.options.length;
	var cnt2 = 0;
	var cnt3 = frm.sel2.options.length;


	for (var i=0 ; i < cnt ; i++){
		if(frm.sel1.options[i].selected == true){
			
			frm.sel2.options.add(new Option(frm.sel1.options[i].text, frm.sel1.options[i].value));
			cnt2++;
		}
	}

	for (var i=0 ; i < cnt2 ; i++){
		frm.sel1.options.remove(frm.sel1.selectedIndex);
	}
}

function removeItem(){
	var frm = document.gongjong_frm;
	var cnt = frm.sel2.options.length;
	var cnt2 = 0;

	for (var i=0 ; i < cnt ; i++){
		if(frm.sel2.options[i].selected == true){
			frm.sel1.options.add(new Option(frm.sel2.options[i].text, frm.sel2.options[i].value));
			cnt2++;
		}
	}

	for (var i=0 ; i < cnt2 ; i++){
		frm.sel2.options.remove(frm.sel2.selectedIndex);
	}
}

function selectUp(){
	$('#step2 option:selected').each(function(){
		var selectObj = $(this)
		if(selectObj.index() == 0 )
			return false;
	   
		var targetObj = $('#step2 option:eq('+(selectObj.index()-1)+')');
		targetObj.before(selectObj);
	});
}

function selectDown(){
	$('#step2 option:selected').each(function(){
		var selectObj = $(this)
		if(selectObj.index() == $('#step2').children().length )
			return false;
	   
		var targetObj = $('#step2 option:eq('+(selectObj.index()+1)+')');
		targetObj.after(selectObj);
	});
}

function submitItem() {
	
	var frm = document.gongjong_frm;
	var frm2 = document.frm;
	var cnt = frm.sel2.options.length;
	var html = "";
	
	for (var i=0 ; i < cnt ; i++){
	
		html += '<tr><td ><input type="text" name="gongjong[]" class="input" value="'+frm.sel2.options[i].value+'" readonly /></td>';
		html += '	  <td ><input type="number" name="gongjong_ycnt[]" class="yday num2" value="0"  /></td>';
		html += '	  <td ><input type="number" name="gongjong_tcnt[]" class="tday num2" value="0" /> </td>';
		html += '	  <td ><input type="number" name="gongjong_stotal[]" class="stotal num2 readonly" value="0" readonly></td></tr>';
		
	}
	//$('#gongjong_list').html('');
	$('#gongjong_list').append(html);
	
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
		url : "/_ajax/file_upload3.php",
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
	file_upload();
    $(this).val('');
}


//업로드 파일목록
function file_list() {
	
	<?php if($w == '') {?>
	var id = $('#uid').val();
	<?php } else {?>
	var id = <?php echo $seq?>
	<?php }?>
	
	$.post('/_ajax/file_listup3.php', { id : id, w : '<?php echo $w?>' }, function(data) {
		$('#file_list').html(data);
	});
	
}

function conv_price(s) {
	
	
	
	var price = $('.pi'+s).val();
	
	$('.pt'+s).html(number_format(price)+"원");
	
	return false;
	
	
}

//파일삭제 
function file_del(seq) {
	
	if(confirm('정말 삭제하시겠습니까?\n삭제 된 파일은 복구가 불가능합니다.\n※주의 : 페이지가 새로고침되어 데이터가 손실될 수 있으니 아래 등록 및 수정을 실행하신 후 삭제하시기 바랍니다.')) {
		location.href = '/_ajax/file_delete3.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}

$(function() {
	
	$(document).on('keyup blur','.yday', function() {
		
		var yea = parseInt($(this).val()); 
		var tea = parseInt($(this).closest('tr').find('.tday').val()); 
		
		$(this).closest('tr').find('.stotal').val(yea+tea);
	})
	
	$(document).on('keyup blur','.tday', function() {
		
		var yea = parseInt($(this).closest('tr').find('.yday').val()); 
		var tea = parseInt($(this).val()); 
		
		$(this).closest('tr').find('.stotal').val(yea+tea);
	})
	
	
	$(document).on('keyup blur','.jajae_ycnt', function() {
		
		var yea = parseInt($(this).val()); 
		var tea = parseInt($(this).closest('tr').find('.jajae_tcnt').val()); 
		
		$(this).closest('tr').find('.jajae_stotal').val(yea+tea);
	})
	
	$(document).on('keyup blur','.jajae_tcnt', function() {
		
		var yea = parseInt($(this).closest('tr').find('.jajae_ycnt').val()); 
		var tea = parseInt($(this).val()); 
		
		$(this).closest('tr').find('.jajae_stotal').val(yea+tea);
	})
	
	
	$(document).on('keyup blur','.machine_ycnt', function() {
		
		var yea = parseInt($(this).val()); 
		var tea = parseInt($(this).closest('tr').find('.machine_tcnt').val()); 
		
		$(this).closest('tr').find('.machine_stotal').val(yea+tea);
	})
	
	$(document).on('keyup blur','.machine_tcnt', function() {
		
		var yea = parseInt($(this).closest('tr').find('.machine_ycnt').val()); 
		var tea = parseInt($(this).val()); 
		
		$(this).closest('tr').find('.machine_stotal').val(yea+tea);
	})
	
	
	//공급가액+현금계약금액 = 총공사금액
	$('#price1, #price2').bind('keyup blur', function() {
		var p1 = parseInt($('#price1').val())?parseInt($('#price1').val()):0;
		var p2 = parseInt($('#price2').val())?parseInt($('#price2').val()):0;
		var total = p1+p2;
		var vat = 0;
		var tottal
		
		$('#total_price').val(total);
		//$('#total_price_conv').html(priceConvertKorean(String(total)));
		
		vat   = (p1*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);    // 부가세(반올림)
		
		$('.pi2').val(vat);
		
		$('.pi3').val(p1+vat);
		
		
		
	})
	
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
