<?php 
include_once('../../_common.php');
define('menu_sign', true);
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if($is_guest) alert_close('권한이 없습니다.');

//전산관리자 권한부여
if($member['mb_level2'] == 3) $is_admin = true; 


$row = sql_fetch("select * from {$none['sign_draft2']} where seq = '$seq'");
$mb = get_member($row['mb_id']);
$date = date('Y-m-d', strtotime($row['ns_date']));
$ns_docnum = $row['ns_docnum'];

if(!$row) alert('잘못 된 접근입니다.');
?>
<!doctype html>
<html lang="ko">
<head>
<title>㈜엔원종합건설</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="아름다운 공간 창조, 모던 건축을 지향하는 엔원종합건설">
<meta property="og:title" content="㈜엔원종합건설">
<meta property="og:description" content="아름다운 공간 창조, 모던 건축을 지향하는 엔원종합건설">
<link rel="shortcut icon" href="<?php echo NONE_URL?>/common/images/favicon.ico">

<!-- COMMON CSS -->
<link rel="stylesheet" href="<?php echo NONE_URL?>/common/n1/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo NONE_URL?>/common/n1/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo NONE_URL?>/common/n1/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css">
<link rel="stylesheet" href="<?php echo NONE_URL?>/common/n1/jvectormap/jquery-jvectormap-2.0.3.min.css"/>
<link rel="stylesheet" href="<?php echo NONE_URL?>/common/n1/morrisjs/morris.min.css" />
<link rel="stylesheet" href="<?php echo NONE_URL?>/common/n1/nestable/jquery-nestable.css"/>

<!-- MAIN CSS -->
<link rel="stylesheet" href="<?php echo NONE_URL?>/assets/css/main.css">
<link rel="stylesheet" href="<?php echo NONE_URL?>/assets/css/color_skins.css">
<script>
	  if(navigator.userAgent.indexOf('Trident') > 0){
		location.href = "microsoft-edge:" + location.href;
		alert('해당 브라우저는 더이상 지원하지 않습니다.\nMicrosoft Edge 브라우저가 자동으로 열립니다.\n만약 Edge브라우저가 없으신 고객님들은 타 브라우저(크롬,사파리 등)을 이용해주시기 바랍니다.');
		setTimeout(close);
	  }
	  
	
</script>
<style>
* {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

#loading {
  position:absolute;
  left:50%;
  display: inline-block;
  width: 50px;
  height: 50px;
  border: 3px solid rgba(100,100,100,.3);
  border-radius: 50%;
  margin-left:-25px;
  text-align:center;
  margin-top:20px;
  border-top-color: #000;
  animation: spin 1s ease-in-out infinite;
  -webkit-animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to { -webkit-transform: rotate(360deg); }
}
@-webkit-keyframes spin {
  to { -webkit-transform: rotate(360deg); }
}

 @page {
	size: A4 ;
	margin: 0;
	/*size: landscape;*/
}

@media print {
	
	#main-content {
		margin: 0;
		border: initial;
		border-radius: initial;
		width: initial;
		min-height: initial;
		box-shadow: initial;
		background: initial;
		
	}
	
	table { page-break-after: always; 
	margin: 0;
		border: initial;
		border-radius: initial;
		width: initial;
		min-height: initial;
		box-shadow: initial;
		background: initial;
	}
	
	img { max-width:100% }
}
.table tbody tr td, .table tbody th td { white-space: normal !important }

.card .body { padding:5px }
.add_table td { padding:5px }
</style>
</head>
<body style="background:none">


<div id="wrapper">
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
.sign_table th, td {  border: 1px solid #ccc}
.sign_table thead td { background:#f2f2f2; width:100px;text-align:center; }
.sign_table tbody td { height:155px; border-bottom:0 !important;text-align:center; }
.add_table {width:100%}
#tag-list { list-style:none; margin:0; padding:0}
#tag-list li {float:left; margin-right:10px; border:1px solid #ccc; background:#f2f2f2; padding:7px 10px;margin-top:3px }
#tag-list .del-btn { padding-left:10px; font-size:15px; font-weight:600; cursor:pointer }
</style>
<!--현장별매출현황-->
<div id="main-content" style="margin:0;width:100%">

 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						
						
						
					
											
					
                        <div class="body project_report">
							
							<h1 class="text-center" style="margin-top:25px;float:left;margin-top:55px">지&nbsp;&nbsp;출&nbsp;&nbsp; 결&nbsp;&nbsp;의&nbsp;&nbsp;서</h1>
							<?php  if($w == 'u'){?>
							<table class="sign_table " style="width:600px;float:right;">
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
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
									<tbody>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="w100 font-weight-bold">문서번호</td>
                                            <td style="border-top:1px solid #ccc;"  colspan="3"><?php echo $ns_docnum?></td>
                                           
                                        </tr>
                                        <tr >
                                           <td style="background:#f2f2f2;border-top:1px solid #ccc" class="w100 font-weight-bold">기안자</td>
                                            <td style="border-top:1px solid #ccc;width:400px;"  colspan="3"><?php echo $mb['mb_name']?></td>
                                        </tr>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">기안일</td>
                                            <td style="border-top:1px solid #ccc"  colspan="3"><?php echo $date?></td>
                                        </tr>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">보존기간</td>
                                            <td style="border-top:1px solid #ccc"  colspan="3">5년</td>
                                        </tr>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">중요도</td>
                                            <td style="border-top:1px solid #ccc"  colspan="3">
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
												
												</div>
											</td>
										</tr>
										</tbody>
										</table>
										
										<table class="add_table">
													<thead style="background:#f2f2f2;">
														<tr>
															<td rowspan="2">업체명</td>
															<td rowspan="2">견적금액</td>
															<td rowspan="2">세액</td>
															<td rowspan="2">총액</td>
															<td colspan="3">계좌정보</td>
															<td rowspan="2">대표전화</td>
															<td rowspan="2">담당자</td>
															<td rowspan="2">비고</td>
														</tr>
														<tr>
															<td >은행명</td>
															<td >계좌번호</td>
															<td >예금주</td>
														
														</tr>
													</thead>
													<tbody id="add_partner">
													
														<?php if($w == 'u') {
															
															$ns_company = explode('||', $row['ns_company']);
															
															for($i=0; $i<count($ns_company); $i++) {
																
																$ns_company_arr = explode('^', $ns_company[$i]);
														?>
															<tr id="chk_<?php echo $i?>_tr" class="chk_tr">
																<td><?php echo $ns_company_arr[0]?></td>
																<td class="text-right"><?php echo number_format($ns_company_arr[1])?></td>
																<td class="text-right"><?php echo number_format($ns_company_arr[2])?></td>
																<td class="text-right"><?php echo number_format($ns_company_arr[3])?></td>
																<td><?php echo $ns_company_arr[4]?></td>
																<td><?php echo $ns_company_arr[5]?></td>
																<td><?php echo $ns_company_arr[6]?></td>
																
																<td><?php echo $ns_company_arr[7]?></td>
																<td><?php echo $ns_company_arr[8]?></td>
																<td><?php echo $ns_company_arr[9]?></td>
																
																
															</tr>
														
														
														<?php 
															}
														}?>
														
													</tbody>
													<tfoot>
													<tr style="background:#f2f2f2;">
														<td>소계</td>
														<td id="stotal1" class="text-right"><?php echo number_format($row['ns_total_price1'])?>
														</td>
														<td id="stotal2" class="text-right"><?php echo number_format($row['ns_total_price2'])?></td>
														<td id="stotal3" class="text-right"><?php echo number_format($row['ns_total_price3'])?></td>
														<td colspan="7">
														<input type="hidden" name="stotal1_input" id="stotal1_input" value="<?php echo $row['ns_total_price1']?>">
														<input type="hidden" name="stotal2_input" id="stotal2_input" value="<?php echo $row['ns_total_price2']?>">
														<input type="hidden" name="stotal3_input" id="stotal3_input" value="<?php echo $row['ns_total_price3']?>"></td>
													</tr>
													</tfoot>
												</table>
										
										
										 <table class="table m-b-0 table-hover">
									<tbody>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="w100 font-weight-bold">외주비</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											<div class="input-group" style="width:300px !important">
												<?php echo number_format($row['ns_price2'])?>원
												</div>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">자재비</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											<div class="input-group" style="width:300px !important">
												<?php echo number_format($row['ns_price3'])?>원
												</div>
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">기타내용</td>
                                            <td style="border-top:1px solid #ccc" colspan="3" >
											<?php echo get_view_thumbnail($row['ns_content']); ?>
												
											</td>
										</tr>
										 <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">댓글</td>
                                            <td style="border-top:1px solid #ccc;white-space:normal" colspan="3" >
											
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
										
									</tbody>
									</table>
								</div>
								
							</div>
                    </div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>


<?php include_once(NONE_PATH.'/footer.php');?>

<script>
  window.print();
  window.onafterprint = function () { 
	history.go(-1);
  }

</script>
