<?php 
include_once('../../_common.php');
define('menu_employee', true);
include_once(NONE_PATH.'/header.php'); 



$sql_common = " from  {$g5['member_table']}  ";
$sql_search = " where (1) and mb_level = 10 and mb_id != 'admin' ";


if ($stx) {
    $sql_search .= " and ( ";
 
    $sql_search .= " (mb_name like '%$stx%' or mb_id like '%$stx%' or mb_hp like '%$stx%' or mb_email like '%$stx%') ";
   
    $sql_search .= " ) ";
}

if($team) {
	 $sql_search .= " and mb_2 = '$team' ";
}


if (!$sst) {
    $sst  = "mb_in_date";
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

$qstr = "&amp;team={$team}";

?>
<!--건축주 리스트-->
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>회사관리</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">회사관리</li>
				<li class="breadcrumb-item active">직원관리 리스트</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					
                    <div class="card">
						<div class="body">
							
                            <a class="btn btn-primary float-right" href="../write/menu1_write.php" role="button">직원등록</a> 
							<form class="float-right" style="margin-right:5px">
								
								<div class="input-group">
										<select name="team" id="inputState" class="form-control" onchange="location.href='?team='+this.value">
											<option value="">부서전체</option>
											<option value="5" <?php echo get_selected($team, 5)?>>기획관리부</option>
											<option value="3" <?php echo get_selected($team, 3)?>>관리부</option>
											<option value="2" <?php echo get_selected($team, 2)?>>공무부</option>
											<option value="1" <?php echo get_selected($team, 1)?>>공사부</option>
											<option value="4" <?php echo get_selected($team, 4)?>>연구부</option>
											<option value="10" <?php echo get_selected($team, 10)?>>실행부</option>
											<option value="11" <?php echo get_selected($team, 11)?>>퇴사</option>
										</select>
									<input type="text" name="stx" class="form-control" placeholder="검색" value="<?php echo urldecode($stx)?>" >
									<div class="input-group-append">
										<button class="input-group-text" id="search-mail"><i class="icon-magnifier"></i></button>
									</div>
								</div>
							</form>
                        </div>	
						
					
						
                        <div class="body project_report">
                            <?php
                            $departments = array(
                                5 => '기획관리부',
                                3 => '관리부',
                                2 => '공무부',
                                1 => '공사부',
                                4 => '연구부',
                                10 => '실행부',
                                11 => '퇴사'
                            );

                            $sql_order = "ORDER BY mb_name ASC";
                            $total_members = 0;

                            foreach ($departments as $dept_key => $dept_name) {
                                $sql_dept_search = $sql_search . " and mb_2 = '$dept_key' ";
                                $sql_dept = " select * {$sql_common} {$sql_dept_search} {$sql_order} limit {$from_record}, {$rows} ";
                                $result_dept = sql_query($sql_dept);
                                $num_rows = sql_num_rows($result_dept);
                        
                                if ($num_rows > 0) {
                                    if ($dept_key != 11) { // 퇴사자 제외
                                        $total_members += $num_rows; // 총원계산
                                    }
                                }
                            }

                            echo "<h3>총원 (퇴사 제외) : {$total_members} 명</h3>";

                            foreach ($departments as $dept_key => $dept_name) {
                                $sql_dept_search = $sql_search . " and mb_2 = '$dept_key' ";
                                $sql_dept = " select * {$sql_common} {$sql_dept_search} {$sql_order} limit {$from_record}, {$rows} ";
                                $result_dept = sql_query($sql_dept);
                                $num_rows = sql_num_rows($result_dept);                             

                                if ($num_rows > 0) {
                                    echo "<h3>{$dept_name} : {$num_rows}명</h3>";
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table m-b-0 table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>사진</th>
                                                    <th>직급</th>
                                                    <th>성명</th>
                                                    <th>주민번호</th>
                                                    <th style="width:200px">주소</th>
                                                    <th>전화번호</th>
                                                    <th>기술등급</th>
                                                    <th>입사일</th>
                                                    <th>근무복사이즈</th>
                                                    <th>급여계좌</th>
                                                    <th>전도금계좌</th>
                                                    <th>관리</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                for ($i = 0; $row_dept = sql_fetch_array($result_dept); $i++) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo get_member_profile_img($row_dept['mb_id']); ?></td>
                                                        <td><?php echo get_mposition_txt($row_dept['mb_3']) ?></td>
                                                        <td><?php echo $row_dept['mb_name'] ?></td>
                                                        <td><?php echo $row_dept['mb_5'] ?></td>
                                                        <td style="width:300px;white-space:normal"><?php echo $row_dept['mb_addr1'] ?></td>
                                                        <td><?php echo $row_dept['mb_hp'] ?> </td>
                                                        <td><?php echo $row_dept['mb_7'] ?></td>
                                                        <td><?php echo $row_dept['mb_in_date'] ?></td>
                                                        <td><?php echo $row_dept['mb_6'] ?></td>
                                                        <td><?php echo $row_dept['mb_bank1_name'] ?> <?php echo $row_dept['mb_account1'] ?></td>
                                                        <td><?php echo $row_dept['mb_bank2_name'] ?> <?php echo $row_dept['mb_account2'] ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" onclick="location.href='/_employee/write/menu1_write.php?w=u&mb_id=<?php echo $row_dept['mb_id'] ?>'">수정</button>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="del_(<?php echo $row_dept['mb_id'] ?>)">삭제</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                                <?php if ($i == 0) { ?>
                                                    <tr>
                                                        <td colspan="11" class="align-center">검색 된 데이터가 없습니다.</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="height : 20px;"></div>                                 
						<?php  }}?>                 
                    </div>
                </div>
            </div>
          
          
          
            
    </div>
    
</div>
<script>
function del_(seq) {
	
	if(confirm('정말 업체정보를 삭제하시겠습니까?\n\n연동 된 정보가 있다면 모두 해제 됩니다.')) {
		location.href = '/_enterprise/write/menu1_update.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
</script>

<?php include_once(NONE_PATH.'/footer.php');?>