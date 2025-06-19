<?php 
$sql = "select * from {$none['est_noim']} where ne_date <= '{$date}' and nw_code = '{$work['nw_code']}' and ne_type = 1";
$rst = sql_query($sql);

$chk = sql_fetch($sql);

if($chk)
	$mode = 'u';
else 
	$mode = '';
?>
<form name="frm" id="frm" action="./update/inc/menu3_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="<?php echo $mode?>">
<input type="hidden" name="nw_code" value="<?php echo $work['nw_code']?>">
<input type="hidden" name="ne_date" value="<?php echo $date?>">
<div class="print_frm" style="overflow-x:scroll">
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width:120%">
       
       
          <tr class="row0">
            <td class="column0 style181 s style181" rowspan="2">구분</td>
            <td class="column1 style181 s style181" rowspan="2">성    명</td>
            <td class="column2 style181 s style181" rowspan="2">공종</td>
            <td class="column2 style181 s style181" rowspan="2">휴대폰번호</td>
            <td class="column3 style181 s style181" colspan="2" style="width:120px">주민등록번호</td>
            <td class="column5 style181 s style181" colspan="2" style="width:450px">주        소</td>
            <td class="column7 style181 s style181" colspan="3">결제정보</td>
            <td class="column10 style181 s style181 print_none" colspan="3" style="width:450px">업로드</td>
            
          </tr>
          <tr class="row1">
            <td class="column3 style191 s">앞</td>
            <td class="column4 style191 s">뒤</td>
            <td class="column5 style191 s">도로명 주소 또는 동까지</td>
            <td class="column6 style191 s">상세주소</td>
            <td class="column7 style191 s">은행명</td>
            <td class="column8 style191 s">계좌번호</td>
            <td class="column9 style191 s">예금주</td>
            <td class="column9 style191 s print_none">신분증</td>
            <td class="column9 style191 s print_none">통장사본</td>
            <td class="column9 style191 s print_none">기타</td>
            
          </tr>
		   <tbody id="rowbody">
		  <?php 
		  if($chk) {
		  
		  for($i=0; $row=sql_fetch_array($rst); $i++) {
			  
			  $jumin = explode('-', $row['ne_num']);
			 ?>
          <tr class="row2">
            <td class="column0 style181 n style181" rowspan="2"><?php echo ($i+1)?></td>
            <td class="column1 style181 null style181" rowspan="2">
			<input type="hidden" name="seq[]" value="<?php echo $row['seq']?>" >
			<input type="text" name="name[]" value="<?php echo $row['ne_name']?>" class="input" ></td>
            <td class="column2 style181 null style181" rowspan="2"><input type="text" name="gongjong[]" value="<?php echo $row['ne_gongjong']?>" class="input"></td>
			 <td class="column4 style181 null style181" rowspan="2"><input type="text" name="hp[]" value="<?php echo $row['ne_hp']?>" class="input"></td>
            <td class="column3 style181 null style181" rowspan="2"><input type="text" name="jumin1[]" value="<?php echo $jumin[0]?>" class="input" style="width:70px"></td>
            <td class="column4 style181 null style181" rowspan="2"><input type="text" name="jumin2[]" value="<?php echo $jumin[1]?>" class="input"  style="width:70px"></td>
           
            <td class="column5 style182 null style182" rowspan="2"><input type="text" name="addr1[]" value="<?php echo $row['ne_addr1']?>" class="input"></td>
            <td class="column6 style183 null style182" rowspan="2"><input type="text" name="addr2[]" value="<?php echo $row['ne_addr2']?>" class="input"></td>
            <td class="column7 style181 null style181" rowspan="2"><input type="text" name="bank[]" value="<?php echo $row['ne_bank']?>" class="input"></td>
            <td class="column8 style181 null style181" rowspan="2"><input type="text" name="account[]" value="<?php echo $row['ne_account']?>" class="input"></td>
            <td class="column9 style181 null style181" rowspan="2"><input type="text" name="accname[]" value="<?php echo $row['ne_holder']?>" class="input"></td>
            <td class="column10 style181 null style181 print_none" rowspan="2">
			
			<?php if($row['ne_file1']) {?>
			<a href="<?php echo NONE_URL?>/_data/noim/<?php echo $row['nw_code']?>/<?php echo $row['ne_file1']?>" target="_blank"  title="다운로드"><span class="glyphicon fa fa-download"></span></a>
			<?php } else {?>
			<span class="glyphicon fa fa-download" style="color:grey"  title="첨부파일 없음"></span>
			<?php }?>
			<input type="file" name="file1[]" style="width:70px">
			</td>
            <td class="column10 style181 null style181 print_none" rowspan="2">
			<?php if($row['ne_file2']) {?>
			<a href="<?php echo NONE_URL?>/_data/noim/<?php echo $row['nw_code']?>/<?php echo $row['ne_file2']?>" target="_blank" title="다운로드"><span class="glyphicon fa fa-download"></span></a>
			<?php } else {?>
			<span class="glyphicon fa fa-download" style="color:grey"title="첨부파일 없음"></span>
			<?php }?>
			
			<input type="file" name="file2[]" style="width:70px"></td>
            <td class="column10 style181 null style181 print_none" rowspan="2">
			<?php if($row['ne_file3']) {?>
			<a href="<?php echo NONE_URL?>/_data/noim/<?php echo $row['nw_code']?>/<?php echo $row['ne_file3']?>" target="_blank" title="다운로드"><span class="glyphicon fa fa-download"></span></a>
			<?php } else {?>
			<span class="glyphicon fa fa-download" style="color:grey" title="첨부파일 없음"></span>
			<?php }?>
			
			
			<input type="file" name="file3[]" style="width:70px"></td>
            
          </tr>
		  <tr class="row3">
            
          </tr>
          <?php } 
		  
		  } else {
			  
			  for($i=1; $i<=10; $i++) {
		  ?>
		  <tr class="row2">
            <td class="column0 style181 n style181" rowspan="2"><?php echo $i?></td>
            <td class="column1 style181 null style181" rowspan="2"><input type="text" name="name[]" value="" class="input"></td>
            <td class="column2 style181 null style181" rowspan="2"><input type="text" name="gongjong[]" value="" class="input"></td>
			<td class="column4 style181 null style181" rowspan="2"><input type="text" name="hp[]" value="" class="input"></td>
            <td class="column3 style181 null style181" rowspan="2"><input type="text" name="jumin1[]" value="" class="input"></td>
            <td class="column4 style181 null style181" rowspan="2"><input type="text" name="jumin2[]" value="" class="input"></td>
            
            <td class="column5 style182 null style182" rowspan="2"><input type="text" name="addr1[]" value="" class="input"></td>
            <td class="column6 style183 null style182" rowspan="2"><input type="text" name="addr2[]" value="" class="input"></td>
            <td class="column7 style181 null style181" rowspan="2"><input type="text" name="bank[]" value="" class="input"></td>
            <td class="column8 style181 null style181" rowspan="2"><input type="text" name="account[]" value="" class="input"></td>
            <td class="column9 style181 null style181" rowspan="2"><input type="text" name="accname[]" value="" class="input"></td>
            <td class="column10 style181 null style181 print_none" rowspan="2"><input type="file" name="file1[]" style="width:70px"></td>
            <td class="column10 style181 null style181 print_none" rowspan="2"><input type="file" name="file2[]" style="width:70px"></td>
            <td class="column10 style181 null style181 print_none" rowspan="2"><input type="file" name="file3[]" style="width:70px"></td>
            
          </tr>
          <tr class="row3">
            
          </tr>
		  
		  <?php }
		  
		  
		  }?>
		  
		  </table>
		  </div>
		<div class="modal-footer">
			<button type="button" class="btn btn-success" onclick="onExcel()"><span class="glyphicon fa fa-file-excel-o"></span> 엑셀출력</button>
			<button type="button" class="btn btn-secondary" onclick="onPrint4()"  data-dismiss="modal">인쇄</button>
			<button type="button" class="btn btn-secondary" onclick="add()" data-dismiss="modal">칸추가</button>
			<button type="submit" class="btn btn-primary"data-dismiss="modal">저장</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal">목록</button>
		</div>
		</form>
		<script>
		function add() {
			
			var s = $('#rowbody').find('.row2').length + 1;
			var html = "";
			html += '<tr class="row2">';
            html += '<td class="column0 style181 n style181" rowspan="2">'+s+'</td>';
			html += ' <td class="column1 style181 null style181" rowspan="2"><input type="text" name="name[]" value="" class="input"></td>';
            html += '<td class="column2 style181 null style181" rowspan="2"><input type="text" name="gongjong[]" value="" class="input"></td>';
            html += '<td class="column3 style181 null style181" rowspan="2"><input type="text" name="hp[]" value="" class="input"></td>';
            html += '<td class="column3 style181 null style181" rowspan="2"><input type="text" name="jumin1[]" value="" class="input"></td>';
            html += '<td class="column4 style181 null style181" rowspan="2"><input type="text" name="jumin2[]" value="" class="input"></td>';
            html += '<td class="column5 style182 null style182" rowspan="2"><input type="text" name="addr1[]" value="" class="input"></td>';
            html += '<td class="column6 style183 null style182" rowspan="2"><input type="text" name="addr2[]" value="" class="input"></td>';
            html += '<td class="column7 style181 null style181" rowspan="2"><input type="text" name="bank[]" value="" class="input"></td>';
            html += '<td class="column8 style181 null style181" rowspan="2"><input type="text" name="account[]" value="" class="input"></td>';
            html += '<td class="column9 style181 null style181" rowspan="2"><input type="text" name="accname[]" value="" class="input"></td>';
            html += '<td class="column10 style181 null style181" rowspan="2"><input type="file" name="file1[]" style="width:70px"></td>';
            html += '<td class="column10 style181 null style181" rowspan="2"><input type="file" name="file2[]" style="width:70px"></td>';
            html += '<td class="column10 style181 null style181" rowspan="2"><input type="file" name="file3[]" style="width:70px"></td>';
            
			html += '</tr>';
			html += '<tr class="row3"></tr>';
			
			 $('#rowbody').append(html);
			
		}
		</script>