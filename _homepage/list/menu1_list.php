<?php 
include_once('../../_common.php');
define('menu_homepage', true);
include_once(NONE_PATH.'/header.php'); 

$sql_common = " from  {$g5['member_table']}  ";
$sql_search = " where  mb_level = 2 ";


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
            $sql_search .= " (mb_id like '%$stx%' or mb_name like '%$stx%' or mb_hp like '%$stx%' or mb_email like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "mb_no";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
echo $sql;
?>
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>회원관리</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">홈페이지 관리</li>
				<li class="breadcrumb-item active">회원관리</li>
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
									<input type="text" name="stx" value="<?php echo $stx?>" class="form-control" placeholder="회원 검색"  >
									<div class="input-group-append">
										<span class="input-group-text" id="search-mail"><i class="icon-magnifier"></i></span>
									</div>
								</div>
							</form>
                        </div>	
						
					
						
                        <div class="body project_report">
							
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>번호</th>
                                            <th>아이디</th>
                                            <th>이름</th>
                                            <th>연락처</th>
                                            <th>이메일</th>
                                            <th>가입일시</th>
                                            <th>마지막접속일</th>
                                            <th>상태</th>
                                            
                                            <th>관리</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										
									
										<?php for($i=0; $row=sql_fetch_array($result); $i++) {
											
											$num = $total_count - ($page - 1) * $rows - $i;
											
											if($row['mb_leave_date'])
												$status = '<span class="badge badge-danger">탈퇴</span>';
											else
												$status = '<span class="badge badge-success">정상</span>';
											
										?>
										<tr>
											<td><?php echo $num?></td>
											<td><?php echo $row['mb_id']?></td>
											<td><?php echo $row['mb_name']?></td>
											<td><?php echo $row['mb_hp']?></td>
											<td><?php echo $row['mb_email']?></td>
											<td><?php echo $row['mb_datetime']?></td>
											<td><?php echo $row['mb_today_login']?></td>
											<td class="text-center"><?php echo $status?></td>
											<td>
											<a class="btn btn-primary btn-sm" href="../write/menu1_write.php?w=u&mb_id=<?php echo $row['mb_id']?>">수정</a>
											<button type="button" class="btn btn-danger btn-sm" onclick="del_(<?php echo $row['mb_id']?>)">삭제</button>
											</td>
											
										</tr>
										<?php } ?>
										
										<?php if($i == 0) {?> 
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
function del_(mb_id) {
	
	if(confirm('정말 회원정보를 삭제하시겠습니까?')) {
		location.href = '../write/menu1_update.php?w=d&mb_id='+mb_id;
	} else {
		return false;
	}
	
}
</script>

<?php include_once(NONE_PATH.'/footer.php');?>