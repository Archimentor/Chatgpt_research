<?php 
include_once('../../_common.php');
define('menu_statistics', true);
include_once(NONE_PATH.'/header.php'); 
?>
<style>
td.none { background:#f7f7f7 }
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
				<li class="breadcrumb-item active">현장별 매출현황</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<div class="body">
							
							<form class="float-right" style="margin-right:5px">
								<div class="input-group">
										 <a class="btn btn-primary float-right" href="../write/menu2_write.php" role="button" style="margin-right:5px">매출현황 등록</a> 
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
					
						//차수 증감에 따른 금액 더하기
						$psql = "select * from {$none['worksite_add']} where nw_id = '{$work['seq']}' order by nw_num desc limit 1";
						$prst = sql_query($psql);
						while($prow = sql_fetch_array($prst)) {
							$work['nw_price1'] = $prow['nw_price1'];
							$work['nw_vat'] = $prow['nw_vat'];
							$work['nw_contract_price'] = $prow['nw_contract_price'];
							$work['nw_price2'] = $prow['nw_price2'];
						}
						
						?>
                        <div class="body project_report">
						
                            <div class="table-responsive">
                                <table class="table m-b-0 ">
									<tbody>
                                        <tr >
                                            <td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold">현장명</td>
                                            <td colspan="8" style="border-top:1px solid #ccc">
											<?php if($work) {?>
											[<?php echo $work['nw_code']?>] <?php echo $work['nw_subject']?>
											<?php } else {?>
											조회 된 데이터가 없습니다.
											<?php }?>
											</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3" style="background:#f2f2f2" class="font-weight-bold">공사금액</td>
                                            
                                        </tr>
										<tr>
											<td class="text-center" style="width:150px;background:#f2f2f2;border-top:1px solid #ccc">공급가액</td>
											<td class="text-center" style="width:150px;background:#f2f2f2;border-top:1px solid #ccc">부가세</td>
											<td class="text-center" style="width:150px;background:#f2f2f2;border-top:1px solid #ccc">계약금액</td>
											<td class="text-center" style="width:150px;background:#f2f2f2;border-top:1px solid #ccc">현금계약금액</td>
											<td class="text-center" style="width:150px;background:#f2f2f2;border-top:1px solid #ccc">총액(계약금액+현금계약금액)</td>
											<td colspan="4" style="border-top:1px solid #ccc"></td>
											
										</tr>
										<tr>
											<td class="text-right"><?php echo number_format($work['nw_price1'])?></td>
											<td class="text-right"><?php echo number_format($work['nw_vat'])?></td>
											<td class="text-right"><?php echo number_format($work['nw_contract_price'])?></td>
											<td class="text-right"><?php echo number_format($work['nw_price2'])?></td>
											<td class="text-right"><?php echo number_format($work['nw_contract_price'] + $work['nw_price2'])?></td>
											<td colspan="4"></td>
											
											
										</tr>
                                        <tr>
                                            <td style="background:#f2f2f2" class="font-weight-bold">공사기간</td>
                                            <td colspan="8"><?php echo $work['nw_sdate']?> ~ <?php echo $work['nw_edate']?></td>
                                        </tr>
                                        <tr>
                                            <td style="background:#f2f2f2" class="font-weight-bold">주소</td>
                                            <td colspan="8"><?php echo $work['nw_addr']?></td>
                                        </tr>
									
									
										<?php 
										$sql = "select * from {$none['sales_list']} where nw_code = '$work_id' order by ns_date desc";
										$rst = sql_query($sql);
										for($z=0; $row=sql_fetch_array($rst); $z++) {
											$data[] = $row;
										}
										krsort($data);
										
										?>
										<tr style="border-top:2px solid #ccc">
											<td colspan="5" class="text-center font-weight-bold" style="background:#f2f2f2;border-right:2px solid #ccc">세금계산서</td>
											<td colspan="4" class="text-center font-weight-bold" style="background:#f2f2f2">도급기성</td>
										</tr>
										<tr  style="background:#fbf4f4">
											<td class="text-center">작성일자</td>
											<td class="text-center">공급가액</td>
											<td class="text-center">세액</td>
											<td class="text-center">합계</td>
											<td class="text-center"  style="border-right:2px solid #ccc">발행률</td>
											<td class="text-center">입금일</td>
											<td class="text-center">금액</td>
											<td class="text-center">입금률</td>
											<td class="text-center">입금통장</td>
										
										</tr>
										
										<?php 
										
										
										foreach ($data as $subType) {
											
											echo '<tr>';
											//계약금액만
											$nw_contract_price = (int)$work['nw_contract_price'];
											
											//계약금액+현금금액 
											$nw_contract_price2 = (int)$work['nw_contract_price'] + (int)$work['nw_price2'];
											
											
											if($subType['ns_type'] == "세금계산서") {
												
												//발행률 구하기 
												$taxPersent = $subType['ns_total_price'] / $nw_contract_price * 100; 
											
												
												echo '<td class="text-center">'. date('y년 m월 d일', strtotime($subType['ns_date'])) .'</td>';
												echo '<td class="text-right">'. number_format($subType['ns_price']) .'</td>';
												echo '<td class="text-right">'. number_format($subType['ns_vat']) .'</td>';
												echo '<td class="text-right" >'. number_format($subType['ns_total_price']) .'</td>';
												echo '<td  class="text-right" style="border-right:2px solid #ccc">'.number_format($taxPersent, 2).'%</td>';
												echo '<td class="none"></td>';
												echo '<td class="none"></td>';
												echo '<td class="none"></td>';
												echo '<td class="none"></td>';
												
												$taxSum1 += $subType['ns_price'];
												$taxSum2 += $subType['ns_vat'];
												$taxTotal += $subType['ns_total_price'];
												$taxSumPersent += number_format($taxPersent, 2);
											
												
												if(in_array(date('m', strtotime($subType['ns_date'])), array('01', '02', '03', '04', '05', '06'))) {
													//상반기
													$firstHalf_total += $subType['ns_total_price'];
												} else {
													//하반기
													$secondHalf_total += $subType['ns_total_price'];
												}
											
												
											} else if($subType['ns_type'] == "도급기성" || $subType['ns_type'] == "도급기성(현금)") {
												
												//입금률 구하기 
												$pricePersent = $subType['ns_total_price'] / $nw_contract_price2 * 100; 
												
												$priceSum2 += $subType['ns_total_price'];
												
												//잔금 
												$blance = $nw_contract_price2 - $priceSum2;
												
												echo '<td class="none"></td>';
												echo '<td class="none"></td>';
												echo '<td class="none"></td>';
												echo '<td class="none"></td>';
												echo '<td class="none" style="border-right:2px solid #ccc"></td>';
												echo '<td class="text-center">'.date('y년  m월 d일', strtotime($subType['ns_date'])) .'</td>';
												echo '<td class="text-right">'. number_format($subType['ns_total_price']) .'</td>';
												echo '<td class="text-right">'.number_format($pricePersent, 2).'%</td>';
												echo '<td class="text-right">'.$subType['ns_account'].'</td>';
												
												$priceSum += $subType['ns_total_price'];
												$priceSumPersent += number_format($pricePersent, 2);
												
												
												if(in_array(date('m', strtotime($subType['ns_date'])), array('01', '02', '03', '04', '05', '06'))) {
													//상반기
													$firstHalf_ptotal += $subType['ns_total_price'];
												} else {
													//하반기
													$secondHalf_ptotal += $subType['ns_total_price'];
												}
												
											}
											
											//도급기성 현금 제외 따로
											if($subType['ns_type'] == "도급기성") {
												$misu += $subType['ns_total_price'];
												$misu2 += $subType['ns_total_price'];
											} 
											
											echo '</tr>';
										}?>
										
										
										<tr style="background:#f2f2f2;border-top:2px solid #ccc">
											<!--세금계싼서-->
											<td class="text-right font-weight-bold">합계</td>
											<td style="color:#cf3434" class="text-right font-weight-bold"><?php echo number_format($taxSum1)?></td>
										
											<td style="color:#cf3434" class="text-right font-weight-bold"><?php echo number_format($taxSum2)?></td>
											
											<td style="color:#cf3434" class="text-right font-weight-bold"><?php echo number_format($taxTotal)?></td>
										
											<td style="color:#cf3434;border-right:2px solid #ccc" class="text-right font-weight-bold"><?php echo number_format(($taxTotal / $work['nw_contract_price'] * 100), 2);  ?>%</td>
											<!--도급기성-->
											<td class="text-right font-weight-bold">합계</td>
											<td style="color:#cf3434" class="text-right font-weight-bold">
											<?php echo number_format($priceSum)?>
											
											</td>
											<td style="color:#cf3434" class="text-right font-weight-bold"><?php echo number_format( ($priceSum / ((int)$work['nw_contract_price'] + (int)$work['nw_price2']) * 100), 2);  ?>%</td>
											<td ></td>
											
										</tr>
										<tr style="background:#f2f2f2">
											<td colspan="3" class="text-right font-weight-bold">계산서 잔액</td>
											<td style="color:#cf3434" class="text-right font-weight-bold"><?php echo number_format(($nw_contract_price - $taxTotal))?></td>
											<td style="border-right:2px solid #ccc"></td>
											<td class="text-right font-weight-bold">미수금</td>
											<td style="color:#cf3434" class="text-right font-weight-bold"><?php echo number_format(($taxTotal - $misu))?></td>
											<td class="text-right font-weight-bold">잔금</td>
											<td style="color:#cf3434" class="text-right font-weight-bold"><?php echo number_format(($work['nw_contract_price'] + $work['nw_price2'])- $priceSum)?></td>
											
										</tr>
										
										</table>
										
										
										
									
									</tbody>
									</table>
								</div>
							
							</div>
						
                    </div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>
<script>
function del_(seq) {
	
	if(confirm('정말 시공현황 정보를 삭제하시겠습니까?\n\n연동 된 정보가 있다면 모두 해제 됩니다.')) {
		location.href = '/_worksite/write/menu1_update.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
</script>

<?php include_once(NONE_PATH.'/footer.php');?>