<?php 
$sql = "select * from {$none['est_noim']} where ne_date <= '{$date}' and nw_code = '{$work['nw_code']}' and ne_type = 1";
$rst = sql_query($sql);

$chk = sql_fetch($sql);

if($chk)
	$mode = 'u';
else 
	$mode = '';
?>

<table border="1" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width:120%">
       
        <col class="col0" style="width:50px">
        <col class="col1" style="width:70px">
        <col class="col2" style="width:100px">
        <col class="col3" style="width:150px">
        <col class="col4" style="width:70px">
        <col class="col5" style="width:70px">
        <col class="col5" style="width:200px">
        <col class="col5" style="width:200px">
        <col class="col5" style="width:120px">
        <col class="col5" style="width:200px">
        <col class="col5" style="width:100px">
		
          <tr class="row0" style="background:#f2f2f2">
            <td class="column0 style181 s style181" rowspan="2">구분</td>
            <td class="column1 style181 s style181" rowspan="2">성    명</td>
            <td class="column2 style181 s style181" rowspan="2">공종</td>
            <td class="column2 style181 s style181" rowspan="2">휴대폰번호</td>
            <td class="column3 style181 s style181" colspan="2" style="width:120px">주민등록번호</td>
            <td class="column5 style181 s style181" colspan="2" style="width:450px">주        소</td>
            <td class="column7 style181 s style181" colspan="3">결제정보</td>
            
          </tr>
          <tr class="row1" style="background:#f2f2f2">
            <td class="column3 style191 s">앞</td>
            <td class="column4 style191 s">뒤</td>
            <td class="column5 style191 s">도로명 주소 또는 동까지</td>
            <td class="column6 style191 s">상세주소</td>
            <td class="column7 style191 s">은행명</td>
            <td class="column8 style191 s">계좌번호</td>
            <td class="column9 style191 s">예금주</td>
            
          </tr>
		   <tbody id="rowbody">
		  <?php 
		  if($chk) {
		  
		  for($i=0; $row=sql_fetch_array($rst); $i++) {
			  
			  $jumin = explode('-', $row['ne_num']);
			 ?>
          <tr class="row2">
            <td class="column0 style181 n style181" rowspan="2" align="center"><?php echo ($i+1)?></td>
            <td class="column1 style181 null style181" rowspan="2">
			
			<?php echo $row['ne_name']?></td>
            <td class="column2 style181 null style181" rowspan="2"><?php echo $row['ne_gongjong']?></td>
			 <td class="column4 style181 null style181" rowspan="2"><?php echo $row['ne_hp']?></td>
            <td class="column3 style181 null style181" rowspan="2" align="center"><?php echo $jumin[0]?></td>
            <td class="column4 style181 null style181" rowspan="2" align="center"><?php echo $jumin[1]?></td>
           
            <td class="column5 style182 null style182" rowspan="2"><?php echo $row['ne_addr1']?></td>
            <td class="column6 style183 null style182" rowspan="2"> <?php echo $row['ne_addr2']?></td>
            <td class="column7 style181 null style181" rowspan="2"><?php echo $row['ne_bank']?></td>
            <td class="column8 style181 null style181" rowspan="2"><?php echo $row['ne_account']?></td>
            <td class="column9 style181 null style181" rowspan="2"><?php echo $row['ne_holder']?></td>
         
			
			
            
          </tr>
		  <tr class="row3">
            
          </tr>
          <?php } 
		  
		  } else {
			  
			  for($i=1; $i<=10; $i++) {
		  ?>
		  <tr class="row2">
            <td class="column0 style181 n style181" rowspan="2"><?php echo $i?></td>
            <td class="column1 style181 null style181" rowspan="2"></td>
            <td class="column2 style181 null style181" rowspan="2"></td>
			<td class="column4 style181 null style181" rowspan="2"></td>
            <td class="column3 style181 null style181" rowspan="2"></td>
            <td class="column4 style181 null style181" rowspan="2"></td>
            
            <td class="column5 style182 null style182" rowspan="2"></td>
            <td class="column6 style183 null style182" rowspan="2"></td>
            <td class="column7 style181 null style181" rowspan="2"></td>
            <td class="column8 style181 null style181" rowspan="2"></td>
            <td class="column9 style181 null style181" rowspan="2"></td>
           
          </tr>
          <tr class="row3">
            
          </tr>
		  
		  <?php }
		  
		  
		  }?>
		  
		  </table>
	