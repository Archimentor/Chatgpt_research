<?php
/***************************************************
 * [menu7_list.php]
 *  - 근태사유서 목록
 *  - 목록 컬럼: 번호, 기안일자, 제목, 기간, 소요시간, 소요일, 기안자, 결재현황, 처리상태
 ***************************************************/
include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php');

// (1) 검색 조건, 페이징 등은 기존 menu2_list와 유사
// 예시: 테이블명 = $none['sign_draft7']
$sql_common = " FROM {$none['sign_draft7']} ";
$sql_search = " WHERE (1) ";

// 검색어/상태 등에 따른 $sql_search 구성
// ...
// 예) if($stx) { $sql_search .= " AND ns_subject LIKE '%$stx%' "; }

if(!$sst) {
    $sst = "seq";
    $sod = "desc";
}
$sql_order = " ORDER BY $sst $sod ";

// 전체 개수
$sql = "SELECT COUNT(*) as cnt {$sql_common} {$sql_search}";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows);
if($page < 1) $page = 1;
$from_record = ($page - 1) * $rows;

// 실제 목록 데이터
$sql = "
    SELECT *
    {$sql_common}
    {$sql_search}
    {$sql_order}
    LIMIT {$from_record}, {$rows}
";
$result = sql_query($sql);
?>

<div id="main-content">
  <div class="block-header">
    <div class="row">
      <div class="col-lg-5 col-md-8 col-sm-12">
        <h2>
          <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
            <i class="fa fa-arrow-left"></i>
          </a>
          전자결재 - 근태사유서
        </h2>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
          <li class="breadcrumb-item active">근태사유서 목록</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="row clearfix">
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="body">
          <!-- 새 근태사유서 작성 버튼 -->
          <a class="btn btn-primary float-right" 
             href="../write/menu7_write.php" role="button">
            근태사유서 작성
          </a>
          
          <!-- 검색 폼 등 필요하면 추가 -->
          <!-- ... -->

        </div>

        <div class="body project_report">
          <div class="table-responsive">
            <table class="table m-b-0 table-hover">
              <thead class="thead-light">
                <tr>
                  <th>번호</th>
                  <th>기안일자</th>
                  <th>제목</th>
                  <th>기간</th>
                  <th>소요시간</th>
                  <th>소요일</th>
                  <th>기안자</th>
                  <th>결재현황</th>
                  <th>처리상태</th>
                </tr>
              </thead>
              <tbody>
<?php
if($total_count == 0) {
    echo '<tr><td colspan="9" class="text-center">등록된 근태사유서가 없습니다.</td></tr>';
} else {
    $num = $total_count - ($page - 1) * $rows;
    while($row = sql_fetch_array($result)) {
        // (a) 목록에 표시할 항목
        // 문서번호(예: N1휴-기안자-번호) -> row['ns_docnum']
        // 기안일자 -> date('Y-m-d', strtotime($row['ns_date']))
        // 제목 -> row['ns_subject']
        // 기간 -> row['ns_startdate'] ~ row['ns_enddate'] (날짜 + 시간)
        // 소요시간 -> row['ns_hours'] (ex: "8시간")
        // 소요일 -> row['ns_days'] (ex: "1일")
        // 기안자 -> get_member($row['mb_id'])['mb_name']
        // 결재현황 -> next 결재자 표시, 또는 "결재완료", "반려" 등
        // 처리상태 -> "미처리", "결재완료", "반려" 등

        $giandaname = get_member($row['mb_id'], 'mb_name');
        $giandaname = $giandaname['mb_name'];

        // 예: 결재상태 로직(간단 ver)
        $state_txt = $row['ns_state']; 
        // 결재현황(다음 결재자) -> $next_mb_name
        $next_mb_name = '담당자이름'; // 실제로는 menu2_list와 동일하게 로직 구현

        echo '<tr>';
        echo '  <td>'.$num.'</td>';
        echo '  <td>'.date('Y-m-d', strtotime($row['ns_date'])).'</td>';
        echo '  <td>
                  <a href="../view/menu7_view.php?w=u&seq='.$row['seq'].'">
                    '.$row['ns_subject'].'
                  </a>
                </td>';
        echo '  <td>'.substr($row['ns_startdate'],0,16).' ~ '.substr($row['ns_enddate'],0,16).'</td>';
        echo '  <td>'.$row['ns_hours'].'</td>';
        echo '  <td>'.$row['ns_days'].'</td>';
        echo '  <td>'.$giandaname.'</td>';
        echo '  <td>'.$next_mb_name.'</td>';
        echo '  <td>'.$state_txt.'</td>';
        echo '</tr>';

        $num--;
    }
}
?>
              </tbody>
            </table>
          </div>
        </div>

        <?php
        // 페이징
        echo get_paging_none(
            $config['cf_write_pages'],
            $page,
            $total_page,
            $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='
        );
        ?>

      </div><!-- card -->
    </div><!-- col -->
  </div><!-- row -->
</div><!-- main-content -->

<script>
function del_(seq) {
  if(confirm('정말 삭제하시겠습니까?')) {
    location.href = '../write/menu7_update.php?w=d&seq='+seq;
  }
}
</script>

<?php include_once(NONE_PATH.'/footer.php'); ?>
