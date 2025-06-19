<?php 
$sql = "select * from {$none['est_noim']} where ne_date <= '{$date}'  and nw_code = '{$work['nw_code']}' and ne_type = 2";
$rst = sql_query($sql);

$chk = sql_fetch($sql);

if($chk)
	$mode = 'u';
else 
	$mode = '';



?>

<table border="1" >
		
		<col class="col0" style="width:50px">
        <col class="col1" style="width:150px">
        <col class="col2" style="width:100px">
        <col class="col3" style="width:150px">
        <col class="col5" style="width:200px">
        <col class="col5" style="width:200px">
        <col class="col5" style="width:120px">
        <col class="col5" style="width:200px">
       
        
          <tr class="row0" style="background:#f2f2f2">
            <td class="column0 style181 s style181" rowspan="2">구분</td>
            <td class="column1 style181 s style181" rowspan="2">업체명</td>
            <td class="column2 style181 s style181" rowspan="2">대표자명</td>
            <td class="column3 style181 s style181" rowspan="2">사업자등록번호</td>
            <td class="column5 style181 s style181" colspan="2" style="width:450px">주        소</td>
            <td class="column7 style181 s style181" colspan="3">결제정보</td>
            
          </tr>
          <tr class="row1" style="background:#f2f2f2">
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
			
			$file = sql_fetch("select * from none_est_noim_file where noim_seq = '{$row['seq']}' and ne_date = '{$date}'");
		?>
         <tr class="row2">
            <td class="column0 style181 n style181" rowspan="2"><?php echo ($i+1)?></td>
            <td class="column1 style181 null style181" rowspan="2">
			
			<?php echo $row['ne_name']?></td>
            <td class="column2 style181 null style181" rowspan="2"><?php echo $row['ne_gongjong']?></td>
            <td class="column3 style181 null style181" rowspan="2"><?php echo $row['ne_num']?></td>
            <td class="column5 style182 null style182" rowspan="2"><?php echo $row['ne_addr1']?></td>
            <td class="column6 style183 null style182" rowspan="2"><?php echo $row['ne_addr2']?></td>
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
            <td class="column3 style181 null style181" rowspan="2"></td>
           
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
		  
		