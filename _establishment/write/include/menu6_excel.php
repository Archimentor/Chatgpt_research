<?php 
$chk = sql_fetch("select * from {$none['est_imprest']} where  nw_code = '{$work['nw_code']}' and ne_date = '$date'");

//이전달 전도금잔금
$prev_date = date('Y-m', strtotime($date." -1 month"));
$prev = sql_fetch("select ne_balance from {$none['est_imprest']} where  nw_code = '{$work['nw_code']}' and ne_date = '$prev_date'");

?>

<table border="1" style="width:100%">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
       
          <tr class="row0">
            <td class="column0 style42 s style42" colspan="8" style="font-size:20px">(<?php echo date('m', strtotime($date))?>월) 전도금 정산서</td>
          </tr>
          <tr class="row1">
            <td class="column0 style41 s"colspan="7">현장명: <?php echo $work['nw_subject']?></td>
            <td class="column1 style43 f style43" ></td>
          </tr>
          <tr class="row2">
            <td class="column0 style39 s style39" rowspan="2">일  자</td>
            <td class="column1 style39 s style39" rowspan="2">거래처</td>
            <td class="column2 style39 s style39" rowspan="2">적  요</td>
            <td class="column3 style39 s style39" rowspan="2">전도금 사용자</td>
            <td class="column4 style40 s style40" colspan="3">사  용  금  액</td>
            <td class="column7 style38 s style38" rowspan="2">비  고</td>
          </tr>
          <tr class="row3">
            <td class="column4 style33 s">개인사용</td>
            <td class="column5 style33 s">법인사용</td>
            <td class="column6 style10 s">합  계</td>
          </tr>
		   <tbody id="rowbody">
		   
		   <?php if(!$chk) {
			   
			   for($i=0; $i<=10; $i++) {
			   
			?>
          <tr class="row4" >
            <td class="column0 style34 null"></td>
            <td class="column1 style24 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style24 null"></td>
            <td class="column4 style23 null"></td>
            <td class="column5 style37 null"></td>
            <td class="column6 style10 null"></td>
            <td class="column7 style32 null"></td>
          </tr>
		   <?php 
			   }
		   
		   } else {
			$sql = "select * from {$none['est_imprest']} where  nw_code = '{$work['nw_code']}' and ne_date = '$date' order by ne_trade_date asc";
			$rst = sql_query($sql);
			for($i=0; $row=sql_fetch_array($rst); $i++) {
			   
			?>
		   <tr class="row4" >
            <td class="column0 style34 null">
			<?php echo $row['ne_trade_date']?> </td>
            <td class="column1 style24 null"><?php echo $row['ne_account_name']?> </td>
            <td class="column2 style24 null"><?php echo $row['ne_summary']?></td>
            <td class="column3 style24 null"><?php echo $row['ne_user']?></td>
            <td class="column4 style23 null"><?php echo number_format($row['ne_cash'])?></td>
            <td class="column5 style37 null"><?php echo number_format($row['ne_card'])?></td>
            <td class="column6 style10 null"><?php echo number_format($row['ne_total'])?></td>
            <td class="column7 style32 null"><?php echo $row['ne_etc']?></td>
          </tr>
		   
		   <?php 
				$cash_total += $row['ne_cash'];
				$card_total += $row['ne_card'];
				$all_total += $row['ne_total'];
		   
				}
		   
		   }?>
          </tbody>
		  <tfoot>
		  
          <tr class="row39">
            <td class="column0 style6 s">합  계</td>
            <td class="column1 style8 null"></td>
            <td class="column2 style8 null"></td>
            <td class="column3 style8 null"></td>
            <td class="column4 style7 f cash_total"><?php echo number_format($cash_total)?></td>
            <td class="column5 style7 f card_total"><?php echo number_format($card_total)?></td>
            <td class="column6 style7 f all_total"><?php echo number_format($all_total)?></td>
            <td class="column7 style2 null"></td>
          </tr>
          <tr class="row40">
            <td class="column0 style6 s">전월잔액</td>
            <td class="column1  f style3" colspan="6" style="background:#fff"><?php echo number_format($prev['ne_balance'])?></td>
            <td class="column7 style2 null"></td>
          </tr>
          <tr class="row40">
            <td class="column0 style6 s">금월입금</td>
            <td class="column1  f style3" colspan="6" style="background:#fff"><?php echo number_format($chk['ne_deposit'])?></td>
            <td class="column7 style2 null"></td>
          </tr>

          <tr class="row40">
            <td class="column0 style6 s">금월지출</td>
            <td class="column1  f style3" colspan="6" style="background:#fff"><?php echo number_format($chk['ne_expenses'])?></td>
            <td class="column7 style2 null"></td>
          </tr>

          <tr class="row40">
            <td class="column0 style6 s">전도금 잔액</td>
            <td class="column1  f style3" colspan="6" style="background:#fff"><?php echo number_format($chk['ne_balance'])?></td>
            <td class="column7 style2 null"></td>
          </tr>

        </tfoot>
    </table>

	
	