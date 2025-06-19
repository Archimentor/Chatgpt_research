<?php 
include_once('../../_common.php');

define('menu_statistics', true);
include_once(NONE_PATH.'/header.php'); 

if(!$_GET['date'])
	$date = date('Y');

?>
<style>
.project_report h2 { font-size:25px; text-align:center; color:#000 }
.info_txt ul { list-style:none; padding:0 }
.subcontract_price { background:#f2f2f2 }
.subcontract_price td{padding:3px }
.num { text-align:right }
.input_num { border:0; width:80px; text-align:right}
.table  { font-size:13px }
.table select{ border:0;width:100%; text-align:center }
.default_row td { padding:3px}
.tit_row { text-align:center; }
.bg1 { background-color:#FDE9D9 }
.bg2 { background-color:#DAEEF3 }
.bg3 { background-color:#E5DFEC }
.bg4 { background-color:#EAF1DD }
.bg5 { background-color:#F2DBDB }
.bg6 { background-color:#e7dbef }
</style>
<!--현장별매출현황-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>통계</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">통계</li>
				<li class="breadcrumb-item active">현장별 기성집계표</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<div class="body">
							<div class="btn-group" role="group" aria-label="Basic example">
							  <button type="button" class="btn btn-secondary" onclick="location.href='?work_id=<?php echo $work_id?>&date=<?php echo ($date-1)?>'"><</button>
							  <button type="button" class="btn btn-secondary"><?php echo $date?>년</button>
							  <button type="button" class="btn btn-secondary"  onclick="location.href='?work_id=<?php echo $work_id?>&date=<?php echo ($date+1)?>'">></button>
							</div>
							<form class="float-right" style="margin-right:5px">
								<div class="input-group">
										<select name="status" id="inputState" class="form-control" onchange="location.href='?date=<?php echo $date?>&status='+this.value">
											<option value="0" <?php echo get_selected($_GET['status'], 0)?>>진행중</option>
											<option value="1" <?php echo get_selected($_GET['status'], 1)?>>완료</option>
										
										</select>
										<select name="work_id" id="inputState" class="form-control" onchange="location.href='?date=<?php echo $date?>&status=<?php echo $status?>&work_id='+this.value">
											<option value="">선택하세요</option>
											<?php 
											if($_GET['status'] == 0)
												$status = 0;
											else 
												$status = 1;
												
											$workSql = "select seq, nw_code, nw_subject  from {$none['worksite']} where nw_status  = '$status' and nw_code != '210707' order by nw_code desc";
											$workRst = sql_query($workSql);
											while($work = sql_fetch_array($workRst)) {
											
											?>
											<option value="<?php echo $work['nw_code']?>" <?php echo get_selected($work['nw_code'], $work_id)?>>[<?php echo $work['nw_code']?>] <?php echo $work['nw_subject']?></option>
											<?php }?>
											
										</select>
								</div>
							</form>
                        </div>	
						
					
						<?php 
						$work = sql_fetch("select * from  {$none['worksite']} where nw_code = '$work_id'");
					
						//최종차수 = 도급금액
						$psql = "select * from {$none['worksite_add']} where nw_id = '{$work['seq']}' order by nw_num desc limit 1";
						$prst = sql_query($psql);
						while($prow = sql_fetch_array($prst)) {
							$work['nw_price1'] = $prow['nw_price1'];
							$work['nw_vat'] = $prow['nw_vat'];
							$work['nw_contract_price'] = $prow['nw_contract_price'];
							$work['nw_price2'] = $prow['nw_price2'];
							$work['nw_add_price'] = $prow['nw_total_price'] - $work['nw_total_price'];
						}
						
						//도급액 계산
						$top_price = array();
						$top_price_sql = "SELECT DATE_FORMAT(ns_date, '%Y-%m') AS ns_date2, SUM(ns_total_price) as ns_total_price FROM {$none['sales_list']} WHERE nw_code = '$work_id' AND (ns_type = '도급기성'  or ns_type = '도급기성(현금)') AND DATE_FORMAT(ns_date, '%Y') = '$date'  GROUP BY ns_date2 ORDER BY ns_date2";
						$top_price_rst = sql_query($top_price_sql);
						while($top=sql_fetch_array($top_price_rst)) {
							$top_price[$top['ns_date2']] = $top['ns_total_price'];
						}
						
						//도급액 누계 계산
						$top_total_price = sql_fetch("SELECT SUM(ns_total_price) as price FROM {$none['sales_list']} WHERE nw_code = '$work_id' AND (ns_type = '도급기성' or ns_type = '도급기성(현금)') ");
						$top_total_price2 = sql_fetch("SELECT SUM(ns_total_price) as price FROM {$none['sales_list']} WHERE nw_code = '$work_id' AND (ns_type = '도급기성' or ns_type = '도급기성(현금)') and ns_date LIKE '$date%'");
						
						
						//보증서체크 
						$file1 = sql_fetch("select * from {$g5['board_file_table']} where bo_table = 'worksite' and bf_category = 11 and ( wr_id = '{$work['seq']}' or  bf_change_id = '{$work['seq']}' )"); // 계약보증서
						if($file1) $file1_chk = "O";
					
						$file2 = sql_fetch("select * from {$g5['board_file_table']} where bo_table = 'work' and bf_category = 13 and ( wr_id = '{$work['seq']}' or  bf_change_id = '{$work['seq']}' )"); // 선급금보증서
						if($file2) $file2_chk = "O";
						
						?>
						<div style="overflow-x:scroll">
                      
								<?php if(!$_GET['work_id']) {?>
								<p style="padding:70px 0; text-align:center; font-size:14px">먼저 현장을 선택하세요.</p>
								<?php } else {?>
								<div class="body project_report"  style="width:2400px;">
								<h2><?php echo $work['nw_subject']?></h2>
								<div class="info_txt">
									<ul>
										<li>건축주 : <?php echo get_owner_txt($work['nw_ptype3_1'])?></li>
										<li>공사기간 :  <?php echo $work['nw_sdate']?> ~ <?php echo $work['nw_edate']?></li>
									</ul>
								</div>
								<div class="table-responsive">
									<table class="table m-b-0 " style="border-top:2px solid #000">
									<thead>
										<tr>
											<th>구분</th>
											<th>업체명</th>
											<th>공종</th>
											<th>도급금액</th>
											<th>공사금액</th>
											<th>추가공사</th>
											<th>부가세</th>
											<th>계약금액</th>
											<th>계약구분</th>
											<th>미지급금</th>
											<th>유보</th>
											<th>1월</th>
											<th>2월</th>
											<th>3월</th>
											<th>4월</th>
											<th>5월</th>
											<th>6월</th>
											<th>7월</th>
											<th>8월</th>
											<th>9월</th>
											<th>10월</th>
											<th>11월</th>
											<th>12월</th>
											<th>소계</th>
											<th>누계</th>
											<th>잔금</th>
											<th>계약보증서</th>
											<th>선금급보증서</th>
										</tr>
									</thead>
									<tbody>
										<tr class="subcontract_price">
											<td class="text-center">도급액</td>
											<td></td>
											<td></td>
											<td></td>
											<td class="num"><?php echo number_format($work['nw_price1'])?></td>
											<td class="num"><?php echo number_format($work['nw_price2'])?></td>
											<td class="num"><?php echo number_format($work['nw_vat'])?></td>
											<td class="num"><?php echo number_format($work['nw_contract_price'] + $work['nw_price2'])?></td>
											<td></td>
											<td></td>
											<td></td>
											<td class="num"><?php echo number_format($top_price[$date.'-01'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-02'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-03'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-04'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-05'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-06'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-07'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-08'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-09'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-10'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-11'])?></td>
											<td class="num"><?php echo number_format($top_price[$date.'-12'])?></td>
											<td class="num"><?php echo number_format($top_total_price2['price'])?></td>
											<td class="num"><?php echo number_format($top_total_price['price'])?></td>
											<td class="num"><?php echo number_format(($work['nw_contract_price'] + $work['nw_price2']) - $top_total_price['price'])?></td>
											<td class="text-center"><?php echo $file1_chk?></td>
											<td class="text-center"><?php echo $file2_chk?></td>
										</tr>
										
										<!--외주비-->
										<?php 
										$sql1 = "select * from {$none['est_jungsan']} where nw_code = '{$work['nw_code']}' and ne_type = 1";
										$rst1 = sql_query($sql1);
										
										if($member['mb_level2'] == 2)
											${'sql'.$a} .= " and ne_admin = 0 ";
										
										
										$cnt1 = sql_num_rows($rst1);
			  
										for($i=0; $row=sql_fetch_array($rst1); $i++) {
												
										
											$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' order by ne_date desc");
											//월별 기성금 (금회기성 - 합계)
											$pprice = array();
											$psql = "select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date LIKE  '$date%' ";
											$prst = sql_query($psql);
											while($prow = sql_fetch_array($prst)) {
												
												$pprice[$prow['ne_date']] = $prow['ne_price11'];
												$pprice['total'] += $prow['ne_price11'];
												
											}
											
											//누계기성
											//전회
											$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$p['ne_date']}'";
											$pprst = sql_query($ppsql);
											
											while($pp=sql_fetch_array($pprst)) {
												$price6 = (int)$pp['price6'];
												$price7 = (int)$pp['price7'];
												$price8 = (int)$pp['price8']; 
											}
											
											//누계-합계
											$row['ne_price17'] = $price8 + $row['ne_price11'];
											
											//잔여기성
											$row['ne_price18'] = $row['ne_price5']  - $row['ne_price17'];
											
											//하도급업체인지 체크 
											$sub_name = get_enterprise_txt2($row['ne_name']);
											$subRow = sql_fetch("select * from {$none['subcontract']} where ns_bname = '$sub_name'");
											
											if($subRow)
												$gubun = "하도급계약";
											else 
												$gubun = "";
											
											$addRow = sql_fetch("select * from {$none['statistics4']} where work_id = '{$work_id}' and subseq = '{$row['seq']}'");
											
									?>
									<tr class="s1_row default_row">
											<?php if($i==0) {?>
											<td  class="tit_row bg1" rowspan="<?php echo ($cnt1+1)?>" id="s1_add_tit">외<br><br>주<br><br>비<br></td>
											<?php }?>
											<td><?php echo $row['ne_name']?></td>
											<td><?php echo $row['ne_gongjong']?></td>
											<td class="num"><?php echo number_format($row['ne_price1'])?></td>
											<td class="num"><?php echo number_format($row['ne_price3'])?></td>
											<td class="num"><input type="text" class="input_num i_price1" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price1']?>"></td>
											<td class="num"><?php echo number_format($row['ne_price4'])?></td>
											<td class="num"><?php echo number_format($row['ne_price5'])?></td>
											<td class="text-center">
											<?php if($gubun) {
												echo $gubun; 
											} else {?>
											<select class="contract" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="하도급계약" <?php echo get_selected($addRow['ns_gubun'], '하도급계약')?>>하도급계약</option>
												<option value="약정계약" <?php echo get_selected($addRow['ns_gubun'], '약정계약')?>>약정계약</option>
												<option value="시공참여" <?php echo get_selected($addRow['ns_gubun'], '시공참여')?>>시공참여</option>
												<option value="직영처리" <?php echo get_selected($addRow['ns_gubun'], '직영처리')?>>직영처리</option>
												<option value="계약안함" <?php echo get_selected($addRow['ns_gubun'], '계약안함')?>>계약안함</option>
											</select>
											<?php }?>
											</td>
											<td class="num"><input type="text" class="input_num i_price2" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price2']?>"></td>
											<td class="num"><input type="text" class="input_num i_price3" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price3']?>"></td>
											<td class="num"><?php echo number_format($pprice[$date.'-01'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-02'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-03'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-04'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-05'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-06'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-07'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-08'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-09'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-10'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-11'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-12'])?></td>
											<td class="num"><?php echo number_format($pprice['total'])?></td>
											<td class="num"><?php echo number_format($row['ne_price17'])?></td>
											<td class="num"><?php echo number_format($row['ne_price18'])?></td>
											<td class="text-center">
											<select class="license1" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O" <?php echo get_selected($addRow['ns_license1'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license1'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license1'], '면허X')?>>면허X</option>
											</select>
											</td>
											<td class="text-center">
											<select class="license2" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O"  <?php echo get_selected($addRow['ns_license2'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license2'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license2'], '면허X')?>>면허X</option>
											</select>
											</td>
										</tr>
									<?php 
									
										$s1_price1_total += $row['ne_price1']; //도급금액
										$s1_price2_total += $row['ne_price3']; //공사금액
										$s1_price3_total += $row['ne_price4']; //부가세
										$s1_price4_total += $row['ne_price5']; //계약금액
										$s1_price5_total += $pprice[$date.'-01']; //1월
										$s1_price6_total += $pprice[$date.'-02']; //2월
										$s1_price7_total += $pprice[$date.'-03']; //3월
										$s1_price8_total += $pprice[$date.'-04']; //4월
										$s1_price9_total += $pprice[$date.'-05']; //5월
										$s1_price10_total += $pprice[$date.'-06']; //6월
										$s1_price11_total += $pprice[$date.'-07']; //7월
										$s1_price12_total += $pprice[$date.'-08']; //8월
										$s1_price13_total += $pprice[$date.'-09']; //9월
										$s1_price14_total += $pprice[$date.'-10']; //10월
										$s1_price15_total += $pprice[$date.'-11']; //11월
										$s1_price16_total += $pprice[$date.'-12']; //12월
										$s1_price17_total += $row['ne_price17']; //누계
										$s1_price18_total += $row['ne_price18']; //잔금
										$s1_price19_total += $pprice['total']; //소계
								
									}
									
									unset($i);
									unset($row);
									unset($pprice);
									unset($prow);
									unset($subRow);
									unset($addRow);
									
									?>
									<tr class="bg1 default_row" style="border-bottom:2px solid #000">
										
										<td >소계</td>
									
										<td></td>
										<td class="num"><?php echo number_format($s1_price1_total)?></td>
										<td class="num"><?php echo number_format($s1_price2_total)?></td>
										<td class="num"></td>
										<td class="num"><?php echo number_format($s1_price3_total)?></td>
										<td class="num"><?php echo number_format($s1_price4_total)?></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="num"><?php echo number_format($s1_price5_total)?></td>
										<td class="num"><?php echo number_format($s1_price6_total)?></td>
										<td class="num"><?php echo number_format($s1_price7_total)?></td>
										<td class="num"><?php echo number_format($s1_price8_total)?></td>
										<td class="num"><?php echo number_format($s1_price9_total)?></td>
										<td class="num"><?php echo number_format($s1_price10_total)?></td>
										<td class="num"><?php echo number_format($s1_price11_total)?></td>
										<td class="num"><?php echo number_format($s1_price12_total)?></td>
										<td class="num"><?php echo number_format($s1_price13_total)?></td>
										<td class="num"><?php echo number_format($s1_price14_total)?></td>
										<td class="num"><?php echo number_format($s1_price15_total)?></td>
										<td class="num"><?php echo number_format($s1_price16_total)?></td>
										<td class="num"><?php echo number_format($s1_price19_total)?></td>
										<td class="num"><?php echo number_format($s1_price17_total)?></td>
										<td class="num"><?php echo number_format($s1_price18_total)?></td>
										<td></td>
										<td></td>
									</tr>
									
									
									<!--자재비-->
										<?php 
										$sql2 = "select * from {$none['est_jungsan']} where nw_code = '{$work['nw_code']}' and ne_type = 2";
										$rst2 = sql_query($sql2);
										
										if($member['mb_level2'] == 2)
											${'sql'.$a} .= " and ne_admin = 0 ";
										
										
										$cnt2 = sql_num_rows($rst2);
			  
										for($i=0; $row=sql_fetch_array($rst2); $i++) {
											
											$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' order by ne_date desc");
											
											//월별 기성금 (금회기성 - 합계)
											$pprice = array();
											$psql = "select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date LIKE  '$date%' ";
											$prst = sql_query($psql);
											while($prow = sql_fetch_array($prst)) {
												$pprice[$prow['ne_date']] = $prow['ne_price11'];
												$pprice['total'] += $prow['ne_price11'];
											}
											
											//누계기성
											//전회
											$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$p['ne_date']}'";
											$pprst = sql_query($ppsql);
											
											while($pp=sql_fetch_array($pprst)) {
												$price6 = (int)$pp['price6'];
												$price7 = (int)$pp['price7'];
												$price8 = (int)$pp['price8']; 
											}
											
											//누계-합계
											$row['ne_price17'] = $price8 + $row['ne_price11'];
											
											//잔여기성
											$row['ne_price18'] = $row['ne_price5']  - $row['ne_price17'];
											
											//하도급업체인지 체크 
											$sub_name = get_enterprise_txt2($row['ne_name']);
											$subRow = sql_fetch("select * from {$none['subcontract']} where ns_bname = '$sub_name'");
											
											if($subRow)
												$gubun = "하도급계약";
											else 
												$gubun = "";
											
											$addRow = sql_fetch("select * from {$none['statistics4']} where work_id = '{$work_id}' and subseq = '{$row['seq']}'");
											
									?>
									<tr class="s1_row default_row">
											<?php if($i==0) {?>
											<td  class="tit_row bg2" rowspan="<?php echo ($cnt2+1)?>" id="s1_add_tit">자<br><br>재<br><br>비<br></td>
											<?php }?>
											<td><?php echo $row['ne_name']?></td>
											<td><?php echo $row['ne_gongjong']?></td>
											<td class="num"><?php echo number_format($row['ne_price1'])?></td>
											<td class="num"><?php echo number_format($row['ne_price3'])?></td>
											<td class="num"><input type="text" class="input_num i_price1" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price1']?>"></td>
											<td class="num"><?php echo number_format($row['ne_price4'])?></td>
											<td class="num"><?php echo number_format($row['ne_price5'])?></td>
											<td class="text-center">
											<?php if($gubun) {
												echo $gubun; 
											} else {?>
											<select class="contract" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="하도급계약" <?php echo get_selected($addRow['ns_gubun'], '하도급계약')?>>하도급계약</option>
												<option value="약정계약" <?php echo get_selected($addRow['ns_gubun'], '약정계약')?>>약정계약</option>
												<option value="시공참여" <?php echo get_selected($addRow['ns_gubun'], '시공참여')?>>시공참여</option>
												<option value="직영처리" <?php echo get_selected($addRow['ns_gubun'], '직영처리')?>>직영처리</option>
												<option value="계약안함" <?php echo get_selected($addRow['ns_gubun'], '계약안함')?>>계약안함</option>
											</select>
											<?php }?>
											</td>
											<td class="num"><input type="text" class="input_num i_price2" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price2']?>"></td>
											<td class="num"><input type="text" class="input_num i_price3" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price3']?>"></td>
											<td class="num"><?php echo number_format($pprice[$date.'-01'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-02'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-03'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-04'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-05'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-06'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-07'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-08'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-09'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-10'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-11'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-12'])?></td>
											<td class="num"><?php echo number_format($pprice['total'])?></td>
											<td class="num"><?php echo number_format($row['ne_price17'])?></td>
											<td class="num"><?php echo number_format($row['ne_price18'])?></td>
											<td class="text-center">
											<select class="license1" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O" <?php echo get_selected($addRow['ns_license1'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license1'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license1'], '면허X')?>>면허X</option>
											</select>
											</td>
											<td class="text-center">
											<select class="license2" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O"  <?php echo get_selected($addRow['ns_license2'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license2'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license2'], '면허X')?>>면허X</option>
											</select>
											</td>
										</tr>
									<?php 
										$s2_price1_total += $row['ne_price1']; //도급금액
										$s2_price2_total += $row['ne_price3']; //공사금액
										$s2_price3_total += $row['ne_price4']; //부가세
										$s2_price4_total += $row['ne_price5']; //계약금액
										$s2_price5_total += $pprice[$date.'-01']; //1월
										$s2_price6_total += $pprice[$date.'-02']; //2월
										$s2_price7_total += $pprice[$date.'-03']; //3월
										$s2_price8_total += $pprice[$date.'-04']; //4월
										$s2_price9_total += $pprice[$date.'-05']; //5월
										$s2_price10_total += $pprice[$date.'-06']; //6월
										$s2_price11_total += $pprice[$date.'-07']; //7월
										$s2_price12_total += $pprice[$date.'-08']; //8월
										$s2_price13_total += $pprice[$date.'-09']; //9월
										$s2_price14_total += $pprice[$date.'-10']; //10월
										$s2_price15_total += $pprice[$date.'-11']; //11월
										$s2_price16_total += $pprice[$date.'-12']; //12월
										$s2_price17_total += $row['ne_price17']; //누계
										$s2_price18_total += $row['ne_price18']; //잔금
										$s2_price19_total += $pprice['total']; //소계
								
									}
									
									unset($i);
									unset($row);
									unset($pprice);
									unset($prow);
									unset($subRow);
									unset($addRow);
									?>
									<tr class="bg2 default_row" style="border-bottom:2px solid #000">
										
										<td >소계</td>
									
										<td></td>
										<td class="num"><?php echo number_format($s2_price1_total)?></td>
										<td class="num"><?php echo number_format($s2_price2_total)?></td>
										<td class="num"></td>
										<td class="num"><?php echo number_format($s2_price3_total)?></td>
										<td class="num"><?php echo number_format($s2_price4_total)?></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="num"><?php echo number_format($s2_price5_total)?></td>
										<td class="num"><?php echo number_format($s2_price6_total)?></td>
										<td class="num"><?php echo number_format($s2_price7_total)?></td>
										<td class="num"><?php echo number_format($s2_price8_total)?></td>
										<td class="num"><?php echo number_format($s2_price9_total)?></td>
										<td class="num"><?php echo number_format($s2_price10_total)?></td>
										<td class="num"><?php echo number_format($s2_price11_total)?></td>
										<td class="num"><?php echo number_format($s2_price12_total)?></td>
										<td class="num"><?php echo number_format($s2_price13_total)?></td>
										<td class="num"><?php echo number_format($s2_price14_total)?></td>
										<td class="num"><?php echo number_format($s2_price15_total)?></td>
										<td class="num"><?php echo number_format($s2_price16_total)?></td>
										<td class="num"><?php echo number_format($s2_price19_total)?></td>
										<td class="num"><?php echo number_format($s2_price17_total)?></td>
										<td class="num"><?php echo number_format($s2_price18_total)?></td>
										<td></td>
										<td></td>
									</tr>
									
									<!--장비-->
										<?php 
										$sql3 = "select * from {$none['est_jungsan']} where nw_code = '{$work['nw_code']}' and ne_type = 3";
										$rst3 = sql_query($sql3);
										
										if($member['mb_level2'] == 2)
											${'sql'.$a} .= " and ne_admin = 0 ";
										
										
										$cnt3 = sql_num_rows($rst3);
			  
										for($i=0; $row=sql_fetch_array($rst3); $i++) {
											
											$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' order by ne_date desc");
											
											//월별 기성금 (금회기성 - 합계)
											$pprice = array();
											$psql = "select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date LIKE  '$date%' ";
											$prst = sql_query($psql);
											while($prow = sql_fetch_array($prst)) {
												$pprice[$prow['ne_date']] = $prow['ne_price11'];
												$pprice['total'] += $prow['ne_price11'];
											}
											
											//누계기성
											//전회
											$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$p['ne_date']}'";
											$pprst = sql_query($ppsql);
											
											while($pp=sql_fetch_array($pprst)) {
												$price6 = (int)$pp['price6'];
												$price7 = (int)$pp['price7'];
												$price8 = (int)$pp['price8']; 
											}
											
											//누계-합계
											$row['ne_price17'] = $price8 + $row['ne_price11'];
											
											//잔여기성
											$row['ne_price18'] = $row['ne_price5']  - $row['ne_price17'];
											
											//하도급업체인지 체크 
											$sub_name = get_enterprise_txt2($row['ne_name']);
											$subRow = sql_fetch("select * from {$none['subcontract']} where ns_bname = '$sub_name'");
											
											if($subRow)
												$gubun = "하도급계약";
											else 
												$gubun = "";
											
											$addRow = sql_fetch("select * from {$none['statistics4']} where work_id = '{$work_id}' and subseq = '{$row['seq']}'");
											
									?>
									<tr class="s1_row default_row">
											<?php if($i==0) {?>
											<td  class="tit_row bg3" rowspan="<?php echo ($cnt3+1)?>" id="s1_add_tit">장<br><br>비<br><br>비<br></td>
											<?php }?>
											<td><?php echo $row['ne_name']?></td>
											<td><?php echo $row['ne_gongjong']?></td>
											<td class="num"><?php echo number_format($row['ne_price1'])?></td>
											<td class="num"><?php echo number_format($row['ne_price3'])?></td>
											<td class="num"><input type="text" class="input_num i_price1" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price1']?>"></td>
											<td class="num"><?php echo number_format($row['ne_price4'])?></td>
											<td class="num"><?php echo number_format($row['ne_price5'])?></td>
											<td class="text-center">
											<?php if($gubun) {
												echo $gubun; 
											} else {?>
											<select class="contract" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="하도급계약" <?php echo get_selected($addRow['ns_gubun'], '하도급계약')?>>하도급계약</option>
												<option value="약정계약" <?php echo get_selected($addRow['ns_gubun'], '약정계약')?>>약정계약</option>
												<option value="시공참여" <?php echo get_selected($addRow['ns_gubun'], '시공참여')?>>시공참여</option>
												<option value="직영처리" <?php echo get_selected($addRow['ns_gubun'], '직영처리')?>>직영처리</option>
												<option value="계약안함" <?php echo get_selected($addRow['ns_gubun'], '계약안함')?>>계약안함</option>
											</select>
											<?php }?>
											</td>
											<td class="num"><input type="text" class="input_num i_price2" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price2']?>"></td>
											<td class="num"><input type="text" class="input_num i_price3" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price3']?>"></td>
											<td class="num"><?php echo number_format($pprice[$date.'-01'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-02'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-03'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-04'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-05'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-06'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-07'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-08'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-09'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-10'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-11'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-12'])?></td>
											<td class="num"><?php echo number_format($pprice['total'])?></td>
											<td class="num"><?php echo number_format($row['ne_price17'])?></td>
											<td class="num"><?php echo number_format($row['ne_price18'])?></td>
											<td class="text-center">
											<select class="license1" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O" <?php echo get_selected($addRow['ns_license1'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license1'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license1'], '면허X')?>>면허X</option>
											</select>
											</td>
											<td class="text-center">
											<select class="license2" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O"  <?php echo get_selected($addRow['ns_license2'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license2'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license2'], '면허X')?>>면허X</option>
											</select>
											</td>
										</tr>
									<?php 
										$s3_price1_total += $row['ne_price1']; //도급금액
										$s3_price2_total += $row['ne_price3']; //공사금액
										$s3_price3_total += $row['ne_price4']; //부가세
										$s3_price4_total += $row['ne_price5']; //계약금액
										$s3_price5_total += $pprice[$date.'-01']; //1월
										$s3_price6_total += $pprice[$date.'-02']; //2월
										$s3_price7_total += $pprice[$date.'-03']; //3월
										$s3_price8_total += $pprice[$date.'-04']; //4월
										$s3_price9_total += $pprice[$date.'-05']; //5월
										$s3_price10_total += $pprice[$date.'-06']; //6월
										$s3_price11_total += $pprice[$date.'-07']; //7월
										$s3_price12_total += $pprice[$date.'-08']; //8월
										$s3_price13_total += $pprice[$date.'-09']; //9월
										$s3_price14_total += $pprice[$date.'-10']; //10월
										$s3_price15_total += $pprice[$date.'-11']; //11월
										$s3_price16_total += $pprice[$date.'-12']; //12월
										$s3_price17_total += $row['ne_price17']; //누계
										$s3_price18_total += $row['ne_price18']; //잔금
										$s3_price19_total += $pprice['total']; //소계
								
									}
									
									unset($i);
									unset($row);
									unset($pprice);
									unset($prow);
									unset($subRow);
									unset($addRow);
									?>
									<tr class="bg3 default_row" style="border-bottom:2px solid #000">
										
										<td >소계</td>
									
										<td></td>
										<td class="num"><?php echo number_format($s3_price1_total)?></td>
										<td class="num"><?php echo number_format($s3_price2_total)?></td>
										<td class="num"></td>
										<td class="num"><?php echo number_format($s3_price3_total)?></td>
										<td class="num"><?php echo number_format($s3_price4_total)?></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="num"><?php echo number_format($s3_price5_total)?></td>
										<td class="num"><?php echo number_format($s3_price6_total)?></td>
										<td class="num"><?php echo number_format($s3_price7_total)?></td>
										<td class="num"><?php echo number_format($s3_price8_total)?></td>
										<td class="num"><?php echo number_format($s3_price9_total)?></td>
										<td class="num"><?php echo number_format($s3_price10_total)?></td>
										<td class="num"><?php echo number_format($s3_price11_total)?></td>
										<td class="num"><?php echo number_format($s3_price12_total)?></td>
										<td class="num"><?php echo number_format($s3_price13_total)?></td>
										<td class="num"><?php echo number_format($s3_price14_total)?></td>
										<td class="num"><?php echo number_format($s3_price15_total)?></td>
										<td class="num"><?php echo number_format($s3_price16_total)?></td>
										<td class="num"><?php echo number_format($s3_price19_total)?></td>
										<td class="num"><?php echo number_format($s3_price17_total)?></td>
										<td class="num"><?php echo number_format($s3_price18_total)?></td>
										<td></td>
										<td></td>
									</tr>
									
									<!--노무비-->
										<?php 
										$sql4 = "select * from {$none['est_jungsan']} where nw_code = '{$work['nw_code']}' and ne_type = 4";
										$rst4 = sql_query($sql4);
										
										if($member['mb_level2'] == 2)
											${'sql'.$a} .= " and ne_admin = 0 ";
										
										
										$cnt4 = sql_num_rows($rst4);
			  
										for($i=0; $row=sql_fetch_array($rst4); $i++) {
											
											$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' order by ne_date desc");
											
											//월별 기성금 (금회기성 - 합계)
											$pprice = array();
											$psql = "select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date LIKE  '$date%' ";
											$prst = sql_query($psql);
											while($prow = sql_fetch_array($prst)) {
												$pprice[$prow['ne_date']] = $prow['ne_price11'];
												$pprice['total'] += $prow['ne_price11'];
											}
											
											//누계기성
											//전회
											$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$p['ne_date']}'";
											$pprst = sql_query($ppsql);
											
											while($pp=sql_fetch_array($pprst)) {
												$price6 = (int)$pp['price6'];
												$price7 = (int)$pp['price7'];
												$price8 = (int)$pp['price8']; 
											}
											
											//누계-합계
											$row['ne_price17'] = $price8 + $row['ne_price11'];
											
											//잔여기성
											$row['ne_price18'] = $row['ne_price5']  - $row['ne_price17'];
											
											//하도급업체인지 체크 
											$sub_name = get_enterprise_txt2($row['ne_name']);
											$subRow = sql_fetch("select * from {$none['subcontract']} where ns_bname = '$sub_name'");
											
											if($subRow)
												$gubun = "하도급계약";
											else 
												$gubun = "";
											
											$addRow = sql_fetch("select * from {$none['statistics4']} where work_id = '{$work_id}' and subseq = '{$row['seq']}'");
											
									?>
									<tr class="s1_row default_row">
											<?php if($i==0) {?>
											<td  class="tit_row bg4" rowspan="<?php echo ($cnt4+1)?>" id="s1_add_tit">노<br><br>무<br><br>비<br></td>
											<?php }?>
											<td><?php echo $row['ne_name']?></td>
											<td><?php echo $row['ne_gongjong']?></td>
											<td class="num"><?php echo number_format($row['ne_price1'])?></td>
											<td class="num"><?php echo number_format($row['ne_price3'])?></td>
											<td class="num"><input type="text" class="input_num i_price1" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price1']?>"></td>
											<td class="num"><?php echo number_format($row['ne_price4'])?></td>
											<td class="num"><?php echo number_format($row['ne_price5'])?></td>
											<td class="text-center">
											<?php if($gubun) {
												echo $gubun; 
											} else {?>
											<select class="contract" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="하도급계약" <?php echo get_selected($addRow['ns_gubun'], '하도급계약')?>>하도급계약</option>
												<option value="약정계약" <?php echo get_selected($addRow['ns_gubun'], '약정계약')?>>약정계약</option>
												<option value="시공참여" <?php echo get_selected($addRow['ns_gubun'], '시공참여')?>>시공참여</option>
												<option value="직영처리" <?php echo get_selected($addRow['ns_gubun'], '직영처리')?>>직영처리</option>
												<option value="계약안함" <?php echo get_selected($addRow['ns_gubun'], '계약안함')?>>계약안함</option>
											</select>
											<?php }?>
											</td>
											<td class="num"><input type="text" class="input_num i_price2" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price2']?>"></td>
											<td class="num"><input type="text" class="input_num i_price3" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price3']?>"></td>
											<td class="num"><?php echo number_format($pprice[$date.'-01'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-02'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-03'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-04'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-05'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-06'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-07'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-08'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-09'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-10'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-11'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-12'])?></td>
											<td class="num"><?php echo number_format($pprice['total'])?></td>
											<td class="num"><?php echo number_format($row['ne_price17'])?></td>
											<td class="num"><?php echo number_format($row['ne_price18'])?></td>
											<td class="text-center">
											<select class="license1" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O" <?php echo get_selected($addRow['ns_license1'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license1'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license1'], '면허X')?>>면허X</option>
											</select>
											</td>
											<td class="text-center">
											<select class="license2" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O"  <?php echo get_selected($addRow['ns_license2'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license2'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license2'], '면허X')?>>면허X</option>
											</select>
											</td>
										</tr>
									<?php 
										$s4_price1_total += $row['ne_price1']; //도급금액
										$s4_price2_total += $row['ne_price3']; //공사금액
										$s4_price3_total += $row['ne_price4']; //부가세
										$s4_price4_total += $row['ne_price5']; //계약금액
										$s4_price5_total += $pprice[$date.'-01']; //1월
										$s4_price6_total += $pprice[$date.'-02']; //2월
										$s4_price7_total += $pprice[$date.'-03']; //3월
										$s4_price8_total += $pprice[$date.'-04']; //4월
										$s4_price9_total += $pprice[$date.'-05']; //5월
										$s4_price10_total += $pprice[$date.'-06']; //6월
										$s4_price11_total += $pprice[$date.'-07']; //7월
										$s4_price12_total += $pprice[$date.'-08']; //8월
										$s4_price13_total += $pprice[$date.'-09']; //9월
										$s4_price14_total += $pprice[$date.'-10']; //10월
										$s4_price15_total += $pprice[$date.'-11']; //11월
										$s4_price16_total += $pprice[$date.'-12']; //12월
										$s4_price17_total += $row['ne_price17']; //누계
										$s4_price18_total += $row['ne_price18']; //잔금
										$s4_price19_total += $pprice['total']; //잔금
								
									}
									
									unset($i);
									unset($row);
									unset($pprice);
									unset($prow);
									unset($subRow);
									unset($addRow);
									?>
									<tr class="bg4 default_row" style="border-bottom:2px solid #000">
										
										<td >소계</td>
									
										<td></td>
										<td class="num"><?php echo number_format($s4_price1_total)?></td>
										<td class="num"><?php echo number_format($s4_price2_total)?></td>
										<td class="num"></td>
										<td class="num"><?php echo number_format($s4_price3_total)?></td>
										<td class="num"><?php echo number_format($s4_price4_total)?></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="num"><?php echo number_format($s4_price5_total)?></td>
										<td class="num"><?php echo number_format($s4_price6_total)?></td>
										<td class="num"><?php echo number_format($s4_price7_total)?></td>
										<td class="num"><?php echo number_format($s4_price8_total)?></td>
										<td class="num"><?php echo number_format($s4_price9_total)?></td>
										<td class="num"><?php echo number_format($s4_price10_total)?></td>
										<td class="num"><?php echo number_format($s4_price11_total)?></td>
										<td class="num"><?php echo number_format($s4_price12_total)?></td>
										<td class="num"><?php echo number_format($s4_price13_total)?></td>
										<td class="num"><?php echo number_format($s4_price14_total)?></td>
										<td class="num"><?php echo number_format($s4_price15_total)?></td>
										<td class="num"><?php echo number_format($s4_price16_total)?></td>
										<td class="num"><?php echo number_format($s4_price19_total)?></td>
										<td class="num"><?php echo number_format($s4_price17_total)?></td>
										<td class="num"><?php echo number_format($s4_price18_total)?></td>
										<td></td>
										<td></td>
									</tr>
									
									<!--기타경비-->
										<?php 
										$sql5 = "select * from {$none['est_jungsan']} where nw_code = '{$work['nw_code']}' and ne_type = 5";
										if($member['mb_level2'] == 2)
											$sql5 .= " and ne_admin = 0 ";
										
										
										$rst5 = sql_query($sql5);
										
									
										
										$cnt5 = sql_num_rows($rst5);
			  
										for($i=0; $row=sql_fetch_array($rst5); $i++) {
											
											$p = sql_fetch("select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' order by ne_date desc");
											
											//월별 기성금 (금회기성 - 합계)
											$pprice = array();
											$psql = "select * from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date LIKE  '$date%' ";
											$prst = sql_query($psql);
											while($prow = sql_fetch_array($prst)) {
												$pprice[$prow['ne_date']] = $prow['ne_price11'];
												$pprice['total'] += $prow['ne_price11'];
											}
											
											//누계기성
											//전회
											$ppsql = "select SUM(ne_price9) AS price6, SUM(ne_price10) AS price7, SUM(ne_price11) AS price8 from {$none['est_jungsan_price']} where parent_id = '{$row['seq']}' and ne_date < '{$p['ne_date']}'";
											$pprst = sql_query($ppsql);
											
											while($pp=sql_fetch_array($pprst)) {
												$price6 = (int)$pp['price6'];
												$price7 = (int)$pp['price7'];
												$price8 = (int)$pp['price8']; 
											}
											
											//누계-합계
											$row['ne_price17'] = $price8 + $row['ne_price11'];
											
											//잔여기성
											$row['ne_price18'] = $row['ne_price5']  - $row['ne_price17'];
											
											//하도급업체인지 체크 
											$sub_name = get_enterprise_txt2($row['ne_name']);
											$subRow = sql_fetch("select * from {$none['subcontract']} where ns_bname = '$sub_name'");
											
											if($subRow)
												$gubun = "하도급계약";
											else 
												$gubun = "";
											
											$addRow = sql_fetch("select * from {$none['statistics4']} where work_id = '{$work_id}' and subseq = '{$row['seq']}'");
											
											if($row['ne_admin'] == 1) $bonsa = 'style="color:red;font-weight:600;"';
											else $bonsa = "";
											
									?>
									<tr class="s1_row default_row">
											<?php if($i==0) {?>
											<td  class="tit_row bg5" rowspan="<?php echo ($cnt5+1)?>" id="s1_add_tit">기<br><br>타<br><br>경<br><br>비</td>
											<?php }?>
											<td <?php echo $bonsa?>><?php echo $row['ne_name']?></td>
											<td><?php echo $row['ne_gongjong']?></td>
											<td class="num"><?php echo number_format($row['ne_price1'])?></td>
											<td class="num"><?php echo number_format($row['ne_price3'])?></td>
											<td class="num"><input type="text" class="input_num i_price1" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price1']?>"></td>
											<td class="num"><?php echo number_format($row['ne_price4'])?></td>
											<td class="num"><?php echo number_format($row['ne_price5'])?></td>
											<td class="text-center">
											<?php if($gubun) {
												echo $gubun; 
											} else {?>
											<select class="contract" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="하도급계약" <?php echo get_selected($addRow['ns_gubun'], '하도급계약')?>>하도급계약</option>
												<option value="약정계약" <?php echo get_selected($addRow['ns_gubun'], '약정계약')?>>약정계약</option>
												<option value="시공참여" <?php echo get_selected($addRow['ns_gubun'], '시공참여')?>>시공참여</option>
												<option value="직영처리" <?php echo get_selected($addRow['ns_gubun'], '직영처리')?>>직영처리</option>
												<option value="계약안함" <?php echo get_selected($addRow['ns_gubun'], '계약안함')?>>계약안함</option>
											</select>
											<?php }?>
											</td>
											<td class="num"><input type="text" class="input_num i_price2" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price2']?>"></td>
											<td class="num"><input type="text" class="input_num i_price3" data="<?php echo $row['seq']?>" value="<?php echo $addRow['ns_price3']?>"></td>
											<td class="num"><?php echo number_format($pprice[$date.'-01'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-02'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-03'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-04'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-05'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-06'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-07'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-08'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-09'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-10'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-11'])?></td>
											<td class="num"><?php echo number_format($pprice[$date.'-12'])?></td>
											<td class="num"><?php echo number_format($pprice['total'])?></td>
											<td class="num"><?php echo number_format($row['ne_price17'])?></td>
											<td class="num"><?php echo number_format($row['ne_price18'])?></td>
											<td class="text-center">
											<select class="license1" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O" <?php echo get_selected($addRow['ns_license1'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license1'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license1'], '면허X')?>>면허X</option>
											</select>
											</td>
											<td class="text-center">
											<select class="license2" data="<?php echo $row['seq']?>">
												<option value=""></option>
												<option value="O"  <?php echo get_selected($addRow['ns_license2'], 'O')?>>O</option>
												<option value="X" <?php echo get_selected($addRow['ns_license2'], 'X')?>>X</option>
												<option value="면허X" <?php echo get_selected($addRow['ns_license2'], '면허X')?>>면허X</option>
											</select>
											</td>
										</tr>
									<?php 
										$s5_price1_total += $row['ne_price1']; //도급금액
										$s5_price2_total += $row['ne_price3']; //공사금액
										$s5_price3_total += $row['ne_price4']; //부가세
										$s5_price4_total += $row['ne_price5']; //계약금액
										$s5_price5_total += $pprice[$date.'-01']; //1월
										$s5_price6_total += $pprice[$date.'-02']; //2월
										$s5_price7_total += $pprice[$date.'-03']; //3월
										$s5_price8_total += $pprice[$date.'-04']; //4월
										$s5_price9_total += $pprice[$date.'-05']; //5월
										$s5_price10_total += $pprice[$date.'-06']; //6월
										$s5_price11_total += $pprice[$date.'-07']; //7월
										$s5_price12_total += $pprice[$date.'-08']; //8월
										$s5_price13_total += $pprice[$date.'-09']; //9월
										$s5_price14_total += $pprice[$date.'-10']; //10월
										$s5_price15_total += $pprice[$date.'-11']; //11월
										$s5_price16_total += $pprice[$date.'-12']; //12월
										$s5_price17_total += $row['ne_price17']; //누계
										$s5_price18_total += $row['ne_price18']; //잔금
										$s5_price19_total += $pprice['total']; //소계
								
									}
									
									unset($i);
									unset($row);
									unset($pprice);
									unset($prow);
									unset($subRow);
									unset($addRow);
									?>
									<tr class="bg5 default_row" style="border-bottom:2px solid #000">
										
										<td >소계</td>
									
										<td></td>
										<td class="num"><?php echo number_format($s5_price1_total)?></td>
										<td class="num"><?php echo number_format($s5_price2_total)?></td>
										<td class="num"></td>
										<td class="num"><?php echo number_format($s5_price3_total)?></td>
										<td class="num"><?php echo number_format($s5_price4_total)?></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="num"><?php echo number_format($s5_price5_total)?></td>
										<td class="num"><?php echo number_format($s5_price6_total)?></td>
										<td class="num"><?php echo number_format($s5_price7_total)?></td>
										<td class="num"><?php echo number_format($s5_price8_total)?></td>
										<td class="num"><?php echo number_format($s5_price9_total)?></td>
										<td class="num"><?php echo number_format($s5_price10_total)?></td>
										<td class="num"><?php echo number_format($s5_price11_total)?></td>
										<td class="num"><?php echo number_format($s5_price12_total)?></td>
										<td class="num"><?php echo number_format($s5_price13_total)?></td>
										<td class="num"><?php echo number_format($s5_price14_total)?></td>
										<td class="num"><?php echo number_format($s5_price15_total)?></td>
										<td class="num"><?php echo number_format($s5_price16_total)?></td>
										<td class="num"><?php echo number_format($s5_price19_total)?></td>
										<td class="num"><?php echo number_format($s5_price17_total)?></td>
										<td class="num"><?php echo number_format($s5_price18_total)?></td>
										<td></td>
										<td></td>
									</tr>
									
									
									<tr class="bg6 default_row" style="border-bottom:2px solid #000">
										
										<td colspan="3" class="text-center"><strong>총계</strong></td>
									
										<td class="num"><?php echo number_format($s1_price1_total+$s2_price1_total+$s3_price1_total+$s4_price1_total+$s5_price1_total)?></td>
										<td class="num"><?php echo number_format($s1_price2_total+$s2_price2_total+$s3_price2_total+$s4_price2_total+$s5_price2_total)?></td>
										<td class="num"></td>
										<td class="num"><?php echo number_format($s1_price3_total+$s2_price3_total+$s3_price3_total+$s4_price3_total+$s5_price3_total)?></td>
										<td class="num"><?php echo number_format($s1_price4_total+$s2_price4_total+$s3_price4_total+$s4_price4_total+$s5_price4_total)?></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="num"><?php echo number_format($s1_price5_total+$s2_price5_total+$s3_price5_total+$s4_price5_total+$s5_price5_total)?></td>
										<td class="num"><?php echo number_format($s1_price6_total+$s2_price6_total+$s3_price6_total+$s4_price6_total+$s5_price6_total)?></td>
										<td class="num"><?php echo number_format($s1_price7_total+$s2_price7_total+$s3_price7_total+$s4_price7_total+$s5_price7_total)?></td>
										<td class="num"><?php echo number_format($s1_price8_total+$s2_price8_total+$s3_price8_total+$s4_price8_total+$s5_price8_total)?></td>
										<td class="num"><?php echo number_format($s1_price9_total+$s2_price9_total+$s3_price9_total+$s4_price9_total+$s5_price9_total)?></td>
										<td class="num"><?php echo number_format($s1_price10_total+$s2_price10_total+$s3_price10_total+$s4_price10_total+$s5_price10_total)?></td>
										<td class="num"><?php echo number_format($s1_price11_total+$s2_price11_total+$s3_price11_total+$s4_price11_total+$s5_price11_total)?></td>
										<td class="num"><?php echo number_format($s1_price12_total+$s2_price12_total+$s3_price12_total+$s4_price12_total+$s5_price12_total)?></td>
										<td class="num"><?php echo number_format($s1_price13_total+$s2_price13_total+$s3_price13_total+$s4_price13_total+$s5_price13_total)?></td>
										<td class="num"><?php echo number_format($s1_price14_total+$s2_price14_total+$s3_price14_total+$s4_price14_total+$s5_price14_total)?></td>
										<td class="num"><?php echo number_format($s1_price15_total+$s2_price15_total+$s3_price15_total+$s4_price15_total+$s5_price15_total)?></td>
										<td class="num"><?php echo number_format($s1_price16_total+$s2_price16_total+$s3_price16_total+$s4_price16_total+$s5_price16_total)?></td>
										<td class="num"><?php echo number_format($s1_price19_total+$s2_price19_total+$s3_price19_total+$s4_price19_total+$s5_price19_total)?></td>
										<td class="num"><?php echo number_format($s1_price17_total+$s2_price17_total+$s3_price17_total+$s4_price17_total+$s5_price17_total)?></td>
										<td class="num"><?php echo number_format($s1_price18_total+$s2_price18_total+$s3_price18_total+$s4_price18_total+$s5_price18_total)?></td>
										<td></td>
										<td></td>
									</tr>
									
									</tbody>
									</table>
								</div>
								</div>
								
								
								
								<?php } //end if?>
							
						</div>
						
                    </div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>


<?php include_once(NONE_PATH.'/footer.php');?>
<script>

function comma(str) {
 str = String(str);
 return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}

function uncomma(str) {
 str = String(str);
 return str.replace(/[^\d]+/g, '');
}

 function removeComma() {
	$('.input_num').each(function() {
		$(this).val(uncomma($(this).val()));
		
	})
	
 }
$(function() {
	$('.input_num').each(function() {
		
			
		$(this).val(comma($(this).val()));
		
	})
	
	$(document).on('keyup', '.input_num', function() {
		 
		var v = comma(uncomma($(this).val()));
	
		$(this).val(v);
	})
	
	$('.i_price1').bind('blur', function() {
		var subseq = $(this).attr('data');
		$.post('./menu4.update.php', { type: 'i_price1', work_id : '<?php echo $work_id?>', subseq : subseq, data : $(this).val() }, function(data) {
			
		})
	})
	$('.i_price2').bind('blur', function() {
		var subseq = $(this).attr('data');
		$.post('./menu4.update.php', { type: 'i_price2', work_id : '<?php echo $work_id?>', subseq : subseq, data : $(this).val() }, function(data) {
			
		})
	})
	$('.i_price3').bind('blur', function() {
		var subseq = $(this).attr('data');
		$.post('./menu4.update.php', { type: 'i_price3', work_id : '<?php echo $work_id?>', subseq : subseq, data : $(this).val() }, function(data) {
			
		})
	})
	$('.contract').bind('change', function() {
		var subseq = $(this).attr('data');
		$.post('./menu4.update.php', { type: 'contract', work_id : '<?php echo $work_id?>', subseq : subseq, data : $(this).val() }, function(data) {
			
		})
	})
	$('.license1').bind('blur', function() {
		var subseq = $(this).attr('data');
		$.post('./menu4.update.php', { type: 'license1', work_id : '<?php echo $work_id?>', subseq : subseq, data : $(this).val() }, function(data) {
			
		})
	})
	$('.license2').bind('blur', function() {
		var subseq = $(this).attr('data');
		$.post('./menu4.update.php', { type: 'license2', work_id : '<?php echo $work_id?>', subseq : subseq, data : $(this).val() }, function(data) {
			
		})
	})
	
})


</script>