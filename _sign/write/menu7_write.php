<?php
/***************************************************
 * menu7_write.php
 *  - 근태사유서 작성/수정 (menu2_write 방식의 결재선/참조자)
 ***************************************************/
include_once('../../_common.php');
define('menu_sign', true);
include_once(NONE_PATH.'/header.php');
include_once(G5_EDITOR_LIB);  // 에디터

if(!$is_member) alert('권한이 없습니다.');
if($member['mb_level2'] == 3) $is_admin = true;

$w   = isset($_GET['w']) ? trim($_GET['w']) : '';
$seq = isset($_GET['seq']) ? trim($_GET['seq']) : '';

// 새 문서 or 수정
if($w == '') {
    // 새 문서
    $mb_id         = $member['mb_id'];
    $mb_name       = $member['mb_name'];
    $date          = date('Y-m-d');
    // 문서번호는 "작성 후 자동생성" 표시
    $ns_docnum     = '<span style="color:#ccc">작성 후 자동생성</span>';

    $ns_importance = '보통';
    $ns_subject    = '';
    $ns_reason     = '';
    $ns_startdate  = '';
    $ns_enddate    = '';
    $ns_hours      = '';
    $ns_days       = '';
    $ns_content    = '';

    // 결재선 (menu2_write와 동일) - 예: sign_line 테이블에서 seq=7
    $signline = sql_fetch("SELECT * FROM {$none['sign_line']} WHERE seq = 7");

} else {
    // 수정 모드
    $row = sql_fetch("SELECT * FROM {$none['sign_draft7']} WHERE seq='$seq'");
    if(!$row) alert('존재하지 않는 문서입니다.');

    $mb_id         = $row['mb_id'];
    $mb_info       = get_member($mb_id, 'mb_name');
    $mb_name       = $mb_info['mb_name'];
    $date          = date('Y-m-d', strtotime($row['ns_date']));
    $ns_docnum     = $row['ns_docnum'];

    $ns_importance = $row['ns_importance'];
    $ns_subject    = $row['ns_subject'];
    $ns_reason     = $row['ns_reason'];
    $ns_startdate  = $row['ns_startdate'];
    $ns_enddate    = $row['ns_enddate'];
    $ns_hours      = $row['ns_hours'];
    $ns_days       = $row['ns_days'];
    $ns_content    = $row['ns_content'];
}

// 파일업로드 임시
$uid = get_uniqid();
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>근태사유서 작성</title>
<script src="/core/js/jquery-1.8.3.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
/* menu2_write 스타일 최대한 복사 */
/* 테이블 공통 */
.table { width:100%; border-collapse:collapse; }
.table th, .table td {
  border:1px solid #ccc; 
  padding:6px; 
  vertical-align: middle;
}
.table thead th { background:#f2f2f2; }

/* 결재라인 테이블 */
.sign_table { width:100% }
.sign_table th, td { border-left:0;  }
.sign_table thead td { background:#f2f2f2; width:100px;text-align:center; border-left:0 !important}
.sign_table tbody td { height:155px; border-bottom:0 !important;text-align:center; border-left:0 !important;}

/* 결재선 지정 모달 */
.add_box { margin-bottom:10px; }
.add_box span { display:inline-block; cursor:pointer; margin:5px; }
.add_box span.name { margin-right:40px; }
.add_box span.up { color:red; }
.add_box span.down { color:blue; }
.add_box span.delete { color:#444; }

/* 참조자(태그) */
#tag-list { list-style:none; margin:0; padding:0; }
#tag-list li {
  float:left; 
  margin-right:10px; 
  background:#f2f2f2; 
  padding:5px 8px; 
  margin-top:5px; 
  border-radius:4px;
}
.del-btn { cursor:pointer; margin-left:5px; }

/* select2 */
.select2 { width:100% !important; }
.select2-container .select2-selection--single { height:36px; border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px; }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px; }

/* 기간 달력 + 시간 */
.date-input { width:120px; display:inline-block; }
.time-input { width:100px; display:inline-block; }
</style>
</head>
<body style="margin:20px;">

<div id="main-content">
<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>전자결재</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">전자결재</li>
				<li class="breadcrumb-item active">근태사유서</li>
			</ul>
		</div>            
	   
	</div>

  <!-- 새 문서라면 결재선 지정 버튼 -->
  <?php if($w=='') { ?>
  <div style="text-align:right; margin-bottom:10px;">
    <a href="#largeModal" data-toggle="modal" data-target="#largeModal" class="btn btn-primary btn-sm">
      결재선 지정
    </a>
  </div>

  <!-- 결재선 지정 모달 (menu2_write와 같은 구조) -->
  <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="max-width:500px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5>결재선 지정</h5>
        </div>
        <form name="signline_frm" onsubmit="return false;">
          <div class="modal-body">
            <!-- 부서 검색/선택 -->
            <select id="department_select" class="form-control">
              <option value="">부서 선택</option>
              <?php 
               echo get_department_select($member['mb_2']);
              ?>
            </select>

            <!-- 왼쪽(사원목록), 오른쪽(추가된 결재자) -->
            <div style="float:left; width:49%; margin-right:1%;">
              <select class="multi_box form-control" id="step1" 
                      style="height:200px; margin-top:10px;"
                      multiple>
                <option value="">부서를 선택하세요</option>
              </select>
            </div>
            <div style="float:right; width:49%;">
              <div class="multi_box form-control" id="step2" 
                   style="height:200px; margin-top:10px;">
              </div>
            </div>
            <div style="clear:both;"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="signSubmit()">확인</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php } // endif ?>

  <form name="frm" action="./menu7_update.php" method="post" enctype="multipart/form-data" onsubmit="return chkfrm(this)">
    <input type="hidden" name="w" value="<?php echo $w;?>">
    <input type="hidden" name="seq" value="<?php echo $seq;?>">
    <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">

    <!-- 상단: 문서번호/기안자/기안일/보존기간 + 오른쪽 결재테이블 -->
    <table class="table" style="margin-bottom:10px;">
      <tbody>
        <tr>
          <td style="background:#f2f2f2; width:100px;">문서번호</td>
          <td><?php echo $ns_docnum; ?></td>

          <!-- 결재란 (rowspan=4) -->
          <td rowspan="4" style="background:#f2f2f2; text-align:center; width:80px;">결재</td>
          <td rowspan="4" style="vertical-align:top; padding:0;">
            <?php if($w=='') { 
              // 새 문서: sign_line 기본
              ?>
            <table class="sign_table">
              <thead>
                <tr>
                  <td>담당자</td>
                  <?php
                  $sign_cnt=0;
                  for($i=1;$i<=5;$i++){
                    if(!$signline['ns_id'.$i]) continue;
                    $sign_cnt++;
                    $mem = get_member($signline['ns_id'.$i], 'mb_name,mb_3');
                    echo '<td>'.$mem['mb_name'].' '.get_mposition_txt($mem['mb_3']).'</td>';
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $mb_name;?></td>
                  <?php
                  $ic=0;
                  for($i=1;$i<=5;$i++){
                    if(!$signline['ns_id'.$i]) continue;
                    $ic++;
                    echo '<td><input type="hidden" name="ns_id'.$ic.'" value="'.$signline['ns_id'.$i].'"></td>';
                  }
                  ?>
                </tr>
              </tbody>
            </table>
            <input type="hidden" id="sign_cnt" name="sign_cnt" value="<?php echo $sign_cnt;?>">

            <?php } else {
              // 수정 모드
              ?>
            <table class="sign_table">
              <thead>
                <tr>
                  <td>담당자</td>
                  <?php
                  $has_line=0;
                  for($i=1;$i<=5;$i++){
                    if(!$row['ns_id'.$i]) continue;
                    $has_line++;
                    $mem = get_member($row['ns_id'.$i], 'mb_name, mb_3');
                    echo '<td>'.$mem['mb_name'].' '.get_mposition_txt($mem['mb_3']).'</td>';
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <?php
                    // 기안자 결재상태
                    if(!$row['ns_id0_stat']){
                      echo $mb_name.' <small style="color:gray">미결</small>';
                    } else {
                      $st=explode('|',$row['ns_id0_stat']);
                      echo $mb_name.' <br><span style="color:green">'.$st[0].'</span> '
                           .date('y-m-d H:i', strtotime($st[1]));
                    }
                    ?>
                  </td>
                  <?php
                  for($i=1;$i<=5;$i++){
                    if(!$row['ns_id'.$i]) continue;

                    echo '<td>';
                    echo '<input type="hidden" name="ns_id'.$i.'" value="'.$row['ns_id'.$i].'">';

                    $col_stat = 'ns_id'.$i.'_stat';
                    if(!$row[$col_stat]) {
                      // 미결
                      if($member['mb_id'] == $row['ns_id'.$i] && $row['ns_state']=='미처리'){
                        echo '<a href="#none" onclick="proc_(\'결재\','.$i.')" class="btn btn-primary btn-sm">결재</a> ';
                        echo '<a href="#none" onclick="proc_(\'전결\','.$i.')" class="btn btn-primary btn-sm">전결</a> ';
                        echo '<a href="#none" onclick="proc_(\'반려\','.$i.')" class="btn btn-danger btn-sm">반려</a>';
                      } else {
                        echo '<span style="color:gray">대기</span>';
                      }
                    } else {
                      // 결재/반려/전결
                      $st=explode('|',$row[$col_stat]);
                      $mb_dir=substr($row['ns_id'.$i], 0,2);
                      // 사인 이미지
                      echo '<img src="'.G5_DATA_URL.'/member/'.$mb_dir.'/'.$row['ns_id'.$i].'_sign.gif" 
                            style="width:60px;height:60px"><br>';
                      echo $st[0].'<br>'.date('y-m-d H:i', strtotime($st[1]));
                    }
                    echo '</td>';
                  }
                  ?>
                </tr>
              </tbody>
            </table>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td style="background:#f2f2f2;">기안자</td>
          <td><?php echo $mb_name;?></td>
        </tr>
        <tr>
          <td style="background:#f2f2f2;">기안일</td>
          <td><?php echo $date;?></td>
        </tr>
        <tr>
          <td style="background:#f2f2f2;">보존기간</td>
          <td>5년</td>
        </tr>
      </tbody>
    </table>

    <!-- 아래: 중요도, 참조자, 근태사유 항목 -->
    <table class="table">
      <tbody>
        <tr>
          <th style="width:100px; background:#f2f2f2;">중요도</th>
          <td style="width:300px;">
            <select name="ns_importance" class="form-control">
              <option value="보통" <?php echo get_selected($ns_importance,'보통');?>>보통</option>
              <option value="중요" <?php echo get_selected($ns_importance,'중요');?>>중요</option>
              <option value="가장중요" <?php echo get_selected($ns_importance,'가장중요');?>>가장중요</option>
            </select>
          </td>
          <th style="width:100px; background:#f2f2f2;">참조자</th>
          <td>
            <select id="tag" class="form-control select2">
              <option value="">참조자 선택</option>
              <?php 
              echo get_admin_select('');
              ?>
            </select>
            <input type="hidden" name="tag" id="rdTag" />
            <ul id="tag-list" style="margin-top:5px;"></ul>
          </td>
        </tr>
        <tr>
          <th style="background:#f2f2f2;">제목</th>
          <td colspan="3">
            <input type="text" name="ns_subject" class="form-control" 
                   value="<?php echo $ns_subject;?>">
          </td>
        </tr>
        <tr>
          <th style="background:#f2f2f2;">사유</th>
          <td colspan="3">
            <input type="text" name="ns_reason" class="form-control"
                   placeholder="예) 연차, 조퇴, 지각, 외출 등"
                   value="<?php echo $ns_reason;?>">
          </td>
        </tr>
        <tr>
          <th style="background:#f2f2f2;">기간 시작</th>
          <td>
<?php
$start_d = substr($ns_startdate,0,10);
$start_t = substr($ns_startdate,11,5);
?>
            <input type="text" name="ns_startdate_date" id="startdate_picker"
                   class="form-control date-input" style="display:inline-block;"
                   value="<?php echo $start_d;?>">
            <select name="ns_startdate_time" class="form-control time-input">
<?php
for($h=0;$h<25;$h++){
  $hh = str_pad($h,2,'0',STR_PAD_LEFT).':00';
  $sel = ($start_t==$hh)?'selected':'';
  echo '<option value="'.$hh.'" '.$sel.'>'.$hh.'</option>';
}
?>
            </select>
          </td>
          <th style="background:#f2f2f2;">기간 종료</th>
          <td>
<?php
$end_d = substr($ns_enddate,0,10);
$end_t = substr($ns_enddate,11,5);
?>
            <input type="text" name="ns_enddate_date" id="enddate_picker"
                   class="form-control date-input" style="display:inline-block;"
                   value="<?php echo $end_d;?>">
            <select name="ns_enddate_time" class="form-control time-input">
<?php
for($h=0;$h<25;$h++){
  $hh = str_pad($h,2,'0',STR_PAD_LEFT).':00';
  $sel=($end_t==$hh)?'selected':'';
  echo '<option value="'.$hh.'" '.$sel.'>'.$hh.'</option>';
}
?>
            </select>
          </td>
        </tr>
        <tr>
          <th style="background:#f2f2f2;">소요시간</th>
          <td>
            <input type="text" name="ns_hours" class="form-control"
                   style="width:80px; display:inline-block;"
                   value="<?php echo $ns_hours;?>"> 시간
          </td>
          <th style="background:#f2f2f2;">소요일</th>
          <td>
            <input type="text" name="ns_days" class="form-control"
                   style="width:80px; display:inline-block;"
                   value="<?php echo $ns_days;?>"> 일
          </td>
        </tr>
        <tr>
          <th style="background:#f2f2f2;">상세사유</th>
          <td colspan="3">
            <?php echo editor_html("ns_content", get_text(html_purifier($ns_content), 0)); ?>
          </td>
        </tr>
        <tr>
          <th style="background:#f2f2f2;">첨부파일</th>
          <td colspan="3">
            <div class="form-row">
              <div class="col-auto">
                <input id="fileInput" type="file" class="form-control" multiple>
                <input type="text" id="userfile" class="form-control" disabled
                       style="margin-top:5px;" placeholder="첨부된 파일 표시">
              </div>
              <div class="col-auto">
                <button type="button" id="file_upload_btn" 
                        onclick="file_upload()" 
                        class="btn btn-primary mb-2">업로드</button>
              </div>
            </div>
            <div class="form-row">
              <table class="table">
                <thead>
                  <tr>
                    <th>파일명</th>
                    <th>용량</th>
                    <th>다운</th>
                    <th>관리</th>
                  </tr>
                </thead>
                <tbody id="file_list">
                  <tr>
                    <td colspan="4">등록 된 첨부파일이 없습니다.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <div style="text-align:right; margin-top:10px;">
<?php if($w=='') { ?>
      <!-- 새 문서 -->
      <button type="submit" class="btn btn-primary">결재상신</button>
      <a href="../list/menu7_list.php" class="btn btn-outline-secondary">취소</a>
<?php } else { ?>
      <!-- 수정 -->
      <button type="submit" class="btn btn-primary">수정</button>
      <button type="button" class="btn btn-primary" onclick="window.print()">인쇄</button>
      <?php if($member['mb_id'] == $row['mb_id'] || $is_admin) { ?>
      <button type="button" class="btn btn-danger" onclick="del_(<?php echo $seq;?>)">삭제</button>
      <?php } ?>
      <a href="../list/menu7_list.php" class="btn btn-outline-secondary">목록</a>
<?php } ?>
    </div>
  </form>
</div><!-- #main-content -->

<?php include_once(NONE_PATH.'/footer.php'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
/** ================ 결재선 지정 (menu2_write 방식) ================ **/
var add_count=0; // 최대 5명 제한
$('#department_select').on('change', function(){
  var dep = $(this).val();
  // ajax.department.php (또는 동일 기능) 통해 부서별 사원 목록 HTML을 #step1에 표시
  $.post('./ajax.department.php', { department: dep }, function(data){
    $('#step1').html(data);
  });
});

// PC환경: 더블클릭으로 추가
$(document).on('dblclick','#step1 option', function(){
  if(add_count >=5){
    alert('최대 5명까지 결재 지정 가능합니다.');
    return false;
  }
  var overlap=false;
  var id = $(this).val();
  var name= $(this).text();
  var chk_val = id+"|"+name;

  // 중복검사
  $('.add_sign_line').each(function(){
    if($(this).val()==chk_val) overlap=true;
  });
  if(overlap){
    alert('이미 추가된 결재자입니다.');
    return false;
  }

  var html="";
  html += '<div class="add_box">';
  html += ' <input type="hidden" name="add_sign_line[]" class="add_sign_line" value="'+chk_val+'">';
  html += ' <span class="name">'+name+'</span>';
  html += ' <span class="up"><i class="fa fa-arrow-up"></i></span>';
  html += ' <span class="down"><i class="fa fa-arrow-down"></i></span>';
  html += ' <span class="delete"><i class="fa fa-trash-o"></i></span>';
  html += '</div>';
  $('#step2').append(html);
  add_count++;
});

// 위/아래 이동
$(document).on('click','.add_box .up', function(){
  var el=$(this).closest('.add_box');
  el.after(el.prev());
});
$(document).on('click','.add_box .down', function(){
  var el=$(this).closest('.add_box');
  el.before(el.next());
});
// 삭제
$(document).on('click','.add_box .delete', function(){
  $(this).closest('.add_box').remove();
  add_count--;
});

// 모달 확인 -> 결재테이블 반영
function signSubmit(){
  var index_data = $("input[name='add_sign_line[]']").length;
  if(index_data==0){
    alert('결재자를 1명 이상 지정해야 합니다.');
    return false;
  }
  var thead = "<td>담당자</td>";
  var tbody = "<td><?php echo $mb_name;?></td>"; // 기안자
  var i=0;
  // 뒤집어서 결재 순서 지정
  $( $("input[name='add_sign_line[]']").get().reverse() ).each(function(){
    i++;
    var sp = $(this).val().split("|");
    thead += "<td>"+sp[1]+"</td>";
    tbody += '<td><input type="hidden" name="ns_id'+i+'" value="'+sp[0]+'"></td>';
  });

  // .sign_table 업데이트
  $('.sign_table thead tr').html(thead);
  $('.sign_table tbody tr').html(tbody);
  $('#sign_cnt').val(index_data);

  $('#largeModal').modal('hide');
}

/** ================ 참조자(태그) ================ **/
var tag={};
var counter=0;
function addTag(value){ tag[counter]=value; counter++; }
function marginTag(){
  return Object.values(tag).filter(function(w){return w!=="";});
}
$("#tag").on('change', function(e){
  var val=$(this).val();
  var txt=$(this).find(':selected').text();
  if(val!==""){
    var result=Object.values(tag).filter(function(w){return w===val;});
    if(result.length==0){
      $("#tag-list").append("<li>"+txt+"<span class='del-btn' idx='"+counter+"'>x</span></li>");
      addTag(val);
      $(this).val("");
      $("#rdTag").val(marginTag());
    } else {
      alert("이미 추가된 참조자입니다.");
    }
  }
  e.preventDefault();
});
$(document).on('click','.del-btn', function(){
  var idx=$(this).attr('idx');
  tag[idx]="";
  $(this).parent().remove();
  $("#rdTag").val(marginTag());
});

/** ================ 기간 달력 ================ **/
$('#startdate_picker,#enddate_picker').datepicker({ dateFormat:'yy-mm-dd' });

/** ================ 파일 업로드 ================ **/
var filesTempArr=[];
function addFiles(e){
  var files=e.target.files;
  var filesArr=Array.prototype.slice.call(files);
  for(var i=0;i<filesArr.length;i++){
    filesTempArr.push(filesArr[i]);
  }
  $('#userfile').val(filesArr.length+"개 파일 첨부");
  $(this).val('');
}
$("#fileInput").on('change', addFiles);

function file_upload(){
  var formData=new FormData();
  for(var i=0;i<filesTempArr.length;i++){
    formData.append("files[]", filesTempArr[i]);
  }
<?php if($w=='u'){ ?>
  formData.append("uid", <?php echo $seq;?>);
<?php } else { ?>
  formData.append("uid", $('#uid').val());
<?php } ?>
  $('#file_upload_btn').html('업로드중..');

  $.ajax({
    type:"POST",
    url:"/_ajax/file_upload5.php",
    data: formData,
    processData:false,
    contentType:false,
    success:function(data){
      if(data=="no"){
        alert("업로드 실패(파일없음,확장자,용량 문제 등)");
      } else {
        // 성공
        filesTempArr=[];
        $('#userfile').val('');
        file_list();
      }
      $('#file_upload_btn').html('업로드');
    },
    error:function(err){
      alert(err.status);
    }
  });
}
function file_list(){
<?php if($w=='u'){ ?>
  var id=<?php echo $seq;?>;
<?php } else { ?>
  var id=$('#uid').val();
<?php } ?>
  $.post('/_ajax/file_listup5.php',{id:id,w:'<?php echo $w;?>'},function(data){
    $('#file_list').html(data);
  });
}
<?php if($w=='u'){ ?>
file_list();
<?php }?>

/** ================ 결재 처리(반려/전결/결재) ================ **/
function proc_(type, sort){
  var seq=<?php echo ($w=='u' ? $seq : 0);?>;
  if(!seq) return;
  if(confirm(type+' 하시겠습니까?')){
    location.href='./state7_update.php?w='+type+'&seq='+seq+'&sort='+sort;
  }
}

/** ================ 폼 유효성 ================ **/
function chkfrm(f){
  <?php echo get_editor_js("ns_content");?>
  if(!f.ns_subject.value){
    alert('제목을 입력하세요.');
    f.ns_subject.focus();
    return false;
  }
  // 기타 유효성 (기간, 사유, etc.)
  return true;
}

/** ================ 삭제 ================ **/
function del_(seq){
  if(!confirm('정말 삭제하시겠습니까?')) return;
  location.href='./menu7_update.php?w=d&seq='+seq;
}

$(function(){
  // select2 초기화
  $('.select2').select2({
    language:{ noResults:function(){return "검색 결과가 없습니다.";} }
  });
});
</script>
</body>
</html>
