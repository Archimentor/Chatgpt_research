<?php 
include_once('../../_common.php');
define('menu_establishment', true);
include_once(NONE_PATH.'/header.php'); 

if($w == 'u') {
	
	$row = sql_fetch("select * from {$none['smart_list']} where seq = '$seq'");
	
	if(!$row)
		alert('데이터가 삭제되었거나 이동되었습니다.');
		
	$work_id = $row['work_id'];
	$date = $row['ns_date'];
}




if($w == '') {
	
	$work = sql_fetch("select * from {$none['worksite']} where seq = '$seq'");

}

if(!$_GET['date']) {
	$date = date('Y-m');
	
}
$preDate = date('Y-m', strtotime($date." -1 Month"));
$nxtDate = date('Y-m', strtotime($date." +1 Month"));

// 메뉴6 전도금 정산서 등에서 담당자 선택 값 유지용
$selected_user_param = isset($_GET['selected_user']) ? $_GET['selected_user'] : '';


//if($index != 14 && $index >= 7) exit;
?>
<link rel="stylesheet" href="./include/stylesheet<?php echo $index?>.css?ver=220523"/>
<style>
@media print {
	* {
		-webkit-print-color-adjust: exact;
		print-color-adjust: exact;
	
    }
	
}
.nav-link { font-size:0.97em }
.input { border:0; width:100%}
</style>
<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> 기성청구서</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active">기성청구서 등록</li>
                        </ul>
                    </div>            
                </div>
            </div>
	
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" >
                        <div class="body">
						<nav style="margin-bottom:10px">
						  <div class="nav nav-tabs " id="nav-tab" role="tablist">
							<button class="nav-link <?php if($index == 1) echo 'active';?>" data="1">정산보고서</button>
							<button class="nav-link <?php if($index == 2) echo 'active';?>" data="2">정산서</button>
							<button class="nav-link <?php if($index == 3) echo 'active';?>" data="3" >노임(인부정보)</button>
							<button class="nav-link <?php if($index == 14) echo 'active';?>" data="14" >노임(용역회사)</button>
							<button class="nav-link <?php if($index == 4) echo 'active';?>" data="4" >노임대장</button>
							<button class="nav-link <?php if($index == 5) echo 'active';?>" data="5" >식대</button>
							<button class="nav-link <?php if($index == 6) echo 'active';?>" data="6" >전도금 정산서</button>
							<button class="nav-link <?php if($index == 7) echo 'active';?>" data="7" >집행내역서(외주)</button>
							<button class="nav-link <?php if($index == 8) echo 'active';?>" data="8" >철근/레미콘현황</button>
							<button class="nav-link <?php if($index == 9) echo 'active';?>" data="9" >집행내역서(자재)</button>
							<button class="nav-link <?php if($index == 10) echo 'active';?>" data="10" >집행내역서(장비)</button>
							<button class="nav-link <?php if($index == 11) echo 'active';?>" data="11" >집행내역서(노무비)</button>
							<button class="nav-link <?php if($index == 12) echo 'active';?>" data="12" >집행내역서(기타경비)</button>
							<button class="nav-link <?php if($index == 13) echo 'active';?>" data="13" >특기사항</button>
							
						  </div>
						</nav>
					
                            <?php include_once('./include/menu'.$index.'_inc.php')?>
							<div class="btn-group" role="group" aria-label="Basic example">
                                                          <button type="button" class="btn btn-secondary" onclick="location.href='?seq=<?php echo $seq?>&index=<?php echo $index?>&date=<?php echo $preDate?><?php echo $selected_user_param ? '&selected_user=' . urlencode($selected_user_param) : ''; ?>'"><</button>
							  <button type="button" class="btn btn-secondary" id="datePicker"><?php echo $date?></button>
                                                          <button type="button" class="btn btn-secondary"  onclick="location.href='?seq=<?php echo $seq?>&index=<?php echo $index?>&date=<?php echo $nxtDate?><?php echo $selected_user_param ? '&selected_user=' . urlencode($selected_user_param) : ''; ?>'">></button>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

</div>


<?php include_once(NONE_PATH.'/footer.php');?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="./jquery.resizableColumns.js"></script>
<script src="./include/js/print.min.js"></script>
<script>
function onExcel() {

	location.href = './menu1_write_excel.php?seq=<?php echo $_GET['seq']?>&date=<?php echo $_GET['date']?>&index=<?php echo $_GET['index']?>';
}
function onPrint() {
	const html = document.querySelector('html');
	 $('.print_frm').find('col').remove();
	 $('.print_frm').find('input[type=date]').attr('type', 'text');
	 $('.print_frm').find('.fa-trash-o').hide();
	const printContents = $('.print_frm').html();

	const printDiv = document.createElement("DIV");
	printDiv.className = "print-div";

	html.appendChild(printDiv);
	printDiv.innerHTML = printContents;
	document.body.style.display = 'none';
	window.print();
	document.body.style.display = 'block';
	printDiv.style.display = 'none';
	 $('.print_frm').find('.ne_trade_date').attr('type', 'date');
	 $('.print_frm').find('.fa-trash-o').show();
}
function onPrint2() {
	const html = document.querySelector('html');
	const printContents = $('.print_frm').html();

	const printDiv = document.createElement("DIV");
	printDiv.className = "print-div";

	html.appendChild(printDiv);
	printDiv.innerHTML = printContents;
	document.body.style.display = 'none';
	window.print();
	document.body.style.display = 'block';
	printDiv.style.display = 'none';
}
function onPrint3() {
	const html = document.querySelector('html');
	const printContents = $('.print_frm').html();

	const printDiv = document.createElement("DIV");
	printDiv.className = "print-div";
	
	
	html.appendChild(printDiv);
	printDiv.innerHTML = printContents;
	$('.print-div .num').each(function() {
		$(this).val(comma($(this).val()));
		
	})
	
	
	$('.print-div input').each(function() {
		$(this).prev().html($(this).val());
		
	})
	
	
	document.body.style.display = 'none';
	window.print();
	document.body.style.display = 'block';
	printDiv.style.display = 'none';
}
function onPrint4() {
	const html = document.querySelector('html');
	const printContents = $('.print_frm').html();

	const printDiv = document.createElement("DIV");
	printDiv.className = "print-div";
	
	
	html.appendChild(printDiv);
	printDiv.innerHTML = printContents;
	$('.print-div input[type=file]').each(function() {
		
			
		$(this).hide()
		
	})
	
	
	document.body.style.display = 'none';
	window.print();
	document.body.style.display = 'block';
	printDiv.style.display = 'none';
}

document.onkeyup = function(e) {
	if(e.which == 119) {
		
		if(confirm('저장하시겠습니까?')) {
			removeComma();
			document.frm.submit();
		} else {
			return false;
		}
	}
}
    var checkUnload = true;
    $(window).on("beforeunload", function(){
        if(checkUnload) return "저장하지 않고 페이지를 벗어나면 작성된 내용은 저장되지 않습니다.";
    });

$(function() {
	$('.nav-link').bind('click', function(){ 
		var index = $(this).attr('data');
		
                var baseUrl = '?w=<?php echo $w?>&seq=<?php echo $seq?>&date=<?php echo $date?>';
<?php if($selected_user_param) { ?>
                baseUrl += '&selected_user=<?php echo urlencode($selected_user_param); ?>';
<?php } ?>
                location.href = baseUrl + '&index=' + index;
	})
	
	
	//$(".write2_table").resizableColumns();
})


</script>
<script>

//파일배열
var filesTempArr = [];

//파일 업로드 처리
function file_upload() {
	var formData = new FormData();
	
	for(var i=0, filesTempArrLen = filesTempArr.length; i<filesTempArrLen; i++) {
	   formData.append("files[]", filesTempArr[i]);
	}
	
	
	formData.append("uid", "<?php echo $seq?><?php echo str_replace($date)?>"); //유니크ID
	
	formData.append("bo_table", "est_<?php echo $index?>"); 
	formData.append("date", "<?php echo $date?>"); 
	
	$('#file_upload_btn').html('업로드 처리중..');
	
	$.ajax({
		type : "POST",
		url : "/_ajax/file_upload_est.php",
		data : formData,
		processData: false,
		contentType: false,
		success : function(data) {
			//파일업로드 완료 처리 로직
			if(data == "no") {
				alert('업로드에 실패하였습니다.\n파일이 없거나 업로드가 불가능한 확장자 또는 용량입니다.');
			} else {
				$('#userfile').val('');
				//다시 빈배열로
				filesTempArr = [];
				file_list(); // 업로드 된 파일목록 리스팅
			}

			$('#file_upload_btn').html('업로드');			
		},
		err : function(err) {
			alert(err.status);
		}
	});

	
}

// 파일을 배열에 추가
function addFiles(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var filesArrLen = filesArr.length;
    var filesTempArrLen = filesTempArr.length;
    for( var i=0; i<filesArrLen; i++ ) {
        filesTempArr.push(filesArr[i]);
        //$("#fileList").append("<div>" + filesArr[i].name + "<img src=\"/images/deleteImage.png\" onclick=\"deleteFile(event, " + (filesTempArrLen+i)+ ");\"></div>");
    }
	$('#userfile').val(filesArrLen+'개 파일 첨부됨');
	
    $(this).val('');
}

//파일첨부시 파일추가 함수 실행.
$("#fileInput").on('change', addFiles);
	
//업로드 파일목록
function file_list() {
	
	
	var id = "<?php echo $seq?><?php echo str_replace($date)?>";

	
	$.post('/_ajax/file_listup_est.php', { id : id, w : '<?php echo $w?>', date : "<?php echo $date?>", bo_table  : "est_<?php echo $index?>" }, function(data) {
		$('#file_list').html(data);
	});
	
}

file_list();

//파일삭제 
function file_del(seq) {
	
	if(confirm('정말 삭제하시겠습니까?\n삭제 된 파일은 복구가 불가능합니다.')) {
		location.href = '/_ajax/file_delete_est.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
</script>

<script src="./include/js/es_<?php echo $index?>.js?ver=220523"></script>