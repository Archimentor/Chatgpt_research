<?php 
include_once('../../_common.php');
define('menu_document', true);
include_once(NONE_PATH.'/header.php'); 

if(!$_GET['date'])
	$date = date('Y');


$sql_common = " from  {$none['subcontract']}  ";
$sql_search = " where  (1)";


if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " (work_name like '%$stx%' or ns_bname_txt LIKE '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
} else {
	
        if($work) {
                $sql_search .= " and work_id = '$work' ";
        } else {
                $sql_search .= " and ns_sdate LIKE '$date%' ";
        }
}

// 현장소장 권한일 경우 본인 현장만 조회
if($member['mb_level2'] == 2) {
    $sql_search .= " AND work_id IN (SELECT nw_code FROM {$none['worksite']} WHERE (
        nw_ptype1_1 = '{$member['mb_id']}' OR
        nw_ptype1_2 = '{$member['mb_id']}' OR
        nw_ptype1_3 = '{$member['mb_id']}' OR
        nw_ptype1_4 = '{$member['mb_id']}' OR
        nw_ptype1_5 = '{$member['mb_id']}' OR
        nw_ptype1_6 = '{$member['mb_id']}' OR
        nw_ptype2_1 = '{$member['mb_id']}' OR
        nw_ptype2_2 = '{$member['mb_id']}' OR
        nw_ptype2_3 = '{$member['mb_id']}' OR
        nw_ptype2_4 = '{$member['mb_id']}' OR
        nw_ptype2_5 = '{$member['mb_id']}' OR
        nw_ptype2_6 = '{$member['mb_id']}'
    ))";
}

if (!$sst) {
    $sst  = "work_id";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 600;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql, true);

$qstr .= "date=$date&amp;stx=$stx&amp;work={$_GET['work']}";


?>
<style>
.no_file { color:#ddd }
</style>
<!--도급계약총괄표 리스트-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>문서관리</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">문서관리</li>
				<li class="breadcrumb-item active">하도급계약서류</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<div class="body">
						
                           <div class="btn-group" role="group" aria-label="Basic example">
							  <button type="button" class="btn btn-secondary" onclick="location.href='?date=<?php echo ($date-1)?>'"><</button>
							  <button type="button" class="btn btn-secondary"><?php echo $date?>년</button>
							  <button type="button" class="btn btn-secondary"  onclick="location.href='?date=<?php echo ($date+1)?>'">></button>
							</div>
							
							<form class="float-right" style="margin-right:5px">
								<div class="input-group">
									<select name="status" id="inputState" class="form-control" onchange="location.href='?work='+this.value">
										<option value="">현장별 보기 선택</option>
											
											<optgroup label="진행현장">
												<?php 
												$workSql = "select seq, nw_code, nw_subject, pj_title_kr  from {$none['worksite']} where nw_status  = '0' and nw_code != '210707' order by nw_code desc";
												$workRst = sql_query($workSql);
												while($work = sql_fetch_array($workRst)) {
													
													$nw_code = $work['nw_code'].' '.$work['pj_title_kr'];
												?>
												<option value="<?php echo $work['nw_code']?>" <?php echo get_selected($work['nw_code'], $_GET['work'])?>><?php echo $nw_code?></option>
												<?php }?>
												
											</optgroup>
											<optgroup label="완료현장">
											<?php 
												$workSql2 = "select seq, nw_code, nw_subject, pj_title_kr  from {$none['worksite']} where nw_status  = '1' and nw_code != '210707' order by nw_code desc";
												$workRst2 = sql_query($workSql2);
												while($work2 = sql_fetch_array($workRst2)) {
													
													$nw_code2 = $work2['nw_code'].' '.$work2['pj_title_kr'];
												?>
												<option value="<?php echo  $work2['nw_code']?>" <?php echo get_selected( $work2['nw_code'], $team)?>><?php echo $nw_code2?></option>
												<?php }?>
											</optgroup>
									</select>
									<input type="text" name="stx" value="<?php echo $stx?>" class="form-control" placeholder="공사명 or 업체명 검색"  >
									<div class="input-group-append">
										<button class="input-group-text" id="search-mail"><i class="icon-magnifier"></i></button>
									</div>
								</div>
							</form>
                        </div>	
						
					
						
                        <div class="body project_report" style="overflow-x:scroll">
							
                            <div class="table-responsive" style="width:2400px">
                                <table class="table m-b-0 table-hover" >
                                    <thead class="thead-light">
                                        <tr>
                                            <th>현장번호</th>
                                            <th>공사명</th>
                                            <th>업체명</th>
                                            <th>공종명</th>
                                            <th class="text-center">계약서</th>
                                            <th class="text-center">내역서</th>
                                            <th class="text-center">사업자등록증</th>
                                            <th class="text-center">통장사본</th>
                                            <th class="text-center">현장대리인계</th>
                                            <th class="text-center">계약보증서</th>
                                            <th class="text-center">근로자재해증권</th>
                                            <th class="text-center">선급금보증서</th>
                                            <th class="text-center">면허수첩</th>
                                            <th class="text-center">건설업면허증</th>
                                            <th class="text-center">국세</th>
                                            <th class="text-center">지방세</th>
                                            <th class="text-center">인감증명서</th>
                                            <th class="text-center">사용인감계</th>
                                            <th class="text-center">등기부등본</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
									
										<?php
										function searchForId($id, $array) {
										   foreach ($array as $key => $val) {
											   if ($val['bf_category'] === $id) {
												   return $key;
											   }
										   }
										   return null;
										}
										$prev_id = "";
										for($i=0; $row=sql_fetch_array($result); $i++) {
											
											
											if($i!=0 && ($row['work_id'] != $prev_id)) {
												$bg = 'style="border-top:8px solid #ddd"';
											} else {
												$bg = '';
											}
											
											/*연구필요.
 											//하도급계약총괄표 파일업로드 체크 
											$file1 = get_file('subcontract', $row['seq']);
											
											
											
											//업체관리 파일업로드 체크 
											$enter = sql_fetch("select seq from {$none['enterprise_list']} where seq = '{$row['ns_bname']}'");
											
											$file2 = get_file('enterprise', $enter['seq']);
											
											$key1 = array_search(1, array_column($file1, 'bf_category')); //계약서
											$key2 = array_search(2, array_column($file1, 'bf_category')); //내역서
											$key3 = array_search(1, array_column($file2, 'bf_category')); //사업자등록증
											$key4 = array_search(2, array_column($file2, 'bf_category')); //통장사본
											$key5 = array_search(3, array_column($file1, 'bf_category')); //현장대리인계
											$key6 = array_search('4', array_column($file1, 'bf_category')); //계약보증서
											$key7 = array_search('5', array_column($file1, 'bf_category')); //근로자재해증권*/
											
											$enter = sql_fetch("select seq from {$none['enterprise_list']} where seq = '{$row['ns_bname']}'");
											
											//계약서
											$file1 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'subcontract' and (wr_id = '{$row['seq']}' or bf_change_id = '{$row['seq']}') and bf_category = 1 order by seq desc"); 
											$file1['href'] = "/_ajax/file_download.php?bo_table=subcontract&amp;wr_id={$file1['seq']}&amp;seq={$file1['seq']}";
											
											//계약서
											$file2 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'subcontract' and (wr_id = '{$row['seq']}' or bf_change_id = '{$row['seq']}') and bf_category = 2 order by seq desc"); 
											$file2['href'] = "/_ajax/file_download.php?bo_table=subcontract&amp;wr_id={$file2['seq']}&amp;seq={$file2['seq']}";
											
											//사업자등록증
											$file3 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'enterprise' and (wr_id = '{$enter['seq']}' or bf_change_id = '{$enter['seq']}') and bf_category = 1 order by seq desc"); 
											$file3['href'] = "/_ajax/file_download.php?bo_table=enterprise&amp;wr_id={$file3['seq']}&amp;seq={$file3['seq']}";
											
											//통장사본
											$file4 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'enterprise' and (wr_id = '{$enter['seq']}' or bf_change_id = '{$enter['seq']}') and bf_category = 2 order by seq desc"); 
											$file4['href'] = "/_ajax/file_download.php?bo_table=enterprise&amp;wr_id={$file4['seq']}&amp;seq={$file4['seq']}";	
											
											//현장대리인계
											$file5 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'subcontract' and (wr_id = '{$row['seq']}' or bf_change_id = '{$row['seq']}') and bf_category = 3 order by seq desc"); 
											$file5['href'] = "/_ajax/file_download.php?bo_table=subcontract&amp;wr_id={$file5['seq']}&amp;seq={$file5['seq']}";	
											
											//계약보증서
											$file6 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'subcontract' and (wr_id = '{$row['seq']}' or bf_change_id = '{$row['seq']}') and bf_category = 4 order by seq desc"); 
											$file6['href'] = "/_ajax/file_download.php?bo_table=subcontract&amp;wr_id={$file6['seq']}&amp;seq={$file6['seq']}";
											
											//근로자재해증권
											$file7 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'subcontract' and (wr_id = '{$row['seq']}' or bf_change_id = '{$row['seq']}') and bf_category = 5 order by seq desc"); 
											$file7['href'] = "/_ajax/file_download.php?bo_table=subcontract&amp;wr_id={$file7['seq']}&amp;seq={$file7['seq']}";
											
											//선급금 보증서
											$file8 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'subcontract' and (wr_id = '{$row['seq']}' or bf_change_id = '{$row['seq']}') and bf_category = 6 order by seq desc"); 
											$file8['href'] = "/_ajax/file_download.php?bo_table=subcontract&amp;wr_id={$file8['seq']}&amp;seq={$file8['seq']}";
											
											//면허수첩
											$file9 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'enterprise' and (wr_id = '{$enter['seq']}' or bf_change_id = '{$enter['seq']}') and bf_category = 3 order by seq desc"); 
											$file9['href'] = "/_ajax/file_download.php?bo_table=enterprise&amp;wr_id={$file9['seq']}&amp;seq={$file9['seq']}";	
											
											//건설업면허증
											$file10 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'enterprise' and (wr_id = '{$enter['seq']}' or bf_change_id = '{$enter['seq']}') and bf_category = 4 order by seq desc"); 
											$file10['href'] = "/_ajax/file_download.php?bo_table=enterprise&amp;wr_id={$file10['seq']}&amp;seq={$file10['seq']}";	
											
											//국세
											$file11 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'enterprise' and (wr_id = '{$enter['seq']}' or bf_change_id = '{$enter['seq']}') and bf_category = 5 order by seq desc"); 
											$file11['href'] = "/_ajax/file_download.php?bo_table=enterprise&amp;wr_id={$file11['seq']}&amp;seq={$file11['seq']}";	
											//지방세
											$file12 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'enterprise' and (wr_id = '{$enter['seq']}' or bf_change_id = '{$enter['seq']}') and bf_category = 6 order by seq desc"); 
											$file12['href'] = "/_ajax/file_download.php?bo_table=enterprise&amp;wr_id={$file12['seq']}&amp;seq={$file12['seq']}";	//지방세
											
											//인감증명서
											$file13 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'enterprise' and (wr_id = '{$enter['seq']}' or bf_change_id = '{$enter['seq']}') and bf_category = 7 order by seq desc"); 
											$file13['href'] = "/_ajax/file_download.php?bo_table=enterprise&amp;wr_id={$file13['seq']}&amp;seq={$file13['seq']}";	
											
											//인감증명서
											$file14 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'enterprise' and (wr_id = '{$enter['seq']}' or bf_change_id = '{$enter['seq']}') and bf_category = 8 order by seq desc"); 
											$file14['href'] = "/_ajax/file_download.php?bo_table=enterprise&amp;wr_id={$file14['seq']}&amp;seq={$file14['seq']}";	
											
											//인감증명서
											$file15 = sql_fetch("select seq from {$g5['board_file_table']} where bo_table = 'enterprise' and (wr_id = '{$enter['seq']}' or bf_change_id = '{$enter['seq']}') and bf_category = 9 order by seq desc"); 
											$file15['href'] = "/_ajax/file_download.php?bo_table=enterprise&amp;wr_id={$file15['seq']}&amp;seq={$file15['seq']}";	
											
										?>
										<tr <?php echo $bg?>>
											<td><a href="../write/menu2_write.php?w=u&seq=<?php echo $row['seq']?>"><?php echo $row['work_id']?></a></td>
									
											<td><?php echo get_worksite_name($row['work_id'])?></td>
											<td><?php echo get_enterprise_txt($row['ns_bname'])?></td>
											<td><?php echo $row['ns_gongjong']?></td>
											
											<td class="text-center"><?php if( $file1['seq'] ) { echo '<a href="'.$file1['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file2['seq'] ) { echo '<a href="'.$file2['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file3['seq'] ) { echo '<a href="'.$file3['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file4['seq'] ) { echo '<a href="'.$file4['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file5['seq'] ) { echo '<a href="'.$file5['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file6['seq'] ) { echo '<a href="'.$file6['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file7['seq'] ) { echo '<a href="'.$file7['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file8['seq'] ) { echo '<a href="'.$file8['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file9['seq'] ) { echo '<a href="'.$file9['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file10['seq'] ) { echo '<a href="'.$file10['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file11['seq'] ) { echo '<a href="'.$file11['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file12['seq'] ) { echo '<a href="'.$file12['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file13['seq'] ) { echo '<a href="'.$file13['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file14['seq'] ) { echo '<a href="'.$file14['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											<td class="text-center"><?php if( $file15['seq'] ) { echo '<a href="'.$file15['href'].'"><span class="glyphicon fa fa-download"></span></a>'; } else { echo '<span class="no_file">미등록</span>'; }?></td>
											
										</tr>
										
										
										
										<?php 
										$prev_id  = $row['work_id'];
										
										}
										
										if($i == 0) {?> 
										<tr>
											<td colspan="11" class="align-center">검색 된 데이터가 없습니다.</td> 
										</tr>
										<?php }?>
									
									</tbody>
									</table>
								</div>
							</div>
						<?php echo get_paging_none(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
                    </div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>
<script>
function del_(seq) {
	
	if(confirm('정말 삭제하시겠습니까?\n\n연동 된 정보가 있다면 모두 해제 됩니다.')) {
		location.href = '/_worksite/write/menu1_update.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
</script>

<?php include_once(NONE_PATH.'/footer.php');?>