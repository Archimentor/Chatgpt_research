<?php
/***************************************************
 * [menu7_view.php]
 *  - 근태사유서 상세보기 (결재처리/댓글등록 등)
 ***************************************************/
include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$w   = isset($_GET['w']) ? trim($_GET['w']) : '';
$seq = isset($_GET['seq'])? trim($_GET['seq']): '';

if(!$seq) alert('잘못된 접근입니다.');

// 근태사유서 테이블
$row = sql_fetch("SELECT * FROM {$none['sign_draft7']} WHERE seq='$seq'");
if(!$row) alert('존재하지 않는 문서입니다.');

$mb       = get_member($row['mb_id']);
$date     = substr($row['ns_date'],0,10);
$ns_docnum= $row['ns_docnum'];

// 결재선, 결재상태 등은 menu2_view와 유사
// ...
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
          <li class="breadcrumb-item active">근태사유서 상세</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="row clearfix">
    <div class="col-lg-12 col-md-12">
      <div class="card">

        <form name="frm" method="post" action="../write/menu7_update.php" enctype="multipart/form-data">
          <input type="hidden" name="w" value="u">
          <input type="hidden" name="seq" value="<?php echo $seq;?>">

          <div class="body project_report">
            <div class="table-responsive">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th style="width:120px; background:#f2f2f2;">문서번호</th>
                    <td><?php echo $ns_docnum; ?></td>
                    <th style="background:#f2f2f2;">기안일</th>
                    <td><?php echo $date; ?></td>
                  </tr>
                  <tr>
                    <th style="background:#f2f2f2;">기안자</th>
                    <td><?php echo $mb['mb_name'];?></td>
                    <th style="background:#f2f2f2;">보존기간</th>
                    <td>5년</td>
                  </tr>
                  <tr>
                    <th style="background:#f2f2f2;">중요도</th>
                    <td><?php echo $row['ns_importance'];?></td>
                    <th style="background:#f2f2f2;">참조자</th>
                    <td>
                      <?php
                      // 참조자 : row['ns_cc']가 콤마(,)로 구분돼 있다면, 멤버명으로 변환
                      echo get_mb_name($row['ns_cc']);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th style="background:#f2f2f2;">제목</th>
                    <td colspan="3"><?php echo $row['ns_subject'];?></td>
                  </tr>
                  <tr>
                    <th style="background:#f2f2f2;">사유</th>
                    <td colspan="3"><?php echo $row['ns_reason'];?></td>
                  </tr>
                  <tr>
                    <th style="background:#f2f2f2;">기간</th>
                    <td colspan="3">
                      <?php echo $row['ns_startdate'].' ~ '.$row['ns_enddate'];?>
                    </td>
                  </tr>
                  <tr>
                    <th style="background:#f2f2f2;">소요시간</th>
                    <td><?php echo $row['ns_hours'];?> 시간</td>
                    <th style="background:#f2f2f2;">소요일</th>
                    <td><?php echo $row['ns_days'];?> 일</td>
                  </tr>
                  <tr>
                    <th style="background:#f2f2f2;">상세사유</th>
                    <td colspan="3">
                      <?php echo get_view_thumbnail($row['ns_content']);?>
                    </td>
                  </tr>
                  <tr>
                    <th style="background:#f2f2f2;">첨부파일</th>
                    <td colspan="3">
                      <!-- 파일 목록 (menu2_view 처럼) -->
                      <table class="table table-striped">
                        <thead><tr><th>파일명</th><th>용량</th><th>다운</th></tr></thead>
                        <tbody id="file_list">
                          <!-- 실제 목록: file_listup5.php 등 재활용 -->
                          <?php
                          // menu2_view 처럼 file_list 출력
                          // ...
                          ?>
                        </tbody>
                      </table>
                    </td>
                  </tr>

                  <!-- 결재칸, 결재버튼, 댓글 등 menu2_view 로직 유사하게 -->
                  <!-- ... -->
                </tbody>
              </table>
            </div>

            <div class="m-t-30 align-right">
              <!-- 결재상신, 반려, 전결 등 버튼(해당 권한자만 보이게) -->
              <button type="button" class="btn btn-primary" onclick="onPrint()">인쇄</button>
              <a href="../list/menu7_list.php" class="btn btn-outline-secondary">목록</a>
            </div>
          </div>
        </form>

      </div><!-- card -->
    </div><!-- col -->
  </div><!-- row -->
</div><!-- main-content -->

<?php include_once(NONE_PATH.'/footer.php'); ?>

<script>
function onPrint(){
  window.print();
}
</script>
