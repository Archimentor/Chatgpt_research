<?php if(!defined('menu_establishment')) exit;?>
<table style="width:100%;border-bottom:1px solid #ddd">
<tr >
<td style="background:#f2f2f2;border-top:1px solid #ccc" class="font-weight-bold text-center">첨부파일</td>
<td style="border-top:1px solid #ccc;padding:15px" >

<div class="form-row ">
	<div class="col-auto">
		<div class="form-group ">
			<input id="fileInput" type="file" data-class-button="btn btn-default" data-class-input="form-control" data-button-text="" data-icon-name="fa fa-upload" class="form-control" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" name="files[]" multiple >
		
			<input type="text" id="userfile" class="form-control" name="userfile" disabled="">
		</div>
	
	</div>
	<div class="col-auto">
		<span class="group-span-filestyle input-group-btn" tabindex="0">
			<label for="fileInput" class="btn btn-default">
				<span class="glyphicon fa fa-upload"></span>
				찾기
			</label>
		</span>
		
	</div>
	<div class="col-auto">
	  <button type="button" id="file_upload_btn" onclick="file_upload()" class="btn btn-primary mb-2">업로드</button>
	</div>
	
	<?php if($index == 19) {?>
	<div class="col-auto" style="margin-left:30px">
	  <button type="button"class="btn btn-info mb-2" onclick="location.href='./ajax.inc11.status.php?step=1&code=<?php echo $work['nw_code']?>&date=<?php echo $date?>'">작성확인 (현장)</button>
	  <button type="button"class="btn btn-success mb-2" onclick="location.href='./ajax.inc11.status.php?step=2&code=<?php echo $work['nw_code']?>&date=<?php echo $date?>'">작성확인 (본사)</button>
	</div>
	<?php }?>
</div>
<div class="form-row ">
	<table  class="table table-striped" >
	  <thead>
		<tr>
		  
		  <th scope="col">파일명</th>
		  <th scope="col">용량</th>
		  <th scope="col">다운</th>
		  <th scope="col">관리</th>
		</tr>
	  </thead>
	  <tbody id="file_list">
		<tr>
		  <td colspan="4">등록 된 첨부파일이 없습니다.</th>
		  
		</tr>
		
	  </tbody>
	</table>
</div>
</td>
</tr>
</table>