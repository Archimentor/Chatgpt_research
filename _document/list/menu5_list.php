<?php 
include_once('../../_common.php');
define('menu_document', true);
include_once(NONE_PATH.'/header.php'); 

if(!$_GET['date'])
	$date = date('Y');
?>
<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>문서관리</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">문서관리</li>
				<li class="breadcrumb-item active">사내자료실</li>
			</ul>
		</div>            
	   
	</div>
</div>
 <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
					<?php
					//wr_id값이 있으면 읽기모드 					
					if($wr_id) {
						$src = '/core/bbs/board.php?bo_table=pds&wr_id='.$wr_id;
					} else {
						$src = '/core/bbs/board.php?bo_table=pds';
					}
					?>
                    <div class="card">
						<iframe width="100%" height="100%" src="<?php echo $src?>" frameborder='1'  id="iframe_test" style="border:0;padding:10px;min-height:700px" onload="calcHeight();"></iframe>
 

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
<script type="text/javascript"> function calcHeight() { var the_height = document.getElementById('iframe').contentWindow. document.body.scrollHeight; document.getElementById('iframe').height = the_height; document.getElementById('iframe').style.overflow = "hidden"; } </script>

<?php include_once(NONE_PATH.'/footer.php');?>
