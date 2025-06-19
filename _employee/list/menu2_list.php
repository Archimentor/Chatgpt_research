<?php 
include_once('../../_common.php');
define('menu_employee', true);
include_once(NONE_PATH.'/header.php'); 



$sql_common = " from  {$none['branch_list']} ";


if ($stx) {
    $sql_search .= " and ( ";
 
    $sql_search .= " nb_name like '%$stx%'  ";
   
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "nb_order";
    $sod = "asc";
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

?>
<style>
.none { border:0; width:100%;text-align:center;}
</style>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<!--건축주 리스트-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>회사관리</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">회사관리</li>
				<li class="breadcrumb-item active">지사관리</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<div class="body">
                           
							<form class="float-left" style="margin-right:5px;width:550px" action="./menu2_update.php" method="post">
							<input type="hidden" name="w" value="i">
								<div class="input-group">
									<input type="text" name="nb_name" class="form-control" placeholder="지사명 입력" value="<?php echo urldecode($stx)?>" >
									<div class="input-group-append">
										 <button class="btn btn-primary float-right" href="../write/menu1_write.php" role="button">지사등록</button> 
									</div>
								</div>
							</form>
                        </div>	
						
					
						
                        <div class="body project_report">
							<form name="frm" action="./menu2_update.php" method="post">
							<input type="hidden" name="w" value="u">
                            <div class="table-responsive" style="width:550px">
								<div class="alert alert-warning alert-dismissible fade show" role="alert">
								- 리스트 빈공간을 드래그하여 순서를 변경하실 수 있습니다.<br>
								- 지사명을 클릭하여 변경하실 수 있습니다.<br>
								- 변경 후 하단 [일괄 업데이트]를 클릭하셔야 저장됩니다.
								</div>
                                <table class="table m-b-0 table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th  class="text-center" style="width:80px">번호</th>
                                            <th class="text-center" style="width:300px">지사명</th>
                                            <th class="text-center">소속인원</th>
                                            <th class="text-center">관리</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable">
										<?php for($i=0; $row=sql_fetch_array($result); $i++) {
											
											$total = sql_fetch("select count(*) as cnt from g5_member where mb_1 = '{$row['seq']}' and mb_level2 != 4"); //설정 된 지사 카운트
										?>
										<tr id="row_<?php echo $row['seq']?>" data="<?php echo $row['seq']?>">
											<td  class="text-center">
											<input type="hidden" name="seq[]" value="<?php echo $row['seq']?>">
											<input type="text" name="nb_order[]" class="nb_order none" readonly data="<?php echo $row['seq']?>" value="<?php echo $row['nb_order']?>" ></td>
											<td><input type="text" name="nb_name[]" value="<?php echo $row['nb_name']?>" class="none"></td>
											<td class="text-right"><?php echo $total['cnt']?>명</td>
											<td class="text-center">
											<button type="button" class="btn btn-danger btn-sm" onclick="del_(<?php echo $row['seq']?>)">삭제</button>
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
									<div style="text-align:center;margin-top:10px">
										<button class="btn btn-primary "  role="button">일괄 업데이트</button> 
									</div>
							</div>
							
							
							</form>
                        </div>
						<?php echo get_paging_none(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
                    </div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>


<?php include_once(NONE_PATH.'/footer.php');?>

  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable({
      placeholder: "ui-state-highlight",
	  stop : function(event, ui) {
		
		
		$( "#sortable tr" ).each(function(i) {
			$(this).find('.nb_order').val(i+1);
		})
		
	  }
    });
    $( "#sortable" ).disableSelection();
  } );
  
	function del_(seq) {
		
		if(confirm('정말 지사정보를 삭제하시겠습니까? \n\n주의 : 직원관리에 설정 된 지사정보가 모두 해제 됩니다.')) {
			location.href = './menu2_update.php?w=d&seq='+seq;
		} else {
			return false;
		}
		
	}
  </script>